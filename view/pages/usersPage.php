<?php
headerAdmin($data);
navAdmin($data);
?>
<?php
if ($_SESSION['permissions_module']['r'] == 1) { ?>
  <h1>Tienes permisos</h1>
  <?php getModal('users_modal', $data); ?>
  <main class="app-content">
    <?php dep($_SESSION['permissions_module']) ?>
    <div class="app-title">
      <div>
        <h1>
          <i class="fa fa-user-tag"></i>
          <?= $data['page_title'] ?>
          <button class="btn btn-primary" type="button" onclick="openModal();">
            <i class="fa-solid fa-plus"></i> Nuevo
          </button>
        </h1>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">
          <a href="<?= base_url() ?>/users">
            <?= $data['page_tag'] ?>
          </a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="tile-body">
            <div class="table-responsive">
              <table class="table table-hover table-bordered" id="tableUsers">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Status</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
<?php } else { ?>
  <main class="app-content">
    <h1>No tienes permisos</h1>
  </main>
<?php
}
?>

<?php footerAdmin($data) ?>