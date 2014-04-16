<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");

$action = $page->actions();

$project = $action[0];
$org_file = PRIVATE_FILE_PATH."/".$project.".srt";
// workspace file
$temp_file = PRIVATE_FILE_PATH."/".$project.".temp";


$file = false;
$translation_file = false;
$original_language = false;
$translation_language = false;


// does temp file exist - it will contain additional progress info
if(file_exists($temp_file)) {

	$workspace_info = file($temp_file);


	// validate workspace info
	if(count($workspace_info) > 0) {

		// first line is languages
		$languages = explode(",", $workspace_info[0]);
		if($languages) {

			$original_language = $languages[0];
			if(file_exists($temp_file.".".$original_language)) {
				$file = $temp_file.".".$original_language;
			}

			$translation_language = $languages[1];
			if(file_exists($temp_file.".".$translation_language)) {
				$translation_file = $temp_file.".".$translation_language;
			}

		}
	}

}

if(!$file && file_exists($org_file)) {
	$file = $org_file;
}


$page->bodyClass("translation");
$page->pageTitle("Subtitle translation workspace");

$page->header();


?>

<div class="scene translation i:translation">
<? 

if($file):

	// load subtitle
	$subtitle_file = file_get_contents($file);
	$subtitle_delimiter = preg_match("/1([\s]+)/", $subtitle_file, $matches);


	// find delimiter (theoretically could be different)
	if($subtitle_delimiter):
		$subtitles = explode($matches[1].$matches[1], $subtitle_file); ?>

	<form name="subtitle_translation">
		<input type="hidden" name="workspace" id="project_name" value="<?= $project ?>" />

		<h1>Translation workspace</h1>
		<h2><?= $project ?></h2>

		<div class="header">
			<span class="index">#</span>
			<span class="start">Start</span>
			<span class="end">End</span>
			<span class="subtitle">
				<label>Original language</label>
				<select name="original_language">
					<!--option value="">Choose language</option-->
					<option value="en"<?= $original_language == "en" ? ' selected="selected"' : '' ?>>English</option>
					<!--option value="da"<?= $original_language == "da" ? ' selected="selected"' : '' ?>>Danish</option-->
				</select>
			</span>
			<span class="translation">
				<label>Translate to</label>
				<select name="translation_language">
					<!--option value="">Choose language</option-->
					<!--option value="en"<?= $translation_language == "en" ? ' selected="selected"' : '' ?>>English</option-->
					<option value="da"<?= $translation_language == "da" ? ' selected="selected"' : '' ?>>Danish</option>
				</select>
			</span>
		</div>
<?

		// translation file available
		if($translation_file) {
			$subtitle_translation_file = file_get_contents($translation_file);
			// print "fil2";
			// print_r($subtitle_translation_file);
			$translations = explode("\n\n", $subtitle_translation_file);
		}


		// loop through subtile file
		foreach($subtitles as $i => $section):
			// identify subtitle section groups
			preg_match("/([\d]+)[\s]+([\d:,]+)[\s->]+([\d:,]+)[\s]+([^$]+)/", $section, $matches);
//			print_r($matches);

			if(count($matches) == 5):

//				print mb_detect_encoding($matches[4], "ISO-8859-1,UTF-8");
//				if( == "ISO-8859-1") {

				$matches[4] = mb_convert_encoding($matches[4], "UTF-8", mb_detect_encoding($matches[4], "WINDOWS-1252,ISO-8859-1,UTF-8"));

//				}
				

?>
		
		<div class="section">
			<span class="index"><?= $matches[1] ?></span>
			<span class="start">
				<input type="text" name="start[<?= $i ?>]" value="<?= $matches[2] ?>" />
			</span>
			<span class="end">
				<input type="text" name="end[<?= $i ?>]" value="<?= $matches[3] ?>" />
			</span>
			<span class="subtitle">
				<textarea name="subtitle[<?= $i ?>]"><?= $matches[4] ?></textarea>
			</span>
			<span class="translation">
<?			if($translation_language && isset($translations[$i])): //count($translations) == count($subtitles)):
				preg_match("/([\d]+)[\s]+([\d:,]+)[\s->]+([\d:,]+)[\s]+([^$]+)/", $translations[$i], $translation_matches);
			endif; ?>
				<textarea name="translation[<?= $i ?>]"><?= isset($translation_matches[4]) ? $translation_matches[4] : "" ?></textarea>
			</span>
		</div>

<?			else: ?>
	<p class="broken"><? print_r($section) ?></p>
<?			endif; ?>
<?		endforeach; ?>
	</form>

<?	else: ?>
	<p>No valid linebreak indicator found - your project file may be corrupt</p>
<?	endif; ?>

<? else: ?>
		<p>Project not found</p>
<? endif; ?>

</div>

<? $page->footer(); ?>
