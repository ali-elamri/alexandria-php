<?php

require_once "../vendor/autoload.php";

define("ROOT", realpath(dirname(__FILE__) . "/../") . "/");

define("APP_NAME", "Alexandria");
define("APP_ROOT", ROOT . "app/");
define("APP_PROTOCOL", stripos($_SERVER["SERVER_PROTOCOL"], "https") === true ? "https://" : "http://");
define("APP_URL", APP_PROTOCOL . $_SERVER["HTTP_HOST"] . "/");

define("CONFIG_FILE", APP_ROOT . "config.php");

define("CONTROLLERS_NAMESPACE", "App\Controllers\\");
define("DEFAULT_CONTROLLER", CONTROLLERS_NAMESPACE . "HomeController");
define("DEFAULT_CONTROLLER_ACTION", "index");

define("VIEW_PATH", APP_ROOT . "views/");
define("DEFAULT_404_PATH", "templates/404.php");
define("DEFAULT_HEADER_PATH", "templates/header");
define("DEFAULT_FOOTER_PATH", "templates/footer");
