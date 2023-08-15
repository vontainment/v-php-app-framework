<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: index.php
 * Description: A Simple PHP App Framework for Building Secure Apps
 */

// Start a new session or resume an existing session.
// This is used for managing information across different pages of the website
session_start();

// Include the config file, which contains configurations settings for the application
require_once '../config.php';

require_once '../lib/common-lib.php';

// Include the load library, which contains functions for loading different components
require_once '../lib/load-lib.php';

// Include the header part of the web page
require_once '../app/partials/header.php';

// Include the main content part of the web page
require_once '../app/partials/content.php';

// Include the footer part of the web page
require_once '../app/partials/footer.php';
