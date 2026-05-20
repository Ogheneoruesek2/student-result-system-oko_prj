
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result Computation System </title>
    <?php include '../../includes/links&scripts.php'; ?>
</head>
<body>
  <div class="d-flex text-dark" style="justify-content:center;align-items:center;">
        <div class=" p-4 div-content " id="login-form" >
        <center>
        <a href="../../index"><img src="../../assets/img/logo.png" width="60px"></a> <br><br>
            <span class="text-dark display-6" style="font-size:large;font-weight:600;">COURSE ADVISER LOGIN CREDENTIALS</span><br><br>
            </center>
            
            <form method="post" class="bg-white form rounded" onsubmit="return false;">
            <center><span class="msg"></span></center>
                <div class=" mb-3 ">
                    <label style="font-weight:600">Email address or School ID</label>
                    <input type="text"  id="user" class="p-2 rounded">
                </div>
                
                <div class=" mb-3">
                    <label style="font-weight:600">Password</label>
                    <input type="password" class="pwd p-2 rounded"  id="pwd">
                </div>
                <div class="d-flex" style="gap:1rem;align-items:center">
                    <div><button class="btn btn-primary btn-sm p-2" id="login-btn">Sign in</button></div>
                    <div><a href="password-request" class="text-decoration-none">Forgot your password?</a></div>
                </div>
                <div class="text-dark mt-3">Don't have an account? <a href="signup" class="text-decoration-none">Sign up</a></div>
              
            </form><br>
            
         
           
            
         </div>
         
    </div>

<script src="../../assets/js/main.js"></script>
<script>
/* --- Login script --- */
const msg = document.querySelector('.msg');
const login_btn = document.getElementById("login-btn");
login_btn.addEventListener("click", async () => {
    const user = document.getElementById("user");
    const password = document.getElementById("pwd");
    


        const formData = new FormData();
        formData.append('course_advisor-login-btn', 1);
        formData.append('user', user.value);
        formData.append('password', password.value);

        
        // Disable the button when the request is initiated
        login_btn.disabled = true;

        try {
            const response = await axios.post('../functions/login.inc.php', formData);
            
            if (response.data.error) {
                msg.innerHTML = "<div class='alert alert-danger'>" + response.data.error + "</div>";
            } else if (response.data.success === true) {
                window.location = '../view/dashboard';
                msg.innerHTML = "";
            }
        } catch (error) {
            console.error(error);
            msg.innerHTML = "<div class='alert alert-danger'>An error occurred. </div>";
        } 
        
        finally {
            login_btn.disabled = false;
        }
    

})


</script>
</body>
</html>