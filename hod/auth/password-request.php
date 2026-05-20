<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result Computation Management System - Password Reset</title>
    <link rel="stylesheet" href="../../assets/css/main.css">
    <?php include '../../includes/links&scripts.php'; ?>
</head>
<body class="bg-color">
  <div class="preloader"></div>
  <div class="d-flex text-dark" style="justify-content:center;align-items:center;">
        <div class=" p-4 div-content " id="login-form" >
        <center>
        <a href="../../index"><img src="../../assets/img/logo.png" width="60px"></a> <br><br>
        <span class="text-dark display-6" style="font-size:large;font-weight:600;">PASSWORD RESET</span><br><br>
            </center>
            <form method="post" class=" bg-white form" onsubmit="return false;">
            <center><span class="msg"></span></center>
            <p>Provide the required information and we will send you a password reset link.</p>
                <div class=" mb-3 ">
                    <label style="font-weight:600">Enter your email address</label>
                    <input type="email"  id="email" class="p-2 rounded">
                </div>
                <button class="btn btn-primary p-2" style="font-size: 12px;" id="password-reset-btn">Submit</button>
                
                <br><br>
                <div class="text-dark">Remember your password? <a href="login" class="text-decoration-none form-link">Login</a></div>
            </form><br>

         </div>
    </div>
    
<script src="../../assets/js/main.js"></script>
<script>
    
    const msg = document.querySelector('.msg');
const password_reset_btn = document.getElementById("password-reset-btn");
password_reset_btn.addEventListener("click", async () => {
    const email = document.getElementById("email");

            const formData = new FormData();
            formData.append('password_reset_btn', 1);
            formData.append('email', email.value);

            
            // Disable the button when the request is initiated
            password_reset_btn.disabled = true;
            try {
                const response = await axios.post('../functions/password-reset.inc.php', formData);
                
                if (response.data.error) {
                    msg.innerHTML = "<div class='alert alert-danger'>" + response.data.error + "</div>";
                } else if (response.data.success) {
                    msg.innerHTML = "<div class='alert alert-success'>" + response.data.success + "</div>";
                }
            } catch (error) {
                console.error(error);
                msg.innerHTML = "<div class='alert alert-danger'>An error occurred. </div>";
            } 
            
            finally {
                password_reset_btn.disabled = false;
            }
        
})
</script>
</body>
</html>