<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: user-forms.php
 * Description: This script handles the server-side processing of user-form updates in the Simple App Framework. It sanitizes the input,
 * retrieves the existing user data, checks if the new password matches a specific value, and if not, it hashes the new password.
 * It then checks if crucial fields are filled in, creates an updated user info array and attempts to update the user's info in the database.
 * If the update is successful or fails, it logs an appropriate message and redirects the user back to the users page.
*/

// Check if the form has been submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the update button has been clicked
    if (isset($_POST["updateUserInfo"])) {
        // Sanitize the user input
        $username = sanitizeInput($_POST["username"]);
        $password = sanitizeInput($_POST["password"]);
        $email = sanitizeInput($_POST["email"]);
        // Determine admin status - returns true if set, else it returns false
        $admin = isset($_POST["admin"]) ? true : false;

        // Convert the password into a hash for security purposes
        $password = password_hash($password, PASSWORD_BCRYPT);

        // Check that username, password and email are not empty
        if (!empty($username) && !empty($password) && !empty($email)) {
            // Create array with the new user info
            $updatedInfo = [
                "username" => $username,
                "password" => $password,
                "email" => $email,
                "admin" => $admin
            ];

            // Update user's data, log and redirect or display an error if it fails
            if (updateUserInfo($username, $updatedInfo)) {
                $error_msg = 'User info updated successfully.';
                appLog("User info updated successfully!", 2);
            } else {
                $error_msg = 'Failed to update user info. Please try again.';
                appLog("Failed to update user info. Please try again.", 2);
            }
        } else {
            // Log and display an error if a required field is missing
            $error_msg = 'Failed to update user info. Please try again.';
            appLog("Failed to update user info. Please try again.", 2);
        }
    }

    // Check if the add user button has been clicked
    if (isset($_POST["addUserInfo"])) {
        // Sanitize the user input
        $username = sanitizeInput($_POST["username"]);
        $password = sanitizeInput($_POST["password"]);
        $email = sanitizeInput($_POST["email"]);
        // Determine admin status - returns true if set, else it returns false
        $admin = isset($_POST["admin"]) ? true : false;

        // Hash the password for security purposes
        $password = password_hash($password, PASSWORD_BCRYPT);

        // Check that username, password, and email are not empty
        if (!empty($username) && !empty($password) && !empty($email)) {
            // Create array with the new user's info
            $userInfo = [
                "username" => $username,
                "password" => $password,
                "email" => $email,
                "admin" => $admin
            ];

            // Add the user's data, log and redirect or display an error if it fails
            if (addUserInfo($username, $userInfo)) {
                $error_msg = 'User info added successfully.';
                appLog("User info added successfully!", 2);
            } else {
                $error_msg = 'Failed to add user info. Username may already exist.';
                appLog("Failed to add user info. Username may already exist.", 2);
            }
        } else {
            // Log and redirect or display an error if a required field is missing
            $error_msg = 'Failed to add user info. All fields are required.';
            appLog("Failed to add user info. All fields are required.", 2);
        }
    }
    if (isset($_POST["deleteUserInfo"])) {
        // Sanitize the user form input before processing
        $username = sanitizeInput($_POST["username"]);

        // Check if username is set
        if (!empty($username)) {
            // Delete user's data, log and redirect or display an error on fail
            if (deleteUserInfo($username)) {
                $error_msg = 'User info deleted successfully!';
                appLog("User info deleted successfully!", 2);
            } else {
                $error_msg = 'Failed to delete user info. Please try again.';
                appLog("Failed to delete user info. Please try again.", 2);
            }
        } else {
            $error_msg = 'Please select a user.';
            appLog("Please select a user.", 2);
        }
    }
}
