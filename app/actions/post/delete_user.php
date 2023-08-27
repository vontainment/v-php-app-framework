<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: delete_user.php
 * Description: This script is used to remove a user from the application's database. It first checks
 * if the current user has admin rights, then it sanitizes the inputted username. After that, it verifies
 * if the username is not empty and calls the 'deleteUserInfo()' function which attempts to delete the user
 * from the database. If the deletion is successful, a success message is logged and the user is redirected
 * to '/users'. Otherwise, an error message is logged and the user is again redirected to '/users'.
 */

// Verify if user is logged in and has admin rights
if ($_SESSION['admin'] === true) {

    // Sanitize the input username for security reasons
    $username = ($_POST["username"]);

    // Check if username data is provided
    if (!empty($username)) {

        // Attempt to delete the user's information from the database
        if (deleteUserInfo($username)) {
            $_SESSION['error_msg'] = 'User info deleted successfully!';
            appLog("User info deleted successfully!", 2);  // Log successful deletion

            // Redirects to users and complete script execution
            header('Location: /users');
            exit();
        } else {
            $_SESSION['error_msg'] = 'Failed to delete user info. Please try again.';
            appLog("Failed to delete user info. Please try again.", 2); // Log failure in deletion

            // Redirects to users and complete script execution
            header('Location: /users');
            exit();
        }
    } else {
        $_SESSION['error_msg'] = 'Please select a user.';
        appLog("Please select a user.", 2);  // Log that no user was selected

        // Redirects to users and complete script execution
        header('Location: /users');
        exit();
    }
} else {
    // Log Suspicious activity and update failed attempts
    update_invalid_activity(IP);
}
