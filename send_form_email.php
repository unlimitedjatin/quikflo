<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields and remove whitespace
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $type = isset($_POST["retailer"]) ? "Retailer " : "";
    $type .= isset($_POST["partner"]) ? "Partner " : "";
    $type .= isset($_POST["brand"]) ? "Brand " : "";
    $location = trim($_POST["location"]);
    $note = trim($_POST["note"]);

    // Check if all fields are filled
    if (empty($email) || empty($name) || empty($phone) || empty($type) || empty($location)) {
        http_response_code(400);
        echo "<script>alert('Please fill out all fields.'); window.location.href = 'javascript:history.back()';</script>";
        exit;
    }

    // Set the recipient email address
    $to = "community@quikflo.in";

    // Set the email subject
    $subject = "New Referral Submission";

    // Build the email content
    $message = "Email: $email\n";
    $message .= "Name: $name\n";
    $message .= "Phone Number: $phone\n";
    $message .= "Type: $type\n";
    $message .= "Location: $location\n";
    $message .= "Email Note:\n$note\n";

    // Set the email headers
    $headers = "From: $email\n";
    $headers .= "Reply-To: $email\n";

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        http_response_code(200);
        echo "<script>alert('Thank You! Your message has been sent.'); window.location.href = 'javascript:history.back()';</script>";
    } else {
        http_response_code(500);
        echo "<script>alert('Oops! Something went wrong and we couldn't send your message.'); window.location.href = 'javascript:history.back()';</script>";
    }
} else {
    http_response_code(403);
    echo "<script>alert('There was a problem with your submission, please try again.'); window.location.href = 'javascript:history.back()';</script>";
}
?>
