<?php
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json');

$result = array();
$result["mainTitle"] = "main title";

$pages = array();

// start page 1
$page = array();
$page["title"] = "Activity 1";
$page["question"] = "Match picture and box.";

$content = array();
$option = array();
$option[] = "<img src='http://www.clker.com/cliparts/s/y/s/q/h/R/cartoon-sun-md.png' width='100'>";
$option[] = "<img src='http://static.giantbomb.com/uploads/square_small/0/4938/889958-nemo_4.jpg' width='100'>";
$option[] = "<img src='http://eofdreams.com/data_images/dreams/pencil/pencil-03.jpg' width='100'>";
$option[] = "<img src='http://bestclipartblog.com/clipart-pics/student-clipart-1.jpg' width='100'>";
$hold = array();
$hold[] = "sky";
$hold[] = "water";
$hold[] = "<img src='http://www.dullmensclub.com/wp-content/uploads/images/stories/eventsApril/erase.gif' width='100'>";
$hold[] = "<img src='http://www.newtoncountyschools.org/Portals/13/middleridge/images/curriculum%20night%20school.jpg' width='100'>";

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
