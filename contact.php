<?php
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

startUserSession();

$error = '';
$success = false;
$ADMIN_EMAIL = 'admin@example.com'; // Change this to your admin email

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } elseif (strlen($message) > 5000) {
        $error = 'Message is too long (max 5000 characters).';
    } else {
        // Send email
        $headers = "From: " . htmlspecialchars($email) . "\r\n";
        $headers .= "Reply-To: " . htmlspecialchars($email) . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        $mailBody = "Name: " . htmlspecialchars($name) . "\r\n";
        $mailBody .= "Email: " . htmlspecialchars($email) . "\r\n";
        $mailBody .= "Subject: " . htmlspecialchars($subject) . "\r\n\r\n";
        $mailBody .= "Message:\r\n";
        $mailBody .= htmlspecialchars($message);

        if (mail($ADMIN_EMAIL, "Contact Form: " . htmlspecialchars($subject), $mailBody, $headers)) {
            $success = true;
        } else {
            $error = 'Failed to send email. Please try again later.';
        }
    }
}

$title = 'Contact Us';
ob_start();
include 'templates/contact_form.php';
$output = ob_get_clean();
include 'templates/layout.php';
?>
