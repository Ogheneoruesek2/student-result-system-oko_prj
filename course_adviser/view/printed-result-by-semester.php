<?php
session_start();
if(isset($_SESSION['courseAdvisorID']) && isset($_SESSION['semester_level']) && isset($_SESSION['semester']) && isset($_SESSION['semester_faculty']) && isset($_SESSION['semester_dept']) && isset($_SESSION["semester_session"])) {
    require '../../configs/dbh.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Result By Semester - Course advisor</title>
    <?php include '../../includes/links&scripts.php'; ?>
    <style>
        body {
            font-size:large !important;
        }
    </style>
    <script>
            (function(){
        window.print();
        setTimeout(function(){
            window.close()
        },500)
    })();
    </script>
    
</head>
<body class="container bg-white">
    
     
       
            
            <?php 
                $level = $_SESSION["semester_level"];
                $semester = $_SESSION["semester"];
                $faculty = $_SESSION["semester_faculty"];
                $dept = $_SESSION["semester_dept"];
                $session = $_SESSION["semester_session"];
            ?>
     
                
   

                        

    <div class="d-flex mt-3 mb-3" style="gap:2rem;">
        <div>
            <img src="../../assets/img/logo.png" alt="logo" width="60px">
        </div>
        <div >
        
                <p style="font-weight:600;">MICHAEL & CECILIA IBRU UNIVERSITY</p> 
                <p style="font-weight:600;">AGBARA-OTOR, DELTA STATE</p> 
                <p style="font-weight:600;">FACULTY OF <?php echo strtoupper($faculty);?></p> 
                <p style="font-weight:600;">DEPARTMENT OF <?php echo strtoupper($dept);?></p> 
                <p style="font-weight:600;"><?php echo strtoupper($semester);?> RESULT FOR <?php echo $session;?> ACADEMIC SESSION (<?php echo $level;?> LEVEL)</p> 
                
        </div>
    </div>
    <?php
$sql = "SELECT * FROM results_tb WHERE dept = '{$dept}' AND level = '{$level}' AND semester = '{$semester}' AND session = '{$session}' AND faculty = '{$faculty}' AND status = 'approved'";
$result = mysqli_query($con, $sql);
$studentData = array();

while ($row = mysqli_fetch_assoc($result)) {
    $studentID = $row['school_id'];

    
    //Sum of quality points
    $sql4 = "SELECT SUM(quality_points) AS total_quality_points  FROM results_tb WHERE school_id = '{$studentID}' AND dept = '{$dept}' AND level = '{$level}' AND semester = '{$semester}' AND session = '{$session}' AND faculty = '{$faculty}' AND status = 'approved'";
    $result2 = mysqli_query($con, $sql4);
    $row1 = mysqli_fetch_assoc($result2);
    $total_quality_points = $row1['total_quality_points'];

    //Sum of total course unit
    $sql5 = "SELECT SUM(course_unit) AS total_course_unit FROM results_tb WHERE school_id = '{$studentID}' AND dept = '{$dept}' AND level = '{$level}' AND semester = '{$semester}' AND session = '{$session}' AND faculty = '{$faculty}' AND status = 'approved'";
    $result3 = mysqli_query($con, $sql5);
    $row2 = mysqli_fetch_assoc($result3);
    $total_course_unit = $row2['total_course_unit'];
    $gpa = (float)((float)$total_quality_points / (float)$total_course_unit);
    $number_format_gpa = round($gpa, 2);
    

    $status = null;
     if($number_format_gpa > 1.50) {
        $status = 'IGS';
     } else {
        $status = 'NIGS';
     }


    if (!isset($studentData[$studentID])) {
        $studentData[$studentID] = array(
            'name' => $row['name'],
            'school_id' => strtoupper($studentID),
            'courseCodes' => array(),
            'score' => array(),
            'grade' => array(),
            'quality_points' => 0,
            'course_unit' => 0,
            'gpa' => $number_format_gpa,
            'status' => $status
        );
    }

    $studentData[$studentID]['courseCodes'][] = $row['course_code'];
    $studentData[$studentID]['score'][] = $row['total'];
    $studentData[$studentID]['grade'][] = $row['grade'];
    $studentData[$studentID]['quality_points'] += $row['quality_points'];
    $studentData[$studentID]['course_unit'] += $row['course_unit'];
    // Initialize an empty array for each student's outstanding courses
    $studentData[$studentID]['outstanding_courses'] = array();

    // Fetch failed courses for the current student
    $sql_failed_course = "SELECT DISTINCT course_code FROM results_tb WHERE school_id = '{$studentID}' AND grade = 'F' AND dept = '{$dept}' AND level = '{$level}' AND semester = '{$semester}' AND session = '{$session}' AND faculty = '{$faculty}' AND status = 'approved'";
    $result_failed_course = mysqli_query($con, $sql_failed_course);

    if (mysqli_num_rows($result_failed_course) > 0) {
        while ($row_failed_course = mysqli_fetch_assoc($result_failed_course)) {
            $failed_course = $row_failed_course['course_code'];
            // Add unique failed courses to the outstanding_courses array
            if (!in_array($failed_course, $studentData[$studentID]['outstanding_courses'])) {
                $studentData[$studentID]['outstanding_courses'][] = $failed_course;
            }
        }
    }
}
?>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">S/N</th>
                <th scope="col">NAME</th>
                <th scope="col">MAT NO</th>
                <th scope="col">COURSES</th>
                <th scope="col">SCORE</th>
                <th scope="col">GRADE</th>
                <th scope="col">TP</th>
                <th scope="col">TU</th>
                <th scope="col">GPA</th>
                <th scope="col">OUTSTANDING COURSE</th>
                <th scope="col">STATUS</th>
                <th scope="col">ANALYSIS</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $num = 1;
            $count_gpa_1 = 0;
            $count_gpa_2 = 0;
            $count_gpa_3 = 0;
            $count_gpa_4 = 0;
            $count_gpa_5 = 0;
            $count_gpa_6 = 0;
                foreach ($studentData as $student) {
            ?>
                <tr>
                    <td><?php echo $num++; ?></td>
                    <td><?php echo $student['name']; ?></td>
                    <td><?php echo $student['school_id']; ?></td>
                    <td style="padding: 0px;">
                    <table class="table" style="margin:0px">
                            <tbody>
                                <?php
                                foreach ($student['courseCodes'] as $courseCode) {
                                ?>
                                    <tr>
                                        <td><?php echo $courseCode; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </td>
                    <td style="padding: 0px;">
                    <table class="table" style="margin:0px">
                            <tbody>
                                <?php
                                foreach ($student['score'] as $score) {
                                ?>
                                    <tr>
                                        <td><?php echo $score; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </td>
                    <td style="padding: 0px;">
                    <table class="table" style="margin:0px">
                            <tbody>
                                <?php
                                foreach ($student['grade'] as $grade) {
                                ?>
                                    <tr>
                                        <td><?php echo $grade; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </td>
                    <td><?php echo $student['quality_points']; ?></td>
                    <td><?php echo $student['course_unit']; ?></td>
                    <td><?php echo $student['gpa'];
                       if ($student['gpa'] >= 4.50 && $student['gpa'] <= 5.00) {
                        $count_gpa_1++;
                  } else if ($student['gpa'] >= 3.50 && $student['gpa'] <= 4.49) {
                    $count_gpa_2++;
                  } else if ($student['gpa'] >= 2.50 && $student['gpa'] <= 3.49) {
                    $count_gpa_3++;
                  } else if ($student['gpa'] >= 1.50 && $student['gpa'] <= 2.49) {
                    $count_gpa_4++;
                  } else if ($student['gpa'] >= 1.00 && $student['gpa'] <= 1.49) {
                    $count_gpa_5++;
                  } else if ($student['gpa'] <= 0.99) {
                    $count_gpa_6++;
                  }
                    ?></td>
                    <td><?php 
                
                    if(isset($student['outstanding_courses']) && !empty($student['outstanding_courses'])) {
                        foreach ($student['outstanding_courses'] as $course_code) {
                            echo $course_code . ', ';
                            
                            
                        }
                    } else {
                        echo 'Nil';
                    }
                
    

                    
                    ?></td>
               <td><?php echo $student['status']; ?></td>
               <td><?php 
               if ($student['gpa'] >= 4.50 && $student['gpa'] <= 5.00) {
                     echo 'First Class';
               } else if ($student['gpa'] >= 3.50 && $student['gpa'] <= 4.49) {
                    echo 'Second Class Upper';
               } else if ($student['gpa'] >= 2.50 && $student['gpa'] <= 3.49) {
                    echo 'Second Class Lower';
               } else if ($student['gpa'] >= 1.50 && $student['gpa'] <= 2.49) {
                    echo 'Third Class';
               } else if ($student['gpa'] >= 1.00 && $student['gpa'] <= 1.49) {
                    echo 'Pass';
               } else if ($student['gpa'] <= 0.99) {
                    echo 'On Probation';
               }?></td>


 
                    
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div><br><br><br>
<?php // Print or use $count_high_gpa as needed
// echo "Number of students with GPA of 4.5 and above: ";
?>
<p style="font-weight: 600;">RESULT ANALYSIS</p>
    <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">CLASSES OF GPA</th>
                <th scope="col">NO OF STUDENTS</th>
            </tr>
        </thead>
        <tbody>

                <tr>
                    <td>4.50 - 5.00</td>
                    <td><?php echo $count_gpa_1; ?></td>
                </tr>
                <tr>
                    <td>3.50 - 4.49</td>
                    <td><?php echo $count_gpa_2; ?></td>
                </tr>
                <tr>
                    <td>2.50 - 3.49</td>
                    <td><?php echo $count_gpa_3; ?></td>
                </tr>
                <tr>
                    <td>1.50 - 2.49</td>
                    <td><?php echo $count_gpa_4; ?></td>
                </tr>
                <tr>
                    <td>1.00 - 1.49</td>
                    <td><?php echo $count_gpa_5; ?></td>
                </tr>
                <tr>
                    <td>0.00 - 0.99</td>
                    <td><?php echo $count_gpa_6; ?></td>
                </tr>
                <tr>
                    <td><b>TOTAL</b></td>
                    <td><?php 
                        $total_students = $count_gpa_1 + $count_gpa_2 + $count_gpa_3 + $count_gpa_4 + $count_gpa_5 + $count_gpa_6;
                        echo $total_students;
                    ?></td>
                </tr>

        </tbody>
    </table>
    </div><br><br><br>

</div>


           
            

<script src="../../assets/js/main.js"></script>
</body>
</html>
<?php } else {
    header('Location: index');
}
?>

