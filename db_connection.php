<!-- db_connection.php -->
<?php
$servername = "localhost"; // Change if your DB is hosted elsewhere
$name = "root"; // Your database username
$password = ""; // Your database password
$dbname = "profolio"; // Your database name

// Create connection
$conn = new mysqli($servername, $name, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>