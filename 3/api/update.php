<?php
error_reporting(E_ALL);
?>
<?php
include 'functions.php';

$db = new SQLite3('../db/tree.db');

//update name of the branch
if( isSetAndNotEmpty($_GET['branch_id'])
	&& isSetAndNotEmpty($_GET['new_name']) ) {

	$branch_id = $_GET['branch_id'];
	$new_name = $_GET['new_name'];

	$stmt = $db->prepare('UPDATE branches SET name = :new_name WHERE id = :branch_id');
	$stmt->bindValue(':new_name', $new_name, SQLITE3_TEXT);
	$stmt->bindValue(':branch_id', $branch_id, SQLITE3_INTEGER);

	$result = $stmt->execute();

	if(!$result)
		die('{"error":true}');
	else
		echo '{"error":false}';
}
//update parent of the branch
else if( isSetAndNotEmpty($_GET['branch_id'])
		&& isSetAndNotEmpty($_GET['new_parent_id']) ) {

	$branch_id = $_GET['branch_id'];
	$new_parent_id = $_GET['new_parent_id'];

	$stmt = $db->prepare('UPDATE branches SET parent_id = :new_parent_id WHERE id = :branch_id');
	$stmt->bindValue(':new_parent_id', $new_parent_id, SQLITE3_INTEGER);
	$stmt->bindValue(':branch_id', $branch_id, SQLITE3_INTEGER);

	$result = $stmt->execute();

	if(!$result)
		die('{"error":true}');
	else
		echo '{"error":false}';
}
else
	die('{"error":true}');

?>


