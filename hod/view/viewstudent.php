<?php
session_start();
if(isset($_SESSION['hodID'])  && isset($_GET['id'])) {
    require '../../configs/dbh.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students - HOD</title>
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
                    <div><p class="display-6" style="font-size: large;font-weight:600;">Students</p></div>
               </div> 
               <?php include 'includes/hodnavbar.php';?>
     
       
            <div class="container-fluid px-4 py-4">
            
     
                
                <div class=" mt-3 shadow-lg" style="overflow:hidden">
                        <div class="p-3 bg-white">
                                <?php 
                                    $id = mysqli_real_escape_string($con, $_GET['id']);  
                                    $sql = "SELECT id, fname, lname, image, email, school_id, dept, faculty, level FROM students_tb WHERE id = '{$id}'";
                                    $result = mysqli_query($con, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                ?>
                                <p class="display-6 mb-4" style="font-size:large;font-weight:600;">Student Details</p><br><br>
                                <div class="flexbox">
                                    <div class="d-50">
                                        <center>
                                    <div class="passport-photo">
                                        <img src="../../uploads/students/<?php if($row['image'] === null) { echo 'default_img.jpg';} else { echo $row['image'];}?>" alt="student_img" style="border-radius:50%;">
                                    </div>
                                    </center>
                                    </div>
                                    <div class="d-50 container">
                                        <p><b>Name:</b> <?php echo $row['fname'] . ' ' . $row['lname'];?></p>
                                        <p><b>Email Address:</b> <?php echo $row['email'];?></p>
                                        <p><b>School ID:</b> <?php echo strtoupper($row['school_id']);?></p>
                                        <p><b>Department:</b> <?php echo $row['dept'];?></p>
                                        <p><b>Faculty:</b> <?php echo $row['faculty'];?></p>
                                        <p><b>Level:</b> <?php echo $row['level'];?></p>
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
    header('Location: index');
}
?>
