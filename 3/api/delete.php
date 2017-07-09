<?php
error_reporting(E_ALL);
?>
<?php
include 'functions.php';

function recursiveDeleteChildren($id, $db) {
	
	$children = [];
	
	$stmt = $db->prepare('DELETE FROM branches WHERE id = :branch_id');
	$stmt->bindValue(':branch_id', $id, SQLITE3_INTEGER);
	$r = $stmt->execute();

	$stmt = $db->prepare('SELECT id FROM branches WHERE parent_id = :id');
	$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
	$r = $stmt->execute();
	while ($row = $r->fetchArray(SQLITE3_ASSOC)) {
		array_push($children, $row);
	}
	foreach($children as $child) {
		recursiveDeleteChildren($child['id'], $db);
	}
}

$db = new SQLite3('../db/tree.db');

if( isSetAndNotEmpty($_GET['branch_id']) )
	$branch_id = $_GET['branch_id'];
else
	die('{"error":true}');

recursiveDeleteChildren($branch_id, $db);
echo '{"error":false}';
?>

