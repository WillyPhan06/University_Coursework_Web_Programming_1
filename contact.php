<?php
// Load Composer autoloader
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load .env variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database includes
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

startUserSession();

// Get .env values
$ADMIN_EMAIL   = $_ENV['ADMIN_EMAIL'] ?? '';
$SMTP_ENABLED  = filter_var($_ENV['SMTP_ENABLED'] ?? false, FILTER_VALIDATE_BOOLEAN);
$SMTP_USERNAME = $_ENV['SMTP_USERNAME'] ?? '';
$SMTP_PASSWORD = $_ENV['SMTP_PASSWORD'] ?? '';
$SMTP_HOST     = $_ENV['SMTP_HOST'] ?? 'smtp.gmail.com';
$SMTP_PORT     = intval($_ENV['SMTP_PORT'] ?? 587);
$SMTP_SECURE   = strtoupper($_ENV['SMTP_SECURE'] ?? 'STARTTLS');

// Map to PHPMailer constant
switch ($SMTP_SECURE) {
    case 'STARTTLS': $SMTP_SECURE = PHPMailer::ENCRYPTION_STARTTLS; break;
    case 'SMTPS':    $SMTP_SECURE = PHPMailer::ENCRYPTION_SMTPS;   break;
    default:         $SMTP_SECURE = '';
}

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Honeypot field
    $honeypot = $_POST['website'] ?? '';
    if (!empty($honeypot)) {
        $success = true;
        return;
    }

    // === Validation ===
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'All fields are required.';
    } elseif (strlen($name) < 2 || strlen($name) > 100) {
        $error = 'Name must be between 2 and 100 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } elseif (strlen($subject) < 3 || strlen($subject) > 200) {
        $error = 'Subject must be between 3 and 200 characters.';
    } elseif (strlen($message) < 10 || strlen($message) > 5000) {
        $error = 'Message must be between 10 and 5000 characters.';
    } else {

        // === Sending email ===
        try {
            if ($SMTP_ENABLED) {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host       = $SMTP_HOST;
                $mail->SMTPAuth   = true;
                $mail->Username   = $SMTP_USERNAME;
                $mail->Password   = $SMTP_PASSWORD;
                $mail->SMTPSecure = $SMTP_SECURE;
                $mail->Port       = $SMTP_PORT;

                $mail->setFrom($SMTP_USERNAME, 'Website Contact Form');
                $mail->addAddress($ADMIN_EMAIL);
                $mail->addReplyTo($email, $name);

                $mail->isHTML(false);
                $mail->Subject = "Contact Form: $subject";
                $mail->Body    = "Name: $name\nEmail: $email\nSubject: $subject\n\nMessage:\n$message";

                $mail->send();
                $success = true;

            } else {
                // PHP mail() fallback
                $headers = "From: noreply@" . $_SERVER['HTTP_HOST'] . "\r\n";
                $headers .= "Reply-To: " . filter_var($email, FILTER_SANITIZE_EMAIL) . "\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
                $headers .= "X-Mailer: PHP/" . phpversion();

                $mailBody  = "Contact Form Submission\n";
                $mailBody .= "========================\n\n";
                $mailBody .= "Name: $name\n";
                $mailBody .= "Email: $email\n";
                $mailBody .= "Subject: $subject\n\n";
                $mailBody .= "Message:\n$message\n";
                $mailBody .= "========================\n";
                $mailBody .= "Sent from: " . $_SERVER['HTTP_HOST'] . "\n";
                $mailBody .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";
                $mailBody .= "Date: " . date('Y-m-d H:i:s') . "\n";

                if (mail($ADMIN_EMAIL, "Contact Form: $subject", $mailBody, $headers)) {
                    $success = true;
                } else {
                    $error = 'Failed to send email. Please contact the administrator directly.';
                }
            }
        } catch (Exception $e) {
            $error = 'Email could not be sent. Error: ' . $mail->ErrorInfo;
        }
    }
}

// Render template
$title = 'Contact Us';
ob_start();
include 'templates/contact_form.php';
$output = ob_get_clean();
include 'templates/layout.php';
