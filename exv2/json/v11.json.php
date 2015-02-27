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
$page["question"] = "<img src='pics/ship.jpg' class='img-thumbnail image-control'>";

$content = array();
$option = array();
$option[] = "P";
$option[] = "S";
$option[] = "I";
$option[] = "H";
$hold = array();
$hold[] = "1";
$hold[] = "2";
$hold[] = "3";
$hold[] = "4";

$content["option"] = $option;
$content["option_true"] = "SHIP";
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 1

// start page 2
$page = array();
$page["title"] = "What is this? ";
$page["question_id"] = "2";
$page["question_type"] = "1";
$page["question"] = "<img src='pics/bike.jpg' class='img-thumbnail image-control'>";

$content = array();
$option = array();
$option[] = "K";
$option[] = "B";
$option[] = "E";
$option[] = "I";
$hold = array();
$hold[] = "1";
$hold[] = "2";
$hold[] = "3";
$hold[] = "4";

$content["option"] = $option;
$content["option_true"] = "BIKE";
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 2

// start page 3
$page = array();
$page["title"] = "What is this? ";
$page["question_id"] = "3";
$page["question_type"] = "1";
$page["question"] = "<img src='pics/taxi.jpg' class='img-thumbnail image-control'>";

$content = array();
$option = array();
$option[] = "T";
$option[] = "I";
$option[] = "A";
$option[] = "X";
$hold = array();
$hold[] = "1";
$hold[] = "2";
$hold[] = "3";
$hold[] = "4";

$content["option"] = $option;
$content["option_true"] = "TAXI";
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 3

// start page 4
$page = array();
$page["title"] = "What is this? ";
$page["question_id"] = "4";
$page["question_type"] = "1";
$page["question"] = "<img src='pics/bicycle.jpg' class='img-thumbnail image-control'>";

$content = array();
$option = array();
$option[] = "I";
$option[] = "B";
$option[] = "C";
$option[] = "Y";
$option[] = "C";
$option[] = "E";
$option[] = "L";
$hold = array();
$hold[] = "1";
$hold[] = "2";
$hold[] = "3";
$hold[] = "4";
$hold[] = "5";
$hold[] = "6";
$hold[] = "7";

$content["option"] = $option;
$content["option_true"] = "BICYCLE";
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 4

// start page 5
$page = array();
$page["title"] = "Answer the question.<br>What is the first day of week ";
$page["question_id"] = "5";
$page["question_type"] = "1";
$page["question"] = "";

$content = array();
$option = array();
$option[] = "Y";
$option[] = "S";
$option[] = "A";
$option[] = "U";
$option[] = "D";
$option[] = "N";
$hold = array();
$hold[] = "1";
$hold[] = "2";
$hold[] = "3";
$hold[] = "4";
$hold[] = "5";
$hold[] = "6";

$content["option"] = $option;
$content["option_true"] = "SUNDAY";
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 5

// start page 6
$page = array();
$page["title"] = "Country.<br>What country do you live? ";
$page["question_id"] = "6";
$page["question_type"] = "1";
$page["question"] = "";

$content = array();
$option = array();
$option[] = "A";
$option[] = "D";
$option[] = "N";
$option[] = "T";
$option[] = "A";
$option[] = "H";
$option[] = "L";
$option[] = "I";
$hold = array();
$hold[] = "1";
$hold[] = "2";
$hold[] = "3";
$hold[] = "4";
$hold[] = "5";
$hold[] = "6";
$hold[] = "7";
$hold[] = "8";

$content["option"] = $option;
$content["option_true"] = "THAILAND";
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 6

// start page 7
$page = array();
$page["title"] = "What is this? ";
$page["question_id"] = "7";
$page["question_type"] = "1";
$page["question"] = "<img src='pics/doctor.png' class='img-thumbnail image-control'>";

$content = array();
$option = array();
$option[] = "T";
$option[] = "D";
$option[] = "O";
$option[] = "O";
$option[] = "C";
$option[] = "R";
$hold = array();
$hold[] = "1";
$hold[] = "2";
$hold[] = "3";
$hold[] = "4";
$hold[] = "5";
$hold[] = "6";

$content["option"] = $option;
$content["option_true"] = "DOCTOR";
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 7

// start page 8
$page = array();
$page["title"] = "What is this? ";
$page["question_id"] = "8";
$page["question_type"] = "1";
$page["question"] = "<img src='pics/apple.jpeg' class='img-thumbnail image-control'>";

$content = array();
$option = array();
$option[] = "E";
$option[] = "L";
$option[] = "P";
$option[] = "P";
$option[] = "A";
$hold = array();
$hold[] = "1";
$hold[] = "2";
$hold[] = "3";
$hold[] = "4";
$hold[] = "5";

$content["option"] = $option;
$content["option_true"] = "APPLE";
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 8

// start page 9
$page = array();
$page["title"] = "What is this? ";
$page["question_id"] = "9";
$page["question_type"] = "1";
$page["question"] = "<img src='pics/fish.jpeg' class='img-thumbnail image-control'>";

$content = array();
$option = array();
$option[] = "H";
$option[] = "I";
$option[] = "F";
$option[] = "S";
$hold = array();
$hold[] = "1";
$hold[] = "2";
$hold[] = "3";
$hold[] = "4";

$content["option"] = $option;
$content["option_true"] = "FISH";
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 9

// start page 10
$page = array();
$page["title"] = "What is this? ";
$page["question_id"] = "10";
$page["question_type"] = "1";
$page["question"] = "<img src='pics/cake.jpg' class='img-thumbnail image-control'>";

$content = array();
$option = array();
$option[] = "E";
$option[] = "K";
$option[] = "C";
$option[] = "A";
$hold = array();
$hold[] = "1";
$hold[] = "2";
$hold[] = "3";
$hold[] = "4";

$content["option"] = $option;
$content["option_true"] = "CAKE";
$content["hold"] = $hold;

$page["content"] = $content;

$pages[] = $page;
// end page 10

$result["pages"] = $pages;
echo json_encode($result);
?>
