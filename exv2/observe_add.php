<?php include "db_connect.php"; ?>
<?php
  //observe_add.php
  header('Content-Type: application/json');


  $json_result = array();

  // get post input
  $post_student_name = isset($_POST["student_name"]) ? $_POST["student_name"] : "" ;
  $post_question_id = isset($_POST["question_id"]) ? $_POST["question_id"] : "" ;
  $post_access_id = isset($_POST["access_id"]) ? $_POST["access_id"] : "" ;
  $post_action = isset($_POST["action"]) ? $_POST["action"] : "" ;
  $post_detail = isset($_POST["detail"]) ? $_POST["detail"] : "" ;
  $post_action_at = isset($_POST["action_at"]) ? $_POST["action_at"] : "" ;
  $post_action_sequence_number = isset($_POST["action_sequence_number"]) ? $_POST["action_sequence_number"] : "" ;



  // escape variables for security
  $post_student_name = mysqli_real_escape_string($con, $post_student_name);
  $post_question_id = mysqli_real_escape_string($con, $post_question_id);
  $post_access_id = mysqli_real_escape_string($con, $post_access_id);
  $post_action = mysqli_real_escape_string($con, $post_action);
  $post_detail = mysqli_real_escape_string($con, $post_detail);
  $post_action_at = mysqli_real_escape_string($con, $post_action_at);
  $post_action_sequence_number = mysqli_real_escape_string($con, $post_action_sequence_number);

  $json_result["data"]["student_name"] = $post_student_name;
  $json_result["data"]["question_id"] = $post_question_id;
  $json_result["data"]["access_id"] = $post_access_id;
  $json_result["data"]["action"] = $post_action;
  $json_result["data"]["detail"] = $post_detail;
  $json_result["data"]["action_at"] = $post_action_at;
  $json_result["data"]["action_sequence_number"] = $post_action_sequence_number;

  $sql = "INSERT INTO observe (student_name, question_id, access_id, action, detail, action_at, action_sequence_number, create_at)
    VALUES ('$post_student_name','$post_question_id','$post_access_id','$post_action','$post_detail','$post_action_at',$post_action_sequence_number,NOW())";

  $json_result["sql"] = 'insert sql: ' . $sql;

  if (!mysqli_query($con,$sql)) {
    $json_result["result"] = 'error: ' . mysqli_error($con);
  } else {
    $json_result["result"] = 'success';
  }

  // Return the data result as json
  echo json_encode($json_result);
  mysqli_close($con);
?>
