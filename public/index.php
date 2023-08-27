<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: index.php
 * Description: A Simple PHP App Framework for Building Secure Apps
 */

// Starts a new session or resume the existing one
ob_start();
session_start();

// Includes the configuration file that contains constants, database connection string etc.
require_once '../config.php';
// Includes common-library.php file that contains common functions utilised throughout the project
require_once '../lib/common-lib.php';
// Includes load-library.php file that contains functions for loading necessary resources
require_once '../lib/load-lib.php';

// Includes header.php, which contains the HTML used for the header portion of the page
require_once '../app/templates/header.php';

// Includes whichever PHP file is set inside the $pageOutput variable. The included file will dictate what content is displayed on the webpage.
require_once $pageOutput;

// Includes footer.php, containing the output for the footer portion of the page
require_once '../app/templates/footer.php';
ob_flush();