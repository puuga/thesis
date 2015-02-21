<?php
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json');

$result = array();
$result["mainTitle"] = "main title";

$pages = array();

// start page 0: for student name
$page = array();
$page["title"] = "Student Name";
$page["question_type"] = "0";
$page["question"] = "Input student name";
$page["placeholder"] = "Student Name";

$pages[] = $page;
// end page 0

// start page 1
$page = array();
$page["title"] = "What is this? ";
$page["question_id"] = "1";
$page["question_type"] = "1";
$page["question"] = "<img src='pics/ship.jpg' width='300'>";

$content = array();
$option = array();
$option[] = "S";
$option[] = "H";
$option[] = "I";
$option[] = "P";
$hold = array();
$hold[] = "1";
$hold[] = "2";
$hold[] = "3";
$hold[] = "4";

$content["option"] = $option;
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 1

// start page 2
$page = array();
$page["title"] = "What is this? ";
$page["question_id"] = "2";
$page["question_type"] = "1";
$page["question"] = "<img src='pics/bike.jpg' width='300'>";

$content = array();
$option = array();
$option[] = "B";
$option[] = "I";
$option[] = "K";
$option[] = "E";
$hold = array();
$hold[] = "1";
$hold[] = "2";
$hold[] = "3";
$hold[] = "4";

$content["option"] = $option;
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 2

// start page 3
$page = array();
$page["title"] = "What is this? ";
$page["question_id"] = "3";
$page["question_type"] = "1";
$page["question"] = "<img src='pics/taxi.jpg' width='300'>";

$content = array();
$option = array();
$option[] = "T";
$option[] = "A";
$option[] = "X";
$option[] = "I";
$hold = array();
$hold[] = "1";
$hold[] = "2";
$hold[] = "3";
$hold[] = "4";

$content["option"] = $option;
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 3

// start page 4
$page = array();
$page["title"] = "What is this? ";
$page["question_id"] = "4";
$page["question_type"] = "1";
$page["question"] = "<img src='pics/bicycle.jpg' width='300'>";

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
$hold[] = "1";
$hold[] = "2";
$hold[] = "3";
$hold[] = "4";
$hold[] = "5";
$hold[] = "6";
$hold[] = "7";

$content["option"] = $option;
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 4

$result["pages"] = $pages;
echo json_encode($result);
?>
