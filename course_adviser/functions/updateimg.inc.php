<?php 
session_start();

if (isset($_SESSION['courseAdvisorID'])) {
    require '../../configs/dbh.inc.php';

    // Initialize the response array
    $response = [];

    // Function to compress and save an image
    function compressAndSaveImage($sourcePath, $destinationPath, $quality) {
        $image = imagecreatefromstring(file_get_contents($sourcePath));
        if ($image === false) {
            return false;
        }
        imagejpeg($image, $destinationPath, $quality);
        imagedestroy($image);
        return true;
    }

    // Get image file data
    $imgFile = $_FILES['imgfile'];
    $imgFileName = $imgFile['name'];

    if (empty($imgFileName)) {
        $response['error'] = 'Please select an image';
        sendResponse($response);
    }

    $fileExt = pathinfo($imgFileName, PATHINFO_EXTENSION);
    $fileExt = strtolower($fileExt);
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($fileExt, $allowedExtensions)) {
        $response['error'] = 'Only JPG, PNG, and WEBP image files are allowed.';
        sendResponse($response);
    }

    $imgFileTmpName = $imgFile['tmp_name'];
    $imgFileSize = $imgFile['size'];
    $imgFileError = $imgFile['error'];

    if ($imgFileError !== 0) {
        $response['error'] = 'An error occurred while uploading. Please try again';
        sendResponse($response);
    }

    if ($imgFileSize > 3145728) {
        $response['error'] = 'Image size is too large.';
        sendResponse($response);
    }

    $school_id = $_POST['school_id'];
    $sql = "SELECT image FROM course_advisor_tb WHERE school_id = '{$school_id}'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($imgFileName !== '') {
        if (in_array($fileExt, $allowedExtensions) && $imgFileError === 0 && $imgFileSize <= 3145728) {
            $id = time() + rand(1, 1000);
            $imgFileName = 'course_advisors' . $id . '.' . $fileExt;

            if ($row['image'] !== null) {
                unlink("../../uploads/course_advisors/" . $row['image']);
            }

            // Compress and save the image
            $compressedImagePath = '../../uploads/course_advisors/' . $imgFileName;
            if (compressAndSaveImage($imgFileTmpName, $compressedImagePath, 50)) {
                $sql = "UPDATE course_advisor_tb SET image = '{$imgFileName}' WHERE school_id = '{$school_id}'";
                if (mysqli_query($con, $sql)) {
                    $response['success'] = 'Profile image updated successfully';
                } else {
                    $response['error'] = 'An error occurred while updating the profile image.';
                }
            } else {
                $response['error'] = 'Failed to compress and save the image';
            }
        } else {
            $response['error'] = 'Invalid image format or too large.';
        }
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
