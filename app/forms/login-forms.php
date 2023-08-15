<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: login-forms.php
 * Description: This is a PHP login form script, part of a simple App Framework,
 * which validates login details and performs appropriate actions based on input.
 */

// Check if the login form has been submitted
if (isset($_POST["login"])) {
    // Log the event of form submission
    appLog("Login form POST fields received.", 2);

    // An associative array representing the form inputs.
    // The keys are the name of input field and values are expected datatype
    $inputData = [
        'username' => 'username',
        'password' => 'password',
    ];

    // Call the function to sanitize and validate the form input.
    // This is done to prevent SQL injection and validate input data
    $sanitizedData = processFormInput($inputData);

    // If the sanitized data is valid
    if ($sanitizedData !== false) {
        // Log in with the sanitized username and password
        if (userLogin($sanitizedData['username'], $sanitizedData['password'])) {
            // If login is successful, log this and redirect user to the home page
            appLog("Redirecting to /home.", 2);
            header('Location: /home');
            exit();
        }
    } else {
        // If validation fails, record the IP for security reasons and update the count for failed attempts
        $ip = $_SERVER['REMOTE_ADDR'];
        update_failed_attempts($ip);
        // Set the error message for invalid login details
        $error_msg = "Invalid username or password.";
        // Log the failed login attempt with IP details
        appLog("Failed login from IP: " . $ip, 1);
    }
}
