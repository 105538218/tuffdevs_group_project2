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
            
            <!-- Each section of the FAQ page in a table, what the questions are on the left and answers on the right -->
            <div id="faq-content">
             <div class="faq-section">
             <div class="section-title">About the practice</div>
                <table>
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Answer</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>What are your hours of operation?</td>
                        <td>We are open 24/7, 365 days a year as we try to serve our community at all times.</td>
                    </tr>

                    <tr>
                        <td>Do you accept new patients?</td>
                        <td>Yes, we are currently accepting new patients of all ages. Call our reception team at 0412 203 304 to book an appointment.</td>
                    </tr>
                    <tr>
                        <td>Where are you located and is parking available?</td>
                        <td>We are located at 123 Main Street, Fitzroy North. Free on-site parking and wheelchair access are available at the main entrance.</td>
                    </tr>
                    </tbody>
                </table>
            </div> <!-- Closes faq-section  -->
            </div> <!-- Closes faq-content  -->

            <div class="faq-section">
            <div class="section-title">Appointments & scheduling</div>
            <table>
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td>How do I book an appointment?</td>
                    <td>Book online through our patient portal, call reception on 0412 203 304, or visit us in person. Online bookings are available 24/7.</td>
                </tr>
                <tr>
                    <td>What is your cancellation policy?</td>
                    <td>Please cancel or reschedule at least 24 hours in advance. Late cancellations or no-shows may incur a fee.</td>
                </tr>
                <tr>
                    <td>Do you offer same-day or urgent appointments?</td>
                    <td>Yes, we reserve slots each day for urgent matters. Call early in the morning to request one. For life-threatening emergencies, call 000.</td>
                </tr>
                </tbody>
            </table>
            </div>

            <div class="faq-section">
            <div class="section-title">Insurance & billing</div>
            <table>
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td>What insurance plans do you accept?</td>
                    <td>We accept Medicare and most major private health funds. We also bulk-bill eligible patients for standard consultations.</td>
                </tr>
                <tr>
                    <td>What payment methods do you accept?</td>
                    <td>Cash, EFTPOS, Visa, Mastercard, and American Express. Medicare rebates are processed on the spot. Payment is due at the end of your visit.</td>
                </tr>
                <tr>
                    <td>What if I don't have insurance?</td>
                    <td>You are still welcome. Medicare covers many services, and we offer a self-pay fee schedule. If all else fails,  we'll New Amsterdam it.</td>
                </tr>
                </tbody>
            </table>
            </div>

            <div class="faq-section">
            <div class="section-title">Telehealth</div>
            <table>
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                    </tr>
                </thead>
                <tbody>
                <tr>   
                    <td>Do you offer telehealth consultations?</td>
                    <td>Yes, video and phone consultations are available for follow-ups, prescription renewals, mental health check-ins, and minor illnesses.</td></tr>
                <tr>
                    <td>What do I need for a video appointment?</td>
                    <td>A device with a camera and microphone plus a stable internet connection. We send a secure browser link — no software download needed.</td>
                </tr>
                </tbody>
            </table>
            </div>

            <div class="faq-section">
            <div class="section-title">Medical records & privacy</div>
            <table>
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td>How do I request my medical records?</td>
                    <td>Complete an authorisation form available at reception. Records are processed within 5-10 business days. A small fee may apply.</td>
                </tr>
                <tr>
                    <td>How is my personal health information protected?</td>
                    <td>We comply with the Australian Privacy Act. Your information is stored securely and only shared with providers involved in your care, or as required by law.</td>
                </tr>
                </tbody>
            </table>
            </div>

            <div class="faq-section">
            <div class="section-title">Prescriptions & referrals</div>
            <table>
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Can I get a prescription renewed without an appointment?</td>
                    <td>Usually a short consultation is required. In some cases a brief telehealth call is sufficient. Please contact us to discuss your situation.</td>
                </tr>
                <tr>
                    <td>How do I get a specialist referral?</td>
                    <td>Referrals are issued by your GP during a consultation. Standard referrals are valid for 12 months; indefinite referrals cover ongoing specialist care.</td>
                </tr>
                </tbody>
            </table>
            </div>

            <div class="faq-section">
            <div class="section-title">Emergencies</div>
            <table>
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td>What should I do in a medical emergency?</td>
                    <td>Call 000 immediately or go to your nearest emergency department. Do not wait for a GP appointment in life-threatening situations.</td>
                </tr>
                <tr>
                    <td>Do you have an after-hours service?</td>
                    <td>We are 24/7, 365 days a year. In the case that we cannot accommodate you, we can refer you to the National Home Doctor Service on 13 74 25, or call Healthdirect on 1800 022 222 for 24/7 nurse advice.</td>
                </tr>
                </tbody>
            </table>
            </div>

        </div> <!-- Closes faq-wrap  -->
    </main>
    
     <?php include 'include/footer.inc'; ?>

