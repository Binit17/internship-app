<?php
session_start();

// Check if the user is logged in as a company
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'company') {
    header("Location: login.php");
    exit();
}

// Include the database configuration file
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['internship_id'])) {
    $internship_id = $_GET['internship_id'];

    // Delete the internship from the database
    $deleteQuery = "DELETE FROM internships WHERE internship_id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param('i', $internship_id);
    
    if ($deleteStmt->execute()) {
        header("Location: internshipsfromcompany.php");
        exit();
    } else {
        $error = "Error deleting internship: " . $conn->error;
    }
} else {
    header("Location: internshipsfromcompany.php");
    exit();
}
?>
