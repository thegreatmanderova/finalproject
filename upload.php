<?php
include('db_connection.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];
    $contactNumber = trim($_POST['contactNumber']);
    $jobPosition = trim($_POST['jobPosition']);
    $description = trim($_POST['description']);

    // File upload paths
    $targetDir = "uploads/";
    $imageFile = $targetDir . basename($_FILES["profileImage"]["name"]);
    $cvFile = $targetDir . basename($_FILES["cvFile"]["name"]);

    // Upload files
    if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $imageFile) && 
        move_uploaded_file($_FILES["cvFile"]["tmp_name"], $cvFile)) {

        // Update the user record
        $stmt = $conn->prepare("UPDATE users SET contactNumber = ?, currentJobPosition = ?, image = ?, resume = ?, description = ? WHERE userID = ?");
        $stmt->bind_param("sssssi", $contactNumber, $jobPosition, $imageFile, $cvFile, $description, $userId);

        if ($stmt->execute()) {
            // Display success message using JavaScript alert
            echo "<script>alert('Information updated successfully!'); window.location.href = 'login.php';</script>";
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "File upload failed.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ProFolio | Upload Information</title>
  <link rel="stylesheet" href="upload.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="form-container">
    <h1>Your Information</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
      <!-- Contact Number -->
       
      <label for="contact-number">Contact Number:</label>
      <input type="text" id="contact-number" name="contactNumber" placeholder="Enter your contact number" required>
      
      <!-- Current Job Position -->
      <label for="job-position">Current Job Position:</label>
      <input type="text" id="job-position" name="jobPosition" placeholder="Enter your job position" required>

      <!-- Short Self Description -->
      <label for="description">Short Self Description:</label>
      <textarea id="description" name="description" placeholder="Write a short description about yourself" rows="4" required></textarea>
      
      <!-- Profile Image Upload -->
      <label for="profile-image">Profile Image:</label>
      <input type="file" id="profile-image" name="profileImage" accept="image/*" required>
      
      <!-- CV File Upload -->
      <label for="cv-upload">Upload Resume:</label>
      <input type="file" id="cv-upload" name="cvFile" accept=".pdf,.doc,.docx" required>

      <!-- Submit Button -->
      <button type="submit">Save</button>
    </form>
  </div>
</body>
</html>
