<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $fname      = strip_tags(trim($_POST["fname"]));
		$fname      = str_replace(array("\r","\n"),array(" "," "),$fname);
        $email      = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $lname      = trim($_POST["lname"]);
        $phone      = trim($_POST["phone"]);
        $message    = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($fname) OR empty($phone) OR empty($lname) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "naeemislam.pa@gmail.com";

        // Set the email subject.
        $phone = "New contact from $fname";

        // Build the email content.
        $email_content = "First Name: $fname\n";
        $email_content = "Last Name: $lname\n";
        $email_content .= "Emailn: $email\n\n";
        $email_content .= "Phone: $phone\\n";
        $email_content .= "Message:\n$message\n";

        // Build the email headers.
        $email_headers = "From: $fname <$email>";

        // Send the email.
        if (mail($recipient, $phone, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>