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

