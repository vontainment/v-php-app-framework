<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: nav.php
 * Description: A Simple PHP App Framework for Building Secure Apps
*/
?>

<div class="tab">
    <a href="/home"><button class="tablinks <?php if ($_SERVER['REQUEST_URI'] === '/home') echo 'active'; ?>">Home</button></a>
    <a href="/users"><button class="tablinks <?php if ($_SERVER['REQUEST_URI'] === '/users') echo 'active'; ?>">Users</button></a>
</div>