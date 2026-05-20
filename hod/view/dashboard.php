<?php
session_start();
if(isset($_SESSION['hodID'])) {
  require '../../configs/dbh.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - HOD</title>
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
               <?php include 'includes/hodnavbar.php';?>
        <div class="container-fluid px-4 py-4">
            
            <div class="flexbox mb-5">
                <div class="d-33 mt-3 shadow-lg ">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center " style="height:200px;">
                            <div>
                                <h3 class="fs-8">
                                <?php 
                                //Get number of declared results
                                $sql = "SELECT faculty FROM  results_tb WHERE faculty = '{$row['faculty']}' AND status = 'pending' GROUP BY school_id";
                                $result = mysqli_query($con, $sql);
                                $num = mysqli_num_rows($result);
                                echo $num;
                           ?>
                                </h3>
                                <p>Total Pending Results</p>
                                
                            </div>
                            <a href="results" class="btn btn-primary">view</a>
                        </div>
                    </div>
                    <div class="d-33 mt-3 shadow-lg ">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center " style="height:200px;">
                            <div>
                                <h3 class="fs-8">
                                <?php
                                      $sql = "SELECT faculty FROM  courses_tb WHERE faculty = '{$row['faculty']}'";
                                      $result = mysqli_query($con, $sql);
                                      $num = mysqli_num_rows($result);
                                      echo $num;
                                    ?>
                                </h3>
                                <p>Total Courses</p>
                                
                            </div>
                            <a href="courses" class="btn btn-primary">view</a>
                        </div>
                 
                </div>
                <div class="d-33 mt-3 shadow-lg ">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center " style="height:200px;">
                            <div>
                                <h3 class="fs-8">
                                <?php
                                      $sql = "SELECT faculty FROM  students_tb WHERE faculty = '{$row['faculty']}'";
                                      $result = mysqli_query($con, $sql);
                                      $num = mysqli_num_rows($result);
                                      echo $num;
                                    ?>
                                </h3>
                                <p>Total Students</p>
                                
                            </div>
                            <a href="students" class="btn btn-primary">view</a>
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