<?php 
require '../../configs/dbh.inc.php';
if (isset($_POST['new-password-btn'])) {
    $response = array(); // Initialize the response array
    //variables
    $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']), ENT_QUOTES);
    $password = $_POST['password'];
    $confirmpwd = $_POST['confirmpassword'];
    $options = ['cost' => 12];
    $hashed_pwd = password_hash($password, PASSWORD_BCRYPT, $options);
    if(empty($confirmpwd) || empty($password)) {
       $response['error'] = 'These fields can\'t be empty.';
    } else if($password !== $confirmpwd) {
        $response['error'] = 'Password mismatch.';
    }else if (strlen($password) < 8) {
        $response['error'] = 'Password must be at least 8 characters';
    } else if( !preg_match("#[0-9]+#", $password) ) {
        $response['error'] = "Password must include at least one number, one lowercase letter, one uppercase letter and a special symbol or character!";
    } else if( !preg_match("#[a-z]+#", $password) ) {
        $response['error'] = "Password must include at least one number, one lowercase letter, one uppercase letter and a special symbol or character!";
    } else if( !preg_match("#[A-Z]+#", $password) ) {
        $response['error'] = "Password must include at least one number, one lowercase letter, one uppercase letter and a special symbol or character!";
    } else if( !preg_match("#\W+#", $password) ) {
        $response['error'] = "Password must include at least one number, one lowercase letter, one uppercase letter and a special symbol or character!";
    } else {

        $sql = "UPDATE hod_tb SET password = ? WHERE email =  ?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $hashed_pwd, $email);
        if(mysqli_stmt_execute($stmt)) {
                $sql = "DELETE FROM pwd_reset_tb WHERE email= ?";
                mysqli_stmt_prepare($stmt, $sql);
                mysqli_stmt_bind_param($stmt, "s", $email);
                if(mysqli_stmt_execute($stmt)) {
                    $response['success'] = true;
                }
            } 
        }
    // Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
}