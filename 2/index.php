<?php
/*Напишите php скрипт который будет запускаться из консоли.
Команда php нашскрипт.php http://где.то/там/ выводит все
ссылки (href атрибуты тега <a>), которые есть на странице http://где.то/там/.
Url должны преобразовываться к абсолютной форме, дубликатов быть не должно.*/

error_reporting(E_ALL);

function urlToAbsolute(&$url, $key, $base) {

	$url = preg_replace("/^\\/(?=[^\\/])/", $base, $url);
	// url like "/" becomes base
	$url = preg_replace("/^\\/$/", $base, $url);

	$url = preg_replace("/^\\/\\//", "http://", $url);
}

//parse and validate command parameters

if(count($argv) !== 2) {
	print "Usage: php ".$argv[0]." <url>\n";
	return -1;
}

$url_pattern =
	"/\b(?:(?:https?|ftp):\/\/|www\.|)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";

if( !preg_match($url_pattern, $argv[1]) ) {
	print "Error: ".$argv[1]." is not a URL\n";
	return -1;
}
else $url = $argv[1];


//get page

$ch = curl_init();
//enable http headers in output
curl_setopt($ch, CURLOPT_HEADER, TRUE);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$page = curl_exec($ch);
curl_close($ch);

//parse location from headers (in case of redirects)
$location = "";
$location_pattern = "/Location: (.+)$/mi";
$location_match = [];
if( preg_match($location_pattern, $page, $location_match) )
	$location = $location_match[1];
else
	$location = $url;

//parse <base> from page (in case of it exists)
$base = "";
$base_pattern = "/<base.+?href=\"(.+?)\"/mi";
$base_match = [];
if( preg_match($base_pattern, $page, $base_match) )
	$base = $base_match[1];
else
	$base = $location;

$base = preg_replace("/[\r\n]/", "", $base);

//parse hrefs
$href_matches = [];
$url_pattern =
	"[-a-z0-9+&@\/%?=~_|!:,.;][-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]";
$href_pattern = "/href=\"(".$url_pattern.")\"/mi";

if( !preg_match_all($href_pattern, $page, $href_matches) ) {
	echo "No links found!\n";
	return 0;
}
else {
	$result = $href_matches[1];
	
	//transform to absolute path
	array_walk($result, "urlToAbsolute", $base);

	//filter unique
	$result = array_unique($result);

	sort($result, SORT_STRING);
	echo join("\n", $result)."\n";
}

?>
