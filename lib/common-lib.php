<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: common-lib.php
 * Description: A Simple PHP App Framework for Building Secure Apps
 */

//This function retrieves user information from the user file.
function getUserInfo($username)
{
    $filePath = USERS_DIR . "/{$username}";
    if (file_exists($filePath)) {
        $userData = file_get_contents($filePath);
        $userInfo = json_decode($userData, true);
        return $userInfo;
    } else {
        return null; // File not found
    }
}

function updateUserInfo($username, $updatedInfo) {
    $filePath = USERS_DIR . "/{$username}.json"; // Make sure to use the appropriate extension
    if (file_exists($filePath)) {
        // Update the user's information
        file_put_contents($filePath, json_encode($updatedInfo));
        return true; // Successfully updated
    } else {
        return false; // File not found
    }
}


function verifyPassword($password, $hashedPassword)
{
    return password_verify($password, $hashedPassword);
}

function hashPassword($password)
{
    // Generate a salt (cost parameter of 12 is recommended for bcrypt)
    $options = ['cost' => 12];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);

    return $hashedPassword;
}

function sanitize_input($data)
{
    // Trim whitespace and remove HTML tags
    $data = trim(strip_tags($data));

    // Filter the input using appropriate filters (not using deprecated FILTER_SANITIZE_STRING)
    $data = filter_var($data, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES);

    // Add additional security measures
    $data = str_replace(array("<?", "?>", "<%", "%>", "<script", "</script", "/bin/sh", "exec(", "system(", "passthru(", "shell_exec(", "phpinfo(", "eval(", "base64_decode(", "gzinflate(", "preg_replace(", "str_rot13(", "assert("), "", $data);

    return $data; // Input is sanitized and validated, return the clean data
}

function validate_input($data, $typeOfValidation)
{
    if ($typeOfValidation == 'username') {
        // Validate username: alphanumeric characters, length 5-14
        return preg_match("/^[a-zA-Z0-9]{5,14}$/", $data);
    } elseif ($typeOfValidation == 'password') {
        // Validate password: at least one digit, one lowercase letter, one uppercase letter, length 8-24
        return preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,24}$/", $data);
    } elseif ($typeOfValidation == 'key') {
        // Validate key: alphanumeric characters, length 3-24
        return preg_match("/^[a-zA-Z0-9]{3,24}$/", $data);
    } else {
        // Return false if type of validation is not recognized
        return false;
    }
}

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
function is_blacklisted($ip)
{
    $blacklist_file = BLACKLIST_DIR . "/BLACKLIST.json";
    $blacklist = json_decode(file_get_contents($blacklist_file), true);

    if (isset($blacklist[$ip]) && $blacklist[$ip]['blacklisted']) {
        // Check if the timestamp is older than three days
        if (time() - $blacklist[$ip]['timestamp'] > (3 * 24 * 60 * 60)) {
            // Remove the IP address from the blacklist
            $blacklist[$ip]['blacklisted'] = false;
            file_put_contents($blacklist_file, json_encode($blacklist));
        } else {
            return true;
        }
    }
    return false;
}

function appLog($message, $level)
{
    // Check DEBUG level
    if (defined('DEBUG') && DEBUG >= $level) {
        // Log the message
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'unknown';
        $dateTime = date('Y-m-d H:i:s');
        $logMessage = "[{$dateTime}] [User: {$username}] [Log Level {$level}]: {$message}\n";

        // Write the log message to a file
        error_log($logMessage, 3, '../storage/logs/error.log');
    }
}