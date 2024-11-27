<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>ProFolio | Group 7</title>
</head>
<body>
    <header>
        <h1><span class="pro">Pro</span>Folio</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
        </nav>
    </header>
    <main>
        <h2>Explore Professionals</h2>
        <section class="team-members">
            <?php
            require 'db_connection.php';
            $sql = "SELECT name, description, resume, image, currentJobPosition FROM users";
            $result = $conn->query($sql);

            while ($profile = $result->fetch_assoc()) {
                $imageUrl = !empty($profile['image']) && file_exists($profile['image']) ? $profile['image'] : "images/edson.jpg";
                $shortDescription = implode(' ', array_slice(explode(' ', $profile['description']), 0, 10)) . (str_word_count($profile['description']) > 10 ? '...' : '');
                
                echo "<div class='member'>
                    <img src='$imageUrl' alt='{$profile['name']}' id='index_image'>
                    <h2 class='name'><span class='accent'>" . strtoupper(explode(' ', $profile['name'])[0]) . " </span>" . strtoupper(substr(strstr($profile['name'], ' '), 1)) . "</h2>
                    <br>
                    <p class='job-position' style='color: white; font-weight:bold;'>{$profile['currentJobPosition']}</p>
                    <p class='description'>$shortDescription</p>
                    <a href='profiles.php?user=" . urlencode($profile['name']) . "'>View Profile</a>";

                if (!empty($profile['resume'])) {
                    echo "<br><a href='{$profile['resume']}' target='_blank'>View Resume</a>";
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
