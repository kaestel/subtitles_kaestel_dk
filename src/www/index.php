<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");

$action = $page->actions();


$page->bodyClass("front");
$page->pageTitle("Subtitles");

$page->header(); ?>

<div class="scene front">
	<h1>Subtitle adjustment and translation tool</h1>
	<p>Add file to create new workspace, or pick existing project</p>

	<div class="upload">
		<label>Drag SRT-file here to add it to the workspace</label>
		<input type="file" name="subtitle" />
		<input type="submit" value="Upload" />
	</div>

	<h3>Existing projects</h3>
	<ul>
		<li><a href="/workspace/more_than_honey">More than honey</a></li>
	</ul>
</div>

<? $page->footer(); ?>
