<?php

/**
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * This is a logging library file for a simple app framework for secure PHP apps.
 */

// Primary function logs specific message "Login request received." with priority 2
appLog("Login request received.", 2);

// Retrieval of credentials 'username' and 'password' from POST request
$username = ($_POST['username']);
$password = ($_POST['password']);

// Function to validate credentials against database records
if (userLogin($username, $password)) {
    // Successfully validated credentials are logged wih associated IP address and user redirected to home view
    appLog("Successful login from IP: " . IP, 2);
    header('Location: /home');
    exit();
} else {
    // Failed login attempt is recorded and corresponding error message displayed
    update_failed_attempts(IP);
    // Log the failed login attempt priority 1
    appLog("Failed login from IP: " . IP, 1);
    $error_msg = "Invalid username or password.";
}

/**
 * Function userLogin
 * Checks for match in the database for the input username and password.
 * @param {string} $username - The entered username
 * @param {string} $password - The entered password
 * @return bool - Return true if username and password match, otherwise return false.
 */
function userLogin($username, $password)
{
    // Gathering and logging the retrieved user information
    $userInfo = getUserInfo($username);
    appLog("User info retrieved for user: " . $username, 2);

    // Matching entered credentials with retrieved user information
    // Successful match initiates user login and session variable setup
    if ($userInfo && $username === $userInfo['username'] && password_verify($password, $userInfo['password'])) {
        appLog("Username matches and password verified.", 2);
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $userInfo['email']; // Storing email into session variable
        $_SESSION['admin'] = $userInfo['admin']; // Storing admin flag into session variable
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generating a CSRF token
        $_SESSION['timeout'] = time(); // Setting up a timeout
        session_regenerate_id(true); // Regenerate session ID to prevent session fixation
        return true;
    } else {
        // Non-match of credentials returns false
        return false;
    }
}
