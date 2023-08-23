<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: api.php
 * Description: A Simple PHP App Framework for Building Secure Apps
 */

// Include the configuration file
require_once '../config.php';

// Include common library
require_once '../lib/common-lib.php';

if (is_blacklisted(IP)) {
    // Stop the script and show an error if the IP is blacklisted
    http_response_code(403); // Optional: Set HTTP status code to 403 Forbidden
    echo "Your IP address has been blacklisted. If you believe this is an error, please contact us.";
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['api'])) {
    appLog("Received post api.", 2);
    foreach ($_POST as $postvalue => $value) {
        $_POST[$postvalue] = sanitizeInput($value);
    }
    $api = $_POST['api'];
    $path = POST_api . "$api.php";
    if (!empty($api) && file_exists($path)) {
        include $path;
    } else {
        exit; // Exit if api is empty or file does not exist
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['api'])) {
    appLog("Received post api.", 2);
    foreach ($_GET as $getvalue => $value) {
        $_GET[$getvalue] = sanitizeInput($value);
    }
    $api = $_GET['api'];
    $path = GET_api . "$api.php";
    if (!empty($api) && file_exists($path)) {
        include $path;
    } else {
        exit; // Exit if api is empty or file does not exist
    }
} else {
    exit; // Exit if not a POST request with api or a GET request with api
}
