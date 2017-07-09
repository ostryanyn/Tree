<?php
error_reporting(E_ALL);
?>
<?php
include 'functions.php';

$db = new SQLite3('../db/tree.db');

if( isSetAndNotEmpty($_GET['branch_id']) ) {

	$branch_id = $_GET['branch_id'];
}
else
	die('{"error":true}');

$stmt = $db->prepare('DELETE FROM branches WHERE id = :branch_id');
$stmt->bindValue(':branch_id', $branch_id, SQLITE3_INTEGER);

$result = $stmt->execute();

if(!$result)
	die('{"error":true}');

$last_id = $db->lastInsertRowID();
echo '{"error":false}';
?>

