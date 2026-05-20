<?php 
session_start();
require '../../configs/dbh.inc.php';
error_reporting(0);

//Student Login
if (isset($_POST['student-login-btn'])) {
    $user = htmlspecialchars(mysqli_real_escape_string($con, $_POST['user']), ENT_QUOTES);
    $pwd = $_POST['password'];
    $response = array(); // Initialize the response array

    if(empty($user) || empty($pwd)) {
        $response['error'] = 'All fields are required';
    } else {
        $sql = "SELECT id, email, school_id, password FROM students_tb WHERE email = ? OR school_id = ?";
        $stmt = mysqli_stmt_init($con);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $user, $user);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $pwd_chk = password_verify($pwd, $row['password']);
                if ($pwd_chk === false) {
                    $response['error'] = 'Incorrect email address/school ID or password.';
                } else if($pwd_chk === true ){
                    $_SESSION['studentID'] = $row['id'];
                    $response['success'] = true;
                }
            } else {
                $response['error'] = 'Incorrect email address/school ID or password.';
            }
        } else {
            $response['error'] = 'An error occurred while processing the request.';
        }
    }

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
