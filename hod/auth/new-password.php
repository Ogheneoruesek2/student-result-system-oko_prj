<?php if(isset($_GET['tkn'])) {
    require '../../configs/dbh.inc.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result Computation Management System - Password Reset</title>
    <?php include '../../includes/links&scripts.php'; ?>
</head>
<body class="bg-color">
  <div class="preloader"></div>
  <div class="d-flex text-dark" style="justify-content:center;align-items:center;">
        <div class=" p-4 div-content " id="login-form" >
        
         
        <center>
        <a href="../../index"><img src="../../assets/img/logo.png" width="60px"></a> <br><br>
        <span class="text-dark display-6" style="font-size:large;font-weight:600;">RESET YOUR PASSWORD</span><br><br>
            </center>
            <form method="post" class=" bg-white form " onsubmit="return false;">
            <?php
                        $token = mysqli_real_escape_string($con, $_GET['tkn']);
                        $currentDate = date("U");
                        $sql = "SELECT email, token, expires FROM pwd_reset_tb WHERE token = '{$token}' AND expires >= '{$currentDate}'";
                        $result = mysqli_query($con, $sql);
                        if(mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $email = $row['email'];
                        ?>        
        <center><span class="msg"></span></center>
        <div class=" mb-3 ">
                    <label style="font-weight:600">Password</label>
                    <input type="password"  id="password" class="p-2 pwd rounded">
                </div>
                <div class=" mb-3">
                <label style="font-weight:600">Confirm password</label>
                    <input type="password"  id="confirmpassword" class="p-2 pwd rounded"> 
                </div>
                    <input type="hidden"  id="email" value="<?php echo $email; ?>">
                <button class="btn btn-primary p-2" style="font-size: 12px;" id="new-password-btn">Proceed</button>
                
                
                <?php  } else {
                        $sql = "DELETE FROM pwd_reset_tb WHERE token = '{$token}'";
                        if(mysqli_query($con, $sql)) { ?>
                            <div class="text-danger">This link has expired</div>     
                        <?php  }
                        }
                        ?>
            </form><br>
         </div>
    </div>
<script src="../../assets/js/main.js"></script>
<script>



/* --- Password script for students --- */
const msg = document.querySelector('.msg');
const new_password_btn = document.getElementById("new-password-btn");
new_password_btn.addEventListener("click", async () => {
    const password = document.getElementById("password");
const confirmpassword = document.getElementById("confirmpassword");
const email = document.getElementById("email");
        const formData = new FormData();
        formData.append('new-password-btn', 1);
        formData.append('password', password.value);
        formData.append('confirmpassword', confirmpassword.value);
        formData.append('email', email.value);

        
        // Disable the button when the request is initiated
        new_password_btn.disabled = true;

        try {
            const response = await axios.post('../functions/new-password-set.inc.php', formData);
            
            if (response.data.error) {
                msgerror.innerHTML = "<span class='text-danger'>" + response.data.error + "</span>";
            } else if (response.data.success === true) {
                window.location = 'login';
            }
        } catch (error) {
            console.error(error);
            msgerror.innerHTML = "<span class='text-danger'>An error occurred. </span>";
        } 
        
        finally {
            new_password_btn.disabled = false;
        }
    

})
</script>
</body>
</html>
<?php } else { header('Location: index'); } ?>