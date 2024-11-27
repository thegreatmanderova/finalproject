<?php
// Start session
session_start();

session_destroy();

header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
// Redirect to the login page or a default page
header("Location: login.php");
exit();
?>