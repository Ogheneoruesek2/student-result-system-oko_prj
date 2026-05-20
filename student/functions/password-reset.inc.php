<?php 
require '../../configs/dbh.inc.php';

//PHPMailer autoload script
require '../../configs/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


//user details
$email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']), ENT_QUOTES);
//token
$token = bin2hex(random_bytes(16));
//expires
$expires = date("U") + 1800;
$response = array();


if(isset($_POST['password_reset_btn'])) {
     if(empty($email)) {
        $response['error'] = 'This field is required.';
    } else {
            $sql = "SELECT email FROM students_tb WHERE email = ?";
            $stmt = mysqli_stmt_init($con);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(!mysqli_num_rows($result) > 0) {
                $response['error'] = 'This email address is not registered with any account';
            } else {
                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->Host       = gethostbyname('ssl://smtp.gmail.com');
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'marvellousobanyedo@gmail.com';
                    $mail->Password   = 'canniqojlriynfyt';
                    $mail->Port       = 465;
                    $mail->setFrom('info@edu.ng', 'Result Computation Management System');
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Password Reset Request';
                    $mail->AddEmbeddedImage('../../assets/img/logo_img.png', 'logo_icon', '../../assets/img/logo.png'); 
                            $mail->Body = "
                        
                        <p style='text-align:justify'>Hello, we received a password reset.<br> Click on the link below to reset your password. If you didn't make this request, kindly ignore.</p><br>
                        <a href='http://localhost/result_com_sys_clients(2)/student/auth/new-password?tkn=$token' style='text-decoration:none;padding:10px;'>Click Here</a>
                        
                        ";
                        if (!$mail->send()) {
                            // echo "Mailer Error: " . $mail->ErrorInfo;
                            $response['error'] = 'An error occurred. Please try again later.';
                        } else {
                            $sql = "INSERT INTO pwd_reset_tb(email, token, expires) VALUES (?, ?, ?)";
                            mysqli_stmt_prepare($stmt, $sql);
                            mysqli_stmt_bind_param($stmt, "sss", $email, $token, $expires);
                            if(mysqli_stmt_execute($stmt)) {
                                $response['success'] = 'A link has been sent to your email address. Check your mail.';
                            }
                        }
            }
    }
}


// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);