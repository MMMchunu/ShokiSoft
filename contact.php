<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include PHPMailer
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize input
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // SMTP Settings
        $mail->isSMTP();
        $mail->Host = 'da16.domains.co.za';
        $mail->SMTPAuth = true;
        $mail->Username = 'sales@shokisoft.co.za';
        $mail->Password = 'Goq00126@';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Sender & Recipient
        $mail->setFrom('sales@shokisoft.co.za', 'Website Contact Form');
        $mail->addAddress('sales@shokisoft.co.za'); // Admin receives message
        $mail->addReplyTo($email, $name); // Reply goes to user

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Message: $subject";

        $mail->Body = "
            <h2>New Contact Message</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Subject:</strong> $subject</p>
            <p><strong>Message:</strong><br>$message</p>

            <hr>
            <p style='font-size:12px;color:#777;'>
                This message was sent from your website contact form.
            </p>
        ";

        $mail->send();

        // Redirect or success message
        echo "<script>alert('Message sent successfully!'); window.location.href='contact.html';</script>";

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

} else {
    header("Location: contact.html");
    exit();
}
?>