<!-- Modal -->
<div class="modal fade" id="role_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="modalTitle">Nuevo Rol</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
          <div class="tile-body">
            <form name="formRole" id="formRole">
              <input type="hidden" id="id_role" name="id" value="">
              <div class=" form-group">
                <label class="control-label" for="role_name">Nombre</label>
                <input class="form-control" id="role_name" name="role_name" type="text" placeholder="Nombre del role"
                  required>
              </div>
              <div class="form-group">
                <label class="control-label" for="role_description">Descripcion</label>
                <textarea class="form-control" id="role_description" name="role_description" rows="2"
                  placeholder="Descripcion del role" required></textarea>
              </div>
              <div class="form-group">
                <label for="role_status">Estado</label>
                <select class="form-control" id="role_status" name="status" required>
                  <option value="1">Activo</option>
                  <option value="2">Inactivo</option>
                </select>
              </div>
              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit">
                  <i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span>
                </button>&nbsp;&nbsp;&nbsp;
                <a class="btn btn-secondary" href="#" data-dismiss="modal">
                  <i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>