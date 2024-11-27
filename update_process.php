<?php
session_start();
include('db_connection.php');

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $contactNumber = $_POST['contactNumber'];
    $jobPosition = $_POST['jobPosition'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    // File handling
    $imageFileName = "";
    $resumeFileName = "";

    // Upload profile image
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == UPLOAD_ERR_OK) {
        $imageFileName = basename($_FILES['profileImage']['name']);
        $imageFilePath = "images/" . $imageFileName;
        if (!move_uploaded_file($_FILES['profileImage']['tmp_name'], $imageFilePath)) {
            die("Failed to upload profile image.");
        }
    }

    // Upload resume
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == UPLOAD_ERR_OK) {
        $resumeFileName = basename($_FILES['resume']['name']);
        $resumeFilePath = "documents/" . $resumeFileName;
        if (!move_uploaded_file($_FILES['resume']['tmp_name'], $resumeFilePath)) {
            die("Failed to upload resume.");
        }
    }

    // Update user data
    $sql = "UPDATE users SET contactNumber = ?, currentJobPosition = ?, image = ?, resume = ?, password = ? WHERE email = ?";
    
    // Prepare statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    if ($password) {
        $stmt->bind_param("ssssss", $contactNumber, $jobPosition, $imageFileName, $resumeFileName, $password, $email);
    } else {
        $stmt->bind_param("ssssss", $contactNumber, $jobPosition, $imageFileName, $resumeFileName, $email);
    }

    if ($stmt->execute()) {
        echo "Information updated successfully!";
    } else {
        echo "Error updating information: " . $conn->error;
    }

    $stmt->close();
}
$conn->close();
?>
