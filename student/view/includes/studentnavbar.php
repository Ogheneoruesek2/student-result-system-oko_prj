
<?php
    $id = $_SESSION['studentID'];
    $sql = "SELECT id, fname, lname, school_id, dept, faculty, email, level, image FROM students_tb WHERE id = {$id}";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $fname = $row['fname'];
    $studentID = $row['school_id'];
    $dept = $row['dept'];
    $faculty = $row['faculty'];
    $name = $row['fname'] . ' ' . $row['lname'];
    $email = $row['email'];
    $level = $row['level'];
?>
<style>

</style>
<div class="d-flex" style="gap:1rem;align-items:center;">
                    <div>
                        
                    <div class="dropdown">
  <span id="dropbtn" style="font-weight:600" class="dropbtn"><i class="fa fa-user-o" style="font-size:large;"></i> Hi, <?php echo ucfirst($row['fname']);?></span>
  <div id="myDropdown" class="dropdown-content">
    <a href="profile"><i class="fa fa-user"></i> Profile</a>
    <a href="logout"><i class="fa fa-sign-out"></i> Log Out</a>
  </div>
</div>

                    
               </div> 
            </nav>
            <br><br><br>
