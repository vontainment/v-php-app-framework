<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: validation-lib.php
 * Description: A Simple PHP App Framework for Building Secure Apps
 */

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
