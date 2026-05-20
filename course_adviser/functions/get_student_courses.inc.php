<?php 
// Handle request for populating the dropdown with course titles
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    require '../../configs/dbh.inc.php';
  $course_title = $_POST['course_title'];
  $school_id = $_POST['school_id'];
  $response = array();

  if ($course_title === "-- Select course title --") {
    $response['error'] = "Please select a course title";
  } else{
    $sql = "SELECT * FROM student_courses_tb WHERE course_title = '{$course_title}' AND school_id  = '{$school_id}'"; // Adjust the query according to your database schema
    $result = mysqli_query($con, $sql);
    
    $row = mysqli_fetch_assoc($result);
    $response['course_code'] = $row['course_code'];
    $response['course_unit'] = $row['course_unit'];
    $response['level'] = $row['level'];
    $response['semester'] = $row['semester'];
    $response['session'] = $row['session'];
  }
    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>

