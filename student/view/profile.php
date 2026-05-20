<?php
session_start();
if(isset($_SESSION['studentID'])) {
    require '../../configs/dbh.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Student </title>
    <?php include '../../includes/links&scripts.php'; ?>
</head>
<body >
<div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php';?>
        <!-- /#sidebar-wrapper --> 
        <!-- Page Content -->
        <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light d-flex bg-white  fixed-top py-3 px-3" style="justify-content:space-between;">
               <div class="d-flex">
                    <div><i class="fas fa-align-left fs-4 me-3" style="color:#0d2a45ff;" id="menu-toggle"></i></div>
                    <div><p class="display-6" style="font-size: large;font-weight:600;">Profile</p></div>
               </div> 
        <?php include 'includes/studentnavbar.php';?>
           
            <div class="container-fluid px-4 py-4">
                <div class="bg-white sm p-3 rounded">
                <div class="d-flex text-dark" style="justify-content:center;align-items:center;">
        <div class=" p-4 div-content " id="login-form" >
                        <form method="post" class="mb-5 " id="form">
                        <center>
                        <?php if($row['image'] === null) { ?>
                            <div class="passport-photo">
                                <img src="../../uploads/students/default_img.jpg" alt="student_image">
                            </div>
                        <?php } else { ?>
                            <div class="passport-photo">
                                <img src="../../uploads/students/<?php echo $row['image'];?>" width="100%" style="border-radius:50% !important;" alt="student_image">
                            </div>
                        <?php }?>
                        </center>
                        <input type="file" class="mt-3 rounded p-2" name="imgfile" id="imgfile" required>
                        <input type="hidden" name="school_id" value="<?php echo $row['school_id'];?>">
                        <button class="btn btn-primary p-2 btn-sm mt-4 w-100"  id="update-img-btn" >Update</button><br><br>
                                        <center><span class="msg1"></span></center>
                        </form>
        </div>
                </div>
                                    <form method="post" onsubmit="return false;">
                                    <div class="flexbox">
                                        <div class="d-50">
                                            <div class="mb-3">
                                                <label style="font-weight:600">First Name</label>
                                                <input type="text"  id="fname" placeholder="First Name" class="p-2 w-100" style="border-radius:0px;border:1px solid grey;" value="<?php echo $row['fname'];?>">
                                            </div>
                                            <div class="mb-3">
                                            <label style="font-weight:600">Last Name</label>
                                                <input type="text"  id="lname" placeholder="Last Name" class="p-2 w-100" style="border-radius:0px;border:1px solid grey;" value="<?php echo $row['lname'];?>">
                                            </div>
                                            <div class="mb-3">
                                                <label style="font-weight:600">Email address</label>
                                                <input type="email"  id="email" placeholder="Email Address" class="p-2 w-100" style="border-radius:0px;border:1px solid grey;" value="<?php echo $row['email'];?>">
                                            </div>
                                        </div>
                                        <div class="d-50">
                                            <div class="mb-3">
                                                <label style="font-weight:600">School ID</label>
                                                <input type="text"  id="school_id" placeholder="School ID" class="p-2 w-100" style="border-radius:0px;border:1px solid grey;" value="<?php echo $row['school_id'];?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label style="font-weight:600">Department</label>
                                                <input type="text"  id="dept" placeholder="Department" class="p-2 w-100" style="border-radius:0px;border:1px solid grey;" value="<?php echo $row['dept'];?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label style="font-weight:600">Faculty</label>
                                                <input type="email"  id="faculty" placeholder="Faculty" class="p-2 w-100" style="border-radius:0px;border:1px solid grey;" value="<?php echo $row['faculty'];?>" readonly>
                                            </div>
                                            
                                        </div>

                                    </div>
                                    <div class="mb-3">
                                    <label style="font-weight:600">Current level</label>
                                    <select id="level" class="p-2 w-100" style="border-radius:0px;border:1px solid grey;">
                                        
                      <option><?php echo $row['level'];?></option>
                      <?php if ($row['level'] === '100') { ?>
                        <option>200</option>
                            <option>300</option>
                            <option>400</option>
                            <option>500</option>
                        <?php }else if ($row['level'] === '200') { ?>
                            <option>100</option>
                            <option>300</option>
                            <option>400</option>
                            <option>500</option>
                        <?php } else if($row['level'] === '300') { ?>
                            <option>100</option>
                            <option>200</option>
                            <option>400</option>
                            <option>500</option>
                        <?php } else if ($row['level'] === '400') { ?>
                            <option>100</option>
                            <option>200</option>
                            <option>300</option>
                            <option>500</option>
                        <?php } else if ($row['level'] === '500') { ?>
                            <option>100</option>
                            <option>200</option>
                            <option>300</option>
                            <option>400</option>
                        <?php } ?>
                    </select>
                        </div>

                  
                                
                                        <button class="btn btn-primary p-2  mb-4 btn-sm"  id="update-btn" >Update</button>
                                        <center><span class="msg2"></span></center>
                                    </form>
               
                </div>
            </div>
        </div>
    </div>

    <script src="../../assets/js/main.js"></script>
<script>
        
        // Close the dropdown if the user clicks outside of it
        window.addEventListener('click', function(event) {
          if (!event.target.matches('.dropbtn')) {
            const myDropdown = document.getElementById('myDropdown');
            if (myDropdown.classList.contains('show')) {
              myDropdown.classList.remove('show');
            }
          }
        });
        
</script>
<script>
const update_btn = document.getElementById("update-btn");
update_btn.addEventListener("click", async () => {
  const fname = document.getElementById("fname").value;
  const lname = document.getElementById("lname").value;
  const email = document.getElementById("email").value;
  const school_id = document.getElementById("school_id").value;
  const dept = document.getElementById("dept").value;
  const faculty = document.getElementById("faculty").value;
  const level = document.getElementById("level").value;
  const msg2 = document.querySelector('.msg2');

  const formData = new FormData();
  formData.append('update-btn', 1);
  formData.append('fname', fname);
  formData.append('lname', lname);
  formData.append('email', email);
  formData.append('school_id', school_id);
  formData.append('dept', dept);
  formData.append('faculty', faculty);
  formData.append('level', level);

  
  // Disable the button when the request is initiated
  update_btn.disabled = true;

  try {
    const response = await axios.post("../functions/update.inc.php", formData);
    
    if (response.data.error) {
      msg2.innerHTML = "<div class='alert alert-danger' >" + response.data.error + "</div>";
    } else if (response.data.success) {
        msg2.innerHTML = "<div class='alert alert-success' >" + response.data.success + "</div>";
    }
  } catch (error) {
      console.error(error);
      msg2.innerHTML = "<div class='alert alert-danger' >An error occurred. </div>";
  } 
  
  finally {
    update_btn.disabled = false;
  }
})

//update image
const form = document.querySelector('#form');
const msg1 = document.querySelector('.msg1');
let update_img_btn = document.getElementById('update-img-btn'); // Change 'const' to 'let'
form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const form_Data = new FormData(form);
    
    update_img_btn = true;

    try {
        const response = await axios.post("../functions/updateimg.inc.php", form_Data);

        if (response.data.error) {
            msg1.innerHTML = `<div class="alert alert-danger w-100" style='border-radius:0px;'>${response.data.error}</div>`;
        } else if (response.data.success) {
            msg1.innerHTML = `<div class="alert alert-success w-100" style='border-radius:0px;'>${response.data.success}</div>`;
        }
    } catch (error) {
        console.error(error);
        msg1.innerHTML = `<div class="alert alert-danger w-100" style='border-radius:0px;'>An error occurred. Please try again</div>`;
    } finally {
        update_img_btn = false;
    }
});

// File validation
document.getElementById("imgfile").addEventListener("change", function () {
    const file = this.files[0];
    const fileType = file.type;
    const match = ["image/jpeg", "image/png", "image/jpg", "image/webp"];
    if (!match.includes(fileType)) {
        alert("Sorry, only JPG, PNG, JPEG, and WEBP files are allowed");
        this.value = ""; // Clear the input field
        return false;
    }
});

</script>
</body>
</html>
<?php } else {
    header("Location: ../auth/login");
}
?>