<?php include "db_connect_oo.php"; ?>
<?php
  // activity_landing.php
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include "head_meta.php"; ?>
    <title>template</title>

    <?php include "head_include.php"; ?>

    <script>
      $(document).ready(function() {
        $.material.init();
      });
    </script>

  </head>


  <body>
    <div class="container">
      <h1>Select Category.</h1>
      <?php
      $sql = "SELECT * FROM view_activity_count_by_tag";
      $result = $conn->query($sql);
      $raw_results = Array();
      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          ?>
          <p>
            <a href="v12.php?tag=<?php echo $row["name"];?>" class="btn btn-info btn-lg">
              <?php echo $row["name"];?> (<?php echo $row["number"];?>)
            </a>
          </p>
          <?php
        }
      }
      ?>
    </div>

  </body>

</html>
<?php $conn->close(); ?>
