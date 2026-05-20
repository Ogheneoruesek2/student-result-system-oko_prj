<?php 
session_start();
require '../../configs/dbh.inc.php';

if (isset($_POST['course_update_btn'])) {
    $response = array(); // Initialize the response array
    $course_title = htmlspecialchars(mysqli_real_escape_string($con, $_POST['course_title']), ENT_QUOTES);
    $course_code = htmlspecialchars(mysqli_real_escape_string($con, $_POST['course_code']), ENT_QUOTES);
    $course_unit = htmlspecialchars(mysqli_real_escape_string($con, $_POST['course_unit']), ENT_QUOTES);
    $level = mysqli_real_escape_string($con, $_POST['level']);
    $dept = mysqli_real_escape_string($con, $_POST['dept']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $course_id = mysqli_real_escape_string($con, $_POST['course_id']);
    $result_computed = '0';

    if (empty($course_title) || empty($course_code) || empty($course_unit)) {
        $response['error'] = 'All fields are required';
    } else if (is_numeric($course_title)) {
        $response['error'] = 'Course title can\'t contain a number';
    } else if ($level === '--Select level--') {
        $response['error'] = 'Please select a level';
    } else if ($dept === '--Select department--') {
        $response['error'] = 'Please select a department';
    } else if ($semester === '--Select Semester--') {
        $response['error'] = 'Please select a semester';
    } else {
        // Check if a course with the same details exists in the database
        $sql_check = "SELECT id FROM courses_tb WHERE course_title = ? AND course_code = ? AND level = ? AND dept = ? AND semester = ?  AND id != ?";
        $stmt_check = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt_check, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "ssssss", $course_title, $course_code, $level, $dept, $semester,  $course_id);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $response['error'] = 'A course with the same details already exists in the database.';
        } else {
            // Update the course
            $sql = "UPDATE courses_tb SET course_title = ?, course_code = ?, course_unit = ?, level = ?, dept = ?, semester = ? WHERE id = ? ";
            $stmt = mysqli_stmt_init($con);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "sssssss", $course_title, $course_code, $course_unit, $level, $dept, $semester, $course_id);
            if (mysqli_stmt_execute($stmt)) {
                    $response['success'] = 'Course updated successfully';
            }
        }
    }

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
