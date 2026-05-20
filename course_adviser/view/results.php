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
    <title>Add results - Course advisor</title>
    <?php include '../../includes/links&scripts.php'; ?>
</head>
<body >
  <div class="preloader"></div>
<div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php';?>
        <!-- /#sidebar-wrapper --> 
        <!-- Page Content -->
        <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light d-flex bg-white  fixed-top py-3 px-3" style="justify-content:space-between;">
               <div class="d-flex">
                    <div><i class="fas fa-align-left fs-4 me-3" style="color:#0d2a45ff;" id="menu-toggle"></i></div>
                    <div><p class="display-6" style="font-size: large;font-weight:600;">Results</p></div>
               </div> 
               <?php include 'includes/cousrseadvisornavbar.php';?>
     
            <div class="container-fluid px-4 py-4">
            <div class="bg-white sm p-3 ">
            <div class="d-flex text-dark" style="justify-content:center;align-items:center;">
        <div class=" p-4 div-content " id="login-form" >
                        <form method="post" class="mb-5 " onsubmit="return false">
                        <span id="msg"></span> 
<div class="mb-3">
                        <label style="font-weight:600">Level</label>
                        <select id="level" class="rounded p-2" style="border-radius: 0px !important;">
                                <option>--Select level--</option>
                                <option>100</option>
                                <option>200</option>
                                <option>300</option>
                                <option>400</option>
                                <option>500</option>
                        </select>
                        </div>
                        
                        <label style="font-weight:600">Department</label>
                        <select id="dept" class="rounded p-2" style="border-radius: 0px !important;">
                                <option>--Select department--</option>
                                <?php 
                                    $sql = "SELECT department, faculty FROM dept_faculty_tb WHERE faculty = '{$faculty}'";
                                    $result = mysqli_query($con, $sql);
                                    while($row = mysqli_fetch_array($result)) {
?>
<option><?php echo $row['department']; ?></option>
<?php
                                    }
                                ?>
                        </select><br><br>
                        <input type="hidden" id="faculty" value="<?php echo $faculty;?>">
                        <button class="btn btn-primary p-2" style="font-size: 12px;"  id="add_result_category_btn" style="font-size:12px;">Proceed</button><br><br>
                          
                        </form>
        </div>
                </div>
                        </div>

            </div>
        </div>
    </div>

<script src="../../assets/js/main.js"></script>
<script>

const msg = document.getElementById('msg');
const add_result_category_btn = document.getElementById("add_result_category_btn");

add_result_category_btn.addEventListener("click", async () => {
    const level = document.getElementById("level");
    const dept = document.getElementById("dept");
    const faculty = document.getElementById("faculty");
        const formData = new FormData();
        formData.append('add_result_category_btn', 1);
        formData.append('faculty',  faculty.value);
        formData.append('level', level.value);
        formData.append('dept', dept.value);

        // Disable the button when the request is initiated
        add_result_category_btn.disabled = true;

        try {
            const response = await axios.post('../functions/get-result.inc.php', formData);
            if(response.data.success === true) {
                window.location = "addresults";
            } else if(response.data.error) {
                msg.innerHTML = "<div class='alert alert-danger text-center' style='border-radius:0px;'>" + response.data.error + "</div>";
            }
        } catch (error) {
            console.error(error);
            msg.innerHTML = "<div class='alert alert-danger' style='border-radius:0px;'>An error occurred</div>";
        } finally {
            add_result_category_btn.disabled = false;
        }
    })
</script>
</body>
</html>
<?php } else {
    header("Location: index");
}
?>