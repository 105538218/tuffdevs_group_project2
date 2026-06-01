<?php
// Read the search query from the URL and normalize it for later use.
$search = '';
if (isset($_GET['query'])) {
    $search = trim($_GET['query']);
}
?>


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

        .search-form {
            text-align: center;
            margin: 20px 0 40px;
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
    
            <!-- Search bar for the FAQ page -->
            <div class="search-form">
              <form action="faq.php" method="get">
            <label for="faq-search" class="visually-hidden" style="color: black;">Search FAQs:</label>
            <input id="faq-search" type="text" name="query" placeholder="Search FAQs..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
        <?php if ($search):  ?>
            <p style="color: black;" class="search-result-msg">
                Showing results for: <strong><?php echo htmlspecialchars($search); ?></strong> &mdash;
                <a href="faq.php">Clear search</a>
            </p>
        <?php endif; ?>
            </div>

            <!-- PHP section: load database settings and connect to MySQL -->
            <?php
            require_once 'settings.php';
            $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);

            // If the database connection fails, show a user-friendly message
            if (!$dbconn) {
                echo '<div class="faq-section"><p>Unable to connect to the database. Please try again later.</p></div>';
            } else {
                // Build a query that optionally filters by the search term
                $query = "SELECT TRIM(REPLACE(category, '\r', '')) AS category, question, answer FROM faq";
                if ($search !== '') {
                    $escapedSearch = mysqli_real_escape_string($dbconn, $search);
                    $query .= " WHERE category LIKE '%$escapedSearch%' OR question LIKE '%$escapedSearch%' OR answer LIKE '%$escapedSearch%'";
                }
                $query .= " ORDER BY category, id";

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
                    if ($search !== '') {
                        echo '<div class="faq-section"><p>No FAQs matched your search.</p></div>';
                    } else {
                        echo '<div class="faq-section"><p>No FAQs are available at the moment.</p></div>';
                    }
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
