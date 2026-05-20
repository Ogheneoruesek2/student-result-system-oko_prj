<?php 
session_start();
require '../../configs/dbh.inc.php';
if(isset($_POST['course_btn'])) {
    $response = array(); // Initialize the response array
    $course_title = htmlspecialchars(mysqli_real_escape_string($con, $_POST['course_title']), ENT_QUOTES);
    $course_code = htmlspecialchars(mysqli_real_escape_string($con, $_POST['course_code']), ENT_QUOTES);
    $course_unit = htmlspecialchars(mysqli_real_escape_string($con, $_POST['course_unit']), ENT_QUOTES);
    $level = mysqli_real_escape_string($con, $_POST['level']);
    $dept = mysqli_real_escape_string($con, $_POST['dept']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $faculty = mysqli_real_escape_string($con, $_POST['faculty']);

    if(empty($course_title) || empty($course_code) || empty($course_unit)) {
        $response['error'] = 'All fields are required';
    } else if(is_numeric($course_title)) {
        $response['error'] = 'Course title can\'t contain a number';
    } else if ($level === '--Select level--') {
        $response['error'] = 'Please select a level';
    } else if($dept === '--Select department--') {
        $response['error'] = 'Please select a department';
    } else if($semester === '--Select Semester--') {
        $response['error'] = 'Please select a semester';
    } else {

        $sql = "SELECT course_title, course_code, faculty FROM courses_tb WHERE course_title = ? OR course_code = ? AND faculty = ?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $course_title, $course_code, $faculty);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result) > 0) {
            $response['error'] = 'This course has already been registered.';
        } else {
            $sql = "INSERT INTO courses_tb (course_title, course_code, course_unit, dept, faculty, level, semester) VALUES (?, ?, ?, ?, ?, ?, ?)";
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "sssssss", $course_title, $course_code, $course_unit, $dept, $faculty, $level, $semester);
            if(mysqli_stmt_execute($stmt)) {
                $response['success'] = 'Course added successfully.';
            }
        }
    }
      // Return the response as JSON
      header('Content-Type: application/json');
      echo json_encode($response);
}