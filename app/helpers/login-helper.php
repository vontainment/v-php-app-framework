<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: login-helper.php
 * Description: A Simple PHP App Framework for Building Secure Apps
 */
function userLogin($username, $password) {
    // Get user info
    $userInfo = getUserInfo($username); // use the sanitized username
    appLog("User info retrieved for user: " . $username, 2);

    // Combined condition to check username matches and password is verified
    if ($userInfo && $username === $userInfo['username'] && password_verify($password, $userInfo['password'])) {
        appLog("Username matches and password verified.", 2);
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $userInfo['email']; // set email to session
        $_SESSION['admin'] = $userInfo['admin']; // set admin to session
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['timeout'] = time();
        session_regenerate_id(true);
        return true;
    } else {
        return false;
    }
}
