<?php

namespace App\Controllers;

use App\Models\User;
use Exception;

class UserController extends Controller
{
  public function __construct()
  {
    session_start();
    if (!isset($_SESSION['login']) || empty($_SESSION['login'])) {
      redirect('/login');
    }
    getPermissions(MODULES['usuarios']);
  }

  public function usersPage()
  {
    $data = [
      'page_tag' => 'Usuarios',
      'page_name' => 'users',
      'page_title' => 'Usuarios <small>Tienda Virtual</small>',
      'page_functions_js' => "functions_users.js"
    ];
    return $this->view('pages.usersPage', $data);
  }

  public function insert()
  {
    validateFields($_POST, "identificacion", "names", "surname", "phone", "email", "role_id");
    validateInteger($_POST['phone'], "phone");
    validateInteger($_POST['role_id'], "role_id");
    $_POST['names'] = ucwords($_POST['names']);
    $_POST['surname'] = ucwords($_POST['surname']);
    $_POST['email'] = strtolower($_POST['email']);
    $model = new User;
    try {
      $user = $model->where("identificacion", "=", $_POST["identificacion"])->first();
      if (!empty($user)) {
        badRequestResponse("La identificacion ya esta en uso");
      }
      $user = $model->where("email", "=", $_POST["email"])->first();
      if (!empty($user)) {
        badRequestResponse("El correo ya esta en uso");
      }
      if (!isset($_POST['password']) || empty($_POST['password'])) {
        $_POST['password'] = hash('sha256', passGenerator());
      } else {
        $_POST['password'] = hash('sha256', $_POST['password']);
      }
      $insertId = $model->create($_POST);
      if ($insertId > 0) {
        createdResponse("Usuario creado exitosamente");
      }
    } catch (Exception $e) {
      internalServerErrorResponse("Error al crear usuario", $e->getMessage());
    }
  }

  public function find($id)
  {
    validateId($id);
    $model = new User;
    try {
      $sql = "SELECT
      u.id, u.identificacion, u.names, u.surname, u.phone, u.email, u.nit, u.nombre_fiscal, u.direccion_fiscal, u.role_id, u.status,
      r.role_name,
      DATE_FORMAT(u.date_created, '%d-%m-%Y') as fecha_registro
      FROM users u
      INNER JOIN roles r
      ON u.role_id = r.id
      WHERE u.id = $id";
      $user = $model->query($sql)->first();
      if (!is_array($user)) {
        notFoundResponse("El usuario no existe");
      }
      jsonResponse([
        'success' => true,
        'data' => $user
      ]);
    } catch (Exception $e) {
      internalServerErrorResponse("Error al obtener usuario", $e->getMessage());
    }
  }

  public function update()
  {
    validateFields($_POST, "id", "email", "identificacion", "names", "surname", "phone", "role_id", "status");
    $id = $_POST['id'];
    validateId($id);
    validateStatus($_POST['status']);
    unset($_POST['id']);
    try {
      $model = new User;
      $user = $model
        ->where("identificacion", "=", $_POST["identificacion"])
        ->andWhere("id", "!=", $id)
        ->first();
      if (!empty($user)) {
        badRequestResponse("La identificacion ya esta en uso");
      }
      $user = $model
        ->where("email", "=", $_POST["email"])
        ->andWhere("id", "!=", $id)
        ->first();
      if (!empty($user)) {
        badRequestResponse("El correo ya esta en uso");
      }
      if (isset($_POST['password']) && !empty($_POST['password'])) {
        $_POST['password'] = hash('sha256', $_POST['password']);
      }
      $model->update($id, $_POST);
      okResponse("Usuario actualizado correctamente");
    } catch (Exception $e) {
      internalServerErrorResponse("Error al actualizar usuario", $e->getMessage());
    }
  }

  public function all()
  {
    $sql = "SELECT 
    u.id, u.identificacion, u.names, u.surname, u.phone, u.email, u.status,
    r.role_name
    FROM users u
    INNER JOIN roles r
    ON u.role_id = r.id
    WHERE u.status != 0";
    $model = new User;
    try {
      $users = $model->query($sql)->get();

      for ($i = 0; $i < count($users); $i++) {
        $btnView = '';
        $btnEdit = '';
        $btnDelete = '';

        $badge = $users[$i]['status'] == 1 ?
          '<span class="badge badge-success">Activo</span>' :
          '<span class="badge badge-danger">Inactivo</span>';

        $users[$i]['status'] = $badge;
        $userId = $users[$i]['id'];
        if ($_SESSION['permissions_module']['r'] == 1) {
          $btnView = '<button class="btn btn-info btn-sm btnViewUser" onclick=handleButtonViewUser(' . $userId . ') title="Ver"><i class="fas fa-eye"></i></button>';
        }
        if ($_SESSION['permissions_module']['u'] == 1) {
          $btnEdit = '<button class="btn btn-primary btn-sm btnEditUser" onclick=handleButtonEditUser(' . $userId . ') title="Editar"><i class="fas fa-pencil-alt"></i></button>';
        }
        if ($_SESSION['permissions_module']['d'] == 1) {
          $btnDelete = '<button class="btn btn-danger btn-sm btnDelUser" onclick=handleButtonDeleteUser(' . $userId . ') title="Eliminar"><i class="fas fa-trash-alt"></i></button>';
        }
        $users[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . ' ' . '</div>';
      }

      return jsonResponse($users);
    } catch (Exception $e) {
      internalServerErrorResponse("Error al obtener usuarios", $e->getMessage());
    }

    return $users;
  }

  public function delete($id)
  {
    validateId($id);
    $model = new User;
    try {
      $user = $model->where("id", "=", $id)->first();
      if (empty($user)) {
        notFoundResponse("El usuario no existe");
      }
      $model->update($id, ["status" => 0]);
      okResponse("Usuario eliminado correctamente");
    } catch (Exception $e) {
      internalServerErrorResponse("Error al eliminar usuario", $e->getMessage());
    }
  }
}
