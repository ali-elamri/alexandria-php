<?php

require_once "./constants.php";
require_once "./common/Helpers.php";
// require_once "./common/Database.php";
require "./models/Book.php";

echo "Welcome to " . APP_NAME . "!";
echo "<br>";
echo "<br>";


echo "<pre>";
print_r(Book::findWith());
echo "</pre>";
