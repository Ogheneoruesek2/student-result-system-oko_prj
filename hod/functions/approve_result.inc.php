<?php 
require '../../configs/dbh.inc.php';
$Id = $_POST['Id'];


//Delete course
if (isset($_POST['approve-result-btn'])) { 
        $sql = "UPDATE results_tb SET status = 'approved' WHERE  id = '{$Id}'";
     

        // Return a JSON response indicating success or failure
        if (mysqli_query($con, $sql)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
} 