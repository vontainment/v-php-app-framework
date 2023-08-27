<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: config.php
 * Description: This file contains the configuration settings for the application.
 * It defines constants that are used throughout the app, such as directories,
 * IP addresses, and logging levels.
*/

// Define the client's IP address.
define('IP', $_SERVER['REMOTE_ADDR']);

// Define the base directory of the project.
define('BASE_DIR', dirname($_SERVER['DOCUMENT_ROOT']));

// Define the view requested by the user.
define('VIEW', ltrim($_SERVER['REQUEST_URI'], '/'));

//Define the path to the view file.
define('VIEW_FILE', BASE_DIR . '/app/views/' . VIEW . ".php");

//Define the path to the helper file.
define('HELPER_FILE', BASE_DIR . '/app/helpers/' . VIEW . ".php");

// Define the path to the error file.
define('ERROR_FILE', BASE_DIR . '/lib/404-lib.php');

// Define the directory for blacklisted IPs.
define('BLACKLIST_DIR', BASE_DIR . '/storage');

// Define the directory for logs.
define('LOG_DIR', BASE_DIR . '/storage/logs');

// Define the directory for user data.
define('USERS_DIR', BASE_DIR . '/storage/users');

// Define the directory for action files.
define('ACTIONS_DIR', BASE_DIR . '/app/actions');

// Set the logging level (2 for development, 1 for production, 0 to turn off).
define('DEBUG', 2);
