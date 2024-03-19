<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Jonathan Ruiz">
  <meta name="theme-color" content="#009688">
  <link rel="shortcut icon" href=<?= base_url() . "/favicon.ico" ?>>
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() . "/css/main.css" ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url() . "/css/styles.css" ?>">
  <title>
    <?= $data['page_tag'] ?>
  </title>
</head>

<body>
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>
  <section class="login-content">
    <div class="logo">
      <h1>
        <?= $data['page_title'] ?>
      </h1>
    </div>
    <div class="login-box flipped">
      <form id="formChangePassword" action="" name="formChangePassword" class="forget-form">
        <input type="hidden" id="userId" name="id" value="<?php echo $data['id']; ?>" required>
        <input type="hidden" id="email" name="email" value="<?php echo $data['email']; ?>" required>
        <input type="hidden" id="token" name="token" value="<?php echo $data['token']; ?>" required>
        <h3 class="login-head"><i class="fas fa-key"></i> Cambiar contraseña</h3>
        <div class="form-group">
          <input class="form-control" id="password" name="password" type="password" placeholder="Nueva contraseña">
        </div>
        <div class="form-group">
          <input class="form-control" id="confirmPassword" name="confirmPassword" type="password" placeholder="Confirmar contraseña">
        </div>
        <div class="form-group btn-container">
          <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>Cambiar contraseña</button>
        </div>
      </form>
    </div>
  </section>
  <!-- Essential javascripts for application to work-->
  <script src="<?= base_url() . "/js/jquery-3.3.1.min.js" ?>"></script>
  <script src="<?= base_url() . "/js/popper.min.js" ?>"></script>
  <script src="<?= base_url() . "/js/bootstrap.min.js" ?>"></script>
  <script src="<?= base_url() . "/js/fontawesome.js" ?>"></script>
  <script src="<?= base_url() . "/js/main.js" ?>"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="<?= base_url() . "/js/plugins/pace.min.js" ?>"></script>
  <script type="text/javascript" src="<?= base_url() . "/js/plugins/sweetalert.min.js" ?>"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script>
    const base_url = "<?= base_url() ?>";
  </script>
  <script src="<?= base_url() . "/js/" . $data["page_functions_js"] ?>"></script>
</body>

</html>