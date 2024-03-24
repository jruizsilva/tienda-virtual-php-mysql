<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?php base_url() ?>/img/avatar.png" alt="User Image">
    <div>
      <p class="app-sidebar__user-name">
        <?= $_SESSION['user']['names'] ?>
      </p>
      <p class="app-sidebar__user-designation">
        <?= $_SESSION['user']['role_name'] ?>
      </p>
    </div>
  </div>
  <ul class="app-menu">
    <!-- Dashboard module id = 1 -->
    <?php if (isset($_SESSION['permissions']) && $_SESSION['permissions'][1]['r'] == 1) : ?>
      <li>
        <a class="app-menu__item" href="<?php base_url(); ?>/dashboard">
          <i class="app-menu__icon fa fa-dashboard"></i>
          <span class="app-menu__label">Dashboard</span>
        </a>
      </li>
    <?php endif; ?>

    <!-- Usuarios module id = 2 -->
    <?php if (isset($_SESSION['permissions']) && $_SESSION['permissions'][2]['r'] == 1) : ?>
      <li class="treeview">
        <a class="app-menu__item" href="#" data-toggle="treeview">
          <i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
          <span class="app-menu__label">Usuarios</span>
          <i class="treeview-indicator fa fa-angle-right"></i>
        </a>
        <ul class="treeview-menu">
          <li>
            <a class="treeview-item" href="<?php base_url(); ?>/users">
              <i class="icon fa fa-circle-o"></i>Usuarios
            </a>
          </li>
          <li>
            <a class="treeview-item" href="<?php base_url(); ?>/roles">
              <i class="icon fa fa-circle-o"></i> Roles
            </a>
          </li>
        </ul>
      </li>
    <?php endif; ?>

    <!-- Clientes module id = 3 -->
    <?php if (isset($_SESSION['permissions']) && $_SESSION['permissions'][3]['r'] == 1) : ?>
      <li>
        <a class="app-menu__item" href="<?php base_url(); ?>/customers">
          <i class="app-menu__icon fa fa-user" aria-hidden="true"></i>
          <span class="app-menu__label">Clientes</span>
        </a>
      </li>
    <?php endif; ?>

    <?php if (isset($_SESSION['permissions']) && ($_SESSION['permissions'][4]['r'] == 1  || $_SESSION['permissions'][6]['r'] == 1)) : ?>
      <li class="treeview">
        <a class="app-menu__item" href="#" data-toggle="treeview">
          <i class="app-menu__icon fa fa-archive" aria-hidden="true"></i>
          <span class="app-menu__label">Tienda</span>
          <i class="treeview-indicator fa fa-angle-right"></i>
        </a>
        <ul class="treeview-menu">
          <?php if ($_SESSION['permissions'][4]['r'] == 1) : ?>
            <li>
              <a class="treeview-item" href="<?php base_url(); ?>/products">
                <i class="icon fa fa-circle-o"></i> Productos
              </a>
            </li>
          <?php endif; ?>
          <?php if ($_SESSION['permissions'][6]['r'] == 1) : ?>
            <li>
              <a class="treeview-item" href="<?php base_url(); ?>/categories">
                <i class="icon fa fa-circle-o"></i>Categorias
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </li>
    <?php endif; ?>

    <!-- Pedidos module id = 5 -->
    <?php if (isset($_SESSION['permissions']) && $_SESSION['permissions'][5]['r'] == 1) : ?>
      <li>
        <a class="app-menu__item" href="<?php base_url(); ?>/orders">
          <i class="app-menu__icon fa fa-shopping-cart"></i>
          <span class="app-menu__label">Pedidos</span>
        </a>
      </li>

    <?php endif; ?>
    <li>
      <a class="app-menu__item" href="<?php base_url(); ?>/logout">
        <i class="app-menu__icon fa fa-sign-out"></i>
        <span class="app-menu__label">Logout</span>
      </a>
    </li>
  </ul>
</aside>