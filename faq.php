<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="description" content="The Frequently Asked Questions page for those who want an answer to a question that may have been asked before">
    <meta name="keywords" content="Job Application, Digital Health and Wellness Provider, Form Submission">
    <meta name="Author" content="Jermaine Michael">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="faq.css">
    <title>TuffDev Medical - Frequently Asked Questions</title>
    <style>
        .faq-header {
    text-align: center;
    margin-bottom: 2rem;
}
    </style>
</head>

<!-- The body of the FAQ page, what shows up to the viewer -->
<body>
      <?php include 'include/header.inc'; ?>
      <?php include 'include/nav.inc'; ?>

    <!-- Main content of the FAQ page -->
    <main>
        <div class="faq-wrap">
            <div class="faq-header">
                <h1>Frequently Asked Questions</h1>
                <p>Find answers to common questions about our practice and services.</p>
            </div> <!--Closes faq-header  -->


            <!-- PHP section: load database settings and connect to MySQL -->
            <?php
            require_once 'settings.php';
            $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);

            // If the database connection fails, show a user-friendly message
            if (!$dbconn) {
                echo '<div class="faq-section"><p>Unable to connect to the database. Please try again later.</p></div>';
            } else {
                // Query the FAQ table and clean newline characters from category names
                $query = "SELECT TRIM(REPLACE(category, '\r', '')) AS category, question, answer FROM faq ORDER BY category, id";
                $result = mysqli_query($dbconn, $query);

                // If we get results, group them by category and render each section
                if ($result && mysqli_num_rows($result) > 0) {
                    $faqs = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $category = $row['category'];
                        if (!isset($faqs[$category])) {
                            $faqs[$category] = [];
                        }
                        $faqs[$category][] = $row;
                    }

                    // Output a table for each category of FAQ items
                    foreach ($faqs as $category => $items) {
                        echo '<div class="faq-section">';
                        echo '<div class="section-title">' . htmlspecialchars($category) . '</div>';
                        echo '<table><thead><tr><th>Question</th><th>Answer</th></tr></thead><tbody>';

                        foreach ($items as $item) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($item['question']) . '</td>';
                            echo '<td>' . htmlspecialchars($item['answer']) . '</td>';
                            echo '</tr>';
                        }

                        echo '</tbody></table>';
                        echo '</div>';
                    }
                } else {
                    // If the query returned no results, show an empty-state message
                    echo '<div class="faq-section"><p>No FAQs are available at the moment.</p></div>';
                }

                // Close the database connection
                mysqli_close($dbconn);
            }
            ?>

        </div> <!-- Closes faq-wrap  -->
    </main>
    
    <!-- php addition for the footer of the page, which is the same across all pages -->
     <?php include 'include/footer.inc'; ?>

</body>
</html>
