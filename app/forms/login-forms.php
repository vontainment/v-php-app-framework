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
        $username = sanitize_input($_POST['username']);
        $password = sanitize_input($_POST['password']);

        // Get user info
        $userInfo = getUserInfo($username); // use the sanitized username
        appLog("User info retrieved for user: " . $username, 2);

        // Combined condition to check username matches and password is verified
        if ($userInfo && $username === $userInfo['username'] && password_verify($password, $userInfo['password'])) {
            appLog("Username matches and password verified.", 2);
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['timeout'] = time();
            session_regenerate_id(true);
            appLog("Redirecting to /home.", 2);
            header('Location: /home');
            exit();
        } else {
            // Failed login
            $ip = $_SERVER['REMOTE_ADDR'];
            appLog("Failed login from IP: " . $ip, 1);
        }
    }
}