<?php

/**
 * The config class loads the config file and provides access to its
 * contents.
 */
class Config
{
  private static $_config;

  /**
   * The load function loads the config file and stores its contents
   * in the $_config property.
   *  
   * These can be fetched by used the get() method and providing the
   * name of the config variable as a parameter as 'module.param'.
   * - e.g. $config->get('database.host');
   */
  public static function get($key)
  {
    // Load configuration file if it hasn't already been loaded
    if (empty(self::$_config)) {
      self::$_config = require_once CONFIG_FILE;
    }

    // Split $key into two part: $module and $param
    $explode = explode('.', $key);
    $module = $explode[0];
    $param = $explode[1];

    // Check if module and param actually exist
    if (array_key_exists($module, self::$_config) && array_key_exists($param, self::$_config[$module])) {
      return self::$_config[$module][$param];
    } else {
      Helpers::error("Property '$key' is not defined in config file.");
    }
  }
}
