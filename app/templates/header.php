<?php
/*
 * Project: WP Update API
 * Version: 2.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: header.php
 * Description: WordPress Update API
*/
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta name="robots" content="noindex, nofollow">
    <title>API Admin Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>
    <script src="/assets/js/header-scripts.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.css" rel="stylesheet" />
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
    <?php if (PAGE !== 'login') : ?>
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
            <a href="/home"><button class="tablinks <?php if (PAGE === 'home') echo 'active'; ?>">Manage Hosts</button></a>
            <a href="/plupdate"><button class="tablinks <?php if (PAGE === 'plupdate') echo 'active'; ?>">Manage Plugins</button></a>
            <a href="/thupdate"><button class="tablinks <?php if (PAGE === 'thupdate') echo 'active'; ?>">Manage Themes</button></a>
            <a href="/logs"><button class="tablinks <?php if (PAGE === 'logs') echo 'active'; ?>">View Logs</button></a>
        </div>
    <?php endif; ?>