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
