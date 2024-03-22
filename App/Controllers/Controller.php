<?php

namespace App\Controllers;

class Controller
{
  public function view($route, $data = [])
  {
    // desestructura el array y crear variables con los nombres de las claves
    extract($data);

    $route = str_replace('.', '/', $route);

    if (file_exists("../view/$route.php")) {
      ob_start();
      include "../view/$route.php";
      $content = ob_get_clean();

      return $content;
    } else {
      return "el archivo no existe";
    }
  }

  public function redirect($route)
  {
    header("Location: {$route}");
  }
}
