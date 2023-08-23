<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: header.php
 * Description: A Simple PHP App Framework for Building Secure Apps
 */
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/assets/js/header-scripts.js"></script>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/views.css">
    <link rel="stylesheet" href="/assets/css/mobile.css">

    <title>AI Status Generator</title>
</head>

<body>
    <header>
        <div class="logo">
            <a href="/home">
                <img src="/assets/images/logo.png" alt="Logo">
            </a>
        </div>
        <?php
        if ($loggedIn) {
        ?>
            <div class="logout-button">
                <form action="/action.php" method="POST">
                    <input type="hidden" name="action" value="logout">
                    <button class="orange-button" type="submit" name="logout">Logout</button>
                </form>
            </div>
        <?php
        }
        ?>
    </header>