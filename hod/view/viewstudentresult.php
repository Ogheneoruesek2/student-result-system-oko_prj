<?php
session_start();
if(isset($_SESSION['hodID']) && isset($_GET['id'])) {
    require '../../configs/dbh.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results - HOD</title>
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
                    <div><i class="fas fa-align-left fs-4 me-3" style="color:#0d2a45ff;" id="menu-toggle"></i></div>
                    <div><p class="display-6" style="font-size: large;font-weight:600;">Results</p></div>
               </div> 
               <?php include 'includes/hodnavbar.php';?>
     
       
            <div class="container-fluid px-4 py-4">
            
     
                
                <div class=" mt-3 shadow-lg bg-white">
                        <div class="p-3   " >
                        <?php 
                            $id = mysqli_real_escape_string($con, $_GET['id']);  
                            $sql = "SELECT id, fname, lname, email, school_id, dept, faculty, image, level FROM students_tb WHERE id = '{$id}'";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $fname = $row['fname'];
        $school_id = $row['school_id'];
                            
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

    </div>
</div><br><br>
    
    


   

<br><br>
<p style="font-weight:600;">STUDENT PENDING RESULT TABLE</p>     
<?php
    $sql = "SELECT id, course_title, course_code, course_unit, level, semester, session, total, grade, school_id FROM results_tb WHERE school_id = '{$school_id}' AND status = 'pending' ORDER BY level";
    $result = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        $num = 1;
    
?>  
        
             <div class="table-responsive">
                            <table class="table table-striped table-borderless">
                                    <thead>
                                        <tr>
                                        <th scope="col">S/N</th>
                                        <th scope="col">Course Title</th>
                                        <th scope="col">Course Code</th>
                                        <th scope="col">Course Unit</th>
                                        <th scope="col">Level</th>
                                        <th scope="col">Semester</th>
                                        <th scope="col">Session</th>                                        
                                        <th scope="col">Score</th>
                                        <th scope="col">Grade</th>
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
                                            <td><?php echo $row['semester'];?></td>
                                            <td><?php echo $row['session'];?></td>
                                            <td><?php echo $row['total'];?></td>
                                            <td><?php echo $row['grade'];?></td>
                                            <td>
                                            <form method="post" onsubmit="return false;">
                                                <input type="hidden" class="Id" value="<?php echo $row['id'];?>">
                                                <button  class="btn btn-primary approve-result "  style="font-size:12px;" title="Approve Result">Approve</button>
                                            </form>
                                        </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                    </table>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-danger">
                                        No further approval is needed
                                    </div>
                                <?php
                                }
                            ?>

                            <p style="font-weight:600">STUDENT APPROVED RESULT TABLE</p>
                            <?php
    $sql = "SELECT id, course_title, course_code, course_unit, level, semester, session, total, grade, school_id FROM results_tb WHERE school_id = '{$school_id}' AND status = 'approved' ORDER BY level";
    $result = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        $num = 1;
    
?>  
        
             <div class="table-responsive">
                            <table class="table table-striped table-borderless">
                                    <thead>
                                        <tr>
                                        <th scope="col">S/N</th>
                                        <th scope="col">Course Title</th>
                                        <th scope="col">Course Code</th>
                                        <th scope="col">Course Unit</th>
                                        <th scope="col">Level</th>
                                        <th scope="col">Semester</th>
                                        <th scope="col">Session</th>                                        
                                        <th scope="col">Score</th>
                                        <th scope="col">Grade</th>
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
                                            <td><?php echo $row['semester'];?></td>
                                            <td><?php echo $row['session'];?></td>
                                            <td><?php echo $row['total'];?></td>
                                            <td><?php echo $row['grade'];?></td>
                                            <td>
                                            <form method="post" onsubmit="return false;">
                                                <input type="hidden" class="Id" value="<?php echo $row['id'];?>">
                                                <button  class="btn btn-primary reverse-result "  style="font-size:12px;" title="Approve Result">Reverse</button>
                                            </form>
                                        </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                    </table>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-danger">
                                        No further reversal is needed
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


// Approve result from the table directly 
document.querySelectorAll('.approve-result').forEach(function (approve_resultBtn) {
    approve_resultBtn.addEventListener('click', function (event) {
        event.preventDefault();
        const Id = event.target.closest('tr').querySelector('.Id').value;
        const formData = new FormData();
        formData.append('approve-result-btn', 1);
        formData.append('Id', Id);

        // Confirm deletion
        if (confirm('Confirm Approval?')) {
            // Send an AJAX request to approve result
            axios.post('../functions/approve_result.inc.php', formData ) // Include courseId in the data object
                .then(function (response) {
                    // Check if deletion was successful
                    if (response.data.success) {
                        // Remove the table row from the DOM
                        event.target.closest('tr').remove();
                    } else {
                        alert('Failed to approve result.');
                    }
                })
                .catch(function (error) {
                    console.error('Error approving result: ' + error);
                });
        }
    });
});

// Reverse result from the table directly 
document.querySelectorAll('.reverse-result').forEach(function (reverse_resultBtn) {
    reverse_resultBtn.addEventListener('click', function (event) {
        event.preventDefault();
        const Id = event.target.closest('tr').querySelector('.Id').value;
        const formData = new FormData();
        formData.append('reverse-result-btn', 1);
        formData.append('Id', Id);

        // Confirm deletion
        if (confirm('Confirm Reversal?')) {
            // Send an AJAX request to reverse result
            axios.post('../functions/reverse_result.inc.php', formData ) // Include courseId in the data object
                .then(function (response) {
                    // Check if deletion was successful
                    if (response.data.success) {
                        // Remove the table row from the DOM
                        event.target.closest('tr').remove();
                    } else {
                        alert('Failed to reverse result.');
                    }
                })
                .catch(function (error) {
                    console.error('Error reverse result: ' + error);
                });
        }
    });
});


</script>
</body>
</html>
<?php } else {
    header('Location: index');
}
?>

