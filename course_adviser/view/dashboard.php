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
    <title>Dashboard - Course advisor</title>
    <?php include '../../includes/links&scripts.php'; ?>
</head>
<body>
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
              <?php include 'includes/cousrseadvisornavbar.php';?>
            <div class="container-fluid px-4 py-4">
            
            <div class="flexbox">
                <div class="d-33 mt-3 shadow-lg rounded" style="overflow:hidden">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center">
                            <div>
                                <h3 class="fs-8">
                                <?php 
                                    //Get number of registered courses 
                                    $sql = "SELECT faculty FROM courses_tb WHERE faculty = '{$row['faculty']}'";
                                    $result = mysqli_query($con, $sql);
                                    $num = mysqli_num_rows($result);
                                    echo $num;
                           ?>
                                </h3>
                                <p>Courses</p>
                            </div>
                            <i class="fas fa-book fs-3  rounded-full text-primary p-3"></i>
                        </div>
                    </div>
                    <div class="d-33 mt-3 shadow-lg rounded" style="overflow:hidden">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center">
                            <div>
                                <h3 class="fs-8">
                                <?php 
                                //Get number of students
                                $sql = "SELECT faculty FROM students_tb WHERE faculty = '{$row['faculty']}'";
                                $result = mysqli_query($con, $sql);
                                $num = mysqli_num_rows($result);
                                echo $num;
                           ?>
                                </h3>
                                <p>Total Students</p>
                            </div>
                            <i class="fas fa-users fs-3  rounded-full text-primary p-3"></i>
                        </div>
                    </div>

                    <div class="d-33 mt-3 shadow-lg rounded" style="overflow:hidden">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center ">
                            <div>
                                <h3 class="fs-8">
                                <?php 
                                //Get number of declared results
                                $sql = "SELECT faculty FROM  results_tb WHERE faculty = '{$row['faculty']}' AND status = 'approved' GROUP BY school_id";
                                $result = mysqli_query($con, $sql);
                                $num = mysqli_num_rows($result);
                                echo $num;
                           ?>
                                </h3>
                                <p>Total Results Declared</p>
                            </div>
                            <i class="fas fa-list fs-3  rounded-full text-primary p-3"></i>
                        </div>
                    </div>
                </div>
                

          

                </div>
            </div>
        </div>
    </div>


<script src="../../assets/js/main.js"></script>

</body>
</html>
<?php } else {
    header("Location: index");
}
?>

