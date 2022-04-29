<?php

class View
{
  public function addData(array $data)
  {
    foreach ($data as $key => $value) {
      $this->{$key} = $value;
    }
  }

  public function getFile($filepath)
  {
    $filename = VIEW_PATH . $filepath . ".php";
    if (file_exists($filename)) {
      require $filename;
    } else {
      Helpers::error("The view file {$filename} does not exist.");
    }
  }

  public function render($filepath, array $data = [])
  {
    $this->addData($data);
    $this->getFile(DEFAULT_HEADER_PATH);
    $this->getFile($filepath);
    $this->getFile(DEFAULT_FOOTER_PATH);
  }

  public function escapeHTML($string)
  {
    return (htmlentities($string, ENT_QUOTES, "UTF-8", false));
  }
}
