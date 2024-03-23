<?php

namespace App\Controllers;

use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use Exception;

class PermissionsController extends Controller
{
  public function allByRoleId($roleId)
  {
    validateId($roleId);
    $model = new Role;
    try {
      $role = $model->find($roleId);
      if (empty($role)) {
        notFoundResponse("El rol no existe");
      }
      $model = new Module;
      $modules = $model->where("status", "=", "1")->get();
      if (empty($modules)) {
        notFoundResponse("No se encontraron módulos");
      }
      $model = new Permission;
      $permissionsRole = $model->where('role_id', '=', $roleId)->get();
      if (empty($permissionsRole)) {
        notFoundResponse("No se encontraron permisos");
      }

      for ($i = 0; $i < count($modules); $i++) {
        for ($j = 0; $j < count($permissionsRole); $j++) {
          if ($modules[$i]['id'] == $permissionsRole[$j]['module_id']) {
            $modules[$i]['permissions'] = $permissionsRole[$i];
          }
        }
      }
      $role['modules'] = $modules;

      ob_start();
      getModal('permissions_modal', $role);
      $permissions_modal = ob_get_clean();

      jsonResponse([
        'success' => true,
        'html' => $permissions_modal,
        'role_permissions' => $role,
      ]);
    } catch (Exception $e) {
      internalServerErrorResponse("Error al obtener permisos del rol", $e->getMessage());
    }
  }

  public function updateByRoleId($roleId)
  {
    validateId($roleId);
    validateFields($_POST, "modules");
    $model = new Permission;
    $sql = "DELETE FROM permissions WHERE role_id = $roleId";
    try {
      $model->query($sql);
      $resInsert = null;
      foreach ($_POST['modules'] as $module) {
        validateFields($module, "id");
        $data = [
          'role_id' => $roleId,
          'module_id' => $module['id'],
          'r' => empty($module['r']) ? 0 : 1,
          'w' => empty($module['w']) ? 0 : 1,
          'u' => empty($module['u']) ? 0 : 1,
          'd' => empty($module['d']) ? 0 : 1,
        ];
        $resInsert = $model->create($data);
      }
      if ($resInsert > 0) {
        jsonResponse([
          'success' => true,
          'message' => "Permisos actualizados correctamente",
        ], 200);
      }
    } catch (Exception $e) {
      internalServerErrorResponse("Error al actualizar permisos del rol", $e->getMessage());
    }
  }
}
