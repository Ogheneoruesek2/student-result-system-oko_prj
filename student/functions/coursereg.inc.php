<?php 
require '../../configs/dbh.inc.php';
if(isset($_POST['course_reg_btn'])) {
    $response = array();
    $course_title = mysqli_real_escape_string($con, $_POST['courseTitleSelect']);
    $course_code = mysqli_real_escape_string($con, $_POST['courseCode']);
    $course_unit = mysqli_real_escape_string($con, $_POST['courseUnit']);
    $level = mysqli_real_escape_string($con, $_POST['level']);
    
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $session = mysqli_real_escape_string($con, $_POST['session']);
    $school_id =  $_POST['school_id'];
    $dept =  $_POST['dept'];
    $faculty =  $_POST['faculty'];
    $name =  $_POST['name'];
    $studentlevel = $_POST['studentlevel'];

    if($course_title === '--Select course title--') {
        $response['error'] = 'Please select a course title';
    } else if(empty($session)) {
        $response['error'] = 'Please include a session';
    } else {
        $sql = "SELECT course_title, school_id FROM student_courses_tb WHERE course_title = '{$course_title}' AND school_id = '{$school_id}' AND is_carry_over = 'No'";
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result) > 0) {
            $response['error'] = 'This course has already been registered';
        } else {
            $sql = "SELECT SUM(course_unit) AS total_units FROM student_courses_tb WHERE school_id = '{$school_id}' AND session = '{$session}' AND semester = '{$semester}'";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            $total_units = $row['total_units'];

            $new_total_units = $total_units + $course_unit;
            if ($new_total_units > 24) {
                
                $response['error'] = 'You have reached the maximum unit load for '. $semester . ' (24 units).';
            } else {
            $sql = "INSERT INTO student_courses_tb(name, school_id, course_title, course_code, course_unit,  level, semester, session, dept, faculty) 
            VALUES ('{$name}','{$school_id}', '{$course_title}','{$course_code}','{$course_unit}','{$level}','{$semester}','{$session}','{$dept}','{$faculty}')";
            if(mysqli_query($con, $sql)) {
                $response['success'] = 'Course registered successfully';
            }
        }
        }
    }
    
    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}