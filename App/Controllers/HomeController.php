<?php

namespace App\Controllers;

class HomeController extends Controller
{
  public function index()
  {
    return $this->view('home', [
      'title' => 'Home',
      'description' => 'This is the home page',
    ]);
  }


}