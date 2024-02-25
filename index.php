<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    form {
      max-width: 400px;
      margin: 20px auto;
    }
    label {
      display: block;
      margin-bottom: 8px;
    }
    input, textarea {
      width: 100%;
      padding: 8px;
      margin-bottom: 16px;
      box-sizing: border-box;
    }
    button {
      background-color: #4caf50;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .hidden {
      display: none;
    }
    .error-message {
      color: red;
      font-size: 12px;
      margin-top: -8px;
      margin-bottom: 8px;
    }
  </style>
</head>
<body>

<?php
  // PHP code to handle form submission and validate input data
  $subjectErr = $emailErr = $phoneErr = $messageErr = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST["subject"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    // Basic server-side validation
    if (empty($subject)) {
      $subjectErr = "Subject is required";
    }

    if (empty($email)) {
      $emailErr = "Email is required";
    } elseif (!isValidEmail($email)) {
      $emailErr = "Invalid email format";
    }

    if (!empty($phone) && !isValidPhoneNumber($phone)) {
      $phoneErr = "Invalid phone number format";
    }

    if (empty($message)) {
      $messageErr = "Message is required";
    }

    // Spam protection: Check if the hidden field is empty
    $spamProtection = $_POST["username"];
    if (!empty($spamProtection) || !empty($_POST["trap"])) {
      echo '<script>alert("Spam detected! Please try again.");</script>';
    } elseif (empty($subjectErr) && empty($emailErr) && empty($phoneErr) && empty($messageErr)) {
      // Additional server-side validation logic can be added here

      // Form successfully submitted
      echo '<script>alert("Form submitted successfully!");</script>';

      // You can add additional logic here, like saving the form data to a database
    }
  }

  // Function to validate email format
  function isValidEmail($email) {
    // Simple email validation without using built-in functions
    return preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $email);
  }

  // Function to validate phone number format
  function isValidPhoneNumber($phone) {
    // Simple phone number validation without using built-in functions
    return preg_match("/^[0-9]{10}$/", $phone);
  }
?>

<form id="contactForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <label for="subject">Subject:</label>
  <input type="text" id="subject" name="subject" required>
  <span class="error-message"><?php echo $subjectErr; ?></span>

  <label for="email">Email:</label>
  <input type="text" id="email" name="email" required>
  <span class="error-message"><?php echo $emailErr; ?></span>

  <label for="phone">Phone:</label>
  <input type="text" id="phone" name="phone">
  <span class="error-message"><?php echo $phoneErr; ?></span>

  <label for="message">Message:</label>
  <textarea id="message" name="message" rows="4" required></textarea>
  <span class="error-message"><?php echo $messageErr; ?></span>

  <!-- Add a hidden field for spam protection (honeypot) -->
  <input type="text" name="username" style="display: none;">
  <div style="position: absolute; left: -99999px;">
            <label for="trap">Leave this field empty:</label><br>
            <input type="text" id="trap" name="trap">
    </div>

  <button type="submit">Submit</button>
</form>

</body>
</html>