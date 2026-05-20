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
    <title>Results - Course advisor</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="shortcut icon" href="../../assets/img/logo_img.png" type="image/x-icon">
    <?php include 'includes/scripts.php';?>
</head>
<body >
  <div class="preloader"></div>
<div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php';?>
        <!-- /#sidebar-wrapper --> 
        <!-- Page Content -->
        <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light d-flex bg-white fixed-top py-3 px-3" style="justify-content:space-between;">
               <div class="d-flex">
                    <div><i class="fas fa-align-left fs-4 me-3" style="color:#0d2a45ff;" id="menu-toggle"></i></div>
                    <div><p class="display-6" style="font-size: large;font-weight:600;">Results</p></div>
               </div> 
               <?php include 'includes/cousrseadvisornavbar.php';?>
     
       
            <div class="container-fluid px-4 py-4">
            
     
                
                <div class=" mt-3 shadow-lg bg-white " style="overflow: hidden;">
                        <div class="p-3   " >
                                    <?php 
                            $id = mysqli_real_escape_string($con, $_GET['id']);  
                            $sql = "SELECT id, course_title, course_code, course_unit, semester, session, level, ca, obj, q1, q2, q3, q4, q5, q6, school_id  FROM results_tb WHERE id = '{$id}'";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_assoc($result);
                            
                            
                        ?>
                        <div class="d-flex" style="justify-content: space-between;">
                            <div><p class="display-6" style="font-size: large;font-weight:600;">Update result </p></div>
                            <div>
                            <form method="post" onsubmit="return false;">
                                                                    <input type="hidden" id="Id" value="<?php echo $row['id'];?>">
                                                                    <input type="hidden" id="studentID" value="<?php echo $row['school_id'];?>">
                                                                    <button class="btn btn-danger p-2" id="delete-result-btn" style="border-radius:0px;font-size: 12px;"><i class="fa fa-trash"></i></button>
                                                                </form>
                            </div>
                        </div><br><br>
                        


                       
                                             <form class="forms" onsubmit="return false" method="post">
                                                <!-- Modal body -->
                                                
                                                    <div class="flexbox">
                                                        <div class="d-50">
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Course title</label><br>
                                                                    <input type="text" id="course_title" class="p-2 w-100 " style="border-radius:0px;border:1px solid grey;" value="<?php echo $row['course_title'];?>" readonly>
                                                                </div>
                                                                <div class=" mb-3">
                                                                <label style="font-weight:600">Course code</label>
                                                                    <input type="text"  id="course_code" class="p-2 w-100 " style="border-radius:0px;border:1px solid grey;" value="<?php echo $row['course_code'];?>" readonly>
                                                                </div>
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Course unit</label>
                                                                    <input type="number" min="0"  id="course_unit" class="p-2 w-100 " style="border-radius:0px;border:1px solid grey;" value="<?php echo $row['course_unit'];?>" readonly>
                                                                </div>
                                                                
                                                        </div>
                                                        <div class="d-50">
                                                             
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Semester</label>
                                                                    <input type="text" id="semester" class="p-2 w-100 " style="border-radius:0px;border:1px solid grey;" value="<?php echo $row['semester'];?>" readonly>
                                                                </div>
                                                                
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Session</label>
                                                                    <input type="text" id="session" class="p-2 w-100 " style="border-radius:0px;border:1px solid grey;" value="<?php echo $row['session'];?>" readonly>
                                                                </div>
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Level</label>
                                                                    <input type="text" id="level" class="p-2 w-100 " style="border-radius:0px;border:1px solid grey;" value="<?php echo $row['level'];?>" readonly>
                                                                </div>
                                                     
                                                    </div>
                                                  

                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label style="font-weight:600">CA Score</label>
                                                        <input type="number" min="0" class="form-control numeric-input w-100 " style="border-radius:0px;border:1px solid grey;" id="ca" placeholder="Enter Score" value="<?php echo $row['ca'];?>" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label style="font-weight:600">Objectives Score</label>
                                                        <input type="number" min="0" class="form-control numeric-input w-100 " style="border-radius:0px;border:1px solid grey;" id="obj" placeholder="Enter Score" value="<?php echo $row['obj'];?>" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label style="font-weight:600">Question 1</label>
                                                        <input type="number" min="0" class="form-control numeric-input w-100 " style="border-radius:0px;border:1px solid grey;" id="q1" placeholder="Enter Score" value="<?php echo $row['q1'];?>" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label style="font-weight:600">Question 2</label>
                                                        <input type="number" min="0" class="form-control numeric-input w-100 " style="border-radius:0px;border:1px solid grey;" id="q2" placeholder="Enter Score" value="<?php echo $row['q2'];?>" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label style="font-weight:600">Question 3</label>
                                                        <input type="number" min="0" class="form-control numeric-input w-100 " style="border-radius:0px;border:1px solid grey;" id="q3" placeholder="Enter Score" value="<?php echo $row['q3'];?>" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label style="font-weight:600">Question 4</label>
                                                        <input type="number" min="0" class="form-control numeric-input w-100 " style="border-radius:0px;border:1px solid grey;" id="q4" placeholder="Enter Score"  value="<?php echo $row['q4'];?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label style="font-weight:600">Question 5</label>
                                                        <input type="number" min="0" class="form-control numeric-input w-100 " style="border-radius:0px;border:1px solid grey;" id="q5" placeholder="Enter Score"  value="<?php echo $row['q5'];?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label style="font-weight:600">Question 6</label>
                                                        <input type="number" min="0" class="form-control numeric-input w-100 " style="border-radius:0px;border:1px solid grey;" id="q6" placeholder="Enter Score" value="<?php echo $row['q6'];?>">
                                                    </div>
                                                        <input type="hidden" id="id-course" value="<?php echo $row['id'];?>">
                                                        <input type="hidden" id="student-id" value="<?php echo $row['school_id'];?>">
                                                        <input type="hidden" id="course_unit" value="<?php echo $row['course_unit'];?>">

                                                        
                                                        <center><span class="msg"></span></center>
                                                        
                                                            <div><button class="btn btn-danger" style="border-radius: 0px;font-size:12px;"  id="update_course_result_btn" style="font-size: 12px;">Update</button></div>
                                                       
                                                        </div>
                                                    
                                                
                                        </form><br>  
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

<script src="../../assets/js/main.js"></script>
<script>


    //Result Informations
    const course_id = document.getElementById("id-course");
    const obj = document.getElementById("obj");
    const q1 = document.getElementById("q1");
    const q2 = document.getElementById("q2");
    const q3 = document.getElementById("q3");
    const q4 = document.getElementById("q4");
    const q5 = document.getElementById("q5");
    const q6 = document.getElementById("q6");
    const ca = document.getElementById("ca");
    const school_id = document.getElementById('student-id');
    const course_unit =document.getElementById("course_unit");
    const msg = document.querySelector('.msg');



    //default value of the input scores sets to 0
    const inputFields = document.querySelectorAll('.numeric-input');
        inputFields.forEach(function (input) {
            input.value = input.value || 0; // Set the default value to 0 if empty
            input.addEventListener('blur', function () {
                if (input.value.trim() === '') {
                    input.value = 0; // Change empty value to 0 on blur
                }
            });
        });

    
    const update_course_btn = document.getElementById("update_course_result_btn")
    update_course_result_btn.addEventListener("click", async function () {
    
        const formData = new FormData();
        formData.append('update_course_result_btn', 1);
        formData.append('course_id', course_id.value);
        formData.append('obj', obj.value);
        formData.append('q1', q1.value);
        formData.append('q2', q2.value);
        formData.append('q3', q3.value);
        formData.append('q4', q4.value);
        formData.append('q5', q5.value);
        formData.append('q6', q6.value);
        formData.append('ca', ca.value);
        formData.append('school_id', school_id.value);
        formData.append('course_unit', course_unit.value);
        

        update_course_result_btn.disabled = true;

        try {
            const response = await axios.post('../functions/update_result.inc.php', formData);
            if (response.data.error) {
                msg.innerHTML = "<div class='alert alert-danger' style='border-radius:0px;'>" + response.data.error + "</div>";
            } else if (response.data.success) {
                msg.innerHTML = "<div class='alert alert-success' style='border-radius:0px;'>" + response.data.success + "</div>";
            }
        } catch (error) {
            console.error(error);
            msg.innerHTML = "<div class='alert alert-danger' style='border-radius:0px;'>An error occurred. </div>";
        }  finally {
            update_course_result_btn.disabled = false;
        }

    })

//Delete result
const courseID = document.getElementById("Id").value;
const studentID = document.getElementById("studentID").value;

const delete_course_btn = document.getElementById("delete-result-btn");
delete_course_btn.addEventListener("click", async function() {
   

    const formData = new FormData();
    formData.append('delete-result-btn', 1);
    formData.append('Id', courseID);
    formData.append('school_id', studentID);

    //Confirm Deletion
    if(confirm('Are you sure you want to delete this result?')) {
        
        delete_course_btn.disabled = true;
        try {
            const response = await axios.post('../functions/delete.inc.php', formData);
            if (response.data.error) {
                alert(response.data.error);
            } else if (response.data.success) {
                window.location = 'manageresults';
            }
        } catch (error) {
            console.error(error);
        }  finally {
            delete_course_btn.disabled = false;
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
