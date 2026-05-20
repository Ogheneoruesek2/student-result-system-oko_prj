<?php 
require '../../configs/dbh.inc.php';
if(isset($_POST['update-btn'])) {
    $response = array(); // Initialize the response array
    $fname = htmlspecialchars(mysqli_real_escape_string($con, $_POST['fname']), ENT_QUOTES);
    $lname = htmlspecialchars(mysqli_real_escape_string($con, $_POST['lname']), ENT_QUOTES);
    $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']), ENT_QUOTES);
    $school_id = $_POST['school_id'];
    $sql = "SELECT email FROM hod_tb WHERE email = ?";
    if(empty($fname) || empty($lname) || empty($email)) {
        $response['error'] = 'All fields are required';
    } else {
        $sql = "UPDATE hod_tb SET fname =?, lname = ?, email =? WHERE school_id = ?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $fname, $lname, $email, $school_id);
        if(mysqli_stmt_execute($stmt)) {
            $response['success'] = 'Profile updated successfully';
        }
    
    }
    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}