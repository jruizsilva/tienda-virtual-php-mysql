<?php

namespace App\Controllers;

use App\Models\User;
use EmailSender;
use Exception;

class AuthController extends Controller
{
  private $emailSender;
  public function __construct()
  {
    session_start();
    $this->emailSender = EmailSender::getInstance();
  }

  public function loginPage()
  {
    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
      redirect('/dashboard');
    }
    $data = [
      'page_id' => 1,
      'page_tag' => "Login - Tienda Virtual",
      'page_title' => "Tienda Virtual",
      'page_name' => "login",
      'page_functions_js' => "functions_login.js"
    ];
    return $this->view('pages.loginPage', $data);
  }

  public function login()
  {
    validateFields($_POST, "email", "password");
    $model = new User;
    try {
      $user = $model
        ->select("id", "status")
        ->where("email", "=", strtolower($_POST['email']))
        ->andWhere("password", "=", hash("sha256", $_POST['password']))
        ->andWhere("status", "!=", "0")
        ->first();

      if (empty($user)) {
        jsonResponse([
          "success" => false,
          "message" => "Usuario o contraseña incorrectos"
        ]);
      }
      // Si el usuario está activo, inicia sesión con SESSION
      if ($user['status'] == 1) {
        $userId = $user['id'];
        $_SESSION['idUser'] = $userId;
        $_SESSION['login'] = true;

        $sql = "SELECT u.id, u.names, u.surname, u.phone, u.email, u.nit, 
        u.nombre_fiscal, u.direccion_fiscal, u.role_id, u.status,
        r.role_name
        FROM users u
        INNER JOIN roles r ON u.role_id = r.id
        WHERE u.id = $userId";
        $user = $model->query($sql)->first();
        $_SESSION['user'] = $user;
        jsonResponse([
          "success" => true,
          "message" => "Bienvenido",
          "data" => $user,
        ]);
      } else {
        jsonResponse([
          "success" => false,
          "message" => "Usuario inactivo"
        ]);
      }
    } catch (Exception $e) {
      internalServerErrorResponse("Error al iniciar sesion", $e->getMessage());
    }
  }

  public function logout()
  {
    if (session_unset() && session_destroy()) {
      redirect("/login");
    }
  }

  public function resetPassword()
  {
    // error_reporting(0);
    validateFields($_POST, "email");
    $_POST['email'] = strtolower($_POST['email']);
    $token = token();
    $model = new User;
    try {
      $user = $model
        ->select("id", "names", "surname", "status")
        ->where("email", "=", $_POST['email'])
        ->andWhere("status", "=", "1")
        ->first();
      if (empty($user)) {
        notFoundResponse("el correo " . $_POST["email"] . " no esta registrado");
      }
      $userId = $user['id'];
      $fullName = $user['names'] . " " . $user['surname'];
      $passwordRecoveryUrl = base_url() . "/auth/change-password/" . $_POST["email"] . "/$token";
      $model->update($userId, ["token" => $token]);

      $data = [
        "email" => $_POST["email"],
        "fullName" => $fullName,
        "passwordRecoveryUrl" => $passwordRecoveryUrl,
      ];

      ob_start();
      require_once("../view/email/email_cambioPassword.php");
      $bodyHtml = ob_get_clean();

      $to = $_POST['email'];
      $subject = "Cambiar contraseña - Tienda Virtual";
      $sendEmailRes = $this->emailSender->sendEmail($to, $subject, $bodyHtml);;
      if ($sendEmailRes == false) {
        $model->update($userId, ["token" => null]);
        badRequestResponse("Error al enviar email");
      }
      okResponse("Se ha enviado un correo electrónico a tu cuenta para cambiar la contraseña.");
    } catch (Exception $e) {
      internalServerErrorResponse("Error al cambiar contraseña", $e->getMessage());
    }
  }

  public function changePasswordPage($email, $token)
  {
    $model = new User;
    try {
      $user = $model
        ->where("email", "=", $email)
        ->andWhere("token", "=", $token)
        ->andWhere("status", "=", "1")
        ->first();
      if (empty($user)) {
        redirect('/');
      }
    } catch (Exception $e) {
      internalServerErrorResponse("Error al cambiar contraseña", $e->getMessage());
    }

    $data = [
      'page_id' => 1,
      'page_tag' => "Cambiar contraseña - Tienda Virtual",
      'page_title' => "Tienda Virtual",
      'page_name' => "change_password",
      'page_functions_js' => "functions_change_password.js",
      'id' => $user['id'],
      'email' => $user['email'],
      'token' => $user['token'],
    ];
    return $this->view('pages.changePasswordPage', $data);
  }

  public function changePassword()
  {
    validateFields($_POST, "password", "confirmPassword", "id", "email", "token");
    if ($_POST['password'] != $_POST['confirmPassword']) {
      badRequestResponse("Las contraseñas no coinciden");
    }
    $model = new User;
    try {
      $user = $model
        ->where("email", "=", $_POST['email'])
        ->andWhere("token", "=", $_POST['token'])
        ->andWhere("status", "=", "1")
        ->first();
      if (empty($user)) {
        redirect('/');
      }
      $userId = $user['id'];
      $model->update($userId, [
        "password" => hash("sha256", $_POST['password']),
        "token" => null
      ]);
      okResponse("Contraseña cambiada correctamente");
    } catch (Exception $e) {
      internalServerErrorResponse("Error al cambiar contraseña", $e->getMessage());
    }
  }
}
