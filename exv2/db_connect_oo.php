<?php // db_connect_oo.php ?>
<?php
  // Create connection
  //$con=mysqli_connect("localhost","thesis","12345678901","thesis_v1");
  $conn = new mysqli("localhost", "thesis", "12345678901", "thesis_v1");

  // Check connection
  if ($conn->connect_error) {
    $json_result = array();
    $json_result["result"] = "Connection failed:";
    $json_result["error"] = "".$conn->connect_error;
    echo json_encode($json_result);
    exit;
  }

  /* change character set to utf8 */
  if (!$conn->set_charset("UTF8")) {
    $json_result = array();
    $json_result["result"] = "Error loading character set utf8:";
    $json_result["error"] = "".$conn->error;
    echo json_encode($json_result);
    exit;
  }

  // mysqli_close($con);
  //$conn->close();
?>
