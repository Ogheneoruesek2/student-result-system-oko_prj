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
    <title>Results - Student </title>
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
                    <div><p class="display-6" style="font-size: large;font-weight:600;">Results</p></div>
               </div> 
        <?php include 'includes/studentnavbar.php';?>
           
            <div class="container-fluid px-4 py-4">
                
            <div class="bg-white shadow-sm p-3">
                <p style="font-weight:600" class="h4">
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
                                 echo "Your CGPA is " . number_format($cgpa, 2);
                             } else {
                               echo "Your CGPA is 0.00";
                             }
                           
                             ?>
                             </p>
                           
                      <?php      

           

                    $sql = "SELECT id, course_title, course_code, course_unit, total, level, session, semester, grade, school_id FROM results_tb WHERE school_id = '{$studentID}' AND status = 'approved' ORDER BY level ASC";
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
                                            <th scope="col">Level</th>
                                            <th scope="col">Session</th>
                                            <th scope="col">Semester</th>
                                            <th scope="col">Score</th>
                                            <th scope="col">Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                                <tr>
                                                <td class="text-center"><?php echo $num++;?></td>
                                        <td ><?php echo $row['course_title'];?></td>
                                        <td><?php echo $row['course_code'];?></td>
                                        <td><?php echo $row['course_unit'];?></td>
                                        <td><?php echo $row['level'];?></td>
                                        <td><?php echo $row['session'];?></td>
                                        <td><?php echo $row['semester'];?></td>
                                        <td><?php echo $row['total'];?></td>
                                        <td><?php echo $row['grade'];?></td>
                                  
                                        </tr>
                                            <?php } ?>
                                    
                                        
                                    </tbody>
                                </table>
                            </div>
                            <?php

} else {
?>
<div class="alert alert-danger p-3 w-100" >Your approved results will display here</div>
<?php
}
?>

<p style="font-weight:600;">CARRY OVER COURSES</p>
        <?php
                      $sql = "SELECT id, course_title, course_code, semester, session, course_unit, level FROM results_tb WHERE school_id = '{$studentID}' AND grade = 'F'";
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
                            <th scope="col">Semester</th>
                            <th scope="col">Session</th>
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
                                <td><?php echo $row['semester'];?></td>
                                <td><?php echo $row['session'];?></td>
                                <td><?php echo $row['level'];?></td>
    
                          
                            </tr>
                            <?php } ?>
                        </tbody>
                        </table>
                        <?php
                      } else {
                        ?>
      <div class="alert alert-danger"  role="alert">
                                        No carry over courses
                                    </div>
                        <?php
                      }

                      ?>

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