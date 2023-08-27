<?php

/**
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: add_user.php
 * Description: This script is used to add a user's information to the system. First, it checks
 * whether a user is logged in and has administrative privileges. It then sanitizes
 * user input, hashes the password, and validates that all necessary fields are
 * completed. If so, it adds the user information to the system, logging any errors or
 * successful entries.
 */

// Verify if user is logged in and has admin rights
if ($_SESSION['admin'] === true) {
    $username = ($_POST["username"]);
    $password = ($_POST["password"]);
    $email = ($_POST["email"]);

    // Determine admin status
    $admin = isset($_POST["admin"]) ? true : false;

    // Hash the password for security
    $password = password_hash($password, PASSWORD_BCRYPT);

    // Check if all necessary fields are filled out
    if (!empty($username) && !empty($password) && !empty($email)) {

        // Prepare new user's information
        $userInfo = [
            "username" => $username,
            "password" => $password,
            "email" => $email,
            "admin" => $admin
        ];

        // Attempt to add the user's information to the system
        if (addUserInfo($username, $userInfo)) {
            $_SESSION['error_msg'] = 'User info added successfully.';
            appLog("User info added successfully!", 2);  // Log successful addition

            // Redirects to users and complete script execution
            header('Location: /users');
            exit();
        } else {
            $_SESSION['error_msg'] = 'Failed to add user info. Username may already exist.';
            appLog("Failed to add user info. Username may already exist.", 2);  // Log failure in addition

            // Redirects to users and complete script execution
            header('Location: /users');
            exit();
        }
    } else {
        $_SESSION['error_msg'] = 'Failed to add user info. All fields are required.';
        appLog("Failed to add user info. All fields are required.", 2);  // Log incomplete form submission

        // Redirects to users and complete script execution
        header('Location: /users');
        exit();
    }
} else {
    // Log suspicious activity and update failed attempts
    update_invalid_activity(IP);
}
