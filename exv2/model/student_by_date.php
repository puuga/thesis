<?php
  class StudentByDate {
    public $date;
    public $studentNumber;
  }

  // return array of StudentByDate
  function getDateList($conn) {
    $sql="SELECT * FROM view_student_by_date ORDER BY activity_date desc";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $obj = new StudentByDate();
        $obj->date = $row["activity_date"];
        $obj->studentNumber = $row["student_number"];
        $arr[] = $obj;
      }
    } else {
      return Array();
    }
    return $arr;
  }
?>
