<?php // db_connect.php ?>
<?php
  // Create connection
  //$con = mysqli_connect("localhost","rls2014ss","rls2014ss","roomlinkDB");
  $con=mysqli_connect("localhost","thesis","12345678901","thesis_v1");

  mysqli_set_charset($con , "UTF8");

  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    $json_result = array();
    $json_result["result"] = "unsuccess";
    $json_result["error"] = "".mysqli_connect_error();
    echo json_encode($json_result);
    exit;
  } else {
    //echo "Success: connected to MySQL";
  }

  // mysqli_close($con);

?>
