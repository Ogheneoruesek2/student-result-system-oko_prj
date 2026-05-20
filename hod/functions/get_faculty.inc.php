<?php 
require '../../configs/dbh.inc.php';
// Handle request for populating the dropdown with course titles
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  $dept = $_POST['dept'];
  $response = array();

  if ($dept === '--Select department--') {
    $response['faculty'] = "Faculty";
  } else{
    $sql = "SELECT department, faculty FROM dept_faculty_tb WHERE department = '{$dept}'"; // Adjust the query according to your database schema
    $result = mysqli_query($con, $sql);
    
    $row = mysqli_fetch_assoc($result);
    $response['faculty'] = $row['faculty'];
  }
    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
