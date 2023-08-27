<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: delete_user.php
 * Description: This script removes a user from the database. It first checks if the user has the necessary admin
   rights and is logged in. After validating user input, it attempts to delete user data. It logs the results and
   returns feedback messages to the front end.
 */

// Validate if user is logged in and has admin privileges
if ($_SESSION['admin'] === true) {

    // Clean the data received from the POST request for security reasons
    $username = ($_POST["username"]);

    // Verify if username data is provided
    if (!empty($username)) {

        // Attempt to delete the user's information, log the results and provide feedback to the user
        if (deleteUserInfo($username)) {
            $error_msg = 'User info deleted successfully!';
            appLog("User info deleted successfully!", 2);  // Log successful deletion
        } else {
            $error_msg = 'Failed to delete user info. Please try again.';
            appLog("Failed to delete user info. Please try again.", 2); // Log failure in deletion
        }
    } else {
        $error_msg = 'Please select a user.';
        appLog("Please select a user.", 2);  // Log that no user was selected
    }
} else {
    // Log Suspicious activity and update failed attempts
    update_invalid_activity(IP);
}
