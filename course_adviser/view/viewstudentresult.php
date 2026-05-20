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
            
     
                
                <div class=" mt-3 shadow-lg bg-white">
                        <div class="p-3   " >
                        <?php 
                            $id = mysqli_real_escape_string($con, $_GET['id']);  
                            $sql = "SELECT id, fname, lname, email, school_id, dept, faculty, image, level FROM students_tb WHERE id = '{$id}'";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $student_name = $row['fname'];
                        ?>
                        <p class="display-6" style="font-size: large;font-weight:600;">View results </p><br><br>
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
    
    
<div class="flexbox">
    <div class="d-50">
    <p style="font-weight:600;">STUDENT OUTSTANDING COURSES</p>
        <?php
                      $sql = "SELECT id, course_title, course_code, course_unit, level FROM results_tb WHERE school_id = '{$school_id}' AND grade = 'F'";
                      $result = mysqli_query($con, $sql);
                      if(mysqli_num_rows($result) >0) {
                        $num = 1;
                    ?>
                        <table class="table table-striped table-borderless">
                        <thead>
                            <tr>
                            <th scope="col">S/N</th>
                            <th scope="col">Course Title</th>
                            <th scope="col">Course Code</th>
                            <th scope="col">Course Unit</th>
                            <th scope="col">Level</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
               
                                while($row = mysqli_fetch_array($result)) {
                        ?>
                            <tr>
                                <td><?php echo $num++;?></td>
                                <td><?php echo $row['course_title'];?></td>
                                <td><?php echo $row['course_code'];?></td>
                                <td><?php echo $row['course_unit'];?></td>
                                <td><?php echo $row['level'];?></td>
    
                          
                            </tr>
                            <?php } ?>
                        </tbody>
                        </table>
                        <?php
                      } else {
                        ?>
      <div class="alert alert-danger" role="alert">
                                        No outstanding courses for this student
                                    </div>
                        <?php
                      }

                      ?>
    </div>
    <div class="d-50">
    <p style="font-weight:600;">STUDENT DROP COURSES</p>
        <?php
                      $sql = "SELECT course_title, course_code, course_unit, level FROM student_courses_tb WHERE school_id = '{$school_id}' AND is_dropped = '1'";
                      $result = mysqli_query($con, $sql);
                      if(mysqli_num_rows($result) >0) {
                        $num = 1;
                    ?>
                        <table class="table table-striped table-borderless">
                        <thead>
                            <tr>
                            <th scope="col">S/N</th>
                            <th scope="col">Course Title</th>
                            <th scope="col">Course Code</th>
                            <th scope="col">Course Unit</th>
                            <th scope="col">Level</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
               
                                while($row = mysqli_fetch_array($result)) {
                        ?>
                            <tr>
                                <td><?php echo $num++;?></td>
                                <td><?php echo $row['course_title'];?></td>
                                <td><?php echo $row['course_code'];?></td>
                                <td><?php echo $row['course_unit'];?></td>
                                <td><?php echo $row['level'];?></td>
    
                          
                            </tr>
                            <?php } ?>
                        </tbody>
                        </table>
                        <?php
                      } else {
                        ?>
      <div class="alert alert-danger" role="alert">
                                        No drop courses for this student
                                    </div>
                        <?php
                      }

                      ?>
    </div>
</div>

   

<br><br>
<p style="font-weight:600;">STUDENT RESULT TABLE</p>     
<?php
    $sql = "SELECT id, course_title, course_code, course_unit, level, total, grade, status, school_id FROM results_tb WHERE school_id = '{$school_id}' ORDER BY level";
    $result = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        $num = 1;
    
?>  
                <!-- SEARCH MODAL -->
                    
                <div class="modal fade modal-lg" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content" style="border-radius: 0px;">

                        
                        <div class="modal-header">
                            <p class="display-6" style="font-size:large;font-weight:600;">Search <?php echo $student_name;?> results</p>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        
                        <div class="modal-body">
                            <form method="post" class="d-flex" onsubmit="return false">
                                <input type="text" id="search" class="w-100" placeholder="Enter course title or course code" style="padding: 5px;">
                                <input type="hidden" id="school_id" value="<?php echo $school_id;?>">
                                <input type="hidden" id="faculty" value="<?php echo $faculty;?>">
                                <button class="btn btn-primary" id="search-btn" ><span class="text"><i class="fa fa-search"></i></span></button>
                            </form><br>
                            <center><span class="msgerror"></span></center>
                            <span id="msg"></span>      
                            <div id="searchResult"></div>        
                        </div>
                        </div>
                    </div>
                </div>
                <!-- END -->
<a href="#" class="btn btn-primary mb-4" style="color:#fff;" data-bs-toggle="modal" data-bs-target="#myModal"><small><i class="fa fa-search"></i> Search</small></a>
             <div class="table-responsive">
                            <table class="table table-striped table-borderless">
                                    <thead>
                                        <tr>
                                        <th scope="col">S/N</th>
                                        <th scope="col">Course Title</th>
                                        <th scope="col">Course Code</th>
                                        <th scope="col">Course Unit</th>
                                        <th scope="col">Level</th>
                                        <th scope="col">Score</th>
                                        <th scope="col">Grade</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                           
                                            while($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $num++;?></td>
                                            <td><?php echo $row['course_title'];?></td>
                                            <td><?php echo $row['course_code'];?></td>
                                            <td><?php echo $row['course_unit'];?></td>
                                            <td><?php echo $row['level'];?></td>
                                            <td><?php echo $row['total'];?></td>
                                            <td><?php echo $row['grade'];?></td>
                                            <td><?php if ($row['status'] === 'pending') { echo '<span class="bg-warning p-1">pending</span>'; } else { echo '<span class="bg-warning p-1">approved</span>';};?></td>
                                            <td>
                                                <a href="editstudentresult?id=<?php echo $row['id'];?>" class='btn btn-primary' style='font-size:12px;border-radius:0px;'><i class="fa fa-pencil"></i> Edit</a>
                                        
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                    </table>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-danger" role="alert">
                                        Student results will show here
                                    </div>
                                <?php
                                }
                            ?>
                      

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

<script src="../../assets/js/main.js"></script>
<script>
// Search student script  
const msg = document.getElementById('msg');
const search_btn = document.getElementById("search-btn");

search_btn.addEventListener("click", async () => {
        const search = document.getElementById("search");
        const faculty = document.getElementById("faculty");
        const school_id = document.getElementById("school_id");
        const searchResult = document.getElementById('searchResult');

        const formData = new FormData();
        formData.append('search-student-result-edition-btn', 1);
        formData.append('faculty',  faculty.value);
        formData.append('school_id', school_id.value);
        formData.append('search', search.value);

        // Disable the button when the request is initiated
        search_btn.disabled = true;

        try {
            const response = await axios.post('../functions/search.inc.php', formData);
            searchResult.innerHTML = response.data
        } catch (error) {
            console.error(error);
            msg.innerHTML = "<div class='alert alert-danger'>An error occurred. </div>";
        } finally {
            search_btn.disabled = false;
        }
    
});



</script>
</body>
</html>
<?php } else {
    header('Location: index');
}
?>

