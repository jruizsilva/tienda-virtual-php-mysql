<div class="modal fade permissions_modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title h4">Permisos roles de usuarios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <?php
        // dep($data)
        ?>
        <div class="col-md-12">
          <div class="tile">
            <form action="" id="formPermissions" name="formPermissions">
              <input type="hidden" name="id" id="id_role" value="<?= $data['id'] ?>" required>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Módulo</th>
                      <th>Ver</th>
                      <th>Crear</th>
                      <th>Actualizar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $modules = $data['modules'];
                    for ($i = 0; $i < count($modules); $i++) {
                      $permissions = $modules[$i]['permissions'];
                      $rCheck = $permissions['r'] == 1 ? 'checked' : '';
                      $wCheck = $permissions['w'] == 1 ? 'checked' : '';
                      $uCheck = $permissions['u'] == 1 ? 'checked' : '';
                      $dCheck = $permissions['d'] == 1 ? 'checked' : '';
                      $moduleId = $modules[$i]['id'];
                      ?>
                      <tr>
                        <td>
                          <?= $no; ?>
                          <input type="hidden" name="modules[<?= $i ?>][id]" value="<?= $moduleId ?>" required>
                        </td>
                        <td>
                          <?= $modules[$i]['module_name']; ?>
                        </td>
                        <td>
                          <div class="toggle-flip">
                            <label>
                              <input type="checkbox" name="modules[<?= $i ?>][r]" <?= $rCheck ?>><span
                                class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                            </label>
                          </div>
                        </td>
                        <td>
                          <div class="toggle-flip">
                            <label>
                              <input type="checkbox" name="modules[<?= $i ?>][w]" <?= $wCheck ?>><span
                                class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                            </label>
                          </div>
                        </td>
                        <td>
                          <div class="toggle-flip">
                            <label>
                              <input type="checkbox" name="modules[<?= $i ?>][u]" <?= $uCheck ?>><span
                                class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                            </label>
                          </div>
                        </td>
                        <td>
                          <div class="toggle-flip">
                            <label>
                              <input type="checkbox" name="modules[<?= $i ?>][d]" <?= $dCheck ?>><span
                                class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                            </label>
                          </div>
                        </td>
                      </tr>

                      <?php
                      $no++;
                    } ?>
                  </tbody>
                </table>
              </div>
              <div class="text-center">
                <button class="btn btn-success" type="submit">
                  <i class="fa fa-fw fa-lg fa-check-circle" aria-hidden="true"></i> Guardar
                </button>
                <button class="btn btn-danger" type="button" data-dismiss="modal">
                  <i class="app-menu__icon fas fa-sign-out-alt" aria-hidden="true"></i> Salir
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>