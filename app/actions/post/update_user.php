<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: update_user.php
 * Description: This script is used to update user information in our application. It first checks
 * if the user is logged in and has admin rights. Then it sanitizes the user's input, creates a hash
 * of the user's password and finally calls a function to update the user's information in the database.
*/

if ($_SESSION['admin'] === true) { // Verify if user is logged in and has admin rights
    $username = ($_POST["username"]); // Sanitizing the input username
    $password = ($_POST["password"]); // Sanitizing the input password
    $email = ($_POST["email"]); // Sanitizing the input email
    $admin = isset($_POST["admin"]) ? true : false; // Checking admin rights

    $password = password_hash($password, PASSWORD_BCRYPT); // Creating a hash of the user's password

    // Checking if the username, password and email are not empty
    if (!empty($username) && !empty($password) && !empty($email)) {
        $updatedInfo = [
            "username" => $username,
            "password" => $password,
            "email" => $email,
            "admin" => $admin
        ]; // Creating an array with the new user information

        // Updating user's information and then checking if the update was successful
        if (updateUserInfo($username, $updatedInfo)) {
            $error_msg = 'User info updated successfully.';
            appLog("User info updated.", 2);
        } else {
            $error_msg = 'Failed to update user info. Please try again.';
            appLog("Failed to update user info.", 2);
        }
    } else {
        $error_msg = 'Failed to update user info. Please try again.';
        appLog("Failed to update user info.", 2);
    }
} else {
    // Log Suspicious activity and update failed attempts
    update_invalid_activity(IP);
}
