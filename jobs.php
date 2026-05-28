<?php
   
   require_once 'settings.php';
    $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$dbconn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $search = '';
    if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
        $search = mysqli_real_escape_string($dbconn, trim($_GET['query']));
        $query = "SELECT * FROM jobs WHERE title LIKE '%$search%' OR JobReferenceNum LIKE '%$search%'";
    }   else {
        $query = "SELECT * FROM jobs";
    }

    $result = mysqli_query($dbconn, $query);



?>
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0" >
 <meta name="description" content="Jobs page to show our available positions at TuffDev Medical">
 <meta name="keywords" content="Job Application, Digital Health and Wellness Provider, Positions">
 <meta name="Author" content="Saw Sheng Yang">
 <link rel="stylesheet" href="styles.css">
 <link rel="stylesheet" href="jobs.css">
 <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
 <title>TuffDev Medical - Jobs Positions Available</title>
 <!-- embedded css -->
<style>
    .jobs-intro { 
        text-align: center;
        margin: 40px 0;
    }
    .search-form {
            text-align: center;
            margin: 20px 0;
        }
        .search-form input[type="text"] {
            padding: 0.6rem 1rem;
            width: 300px;
            border: 1px solid #b2d8d8;
            border-radius: 8px 0 0 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            outline: none;
        }
        .search-form button {
            padding: 0.6rem 1.2rem;
            background: #228079;
            color: white;
            border: none;
            border-radius: 0 8px 8px 0;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
        }
        .search-form button:hover {
            background: #124746;
        }
        .no-results {
            text-align: center;
            color: black;
            padding: 2rem;
            font-style: italic;
        }
        .search-result-msg {
            text-align: center;
            color: #228079;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }
</style>
</head>


<!-- navigation bar -->
    <?php include 'include/header.inc'; ?>
    <?php include 'include/nav.inc'; ?>

<!-- main section -->
<main>
    <section class="jobs-intro">
        <h1>Current Job Openings</h1>
        <p style="font-style: italic; color: black;">Join our team and help us expand our digital services team to support online patient platforms, appointment systems, health information websites and much more!</p>
    </section>

    <!-- search bar -->
    <div class="search-form">
        <form action="jobs.php" method="get">
            <label for="job-search" class="visually-hidden" style="color: black;">Search jobs by title or reference number:</label>
            <input id="job-search" type="text" name="query" placeholder="Search jobs by title or reference number..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
        <?php if ($search):  ?>
            <p style="color: black;" class="search-result-msg">
                Showing results for: <strong><?php echo htmlspecialchars($search); ?></strong> &mdash;
                <a href="jobs.php">Clear search</a>
            </p>
        <?php endif; ?>
    </div>

    <aside> 
        <h2>How to Apply</h2>
        <p>To apply for the position, please complete our application form and submit your CV together with a cover letter.</p>
        <h3>Application Checklist</h3>
        <ul>
            <li>Completed application form</li>
            <li>Current CV</li>
            <li>Cover letter</li>
        </ul>
        <h3>Closing Dates</h3>
        <p>Applications will close on <strong>Friday, 15 May 2026</strong></p>
        <h3>Contact Information</h3>
        <p>For enquiries, contact:</p>
        <p><strong>careers@tuffdevmedical.com.au</strong></p>
        <a class="button" href="apply.html">Apply Now</a>
    </aside>

    <div class="job-list"> <!-- Entire Job list -->
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($job = mysqli_fetch_assoc($result)): ?>
                <?php 
                        $responsibilities = json_decode($job['responsibilities'], true);
                        $essential       = json_decode($job['essential_req'], true);
                        $preferable       = json_decode($job['preferable_req'], true);
                ?>
        <section class="job-card"> <!-- Job 1 -->

            <h2>REF: <?php echo htmlspecialchars($job['JobReferenceNum']); ?> - <?php echo htmlspecialchars($job['title']); ?></h2>
            <p class="job-desc"><?php echo htmlspecialchars($job['short_desc']); ?></p>
            <div class="job-info">
                <div><span class="label">Salary</span><span class="value"><?php echo htmlspecialchars($job['salary']); ?></span></div>
                <div><span class="label">Reporting To</span><span class="value"><?php echo htmlspecialchars($job['reporting_to']); ?></span></div>
                <div><span class="label">Employment Type</span><span class="value"><?php echo htmlspecialchars($job['employment_type']); ?></span></div>
                <div><span class="label">Location</span><span class="value"><?php echo htmlspecialchars($job['location']); ?></span></div>
            </div>

            <h3>Key Responsibilities</h3>
            <ol>
                <?php foreach ($responsibilities as $responsibility): ?>
                    <li><?php echo htmlspecialchars($responsibility); ?></li>
                <?php endforeach; ?>
                
            </ol>

            <h3>Requirements</h3>
            <div class="space">
                <h4>Essential</h4>
                <ul>
                    <?php foreach ($essential as $requirements): ?>
                        <li><?php echo htmlspecialchars($requirements); ?></li>
                    <?php endforeach; ?>
               
                </ul>
            </div> 
            <div class="space">
                <h4>Preferable</h4>
                <ul>
                    <?php foreach ($preferable as $requirements): ?>
                        <li><?php echo htmlspecialchars($requirements); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-results" >
                No jobs found matching "<?php echo htmlspecialchars($search); ?>".
                <a href="jobs.php">View all jobs</a>
            </p>
        <?php endif; ?>
    </div>
</main>
    <?php include 'include/footer.inc'; ?>

    </body>
    </html>
    <?php mysqli_close($dbconn); ?>