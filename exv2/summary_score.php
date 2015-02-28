<?php include "db_connect_oo.php"; ?>
<?php
  // summary_score.php
?>
<?php
$access_id = $_GET["access_id"];

// get result
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

// get amount of activity
$sql="SELECT * FROM observe WHERE `access_id` LIKE '$access_id' and `action`='activity'  ORDER BY action_sequence_number";
$result = $conn->query($sql);
$raw_activity_results = Array();
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $raw_activity_result["access_id"] = $row["access_id"];
    $raw_activity_result["question_id"] = $row["question_id"];
    $raw_activity_result["action"] = $row["action"];
    $raw_activity_results[] = $raw_activity_result;
  }
}

function getAnswer($question_id, $results) {
  $output = "";
  for ($i=0; $i<count($results); $i++) {
    if ( $question_id == $results[$i]["question_id"] ) {
      if ( $results[$i]["action"]=="on" ) {
        // $output = $output.$results[$i-1]["detail"];
        $index = $results[$i]["detail"]*1;
        $temp[$index] = $results[$i-1]["detail"];
      }
    }
  }
  // ksort($temp);
  for ( $j=1; $j<count($results); $j++ ) {
    $output = $output.$temp[$j];
  }
  // print_r($temp);
  return $output;
}

function getTrueAnswer($question_id, $question) {
  for ($i=0; $i<count($question->pages); $i++) {
    if ( $question->pages[$i]->question_id == $question_id ) {
      return $question->pages[$i]->content->option_true;
    }
  }
  return "";
}

function checkAnswer($j,$question_id, $question, $results) {
  for ( $k=0; $k<count($question->pages); $k++ ) {
    if ( $question->pages[$k]->question_id == $question_id ) {
      if ( getTrueAnswer($question_id, $question) == getAnswer($question_id,$results) ) {
        return true;
      }
      return false;
    }
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

        // play sound
        playSound();
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
        curl_setopt($ch, CURLOPT_URL, "http://128.199.208.34/thesis/exv2/json/v12.json.php?limit==all");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);

        $obj = json_decode($json);

        // print_r($obj);
        // echo "<hr>";
        // print_r($raw_results);
        // echo "<hr>";
        // print_r($raw_activity_results);
        // echo "<hr>";

        $numberOfRightAnswer = 0;

        for ($i=1; $i<count($raw_activity_results)+1; $i++) {
          $isRightAnswer = checkAnswer($i,$raw_activity_results[$i-1]["question_id"],$obj,$raw_results);
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
                Right answer is <?php echo getTrueAnswer($raw_activity_results[$i-1]["question_id"], $obj); ?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-md-offset-2">
                Your answer is <?php echo getAnswer($raw_activity_results[$i-1]["question_id"],$raw_results); ?>
              </div>
            </div>
          </div>

          <?php
        }
        ?>

        <div class="well well-lg well-material-blue-grey-300">
          <h1>You got <?php echo $numberOfRightAnswer; ?> of <?php echo count($raw_activity_results); ?></h1>
          <h2>
          <?php
          if ( $numberOfRightAnswer/(count($raw_activity_results)) >= 0.8 ) {
            echo "You are excellent!";
          } else if ( $numberOfRightAnswer/(count($raw_activity_results)) >= 0.6 ) {
            echo "You are very good!";
          } else if ( $numberOfRightAnswer/(count($raw_activity_results)) >= 0.4 ) {
            echo "You are good!";
          } else {
            echo "You have to practice more!";
          }
          ?>
          </h2>
        </div>

      </div>

    </div>

    <div id="sound"></div>
    <script>
      // play sound
      function playSound() {
        if ( <?php echo $numberOfRightAnswer/(count($obj->pages)-1); ?>>= 0.8 ) {
          $("#sound").html('<audio autoplay="autoplay"><source src="sound/Final-Fantasy-VII-Victory-Fanfare.mp3" type="audio/mpeg" /><embed hidden="true" autostart="true" loop="false" src="sound/Final-Fantasy-VII-Victory-Fanfare.mp3" /></audio>');
        }

      }
    </script>

  </body>

</html>
<?php $conn->close(); ?>
