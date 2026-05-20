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
        <nav class="navbar navbar-expand-lg navbar-light d-flex bg-white fixed-top py-3 px-3" style="justify-content:space-between;">
               <div class="d-flex">
                    <div ><i class="fas fa-align-left fs-4 me-3"  style="color:#0d2a45ff;" id="menu-toggle"></i></div>
                    <div><p class="display-6" style="font-size: large;font-weight:600;">Courses</p></div>
               </div> 
               <?php include 'includes/studentnavbar.php';?>
     
       
            <div class="container-fluid px-4 py-4">
            
     
                
                <div class=" mt-3 shadow-lg " style="overflow:hidden">
                        <div class="p-3 bg-white rounded  ">
                <!-- SEARCH MODAL -->
                    
                    <div class="modal fade modal-lg" id="myModal">
                        <div class="modal-dialog">
                        <div class="modal-content" style="border-radius: 0px ;">

                        
                        <div class="modal-header">
                            <p class="display-6" style="font-size:large;font-weight:600;">Search courses</p>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        
                        <div class="modal-body">
                            <form method="post" class="d-flex" onsubmit="return false">
                                <input type="text" id="search" class="w-100" placeholder="Enter course title or course code" style="padding: 5px;">
                                <input type="hidden" id="school_id_1" value="<?php echo $studentID;?>">
                                <button class="btn btn-primary " id="search-btn"><i class="fa fa-search"></i></button>
                            </form><br>
                            <span id="msg2"></span>      
                            <div id="searchResult"></div>        
                        </div>
                        </div>
                    </div>
                </div>
                <!-- END -->

                <!-- ADD COURSE MODAL -->
                    
                    <div class="modal fade modal-lg" id="courseAdd">
                        <div class="modal-dialog">
                            <div class="modal-content" style="border-radius: 0px ;">

                        
                        <div class="modal-header">
                            <p class="display-6" style="font-size:large;font-weight:600;">Add course</p>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        
                        <div class="modal-body">
                           
                        <form class="forms" onsubmit="return false" method="post">
                                                
                                                <div class="modal-body">
                                                    <div class="flexbox">
                                                        <div class="d-50">
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Course title</label>
                                                                        <select id="course_title" class="p-2 w-100" style="border:1px solid grey;" name="course_title">
                                                                        <option>--Select course title--</option>
                                                                        <?php
                                                                                $sql = "SELECT course_title FROM courses_tb WHERE dept = '{$dept}' AND level <= '{$level}' ORDER BY semester ASC";
                                                                                $result = mysqli_query($con, $sql);
                                                                                while($row = mysqli_fetch_assoc($result)) {
                                                                            ?>
                                                                                <option><?php echo $row['course_title'];?></option>
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                </div>
                                                                <div class=" mb-3">
                                                                <label style="font-weight:600">Course code</label>
                                                                <input type="text"  id="course_code" class="p-2 w-100" style="border:1px solid grey;" name="course_code" placeholder="Course code" readonly>
                                                                </div>
                                                                
                                                        </div>
                                                        <div class="d-50">
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Course unit</label>
                                                                    <input type="number" min="0"  id="course_unit" class="p-2 w-100" style="border:1px solid grey;" name="course_unit" placeholder="Course unit" readonly>
                                                                </div>
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Level</label>
                                                                    <input type="text"  id="level" name="level" class="p-2 w-100" style="border:1px solid grey;" placeholder="Level" readonly>
                                                                </div>
                                                        </div>
                                                     
                                                    </div>

                                                        <div class=" mb-3">
                                                            <label style="font-weight:600">Semester</label>
                                                            <input type="text"  id="semester" class="p-2 w-100" style="border:1px solid grey;" name="semester" placeholder="Semester" readonly>
                                                        </div>
                                                        <div class=" mb-3">
                                                            <label style="font-weight:600">Session</label>
                                                            <input type="text" id="session" class="p-2 w-100" style="border:1px solid grey;" name="session" placeholder="previous year/current year">
                                                        </div>
                                                        <input type="hidden" id="school_id" value="<?php echo $studentID;?>">
                                                <input type="hidden" id="dept" value="<?php echo $dept;?>">
                                                <input type="hidden" id="faculty" value="<?php echo $faculty;?>">
                                                <input type="hidden" id="name" value="<?php echo $name;?>">
                                                <input type="hidden" id="studentlevel" value="<?php echo $level;?>">
                                                        <center><span class="msg"></span></center>
                                                </div>
 
                                                
                                                
                                                <button class="btn btn-primary " style="font-size:12px;"  id="course_reg_btn">Register</button>
                                                
                                        </form><br>     
                        </div>
                        </div>
                    </div>
                </div>
                <!-- END -->
                        <div>
                            <div class="d-flex" style="justify-content:space-between;">
                            <div><a href="#" class="btn btn-primary  mb-4" style="color:#fff;" data-bs-toggle="modal" data-bs-target="#myModal"><small><i class="fa fa-search"></i> Search</small></a></div>
                                <div><a href="#" class="btn btn-primary  mb-4" style="color:#fff;" data-bs-toggle="modal" data-bs-target="#courseAdd"><small><i class="fa fa-plus"></i></small></a></div>
                            </div>
                            <?php
                    $sql = "SELECT id, course_title, course_code, course_unit, level, is_dropped,session, semester, school_id FROM student_courses_tb WHERE school_id = '{$studentID}' ORDER BY level ASC";
                    $result = mysqli_query($con, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        $num = 1;
                ?>
                
          
                                    <div class="table-responsive">
                            <table class="table table-striped  table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">S/N</th>
                                            <th scope="col">Course Title</th>
                                            <th scope="col">Course Code</th>
                                            <th scope="col">Course Unit</th>
                                            <th scope="col">Dropped Status</th>
                                            <th scope="col">Level</th>
                                            <th scope="col">Session</th>
                                            <th scope="col">Semester</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                            
                                                
                                            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                                <tr>
                                                <td><?php echo $num++;?></td>
                                        <td ><?php echo $row['course_title'];?></td>
                                        <td><?php echo $row['course_code'];?></td>
                                        <td><?php echo $row['course_unit'];?></td>
                                        <td><?php if( $row['is_dropped'] === '0') {
                                                echo "<div class='bg-success text-white p-1  text-center'>Active</div>";
                                        } else {
                                                echo "<div class='bg-danger text-white p-1  text-center'>Dropped</div>";
                                            }
                                            ?></td>
                                        <td><?php echo $row['level'];?></td>
                                        <td><?php echo $row['session'];?></td>
                                        <td><?php echo $row['semester'];?></td>
                                        <td>
                                     <a href="viewcourses?id=<?php echo $row['id'];?>" class="btn btn-primary " style="font-size: 12px;">View</a>
                                            
                                        </td> 
                                        </tr>
                                            <?php } ?>
                                 
                                    
                                    
                                        
                                    </tbody>
                                    </table>
                                    </div>
                <?php

                    } else {
                ?>
                <div class="alert alert-danger p-3 w-100">Your registered courses will show here</div>
                <?php
                    }
                ?>
                            
                            </div>
                        </div>
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
<script src="../../assets/js/main.js"></script>
<script>
const course_reg_btn = document.getElementById('course_reg_btn');
const courseTitleSelect = document.getElementById('course_title');
const courseCode = document.getElementById('course_code');
const courseUnit = document.getElementById('course_unit');
const level = document.getElementById('level');
const semester = document.getElementById('semester');
const session = document.getElementById('session');
const school_id = document.getElementById('school_id');
const dept = document.getElementById('dept');
const faculty = document.getElementById('faculty');
const name = document.getElementById('name');
const studentlevel = document.getElementById('studentlevel');
const msg = document.querySelector('.msg');
courseTitleSelect.addEventListener('change', async function () {
//Fetch Course Info From Database
const formData = new FormData();
  formData.append('courseTitleSelect', courseTitleSelect.value);

  try {
    const response = await axios.post('../functions/get_courses.inc.php', formData);
    courseCode.value = response.data.coursecode
    courseUnit.value = response.data.courseunit
    level.value = response.data.level
    semester.value = response.data.semester
  } catch (error) {
      console.error(error);
  } 
  
})

// Search course script 
const msg2 = document.getElementById('msg2');
const search_btn = document.getElementById("search-btn");
search_btn.addEventListener("click", async () => {
    const search = document.getElementById("search");
    const school_id_1 = document.getElementById("school_id_1");
    const searchResult = document.getElementById('searchResult');

        const formData = new FormData();
        formData.append('search-course-btn', 1);
        formData.append('school_id',  school_id.value);
        formData.append('search', search.value);

        // Disable the button when the request is initiated
        search_btn.disabled = true;

        try {
            const response = await axios.post('../functions/search.inc.php', formData);
            searchResult.innerHTML = response.data
        } catch (error) {
            console.error(error);
            msg2.innerHTML = "<div class='alert alert-danger' style=''>An error occurred. </div>";
        } finally {
            search_btn.disabled = false;
        }
});

//Register the course into the student course Database
course_reg_btn.addEventListener('click', async function () {
const formData = new FormData();
  formData.append('course_reg_btn', 1);
  formData.append('courseTitleSelect', courseTitleSelect.value);
  formData.append('courseCode', courseCode.value);
  formData.append('courseUnit', courseUnit.value);
  formData.append('level', level.value);
  formData.append('semester', semester.value);
  formData.append('session', session.value);
  formData.append('school_id', school_id.value);
  formData.append('dept', dept.value);
  formData.append('faculty', faculty.value);
  formData.append('name', name.value);
  formData.append('studentlevel', studentlevel.value);

    // Disable the button when the request is initiated
    course_reg_btn.disabled = true;

  try {
    const response = await axios.post('../functions/coursereg.inc.php', formData);
    if (response.data.error) {
      msg.innerHTML = "<div class='alert alert-danger'>" + response.data.error + "</div>";
    } else if (response.data.success) {
        msg.innerHTML = "<div class='alert alert-success'>" + response.data.success + "</div>";
    }
  } catch (error) {
      console.error(error);
      msg.innerHTML = "<div class='alert alert-danger'>An error occurred</div>";
  } 
  finally {
    course_reg_btn.disabled = false;
  }
  
})

   

</script>
</body>
</html>
<?php } else {
    header("Location: index");
}
?>