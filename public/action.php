<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: action.php
 * Description: This file acts as a part of a simple PHP app framework for building
 * secure apps. It includes the configuration file and common library, and validates
 * client's IP address against a blacklist. If the IP is blacklisted, an error
 * message is shown and the script stops. The file also checks and validates POST
 * and GET requests, includes corresponding action, and logs actions.
 */

// Include the configuration and common library files
require_once '../config.php';
require_once '../lib/common-lib.php';

// If the client's IP is blacklisted, stop script and display error
if (is_blacklisted(IP)) {
    http_response_code(403);
    appLog("Blacklisted IP: " . IP . " attempted access", 1);
    echo "Your IP address has been blacklisted. If you believe this is an error, please contact us.";
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) { // Handle POST requests
    appLog("Received post action.", 2);
    // Loop over POST data, sanitize and validate inputs, and replace incoming data with sanitized data
    // Log validation failures
    foreach ($_POST as $postvalue => $value) {
        $sanitizedValue = sanitizeInput($value);
        $validatedValue = validateInput($postvalue, $sanitizedValue);
        if ($validatedValue === false) {
            appLog("Validation failed for $postvalue.", 2);
            $error_msg = "Validation failed for $postvalue.";
        }
        $_POST[$postvalue] = $validatedValue;
    }
    // If an action file corresponding to the action is found, include it
    // Else, stop script
    $action = $_POST['action'];
    $path = POST_ACTION . "$action.php";
    if (!empty($action) && file_exists($path)) {
        include $path;
    } else {
        // Suspicious activity from IP
        update_failed_attempts(IP);
        appLog("Suspicious activity from IP: " . IP . "POST request to nonexisting $action.", 1);
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) { // Handle GET requests
    appLog("Received post action.", 2);
    // Sanitize GET data
    foreach ($_GET as $getvalue => $value) {
        $_GET[$getvalue] = sanitizeInput($value);
    }
    // If an action file corresponding to the action is found, include it
    // Else, stop script
    $action = $_GET['action'];
    $path = GET_ACTION . "$action.php";
    if (!empty($action) && file_exists($path)) {
        include $path;
    } else {
        // Suspicious activity from IP
        update_failed_attempts(IP);
        appLog("Suspicious activity from IP: " . IP . "GET request to nonexisting $action.", 1);
        exit;
    }
} else {
    // Stop script if the request is not a POST or GET request with an 'action' parameter
    appLog("Attempted direct access to actions.php.", 1);
    exit;
}
