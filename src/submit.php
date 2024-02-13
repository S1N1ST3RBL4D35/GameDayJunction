<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    // Validate empty fields
    if (empty($name) || empty($email) || empty($message)) {
        $resultMessage = "All fields are required. Please fill out the form completely.";
        $resultColor = "red";
    } else {
        // Validate name format (allow only letters and spaces)
        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $resultMessage = "Invalid name format. Please enter a valid name.";
            $resultColor = "red";
        } else {
            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $resultMessage = "Invalid email format. Please enter a valid email address.";
                $resultColor = "red";
            } else {
                // Additional email checks (customize as needed)
                $disallowedDomains = ['example.com', 'test.com'];
                $emailDomain = explode('@', $email)[1];
                if (in_array($emailDomain, $disallowedDomains)) {
                    $resultMessage = "Email from this domain is not allowed.";
                    $resultColor = "red";
                } else {
                    // Validate message length
                    if (strlen($message) > 1000) {
                        $resultMessage = "Message is too long. Please limit your message to 1000 characters.";
                        $resultColor = "red";
                    } else {
                        // Additional validations...

                        // Send email
                        $to = "gamedayjunction93@gmail.com";
                        $subject = "New Contact Form Submission";
                        $headers = "From: $email";

                        if (mail($to, $subject, $message, $headers)) {
                            $resultMessage = "Message sent successfully. Please allow some time for delivery and response.";
                            $resultColor = "green";
                        } else {
                            $resultMessage = "Message failed to send. Please try again later.";
                            $resultColor = "red";
                        }
                    }
                }
            }
        }
    }

    // Redirect with query parameters
    header("Location: contact.html?resultMessage=" . urlencode($resultMessage) . "&resultColor=" . $resultColor);
    exit();
} else {
    header("Location: contact.html");
    exit();
}
?>
