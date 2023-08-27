<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: login.php
 * Description: A Simple PHP App Framework for Building Secure Apps
 */
?>

<div id="login-box">
    <img src="assets/images/logo.png" alt="Logo" class="logo">
    <h2>WordPress Update Server</h2>
    <form id="login-form" action="/actions/auth" method="POST">
        <input type="hidden" name="action" value="login">
        <label>Username:</label>
        <input type="text" name="username" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <button type="submit" id="btn-login" class="green">Log In</button>
    </form>
    <?php display_error_msg(); ?>
</div>