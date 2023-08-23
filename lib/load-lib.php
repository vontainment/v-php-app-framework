<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: load-lib.php
 * Description: This is a part of a simple app framework that's designed to help build secure web applications.
 */

// First, we check if the IP of the user is blacklisted.
if (is_blacklisted(IP)) {
    // If the user is blacklisted, we stop the script immediately and send a 403 response.
    http_response_code(403);
    appLog("Blacklisted the following IP: " . IP, 1); // Logs the blacklisted IP
    exit();

// In case the view requested is 'login' and the user's session shows they're already logged in
} elseif (VIEW === 'login' && isset($_SESSION['logged_in'])) {
    // Since the user is logged in there is no need to go to the 'login' view, redirect them to the 'home' view.
    appLog("Redirect to home view if the user is already logged in.", 2); // Logs the redirection
    header('Location: /home');
    exit();

// Here, we're checking if the view is anything other than 'login' and the user isn't logged in
} elseif (VIEW !== 'login' && !isset($_SESSION['logged_in'])) {
    // We redirect these users to the 'login' view
    appLog("Redirect to login view if not logged in.", 2); // Logs the redirection
    header('Location: /login');
    exit();
} else {
    // For any other case, we begin constructing the view.
    appLog("Constructing view.", 2);

    // Each value in the POST array is escaped to fend off attacks like XSS.
    foreach ($_POST as $postvalue => $value) {
        $_POST[$postvalue] = sanitizeInput($value);
    }

    // Check if the view file exists; if not, provide an error file.
    if (file_exists(VIEW_FILE)) {
        $viewOutput = VIEW_FILE;
    } else {
        appLog("View does not exist.", 2); // Logs the error
        $viewOutput = ERROR_FILE;
    }

    // We have helper functionality separately coded. If the helper file exists, bring it in.
    if (file_exists(HELPER_FILE)) {
        require_once(HELPER_FILE);
    }
}
