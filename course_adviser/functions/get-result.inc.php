<?php 
require '../../configs/dbh.inc.php';
if (isset($_POST['add_result_category_btn'])) {
    $response = array(); // Initialize the response array
    $level = mysqli_real_escape_string($con, $_POST['level']);
    $faculty = mysqli_real_escape_string($con, $_POST['faculty']);
    $dept = mysqli_real_escape_string($con, $_POST['dept']);

    if($level === '--Select level--') {
        $response['error'] = "Please select a level";
    } else if ($dept === '--Select department--') {
        $response['error'] = "Please select a department";
    } else {
        $sql = "SELECT level, faculty, dept FROM students_tb WHERE level = '{$level}' AND dept = '{$dept}' AND faculty = '{$faculty}'";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            session_start();
            $_SESSION["level"] = $level;
            $_SESSION["faculty"] = $faculty;
            $_SESSION["dept"] = $dept;
            $response['success'] = true;
    
        }  else {
            $response["error"] = "Students not found";
        }
    }
    
    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}