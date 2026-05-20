<?php 
require '../../configs/dbh.inc.php';


//Student signup
if(isset($_POST['student-sign-up-btn'])) {
    $fname = htmlspecialchars(mysqli_real_escape_string($con, $_POST['fname']), ENT_QUOTES);
    $lname = htmlspecialchars(mysqli_real_escape_string($con, trim($_POST['lname'])), ENT_QUOTES);
    $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']), ENT_QUOTES);
    $school_id = htmlspecialchars(mysqli_real_escape_string($con, $_POST['school_id']), ENT_QUOTES);
    $level = $_POST['level'];
    $dept = $_POST['dept'];
    $faculty = $_POST['faculty'];
    $password = $_POST['password'];
    
    $options = ['cost' => 12];
    $hashed_pwd = password_hash($password, PASSWORD_BCRYPT, $options);
    $response = array(); // Initialize the response array


    
    function empty_input_func($fname, $lname, $email, $school_id, $password) {
        return empty($fname) || empty($lname) || empty($email) || empty($school_id) || empty($password);
    }


    if (empty_input_func($fname, $lname, $email, $school_id, $password)) {
        $response['error'] = 'All fields are required';
    } else if (strlen($fname) < 2 || strlen($fname) > 60) {
        $response['error'] = 'First Name length is outside the acceptable range';
    }  else if (strlen($lname) < 2 || strlen($lname) > 60) {
        $response['error'] = 'Last Name length is outside the acceptable range';
    } else if (preg_match('/[0-9]+/', $fname) || preg_match('/[0-9]+/', $lname)) {
        $response['error'] = 'First Name or Last Name contains invalid characters';
    } else if (preg_match("#\W+#", $fname) || preg_match("#\W+#", $lname)) {
        $response['error'] = 'First Name or Last Name contains invalid characters';
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
        $response['error'] = 'Invalid email address';
    } else if($level === '--Select level--') {
        $response['error'] = 'Please select your level';
    } else if($dept === '--Select department--') {
        $response['error'] = 'Please select your department';
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
        $sql = "SELECT email, school_id FROM students_tb WHERE email = ?  OR school_id = ?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $email, $school_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result) > 0) {
            $response['error']= "A student with same email address or school id is already registered";
        } else {
  
                $sql = "INSERT INTO students_tb(fname, lname, email, school_id, dept, faculty, level, password)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($con);
                mysqli_stmt_prepare($stmt, $sql);
                mysqli_stmt_bind_param($stmt, "ssssssss", $fname, $lname, $email, $school_id, $dept, $faculty, $level, $hashed_pwd);
                if(mysqli_stmt_execute($stmt)) {
                    $sql = "SELECT id, email, school_id FROM students_tb WHERE email = ?  OR school_id = ?";
                    mysqli_stmt_prepare($stmt, $sql);
                    mysqli_stmt_bind_param($stmt, "ss", $email, $school_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if(mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        session_start();
                        $_SESSION['studentID'] = $row['id'];
                        $response['success'] = true;
                    }
                }
        }
    }
        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);

}
?>
