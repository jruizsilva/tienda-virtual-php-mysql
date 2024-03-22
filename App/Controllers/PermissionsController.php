<?php

namespace App\Controllers;

use App\Models\Module;
use App\Models\Permission;
use Exception;

class PermissionsController extends Controller
{

  public function allByRoleId($roleId)
  {
    validateId($roleId);
    $model = new Module;
    try {
      $modules = $model
        ->where("status", "!=", "0")
        ->get();
      $model = new Permission;
      $role_permissions = $model
        ->where("role_id", "=", $roleId)
        ->get();

      $permissions = [
        'r' => 0,
        'w' => 0,
        'u' => 0,
        'd' => 0,
      ];
      if (empty($role_permissions)) {
        for ($i = 0; $i < count($modules); $i++) {
          $modules[$i]['permissions'] = $permissions;
        }
      } else {
        for ($i = 0; $i < count($modules); $i++) {
          $permissions = [
            'r' => 0,
            'w' => 0,
            'u' => 0,
            'd' => 0,
          ];
          if (isset($role_permissions[$i])) {
            $permissions = [
              'r' => $role_permissions[$i]['r'],
              'w' => $role_permissions[$i]['w'],
              'u' => $role_permissions[$i]['u'],
              'd' => $role_permissions[$i]['d'],
            ];
          }
          $modules[$i]['permissions'] = $permissions;
        }
      }
      $role_permissions = [
        'id' => $roleId,
        'modules' => $modules,
      ];
      ob_start();
      getModal('permissions_modal', $role_permissions);
      $permissions_modal = ob_get_clean();

      jsonResponse([
        'success' => true,
        'html' => $permissions_modal,
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
