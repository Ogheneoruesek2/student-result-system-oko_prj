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
                    <div ><i class="fas fa-align-left fs-4 me-3"  style="color:#0d2a45ff;" id="menu-toggle"></i></div>
                    <div><p class="display-6" style="font-size: large;font-weight:600;">Courses</p></div>
               </div> 
               <?php include 'includes/cousrseadvisornavbar.php';?>
     
       
            <div class="container-fluid px-4 py-4">
            
     
                
                <div class=" mt-3 shadow-lg " style="overflow:hidden">
                        <div class="p-3 bg-white   ">
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
                                <input type="hidden" id="faculty_1" value="<?php echo $faculty;?>">
                                <button class="btn btn-primary" id="search-btn" ><span class="text"><i class="fa fa-search"></i></span></button>
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
                                                                    <input type="text"  id="course_title" class="p-2 w-100" style="border-radius:0px;border:1px solid grey;">
                                                                </div>
                                                                <div class=" mb-3">
                                                                <label style="font-weight:600">Course code</label>
                                                                    <input type="text"  id="course_code" class="p-2 w-100" style="border-radius:0px;border:1px solid grey;">
                                                                </div>
                                                                
                                                        </div>
                                                        <div class="d-50">
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Course unit</label>
                                                                    <input type="number" min="0"  id="course_unit" class="p-2 w-100" style="border-radius:0px;border:1px solid grey;">
                                                                </div>
                                                                <div class=" mb-3">
                                                                    <label style="font-weight:600">Level</label>
                                                                    <select id="level"  class="p-2 w-100" style="border-radius:0px;border:1px solid grey;">
                                                                        <option>--Select level--</option>
                                                                        <option>100</option>
                                                                        <option>200</option>
                                                                        <option>300</option>
                                                                        <option>400</option>
                                                                        <option>500</option>
                                                                    </select>
                                                                </div>
                                                        </div>
                                                     
                                                    </div>
                                                    <div class=" mb-3">
                                                                <label style="font-weight:600">Department</label>
                                                                <select id="dept"  class="p-2 w-100" style="border-radius:0px;border:1px solid grey;">
                                                                        <option>--Select department--</option>
                                                                        <?php 
                                                                            $sql = "SELECT department FROM dept_faculty_tb WHERE faculty = '{$faculty}'";
                                                                            $result = mysqli_query($con, $sql);
                                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                        ?>
                                                                            <option><?php echo $row['department'];?></option>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                        <div class=" mb-3">
                                                            <label style="font-weight:600">Semester</label>
                                                            <select id="semester"  class="p-2 w-100" style="border-radius:0px;border:1px solid grey;">
                                                                <option>--Select Semester--</option>
                                                                <option>First Semester</option>
                                                                <option>Second Semester</option>
                                                            </select>
                                                        </div>
                                                        <input type="hidden" id="faculty_2" value="<?php echo $faculty;?>">
                                                        <center><span class="msg"></span></center>
                                                        
                                                </div>
 
                                                
                                                
                                                    <button class="btn btn-primary btm-sm" id="course-btn">Save</button>
                                                
                                        </form><br>     
                        </div>
                        </div>
                    </div>
                </div>
                <!-- END -->
                        <div>
                            <div class="d-flex" style="justify-content:space-between;">
                                <div><a href="#" class="btn btn-primary mb-4" style="color:#fff;" data-bs-toggle="modal" data-bs-target="#myModal"><small><i class="fa fa-search"></i> Search</small></a></div>
                                <div><a href="#" class="btn btn-primary mb-4" style="color:#fff;" data-bs-toggle="modal" data-bs-target="#courseAdd"><small><i class="fa fa-plus"></i></small></a></div>
                            </div>
                            <?php
                                $sql = "SELECT id, course_title, course_code, semester, course_unit, dept, level FROM courses_tb ORDER BY LEVEL, semester ASC";
                                $result = mysqli_query($con, $sql);
                                if(mysqli_num_rows($result) > 0) {
                                    $num = 1;
                                
                            ?>
                            <div class="table-responsive">
                            <table class="table table-striped  table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">S/N</th>
                                            <th scope="col">Course title</th>
                                            <th scope="col">Course code</th>
                                            <th scope="col">Course unit</th>
                                            <th scope="col">Dept</th>
                                            <th scope="col">Level</th>
                                            <th scope="col">Semester</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                
                                            
                                        <td><?php echo $num++;?></td>
                                        <td><?php echo $row['course_title'];?></td>
                                        <td><?php echo $row['course_code'];?></td>
                                        <td><?php echo $row['course_unit'];?></td>
                                        <td><?php echo $row['dept'];?></td>
                                        <td><?php echo $row['level'];?></td>
                                        <td><?php echo $row['semester'];?></td>
                                        <td><a href="editcourse?id=<?php echo $row['id'];?>" class="btn btn-primary" style="font-size: 12px;"><i class="fa fa-pencil"></i> Edit</a></td>

                                    </tr>
                                    <?php } ?>
                                        
                                    </tbody>
                                    </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="alert alert-danger" role="alert">
                                        Courses you added will show here
                                    </div>
                                <?php } ?>
                            
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    

<script src="../../assets/js/main.js"></script>
<script>
// Add course script  

const msg = document.querySelector('.msg');
const course_btn = document.getElementById("course-btn");
course_btn.addEventListener("click", async () => {
    const course_title = document.getElementById('course_title');
    const course_code = document.getElementById('course_code');
    const course_unit = document.getElementById('course_unit');
    const level = document.getElementById('level');
    const dept = document.getElementById('dept');
    const semester = document.getElementById('semester');
    const faculty = document.getElementById('faculty_2');

        const formData = new FormData();
        formData.append('course_btn', 1);
        formData.append('course_title', course_title.value);
        formData.append('course_code', course_code.value);
        formData.append('course_unit', course_unit.value);
        formData.append('level', level.value);
        formData.append('dept', dept.value);
        formData.append('semester', semester.value);
        formData.append('faculty', faculty.value);
        
        // Disable the button when the request is initiated
        course_btn.disabled = true;

        try {
            const response = await axios.post('../functions/addcourse.inc.php', formData);
            
            if (response.data.error) {
                msg.innerHTML = "<div class='alert alert-danger'>" + response.data.error + "</div>";
            } else if (response.data.success) {
                msg.innerHTML = "<div class='alert alert-success'>" + response.data.success + "</div>";
            }
        } catch (error) {
            console.error(error);
            msg.innerHTML = "<div class='alert alert-danger'> An error occurred. </div>";
        } 
        
        finally {
            course_btn.disabled = false;
        }
    

})

// Search course script  
const msg2 = document.getElementById('msg2');
const search_btn = document.getElementById("search-btn");
search_btn.addEventListener("click", async () => {
    const search = document.getElementById("search");
    const faculty = document.getElementById("faculty_1");
    const searchResult = document.getElementById('searchResult');

        const formData = new FormData();
        formData.append('search-course-btn', 1);
        formData.append('faculty',  faculty.value);
        formData.append('search', search.value);

        // Disable the button when the request is initiated
        search_btn.disabled = true;
        try {
            const response = await axios.post('../functions/search.inc.php', formData);
            searchResult.innerHTML = response.data
        } catch (error) {
            console.error(error);
            msg2.innerHTML = "<div class='alert alert-danger'>An error occurred. </div>";
        } finally {
            search_btn.disabled = false;
        }
    
});





</script>
</body>
</html>
<?php } else {
    header("Location: index");
}
?>