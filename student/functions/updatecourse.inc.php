<?php 
session_start();
require '../../configs/dbh.inc.php';

$response = array(); // Initialize the response array

$course_id = mysqli_real_escape_string($con, $_POST['course_id']);

if(isset($_POST['drop_course_btn'])) {
    

    $course_id = mysqli_real_escape_string($con, $_POST['course_id']);
    $sql = "SELECT id, result_computed FROM student_courses_tb WHERE id = '{$course_id}'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    if($row['result_computed'] === '1') {
        $response["error"] = "Course drop unavailable due to existing school-related results";
    } else  {
        $sql = "UPDATE student_courses_tb SET is_dropped = '1' WHERE id = '{$course_id}' AND result_computed = '0'";
        if(mysqli_query($con, $sql)) {
            $response["success"] = "Course dropped successfully";
        }
    }
    

}

if(isset($_POST['reg_course_btn'])) {


    $sql = "UPDATE student_courses_tb SET is_dropped = '0' WHERE id = '{$course_id}'";
    if(mysqli_query($con, $sql)) {
        $response["success"] = "Course registered successfully";
    }

}
    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);

