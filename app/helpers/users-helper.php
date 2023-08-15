<?php
/*
 * Project: Simple App Framework
 * Version: 10.0
 * Author Vontainment
 * URL: https://vontainment.com
 * File: users-helper.php
 * Description: A Simple PHP App Framework for Building Secure Apps
 *
 * This script contains a function `selectUserInfo()` which populates an array with
 * user data obtained from JSON files within a specified directory.
 * Each array element contains a `username` and `dataAttributes` for the user.
 * `dataAttributes` are a string includes encoded or escaped values related to
 * each user such as `username`, `password`, `email`, and `admin` status.
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
