<?php
error_reporting(E_ALL);
?>
<?php
include 'functions.php';

$db = new SQLite3('../db/tree.db');

if( isSetAndNotEmpty($_GET['branch_name'])
	&& isSetAndNotEmpty($_GET['parent_id']) ) {

	$branch_name = $_GET['branch_name'];
	$parent_id = $_GET['parent_id'];
}
else
	die('{"error":true}');

$stmt = $db->prepare('INSERT INTO branches(name, parent_id) VALUES(:name, :parent_id)');
$stmt->bindValue(':name', $branch_name, SQLITE3_TEXT);
$stmt->bindValue(':parent_id', $parent_id, SQLITE3_INTEGER);

$result = $stmt->execute();

if(!$result)
	die('{"error":true}');

$last_id = $db->lastInsertRowID();
echo '{"error":false,"last_id":'.$last_id.'}';
?>


