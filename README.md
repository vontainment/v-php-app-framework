# v-php-app-framework

## Description
A Simple PHP App Framework for Building Secure Apps. Designed to be easier than traditional MVC frameworks, because any developer who says they can jump into a random codebase built with MVC and not be lost at first is likely exaggerating. This framework is based on API, Actions, Views, Helpers, and Libs.

### App (Contains core code)
- actions (Directs form input)
  - post (Contains `$action.php` file; post `$action` to direct)
  - get (Contains `$action.php` file; get `$action` to direct)
- api (Directs API requests)
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

## Features
- Automatic sanitization and validation on POST and GET requests.
- IP blacklisting for failed logins or suspicious activity.

## How To
- Forms:
~~~
<form action="/action.php" method="POST">
    <input type="hidden" name="action" value="login">
~~~

This routes the form submission to /app/actions/post/login.php, actions.php handles basic sanitization and validation.

- Logging:
Logging can be defined as debug or production in config.php, 1 is production, 2 is debug.

~~~
appLog("Attempted direct access to actions.php.", 1);
~~~
or
~~~
appLog("Attempted direct access to actions.php.", 2);
~~~