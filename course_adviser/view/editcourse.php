<?php
session_start();
if(isset($_SESSION['courseAdvisorID']) && isset($_GET['id'])) {
    require '../../configs/dbh.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - Course advisor</title>
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
                    <div><p class="display-6" style="font-size: large;font-weight:600;">Courses</p></div>
               </div> 
               <?php include 'includes/cousrseadvisornavbar.php';?>
     
       
            <div class="container-fluid px-4 py-4">
            
     
                
                <div class=" mt-3 shadow-lg " style="overflow:hidden">

                <?php 
                            $id = mysqli_real_escape_string($con, $_GET['id']);  
                            $sql = "SELECT id, course_title, course_code, course_unit, level, dept, semester  FROM courses_tb WHERE id = '{$id}'";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_assoc($result);
                        ?>        
                            

                        <div class="p-3 bg-white rounded  ">
                            <div class="d-flex" style="justify-content: space-between;">
                                <div>
                                    <p class="display-6" style="font-size: large;font-weight:600;">Edit course</p>
                                </div>
                                <div>
                                    <form method="post" onsubmit="return false;">
                                        <button id="delete-course-btn" class="btn btn-primary p-2 w-100" style="font-size: 12px;"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </div><br><br>

                        
            
 
                        <form class="forms" onsubmit="return false" method="post">
                                                
                                                <div class="modal-body">
                                                    <div class="flexbox">
                                                        <div class="d-50">
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Course title</label>
                                                                    <input type="text"  id="course_title" class="p-2 w-100" style="border:1px solid grey;" value="<?php echo $row['course_title'];?>">
                                                                </div>
                                                                <div class=" mb-3">
                                                                <label style="font-weight:600">Course code</label>
                                                                    <input type="text"  id="course_code" class="p-2 w-100" style="border:1px solid grey;"  value="<?php echo $row['course_code'];?>">
                                                                </div>
                                                                
                                                        </div>
                                                        <div class="d-50">
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Course unit</label>
                                                                    <input type="number" min="0"  id="course_unit" class="p-2 w-100" style="border:1px solid grey;" value="<?php echo $row['course_unit'];?>">
                                                                </div>
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Level</label>
                                                                    <select id="level"  class="p-2 w-100" style="border:1px solid grey;">
                                                                        <option><?php echo $row['level'];?></option>
                                                                        <?php if($row['level'] === '100') { ?>
                                                                            <option>200</option>
                                                                            <option>300</option>
                                                                            <option>400</option>
                                                                            <option>500</option>
                                                                        <?php } else if ($row['level'] === '200') {?>
                                                                            <option>100</option>
                                                                            <option>300</option>
                                                                            <option>400</option>
                                                                            <option>500</option>
                                                                        <?php } else if ($row['level'] === '300') {?>
                                                                            <option>100</option>
                                                                            <option>200</option>
                                                                            <option>400</option>
                                                                            <option>500</option>
                                                                        <?php } else if ($row['level'] === '400') {?>
                                                                            <option>100</option>
                                                                            <option>200</option>
                                                                            <option>300</option>
                                                                            <option>500</option>
                                                                        <?php } else if ($row['level'] === '500') {?>
                                                                            <option>100</option>
                                                                            <option>200</option>
                                                                            <option>300</option>
                                                                            <option>400</option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                        </div>
                                                     
                                                    </div>
                                                    <div class=" mb-3">
                                                                <label style="font-weight:600">Department</label>
                                                                <select id="dept"  class="p-2 w-100" style="border:1px solid grey;">
                                                                        <option><?php echo $row['dept'];?></option>
                                                                        <?php 
                                                                            $sql = "SELECT department FROM dept_faculty_tb WHERE department != '{$row['dept']}' AND faculty = '{$faculty}'";
                                                                            $result = mysqli_query($con, $sql);
                                                                            while ($row2 = mysqli_fetch_assoc($result)) {
                                                                        ?>
                                                                            <option><?php echo $row2['department'];?></option>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                        <div class=" mb-3">
                                                            <label style="font-weight:600">Semester</label>
                                                            <select id="semester"  class="p-2 w-100" style="border:1px solid grey;">
                                                                <option><?php echo $row['semester'];?></option>
                                                                <?php if ($row['semester'] === 'First Semester') { ?>
                                                                    <option>Second Semester</option>
                                                                <?php } else  if ($row['semester'] === 'Second Semester') { ?>
                                                                    <option>First Semester</option>
                                                                <?php } ?>
                                                                
                                                                
                                                            </select>
                                                            
                                                        </div>
                                                
                                                        <input type="hidden" id="course_id" value="<?php echo $row['id'];?>">

                                                        <center><span class="msg"></span></center>
                                                        
                                                </div>
 
                                                
                                                
                                                    <button class="btn btn-primary" id="course_update_btn" style="font-size: 12px;">Update</button>
                                                
                                        </form><br>   

                        </div>
                    </div>

                </div>
            </div>
        </div>
<script src="../../assets/js/main.js"></script>
<script>
// Update course script

const msg = document.querySelector('.msg');


const course_update_btn = document.getElementById("course_update_btn");
course_update_btn.addEventListener("click", async () => {
    const course_title = document.getElementById('course_title');
    const course_code = document.getElementById('course_code');
    const course_unit = document.getElementById('course_unit');
    const level = document.getElementById('level');
    const dept = document.getElementById('dept');
    const semester = document.getElementById('semester');
    const course_id = document.getElementById('course_id');


        const formData = new FormData();
        formData.append('course_update_btn', 1);
        formData.append('course_title', course_title.value);
        formData.append('course_code', course_code.value);
        formData.append('course_unit', course_unit.value);
        formData.append('level', level.value);
        formData.append('dept', dept.value);
        formData.append('semester', semester.value);
        formData.append('course_id', course_id.value);
        
        // Disable the button when the request is initiated
        course_update_btn.disabled = true;

        try {
            const response = await axios.post('../functions/updatecourse.inc.php', formData);
            
            if (response.data.error) {
                msg.innerHTML = "<div class='alert alert-danger' style='border-radius:0px;'>" + response.data.error + "</div>";
            } else if (response.data.success) {
                msg.innerHTML = "<div class='alert alert-success' style='border-radius:0px;'>" + response.data.success + "</div>";
            }
        } catch (error) {
            console.error(error);
            msg.innerHTML = "<div class='alert alert-danger' style='border-radius:0px;'>An error occurred. </div>";
        } 
        
        finally {
            course_update_btn.disabled = false;
        }


})

const delete_btn = document.getElementById('delete-course-btn');
delete_btn.addEventListener('click', async () => {
    const formData = new FormData();
    formData.append('delete-course-btn', 1);
    formData.append('Id', course_id.value);
    
    delete_btn.disabled = true;

    // Confirm deletion
        if (confirm('Are you sure you want to delete this course?')) {
            // Send an AJAX request to delete the course
            axios.post('../functions/delete.inc.php', formData ) // Include courseId in the data object
                .then(function (response) {
                    // Check if deletion was successful
                    if (response.data.success) {
                        // Remove the table row from the DOM
                        window.location = 'courses';
                    } else {
                        alert('Failed to delete the course.');
                    }
                })
                .catch(function (error) {
                    console.error('Error deleting course: ' + error);
                });
        }
        delete_btn.disabled = false;
})


</script>
</body>
</html>
<?php } else {
    header('Location: index');
}
?>
