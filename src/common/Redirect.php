<?php

class Redirect
{
  public static function to($location = "")
  {
    if ($location) {
      if ($location === 404) {
        header('HTTP/1.0 404 Not Found');
        include VIEW_PATH . DEFAULT_404_PATH;
      } else {
        header("Location: " . $location);
      }
      exit();
    }
  }
}
