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

function sanitizeInput($data)
{
    // Trim whitespace, strip tags, and remove backslashes from the input
    $data = stripslashes(trim(strip_tags($data)));

    // Convert special characters into their HTML entities, excluding quotes
    // The optional fourth parameter, 'false', specifies that no quotes will be encoded
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8', false);

    // Remove potentially harmful strings from the user-generated input
    // This includes standard PHP tags, script tags, execution commands, and some common injection methods
    $data = preg_replace('/<\?(?:php|=)?|<%|<script|<\/script|\/bin\/sh|exec\(|system\(|passthru\(|shell_exec\(|phpinfo\(|eval\(|base64_decode\(|gzinflate\(|preg_replace\(|str_rot13\(|assert\(/i', '', $data);

    // Return the sanitized input
    return $data;
}


/**
 * Validates if the input is a valid email by checking if it's correctly formatted
 *
 * @param string $email The email to be validated
 * @return bool Returns true if the email is valid, false otherwise
 */
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validates if the username is a string of 5 to 14 alphanumerics characters
 *
 * @param string $username The username to be validated
 * @return bool Returns true if the username is valid, false otherwise
 */
function validateUsername($username)
{
    return preg_match("/^[a-zA-Z0-9]{5,14}$/", $username);
}

/**
 * Validates if the password has at least one digit, one lowercase letter, one uppercase letter,
 * and length from 8 to 24 characters
 *
 * @param string $password The password to be validated
 * @return bool Returns true if the password is valid, false otherwise
 */
function validatePassword($password)
{
    return preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,24}$/", $password);
}

/**
 * Validates if the input is a valid url
 *
 * @param string $url The URL to be validated
 * @return bool Returns true if the URL is valid, false otherwise
 */
function validateURL($url)
{
    return preg_match("/^(https?:\/\/)?(www\.)?([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}(\/)?$/", $url);
}

/**
 * Validates if the input date is in the given format or 'Y-m-d' by default
 *
 * @param string $date The date to be validated
 * @param string $format The desired date format
 * @return bool Returns true if the date is valid and in the correct format, false otherwise
 */
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

/**
 * Validates if the number is within the range defined by $min and $max
 *
 * @param int $number The number to be validated
 * @param int $min The minimum acceptable value
 * @param int $max The maximum acceptable value
 * @return bool Returns true if the number is within the range, false otherwise
 */
function validateNumberRange($number, $min, $max)
{
    return is_numeric($number) && $number >= $min && $number <= $max;
}

/**
 * Validates if the input is a correctly formatted phone number
 *
 * @param string $phone The phone number to be validated
 * @return bool Returns true if the phone number is valid, false otherwise
 */
function validatePhoneNumber($phone)
{
    return preg_match("/^(\+\d{1,3})?\d{7,15}$/", $phone);
}

/**
 * Validates if the postal code is a string of 3 to 10 alphanumeric characters, spaces or hyphens
 *
 * @param string $postalCode The postal code to be validated
 * @return bool Returns true if the postal code is valid, false otherwise
 */
function validatePostalCode($postalCode)
{
    return preg_match("/^[a-zA-Z0-9\s\-]{3,10}$/", $postalCode);
}

/**
 * Validates if the input value is a boolean
 *
 * @param bool $value The value to be validated
 * @return bool Returns true if the value is a boolean, false otherwise
 */
function validateBoolean($value)
{
    return is_bool($value);
}
