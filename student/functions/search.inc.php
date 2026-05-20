<?php 
require '../../configs/dbh.inc.php';
$search = trim($_POST['search']);
$school_id = $_POST['school_id'];

//course search
if(isset($_POST['search-course-btn'])) {
    if(!empty($search)) {
        $sql = "SELECT id, course_title, course_code, course_unit, dept, is_dropped, level, session,  semester, school_id FROM student_courses_tb WHERE (course_title LIKE ? OR course_code LIKE ?) AND school_id = ?";
        $stmt = mysqli_stmt_init($con);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            $param = "%" . $search . "%";
            mysqli_stmt_bind_param($stmt, "sss", $param, $param, $school_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) > 0) {
                echo "
                <div class='table-responsive'>
                <table class='table table-striped'>
                    <thead>
                    <tr>
                        
                        <th scope='col'>Course Title</th>
                        <th scope='col'>Course Code</th>
                        <th scope='col'>Course Unit</th>
                        <th scope='col'>Dropped Status</th>
                        <th scope='col'>Level</th>
                        <th scope='col'>Session</th>
                        <th scope='col'>Semester</th>
                        <th scope='col'>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                ";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                            <tr>
                                    <td>" . $row['course_title'].  "</td>
                                    <td>" . $row['course_code'] . "</td>
                                    <td>" . $row['course_unit'] . "</td>
                            ";

                            if ($row['is_dropped'] === '0') {
                                echo "<td><div class='bg-success text-white p-1  text-center'>Active</div></td>";
                            } else {
                                echo "<td><div class='bg-danger text-white p-1  text-center'>Dropped</div></td>";
                            }
                            echo "
                                    <td>" . $row['level'] . "</td>
                                    <td>" . $row['session'] . "</td>
                                    <td>" . $row['semester'] . "</td>
                                    <td>
                                        <a href='viewcourses?id=" . $row['id'] . "' class='btn btn-danger' style='font-size: 12px;border-radius:0px;'>View</a>
                                    </td>
                            </tr>
                    ";
                }
                echo "
                    </tbody>
                </table>
            </div>
            ";
            } else {
                echo "<center><div class='alert alert-danger w-100'>Course not found</div></center>";
                exit();
            }
        } else {
            echo 'An error occurred. Please try again.';
        }
    }
} 