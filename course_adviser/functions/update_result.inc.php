<?php 
require '../../configs/dbh.inc.php';
if(isset($_POST['update_course_result_btn'])) {
    $response = array();
    $CA = (int)mysqli_real_escape_string($con, $_POST['ca']);
    $obj = (int)mysqli_real_escape_string($con, $_POST['obj']);
    $Q1 = (int)mysqli_real_escape_string($con, $_POST['q1']);
    $Q2 = (int)mysqli_real_escape_string($con, $_POST['q2']);
    $Q3 = (int)mysqli_real_escape_string($con, $_POST['q3']);
    $Q4 = (int)mysqli_real_escape_string($con, $_POST['q4']);
    $Q5 = (int)mysqli_real_escape_string($con, $_POST['q5']);
    $Q6 = (int)mysqli_real_escape_string($con, $_POST['q6']);
    $course_unit = (int)mysqli_real_escape_string($con, $_POST['course_unit']);
    $course_id = mysqli_real_escape_string($con, $_POST['course_id']);
    $school_id = mysqli_real_escape_string($con, $_POST['school_id']);

    $total = $CA + $obj + $Q1 + $Q2 + $Q3 + $Q4 + $Q5 + $Q6;
    $grade = null;
    $grade_points = null;
    if($total >= 70 && $total <= 100) {
        $grade = 'A';
        $grade_points = 5;
        $quality_points = $course_unit * $grade_points;
    } else if ($total >= 60 && $total <= 69) {
        $grade = 'B';
        $grade_points = 4;
        $quality_points = $course_unit * $grade_points;
    } else if ($total >= 50 && $total <= 59) {
        $grade = 'C';
        $grade_points = 3;
        $quality_points = $course_unit * $grade_points;
    } else if ($total >= 45 && $total <= 49) {
        $grade = 'D';
        $grade_points = 2;
        $quality_points = $course_unit * $grade_points;
    } else if ($total >= 40 && $total <= 44) {
        $grade = 'E';
        $grade_points = 1;
        $quality_points = $course_unit * $grade_points;
    } else if ($total >= 0 && $total <= 39) {
        $grade = 'F';
        $grade_points = 0;
        $quality_points = $course_unit * $grade_points;
    }


$sql1 = "UPDATE results_tb SET ca = '{$CA}', obj = '{$obj}', q1 = '{$Q1}', q2 = '{$Q2}', q3 = '{$Q3}', q4 = '{$Q4}', q5 = '{$Q5}', q6 = '{$Q6}', total = '{$total}', grade_points = '{$grade_points}', quality_points = '{$quality_points}', grade = '{$grade}'  WHERE id = '{$course_id}'";
if(mysqli_query($con, $sql1)) {

    //Set carry over for student if Grade is F
    $sql_grade = "SELECT course_title, course_code, grade FROM results_tb WHERE id = '{$course_id}' AND school_id = '{$school_id}'";
    $result_grade = mysqli_query($con, $sql_grade);
    $row_grade = mysqli_fetch_array($result_grade);
    if($row_grade['grade'] === 'F') {
        $sql_grade = "UPDATE student_courses_tb SET is_carry_over = 'Yes' WHERE course_title = '{$row_grade['course_title']}' AND course_code = '{$row_grade['course_code']}' AND school_id = '{$school_id}'";
        if(mysqli_query($con, $sql_grade)) {
            $response['success'] = 'Result updated successfully';
        } else {
            $response['error'] = 'Error updating result';
        }

    } else {
        $sql_grade = "UPDATE student_courses_tb SET is_carry_over = 'No' WHERE course_title = '{$row_grade['course_title']}' AND course_code = '{$row_grade['course_code']}' AND school_id = '{$school_id}'";
        if(mysqli_query($con, $sql_grade)) {
            $response['success'] = 'Result updated successfully';
        } else {
            $response['error'] = 'Error updating result';
        }
    }
    }
}  
    


// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);