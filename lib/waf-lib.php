
<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: waf-lib.php
 * Description: A Simple PHP App Framework for Building Secure Apps
 */

/**
 * Updates the number of failed attempts for an IP address. If failed attempts >= 3, blacklist the IP.
 *
 * @param string $ip IP address to update failed attempts for
 */
function update_failed_attempts($ip)
{
    $blacklist_file = BLACKLIST_DIR . "/BLACKLIST.json";
    $content = json_decode(file_get_contents($blacklist_file), true);

    if (isset($content[$ip])) {
        $content[$ip]['login_attempts'] += 1;
        if ($content[$ip]['login_attempts'] >= 3) {
            $content[$ip]['blacklisted'] = true;
            $content[$ip]['timestamp'] = time();
        }
    } else {
        $content[$ip] = ['login_attempts' => 1, 'blacklisted' => false, 'timestamp' => time()];
    }

    file_put_contents($blacklist_file, json_encode($content));
}

/**
 * Checks if an IP address is blacklisted. If blacklisted more than 3 days ago, unblacklist.
 *
 * @param string $ip IP address to check
 * @return boolean Returns true if blacklisted, else false
 */
function is_blacklisted($ip)
{
    $blacklist_file = BLACKLIST_DIR . "/BLACKLIST.json";
    $blacklist = json_decode(file_get_contents($blacklist_file), true);

    if (isset($blacklist[$ip]) && $blacklist[$ip]['blacklisted']) {
        if (time() - $blacklist[$ip]['timestamp'] > (3 * 24 * 60 * 60)) {
            $blacklist[$ip]['blacklisted'] = false;
            file_put_contents($blacklist_file, json_encode($blacklist));
        } else {
            return true;
        }
    }
    return false;
}
