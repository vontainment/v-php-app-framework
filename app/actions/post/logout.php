<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: log-lib.php
 * Description: Handles user logout
 */

// The appLog function logs the received logout request with priority level 2.
// Note that the priority level is an optional parameter to signify the importance of the log.
appLog("Logout request received.", 2);

// The session_destroy function destroys all data registered to a session. It does not unset any global variables associated with the session,
// or unset the session cookie. To use the session variables again, session_start() has to be called.
session_destroy();

// The header() function sends a raw HTTP header to a client. In this case, it is used to redirect the user to the login view (/login).
header("Location: /login");

// The exit statement is used to halt current script execution. After destroying the session and redirecting the user to the login view,
// the script execution is halted to prevent any further unintended code execution.
exit();
