<?php
session_start(); // Start session

// Clear all session data
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: login.php");
exit();
?>
