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

 <!-- An Example of Internal CSS within the header tag and the style element -->
 <style>
h2 {
   color: cadetblue;
   width: 100%;
   font-size: 1.3rem;
}
</style>
</head>

<!-- <span style="color: #940000;">*</span> is the example of inline CSS -->
<body> <!--Body section of the HTML, where visible content is displayed-->
    <!--Header Section of the page-->
     <?php include '../include/header.inc'; ?>
     <?php include '../include/nav.inc'; ?>

    <!--Banner section of the page-->
    <section class="banner" aria-labelledby="PageBanner">
        <h1 id="PageBanner">Job Application Form</h1>
        <p id="subheading">Complete the form below — all fields marked with "<span style="color: #940000;">★</span>" are required.
        <br>All information provided by the user is handled and stored according to the <em>Privacy Act 1988.</em></p>
        </section>

   <!--Form part of the page, where the user can submit their application and the output is displayed in the
   following link provided in the action attribute-->
   <form method="post" action="https://mercury.swin.edu.au/it000000/formtest.php">
       <!--Main/Body section of the webpage-->
        <main>
        <!--Main fieldset of the whole form in the page-->
       <fieldset class="form">
            <!--Section for Job Reference of the Form-->
            <section class="subfield" aria-labelledby="Position-Details">
                <h2 id="Position-Details">Position Details</h2>
                <p><label for="Job-Reference-Number"><span style="color: #940000;">★</span>Job Reference Number</label>
                <br>The job reference number must match to the given job position which is exactly 5 alphanumeric characters.</p>
                    <!--The pattern ensures the job reference number is exactly 5 characters, which can be alphanumeric-->
                    <input type="text" id="Job-Reference-Number" name="Job-Reference-Number" pattern="^[A-Za-z0-9]{5}$" required="required" placeholder="e.g. ABC12">
            </section>
            <hr>
            <!--Section for Personal Details of the Form-->
           <section class="subfield" aria-labelledby="Personal-Details">
               <h2 id="Personal-Details">Personal Details</h2>
                <div class="name-field"><!--First Name Field-->
                   <!--User must input their first name as required-->
                   <p><label for="First-Name"><span style="color: #940000;">★</span>First Name</label><br>
                       <!--The pattern ensures the name contains only between 0 and 20 alpha characters-->
                       <input type="text" name="First-Name" id="First-Name" pattern="^(.*[A-Za-z]){0,20}" required="required" placeholder="Steven"></p>
                   
                   <!--User must input their last name as required-->
                   <p><label for="Last-Name"><span style="color: #940000;">★</span>Last Name</label><br>
                       <!--The pattern ensures the name contains only between 0 and 20 alpha characters-->
                       <input type="text" name="Last-Name" id="Last-Name" pattern="^(.*[A-Za-z]){0,20}" required="required" placeholder="Smith"></p>
                </div>

                   <!--User must input their date of birth as required-->
                   <p><label for="Date-of-Birth"><span style="color: #940000;">★</span>Date of Birth</label><br>
                       <!--The input type of date ensures the user inputs a valid date format-->
                       <input type="date" name="Date-of-Birth" id="Date-of-Birth" required="required"></p>
            </section>
            <hr>
            <!--Section for Gender of the Form-->
            <section class="subfield" aria-labelledby="User-Gender"> 
                <h2 id="User-Gender">Gender</h2>
                <p><span style="color: #940000;">★</span>Please select your gender</p>
                <!--The first radio button is required in order for the user to input a gender-->
                <fieldset class="GenderList">
                <label class="visually-hidden">Gender Section</label>
                    <p><label for="Prefer-not-to-say">Prefer not to say</label>
                    <input type="radio" id="Prefer-not-to-say" name="Gender" value="Prefer not to say" required="required"> </p>                
                   
                    <p><label for="Non-binary">Non-binary</label>
                    <input type="radio" id="Non-binary" name="Gender" value="Non-binary"></p>

                    <p><label for="Male">Male</label>
                    <input type="radio" id="Male" name="Gender" value="Male"></p>
                                                
                    <p><label for="Female">Female</label>
                    <input type="radio" id="Female" name="Gender" value="Female"></p>
                </fieldset>
            </section>
            <hr>
            <!--Section for Address of the Form-->
           <section class="subfield" aria-labelledby="Address">
               <h2 id="Address">Address</h2>
               <div class="AddressDetails">
                   <!--User must input their street address as required-->
                   <p><label for="Street-Address"><span style="color: #940000;">★</span>Street Address</label><br>
                       <!--The pattern ensures the street address contains only between 0 and 40 alpha characters, numbers, spaces and common punctuation-->
                       <input type="text" id="Street-Address" name="Street-Address" pattern="^[A-Za-z0-9\s\-\,\.]{0,40}$" required="required" placeholder="12 Avenue St"></p>

                   <!--User must input their suburb/town as required-->
                   <p><label for="Suburb-Town"><span style="color: #940000;">★</span>Suburb/Town</label><br>
                       <!--The pattern ensures the suburb/town contains only between 0 and 40 alpha characters, numbers, spaces and common punctuation-->
                       <input type="text" id="Suburb-Town" name="Suburb-Town" pattern="^[A-Za-z0-9\s\-\,\.]{0,40}$" required="required" placeholder="Hawthorn"></p>

                   <!--User must select their state as required-->
                   <p><label for="State"><span style="color: #940000;">★</span>State</label><br>
                       <!--Select tag is used to create a dropdown list-->
                       <select name="State" id="State" required="required">
                           <option value="">Please Select</option><!--"Please Select is used as a placeholder in this instance"-->
                           <option value="VIC">Victoria</option>
                           <option value="NSW">New South Wales</option>
                           <option value="QLD">Queensland</option>
                           <option value="NT">Northern Territory</option>
                           <option value="WA">Western Australia</option>
                           <option value="SA">South Australia</option>
                           <option value="TAS">Tasmania</option>
                           <option value="ACT">Australian Capital Territory</option>
                       </select>
                   </p>
                   <!--User must input their postcode in as required-->
                   <p><label for="PostCode"><span style="color: #940000;">★</span>Post Code</label><br><!--The pattern ensures the postcode is exactly 4 digits-->
                           <input type="text" id="PostCode" name="PostCode" pattern="\d{4}" required="required" placeholder="3000"></p>
                </div>
            </section>
            <hr>
            <!--Section for Contact Information of the Form-->
           <section class="subfield" aria-labelledby="Contact-Information">
               <h2 id="Contact-Information">Contact Information</h2>
               <div class="contactinfo">
                   <!--User must input their email as required-->
                   <p><label for="Email"><span style="color: #940000;">★</span>Email</label><br><!--The pattern ensures the email is valid-->
                       <input type="text" id="Email" name="Email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required="required" placeholder="name@example.com"></p>

                   <!--User must input their phone number as required-->
                   <p><label for="Phone-Number"><span style="color: #940000;">★</span>Phone Number (+61)</label><br>
                       <!--The pattern ensures the phone number is between 8 and 10 digits-->
                       <input type="text" id="Phone-Number" name="Phone-Number" pattern="\d{8,10}" required="required" placeholder="0123 456 789"></p>
                </div>
            </section>
          <hr>
          <!--Section for Job Skills of the Form-->
           <section class="subfield" aria-labelledby="Skills">
               <h2 id="Skills">Job Skills</h2>
                   <p><span style="color: #940000;">★</span>Skill list (select all that apply)</p>
                   <!--The name of the checkbox is the same for all checkboxes so that multiple values can be selected and sent as an array
                   and the id attribute is used to associate the label with the checkbox-->
                   <div class="checkbox-list">
                       <label for="Clear-Communication"><input type="checkbox" id="Clear-Communication" name="Skills" value="Clear Communication">Clear Communication</label>
                       <label for="Customer-Service"><input type="checkbox" id="Customer-Service" name="Skills" value="Customer Service">Customer Service</label>
                       <label for="Data-Analysis"><input type="checkbox" id="Data-Analysis" name="Skills" value="Data Analysis">Data Analysis</label>
                       <label for="Live-Chat-Support"><input type="checkbox" id="Live-Chat-Support" name="Skills" value="Live Chat Support">Live Chat Support</label>
                       <label for="Problem-solving-Skills"><input type="checkbox" id="Problem-solving-Skills" name="Skills" value="Problem-solving Skills">Problem-solving Skills</label>
                       <label for="Time-Management"><input type="checkbox" id="Time-Management" name="Skills" value="Time Management">Time Management</label>
                       <label for="Troubleshooting-Technical-Issues"><input type="checkbox" id="Troubleshooting-Technical-Issues" name="Skills" value="Troubleshooting Technical Issues">Troubleshooting Technical Issues</label>
                       <label for="Grammar-and-Vocabulary"><input type="checkbox" id="Grammar-and-Vocabulary" name="Skills" value="Grammar and Vocabulary">Grammar and Vocabulary</label>
                   </div>

                   <p><label for="Other-Skills">Description of Other Skills (Optional).</label>
                       <!--The textarea allows the user to input a longer description of their other skills, and the placeholder provides guidance on what to write-->
                       <textarea class="textarea" id="Other-Skills" name="Other-Skills" rows="5" cols="100" placeholder="Write other relevant skills here..."></textarea></p>
           </section>

           <hr>
            <!--Section for Document Upload of the Form-->
            <section class="subfield" aria-labelledby="Document-Upload">
                <h2 id="Document-Upload">Document Upload</h2>

                    <p><label for="CV"><span style="color: #940000;">★</span>Upload Current CV</label><br>
                    <br><input type="file" id="CV" name="CV" accept=".pdf,.doc,.docx" required="required"></p>
                    <p><label for="Cover-Letter"><span style="color: #940000;">★</span>Upload Cover Letter </label><br>
                    <br><input type="file" id="Cover-Letter" name="Cover-Letter" accept=".pdf,.doc,.docx"></p>
            </section>

           <!--Submit and Reset Button Sectoin of the Form-->
           <div class="subfield" id="SRButtons">
            <input type="submit" value="Submit Application Form">
            <input type="reset" value="Reset form">
           </div>
        </fieldset>
       </main>
    </form>
                  
       <!--Footer Section-->
        <?php include '../include/footer.inc'; ?>
  
</body>
</html>
