<?php
error_reporting(E_ALL);
?>
<?php
$db = new SQLite3('../tree.db');

$tree = array();

$results = $db->query('SELECT * FROM branches');
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
	array_push($tree, json_encode($row));
}

$tree = '['.join($tree, ',').']';
echo $tree;
?>

