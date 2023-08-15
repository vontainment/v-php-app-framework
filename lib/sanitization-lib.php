<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: sanitization-lib.php
 * Description: A Simple PHP App Framework for Building Secure Apps
 */

/*
 * The function sanitizeInput() is used to sanitize and protect
 * user-generated input from potential harmful injections or manipulation.
 *
 * @param   string  $data  The user-generated input to sanitize
 * @return  string  The sanitized input
 */
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
