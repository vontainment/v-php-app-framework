<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: load-lib.php
 * Description: A Simple PHP App Framework for Building Secure Apps
 */

$ip = $_SERVER['REMOTE_ADDR'];
$loggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$isLoginPage = strpos($_SERVER['REQUEST_URI'], '/login') !== false;

appLog("Is Login Page: " . ($isLoginPage ? "True" : "False"), 2);
appLog("IP: " . $ip, 2);
appLog("Logged In: " . ($loggedIn ? "True" : "False"), 2);

if (is_blacklisted($ip)) {
    // Stop the script and show an error if the IP is blacklisted
    appLog("IP is blacklisted.", 1);
    http_response_code(403); // Optional: Set HTTP status code to 403 Forbidden
    echo "Your IP address has been blacklisted. If you believe this is an error, please contact us.";
    exit();
}

if (($isLoginPage && $loggedIn) || (!$isLoginPage && !$loggedIn)) {
    appLog("Redirecting to: " . ($loggedIn ? "/home" : "/login"), 2);
    header('Location: ' . ($loggedIn ? '/home' : '/login'));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["logout"])) {
    appLog("Logout request received.", 2);
    session_destroy();
    header("Location: /login");
    exit();
}

if ((($_SERVER['REQUEST_METHOD'] === 'POST')) && isset($_GET['page'])) {
    $page = $_GET['page'];
    appLog("Processing " . $_SERVER['REQUEST_METHOD'] . " request for page: " . $page, 2);

    // Check if $page-helper.php exists
    $helperFile = "../app/helpers/" . $page . "-helper.php";
    if (file_exists($helperFile)) {
        appLog("Including helper file: " . $helperFile, 2);
        require_once($helperFile);
    }

    // Check if $page-forms.php exists
    $formsFile = "../app/forms/" . $page . "-forms.php";
    if (file_exists($formsFile)) {
        appLog("Including forms file: " . $formsFile, 2);
        require_once($formsFile);
    }
}

if (($_SERVER['REQUEST_METHOD'] === 'GET') && isset($_GET['page'])) {
    $page = $_GET['page'];
    appLog("Processing " . $_SERVER['REQUEST_METHOD'] . " request for page: " . $page, 2);

    $pageJs = "assets/js/" . $page . "-scripts.js";
    if (file_exists($pageJs)) {
        appLog("Found JavaScript file: " . $pageJs, 2);
        $pageJsOutput = "<script src='/assets/js/{$page}-scripts.js'></script>";
    }

    // Check if $page-helper.php exists
    $helperFile = "../app/helpers/" . $page . "-helper.php";
    if (file_exists($helperFile)) {
        appLog("Including helper file: " . $helperFile, 2);
        require_once($helperFile);
    }

    $pageFile = "../app/pages/" . $page . ".php";
    if (file_exists($pageFile)) {
        appLog("Found page file: " . $pageFile, 2);
        $pageOutput = $pageFile;
    }
}