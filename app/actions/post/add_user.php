<?php
/**
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: add_user.php
 *
 * This script is used to add a user's information to the system. First, it checks
 * whether a user is logged in and has administrative privileges. It then sanitizes
 * user input, hashes the password, and validates that all necessary fields are
 * completed. If so, it adds the user information to the system, logging any errors or
 * successful entries.
 */
session_start();  // Start or resume a session

// Check if user is logged in with administrative privileges
if ($_SESSION['logged_in'] === true && $_SESSION['admin'] === true) {
       $username = ($_POST["username"]);
       $password = ($_POST["password"]);
       $email = ($_POST["email"]);

       // Determine admin status
       $admin = isset($_POST["admin"]) ? true : false;

       // Hash the password for security
       $password = password_hash($password, PASSWORD_BCRYPT);

       // Check that all necessary fields are filled out
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
               $error_msg = 'User info added successfully.';
               appLog("User info added successfully!", 2);
           } else {
               $error_msg = 'Failed to add user info. Username may already exist.';
               appLog("Failed to add user info. Username may already exist.", 2);
           }
       } else {
           $error_msg = 'Failed to add user info. All fields are required.';
           appLog("Failed to add user info. All fields are required.", 2);
       }
} else {
    // If user is not an admin or not logged in, log the unauthorized access and exit
    update_failed_attempts(IP);
    appLog("Unauthorized access to add user from IP: " . IP, 1);
    exit();
}