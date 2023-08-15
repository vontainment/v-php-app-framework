<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: log-lib.php
 * Description: A Simple PHP App Framework for Building Secure Apps
 */

/**
 * Retrieves user information from the user file.
 *
 * @param string $username User's name
 *
 * @return array|null Array with user information or null if user does not exists
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
        }
    } else {
        $content[$ip] = ['login_attempts' => 1, 'blacklisted' => false, 'timestamp' => time()];
    }

    file_put_contents($blacklist_file, json_encode($content));
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
function processFormInput($inputData)
{
    foreach ($inputData as $key => $datatype) {
        if (!isset($_POST[$key])) return false; // Return false if key is not set

        // Sanitize the input
        $data = stripslashes(trim(strip_tags($_POST[$key])));
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8', false);
        $data = preg_replace('/<\?(?:php|=)?|<%|<script|<\/script|\/bin\/sh|exec\(|system\(|passthru\(|shell_exec\(|phpinfo\(|eval\(|base64_decode\(|gzinflate\(|preg_replace\(|str_rot13\(|assert\(/i', '', $data);

        // Validate the input based on the datatype
        $isValid = true; // Assume valid by default
        switch ($datatype) {
            case 'email':
                $isValid = filter_var($data, FILTER_VALIDATE_EMAIL) !== false;
                break;
            case 'username':
                $isValid = preg_match("/^[a-zA-Z0-9]{5,14}$/", $data);
                break;
            case 'password':
                $isValid = preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,24}$/", $data);
                break;
                // Add other cases here
        }

        if (!$isValid) return false; // Return false if validation fails

        $_POST[$key] = $data; // Optionally update the POST data with the sanitized value
    }

    return $_POST; // Return the sanitized and validated form variables
}
