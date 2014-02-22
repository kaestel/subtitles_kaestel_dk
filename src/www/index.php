<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");

$action = $page->actions();


$page->bodyClass("front");
$page->pageTitle("Subtitles");

$page->header(); 

// load subtitle
$subtitle_file = file_get_contents(PRIVATE_FILE_PATH."/more_than_honey.srt");

// find delimiter (theoretically could be different)
$subtitle_delimiter = preg_match("/1([\s]+)/", $subtitle_file, $matches);

if($subtitle_delimiter):
	$subtitles = explode($matches[1].$matches[1], $subtitle_file); ?>


	<h1>Subtitle adjustment and translation</h1>
	<div class="header">
		<span class="index">#</span>
		<span class="start">Start</span>
		<span class="end">End</span>
		<span class="subtitle">Subtitle</span>
		<span class="translation">
			<select name="language">
				<option value="en">English</option>
				<option value="da">Danish</option>
			</select>
		</span>
	</div>
<?
	// find grouping delimiter


	foreach($subtitles as $i => $section):
		preg_match("/([\d]+)[\s]+([\d:,]+)[\s->]+([\d:,]+)[\s]+([^$]+)/", $section, $matches);
//		print_r($matches);


		if(count($matches) == 5): ?>
			
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
				<textarea name="translation[<?= $i ?>]"><?= $matches[4] ?></textarea>
			</span>
		</div>
		
<?		else: ?>

		<p class="broken"><? print_r($section) ?></p>
		
<?		endif; ?>

<?	endforeach; ?>

<? endif; ?>


<?
$page->footer();
?>
