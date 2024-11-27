<?php
session_start();
include('db_connection.php');

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}

$email = $_SESSION['email'];

// Fetch the user's current data
$stmt = $conn->prepare("SELECT name, email FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Information</title>
  <link rel="stylesheet" href="update.css">
</head>
<body>
  <div class="form-container">
    <h1>Update Your Information</h1>
    <form action="update_process.php" method="post" enctype="multipart/form-data">
      <!-- Pre-fill name and email from session -->
      <label for="name">Full Name:</label>
      <input type="text" id="name" name="name" value="<?= $user['name']; ?>" required readonly>
      
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?= $user['email']; ?>" required readonly>
      
      <!-- Other fields for additional information -->
      <label for="contact-number">Contact Number:</label>
      <input type="tel" id="contact-number" name="contactNumber" placeholder="Enter your contact number" required>
      
      <label for="job-position">Current Job Position:</label>
      <input type="text" id="job-position" name="jobPosition" placeholder="Enter your job position" required>
      
      <label for="profile-image">Profile Image:</label>
      <input type="file" id="profile-image" name="profileImage" accept="image/*" required>
      
      <label for="resume-upload">Upload Resume:</label>
      <input type="file" id="resume-upload" name="resume" accept=".pdf,.doc,.docx" required>

      <label for="password">New Password:</label>
      <input type="password" id="password" name="password" placeholder="Enter your new password" required>
      
      <label for="confirm-password">Confirm Password:</label>
      <input type="password" id="confirm-password" name="confirmPassword" placeholder="Confirm your new password" required>
      
      <button type="submit">Update</button>
    </form>
  </div>
</body>
</html>
