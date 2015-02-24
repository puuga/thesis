<?php include "db_connect_oo.php"; ?>
<?php
  // summary_score.php
?>
<?php
$access_id = $_GET["access_id"];
$sql="SELECT * FROM observe WHERE access_id='$access_id' ORDER BY action_sequence_number";
$result = $conn->query($sql);
$raw_results = Array();
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $raw_result["student_name"] = $row["student_name"];
    $raw_result["access_id"] = $row["access_id"];
    $raw_result["question_id"] = $row["question_id"];
    $raw_result["action_sequence_number"] = $row["action_sequence_number"];
    $raw_result["action"] = $row["action"];
    $raw_result["detail"] = $row["detail"];
    $raw_result["action_at"] = $row["action_at"];
    $raw_results[] = $raw_result;
  }
}

function getAnswer($question_id, $results) {
  $output = "";
  for ($i=0; $i<count($results); $i++) {
    if ( $question_id == $results[$i]["question_id"] ) {
      if ( $results[$i]["action"]=="on" ) {
        $output = $output.$results[$i-1]["detail"];
      }
    }
  }
  return $output;
}

function checkAnswer($question_id, $question, $results) {
  if ( $question->pages[$question_id]->content->option_true == getAnswer($question_id,$results) ) {
    return true;
  }
  return false;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include "head_meta.php"; ?>
    <title>Summary Score of <?php echo $raw_results[0]["student_name"]; ?></title>

    <?php include "head_include.php"; ?>

    <script>
      $(document).ready(function() {
        $.material.init();
      });
    </script>

  </head>


  <body>
    <div class="container-fluid bg-primary">
      <div class="row">
        <div class="col-md-12">
          <h1>Summary Score of <?php echo $raw_results[0]["student_name"]; ?></h1>
        </div>
      </div>
    </div>

    <div class="container">
      <br/>


      <div>
        <?php
        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_URL, "http://localhost/thesis/exv2/json/v11.json.php");
        curl_setopt($ch, CURLOPT_URL, "http://128.199.208.34/thesis/exv2/json/v11.json.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);

        $obj = json_decode($json);
        //print_r($obj);
        //print_r($raw_results);

        $numberOfRightAnswer = 0;

        for ($i=1; $i<count($obj->pages); $i++) {
          $isRightAnswer = checkAnswer($i,$obj,$raw_results);
          if ( $isRightAnswer ) {
            $numberOfRightAnswer++;
          }
          ?>
          <div class="well well-lg <?php echo $isRightAnswer?"well-material-green-300":"well-material-red-300"; ?>">
            <div class="row">
              <div class="col-md-1">
                <?php echo $i; ?>
              </div>
              <div class="col-md-1">
                <?php
                if ( $isRightAnswer ) {
                  echo "<span class='mdi-navigation-check'></span>";
                } else {
                  echo "<span class='mdi-navigation-close'></span>";
                }
                ?>
              </div>
              <div class="col-md-4">
                Right answer is <?php echo $obj->pages[$i]->content->option_true; ?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-md-offset-2">
                Your answer is <?php echo getAnswer($i,$raw_results); ?>
              </div>
            </div>
          </div>

          <?php
        }
        ?>

        <div class="well well-lg well-material-blue-grey-300">
          <h2>You got <?php echo $numberOfRightAnswer; ?> of <?php echo count($obj->pages)-1; ?></h2>
        </div>

      </div>

    </div>

  </body>

</html>
<?php $conn->close(); ?>
