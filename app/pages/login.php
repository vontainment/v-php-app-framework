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

<div class="login-box">
    <img src="assets/images/logo.png" alt="Logo" class="logo">
    <h2>AI Status Admin</h2>
    <form class="login-form" action="/login" method="POST">
        <label>Username:</label>
        <input type="text" name="username"><br><br>
        <label>Password:</label>
        <input type="password" name="password"><br><br>
        <button type="submit" class="green-button" name="login">Log In</button>
    </form>
    <?php if (isset($error_msg)) : ?>
        <div id="error-msg"><?php echo $error_msg; ?></div>
    <?php endif; ?>
</div>