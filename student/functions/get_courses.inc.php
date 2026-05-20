<?php 
require '../../configs/dbh.inc.php';
// Handle request for populating the dropdown with course titles
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $course_title = $_POST['courseTitleSelect'];
  $response = array();

  if ($course_title === '--Select course title--') {
    $response['coursecode'] = "Course code";
    $response['courseunit'] = "Course unit";
    $response['level'] = "Level";
    $response['semester'] = "Semester";
  } else {
    $sql = "SELECT course_title, course_code, course_unit, level, semester FROM courses_tb WHERE course_title = '{$course_title}'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $response['coursecode'] = $row['course_code'];
    $response['courseunit'] = $row['course_unit'];
    $response['level'] = $row['level'];
    $response['semester'] = $row['semester'];

  }
    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
