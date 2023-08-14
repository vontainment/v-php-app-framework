<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: index.php
 * Description: A Simple PHP App Framework for Building Secure Apps
 */

session_start();
require_once '../config.php';
require_once '../lib/common-lib.php';
require_once '../lib/load-lib.php';

require_once '../app/partials/header.php';
require_once '../app/partials/content.php';
require_once '../app/partials/footer.php';
