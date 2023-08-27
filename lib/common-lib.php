<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: common-lib.php
 * Description: This file contains a set of utility functions for the project.
 */

/**
 * Retrieves user information based on a given username.
 * Returns null if the user doesn't exist.
 * @param string $username The username of the user.
 * @return array|NULL The user's data if exists, otherwise NULL.
 */
function getUserInfo($username)
{
    $filePath = USERS_DIR . "/{$username}";
    if (file_exists($filePath)) {
        $userData = file_get_contents($filePath);
        $userInfo = json_decode($userData, true);
        return $userInfo;
    } else {
        return null;
    }
}

/**
 * Logs a message into a file if the DEBUG level is equal to or higher than $level.
 *
 * @param string $message The log message
 * @param int $level The log level
 */
function appLog($message, $level)
{
    if (defined('DEBUG') && DEBUG >= $level) {
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'unknown';
        $dateTime = date('Y-m-d H:i:s');
        $logMessage = "[{$dateTime}] [User: {$username}] [Log Level {$level}]: {$message}\n";
        error_log($logMessage, 3, '../storage/logs/error.log');
    }
}

/**
 * This function is responsible for displaying error messages.
 * It checks if there are any error messages stored in the session,
 * then it prints the error message within a div container on the webpage.
 * After that, it deletes the session error message to prevent it from
 * being displayed again on the subsequent reloads/redirects.
 */
function display_error_msg()
{
    // Check if there is an error message set in the session
    if (isset($_SESSION['error_msg'])) {

        // If an error message exists in the session, outputs it inside a div with id 'error-msg'
        echo '<div id="error-msg">' . $_SESSION['error_msg'] . '</div>';

        // Unset the error message from the session, preventing it from being displayed again on page reload
        unset($_SESSION['error_msg']);
    }
}


/**
 * Updates the number of failed attempts for an IP address. If failed attempts >= 3, blacklist the IP.
 *
 * @param string $ip IP address to update failed attempts for
 */
function update_failed_attempts($ip)
{
    $blacklist_file = BLACKLIST_DIR . "/BLACKLIST.json";
    $content = json_decode(file_get_contents($blacklist_file), true);

    if (isset($content[$ip])) {
        $content[$ip]['login_attempts'] += 1;
        if ($content[$ip]['login_attempts'] >= 3) {
            $content[$ip]['blacklisted'] = true;
            $content[$ip]['timestamp'] = time();
            $blacklistStatus = "true";
        }
    } else {
        $content[$ip] = ['login_attempts' => 1, 'blacklisted' => false, 'timestamp' => time()];
    }

    file_put_contents($blacklist_file, json_encode($content));
    if ($blacklistStatus === "true") {
        appLog("IP: " . $ip . " blacklisted due to suspicious activity", 1);
        http_response_code(403);
        die("Your IP address has been blacklisted. If you believe this is an error, please contact us.");
    }
}

function update_invalid_activity($ip)
{
    $blacklist_file = BLACKLIST_DIR . "/BLACKLIST.json";
    $content = json_decode(file_get_contents($blacklist_file), true);

    if (isset($content[$ip])) {
        $content[$ip]['strikes'] += 1;
        if ($content[$ip]['strikes'] >= 3) {
            $content[$ip]['blacklisted'] = true;
            $content[$ip]['timestamp'] = time();
            $blacklistStatus = "blacklisted";
        }
    } else {
        $content[$ip] = ['strikes' => 1, 'blacklisted' => false, 'timestamp' => time()];
        $blacklistStatus = "strike";
    }
    file_put_contents($blacklist_file, json_encode($content));
    if ($blacklistStatus === "strike") {
        appLog("Suspicious activity from IP: " . $ip, 1);
        http_response_code(403);
        die("INVALID ACTION: Your IP address has been logged.");
    } elseif ($blacklistStatus === "blacklisted") {
        appLog("IP: " . $ip . " blacklisted due to suspicious activity", 1);
        http_response_code(403);
        die("Your IP address has been blacklisted. If you believe this is an error, please contact us.");
    }
}

/**
 * Checks if an IP address is blacklisted. If blacklisted more than 3 days ago, unblacklist.
 *
 * @param string $ip IP address to check
 * @return boolean Returns true if blacklisted, else false
 */
function is_blacklisted($ip)
{
    $blacklist_file = BLACKLIST_DIR . "/BLACKLIST.json";
    $blacklist = json_decode(file_get_contents($blacklist_file), true);

    if (isset($blacklist[$ip]) && $blacklist[$ip]['blacklisted']) {
        if (time() - $blacklist[$ip]['timestamp'] > (3 * 24 * 60 * 60)) {
            $blacklist[$ip]['blacklisted'] = false;
            file_put_contents($blacklist_file, json_encode($blacklist));
        } else {
            return true;
        }
    }
    return false;
}

/**
 * Sanitizes input data to prevent XSS attacks.
 *
 * @param mixed $data The input data to sanitize.
 * @return string The sanitized input data.
 */
function sanitizeInput($data)
{
    $data = stripslashes(trim(strip_tags($data)));
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8', false);
    $data = preg_replace('/<\?(?:php|=)?|<%|<script|<\/script|\/bin\/sh|exec\(|system\(|passthru\(|shell_exec\(|phpinfo\(|eval\(|base64_decode\(|gzinflate\(|preg_replace\(|str_rot13\(|assert\(/i', '', $data);
    return $data;
}

/**
 * Validates input values based on the input key.
 * Currently supports 'username', 'password', 'admin', 'domain', 'key' and 'id'.
 *
 * @param string $key The key of the input data.
 * @param mixed $value The value of the input data.
 * @return mixed|bool The original value if validation passes, false otherwise.
 */
function validateInput($key, $value)
{
    switch ($key) {
        case 'username':
            // Check if username only contains alphanumeric characters and underscores
            if (!preg_match("/^[a-zA-Z0-9_]+$/", $value)) {
                return false;
            }
            break;
        case 'password':
            // Password must be at least 8 characters long
            if (strlen($value) < 8) {
                return false;
            }
            break;
        case 'admin':
            // Admin value must be either 'true' or 'false'
            if ($value !== 'true' && $value !== 'false') {
                return false;
            }
            break;
        case 'domain':
            // Domain must follow the pattern: alphanumeric characters or hyphen followed by dot and again alphanumeric characters or hyphen
            if (!preg_match("/^[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)+$/", $value)) {
                return false;
            }
            break;
        case 'key':
            // Key must be 3 to 12 alphanumeric characters and special characters !, @, #, $
            if (!preg_match("/^[a-zA-Z0-9!@#$]{3,12}$/", $value)) {
                return false;
            }
            break;
        case 'id':
            // ID must be an integer
            if (filter_var($value, FILTER_VALIDATE_INT) === false) {
                return false;
            }
            break;
        default:
            // If field is not specified, perform no validation and return value as it is
            return $value;
    }
    // If all checks pass, return the original value
    return $value;
}
