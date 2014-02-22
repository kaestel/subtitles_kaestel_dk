<?php

$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");

$action = $page->actions();


function curl($url, $params = array(), $is_coockie_set = false) {
 
	if(!$is_coockie_set) {
		/* STEP 1. let’s create a cookie file */
		$ckfile = tempnam ("/tmp", "CURLCOOKIE");
 
		/* STEP 2. visit the homepage to set the cookie properly */
		$ch = curl_init ($url);
		curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec ($ch);
	}
 
	$str = '';
	$str_arr = array();
	foreach($params as $key => $value) {
		$str_arr[] = urlencode($key)."=".urlencode($value);
	}
	if(!empty($str_arr)) {
		$str = '?'.implode('&',$str_arr);
	
	}
 
	/* STEP 3. visit cookiepage.php */
 
	$Url = $url.$str;
 
	$ch = curl_init ($Url);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
 
	$output = curl_exec ($ch);
	return $output;
}

function translate($text, $from, $to) {

	$text = urlencode($text);
//	print $text."<br>";
//	$text = "My grand-grand father\nand my grandfather were keeping bees,";

//	$url = 'http://translate.google.com/translate_a/t?client=t&text='.$text.'&hl=en&sl='.$from.'&tl='.$to.'&ie=UTF-8&oe=UTF-8&multires=1&otf=2&pc=1&ssel=0&tsel=0&sc=1';
	$url = 'http://translate.google.com/translate_a/t?client=t&text='.$text.'&hl=en&sl='.$from.'&tl='.$to.'&ie=UTF-8&oe=UTF-8&multires=1';
	$translation_result = curl($url);

  
//	print_r($translation_result);
	$translation_result = str_replace("\\\"", "&quot;", $translation_result);
//	print_r($translation_result);

	$translation = explode('"', $translation_result);

	$translation_result = str_replace("&quot;", "\"", $translation_result);

	return preg_replace("/ \:/", ":", preg_replace("/ \./", ".", preg_replace("/ ,/", ",", $translation[1])));
}

if(count($action) == 2) {
	
	$text = stripslashes(getVar("text"));

}
else if(count($action) == 3) {
	
	$text = $action[2];

}
else {
	exit();
}

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>

<div id="original"><?= $text ?></div>
<div id="translation"><?= translate($text, $action[0], $action[1]) ?></div>

</body>
</html>