# v-php-app-framework

## Description

A Simple PHP App Framework for Building Secure Apps. Designed to be easier than traditional MVC frameworks, because any developer who says they can jump into a random codebase built with MVC and not be lost at first is likely exaggerating. This framework is based on API, Actions, Views, Helpers, and Libs.

The idea is to split the code into Core logic and functions (libs), page rendering and logic/functions (views/helpers), post/get logic/functions (api/actions).

### App (Contains core code)

- actions (Directs form and api input)
  - api (Contains `action.php` file; get `$action` to direct)
  - auth (Contains `$action.php` file; get `$action` to direct)
  - post (Contains `$action.php` file; post `$action` to direct)
  - get (Contains `$action.php` file; get `$action` to direct)
- views (Contains the page rendering views)
- helpers (Contains the backend page code)
- partials (Header, footer, nav)

### Lib (Core app logic, routing, common functions, security)

- common-lib.php (Common functions)
- load-lib.php (Core code to route and render)

### Public (Webroot)

- assets (Css, js, img)
  - images
  - js
  - css
- index.php (Main entry file)
- actions.php (Actions entry file)
- api.php (API entry file)

### Storage (File storage)

- logs
- users
- BLACKLIST.json

### Config.php (Constants)

## How To

- 404 Errors
Create a file /lib/404-lib.php

- Forms:

```
<form action="/action/post" method="POST">
    <input type="hidden" name="action" value="addsomething">
```

```
<form action="/action/get" method="GET">
    <input type="hidden" name="action" value="getinfo">
```

```
<form action="/action/auth" method="POST">
    <input type="hidden" name="action" value="login">
```

This routes the form submission to /app/actions/auth/login.php. Also actions.php handles basic sanitization and validation. /actions/api can do both GET and POST.

- Automatic sanitization and validation on POST and sanitization on GET requests:
  These are very basic and just prevent the general issues. The sanitization should stript out most dangerous input but should not cause issues with most usages.

```
function sanitizeInput($data)
{
    $data = stripslashes(trim(strip_tags($data)));
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8', false);
    $data = preg_replace('/<\?(?:php|=)?|<%|<script|<\/script|\/bin\/sh|exec\(|system\(|passthru\(|shell_exec\(|phpinfo\(|eval\(|base64_decode\(|gzinflate\(|preg_replace\(|str_rot13\(|assert\(/i', '', $data);
    return $data;
}
```

The validation is standard for Usernames, Passwords, Admin (true,false). It works by matching the post variable name. You can add more validations as needed, if a validation does not exist for field it is treated as valid.

```
function validateInput($key, $value)
{
    switch ($key) {
        case 'username':
            // Perform username validation here
            if (!preg_match("/^[a-zA-Z0-9_]+$/", $value)) {
                return false;
            }
            break;
        case 'password':
            // Perform password validation here
            if (strlen($value) < 8) {
                return false;
            }
            break;
        case 'admin':
            // Perform admin validation here
            if ($value !== 'true' && $value !== 'false') {
                return false;
            }
            break;
            // Add more cases for other fields as needed
        default:
            // Default validation or no validation, return the value
            return $value;
    }
    return $value;
}
```

Its controlled in action.php with this code:

```
    foreach ($_POST as $postvalue => $value) {
        $sanitizedValue = sanitizeInput($value);
        $validatedValue = validateInput($postvalue, $sanitizedValue);
        if ($validatedValue === false) {
            appLog("Validation failed for $postvalue.", 2);
            $_SESSION['error_msg'] = "Validation failed for $postvalue.";
        }
        $_POST[$postvalue] = $validatedValue;
    }
```

and

```
    foreach ($_GET as $getvalue => $value) {
        $_GET[$getvalue] = sanitizeInput($value);
    }
```

- Logging:
Logging can be defined as debug or production in config.php, 1 is production, 2 is debug.

```
appLog("Attempted direct access to actions.php.", 1);
```

or

```
appLog("Attempted direct access to actions.php.", 2);
```

- Error Messages:
Display:

```
<?php display_error_msg(); ?>
```

or create:

```
       // Sets the success message in the session with details of the updated entry
       $_SESSION['error_msg'] = "Updated entry: $domain, $key";
       // Logs the update process
       appLog("Updated entry: $domain, $key", 2);
       // Redirects to home
       header('Location: /home');
       // Complete script execution
       exit();
```

- Blacklisting IPs
IPs get 3 strokes and then are blacklisted. To give an IP a strike:

```
update_failed_attempts(IP);
appLog("Unauthorized access to update user from IP: " . IP, 1);
exit();
```

failed_attempts does:

```
if ($blacklistStatus === "true") {
    appLog("IP: " . $ip . " blacklisted due to suspicious activity", 1);
    http_response_code(403);
    die("Your IP address has been blacklisted. If you believe this is an error, please contact us.");
}
```

or

```
// Log Suspicious activity and update failed attempts
update_invalid_activity(IP);
```

invalid_activity does:

```
if ($blacklistStatus === "strike") {
    appLog("Suspicious activity from IP: " . $ip, 1);
    http_response_code(403);
    die("INVALID ACTION: Your IP address has been logged.");
} elseif ($blacklistStatus === "blacklisted") {
    appLog("IP: " . $ip . " blacklisted due to suspicious activity", 1);
    http_response_code(403);
    die("Your IP address has been blacklisted. If you believe this is an error, please contact us.");
}
```

update_failed_attempts(IP); is more for logins, update_invalid_activity(IP); is better used for situations where it is triggered if people are doing things they should not.
