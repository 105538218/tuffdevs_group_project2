<?php
session_start();

/*
    If the user is not logged in, they are sent back to login.php.
    This prevents normal users from directly opening manage.php.
*/
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

/*
    Connect to the database
*/
require_once("settings.php");

$conn = mysqli_connect($host, $user, $pwd, $sql_db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


$message = "";


if (isset($_POST['delete_job'])) {
    $jobRef = mysqli_real_escape_string($conn, $_POST['job_reference']);

    $deleteQuery = "
        DELETE FROM eoi
        WHERE JobReferenceNum = '$jobRef'
    ";

    if (mysqli_query($conn, $deleteQuery)) {
        $message = "EOIs for job reference $jobRef were deleted successfully.";
    } else {
        $message = "Error deleting EOIs.";
    }
}

