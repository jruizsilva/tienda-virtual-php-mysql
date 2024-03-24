<?php

namespace App\Controllers;

use App\Models\Role;
use App\Models\User;
use Exception;

class RoleController extends Controller
{
  public function __construct()
  {
    session_start();
    if (!isset($_SESSION['login']) || empty($_SESSION['login'])) {
      redirect('/login');
    }
    // module id -> 7
    getPermissions(MODULES['roles']);
  }

  public function rolesPage()
  {
    return $this->view('pages.rolesPage', [
      'page_id' => '3',
      'page_tag' => 'Roles Usuario',
      'page_name' => 'user_roles',
      'page_title' => 'Roles Usuario <small>Tienda Virtual</small>',
      'page_functions_js' => "functions_roles.js"
    ]);
  }

  public function insert()
  {
    validateFields($_POST, "role_name", "role_description", "status");
    validateStatus($_POST['status']);
    $model = new Role;
    try {
      $role = $model
        ->where("role_name", "=", $_POST['role_name'])
        ->first();
      if (!empty($role)) {
        badRequestResponse("Role name already added");
      }
      $insertId = $model->create($_POST);
      if ($insertId > 0) {
        createdResponse("Role created successfully");
      }
    } catch (Exception $e) {
      internalServerErrorResponse("Error al crear role", $e->getMessage());
    }
  }

  public function find($id)
  {
    validateId($id);
    $model = new Role;
    $role = $model->find($id);
    if (!is_array($role)) {
      return notFoundResponse("Role not found");
    }
    jsonResponse([
      'success' => true,
      'data' => $role
    ]);
  }

  public function update()
  {
    validateFields($_POST, "id", "role_name", "role_description", "status");
    $id = $_POST['id'];
    validateId($id);
    validateStatus($_POST['status']);
    unset($_POST['id']);

    $model = new Role;
    try {
      $role = $model
        ->where("role_name", "=", $_POST['role_name'])
        ->andWhere("id", "!=", $id)
        ->first();
      if (!empty($role)) {
        badRequestResponse("Role name already added");
      }
      $model->update($id, $_POST);
      okResponse("Rol actualizado correctamente");
    } catch (Exception $e) {
      internalServerErrorResponse("Error al actualizar role", $e->getMessage());
    }
  }

  public function all()
  {
    $model = new Role;
    try {
      $roles = $model->where("status", "!=", "0")->get();

      for ($i = 0; $i < count($roles); $i++) {
        $badge = $roles[$i]['status'] == 1 ?
          '<span class="badge badge-success">Activo</span>' :
          '<span class="badge badge-danger">Inactivo</span>';

        $roles[$i]['status'] = $badge;
        $roleId = $roles[$i]['id'];
        $roles[$i]['options'] = '<div class="text-center">
      <button class="btn btn-secondary btn-sm btnPermissionsRole" onclick=handleButtonPermissionsRole(' . $roleId . ') title="Permisos"><i class="fas fa-key"></i></button>
      <button class="btn btn-primary btn-sm btnEditRole" onclick=handleButtonEditRole(' . $roleId . ') title="Editar"><i class="fas fa-pencil-alt"></i></button>
      <button class="btn btn-danger btn-sm btnDelRole" onclick=handleButtonDeleteRole(' . $roleId . ') title="Eliminar"><i class="fas fa-trash-alt"></i></button>
      </div>';
      }

      return $roles;
    } catch (Exception $e) {
      internalServerErrorResponse("Error al obtener roles", $e->getMessage());
    }
  }

  public function delete($id)
  {
    validateId($id);
    $model = new User;
    $user = $model->where("id", "=", $id)->first();
    if (!empty($user)) {
      badRequestResponse("Role cannot be deleted because it is in use");
    }
    $model = new Role;
    try {
      $model->update($id, ['status' => 0]);
      okResponse("Rol eliminado correctamente");
    } catch (Exception $e) {
      internalServerErrorResponse("Error al eliminar role", $e->getMessage());
    }
  }

  public function allSelectOptions()
  {
    $htmlOptions = "";
    $model = new Role;
    try {
      $roles = $model
        ->where("status", "=", "1")
        ->get();

      if (!empty($roles)) {
        foreach ($roles as $role) {
          $htmlOptions .= "<option value=" . $role['id'] . ">" . $role['role_name'] . "</option>";
        }
        jsonResponse([
          'success' => true,
          'data' => $htmlOptions,
        ]);
      }
      notFoundResponse("No se encontraron roles");
    } catch (Exception $e) {
      internalServerErrorResponse("Error al obtener roles", $e->getMessage());
    }
  }
}
