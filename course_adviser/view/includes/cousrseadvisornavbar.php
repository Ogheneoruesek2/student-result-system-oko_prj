<?php
    //Get Course Advisor
    $id = $_SESSION['courseAdvisorID'];
    $sql = "SELECT id, faculty, image, fname, lname, school_id, email FROM course_advisor_tb WHERE id = '{$id}'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $faculty = $row['faculty'];
?>

<div class="d-flex" style="gap:1rem;align-items:center;">
               
                    <div>
                        
                    <div class="dropdown">
                        <button id="dropbtn" onclick="dropdownFunction()" class="bg-white" style="font-weight:600"><i class="fa fa-user-o" style="font-size:large;"  ></i> Hi, <?php echo $row['fname'];?></button>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="profile"><i class="fa fa-user"></i> Profile</a>
                            <a href="logout"><i class="fa fa-sign-out"></i> Log Out</a>
                        </div>
                    </div>
                    
               </div> 
            </nav>
            <br><br><br>