<?php
// Database connection
$host = "localhost";
$dbname = "profolio";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Retrieve user profile
if (isset($_GET['user'])) {
    $user = $_GET['user'];

    // Use prepared statements to prevent SQL injection
    $stmt = $pdo->prepare("SELECT * FROM users WHERE name = :name");
    $stmt->execute(['name' => $user]);

    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$profile) {
        echo "Profile not found.";
        exit;
    }

    // Construct image file path
    $imageFile = !empty($profile['image']) ? htmlspecialchars($profile['image']) : "default-avatar.png";

    $resumeFile = isset($profile['resume']) && !empty($profile['resume']) ? $profile['resume'] : null;

} else {
    echo "Profile not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title><?= htmlspecialchars($profile['name']) ?>'s Profile</title>
</head>
<body>
    <header>
        <h1><?= htmlspecialchars($profile['name']) ?>'s Profile</h1>
        <nav>
            <a href="main_index.php">Home</a>
        <?php
            // Display "View Resume" link if resume exists
        if ($resumeFile) {
             echo "<a href='{$resumeFile}' target='_blank'>View Resume</a>";
        } else {
            echo "<span>No Resume Available</span>";
        }
        ?>
        </nav>
    </header>
    <main style="display: flex; flex-direction: column; align-items: center; justify-content: center; margin: 20px auto;">
        <!-- Dynamic Profile Picture -->
        <div style="width: 300px; height: 400px; border-radius: 15px; overflow: hidden; background-color: #003d5c;">
            <img src="<?= $imageFile ?>" alt="Profile Picture"
                 style="width: 100%; height: 100%; object-fit: cover; display: block;" />
        </div>

        <!-- Name and Job Title -->
        <h3 style="font-size: 2em; margin: 10px 0;"><?= htmlspecialchars($profile['name']) ?></h3>
        <p style="font-size: 1.2em; color: #6A1E55; margin: 5px 0 15px;">
           <?= htmlspecialchars($profile['currentJobPosition'] ?? 'Not Specified') ?>
        </p>

        <!-- Description -->
        <p style="font-size: 1em; line-height: 1.6; margin: 15px; text-align: center; display: flex; justify-content: center; align-items: center; height: 100%; width: 40%; font-style: italic;">
            <?= htmlspecialchars($profile['description'] ?? 'No description provided.') ?>
        </p>

        <!-- Contact Information -->
        <p style="font-size: 1em; margin: 15px 0 5px; color: black">
            Email: <a href="mailto:<?= htmlspecialchars($profile['email']) ?>" style="color: #6A1E55; text-decoration: none; font-weight: bold;"><?= htmlspecialchars($profile['email']) ?></a>
        </p>
        <p style="font-size: 1em; margin: 5px 0; color: black">
            Contact Number: <span style="color: #6A1E55; font-weight: bold;"><?= htmlspecialchars($profile['contactNumber'] ?? 'Not Specified') ?></span>
        </p>
    </main>

    <footer>
        <p>&copy; 2024 <span class="pro">Pro</span>Folio. All rights reserved.</p>
    </footer>
</body>
</html>
