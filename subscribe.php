<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];

    // Email setup
    $to = "acceptjatin@gmail.com"; // Change this to your email address
    $subject = "New Newsletter Subscription";
    $message = "Name: " . $name . "\n" . "Whatsapp Number: " . $number . "\n" . "Email: " . $email;
    $headers = "From: " . $email;

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo '<script>alert("Thank you for subscribing to our newsletter!");</script>';
    } else {
        echo '<script>alert("Sorry, there was an error subscribing to our newsletter. Please try again later.");</script>';
        echo 'Mailer Error: ' . error_get_last()['message']; // Display error message
    }
    // Redirect back to the same page
    echo '<script>window.location.href = "http://'.$_SERVER['HTTP_HOST'].'/";</script>';
}

?>
