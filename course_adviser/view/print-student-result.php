<?php
session_start();
if(isset($_SESSION['courseAdvisorID'])) {
    require '../../configs/dbh.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Result - Course Advisor </title>
    <?php include '../../includes/links&scripts.php'; ?>
</head>
<body >
<div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php';?>
        <!-- /#sidebar-wrapper --> 
        <!-- Page Content -->
        <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light d-flex bg-white fixed-top py-3 px-3" style="justify-content:space-between;">
               <div class="d-flex">
                    <div><i class="fas fa-align-left fs-4 me-3" style="color:#0d2a45ff;" id="menu-toggle"></i></div>
                    <div><p class="display-6" style="font-size: large;font-weight:600;">Print result</p></div>
               </div> 
               <?php include 'includes/cousrseadvisornavbar.php';?>
           
            <div class="container-fluid px-4 py-4">
            <div class=" mt-3 shadow-lg bg-white p-3 " style="overflow:hidden">
                <p class="display-6" style="font-size:large;font-weight:600;">Result Category</p>
                <form method="post" onsubmit="return false;">
                            
                            <div class="mb-3">
                                <label style="font-weight:600">Level</label>
                                <select id="level" class=" p-2 w-100" style="border-radius:0px;border:1px solid grey;">
                                    <option>-- Select level --</option>
                                    <option>100</option>
                                    <option>200</option>
                                    <option>300</option>
                                    <option>400</option>
                                    <option>500</option>
                                </select>
                            </div>
                            <div class="mb-3">
                            <label style="font-weight:600">Semester</label>
                            <select id="semester" class=" p-2 w-100" style="border-radius:0px;border:1px solid grey;">
                                    <option>-- Select semester --</option>
                                    <option>First Semester</option>
                                    <option>Second Semester</option>
                                </select>

                            </div>
                            <div class="mb-3">
                            <label style="font-weight:600">Department</label>
                            <select id="dept" class=" p-2 w-100" style="border-radius:0px;border:1px solid grey;">
                                    <option>-- Select department --</option>
                                    <?php 
                                        $sql = "SELECT department FROM dept_faculty_tb WHERE faculty = '{$faculty}'";
                                        $result = mysqli_query($con, $sql);
                                        while($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <option><?php echo $row['department'];?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                                
                            </div>
                            <div class=" mb-3">
                                <label style="font-weight:600">Session</label>
                                <input type="text"  class=" p-2 w-100" style="border-radius:0px;border:1px solid grey;" id="session" placeholder="previous year/present year" >
                            </div>
                            <input type="hidden" value="<?php echo $faculty;?>" id="faculty">
                        <button class="btn btn-primary p-2  mb-4 "  id="print_btn" style="font-size: 12px;"><i class="fa fa-print"></i> Print</button>
                        <center><span class="msg"></span></center>
                    </form>


        </div>
    </div>
</div>
<script src="../../assets/js/main.js"></script>
<script>
//Semester result print
const msg = document.querySelector('.msg');
const print_btn = document.getElementById("print_btn");
print_btn.addEventListener("click", async () => {
  const level = document.getElementById("level").value;
  const semester = document.getElementById("semester").value;
  const faculty = document.getElementById("faculty").value;
  const dept = document.getElementById("dept").value;
  const session = document.getElementById("session").value;
  


  const formData = new FormData();
  formData.append('print_btn', 1);
  formData.append('level', level);
  formData.append('semester', semester);
  formData.append('faculty', faculty);
  formData.append('dept', dept);
  formData.append('session', session);

  
  // Disable the button when the request is initiated
  print_btn.disabled = true;

  try {
    const response = await axios.post("../functions/get-printed-results.inc.php", formData);
    
    if (response.data.error) {
      msg.innerHTML = "<div class='alert alert-danger'>" + response.data.error + "</div>";
    } else if (response.data.success === true) {
        window.location = "printed-result-by-semester";
    }
  } catch (error) {
      console.error(error);
      msg.innerHTML = "<div class='alert alert-danger'>An error occurred. </div>";
  } 
  
  finally {
    print_btn.disabled = false;
  }
})


</script>
</body>
</html>
<?php } else {
    header("Location: ../auth/login");
}
?>;