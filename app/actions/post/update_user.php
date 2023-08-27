<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: update_user.php
 * Description: This script is used to update user information in our application. It first verifies
 * if the current user has admin rights, then it sanitizes the inputted username, password and email.
 * After that, it hashes the password using BCRYPT algorithm and creates an associative array containing
 * updated user information. This array is passed to the 'updateUserInfo()' function which updates the
 * user's info in the database. If the update is successful, a success message is logged and the user
 * is redirected to '/users'. Otherwise, an error message is logged and the user is again redirected to '/users'.
*/

// Verify if user is logged in and has admin rights
if ($_SESSION['admin'] === true) {

    // Sanitizing the input username, password and email
    $username = ($_POST["username"]);
    $password = ($_POST["password"]);
    $email = ($_POST["email"]);

    // Checking admin rights
    $admin = isset($_POST["admin"]) ? true : false;

    // Creating a hash of the user's password
    $password = password_hash($password, PASSWORD_BCRYPT);

    // Checking if the username, password and email are not empty
    if (!empty($username) && !empty($password) && !empty($email)) {

        // Creating an array with the new user information
        $updatedInfo = [
            "username" => $username,
            "password" => $password,
            "email" => $email,
            "admin" => $admin
        ];

        // Updating user's information and then checking if the update was successful
        if (updateUserInfo($username, $updatedInfo)) {
            $_SESSION['error_msg'] = 'User info updated successfully.';
            appLog("User info updated.", 2);

            // Redirects to users and complete script execution
            header('Location: /users');
            exit();
        } else {
            $_SESSION['error_msg'] = 'Failed to update user info. Please try again.';
            appLog("Failed to update user info.", 2);

            // Redirects to users and complete script execution
            header('Location: /users');
            exit();
        }
    } else {
        $_SESSION['error_msg'] = 'Failed to update user info. Please try again.';
        appLog("Failed to update user info.", 2);

        // Redirects to users and complete script execution
        header('Location: /users');
        exit();
    }
} else {
    // Log Suspicious activity and update failed attempts
    update_invalid_activity(IP);
}
