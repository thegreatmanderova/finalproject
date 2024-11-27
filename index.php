<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>ProFolio | Group 7</title>
</head>

<?php
session_start();
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email and password are provided
    if (!empty($email) && !empty($password)) {
        // Prepare SQL to find the user by email
        $sql = "SELECT id, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Bind result variables
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Set session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['userid'] = $id;
                $_SESSION['email'] = $email;

                // Redirect to the homepage
                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid password. Please try again.";
            }
        } else {
            $error = "No account found with that email.";
        }
        $stmt->close();
    } else {
        $error = "Please enter both email and password.";
    }
}
?>

<?php
$sql = "SELECT name, description, resume, image, currentJobPosition FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$profiles = array();
while ($row = $result->fetch_assoc()) {
    $profiles[] = $row;
}

$stmt->close();
?>

<body>
    <header>
        <h1><span class="pro">Pro</span>Folio</h1>

        <nav>
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <h2>Explore Professionals</h2>
        <section class="team-members">
            <?php
            foreach ($profiles as $profile) {
                $imageFilename = $profile['image'];
                $imagePath = $imageFilename; // Construct the image path
                
                // Check if the image file exists
                $imageUrl = file_exists($imagePath) && !empty($imageFilename) ? $imagePath : "images/edson.jpg"; // Default image

                $resume = isset($profile['resume']) && !empty($profile['resume']) ? $profile['resume'] : null;

                $maxWords = 10;
                $descriptionWords = explode(' ', $profile['description']);
                $shortDescription = implode(' ', array_slice($descriptionWords, 0, $maxWords));
                if (count($descriptionWords) > $maxWords) {
                    $shortDescription .= '...';
                }

                echo "<div class='member'>
                    <img src='$imageUrl' alt='{$profile['name']}' id='index_image'>
                    <h2 class='name'><span class='accent'>" . strtoupper(explode(' ', $profile['name'])[0]) . " </span>" . strtoupper(substr(strstr($profile['name'], ' '), 1)) . "</h2>
                    <br>
                    <p class='job-position' style='color: white; font-weight:bold;'>{$profile['currentJobPosition']}</p>
                    <p class='description'>{$shortDescription}</p>
                    <a href='profiles.php?user=" . urlencode($profile['name']) . "'>View Profile</a><br>";

                if ($resume) {
                    echo "<a href='{$resume}' target='_blank'>View Resume</a>";
                } else {
                    echo "<span class='no-resume'></span>";
                }
                echo "</div>";
            }
            ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 <span class="pro">Pro</span>Folio. All rights reserved.</p>
    </footer>
</body>
</html>
