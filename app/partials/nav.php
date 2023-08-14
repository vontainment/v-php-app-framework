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
    <a href="/home"><button class="tablinks <?php if ($_SERVER['REQUEST_URI'] === '/home') echo 'active'; ?>">Statuses</button></a>
    <a href="/accounts"><button class="tablinks <?php if ($_SERVER['REQUEST_URI'] === '/accounts') echo 'active'; ?>">Accounts</button></a>
    <a href="/gallery">
        <button class="tablinks <?php
                                $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                                if (preg_match('/^\/gallery\/.+/', $currentPath)) {
                                    echo 'active';
                                }
                                ?>">Gallery</button>
    </a>

    <?php
    if (isset($_SESSION['username'])) {
        $userData = getUserInfo($_SESSION['username']);
        if ($userData && isset($userData['admin'])) {
            if ($userData['admin'] == 1) :
    ?>
                <a href="/users"><button class="tablinks <?php if ($_SERVER['REQUEST_URI'] === '/users') echo 'active'; ?>">Users</button></a>
            <?php
            elseif ($userData['admin'] == 0) :
            ?>
                <a href="/info"><button class="tablinks <?php if ($_SERVER['REQUEST_URI'] === '/info') echo 'active'; ?>">My info</button></a>
    <?php
            endif;
        }
    }
    ?>
</div>