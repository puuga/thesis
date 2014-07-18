<?php
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json');

$result = array();
$result["mainTitle"] = "main title";

$pages = array();

// start page 1
$page = array();
$page["title"] = "title 1";
$page["question"] = "match item";

$content = array();
$option = array();
$option[] = "bird";
$option[] = "fish";
$option[] = "star";
$option[] = "sky walker";
$hold = array();
$hold[] = "sky";
$hold[] = "water";
$hold[] = "space";
$hold[] = "star war";

$content["option"] = $option;
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 1

// start page 2
$page = array();
$page["title"] = "title 2";
$page["question"] = "match item";

$content = array();
$option = array();
$option[] = "car";
$option[] = "ship";
$option[] = "line";
$option[] = "microsoft";
$hold = array();
$hold[] = "road";
$hold[] = "ocean";
$hold[] = "sticker";
$hold[] = "windows";

$content["option"] = $option;
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 2

$result["pages"] = $pages;
echo json_encode($result);
?>