<?php 
// Include your database connection here
require '../../configs/dbh.inc.php';
    if (isset($_POST['delete-course-btn'])) { // Check if 'courseId' is set in $_POST
        $courseId = mysqli_real_escape_string($con, $_POST['courseId']);
        $response = array();
        
        // Perform the SQL delete operation based on $courseId
        $sql = "SELECT id, result_computed FROM student_courses_tb WHERE id = '{$courseId}'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        if($row['result_computed'] === '0') {    
            $sql = "DELETE FROM student_courses_tb WHERE id = '{$courseId}' AND result_computed = '0'";
            if (mysqli_query($con, $sql)) {
                $response['success'] = true;
            }
        } else {
            $response['error'] = 'The removal of this course is not possible as its results have already been uploaded';
        }
        
    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} 

