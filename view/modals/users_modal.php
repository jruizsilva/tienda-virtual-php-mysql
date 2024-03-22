<!-- Modal -->
<div class="modal fade" id="users_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class=" modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="modalTitle">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="formUsers" id="formUsers" class="form-horizontal">
          <input type="hidden" id="id_user" name="id" value="">
          <p class="text-primary">Todos los campos son obligatorios</p>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="control-label" for="identificacion">Identificación</label>
              <input class="form-control" id="identificacion" name="identificacion" type="text" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="control-label" for="names">Nombres</label>
              <input class="form-control valid validText" id="names" name="names" type="text" required>
            </div>
            <div class="form-group col-md-6">
              <label class="control-label" for="surname">Apellidos</label>
              <input class="form-control valid validText" id="surname" name="surname" type="text" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="control-label" for="phone">Teléfono</label>
              <input class="form-control valid validNumber" id="phone" name="phone" type="text" required
                onkeypress="return controlTag(event)">
            </div>
            <div class="form-group col-md-6">
              <label class="control-label" for="email">Email</label>
              <input class="form-control valid validEmail" id="email" name="email" type="email" required>
            </div>
          </div>
          <div class="form-row">
            <div class=" form-group col-md-6">
              <label class="control-label" for="role_id_list">Tipo usuario</label>
              <select class="form-control" data-live-search="true" id="role_id_list" name="role_id" required></select>
            </div>
            <div class=" form-group col-md-6">
              <label class="control-label" for="status_list">Status</label>
              <select class="form-control selectpicker" id="status_list" name="status" required>
                <option value="1">Activo</option>
                <option value="2">Inactivo</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="control-label" for="password">Password</label>
              <input class="form-control" id="password" name="password" type="password">
            </div>
          </div>

          <div class="tile-footer">
            <button id="btnActionForm" class="btn btn-primary" type="submit">
              <i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span>
            </button>&nbsp;&nbsp;&nbsp;
            <button class="btn btn-danger" type="button" data-dismiss="modal">
              <i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="view_user_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class=" modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="modalTitle">Datos del Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Identificación: </td>
              <td id="identificacion_view">3213123</td>
            </tr>
            <tr>
              <td>Nombres: </td>
              <td id="names_view">3213123</td>
            </tr>
            <tr>
              <td>Apellidos: </td>
              <td id="surname_view">3213123</td>
            </tr>
            <tr>
              <td>Email: </td>
              <td id="email_view">3213123</td>
            </tr>
            <tr>
              <td>Tipo de usuario: </td>
              <td id="tipo_usuario_view">3213123</td>
            </tr>
            <tr>
              <td>Estado: </td>
              <td id="status_view">3213123</td>
            </tr>
            <tr>
              <td>Fecha registro: </td>
              <td id="date_created_view">231313</td>
            </tr>
          </tbody>
        </table>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>