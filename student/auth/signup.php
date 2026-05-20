<?php
require '../../configs/dbh.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result Computation Management System - Sign Up</title>
    <?php include '../../includes/links&scripts.php'; ?>
</head>
<body class="bg-color">
  <div class="d-flex text-dark" style="justify-content:center;align-items:center;">
        <div class=" p-4 div-content " id="login-form" >
        <center>
        <a href="../../index"><img src="../../assets/img/logo.png" width="60px"></a> <br><br>
        <span class="text-dark display-6" style="font-size:large;font-weight:600;">STUDENT SIGNUP CREDENTIALS</span><br><br>
            </center>
            
            <form method="post" class="bg-white rounded form" onsubmit="return false;">
            <center><span class="msg"></span></center>
                <div class=" mb-3 ">
                  <label style="font-weight:600">First Name</label>
                    <input type="text"  id="fname" class="p-2 rounded" >
                </div>
                <div class=" mb-3 ">
                <label style="font-weight:600">Last Name</label>
                    <input type="text"  id="lname" class="p-2 rounded" >
                </div>
                <div class=" mb-3 ">
                <label style="font-weight:600">Email Address</label>
                    <input type="email"  id="email" class="p-2 rounded" >
                </div>
                <div class=" mb-3 ">
                  <label style="font-weight:600">School ID</label>
                    <input type="text"  id="school_id" class="p-2 rounded">
                </div>
                <div class=" mb-3 ">
                <label style="font-weight:600">Level</label>
                    <select id="level" class="p-2 rounded" style="border-radius: 0px !important;">
                      <option>--Select level--</option>
                      <option>100</option>
                      <option>200</option>
                      <option>300</option>
                      <option>400</option>
                      <option>500</option>
                    </select>
                </div>
                <div class=" mb-3 ">
                    <label style="font-weight:600">Department</label>
                        <select id="dept" class="p-2 rounded" style="border-radius: 0px !important;">
                            <option>--Select department--</option>
                            <?php
                                        $sql = "SELECT department FROM dept_faculty_tb";
                                        $result = mysqli_query($con, $sql);
                                        while($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <option><?php echo $row['department'];?></option>
                                    <?php
                                        }
                                    ?>
                        </select>
                </div>
                <div class=" mb-3 ">
                <label style="font-weight:600">Faculty</label>
                    <input type="text"  id="faculty" class="p-2 rounded" readonly>
                </div>
                <div class=" mb-3">
                <label style="font-weight:600">Password</label>
                    <input type="password" class="pwd p-2 rounded" id="password"  >
           
                </div>


                <button class="btn btn-primary btn-sm p-2"  id="student-sign-up-btn">Sign up</button><br><br>
                <div class="text-dark">Already have an account? <a href="login.php" class="text-decoration-none">Login</a></div>
            </form><br>

         </div>
    </div>
<script src="../../assets/js/main.js"></script>
<script>

const fname = document.getElementById("fname");
const lname = document.getElementById("lname");
const email = document.getElementById("email");
const school_id = document.getElementById("school_id");
const password = document.getElementById("password");
const dept = document.getElementById("dept");
const faculty = document.getElementById("faculty");
const level = document.getElementById("level");
const msg = document.querySelector('.msg');

dept.addEventListener('change', async function () {
  // Fetch Course Info From Database
  const formData = new FormData();
  formData.append('dept', dept.value);

  try {
    const response = await axios.post('../functions/get_faculty.inc.php', formData);
    faculty.value = response.data.faculty;
  } catch (error) {
    console.error(error);
  }
});

/* --- SIGNUP FUNCTION --- */
const sign_up_btn = document.getElementById("student-sign-up-btn");
sign_up_btn.addEventListener("click", async () => {


      const formData = new FormData();
      formData.append('student-sign-up-btn', 1);
      formData.append('fname', fname.value);
      formData.append('lname', lname.value);
      formData.append('email', email.value);
      formData.append('school_id', school_id.value);
      formData.append('dept', dept.value);
      formData.append('faculty', faculty.value);
      formData.append('level', level.value);
      formData.append('password', password.value);

      // Disable the button when the request is initiated
      sign_up_btn.disabled = true;

      try {
        const response = await axios.post('../functions/signup.inc.php', formData);

        if (response.data.error) {
          msg.innerHTML = "<div class='alert alert-danger' >" + response.data.error + "</div>";
        } else if (response.data.success === true) {
              window.location = '../view/dashboard';
              msg.innerHTML = "";
        }
      } catch (error) {
        console.error(error);
        msg.innerHTML = "<div class='alert alert-danger' >An error occurred. </div>";
      } finally {
        sign_up_btn.disabled = false;
      }

      return true; // Form is valid
    
});



</script>
</body>
</html>