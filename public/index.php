<?php

/**
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: index.php
 * Description: This file serves as the main entry point of the Simple App Framework.
 * It initiates a session, includes necessary files for configuration, libraries,
 * and templates, and determines which content to display based on the $pageOutput variable.
 */

// Start output buffering
ob_start();

session_set_cookie_params([
    'lifetime' => 3600, // 1 hour
    'path' => '/',
    'domain' => 'DOMAIN',
    'secure' => true, // requires HTTPS
    'httponly' => true, // inaccessible to JavaScript
    'samesite' => 'Strict' // strict same-site policy
]);

// Starts a new session or resume the existing one
session_start();

// Includes the configuration file that contains constants, database connection string etc.
require_once '../config.php';

// Includes common-library.php file that contains common functions utilized throughout the project
require_once '../lib/common-lib.php';

// Includes load-library.php file that contains functions for loading necessary resources
require_once '../lib/load-lib.php';

// Includes header.php, which contains the HTML used for the header portion of the page
require_once '../app/templates/header.php';

// Includes whichever PHP file is set inside the $pageOutput variable.
// The included file will dictate what content is displayed on the webpage.
require_once $viewOutput;

// Includes footer.php, containing the output for the footer portion of the page
require_once '../app/templates/footer.php';

// End output buffering and flush system output buffer
ob_flush();
