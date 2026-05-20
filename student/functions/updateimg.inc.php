<?php
session_start();

if (isset($_SESSION['studentID'])) {
    require '../../configs/dbh.inc.php';

    $response = [];

    // Get image file data
    $imgFile = $_FILES['imgfile'];
    $imgFileName = $imgFile['name'];
    $imgFileTmpName = $imgFile['tmp_name'];
    $imgFileSize = $imgFile['size'];
    $imgFileError = $imgFile['error'];

    if (empty($imgFileName)) {
        $response['error'] = 'Please select an image';
        sendResponse($response);
    }

    $fileExt = strtolower(pathinfo($imgFileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($fileExt, $allowedExtensions)) {
        $response['error'] = 'Only JPG, PNG, and WEBP image files are allowed.';
        sendResponse($response);
    }

    if ($imgFileError !== 0) {
        $response['error'] = 'An error occurred while uploading. Please try again.';
        sendResponse($response);
    }

    if ($imgFileSize > 3145728) { // 3MB
        $response['error'] = 'Image size is too large.';
        sendResponse($response);
    }

    $school_id = $_POST['school_id'];

    // Check if old image exists
    $sql = "SELECT image FROM students_tb WHERE school_id = '{$school_id}'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    // Prepare new file name
    $id = time() + rand(1, 1000);
    $newFileName = 'students' . $id . '.' . $fileExt;
    $destinationPath = '../../uploads/students/' . $newFileName;

    // Move the uploaded file
    if (move_uploaded_file($imgFileTmpName, $destinationPath)) {
        
        // Delete old image if it exists
        if ($row && !empty($row['image'])) {
            $oldImagePath = '../../uploads/students/' . $row['image'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Update database with new image
        $updateSql = "UPDATE students_tb SET image = '{$newFileName}' WHERE school_id = '{$school_id}'";
        if (mysqli_query($con, $updateSql)) {
            $response['success'] = 'Profile image updated successfully';
        } else {
            $response['error'] = 'An error occurred while updating the profile image.';
        }
    } else {
        $response['error'] = 'Failed to upload image.';
    }

    sendResponse($response);
}

// Function to send the response as JSON and terminate the script
function sendResponse($response) {
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
