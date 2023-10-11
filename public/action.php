<?php

/**
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: action.php
 * Description: This file is a part of the Simple App Framework, responsible for handling
 * HTTP requests and actions. It starts or resumes a session, includes necessary configuration
 * files and libraries, checks whether the client's IP address is blacklisted, validates POST
 * and GET requests, includes appropriate action files based on request type, and logs actions.
 */

// The session is being started or resumed.
session_start();

// Importing the configuration settings from the file 'config.php'.
require_once '../config.php';
require_once '../lib/common-lib.php';

// Checking if the visitor's IP address is blacklisted.
if (is_blacklisted(IP)) {
    // If the visitor's IP address is blacklisted,
    // HTTP response code 403 is returned and an error message is shown.
    appLog("Blacklisted IP: " . $ip . "blocked", 1);
    http_response_code(403);
    die("Your IP address has been blacklisted. If you believe this is an error, please contact us.");
} else {
    // Parse URL to get the actionType from the path
    $parsedUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $components = explode('/', str_replace('/actions/', '', $parsedUrl));

    if ((isset($_GET['action']) || isset($_POST['action'])) && count($components) === 1 && !empty($components[0])) {
        $actionType = $components[0];
        $action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];

        switch ($actionType) {
            case 'api':
                // Validate and require API action
                $filePath = ACTIONS_DIR . "/api/{$action}.php";
                if (($_SERVER['REQUEST_METHOD'] === 'GET') && file_exists($filePath)) {
                    foreach ($_GET as $getvalue => $value) {
                        $_GET[$getvalue] = validateInput($getvalue, sanitizeInput($value));  // Changed $postvalue to $getvalue
                        if ($_GET[$getvalue] === false) {
                            $_SESSION['error_msg'] = "Validation failed for Input.";
                            header('Location: ' . $_SERVER['HTTP_REFERER']);
                            exit();
                        }
                    }
                    require_once($filePath);
                } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && file_exists($filePath)) {
                    foreach ($_POST as $postvalue => $value) {
                        $_POST[$postvalue] = validateInput($postvalue, sanitizeInput($value));
                        if ($_POST[$postvalue] === false) {
                            $_SESSION['error_msg'] = "Validation failed for Input.";
                            header('Location: ' . $_SERVER['HTTP_REFERER']); // Redirects back to the previous page
                            exit(); // Stops the script
                        }
                    }
                    require_once($filePath);
                } else {
                    // Log Suspicious activity and update failed attempts
                    update_invalid_activity(IP);
                }
                break;

            case 'auth':
                // Validate and require Auth action
                $filePath = ACTIONS_DIR . "/auth/{$action}.php";
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && file_exists($filePath)) {
                    foreach ($_POST as $postvalue => $value) {
                        $_POST[$postvalue] = validateInput($postvalue, sanitizeInput($value));
                        if ($_POST[$postvalue] === false) {
                            $_SESSION['error_msg'] = "Validation failed for Input.";
                            header('Location: ' . $_SERVER['HTTP_REFERER']); // Redirects back to the previous page
                            exit(); // Stops the script
                        }
                    }
                    require_once($filePath);
                } else {
                    // Log Suspicious activity and update failed attempts
                    update_invalid_activity(IP);
                }
                break;

            case 'post':
                // Validate and require POST action
                $filePath = ACTIONS_DIR . "/post/{$action}.php";
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']) && $_SESSION['loggedIn'] === true && file_exists($filePath)) {
                    foreach ($_POST as $postvalue => $value) {
                        $_POST[$postvalue] = validateInput($postvalue, sanitizeInput($value));
                        if ($_POST[$postvalue] === false) {
                            $_SESSION['error_msg'] = "Validation failed for Input.";
                            header('Location: ' . $_SERVER['HTTP_REFERER']); // Redirects back to the previous page
                            exit(); // Stops the script
                        }
                    }
                    require_once($filePath);
                } else {
                    // Log Suspicious activity and update failed attempts
                    update_invalid_activity(IP);
                }
                break;

            case 'get':
                // Validate and require GET action
                $filePath = ACTIONS_DIR . "/get/{$action}.php";
                if ($_SERVER['REQUEST_METHOD'] === 'GET' && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']) && $_SESSION['loggedIn'] === true && file_exists($filePath)) {
                    foreach ($_GET as $getvalue => $value) {
                        $_GET[$getvalue] = validateInput($getvalue, sanitizeInput($value));  // Changed $postvalue to $getvalue
                        if ($_GET[$getvalue] === false) {
                            $_SESSION['error_msg'] = "Validation failed for Input.";
                            header('Location: ' . $_SERVER['HTTP_REFERER']);
                            exit();
                        }
                    }
                    require_once($filePath);
                } else {
                    // Log Suspicious activity and update failed attempts
                    update_invalid_activity(IP);
                }
                break;

            default:
                // Log Suspicious activity and update failed attempts
                update_invalid_activity(IP);
                break;
        }
    } else {
        // Log Suspicious activity and update failed attempts if 'action' is not set
        update_invalid_activity($_SERVER['REMOTE_ADDR']);
    }
}
