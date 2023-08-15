<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: user-lib.php
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
 * Updates existing user's information in the user file.
 *
 * @param string $username User's name
 * @param array $updatedInfo Array of user's updated information
 *
 * @return bool Returns true if successfully updated, otherwise false
 */
function updateUserInfo($username, $updatedInfo)
{
    $filePath = USERS_DIR . "/{$username}";
    if (file_exists($filePath)) {
        file_put_contents($filePath, json_encode($updatedInfo));
        return true;
    } else {
        return false;
    }
}

/**
 * This function adds a new user to the user file.
 *
 * @param string $username unique identifier for the user.
 * @param array $userInfo associate array with user's information
 * @return bool Returns true if a user file was successfully created, otherwise returns false
 */
function addUserInfo($username, $userInfo)
{
    $filePath = USERS_DIR . "/{$username}";
    if (!file_exists($filePath)) {
        file_put_contents($filePath, json_encode($userInfo));
        return true;
    } else {
        return false;
    }
}

/**
 * Deletes user record from the user file.
 *
 * @param string $username User's name
 *
 * @return bool Returns true if successfully deleted, otherwise false
 */
function deleteUserInfo($username)
{
    $filePath = USERS_DIR . "/{$username}";
    if (file_exists($filePath)) {
        unlink($filePath);
        return true;
    } else {
        return false;
    }
}
