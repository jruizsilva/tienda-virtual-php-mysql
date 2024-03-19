<?php

namespace App\Controllers;

class DashboardController extends Controller
{
  public function __construct()
  {
    session_start();
    if (!isset($_SESSION['login']) || empty($_SESSION['login'])) {
      redirect('/login');
    }
  }

  public function index()
  {
    return $this->view('dashboard.index', [
      'page_id' => 1,
      'page_tag' => "Dashboard - Tienda Virtual",
      'page_title' => "Dashboard - Tienda Virtual",
      'page_name' => "dashboard",
      'page_functions_js' => "functions_dashboard.js",
    ]);
  }
}