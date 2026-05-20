<?php 
require '../../configs/dbh.inc.php';
$search = trim($_POST['search']);
$faculty = $_POST['faculty'];

// Student search
if(isset($_POST['search-students-btn'])) {
    if(!empty($search)) {
        $sql = "SELECT id, fname, lname, school_id, dept, faculty FROM students_tb WHERE  (fname LIKE ? OR lname LIKE ? OR school_id LIKE ?) AND faculty = ?";
        $stmt = mysqli_stmt_init($con);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            $param = "%" . $search . "%";
            mysqli_stmt_bind_param($stmt, "ssss", $param, $param, $param, $faculty);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) > 0) {
                echo "
                <div class='table-responsive'>
                <table class='table table-striped'>
                    <thead>
                    <tr>
                        <th scope='col'>Name</th>
                        <th scope='col'>School ID</th>
                        <th scope='col'>Department</th>
                        <th scope='col'>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                ";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                            <tr>
                                <td>" . $row['fname'] . " " . $row['lname'].  "</td>
                                <td>" . strtoupper($row['school_id']) . "</td>
                                <td>" . $row['dept'] . "</td>
                                <td>
                                    <a href='viewstudent?id=" . $row['id'] . "' class='btn btn-primary text-decoration-none' style='font-size:12px;'> view info</a>
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
                echo "<center><div class='alert alert-danger w-100'>Student not found</div></center>";
                exit();
            }
        } else {
            echo 'An error occurred. Please try again.';
        }
    }
} 

//course search
if(isset($_POST['search-course-btn'])) {
    if(!empty($search)) {
        $sql = "SELECT id, course_title, course_code, course_unit, dept, level, faculty FROM courses_tb WHERE (course_title LIKE ? OR course_code LIKE ?) AND faculty = ?";
        $stmt = mysqli_stmt_init($con);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            $param = "%" . $search . "%";
            mysqli_stmt_bind_param($stmt, "sss", $param, $param, $faculty);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) > 0) {
                echo "
                <div class='table-responsive'>
                <table class='table table-striped'>
                    <thead>
                    <tr>
                        
                        <th scope='col'>Course title</th>
                        <th scope='col'>Course code</th>
                        <th scope='col'>Course unit</th>
                        <th scope='col'>Dept</th>
                        <th scope='col'>Level</th>
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
                                    <td>" . $row['dept'] . "</td>
                                    <td>" . $row['level'] . "</td>
                                    <td>
                                        <a href='editcourse?id=" . $row['id'] . "' class='btn btn-primary text-decoration-none' style='font-size:12px;'>view</a>
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

//search student for result computation
if(isset($_POST['search-results-students-btn'])) {
    if(!empty($search)) {
        $sql = "SELECT id, fname, lname, school_id, dept, faculty FROM students_tb WHERE  (fname LIKE ? OR lname LIKE ? OR school_id LIKE ?) AND faculty = ?";
        $stmt = mysqli_stmt_init($con);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            $param = "%" . $search . "%";
            mysqli_stmt_bind_param($stmt, "ssss", $param, $param, $param, $faculty);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) > 0) {
                echo "
                <div class='table-responsive'>
                <table class='table table-striped'>
                    <thead>
                    <tr>
                        <th scope='col'>Name</th>
                        <th scope='col'>School ID</th>
                        <th scope='col'>Department</th>
                        <th scope='col'>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                ";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                            <tr>
                                <td>" . $row['fname'] . " " . $row['lname'].  "</td>
                                <td>" . strtoupper($row['school_id']) . "</td>
                                <td>" . $row['dept'] . "</td>
                                <td>
                                    <a href='computeresult?id=" . $row['id'] . "' class='btn btn-primary text-decoration-none' style='font-size:12px;'> Add result</a>
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
                echo "<center><div class='alert alert-danger w-100'>Student not found</div></center>";
                exit();
            }
        } else {
            echo 'An error occurred. Please try again.';
        }
    }
}

//Search Students to manage their result
if(isset($_POST['search-student-result-btn'])) {
    if(!empty($search)) {
        $sql = "SELECT id, fname, lname, school_id, dept, faculty, school_id FROM students_tb WHERE  (fname LIKE ? OR lname LIKE ? OR school_id LIKE ?) AND faculty = ?";
        $stmt = mysqli_stmt_init($con);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            $param = "%" . $search . "%";
            mysqli_stmt_bind_param($stmt, "ssss", $param, $param, $param, $faculty);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) > 0) {
                echo "
                <div class='table-responsive'>
                <table class='table table-striped'>
                    <thead>
                    <tr>
                        <th scope='col'>Name</th>
                        <th scope='col'>School ID</th>
                        <th scope='col'>Department</th>
                        <th scope='col'>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                ";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                            <tr>
                                <td>" . $row['fname'] . " " . $row['lname'].  "</td>
                                <td>" . $row['school_id'] . "</td>
                                <td>" . $row['dept'] . "</td>
                                <td>
                                    <a href='viewstudentresult?id=" . $row['id'] . "' class='btn btn-primary text-decoration-none' style='font-size:12px;'> Manage result</a>
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
                echo "<center><div class='alert alert-danger w-100'>Student not found</div></center>";
                exit();
            }
        } else {
            echo 'An error occurred. Please try again.';
        }
    }
}

//Search Student result for edition fromresults table

if(isset($_POST['search-student-result-edition-btn'])) {
    $school_id = $_POST['school_id'];
    if(!empty($search)) {
        $sql = "SELECT id, course_title, course_code, course_unit, level, total, grade, school_id, faculty FROM results_tb WHERE  (course_title LIKE ? OR course_code LIKE ?) AND school_id = ?";
        $stmt = mysqli_stmt_init($con);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            $param = "%" . $search . "%";
            mysqli_stmt_bind_param($stmt, "sss", $param, $param,  $school_id);
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
                        <th scope='col'>Level</th>
                        <th scope='col'>Score</th>
                        <th scope='col'>Grade</th>
                        <th scope='col'>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                ";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                            <tr>
                                <td>" . $row['course_title'] . "</td>
                                <td>" . $row['course_code'] . "</td>
                                <td>" . $row['course_unit'] . "</td>
                                <td>" . $row['level'] . "</td>
                                <td>" . $row['total'] . "</td>
                                <td>" . $row['grade'] . "</td>
                                <td>
                                    <a href='editstudentresult?id=" . $row['id'] . "' class='btn btn-primary text-decoration-none' style='font-size:12px;'> Edit</a>
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
                echo "<center><div class='alert alert-danger w-100'>Result not found</div></center>";
                exit();
            }
        } else {
            echo 'An error occurred. Please try again.';
        }
    }
}


