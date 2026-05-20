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
    <?php include '../../includes/links&scripts.php'; ?>
</head>
<body>
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
            
     
                
                <div class=" mt-3 shadow-lg ">
                        <div class="p-3 bg-white   ">
                        <?php 
                            $id = mysqli_real_escape_string($con, $_GET['id']);  
                            $sql = "SELECT id, fname, lname, email, image, school_id, dept, faculty, level FROM students_tb WHERE id = '{$id}'";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_assoc($result);
                            
                        ?>
                        <p class="display-6" style="font-size: large;font-weight:600;">Result computation </p><br><br>

                        <div class="flexbox mt-4 mb-4">
        <div class="d-50">
        <br><br><br>
        <center>
            <div class="passport-photo">
                <img src="../../uploads/students/<?php if($row['image'] === null) { echo 'default_img.jpg';} else { echo $row['image'];}?>" alt="student_img" style="border-radius:50%;">
            </div>
            </center>
        </div>
        <div class="d-50"><br><br><br>
        <p><b>Name:</b> <?php echo $row['fname'] . ' ' . $row['lname'];?></p>
        <p><b>Email Address:</b> <?php echo $row['email'];?></p>
        <p><b>School ID:</b> <?php echo strtoupper($row['school_id']);?></p>
        <p><b>Department:</b> <?php echo $row['dept'];?></p>
        <p><b>Faculty:</b> <?php echo $row['faculty'];?></p>
        <p><b>Level:</b> <?php echo $row['level'];?></p>
        <p><b>CGPA</b>:
        <?php
        $school_id = $row['school_id'];
        $sql = "SELECT school_id FROM results_tb WHERE school_id = '{$school_id}' AND status = 'approved'";
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result) > 0) {
            $sql1 = "SELECT SUM(quality_points) AS total_quality_points  FROM results_tb WHERE school_id = '{$school_id}' AND status = 'approved'";
            $result1 = mysqli_query($con, $sql1);
            $row1 = mysqli_fetch_assoc($result1);
            $total_quality_points = $row1['total_quality_points'];
    
            //Sum of total course unit
            $sql2 = "SELECT SUM(course_unit) AS total_course_unit FROM results_tb WHERE school_id = '{$school_id}' AND status = 'approved'";
            $result2 = mysqli_query($con, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $total_course_unit = $row2['total_course_unit'];
            
    
    
    
            $cgpa = (float)((float)$total_quality_points / (float)$total_course_unit);
            if ($cgpa >= 4.50 && $cgpa <= 5.00) {
                echo number_format($cgpa, 2) . ' ' . '<br><br><b>Position:</b> First Class';
          } else if ($cgpa >= 3.50 && $cgpa <= 4.49) {
               echo number_format($cgpa, 2) . ' ' . '<br><br><b>Position:</b> Second Class Upper';
          } else if ($cgpa >= 2.50 && $cgpa <= 3.49) {
               echo number_format($cgpa, 2) . ' ' . '<br><br><b>Position:</b> Second Class Lower';
          } else if ($cgpa >= 1.50 && $cgpa <= 2.49) {
               echo number_format($cgpa, 2) . ' ' . '<br><br><b>Position:</b> Third Class';
          } else if ($cgpa >= 1.00 && $cgpa <= 1.49) {
               echo number_format($cgpa, 2) . ' ' . '<br><br><b>Position:</b> Pass';
          } else if ($cgpa <= 0.99) {
               echo number_format($cgpa, 2) . ' ' . '<br><br><b>Position:</b> On Probation';
          }
        } else {
            echo "0.00" . ' ' . '<br><br><b>Position:</b> No result yet';
        }

      
        ?>
        </p>

        </div>
        </div><br><br>
                            <?php
                                
                            ?>
                                             <form class="forms" onsubmit="return false" method="post">
                                                <!-- Modal body -->
                                                
                                                    <div class="flexbox">
                                                        <div class="d-50">
                                                                <div class=" mb-3">
                                                                    <?php
                                                                                $sql2 = "SELECT course_title, level, school_id, result_computed, is_dropped  FROM student_courses_tb WHERE school_id = '{$school_id}' AND result_computed = '0' AND is_dropped = '0'";
                                                                                $result2 = mysqli_query($con, $sql2);
                                                                                
                                                                                
                                                                    ?>
                                                                    <label style="font-weight:600">Course title</label><br>
                                                                    <small>Please note that only the courses registered by this student will be displayed here.</small>
                                                                    <select id="course_title" class="p-2 w-100 " style="border-radius:0px;border:1px solid grey;">

                                                                        <option>-- Select course title --</option>
                                                                        <?php
                                                                        
                                                                        if(mysqli_num_rows($result2) > 0) {
                                                                                while($row2 = mysqli_fetch_assoc($result2)) {
                                                                            ?>
                                                                                <option><?php echo $row2['course_title'];?></option>
                                                                            <?php
                                                                                }
                                                                        } else {
                                                                            echo "<option>No course registered</option>";
                                                                        }
                                                                            ?>
                                                                    </select>
                                                                </div>
                                                                <div class=" mb-3">
                                                                <label style="font-weight:600">Course code</label>
                                                                    <input type="text"  id="course_code" class="p-2 w-100 " style="border-radius:0px;border:1px solid grey;"  readonly>
                                                                </div>
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Course unit</label>
                                                                    <input type="number" min="0"  id="course_unit" class="p-2 w-100 " style="border-radius:0px;border:1px solid grey;" readonly>
                                                                </div>
                                                                
                                                        </div>
                                                        <div class="d-50">
                                                             
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Semester</label><br><br>

                                                                    <input type="text" id="semester" class="p-2 w-100 " style="border-radius:0px;border:1px solid grey;" readonly>
                                                                </div>
                                                                
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Session</label>
                                                                    <input type="text" id="session" class="p-2 w-100 " style="border-radius:0px;border:1px solid grey;" readonly>
                                                                </div>
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Level</label>
                                                                    <input type="text" id="level" class="p-2 w-100 " style="border-radius:0px;border:1px solid grey;" readonly>
                                                                </div>
                                                     
                                                    </div>
                                                  

                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label style="font-weight:600">CA Score</label>
                                                        <input type="number" min="0" class="form-control numeric-input w-100 " style="border-radius:0px;border:1px solid grey;" id="ca" placeholder="Enter Score" value="0">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label style="font-weight:600">Objectives Score</label>
                                                        <input type="number" min="0" class="form-control numeric-input w-100 " style="border-radius:0px;border:1px solid grey;" id="obj" placeholder="Enter Score" value="0">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label style="font-weight:600">Question 1</label>
                                                        <input type="number" min="0" class="form-control numeric-input w-100 " style="border-radius:0px;border:1px solid grey;" id="q1" placeholder="Enter Score" value="0">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label style="font-weight:600">Question 2</label>
                                                        <input type="number" min="0" class="form-control numeric-input w-100 " style="border-radius:0px;border:1px solid grey;" id="q2" placeholder="Enter Score" value="0">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label style="font-weight:600">Question 3</label>
                                                        <input type="number" min="0" class="form-control numeric-input w-100 " style="border-radius:0px;border:1px solid grey;" id="q3" placeholder="Enter Score" value="0">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label style="font-weight:600">Question 4</label>
                                                        <input type="number" min="0" class="form-control numeric-input w-100 " style="border-radius:0px;border:1px solid grey;" id="q4" placeholder="Enter Score" value="0">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label style="font-weight:600">Question 5</label>
                                                        <input type="number" min="0" class="form-control numeric-input w-100 " style="border-radius:0px;border:1px solid grey;" id="q5" placeholder="Enter Score" value="0">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label style="font-weight:600">Question 6</label>
                                                        <input type="number" min="0" class="form-control numeric-input w-100 " style="border-radius:0px;border:1px solid grey;" id="q6" placeholder="Enter Score" value="0">
                                                    </div>
                                                                <?php 
                                                                    $sql3 = "SELECT dept, level FROM student_courses_tb WHERE school_id = '{$school_id}' AND result_computed = '0'";
                                                                    $result3 = mysqli_query($con, $sql3);
                                                                    $row3 = mysqli_fetch_assoc($result3)
                                                                ?>
                                                        <input type="hidden" id="level" value="<?php echo $row3['level'];?>">
                                                        <input type="hidden" id="dept" value="<?php echo $row3['dept'];?>">
                                                        <input type="hidden" id="faculty" value="<?php echo $faculty;?>">
                                                        <input type="hidden" id="name" value="<?php echo $row['fname'] . " " . $row['lname'];?>">
                                                        <input type="hidden" id="school_id" value="<?php echo $school_id;?>">
                                                        
                                                        <center><span class="msg"></span></center>
                                                    <button class="btn btn-primary" id="upload_course_result_btn" style="font-size: 12px;">Save</button>
                                                
                                        </form><br>  
                            </div>
                        </div>
                    </div>

                </div>
            </div>


<script src="../../assets/js/main.js"></script>
<script>


    //Result Informations
    const name = document.getElementById("name");
    const school_id = document.getElementById("school_id");
    const course_title = document.getElementById("course_title");
    const course_code = document.getElementById("course_code");
    const course_unit = document.getElementById("course_unit");
    const level = document.getElementById("level");
    const dept = document.getElementById("dept");
    const faculty = document.getElementById("faculty");
    const semester = document.getElementById("semester");
    const session = document.getElementById("session");
    const obj = document.getElementById("obj");
    const q1 = document.getElementById("q1");
    const q2 = document.getElementById("q2");
    const q3 = document.getElementById("q3");
    const q4 = document.getElementById("q4");
    const q5 = document.getElementById("q5");
    const q6 = document.getElementById("q6");
    const ca = document.getElementById("ca");
    const msg = document.querySelector('.msg');

    //Shows other details as the course title changes                                                                                
    course_title.addEventListener("change", async function () {
          // Fetch Course Info From Database
        const formData = new FormData();
        formData.append('course_title', course_title.value);
        formData.append('school_id', school_id.value);

        try {
            const response = await axios.post('../functions/get_student_courses.inc.php', formData);
            // course_title.value = response.course_title.value;
            if(response.data.error) {
                alert(response.data.error);
                course_code.value = '';
                course_unit.value = '';
                level.value = '';
                semester.value = '';
                session.value = '';
            } else {
                course_code.value = response.data.course_code;
                course_unit.value = response.data.course_unit;
                level.value = response.data.level;
                semester.value = response.data.semester;
                session.value = response.data.session;
            }
        } catch (error) {
            console.error(error);
        }
    })

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

    
    const upload_course_result_btn = document.getElementById("upload_course_result_btn")
    upload_course_result_btn.addEventListener("click", async function () {
    
        const formData = new FormData();
        formData.append('upload_course_result_btn', 1);
        formData.append('name', name.value);
        formData.append('course_title', course_title.value);
        formData.append('course_code', course_code.value);
        formData.append('course_unit', course_unit.value);
        formData.append('level', level.value);
        formData.append('dept', dept.value);
        formData.append('faculty', faculty.value);
        formData.append('school_id', school_id.value)
        formData.append('semester', semester.value);
        formData.append('session', session.value);
        formData.append('obj', obj.value);
        formData.append('q1', q1.value);
        formData.append('q2', q2.value);
        formData.append('q3', q3.value);
        formData.append('q4', q4.value);
        formData.append('q5', q5.value);
        formData.append('q6', q6.value);
        formData.append('ca', ca.value);
        

        upload_course_result_btn.disabled = true;

        try {
            const response = await axios.post('../functions/upload-result.inc.php', formData);
            if (response.data.error) {
                msg.innerHTML = "<div class='alert alert-danger'>" + response.data.error + "</div>";
            } else if (response.data.success) {
                msg.innerHTML = "<div class='alert alert-success'>" + response.data.success + "</div>";
            }
        } catch (error) {
            console.error(error);
            msg.innerHTML = "<div class='alert alert-danger'>An error occurred. </div>";
        }  finally {
            upload_course_result_btn.disabled = false;
        }

    })





</script>
</body>
</html>
<?php } else {
    header('Location: index');
}
?>
