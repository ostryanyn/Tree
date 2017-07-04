<?php
/*Есть одномерный массив (размер произвольный) чисел больше 0.
Задача вывести все его элементы в 7 колонок, в таблице с border="1".
У пустых ячеек должна быть рамка.*/

error_reporting(E_ALL);

$numbers = array();
$numbersLength = rand(11,99);

//fill $numbers
for($i=0; $i<$numbersLength; $i++)
	array_push($numbers, rand(0, 99));

function renderArray($array, $columns) {

	$output = '';

	foreach($array as $key => $item) {
		$output .= '<td>'.$item.'</td>';
		if( ($key + 1) % $columns == 0) $output .= '</tr><tr>';
	}
	
	$output = '<tr>'.$output.'</tr>';
	$output = '<table>'.$output.'</table>';

	return $output;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Array</title>
		<style>
		table {table-layout: fixed; border-collapse: collapse;}
		table td {padding: 8px; border: 1px solid #777}
		</style>
	</head>
	<body>
		<?= renderArray($numbers, 7) ?>
	</body>
</html>
