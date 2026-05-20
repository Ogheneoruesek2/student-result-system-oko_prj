<?php
session_start();
if(isset($_SESSION['courseAdvisorID']) && isset($_SESSION['level']) && isset($_SESSION['faculty']) && isset($_SESSION['dept'])) {
    require '../../configs/dbh.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add results - Course advisor</title>
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
        <nav class="navbar navbar-expand-lg navbar-light d-flex bg-white  fixed-top py-3 px-3" style="justify-content:space-between;">
               <div class="d-flex">
                    <div><i class="fas fa-align-left fs-4 me-3" style="color:#0d2a45ff;" id="menu-toggle"></i></div>
                    <div><p class="display-6" style="font-size: large;font-weight:600;">Results</p></div>
               </div> 
               <?php include 'includes/cousrseadvisornavbar.php';?>
     
            <div class="container-fluid px-4 py-4">
            
     
                
            <div class=" mt-3 shadow-lg " style="overflow:hidden">
                    <div class="p-3 bg-white   ">
                <!-- SEARCH MODAL -->
                <div class="modal fade modal-lg" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content" style="border-radius: 0px;">

                    
                    <div class="modal-header">
                        <p class="display-6" style="font-size:large;font-weight:600;">Search students</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    
                    <div class="modal-body">
                    <form method="post" class="d-flex" onsubmit="return false">
                            
                            <input type="text" id="search" placeholder="Enter student name or school ID" class="w-100" style="padding: 5px;">
                            <input type="hidden" value="<?php echo $faculty;?>" id="faculty">
                            <button class="btn btn-primary" id="search-btn"><span class="text"><i class="fa fa-search"></i></span></button>
                        </form><br>
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
                        $level = $_SESSION["level"]; 
                        $faculty = $_SESSION["faculty"];
                        $dept = $_SESSION["dept"];

                        $sql = "SELECT id, fname, lname, school_id, dept, level, faculty FROM students_tb WHERE  dept = '{$dept}' AND level = '{$level}' AND faculty = '{$faculty}' ORDER BY id DESC";
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
                                        <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                           
                                            while($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $num++;?></td>
                                            <td><?php echo $row['fname'] . ' ' . $row['lname'];?></td>
                                            <td><?php echo strtoupper($row['school_id']);?></td>
                                            <td><?php echo $row['dept'];?></td>
                                            <td>
                                                <a href="computeresult?id=<?php echo $row['id'];?>" title="Add result for <?php echo $row['fname'];?>" class="btn btn-primary" style="font-size: 12px;"> Add result</a>
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
        </div>
    </div>

<script src="../../assets/js/main.js"></script>
<script>
//Search script

const search_btn = document.getElementById("search-btn");

search_btn.addEventListener("click", async () => {
    const search = document.getElementById("search");
    const faculty = document.getElementById("faculty");
    const msg = document.getElementById('msg');
    const searchResult = document.getElementById('searchResult');
        const formData = new FormData();
        formData.append('search-results-students-btn', 1);
        formData.append('faculty',  faculty.value);
        formData.append('search', search.value);

        // Disable the button when the request is initiated
        search_btn.disabled = true;

        try {
            const response = await axios.post('../functions/search.inc.php', formData);
            searchResult.innerHTML = response.data
        } catch (error) {
            console.error(error);
            msgerror.innerHTML = "<div class='alert alert-danger' style='border-radius:0px;'>An error occurred. </div>";
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