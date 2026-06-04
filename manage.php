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

    <section class="admin-grid">

        <div class="admin-card">
            <h2>Search EOIs</h2>

            <form method="get" action="manage.php">
                <label for="jobref">Job Reference</label>
                <input type="text" id="jobref" name="jobref" placeholder="Example: TD001">

                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" placeholder="Applicant first name">

                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" placeholder="Applicant last name">

                <label for="sort">Sort Results By</label>
                <select id="sort" name="sort">
                    <option value="EOINumber">EOI Number</option>
                    <option value="JobReferenceNum">Job Reference</option>
                    <option value="FirstName">First Name</option>
                    <option value="LastName">Last Name</option>
                    <option value="Email">Email</option>
                    <option value="Status">Status</option>
                </select>

                <button type="submit" class="manage-btn">Search</button>
            </form>
        </div>

        <!-- Status update form -->
        <div class="admin-card">
            <h2>Update EOI Status</h2>

            <form method="post" action="manage.php">
                <label for="eoi_number">EOI Number</label>
                <input type="number" id="eoi_number" name="eoi_number" required>

                <label for="status">New Status</label>
                <select id="status" name="status">
                    <option value="New">New</option>
                    <option value="Current">Current</option>
                    <option value="Final">Final</option>
                </select>

                <button type="submit" name="update_status" class="manage-btn">
                    Update Status
                </button>
            </form>
        </div>

        <!-- Delete form -->
        <div class="admin-card danger-card">
            <h2>Delete EOIs</h2>

            <form method="post" action="manage.php">
                <label for="job_reference">Job Reference</label>
                <input type="text" id="job_reference" name="job_reference" placeholder="Example: TD001" required>

                <button
                    type="submit"
                    name="delete_job"
                    class="delete-btn"
                    onclick="return confirm('Are you sure you want to delete all EOIs for this job reference?');">
                    Delete EOIs
                </button>
            </form>
        </div>

    </section> 

    <!-- Results table -->
    <section class="results-section">
        <h2>EOI Results</h2>

        <table class="results-table">
            <tr>
                <th>EOI #</th>
                <th>Job Ref</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
            </tr>

            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['EOINumber']); ?></td>
                        <td><?php echo htmlspecialchars($row['JobReferenceNum']); ?></td>
                        <td><?php echo htmlspecialchars($row['FirstName']); ?></td>
                        <td><?php echo htmlspecialchars($row['LastName']); ?></td>
                        <td><?php echo htmlspecialchars($row['Email']); ?></td>
                        <td><?php echo htmlspecialchars($row['PhoneNum']); ?></td>
                        <td><?php echo htmlspecialchars($row['Status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No EOIs found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </section>

</main>
  
<style>
/*
    Extra page styling
*/




.manage-page {
    padding: 2rem;
    background-color: #f4f6fb;
}

.manage-hero {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    border-left: 6px solid darkgoldenrod;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
}

.manage-hero h1 {
    margin-top: 0;
}

.manage-hero p {
    color: #222;
}

.admin-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: darkslategray;
    color: white;
    padding: 1rem 1.5rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}

.logout-btn {
    background: #c0392b;
    color: white;
    padding: 0.6rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
}

.logout-btn:hover {
    background: #922b21;
}

.message-box {
    background: #e8f6ef;
    color: #1e8449;
    padding: 1rem;
    border-radius: 8px;
    font-weight: bold;
}

.admin-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.admin-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.admin-card h2 {
    margin-top: 0;
    color: darkslategray;
}

.admin-card label {
    display: block;
    margin-top: 1rem;
    font-weight: bold;
    color: darkslategray;
}

.admin-card input,
.admin-card select {
    width: 100%;
    padding: 0.7rem;
    margin-top: 0.4rem;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-sizing: border-box;
    color: #000;

}

.manage-btn {
    margin-top: 1.2rem;
    width: 100%;
    background: rgb(32, 110, 110);
    color: white;
    border: none;
    padding: 0.8rem;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
}

.manage-btn:hover {
    background: darkslategray;
}

.delete-btn {
    margin-top: 1.2rem;
    width: 100%;
    background: #c0392b;
    color: white;
    border: none;
    padding: 0.8rem;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
}

.delete-btn:hover {
    background: #922b21;
}

.results-section {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    overflow-x: auto;
    color: #000;

}

.results-table {
    width: 100%;
    border-collapse: collapse;
}

.results-table th {
    background: darkslategray;
    color: white;
}

.results-table th,
.results-table td {
    padding: 0.8rem;
    border: 1px solid #ddd;
    text-align: left;
    
}

.results-table td {
    color: #222 !important;
}


.results-table tr:nth-child(even) {
    background: #f4f6fb;
}

@media screen and (max-width: 900px) {
    .admin-grid {
        grid-template-columns: 1fr;
    }

    .admin-bar {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
}
</style>   


<?php

mysqli_close($conn);

/*
    Include existing footer
*/
include 'include/footer.inc';
?>
  

   

 







