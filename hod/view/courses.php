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
    <title>Courses - HOD</title>
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
                    <div ><i class="fas fa-align-left fs-4 me-3"  style="color:#0d2a45ff;" id="menu-toggle"></i></div>
                    <div><p class="display-6" style="font-size: large;font-weight:600;">Courses</p></div>
               </div> 
               <?php include 'includes/hodnavbar.php';?>
     
       
            <div class="container-fluid px-4 py-4">
            
     
                
                <div class=" mt-3 shadow-lg " style="overflow:hidden">
                        <div class="p-3 bg-white   ">
                <!-- SEARCH MODAL -->
                    
                    <div class="modal fade modal-lg" id="myModal">
                        <div class="modal-dialog">
                        <div class="modal-content" style="border-radius: 0px ;">

                        
                        <div class="modal-header">
                            <p class="display-6" style="font-size:large;font-weight:600;">Search courses</p>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        
                        <div class="modal-body">
                            <form method="post" class="d-flex" onsubmit="return false">
                                <input type="text" id="search" class="w-100" placeholder="Enter course title or course code" style="padding: 5px;">
                                <input type="hidden" id="faculty_1" value="<?php echo $faculty;?>">
                                <button class="btn btn-primary" id="search-btn"><span class="text"><i class="fa fa-search"></i></span></button>
                            </form><br>
                            <span id="msg2"></span>      
                            <div id="searchResult"></div>        
                        </div>
                        </div>
                    </div>
                </div>
                <!-- END -->

                                      <div>
                            
                                <div><a href="#" class="btn btn-primary mb-4" style="color:#fff;" data-bs-toggle="modal" data-bs-target="#myModal"><small><i class="fa fa-search"></i> Search</small></a></div>
                            
                            <?php
                                $sql = "SELECT id, course_title, course_code, semester,  faculty course_unit, dept, level FROM courses_tb WHERE faculty = '{$faculty}' ORDER BY LEVEL ASC";
                                $result = mysqli_query($con, $sql);
                                if(mysqli_num_rows($result) > 0) {
                                    $num = 1;
                                
                            ?>
                            <div class="table-responsive">
                            <table class="table table-striped  table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">S/N</th>
                                            <th scope="col">Course title</th>
                                            <th scope="col">Course code</th>
                                            <th scope="col">Course unit</th>
                                            <th scope="col">Dept</th>
                                            <th scope="col">Level</th>
                                            <th scope="col">Semester</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                
                                            
                                        <td><?php echo $num++;?></td>
                                        <td><?php echo $row['course_title'];?></td>
                                        <td><?php echo $row['course_code'];?></td>
                                        <td><?php echo $row['course_unit'];?></td>
                                        <td><?php echo $row['dept'];?></td>
                                        <td><?php echo $row['level'];?></td>
                                        <td><?php echo $row['semester'];?></td>
                                        
                                        

                                    </tr>
                                    <?php } ?>
                                        
                                    </tbody>
                                    </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="alert alert-danger" style="border-radius: 0px;" role="alert">
                                        Courses will show here
                                    </div>
                                <?php } ?>
                            
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    

<script src="../../assets/js/main.js"></script>
<script>


// Search course script  
const msg2 = document.getElementById('msg2');
const search_btn = document.getElementById("search-btn");
search_btn.addEventListener("click", async () => {
    const search = document.getElementById("search");
    const faculty = document.getElementById("faculty_1");
    const searchResult = document.getElementById('searchResult');

        const formData = new FormData();
        formData.append('search-course-btn', 1);
        formData.append('faculty',  faculty.value);
        formData.append('search', search.value);

        // Disable the button when the request is initiated
        search_btn.disabled = true;
        try {
            const response = await axios.post('../functions/search.inc.php', formData);
            searchResult.innerHTML = response.data
        } catch (error) {
            console.error(error);
            msg2.innerHTML = "<div class='alert alert-danger' style='border-radius:0px;'>An error occurred. </div>";
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