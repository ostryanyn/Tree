<?php
error_reporting(E_ALL);
?>
<?php
$db = new SQLite3('../db/tree.db');

//load data from db, save as nottree
$nottree = array();

$results = $db->query('SELECT * FROM branches');
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
	array_push($nottree, $row);
}

//function to build hierarchy from nottree
function grow(&$branch, $nottree) {
	$twigs = array_keys(array_column($nottree, 'parent_id'), $branch['id']);
	$branch['branch'] = array();
	foreach( $twigs as $id ) {
		$twig = $nottree[$id];
		grow($twig, $nottree);
		array_push($branch['branch'], $twig);
	}
		
}

//create treeroot
$tree = array();
$tree['id'] = 0;
$tree['name'] = 'treeroot (read-only)';

//grow tree
grow($tree, $nottree);

echo '['.json_encode($tree).']';
?>

