<?php
$to = "acceptjatin@gmail.com"; // Your email address
$subject = "Test email";
$message = "This is a test email sent from the PHP mail function.";
$headers = "From: webmaster@example.com"; // Your domain email address

if (mail($to, $subject, $message, $headers)) {
    echo "Test email sent successfully!";
} else {
    echo "Test email failed to send.";
}
?>
