<?php 
require '../../configs/dbh.inc.php';
$Id = $_POST['Id'];


//Delete course
if (isset($_POST['delete-course-btn'])) { 
        $sql = "DELETE FROM courses_tb WHERE id = '{$Id}'";
     

        // Return a JSON response indicating success or failure
        if (mysqli_query($con, $sql)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
} 

//Delete student result
if (isset($_POST['delete-result-btn'])) { 
    $response = array(); // Initialize the response array
    $school_id = mysqli_real_escape_string($con, $_POST['school_id']);

    //Get course details from student_courses_tb
    $sql = "SELECT course_title, course_code FROM results_tb WHERE id = '{$Id}'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $course_title = $row['course_title'];
    $course_code = $row['course_code'];

    //Update course result to 0
    $sql2 = "UPDATE student_courses_tb SET result_computed = '0' WHERE course_title = '{$course_title}' AND course_code = '{$course_code}' AND school_id = '{$school_id}'";
    if(mysqli_query($con, $sql2)) {
        //Update course result carry over to No 
        $sql_carry_over  = "UPDATE student_courses_tb SET is_carry_over = 'No' WHERE course_title = '{$course_title}' AND course_code = '{$course_code}' AND school_id = '{$school_id}'";
        mysqli_query($con, $sql_carry_over);
        $sql3 = "DELETE FROM results_tb WHERE id = '{$Id}'";
        if(mysqli_query($con, $sql3)) {
       
                        $response['success'] = true;
                    
            } else {
                    $response['error'] = "An error occurred while processing the query";
            }

 
        }
    } else {
        $response['error'] = "An error occurred while processing the query";
    }

    // Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

