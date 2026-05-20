<?php 
require '../../configs/dbh.inc.php';
$response = array(); // Initialize the response array
$level = mysqli_real_escape_string($con, $_POST['level']);
$semester = mysqli_real_escape_string($con, $_POST['semester']);
$faculty = mysqli_real_escape_string($con, $_POST['faculty']);
$dept = mysqli_real_escape_string($con, $_POST['dept']);
$session = mysqli_real_escape_string($con, $_POST['session']);

//Semester printing
if (isset($_POST['print_btn'])) {
    $sql = "SELECT level, semester, faculty, dept, session FROM results_tb WHERE level = '{$level}' AND semester = '{$semester}' AND dept = '{$dept}' AND faculty = '{$faculty}' AND session = '{$session}'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        session_start();
        $_SESSION["semester_level"] = $level;
        $_SESSION["semester"] = $semester;
        $_SESSION["semester_faculty"] = $faculty;
        $_SESSION["semester_dept"] = $dept;
        $_SESSION["semester_session"] = $session;
        $response["success"] = true;
    } else {
        $response["error"] = "Result not found";
    }
}




   // Return the response as JSON
   header('Content-Type: application/json');
   echo json_encode($response);