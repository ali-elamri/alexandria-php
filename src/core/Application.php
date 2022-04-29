<?php

require "./common/Redirect.php";
require "./controllers/HomeController.php";
require "./controllers/UsersController.php";

class Application
{
  private $_class = DEFAULT_CONTROLLER;
  private $_method = DEFAULT_CONTROLLER_ACTION;
  private $_params = [];

  public function __construct()
  {
    $this->_parseURL();

    try {
      $this->_getClass();
      $this->_getMethod();
      $this->_getParams();
    } catch (Exception $e) {
      Redirect::to(404);
    }
  }

  private function _parseURL()
  {
    $url = isset($_GET['url']) ? $_GET['url'] : '';
    if ($url) {
      $this->_params = explode("/", filter_var(rtrim($url, "/"), FILTER_SANITIZE_URL));
    }
  }

  private function _getClass()
  {
    if (isset($this->_params[0]) and !empty($this->_params[0])) {
      $this->_class = ucfirst(strtolower($this->_params[0])) . "Controller";
      unset($this->_params[0]);
    }
    if (!class_exists($this->_class)) {
      Helpers::error("The controller {$this->_class} does not exist.");
    }
    $this->_class = new $this->_class;
  }

  private function _getMethod()
  {
    if (isset($this->_params[1]) and !empty($this->_params[1])) {
      $this->_method = $this->_params[1];
      unset($this->_params[1]);
    }

    // Check to ensure the requested controller method exists.
    if (!(new ReflectionClass($this->_class))->hasMethod($this->_method)) {
      Helpers::error("The controller method {$this->_method} does not exist!");
    }

    // Check to ensure the requested controller method is pubic.
    if (!(new ReflectionMethod($this->_class, $this->_method))->isPublic()) {
      Helpers::error("The controller method {$this->_method} is not accessible!");
    }
  }

  private function _getParams()
  {
    $this->_params = $this->_params ? array_values($this->_params) : [];
  }

  public function run()
  {
    call_user_func_array([$this->_class, $this->_method], $this->_params);
  }
}
