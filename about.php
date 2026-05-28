<!DOCTYPE html>
<html lang="en">
<head>

<!-- adding metadata such as author, keywords and description -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <meta name="description" content="Information About the Team at TuffDev Medical">
    <meta name="keywords" content="About Us, Meet Our Team">
    <meta name="Author" content="Sandiv Wijesekera">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="about.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <title>TuffDevs Medical - About Us</title>
    <style>
      h1 {
        text-align: center;
      }
    </style>

      <?php include 'include/header.inc'; ?>
      <?php include 'include/nav.inc'; ?>
  </head>

  <body>

    <!-- Insert all about page code here -->

    <main class="about-main">


     <!-- #1 Group Info -->
     <section>
        <h1>About Us</h1>
        <h2>TUFFDEV MEDICAL</h2>
        <div class="info-card">
        <ul>
          <li>Our Mission
            <ul>
              <li> At TuffDev Medical, we strive to provide the best digital solutions for the healthcare sector. We work with hospitals to develop and maintain online patient platforms, appointment systems, and health information websites that help staff and patients alike.
            </ul>
          </li>
          <li>Class Day &amp; Time
            <ul>
              <li>Friday, 8:30 AM – 10:30 AM</li>
            </ul>
          </li>
        </ul>
        </div>
     </section>

    <!-- ── #2 MEMBER CONTRIBUTIONS ── -->
     <section class="about-section">
    <h2>Members Contributions</h2>
    <?php
    require_once 'settings.php';
    $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
    if ($dbconn) {
        $query = "SELECT * FROM members_contributions";
        $result = @mysqli_query($dbconn, $query);
        if ($result) {
            echo "<dl>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<dt>" . $row['name'] . " - " . $row['role'] . "</dt>";
                echo "<dd><strong>Part 1:</strong> " . $row['projectpart1_contribution'] . "</dd>";
                echo "<dd><strong>Part 2:</strong> " . $row['projectpart2_contribution'] . "</dd>";
            }
            echo "</dl>";
        }
        mysqli_close($dbconn);
    } else {
        echo "<p>Unable to connect to the database.</p>";
    }
    ?>
</section>

      <!-- ── 04 FUN FACTS TABLE ── -->
      <section class="about-section">
        <h2 class="about-heading">Fun Facts</h2>
        <div class="table-wrap">
          <table class="fun-facts-table">
            <thead>
              <tr>
                <th>Member</th>
                <th>Fun Facts</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="member-name">Sheng Yang</td>
                <td class="fact">"I almost fell down a waterfall as a kid"</td>
              </tr>
              <tr>
                <td class="member-name">Kyla</td>
                <td class="fact">"I like sleeping, gaming, walking, cooking/baking, gardening, and maybe studying if I'm really bored. My passion in life is to succeed."</td>
              </tr>
              <tr>
                <td class="member-name">Layaan</td>
                <td class="fact">"I like to try everything and have many hobbies, my main one is me being an artist. I love to paint/sketch, and i also sing and record karaoke sessions with my friends, and game with them often too."</td>
              </tr>
              <tr>
                <td class="member-name">Jermaine</td>
                <td class="fact">"I've lived in three different countries"</td>
              </tr>
              <tr>
                <td class="member-name">Sandiv</td>
                <td class="fact">"I love new experiences, so i always have a new hobby in rotation. Right now I am learning piano and guitar and have been hiking with my friends. I also love driving, despite petrol prices." </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>


     <section>
        <div class="container">
          <h2 id="photo-heading">Group Photo</h2>
          <figure class="photo-figure">
            <img
              src="images/GroupPhoto.jpeg"
              alt="Five TuffDevs team members smiling"
              width="640"
              height="480"
            >
            <figcaption>
              The TuffDevs team outside Building BA — 2026
            </figcaption>
          </figure>
        </div>
     </section>
     <h2>Acknowledgement of Country</h2>
      <p>We at TuffDev Medical respectfully acknowledge the Wurundjeri People of the Kulin Nation who are the Traditional Owners and custondians of the land on which our center of operations are located in Melbourne. We pay respect to our elder's past, present and emerging.</p>
    </main>
    
    <?php include 'include/footer.inc'; ?>
    
  
