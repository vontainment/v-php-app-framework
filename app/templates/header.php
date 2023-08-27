<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author Vontainment
 * URL: https://vontainment.com
 * File: header.php
 * Description: A Simple PHP App Framework for Building Secure Apps
*/
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta name="robots" content="noindex, nofollow">
    <title>APP</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/header-scripts.js"></script>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/typography.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <link rel="stylesheet" href="/assets/css/forms.css">
    <link rel="stylesheet" href="/assets/css/elements.css">
    <link rel="stylesheet" href="/assets/css/modal.css">
    <link rel="stylesheet" href="/assets/css/pages.css">
    <link rel="stylesheet" href="/assets/css/mobile.css">

    <title>Update Dashboard</title>
</head>

<body>
    <?php if (VIEW !== 'login') : ?>
        <header>
            <div class="logo">
                <a href="/home">
                    <img src="/assets/images/logo.png" alt="Logo">
                </a>
            </div>
            <div class="logout-button">
                <form action="/actions/auth" method="POST">
                    <input type="hidden" name="action" value="logout">
                    <button class="orange" type="submit" name="logout">Logout</button>
                </form>
            </div>
        </header>
        <div class="tab">
            <a href="/home"><button class="tablinks <?php if (VIEW === 'home') echo 'active'; ?>">Dashboard</button></a>
            <a href="/Users"><button class="tablinks <?php if (VIEW === 'users') echo 'active'; ?>">Manage Users</button></a>
        </div>
    <?php endif; ?>