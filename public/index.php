<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: index.php
 * Description: A Simple PHP App Framework for Building Secure Apps
 */

// Initializes a new session, or resumes an existing one
session_start();

// Incorporates the settings and configurations defined in the config.php file
require_once '../config.php';

// Incorporates functionalities defined in the common-lib.php file. Common operations are defined here
require_once '../lib/common-lib.php';

// Incorporates functionalities defined in the load-lib.php file. Loading operations are defined here
require_once '../lib/load-lib.php';

// Incorporates the header section of the view from the header.php file
require_once '../app/partials/header.php';

// Checks if the user is not on the login view. If true, then it incorporates the navigation bar view from the navigation.php file
if (VIEW !== 'login') {
    require_once '../app/partials/navigation.php';
}

// Incorporates the main view output defined in the file specified by the $viewOutput variable
require_once $viewOutput;

// Incorporates the footer section of the view from the footer.php file
require_once '../app/partials/footer.php';
