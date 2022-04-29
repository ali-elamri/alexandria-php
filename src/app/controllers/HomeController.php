<?php

namespace App\Controllers;

use App\Base\Controller;

class HomeController extends Controller
{
  public function index()
  {
    $this->view->render("home/index", [
      "title" => "Home"
    ]);
  }
}
