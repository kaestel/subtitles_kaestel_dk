<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");

$action = $page->actions();

$project = $action[0];


$page->bodyClass("workspace");
$page->pageTitle("Subtitle workspace");

$page->header(); ?>

<div class="scene workspace">

	<h1>Subtitle workspace</h1>
	<h2><?= $project ?></h2>
	<p>Pick your subtitle tool</p>
	
	<h3>Tools</h3>
	<ul>
		<li><a href="/translation/<?= $project ?>">Translation</a></li>
		<li><a href="/adjustment/<?= $project ?>">Adjustment</a></li>
	</ul>
</div>

<? $page->footer(); ?>
