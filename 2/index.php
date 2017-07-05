<?php
/*Напишите php скрипт который будет запускаться из консоли.
Команда php нашскрипт.php http://где.то/там/ выводит все
ссылки (href атрибуты тега <a>), которые есть на странице http://где.то/там/.
Url должны преобразовываться к абсолютной форме, дубликатов быть не должно.*/

error_reporting(E_ALL);

//parse and validate command parameters

if(count($argv) !== 2) {
	print "Usage: php ".$argv[0]." <url>\n";
	return -1;
}

$url_pattern =
	"/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";

if( !preg_match($url_pattern, $argv[1]) ) {
	print "Error: ".$argv[1]." is not a URL\n";
	return -1;
}
else $url = $argv[1];


//get page, and parse urls

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$page = curl_exec($ch);

$url_matches = [];

if( !preg_match_all($url_pattern, $page, $url_matches) ) {
	echo "No url found!\n";
	return 0;
}
else {
	$result = array_unique($url_matches[0]);
	sort($result, SORT_STRING);
	echo join("\n", $result)."\n";
}

curl_close($ch);
?>
