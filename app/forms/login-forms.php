<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: login-forms.php
 * Description: A Simple PHP App Framework for Building Secure Apps
 */

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    appLog("POST request received.", 2);
    if (isset($_POST["login"]) && isset($_POST['username']) && isset($_POST['password'])) {
        appLog("Login form POST fields received.", 2);
        $username = sanitizeInput($_POST['username']);
        $password = sanitizeInput($_POST['password']);

        if (userLogin($username, $password)) {
            appLog("Redirecting to /home.", 2);
            header('Location: /home');
            exit();
        } else {
            // Failed login
            $ip = $_SERVER['REMOTE_ADDR'];
            update_failed_attempts($ip);
            $error_msg = "Invalid username or password.";
            appLog("Failed login from IP: " . $ip, 1);
        }
    }
}