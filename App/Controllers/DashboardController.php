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

    getPermissions(MODULES['dashboard']);
  }

  public function dashboardPage()
  {
    $data = [
      'page_id' => 1,
      'page_tag' => "Dashboard - Tienda Virtual",
      'page_title' => "Dashboard - Tienda Virtual",
      'page_name' => "dashboard",
      'page_functions_js' => "functions_dashboard.js",
    ];
    return $this->view('pages.dashboardPage', $data);
  }
}
