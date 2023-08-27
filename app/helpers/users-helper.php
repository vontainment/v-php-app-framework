<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author Vontainment
 * URL: https://vontainment.com
 * File: users-helper.php
 * Description: This script contains a function `selectUserInfo()` which populates an array with
 * user data obtained from JSON files within a specified directory.
 * Each array element contains a `username` and `dataAttributes` for the user.
 * `dataAttributes` are a string includes encoded or escaped values related to
 * each user such as `username`, `password`, `email`, and `admin` status.
*/

/**
 * Updates user information in a file based on a given username.
 *
 * @param string $username The username of the user.
 * @param array $updatedInfo The updated information of the user.
 * @return bool Returns true if update is successful, false otherwise.
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
 * Adds user information to a new file based on a given username.
 *
 * @param string $username The username of the user.
 * @param array $userInfo The information of the user.
 * @return bool Returns true if addition is successful, false otherwise.
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
 * Adds user information to a new file based on a given username.
 *
 * @param string $username The username of the user.
 * @param array $userInfo The information of the user.
 * @return bool Returns true if addition is successful, false otherwise.
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

/**
 * Selects user information from all files in a specific directory and returns it as an array.
 *
 * @return array An array of associative arrays containing 'username' and 'dataAttributes'.
 */
function selectUserInfo()
{
    $userFiles = glob(USERS_DIR . "/*");
    $usersData = [];

    foreach ($userFiles as $userFile) {

        $username = pathinfo($userFile, PATHINFO_FILENAME);
        $userInfo = json_decode(file_get_contents($userFile), true);

        if ($userInfo !== null) {
            $dataAttributes = 'data-username="' . htmlspecialchars($username) . '" ';
            $dataAttributes .= 'data-password="' . urlencode($userInfo['password']) . '" ';
            $dataAttributes .= 'data-email="' . urlencode($userInfo['email']) . '" ';
            $dataAttributes .= 'data-admin="' . htmlspecialchars($userInfo['admin']) . '" ';

            $usersData[] = [
                'username' => $username,
                'dataAttributes' => $dataAttributes
            ];
        }
    }

    return $usersData;
}

$usersData = selectUserInfo();
