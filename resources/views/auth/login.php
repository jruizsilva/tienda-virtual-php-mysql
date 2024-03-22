<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Jonathan Ruiz">
  <meta name="theme-color" content="#009688">
  <link rel="shortcut icon" href="<?= base_url() . "/favicon.ico" ?>">
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
    <div class="login-box">
      <div id="divloading">
        <div>
          <img src="<?= base_url() . "/img/loading.svg" ?>" alt="loading">
        </div>
      </div>
      <form class="login-form" action="" name="formLogin" id="formLogin">
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Iniciar Sesión</h3>
        <div class="form-group">
          <label class="control-label">Email</label>
          <input id="email" name="email" class="form-control" type="email" placeholder="Email" autofocus>
        </div>
        <div class="form-group">
          <label class="control-label">Contraseña</label>
          <input id="password" name="password" class="form-control" type="password" placeholder="Contraseña">
        </div>
        <div class="form-group">
          <div class="utility">
            <p class="semibold-text mb-2"><a href="#" data-toggle="flip">¿Olvidaste tu contraseña?</a></p>
          </div>
        </div>
        <div id="alertLogin" class="text-center"></div>
        <div class="form-group btn-container">
          <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i> Iniciar
            sesión</button>
        </div>
      </form>
      <form id="formResetPassword" action="" name="formResetPassword" class="forget-form">
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>¿Olvidaste tu contraseña?</h3>
        <div class="form-group">
          <label class="control-label">Email</label>
          <input class="form-control" id="resetPasswordEmail" name="email" type="email" placeholder="Email">
        </div>
        <div class="form-group btn-container">
          <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>Reiniciar</button>
        </div>
        <div class="form-group mt-3">
          <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Iniciar
              sesión</a></p>
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