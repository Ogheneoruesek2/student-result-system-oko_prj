<?php 
require '../../configs/dbh.inc.php';
if(isset($_POST['upload_course_result_btn'])) {
    $response = array();
    $CA = (int)mysqli_real_escape_string($con, $_POST['ca']);
    $obj = (int)mysqli_real_escape_string($con, $_POST['obj']);
    $Q1 = (int)mysqli_real_escape_string($con, $_POST['q1']);
    $Q2 = (int)mysqli_real_escape_string($con, $_POST['q2']);
    $Q3 = (int)mysqli_real_escape_string($con, $_POST['q3']);
    $Q4 = (int)mysqli_real_escape_string($con, $_POST['q4']);
    $Q5 = (int)mysqli_real_escape_string($con, $_POST['q5']);
    $Q6 = (int)mysqli_real_escape_string($con, $_POST['q6']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $course_title = mysqli_real_escape_string($con, $_POST['course_title']);
    $course_code = mysqli_real_escape_string($con, $_POST['course_code']);
    $course_unit = (int)mysqli_real_escape_string($con, $_POST['course_unit']);
    $level = mysqli_real_escape_string($con, $_POST['level']);
    $school_id = mysqli_real_escape_string($con, $_POST['school_id']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $session = mysqli_real_escape_string($con, $_POST['session']);
    $dept = mysqli_real_escape_string($con, $_POST['dept']);
    $faculty = mysqli_real_escape_string($con, $_POST['faculty']);

    if(empty($course_code) || empty($course_unit)) {
        $response['error'] = 'Please provide a valid course course title and course code';
    } else {
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

        //check if result has been uploaded before 
        $sql1 = "SELECT result_computed, school_id, course_title FROM student_courses_tb WHERE school_id = '{$school_id}' AND course_title = '{$course_title}' AND result_computed = '1'";
        $result1 = mysqli_query($con, $sql1);
        if(mysqli_num_rows($result1) > 0) {
            $response['error'] = 'Result for this course has already been uploaded';
        } else {
            $sql_check_course_dropped = "SELECT is_dropped, school_id, course_title FROM student_courses_tb WHERE school_id = '{$school_id}' AND course_title = '{$course_title}' AND is_dropped = '1'";
            $result_check_course_dropped = mysqli_query($con, $sql_check_course_dropped);
            if(mysqli_num_rows($result_check_course_dropped) > 0) {
                $response['error'] = 'The student has withdrawn from this course therefore the associated results cannot be processed';
            } else {
                $sql2 = "INSERT INTO results_tb(name, school_id, course_title, course_code, course_unit, level, dept, faculty, semester, session, obj, q1, q2, q3, q4, q5, q6, ca, total, grade_points, quality_points, grade) 
                VALUES ('{$name}', '{$school_id}', '{$course_title}', '{$course_code}', '{$course_unit}', '{$level}', '{$dept}', '{$faculty}', '{$semester}', '{$session}', '{$obj}', '{$Q1}', '{$Q2}', '{$Q3}', '{$Q4}', '{$Q5}', 
                '{$Q6}', '{$CA}', '{$total}', '{$grade_points}', '{$quality_points}', '{$grade}')";
                if(mysqli_query($con, $sql2)) {
                    $sql3 = "UPDATE student_courses_tb SET result_computed = '1' WHERE school_id = '{$school_id}' AND course_title = '{$course_title}' AND course_unit = '{$course_unit}'";
                    if(mysqli_query($con, $sql3)) {
                        
                        //Set carry over for student if Grade is F
                        if($grade ===  'F') {
                            $sql = "UPDATE student_courses_tb SET is_carry_over = 'Yes' WHERE course_title = '{$course_title}' AND course_code = '{$course_code}' AND school_id = '{$school_id}'";
                            if(mysqli_query($con, $sql)) {
                                $response['success'] = 'Result uploaded successfully';
                            } else {
                                $response['error'] = 'An error occurred while uploading the result';
                            }
                        } else {
                            $response['success'] = 'Result uploaded successfully';
                        }
                        
    
        
                        }
                    
                }
            }
        }
    } 
}


// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);