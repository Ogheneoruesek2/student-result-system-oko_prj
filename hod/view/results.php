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
        <nav class="navbar navbar-expand-lg navbar-light d-flex bg-white  fixed-top py-3 px-3" style="justify-content:space-between;">
               <div class="d-flex">
                    <div><i class="fas fa-align-left fs-4 me-3" style="color:#0d2a45ff;" id="menu-toggle"></i></div>
                    <div><p class="display-6" style="font-size: large;font-weight:600;">Results</p></div>
               </div> 
               <?php include 'includes/hodnavbar.php';?>
           
            <div class="container-fluid px-4 py-4">
                
            <div class="bg-white shadow-sm p-3">
                                <!-- SEARCH MODAL -->
                                <div class="modal fade modal-lg" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                    
                    <div class="modal-header">
                        <p class="display-6" style="font-size:large;font-weight:600;">Search students</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    
                    <div class="modal-body">
                            <form method="post" class="d-flex" onsubmit="return false">
                            <input type="text" id="search" class="w-100" placeholder="Enter student name or school ID" style="padding: 5px;">
                                <input type="hidden" id="faculty" value="<?php echo $faculty;?>">
                                <button class="btn btn-primary" id="search-btn"><span class="text"><i class="fa fa-search"></i></span></button>
                            </form><br>
                            <center><span class="msgerror2"></span></center>
                            <span id="msg"></span>      
                            <div id="searchResult"></div>        
                        </div>
                    </div>
                </div>
            </div>
            <!-- END -->
                        <div>
                        <a href="#" class="btn btn-primary mb-4" style="color:#fff;" data-bs-toggle="modal" data-bs-target="#myModal"><small><i class="fa fa-search"></i> Search</small></a>
            <?php
             $sql = "SELECT id, fname, lname, school_id, level, dept FROM students_tb WHERE  faculty = '{$faculty}' ORDER BY level DESC";
             $result = mysqli_query($con, $sql);
             $num = 1;
             if(mysqli_num_rows($result) > 0) {?>
             <div class="table-responsive">
                            <table class="table table-striped table-borderless">
                                    <thead>
                                        <tr>
                                        <th scope="col">S/N</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">School ID</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Level</th>
                                        <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                           
                                            while($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $num++;?></td>
                                            <td><?php echo $row['fname'] . ' ' . $row['lname'];?></td>
                                            <td><?php echo strtoupper($row['school_id']);?></td>
                                            <td><?php echo $row['dept'];?></td>
                                            <td><?php echo $row['level'];?></td>
                                            <td>
                                                <a href="viewstudentresult?id=<?php echo $row['id'];?>" class="btn btn-primary" style="font-size:12px;"> View result</a>
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
                                        Students will show here
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
            <script>
//Search student script

const search_btn = document.getElementById("search-btn");

search_btn.addEventListener("click", async () => {
    const search = document.getElementById("search");
    const faculty = document.getElementById("faculty");
    const msg = document.getElementById('msg');
    const searchResult = document.getElementById('searchResult');
        const formData = new FormData();
        formData.append('search-student-result-btn', 1);
        formData.append('faculty',  faculty.value);
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
    header("Location: ../auth/login");
}
?>