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
    <title>Dashboard - Student</title>
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
                    <div><p class="display-6" style="font-size: large;font-weight:600;">Dashboard</p></div>
               </div> 
        <?php include 'includes/studentnavbar.php';?>
        <div class="container-fluid px-4 py-4">
            
            <div class="flexbox mb-5">
                <div class="d-33 mt-3 shadow-lg rounded">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center " style="height:200px;">
                            <div>
                                <h3 class="fs-8">
                                    <?php
                                      $sql = "SELECT school_id FROM student_courses_tb WHERE school_id = '{$studentID}'";
                                      $result = mysqli_query($con, $sql);
                                      $num = mysqli_num_rows($result);
                                      echo $num;
                                    ?>
                                </h3>
                                <p>Registered Courses</p>
                                
                            </div>
                            <a href="courses" class="btn btn-primary ">view</a>
                        </div>
                    </div>
                    <div class="d-33 mt-3 shadow-lg rounded">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center " style="height:200px;">
                            <div>
                                <h3 class="fs-8">
                                <?php
                                      $sql = "SELECT school_id, is_carry_over FROM student_courses_tb WHERE school_id = '{$studentID}' AND is_carry_over = 'Yes'";
                                      $result = mysqli_query($con, $sql);
                                      $num = mysqli_num_rows($result);
                                      echo $num;
                                    ?>
                                </h3>
                                <p>Carry Over Courses</p>
                                
                            </div>
                            <a href="results" class="btn btn-primary ">view</a>
                        </div>
                 
                </div>
                <div class="d-33 mt-3 shadow-lg rounded">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center " style="height:200px">
                            <div>
                                <h3 class="fs-8">
                                CGPA
                               
                                </h3>
                                <p>
                                <?php
                             
                                      $sql = "SELECT school_id FROM results_tb WHERE school_id = '{$studentID}' AND status = 'approved'";
                                      $result = mysqli_query($con, $sql);
                                      if(mysqli_num_rows($result) > 0) {
                                          $sql1 = "SELECT SUM(quality_points) AS total_quality_points  FROM results_tb WHERE school_id = '{$studentID}' AND status = 'approved'";
                                          $result1 = mysqli_query($con, $sql1);
                                          $row1 = mysqli_fetch_assoc($result1);
                                          $total_quality_points = $row1['total_quality_points'];
                                  
                                          //Sum of total course unit
                                          $sql2 = "SELECT SUM(course_unit) AS total_course_unit FROM results_tb WHERE school_id = '{$studentID}' AND status = 'approved'";
                                          $result2 = mysqli_query($con, $sql2);
                                          $row2 = mysqli_fetch_assoc($result2);
                                          $total_course_unit = $row2['total_course_unit'];
                                          
                                  
                                  
                                  
                                          $cgpa = (float)((float)$total_quality_points / (float)$total_course_unit);
                                          echo number_format($cgpa, 2);
                                      } else {
                                        echo "0.00";
                                      }
                                    
                                      ?>
                                      </p>
                                    
                                </p>
                            </div>
                            
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
</body>
</html>
<?php } else {
    header("Location: ../auth/login");
}
?>