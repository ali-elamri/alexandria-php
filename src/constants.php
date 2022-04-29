<?php

define("APP_NAME", "Alexandria");

define("ROOT", realpath(dirname(__FILE__)) . "/");
define("CONFIG_FILE", ROOT . "config.php");

define("DEFAULT_CONTROLLER", "HomeController");
define("DEFAULT_CONTROLLER_ACTION", "index");

define("VIEW_PATH", "./views/");
define("DEFAULT_404_PATH", "templates/404.php");
define("DEFAULT_HEADER_PATH", "templates/header");
define("DEFAULT_FOOTER_PATH", "templates/footer");
