<?php
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json');

$result = array();
$result["mainTitle"] = "main title";

$pages = array();

// start page 1
$page = array();
$page["title"] = "Vehicle";
$page["question"] = "<img src='pics/ship.jpg' width='100'>";

$content = array();
$option = array();
$option[] = "S";
$option[] = "H";
$option[] = "I";
$option[] = "P";
$hold = array();
$hold[] = "";
$hold[] = "";
$hold[] = "";
$hold[] = "";

$content["option"] = $option;
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 1

// start page 2
$page = array();
$page["title"] = "Vehicle";
$page["question"] = "<img src='pics/bike.jpg' width='100'>";

$content = array();
$option = array();
$option[] = "B";
$option[] = "I";
$option[] = "K";
$option[] = "E";
$hold = array();
$hold[] = "";
$hold[] = "";
$hold[] = "";
$hold[] = "";

$content["option"] = $option;
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 2

// start page 3
$page = array();
$page["title"] = "Vehicle";
$page["question"] = "<img src='pics/taxi.jpg' width='100'>";

$content = array();
$option = array();
$option[] = "T";
$option[] = "A";
$option[] = "X";
$option[] = "I";
$hold = array();
$hold[] = "";
$hold[] = "";
$hold[] = "";
$hold[] = "";

$content["option"] = $option;
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 3

// start page 4
$page = array();
$page["title"] = "Vehicle";
$page["question"] = "<img src='pics/bicycle.jpg' width='100'>";

$content = array();
$option = array();
$option[] = "B";
$option[] = "I";
$option[] = "C";
$option[] = "Y";
$option[] = "C";
$option[] = "L";
$option[] = "E";
$hold = array();
$hold[] = "";
$hold[] = "";
$hold[] = "";
$hold[] = "";
$hold[] = "";
$hold[] = "";
$hold[] = "";

$content["option"] = $option;
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 4

$result["pages"] = $pages;
echo json_encode($result);
?>
