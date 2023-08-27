<?php
/*
 * Project: WP Update API
 * Version: 2.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: update_theme.php
 * Description: WordPress Update API
 */

 // Get the domain, key, and file from the query string
 $domain = isset($_GET['domain']) ? $_GET['domain'] : '';
 $key = isset($_GET['key']) ? $_GET['key'] : '';
 $file = isset($_GET['file']) ? $_GET['file'] : '';

 // Validate the domain and key against the HOSTS file
 $allowed = false;
 if ($handle = fopen(HOSTS_ACL . 'HOSTS', 'r')) {
     while (($line = fgets($handle)) !== false) {
         $line = trim($line);
         if (!empty($line)) {
             list($host, $host_key) = explode(' ', $line, 2);
             if ($domain == $host && $key == $host_key) {
                 $allowed = true;
                 break;
             }
         }
     }
     fclose($handle);
 }

 // If the domain and key are valid, send the file for download
 if ($allowed) {
     $file_path = THEMES_DIR . '/' . $file;
     if (file_exists($file_path)) {
         header('Content-Type: application/octet-stream');
         header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
         header('Content-Length: ' . filesize($file_path));
         readfile($file_path);
         exit;
     } else {
         header('HTTP/1.1 404 Not Found');
         echo 'File not found';
         error_log('File not found: ' . $file_path);
         exit;
     }
 } else {
     update_failed_attempts(IP);
     header('HTTP/1.1 401 Unauthorized');
     echo 'Unauthorized';
     error_log('Unauthorized access: ' . $_SERVER['REMOTE_ADDR']);
     exit;
 }
