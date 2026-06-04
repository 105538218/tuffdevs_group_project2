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

/*
   Update EOI status code
*/

if (isset($_POST['update_status'])) {
    $eoiNumber = (int) $_POST['eoi_number'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $updateQuery = "
        UPDATE eoi
        SET Status = '$status'
        WHERE EOINumber = $eoiNumber
    ";

    if (mysqli_query($conn, $updateQuery)) {
        $message = "EOI #$eoiNumber status updated to $status.";
    } else {
        $message = "Error updating EOI status.";
    }
}

/*
    Search and sorting setup
*/

$whereParts = [];
$orderBy = "EOINumber";

/*
    Allow safe sorting only preventing users from injecting unsafe SQL into the sort field.
*/
$allowedSorts = [
    "EOINumber",
    "JobReferenceNum",
    "FirstName",
    "LastName",
    "Email",
    "Status"
];

if (!empty($_GET['sort']) && in_array($_GET['sort'], $allowedSorts)) {
    $orderBy = $_GET['sort'];
}

/*
    Search by job reference
*/




if (!empty($_GET['jobref'])) {
    $jobRef = mysqli_real_escape_string($conn, $_GET['jobref']);
    $whereParts[] = "JobReferenceNum = '$jobRef'";
}

/*
    Search by first name
*/




if (!empty($_GET['firstname'])) {
    $fname = mysqli_real_escape_string($conn, $_GET['firstname']);
    $whereParts[] = "FirstName LIKE '%$fname%'";
}  


/*
    Search by last name
*/



if (!empty($_GET['lastname'])) {
    $lname = mysqli_real_escape_string($conn, $_GET['lastname']);
    $whereParts[] = "LastName LIKE '%$lname%'";
}



/*
    If no filters are used, all EOIs are displayed.
    If filters are used, they are joined with AND.
*/



$whereClause = "";

if (count($whereParts) > 0) {
    $whereClause = "WHERE " . implode(" AND ", $whereParts);
}  


/*
    lists all EOIs sorted by the manager's selected field.
*/


$query = "
    SELECT *
    FROM eoi
    $whereClause
    ORDER BY $orderBy
";

$result = mysqli_query($conn, $query);
?>
 
<?php

/*
    Include existing site header and navigation which 
    keeps the manage page consistent with
    the rest of the website.
*/

include 'include/header.inc';
include 'include/nav.inc';
?>

<!DOCTYPE html>
<html lang="en">
<main class="manage-page">

    <!-- Page heading -->
    <section class="manage-hero">
        <h1>HR Management Panel</h1>
        <p>
            View, search, sort, update and manage Expressions of Interest
            submitted through the TuffDev Medical careers portal.
        </p>
    </section>  
     <!-- Logged-in manager information and logout button -->
    <section class="admin-bar">
        <p>
            Logged in as
            <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
        </p>

        <a href="logout.php" class="logout-btn">Logout</a>
    </section>

     <!-- Success/error message -->
    <?php if ($message != ""): ?>
        <p class="message-box">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php endif; ?>  

   

 







