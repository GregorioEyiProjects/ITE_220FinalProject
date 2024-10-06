<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input to avoid XSS
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
        $message = htmlspecialchars(trim($_POST['message']));

    // Check if form fields are filled
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Send an email (configure with your email settings)
        $to = "support@yourwebsite.com"; // Change this to your contact email
        $subject = "New Contact Message from $name";
        $headers = "From: $email" . "\r\n" . "Reply-To: $email" . "\r\n";
        $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        if (mail($to, $subject, $body, $headers)) {
            $success_message = "Your message has been sent successfully!";
        } else {
            $error_message = "Oops! Something went wrong. Please try again later.";
        }
    } else {
        $error_message = "Please fill in all the fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../../Styles/V2/contact_page.css">
</head>
<body>

    <div class="contact-container">
        <h1>Contact Us</h1>

        <div class="contact-info">
            <p>We’d love to hear from you! Whether you have questions about our service, need support, or just want to give feedback, feel free to get in touch.</p>
        </div>

        <!-- Display success or error message -->
        <?php if (isset($success_message)): ?>
            <p class="success-message"><?php echo $success_message; ?></p>
        <?php elseif (isset($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <div class="form-container">
            <form action="" method="POST">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" placeholder="Write your message here" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>

        <div class="social-links">
            <p>Connect with us:</p>
            <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
            <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
            <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
        </div>
    </div>

</body>
</html>
