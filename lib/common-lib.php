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
 * Logs messages in the system with a specific level.
 *
 * @param string $message The message to be logged.
 * @param string $level The level of the log entry.
 */
function appLog($message, $level)
{
    if (defined('DEBUG') && DEBUG >= $level) {
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'unknown';
        $dateTime = date('Y-m-d H:i:s');
        $logMessage = "[{$dateTime}] [User: {$username}] [Log Level {$level}]: {$message}\n";
        error_log($logMessage, 3, LOG_DIR . '/error.log');
    }
}

/**
 * Increases failed login attempts from a particular IP.
 * If attempts are 3 or more, it marks the IP as blacklisted.
 *
 * @param string $ip The IP address to update.
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
        }
    } else {
        $content[$ip] = ['login_attempts' => 1, 'blacklisted' => false, 'timestamp' => time()];
    }

    file_put_contents($blacklist_file, json_encode($content));
}

/**
 * Checks if a given IP is blacklisted.
 * If IP was blacklisted more than 3 days ago, removes it from blacklists.
 *
 * @param string $ip The IP address to check.
 * @return bool True if the IP is blacklisted, otherwise false.
 */ function is_blacklisted($ip)
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
 * Currently supports 'username', 'password', and 'admin'.
 *
 * @param string $key The key of the input data.
 * @param mixed $value The value of the input data.
 * @return mixed|bool The original value if validation passes, false otherwise.
 */
function validateInput($key, $value)
{
    switch ($key) {
        case 'username':
            // Perform username validation here
            if (!preg_match("/^[a-zA-Z0-9_]+$/", $value)) {
                return false;
            }
            break;
        case 'password':
            // Perform password validation here
            if (strlen($value) < 8) {
                return false;
            }
            break;
        case 'admin':
            // Perform admin validation here
            if ($value !== 'true' && $value !== 'false') {
                return false;
            }
            break;
            // Add more cases for other fields as needed
        default:
            // Default validation or no validation, return the value
            return $value;
    }
    return $value;
}
