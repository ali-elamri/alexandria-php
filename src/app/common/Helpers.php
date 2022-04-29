<?php

namespace App\Common;

/**
 * The helpers class provides a set of helper functions.
 * 
 * It is loaded by the index.php file and provides access to its
 * contents.
 */
class Helpers
{
  /**
   * The error function displays an error message and exits the script.
   *
   * @param string $message
   * @return void
   */
  public static function warn(string $message)
  {
    print_r("<pre><strong style='color:RED'>ERROR:</strong> $message</pre>");
  }

  /**
   * The error function displays an error message and exits the script.
   *
   * @param string $message
   * @return void
   */
  public static function error(string $message)
  {
    die("<pre><strong style='color:RED'>ERROR:</strong> $message</pre>");
  }
}
