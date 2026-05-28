<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <meta name="description" content="TuffDev Medical - Exact Template Layout" >
    <meta name="author" content="A. Student" >
    <link rel="stylesheet" href="styles.css" >
    <link rel="stylesheet" href="index.css" >
    <style>
        .left-column, .right-column {
    flex: 1; 
}
    </style>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=DM+Serif+Display&display=swap" >
    <title>TuffDev Medical - Home</title>

       <!-- Topbar/header with brand logo, navigation, and search bar -->
    <?php include 'include/header.inc'; ?>
    <?php include 'include/nav.inc'; ?>

</head>
<body>

    <!-- Main content area with two columns and a divider -->
    <main class="layout">
        
        <section class="left-column">
            
            <div class="header">
                <img src="images/background-removed-background-removed.png" alt="TuffDev Medical Logo"  style="width: 150px; height: 150px;">
                
                <div class="title-text">
                    <h1 class="bold-title">TUFFDEV<br>MEDICAL</h1>
                    <p class="tagline">Keeping you strong, every day</p>
                </div>
            </div>

            <p class="slogan">Helping you stay tuff every day, with high quality care and reliability</p>

            <div class="headingblock">
                <h2>Product Grid</h2>
                <h3>Overview</h3>
            </div>

            <!-- Grid Table with merged cells -->
            <table class="grid-table">
                <tr>
                    <td rowspan="2" class="highlight-cell">Main Feature</td>
                    <td class="cell">Patient Portal</td>
                    <td class="cell">Clinical Records</td>
                </tr>
                <tr>
                    <td>System Specs</td>
                    <td>Australia Wide</td>
                </tr>
                <tr>
                    <td class="highlight-cell">Logistics & Support</td>
                    <td colspan="2">Access client dashboards</td>
                </tr>
            </table>

        </section> <div class="divider-line"></div> <!-- Divider line between columns -->

        <section class="right-column">
            
            <div class="desc-heading">
                <h2>Description</h2>
            </div>
            
            <p class="desc-tagline">Service overview and partnership opportunities</p>
            
            <p class="desc-words">TuffDev Medical is a company that provides health information systems and builds online appointment systems for hospitals and clinics. We are committed to providing excellent customer service. We are always looking for talented individuals to join our team.</p>

            <div class="image-box">
                <img src="images/background-removed-background-removed(3).png" alt="TuffDev Medical team" >
            </div>
        
        </section> </main>

        <!-- Footer with contact information, links and copyright -->
        <?php include 'include/footer.inc'; ?>
