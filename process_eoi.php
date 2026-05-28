<?php
// Redirect to apply.php if the request method is not POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: apply.php");
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);  // add this
ini_set('display_startup_errors', 1);  // add this

require_once ("settings.php");
$conn = mysqli_connect($host, $user, $pwd, $sql_db);
if(!$conn) {
    echo "<p> Database connection failed". mysqli_connect_error(). "</p>";
}

// Create the eoi table if it doesn't exist
$createTable = "
CREATE TABLE IF NOT EXISTS `eoi` (
`EOINumber` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
`JobReferenceNum` VARCHAR(5) NOT NULL,
`FirstName` VARCHAR(20) NOT NULL,
`LastName` VARCHAR(20) NOT NULL,
`DOB` DATE NOT NULL,
`Gender` ENUM('Prefer not to say','Non-binary','Male','Female') NOT NULL,
`StreetAddress` VARCHAR(40) NOT NULL,
`SuburbTown` VARCHAR(40) NOT NULL,
`State` ENUM('VIC','NSW','QLD','NT','WA','SA','TAS','ACT') NOT NULL,
`PostCode` INT(4) NOT NULL,
`Email` VARCHAR(100) NOT NULL,
`PhoneNum` INT(10) NOT NULL,
`SkillList` varchar(255) NOT NULL,
`CV` MEDIUMBLOB NOT NULL,
`CoverLetter` MEDIUMBLOB NOT NULL,
`Status` SET('New','Current','Final') NOT NULL DEFAULT 'New'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; ";

if (!mysqli_query($conn, $createTable)) {
    echo "Error creating table: " . mysqli_error($conn);
}

// Function to sanitise user input
function sanitise_input($data) {
    $data = trim($data); //remove extra spaces
    $data = stripslashes($data); //remove backslashes
    $data = htmlspecialchars($data); //convert special characters to HTML entities
    return $data;
} //sanitized data is returned

    //variables and sanitisation of user input by POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jobReferenceNumber = sanitise_input($_POST["Job-Reference-Number"]);
    $firstName = sanitise_input($_POST["First-Name"]);
    $lastName = sanitise_input($_POST["Last-Name"]);
    $dateofBirth = sanitise_input($_POST["Date-of-Birth"]);
    $gender = sanitise_input($_POST["Gender"] ?? "");
    $streetaddress = sanitise_input($_POST["Street-Address"]);
    $suburbtown = sanitise_input($_POST["Suburb-Town"]);
    $state = sanitise_input($_POST["State"]);
    $postcode = sanitise_input($_POST["PostCode"]);
    $email = sanitise_input($_POST["Email"]);
    $otherskills = sanitise_input($_POST["Other-Skills"]);

    //strips the spaces between the numbers before validating
    //\s means whitespaces and replaces them with nothing ''
    $phone = preg_replace('/\s+/', '', sanitise_input($_POST["Phone-Number"]));

    // Check if optional fields are set before sanitising
    $skills = isset($_POST["Skills"]) ? implode(", ", array_map('sanitise_input', $_POST["Skills"])) : "";
    
    //? if the statement before is true then performs the after
    //: - otherwise
    $otherskills = empty($otherskills) ? "No other skills mentioned." : $otherskills;

    //Collect all error messages in an array
    $errors = [];

    if (empty($jobReferenceNumber)) {$errors[] = "Job Reference Number is required.";} 
        elseif (!preg_match("/^[A-Za-z0-9]{5}$/", $jobReferenceNumber)) {$errors[] = "Ensure Job Reference Number is 5 alphanumeric characters.";}

    if (empty($firstName)) {$errors[] = "First name is required.";}
        elseif (!preg_match("/^(.*[A-Za-z]){0,20}$/", $firstName)) {$errors[] = "Ensure that the first name is within 20 characters.";}

    if (empty($lastName)) {$errors[] = "Last name is required.";}
        elseif (!preg_match("/^(.*[A-Za-z]){0,20}$/", $lastName)) {$errors[] = "Ensure that the last name is within 20 characters.";}

    if (empty($dateofBirth)) {$errors[] = "Date of Birth is required.";}  
        elseif (!preg_match('/^(0[1-9]|[12]\d|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/', $dateofBirth)) {$errors[] = "Date of Birth must be in DD/MM/YYYY format.";}
    else {
        //splits each part of the string using / into their respective places in the array
        [$day, $month, $year] = explode('/', $dateofBirth);

        //checkdate is a built in function for checking if the date exists
        // Extra check: ensures the date actually exists (e.g. rejects 31/02/2000)
        if (!checkdate((int)$month, (int)$day, (int)$year)) {$errors[] = "Please enter a valid date.";}

        else {$dateofBirth = "$year-$month-$day";}
    }


    if (empty($streetaddress)) {$errors[] = "Address is required.";}
        elseif (!preg_match("/^[A-Za-z0-9\s\-\,\.]{0,40}$/", $streetaddress)) {$errors[] = "Ensure that the address is within 40 characters and contains only letters, numbers, spaces, hyphens, commas, and periods.";}

    if (empty($suburbtown)) {$errors[] = "Suburb/Town is required.";}
        elseif (!preg_match("/^[A-Za-z0-9\s\-\,\.]{0,40}$/", $suburbtown)) {$errors[] = "Ensure that the suburb/town is within 40 characters and contains only letters, numbers, spaces, hyphens, commas, and periods.";}

    if (empty($postcode)) {$errors[] = "Postcode is required.";}
        elseif (!preg_match("/^\d{4}$/", $postcode)) {$errors[] = "Ensure that the postcode is a 4-digit number.";}

    if (empty($email)) {$errors[] = "Email is required.";}
    //name part can start with a letter or number
    //optional group "()?" = can have allowed special characters that finishes with a letter or number before the @
    //domain must start with a letter or num and domain middle can have hyphens but cannot end with one
    //allow sub domains () (e.g. swin.student)
    //tld must be 2,3 characters long
        elseif (!preg_match("/^[a-zA-Z0-9]([a-zA-Z0-9._+-]*[a-zA-Z0-9])?@[a-zA-Z0-9]([a-zA-Z0-9-]*[a-zA-Z0-9])?(\.[a-zA-Z0-9]([a-zA-Z0-9-]*[a-zA-Z0-9])?)*\.[a-zA-Z]{2,3}$/", $email))
            {$errors[] = "Please enter a valid email address.";}

    if (empty($phone)) {$errors[] = "Phone number is required.";}
        elseif (!preg_match("/^0[2-9]\d{8}$/", $phone)) {$errors[] = "Please enter a valid Australian phone number starting with 0.";}

    //Validate that the state is one of the allowed Australian states
    //and not the -Please Select- option
    $allowedStates = ["VIC","NSW","QLD","NT","WA","SA","TAS","ACT"];
    if (empty($state)) {$errors[] = "State is required.";}
        elseif (!in_array($state, $allowedStates, true)) {$errors[] = "Please select a valid Australian state.";}

    if (empty($gender)) {$errors[] = "Gender is required.";}

    if (empty($skills)) {$errors[] = "At least one skill is required.";}

    //For sanitising and handling file upload
    //allowed file extension in an array
    $allowedExts = ['pdf', 'doc', 'docx'];
    //1024 * 1024 = 1MB * 5 = 5MB
    $maxFileSize = 5 * 1024 * 1024; // 5 MB
    
    $uploadedFiles = [];

    $cv = $_FILES["CV"];
    $cv_name = preg_replace('/[^A-Za-z0-9._\-]/', '_', basename($cv["name"]));
    $cvpath = strtolower(pathinfo($cv_name, PATHINFO_EXTENSION));
    if (empty($cv)) {$errors[] = "CV is required";}
        elseif ($cv["size"] > $maxFileSize) {$errors[] = "CV file size exceeds the allowed size (5MB).";}
        elseif (!in_array($cvpath, $allowedExts, true)) {$errors[] = "CV must be a PDF, DOC, or DOCX file.";}
    else {
        //Sets the folder path where CV files will be saved on the server.
        $uploadDir = 'uploads/cvs/';
        //checks if the folder exist  then manually creates the folder with set permissions
        //0777 gives everyone fill read/write/execute permission
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        //creates the filename to save to server
        $cvFileName = $cv_name;
        //Take the cover letter from PHP's temporary folder
        //then it gets deleted when the script finishes so move_upload_file then moves it to the
        //save it permanently into uploads/coverletters/ with the correct filename."
        move_uploaded_file($cv["tmp_name"], $uploadDir . $cvFileName);
        //saves into the array with the label
        //the label contains the information of the folderpath + filename
        $uploadedFiles["CV"] = $cvFileName;
    }

    $coverLetter = $_FILES["Cover-Letter"];
    $cl_name = preg_replace('/[^A-Za-z0-9._\-]/', '_', basename($coverLetter["name"]));
    $coverLetterPath = strtolower(pathinfo($cl_name, PATHINFO_EXTENSION));
    if (empty($coverLetter)) {$errors[] = "Cover Letter is required";}
        elseif ($coverLetter["size"] > $maxFileSize) {$errors[] = "Cover letter file size exceeds the allowed size (5MB).";}
        elseif (!in_array($coverLetterPath, $allowedExts, true)) {$errors[] = "Cover Letter must be a PDF, DOC, or DOCX file.";}
    else {
        //Sets the folder path where CV files will be saved on the server.
        $uploadDir = 'uploads/coverletters/';
        //checks if the folder exist  then manually creates the folder with set permissions
        //0777 gives everyone fill read/write/execute permission
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        //creates the filename to save to server
        $clFileName = $cl_name;
        //Take the cover letter from PHP's temporary folder
        //then it gets deleted when the script finishes so move_upload_file then moves it to the
        //save it permanently into uploads/coverletters/ with the correct filename."
        move_uploaded_file($coverLetter["tmp_name"], $uploadDir . $clFileName);
        //saves into the array with the label
        //the label contains the information of the folderpath + filename
        $uploadedFiles["Cover-Letter"] = $clFileName;
    }
    //array labels are given back to the correct variables
    $cv = $uploadedFiles["CV"] ?? "";
    $coverLetter = $uploadedFiles["Cover-Letter"] ?? "";

}
    //Show errors if there are any
if (!empty($errors)) {
    mysqli_close($conn);
    ?>
    <!DOCTYPE html>
    <html lang="en"><!--Declares the language of the document, hence english-->
    <head><!--Head section of the HTML, where information of the website is stored-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="The application form page for those wanting the job position for the Digital Health and Wellness Provider">
    <meta name="keywords" content="Job Application, Digital Health and Wellness Provider, Form Submission">
    <meta name="Author" content="Kyla Solomon">
    <link type= "text/css" rel="stylesheet" href="apply.css">
    <link rel="stylesheet" href="styles.css">
    <title>TuffDev Medical Application Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
        <style>
            h1 {
                color: #940000;   
            }
            #outputbtn {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                column-gap: 10px;
                cursor: pointer;
            }
            #backToForm, #backToHome {
                text-align: center;
                font-size: 14px;
                border: .5px solid #ccc;
                text-decoration: none;
                color : #000000;
                padding: 10px 10px;
                background-color: rgb(210, 241, 241);
                cursor: pointer;
            }
        </style>
    </head>

    <body>
        <?php include("include/header.inc"); ?>
        <div id="main">
            <!--Banner section of the page-->
            <section class="banner" aria-labelledby="PageBanner">
                <h1 id="PageBanner">Job Application Form Failed</h1>
                <p id="subheading">Please go back to the form page using the <strong>"Back to Form"</strong> button to fix any errors listed below.<br>
                Otherwise, you can return to the homepage using the <strong>"Back to Home"</strong> button</p>
            </section>

            <fieldset class="form">
                <!-- Display all error messages -->
                <?php
                    foreach ($errors as $error) {
                        echo "<ul>";
                        echo "<li><p style='color:red;'>" . htmlspecialchars($error) . "</p></li>";
                        echo "</ul>";
                    }
                    echo "<p><strong>Please go back and fix the errors.</strong></p>";
                ?>
                <div class="subfield" id="outputbtn">
                    <a id="backToForm" href="apply.php">Back to Form</a>
                    <a id="backToHome" href="index.php">Back to Home</a>
                </div>
            </fieldset>
        </div>
        <?php include("include/footer.inc"); ?>  
    </body>
    </html>
    <!-- Start of success plage form -->
    <?php
        exit();
}
    //to retrieve the newly created EOINumber for the current application
    $sql = "SELECT MAX(EOINumber) AS max_eoi FROM eoi"; //get the maximum EOINumber from the eoi table
    $result = mysqli_query($conn, $sql); //execute the query and store the result
    $row = mysqli_fetch_assoc($result); //fetch the result as an associative array
    $newEOINumber = ($row['max_eoi'] === null) ? 1 : $row['max_eoi'] + 1; 
    //handle empty table
    //increment the maximum EOINumber by 1 to get the new EOINumber for the current application

    //Insert data into database
    $sqlcode = "INSERT INTO eoi (JobReferenceNum, FirstName, LastName, DOB, Gender, StreetAddress, SuburbTown, State, PostCode, Email, PhoneNum, SkillList, OtherSkills, CV, CoverLetter) 
        VALUES ('$jobReferenceNumber', '$firstName', '$lastName', '$dateofBirth', '$gender',
        '$streetaddress', '$suburbtown', '$state', '$postcode', '$email',
        '$phone', '$skills', '$otherskills', '$cv', '$coverLetter')";
    ?>
    <!DOCTYPE html>
    <html lang="en"><!--Declares the language of the document, hence english-->
    <head><!--Head section of the HTML, where information of the website is stored-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="The application form page for those wanting the job position for the Digital Health and Wellness Provider">
    <meta name="keywords" content="Job Application, Digital Health and Wellness Provider, Form Submission">
    <meta name="Author" content="Kyla Solomon">
    <link type= "text/css" rel="stylesheet" href="apply.css">
    <link rel="stylesheet" href="styles.css">
    <title>TuffDev Medical Application Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
        <style>
            h1 {
                color: #009445;   
            }
            #outputbtn {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                column-gap: 10px;
                cursor: pointer;
            }
            #backToHome, #backToJobs {
                text-align: center;
                font-size: 14px;
                border: .5px solid #ccc;
                text-decoration: none;
                color : #000000;
                padding: 10px 10px;
                background-color: rgb(210, 241, 241);
                cursor: pointer;
            }
        </style>
    </head>

    <body>
        <?php include("include/header.inc"); ?>
        <div id="main">
            <!--Banner section of the page-->
            <section class="banner" aria-labelledby="PageBanner">
                <h1 id="PageBanner">Job Application Form Successful</h1>
                <p id="subheading">The Job Application Form was submitted successfully.<br>
                You can proceed back to the homepage using the <strong>"Back to Home"</strong> button.<br>
                However, you can apply for more positions at the Jobs page using the <strong>"Back to Jobs"</strong> button.</p>
            </section>

            <fieldset class="form">
                <?php
                    if (mysqli_query($conn, $sqlcode)) {
                        echo "<p>🔔Ensure your email notifications is on for further updates about your application from <strong>careers@tuffdevmedical.com.au</strong>.
                        <br>Your information below has been sent to the careers team at &copy;TuffDev Medical with your respective Expression of Interest number.</p>";
                        echo "<p><strong>Expression of Interest Number:</strong> " . htmlspecialchars($newEOINumber) . "</p>";
                        echo "<p><strong>Name:</strong> " . htmlspecialchars($firstName) . " " . htmlspecialchars($lastName) . "</p>";
                        echo "<p><strong>Job Reference Number:</strong> " . htmlspecialchars($jobReferenceNumber) . "</p>";
                        echo "<p><strong>Date of Birth:</strong> " . htmlspecialchars($dateofBirth) . "</p>";
                        echo "<p><strong>Gender:</strong> " . htmlspecialchars($gender) . "</p>";
                        echo "<p><strong>Address:</strong> " . htmlspecialchars($streetaddress) .", " . htmlspecialchars($suburbtown) . ", " . htmlspecialchars($state) . " " . htmlspecialchars($postcode) . "</p>";
                        echo "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
                        echo "<p><strong>Phone Number:</strong> " . htmlspecialchars($phone) . "</p>";
                        echo "<p><strong>Skills:</strong> " . htmlspecialchars($skills) . "</p>";
                        echo "<p><strong>Other Skills:</strong> " . htmlspecialchars($otherskills). "</p>";
                        echo "<p><strong>CV:</strong> " . htmlspecialchars($cv) . "</p>";
                        echo "<p><strong>Cover Letter:</strong> " . htmlspecialchars($coverLetter) . "</p>";
                    } else {
                        echo "<p style='color:red'> Error:" . mysqli_error($conn) . "</p>";
                    }
                ?>
                <div class="subfield" id="outputbtn">
                    <a id="backToHome" href="index.php">Back to Home</a>
                    <a id="backToJobs" href="jobs.php">Back to Jobs</a>
                </div>
            </fieldset>
        </div>
        <?php include("include/footer.inc"); ?>
    </body>
    </html>
