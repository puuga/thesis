<?php include "db_connect_oo.php"; ?>
<?php
  //observe_view.php
?>
<?php
  include "model/student_by_date.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include "head_meta.php"; ?>
    <title>Observe View</title>

    <?php include "head_include.php"; ?>

    <script>
      $(document).ready(function() {
        $.material.init();
      });
    </script>

  </head>


  <body>
    <div class="container">

      <div class="row bg-primary">
        <div class="col-md-12">
          <h1><i class="mdi-action-receipt"></i><span>Observe View</span></h1>
        </div>
      </div>

      <br/>

      <div class="row">
        <div class="col-md-12">
          <?php
          $access_id = $_GET["access_id"];
          $date = $_GET["date"];
          if ( $access_id != "" ) {
            echo "<a href='summary_score.php?access_id=$access_id' class='btn btn-material-light-blue btn-lg'>Score</a>";
          } else {

            $StudentByDate = getDateList($conn);
            echo "<ul class=\"nav nav-pills\">";
            if ( $date=="" || $date=="Today" ) {
              echo "<li class='active'><a href='observe_view.php?date=Today'>Today</a></li>";
            } else {
              echo "<li><a href='observe_view.php?date=Today'>Today</a></li>";
            }
            for ( $i=0; $i<count($StudentByDate); $i++) {
              if ( $date==$StudentByDate[$i]->date ) {
                echo "<li class='active'>";
                echo "<a href='observe_view.php?date=".$StudentByDate[$i]->date."'>";
                echo $StudentByDate[$i]->date." ";
                echo "<span class=\"badge\">".$StudentByDate[$i]->studentNumber."</span>";
                echo "</a>";
                echo "</li>";
              }
              else {
                echo "<li>";
                echo "<a href='observe_view.php?date=".$StudentByDate[$i]->date."'>";
                echo $StudentByDate[$i]->date." ";
                echo "<span class=\"badge\">".$StudentByDate[$i]->studentNumber."</span>";
                echo "</a>";
                echo "</li>";
              }
            }
            echo "</ul>";
          }
          ?>
        </div>
      </div>

      <table class="table table-striped table-hover ">
        <thead>
          <tr>
            <th>Student Name</th>
            <th>Hash</th>
            <th>Question</th>
            <th>Sequence</th>
            <th>action</th>
            <th>on</th>
            <th>at</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ( $access_id=="" && ($date=="" || $date=="Today") ) {
            $sql="SELECT * FROM observe WHERE date(create_at)=CURDATE() ORDER BY action_at,access_id,action_sequence_number";
          } else if ( $date!="" ) {
            $sql="SELECT * FROM observe WHERE date(create_at)='$date' ORDER BY action_at,access_id,action_sequence_number";
          } else {
            $sql="SELECT * FROM observe WHERE access_id='$access_id' ORDER BY action_at,access_id,action_sequence_number";
          }
          // echo $sql;
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
              ?>
              <tr>
                <td><?php echo $row["student_name"];?></td>
                <td><a href="observe_view.php?access_id=<?php echo $row["access_id"];?>"><?php echo $row["access_id"];?></a></td>
                <td><?php echo $row["question_id"];?></td>
                <td><?php echo $row["action_sequence_number"];?></td>
                <td><?php echo $row["action"];?></td>
                <td><?php echo $row["detail"];?></td>
                <td><?php echo $row["action_at"];?></td>
              </tr>
              <?php
            }
          } else {
            ?>
            <tr>
              <td colspan="7">
                0 results
              </td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>

    </div>

    <div class="floating-action-button-position">
      <a href="observe_view.php" class="btn btn-fab btn-raised btn-material-red mdi-av-replay"></a>
    </div>

  </body>

</html>
<?php $conn->close(); ?>
