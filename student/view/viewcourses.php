<?php

session_start();
if(isset($_SESSION['studentID']) && isset($_GET['id'])) {
    require '../../configs/dbh.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - Student</title>
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
               <?php include 'includes/studentnavbar.php';?>
     
       
            <div class="container-fluid px-4 py-4">
            
     
                
                <div class=" mt-3 shadow-lg  " style="overflow:hidden">

                <?php 
                            $id = mysqli_real_escape_string($con, $_GET['id']);  
                            $sql = "SELECT id, course_title, course_code, 	is_dropped, course_unit, level, session, semester, school_id  FROM student_courses_tb WHERE id = '{$id}'";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_assoc($result);
                        ?>        
                            

                        <div class="p-3 bg-white  ">
                            <div class="d-flex" style="justify-content: space-between;">
                                <div>
                                    <p class="display-6" style="font-size: large;font-weight:600;">Course information</p>
                                </div>
                                <div>
                                    <form method="post" onsubmit="return false;">
                                        <button id="delete-course-btn" class="btn btn-primary p-2"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </div><br><br>

                        
            
 
                        <form class="forms" onsubmit="return false" method="post">
                                                
                                                <div class="modal-body">
                                                    <div class="flexbox">
                                                        <div class="d-50">
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Course title</label>
                                                                    <input type="text"  id="course_title" class="p-2 w-100" style="border-radius:0px;border:1px solid grey;" value="<?php echo $row['course_title'];?>" readonly>
                                                                </div>
                                                                <div class=" mb-3">
                                                                <label style="font-weight:600">Course code</label>
                                                                    <input type="text"  id="course_code" class="p-2 w-100" style="border-radius:0px;border:1px solid grey;"  value="<?php echo $row['course_code'];?>" readonly>
                                                                </div>
                                                                
                                                        </div>
                                                        <div class="d-50">
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Course unit</label>
                                                                    <input type="number" min="0"  id="course_unit" class="p-2 w-100" style="border-radius:0px;border:1px solid grey;" value="<?php echo $row['course_unit'];?>" readonly>
                                                                </div>
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Level</label>
                                                                    <input type="number" min="0"  id="course_unit" class="p-2 w-100" style="border-radius:0px;border:1px solid grey;" value="<?php echo $row['level'];?>" readonly>

                                                                </div>
                                                        </div>
                                                     
                                                    </div>
                                          
                                                        <div class=" mb-3">
                                                            <label style="font-weight:600">Semester</label>
                                                            <input type="text" class="p-2 w-100" style="border-radius:0px;border:1px solid grey;" value="<?php echo $row['semester'];?>" readonly>
                                                            
                                                        </div>
                                                        <div class=" mb-3">
                                                            <label style="font-weight:600">Session</label>
                                                            <input type="text"   id="session"  class="p-2 w-100" style="border-radius:0px;border:1px solid grey;" value="<?php echo $row['session']; ?>" readonly>
                                                        </div>
                                                        

                                                </div>
 
                                                
                                                <?php
                                                    if($row['is_dropped'] === '0') {
                                                ?>
                                                
                                                    <center><span class="msg"></span></center>
                                                    <input type="hidden" id="course_id" value="<?php echo $row['id'];?>">
                                                    <button class="btn btn-primary" style="font-size:12px;" id="drop_course_btn">Drop course</button>
                                                <?php
                                                    } else {
                                                ?>
                                                    <center><span class="msg2"></span></center>
                                                    <input type="hidden" id="course_id2" value="<?php echo $row['id'];?>">
                                                    <button class="btn btn-primary" style="font-size:12px;" id="reg_course_btn">Register course</button>
                                                <?php
                                                    }
                                                ?>

                                                  
                                                
                                        </form><br>   

                        </div>
                    </div>

                </div>
            </div>
        </div>
<script>
//Register Course

const reg_course_btn = document.getElementById("reg_course_btn");
const drop_course_btn = document.getElementById("drop_course_btn");

if(drop_course_btn === null) {
reg_course_btn.addEventListener("click", async () => {

    const course_id2 = document.getElementById('course_id2');
    const msg2 = document.querySelector('.msg2');
    const msgerror2 = document.querySelector('.msgerror2');

        msg2.style.display = 'none';
        msgerror2.style.display = "block";
        const formData = new FormData();
        formData.append('reg_course_btn', 1);
        formData.append('course_id', course_id2.value);
        
        // Disable the button when the request is initiated
        reg_course_btn.disabled = true;

        try {
            const response = await axios.post('../functions/updatecourse.inc.php', formData);
            if (response.data.error) {
                msgerror2.innerHTML = "<div class='alert alert-danger'>" + response.data.error + "</div>";
            } else if (response.data.success) {
                msgerror2.innerHTML = "<div class='alert alert-success'>" + response.data.success + "</div>";
            }
        } catch (error) {
            console.error(error);
            msgerror2.innerHTML = "<div class='alert alert-danger'>An error occurred. </div>";
        }  finally {
            reg_course_btn.disabled = false;
        }
})
} else {
    
// Drop course script
drop_course_btn.addEventListener("click", async () => {

    const course_id = document.getElementById('course_id');
    const msg = document.querySelector('.msg');
    const msgerror = document.querySelector('.msgerror');

        msg.style.display = 'none';
        msgerror.style.display = "block";
        const formData = new FormData();
        formData.append('drop_course_btn', 1);
        formData.append('course_id', course_id.value);
        
        // Disable the button when the request is initiated
        drop_course_btn.disabled = true;

        try {
            const response = await axios.post('../functions/updatecourse.inc.php', formData);
            if (response.data.error) {
                msgerror.innerHTML = "<div class='alert alert-danger'>" + response.data.error + "</div>";
            } else if (response.data.success) {
                msgerror.innerHTML = "<div class='alert alert-success'>" + response.data.success + "</div>";
            }
        } catch (error) {
            console.error(error);
            msgerror.innerHTML = "<div class='alert alert-danger'>An error occurred. </div>";
        }  finally {
            drop_course_btn.disabled = false;
        }
})

}

//delete
const delete_btn = document.getElementById('delete-course-btn');
delete_btn.addEventListener('click', async () => {
    const formData = new FormData();
    formData.append('delete-course-btn', 1);
    formData.append('courseId', course_id.value);
    
    delete_btn.disabled = true;
    

    // Confirm deletion
        if (confirm('Are you sure you want to delete this course?')) {
            try {
            const response = await axios.post('../functions/delete_course.inc.php', formData);
            if (response.data.success === true) {
                window.location = 'courses'
            } else if (response.data.error) {
                alert(response.data.error);
            }
        }  catch (error) {
            console.error(error);
        }  finally {
            delete_btn.disabled = false;
        }
    }
        
})


</script>
</body>
</html>
<?php } else {
    header('Location: index');
}
?>
