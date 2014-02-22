<?php

$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");

$action = $page->actions();

// save project progress to temp files


$project_name = getPost("project_name");
$original_language = getPost("original_language");
$translation_language = getPost("translation_language");
$sections = getPost("sections");

$temp_file = PRIVATE_FILE_PATH."/".$project_name.".temp";

if($original_language && $translation_language && $original_language != $translation_language) {

	print $temp_file."<br>";
	file_put_contents($temp_file, $original_language.",".$translation_language);

	if($sections) {
//		print_r($sections);

		$sections = json_decode(stripslashes($sections));
		$original_subtitle = "";
		$translated_subtitle = "";

		$original_file = PRIVATE_FILE_PATH."/".$project_name.".temp.".$original_language;
		$translated_file = PRIVATE_FILE_PATH."/".$project_name.".temp.".$translation_language;

		foreach($sections as $index => $section) {
			$original_subtitle .= ($index+1) . "\n" . $section[0] . " --> " . $section[1] . "\n" . $section[2] . "\n\n";
			$translated_subtitle .= ($index+1) . "\n" . $section[0] . " --> " . $section[1] . "\n" . $section[3] . "\n\n";
		}

		file_put_contents($original_file, $original_subtitle);
		file_put_contents($translated_file, $translated_subtitle);
	}
	
}




?>