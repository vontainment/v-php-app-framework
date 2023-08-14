<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: config.php
 * Description: A Simple PHP App Framework for Building Secure Apps
*/

define('BASE_DIR', dirname($_SERVER['DOCUMENT_ROOT']));
define('BLACKLIST_DIR', BASE_DIR . '/storage');
define('LOG_DIR', BASE_DIR . '/storage/logs');

// Set logging level
define('DEBUG', 2);  // change to 2 for development, 1 for production, or 0 to turn off