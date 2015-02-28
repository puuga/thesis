<?php include "../db_connect_oo.php"; ?>
<?php
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json');

// filter activity by tag
$tag = $_GET["tag"];

// if limit==all then get all activities else get random 10 activities
$limit = $_GET["limit"];


function createPage($i, $raw_results) {
  if ( $raw_results[$i]["question_type"]==1 ) {
    return createPageType1($i, $raw_results);
  }
}

function createPageType1($i, $raw_results) {
  $page = array();
  $page["name"] = $raw_results[$i]["name"];
  $page["title"] = $raw_results[$i]["title"];
  $page["question_id"] = $raw_results[$i]["question_id"];
  $page["question_type"] = $raw_results[$i]["question_type"];
  $page["question"] = $raw_results[$i]["question"];
  $page["placeholder"] = $raw_results[$i]["placeholder"];

  $content = array();
  $option = array();
  $shuffleString = str_shuffle($raw_results[$i]["option_true"]);
  for ( $j=0; $j<strlen($shuffleString);$j++ ) {
    $option[] = $shuffleString[$j];
  }
  $hold = array();
  for ( $j=0; $j<strlen($raw_results[$i]["option_true"]);$j++ ) {
    $hold[] = ($j+1);
  }
  $content["option"] = $option;
  $content["option_true"] = $raw_results[$i]["option_true"];
  $content["hold"] = $hold;

  $page["content"] = $content;

  return $page;
}


$result_final = array();
$result_final["mainTitle"] = $tag;

$pages = array();

// start page 0: for student name
$page = array();
$page["title"] = "Student Name";
$page["question_type"] = "0";
$page["question"] = "Input student name";
$page["placeholder"] = "Student Name";

$pages[] = $page;
// end page 0

// get activity from database, filter activity by tag
if ( $tag=="" ) {
  $sql = "SELECT * FROM view_activity_tag";
} else if ( $tag!="" ) {
  $sql = "SELECT * FROM view_activity_tag WHERE name LIKE '$tag'";
}
$result = $conn->query($sql);
$raw_results = Array();
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $raw_result["name"] = $row["name"];
    $raw_result["title"] = $row["title"];
    $raw_result["question_id"] = $row["question_id"];
    $raw_result["question_type"] = $row["question_type"];
    $raw_result["question"] = $row["question"];
    $raw_result["placeholder"] = $row["placeholder"];
    $raw_result["option_true"] = $row["option_true"];
    $raw_results[] = $raw_result;
  }
}

// filter activity by limit
// create random number
$random = Array();
if ( count($raw_results)<=10 ) {
  for ( $i=0; $i<count($raw_results); $i++) {
    $random[] = $i;
  }
} else {
  for ( $i=0; $i<10; $i++) {
    if ( count($random)==0 ) {
      $random[] = rand(0,count($raw_results)-1);
    } else {
      do {
        $ran = rand(0,count($raw_results)-1);
      } while ( !in_array($ran, $random) );
      $random[] = $ran;
    }
  }
}

// create page
// add page to pages
for ( $i=0; $i<count($random); $i++) {
  $page = createPage($random[$i], $raw_results);
  $pages[] = $page;
}


$result_final["pages"] = $pages;
echo json_encode($result_final);
?>
<?php $conn->close(); ?>
