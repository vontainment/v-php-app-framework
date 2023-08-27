<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: config.php
 * Description: A Simple PHP App Framework for Building Secure Apps
*/

define('IP', $_SERVER['REMOTE_ADDR']);
define('BASE_DIR', dirname($_SERVER['DOCUMENT_ROOT']));
define('VIEW', ltrim($_SERVER['REQUEST_URI'], '/'));

define('VIEW_FILE', BASE_DIR . '/app/views/' . VIEW . ".php");
define('HELPER_FILE', BASE_DIR . '/app/helpers/' . VIEW . ".php");
define('ERROR_FILE', BASE_DIR . '/lib/404-lib.php');

define('BLACKLIST_DIR', BASE_DIR . '/storage');
define('LOG_DIR', BASE_DIR . '/storage/logs');
define('USERS_DIR', BASE_DIR . '/storage/users');

// Define actions pathways.
define('ACTIONS_DIR', BASE_DIR . '/app/actions'); // Replace with the actual path

// Set logging level
define('DEBUG', 2);  // change to 2 for development, 1 for production, or 0 to turn off