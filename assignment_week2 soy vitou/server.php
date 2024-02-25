<?php

    // Check if the honeypot field is filled
    if (!empty($_POST['website1']) || !empty($_POST['website2']) || !empty($_POST['website3'])) {
        // Handle as spam
        die("Spam detected. Your submission could not be processed.");
    }

    if(isset($_POST['subject']) && $_POST['email'] && $_POST['message']){
        // Sanitize input data
        $subject = htmlspecialchars($_POST['subject']);
        $email = htmlspecialchars($_POST['email']);
        $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
        $message = htmlspecialchars($_POST['message']);

        // Subject
        if (strlen($subject) > 125) {
            echo "Subject is too long. Please keep it under 125 characters.";
            exit;
        }

        // Email
        if (!preg_match('/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/', $email)) {
            echo "Please enter a valid email address.";
            exit;
        }

        // Phone (optional)
        if (!empty($phone) && !preg_match('/^\d+$/', $phone)) {
            echo "Please enter a valid phone number (numbers only).";
            exit;
        } else if (strlen($phone) > 15) {
            echo "Phone number is too long. Please keep it under 15 characters.";
            exit;
        }
        // Message
        if (strlen($message) > 3000) {
            echo "Message is too long. Please keep it under 3000 characters.";
            exit;
        }

        

        $to = "soyvitou999@gmail.com";
        $subject = $subject;
        $body = "Subject: $subject\nEmail: $email\nPhone: $phone\nMessage: $message";
        $headers = "From: $email";

        // Send email
        if ($subject && $email && $message) {
            echo "Successfully send email";
        } else {
            echo "Failed to send email. Please try again later.";
        }
    } else {
        echo "Go filed your blank again!";
    }
    
?>