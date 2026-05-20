<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result Computation Management System</title>    
    <?php include 'includes/links&scripts.php'; ?>
</head>
<body class="bg-img">
  <div class="preloader"></div>
  <div class="d-flex text-dark" style="justify-content:center;align-items:center;height:100vh;">
        <div class="p-3">
            <center><img src="assets/img/logo.png" width="150px"><br><br><br>
                <p class="text-center text-white mb-3 h4" style="font-weight:600;font-size: 20px !important;">Welcome to MCIU Result Computation Portal</p>
                <div class="d-flex" style="gap:1rem;justify-content:center;">
                      <a href="student/auth/login" style="border-radius:0px;" class="btn btn-primary rounded btn-sm p-2">Student <i class="fa fa-users"></i></a>
                      <a href="course_adviser/auth/login" style="border-radius:0px;"  class="btn btn-primary rounded btn-sm p-2">Course Adviser <i class="fa fa-user"></i></a>
                      <a href="hod/auth/login" style="border-radius:0px;"  class="btn btn-primary rounded btn-sm p-2">HOD <i class="fa fa-user"></i></a>
                </div>
            </center>
         </div>
    </div>
<script src="assets/js/main.js"></script>
</body>
</html>