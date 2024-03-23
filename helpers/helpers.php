<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
// TODO cada vez que se cree un role crear los permisos para ese rol

use App\Models\Permission;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Retorna la url del proyecto
function base_url()
{
  return BASE_URL;
}
function headerAdmin($data = "")
{
  $view_header = '../view/templates/header_admin.php';
  require_once($view_header);
}
function navAdmin($data = "")
{
  $view_nav = '../view/templates/nav_admin.php';
  require_once($view_nav);
}
function footerAdmin($data = "")
{
  $view_footer = '../view/templates/footer_admin.php';
  require_once($view_footer);
}
function getModal($modalName, $data)
{
  $view_modal = "../view/modals/{$modalName}.php";
  require_once $view_modal;
}
// Muestra informacion formateada
function dep($data)
{
  echo '<pre>';
  print_r($data);
  echo '</pre>';
}

//Elimina exceso de espacios entre palabras
function strClean($strCadena)
{
  $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
  $string = trim($string); //Elimina espacios en blanco al inicio y al final
  $string = stripslashes($string); // Elimina las \ invertidas
  $string = str_ireplace("<script>", "", $string);
  $string = str_ireplace("</script>", "", $string);
  $string = str_ireplace("<script src>", "", $string);
  $string = str_ireplace("<script type=>", "", $string);
  $string = str_ireplace("SELECT * FROM", "", $string);
  $string = str_ireplace("DELETE FROM", "", $string);
  $string = str_ireplace("INSERT INTO", "", $string);
  $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
  $string = str_ireplace("DROP TABLE", "", $string);
  $string = str_ireplace("OR '1'='1", "", $string);
  $string = str_ireplace('OR "1"="1"', "", $string);
  $string = str_ireplace('OR ´1´=´1´', "", $string);
  $string = str_ireplace("is NULL; --", "", $string);
  $string = str_ireplace("is NULL; --", "", $string);
  $string = str_ireplace("LIKE '", "", $string);
  $string = str_ireplace('LIKE "', "", $string);
  $string = str_ireplace("LIKE ´", "", $string);
  $string = str_ireplace("OR 'a'='a", "", $string);
  $string = str_ireplace('OR "a"="a', "", $string);
  $string = str_ireplace("OR ´a´=´a", "", $string);
  $string = str_ireplace("OR ´a´=´a", "", $string);
  $string = str_ireplace("--", "", $string);
  $string = str_ireplace("^", "", $string);
  $string = str_ireplace("[", "", $string);
  $string = str_ireplace("]", "", $string);
  $string = str_ireplace("==", "", $string);
  return $string;
}
//Genera una contraseña de 10 caracteres
function passGenerator($length = 10)
{
  $pass = "";
  $longitudPass = $length;
  $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
  $longitudCadena = strlen($cadena);

  for ($i = 1; $i <= $longitudPass; $i++) {
    $pos = rand(0, $longitudCadena - 1);
    $pass .= substr($cadena, $pos, 1);
  }
  return $pass;
}
//Genera un token
function token()
{
  $r1 = bin2hex(random_bytes(10));
  $r2 = bin2hex(random_bytes(10));
  $r3 = bin2hex(random_bytes(10));
  $r4 = bin2hex(random_bytes(10));
  $token = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4;
  return $token;
}
//Formato para valores monetarios
function formatMoney($cantidad)
{
  $cantidad = number_format($cantidad, 2, SPD, SPM);
  return $cantidad;
}

function validateFields($data, ...$fields)
{
  foreach ($fields as $field) {
    if (!isset($data[$field]) || empty($data[$field])) {
      badRequestResponse("field $field is required");
    }
  }
}
function validateStatus($status)
{
  if ($status != 1 && $status != 2) {
    badRequestResponse("field status must be 1 or 2: $status");
  }
}
function validateId($id)
{
  if (!isset($id) || empty($id)) {
    badRequestResponse("id is required");
  }
  validateInteger($id, "id");
}
function validateInteger($value, $fieldName)
{
  if (!is_numeric($value)) {
    badRequestResponse("field $fieldName must be numeric");
  }
  if ($value < 1) {
    badRequestResponse("$fieldName must be greater then 0");
  }
}

function validateToken($token)
{
  if (!isset($token) || empty($token)) {
    badRequestResponse("token is required");
  }
}


function jsonResponse(array $data, int $code = 200)
{
  if (is_array($data)) {
    header("HTTP/1.1 " . $code);
    header("Content-Type: application/json");
    echo json_encode($data, true);
  }
  die();
}

function okResponse(string $message)
{
  $data = [
    "success" => true,
    "message" => $message
  ];
  jsonResponse($data, 200);
}
function createdResponse(string $message)
{
  $data = [
    "success" => true,
    "message" => $message
  ];
  jsonResponse($data, 201);
}

function badRequestResponse(string $message)
{
  $data = [
    "success" => false,
    "message" => $message
  ];
  jsonResponse($data, 400);
}
function paramsErrorResponse(string $message)
{
  $data = [
    "success" => false,
    "message" => "Params error: " . $message,
  ];
  jsonResponse($data, 400);
}

function internalServerErrorResponse(string $message, string $error)
{
  $data = [
    "success" => false,
    "message" => $message,
    "error" => $error
  ];
  jsonResponse($data, 500);
}

function methodNotAllowedResponse(string $method)
{
  $data = [
    "success" => false,
    "message" => "Error en la solicitud $method"
  ];
  jsonResponse($data, 405);
}

function notFoundResponse($message = null)
{
  $data = [
    "success" => false,
    "message" => $message ?? "Recurso no encontrado"
  ];
  jsonResponse($data, 404);
}

function redirect($path)
{
  header("location: " . base_url() . $path);
  die();
}

//Envio de correos
function sendEmail($data, $template)
{
  $subject = $data['subject'];
  $toEmail = $data['email'];
  $empresa = NOMBRE_REMITENTE;
  $remitente = EMAIL_REMITENTE;
  //ENVIO DE CORREO
  $de = "MIME-Version: 1.0\r\n";
  $de .= "Content-type: text/html; charset=UTF-8\r\n";
  $de .= "From: {$empresa} <{$remitente}>\r\n";
  ob_start();
  require_once("../views/email/" . $template . ".php");
  $mensaje = ob_get_clean();
  $send = mail($toEmail, $subject, $mensaje, $de);
  return $send;
}

class EmailSender
{
  private static $instance;
  private $mailer;

  public function __construct()
  {
    $this->mailer = new PHPMailer(true);
    $this->mailer->SMTPDebug = SMTP::DEBUG_OFF;
    $this->mailer->isSMTP();
    $this->mailer->Host = 'smtp.gmail.com';
    $this->mailer->SMTPAuth = true;
    $this->mailer->Username = $_ENV['MAILER_USERNAME'];
    $this->mailer->Password = $_ENV['MAILER_PASS'];
    $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $this->mailer->Port = 465;
    $this->mailer->setFrom($_ENV['MAILER_USERNAME']);
  }

  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function sendEmail($to, $subject, $body)
  {
    try {
      $this->mailer->addAddress($to);
      $this->mailer->isHTML(true);
      $this->mailer->Subject = mb_encode_mimeheader($subject, "UTF-8");
      $this->mailer->Body = $body;

      return $this->mailer->send();
    } catch (Exception $e) {
      internalServerErrorResponse("Error al enviar el correo", $e->getMessage());
    }
  }
}

function getPermissions($idModule)
{
  $model = new Permission;
  $roleId = $_SESSION['user']['role_id'];
  $sql = "SELECT 
  p.role_id, p.module_id, m.module_name, p.r, p.w, p.u, p.d  
  FROM permissions p
  INNER JOIN modules m
  ON p.module_id = m.id
  WHERE p.role_id = $roleId";
  $permissionsModule = $model->all($sql);
}
