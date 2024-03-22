<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="description" content="Tienda virtual">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Jonathan Ruiz">
  <meta name="theme-color" content="#009688">
  <link rel="shortcut icon" href=<?php base_url() . "/favicon.ico" ?>>
  <title>
    <?= $data['page_tag'] ?>
  </title>
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap-select.min.css">
</head>

<body class="app sidebar-mini">
  <!-- Navbar-->
  <header class="app-header">
    <a class="app-header__logo" href="<?= base_url() ?>/dashboard">
      Tienda Virtual
    </a>
    <!-- Sidebar toggle button-->
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar">
    </a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">
      <!-- User Menu-->
      <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i
            class="fa fa-user fa-lg"></i></a>
        <ul class="dropdown-menu settings-menu dropdown-menu-right">
          <li><a class="dropdown-item" href="<?= base_url() ?>/settings"><i class="fa fa-cog fa-lg"></i> Settings</a>
          </li>
          <li><a class="dropdown-item" href="<?= base_url() ?>/profile"><i class="fa fa-user fa-lg"></i> Profile</a>
          </li>
          <li><a class="dropdown-item" href="<?= base_url() ?>/auth/logout"><i class="fa fa-sign-out fa-lg"></i>
              Logout</a>
          </li>
        </ul>
      </li>
    </ul>
  </header>