<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'profolio';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if 'user' parameter exists in the query string
if (isset($_GET['user'])) {
    $user = $_GET['user'];

    // Prepare the SQL query to fetch profile data
    $stmt = $pdo->prepare("SELECT * FROM users WHERE name = :name");
    $stmt->bindParam(':name', $user);
    $stmt->execute();

    // Fetch the profile data
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($profile) {
        // Profile found, proceed to display
    } else {
        echo "Profile not found.";
        exit;
    }
} else {
    echo "No user specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Resume of <?= htmlspecialchars($user) ?></title>
</head>
<body>
    <header>
        <h1>Resume of <?= htmlspecialchars($user) ?></h1>
        <nav>
            <a href="index.php">Back to Homepage</a>
            <a href="profiles.php?user=<?= urlencode($user) ?>">Back to Profile</a>
        </nav>
    </header>
    <main>
        <h2>Resume of Professional <?= htmlspecialchars($user) ?></h2>
        <p>Position: <?= htmlspecialchars($profile['description']) ?></p>
        <p>Email: <a href="mailto:<?= htmlspecialchars($profile['email']) ?>"><?= htmlspecialchars($profile['email']) ?></a></p>
        <p><a href="resumes/<?= htmlspecialchars($profile['resume']) ?>" download>Download Resume</a></p>
    </main>
</body>
</html>
