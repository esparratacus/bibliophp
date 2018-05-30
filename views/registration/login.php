<?php
require_once '../../includes/includes.php';
include_once ROOT_PATH . '/Model/Mapper/UserMapper.php';

  $um = new UserMapper($con);

  if(isset($_POST['inputEmail'])){
    $fetch_result = $um->find("Email='" . $_POST['inputEmail'] . "'")->toArray();
    if(empty($fetch_result)){ // Invalid email
      $_GLOBALS['errors']= "Correo o contraseña inválidos"; // Fix
    } else {
      $user = $fetch_result[0];
      if(password_verify($_POST['inputPassword'], $user->password)){
        $_SESSION['current_user'] = $user;
        redirect('/index.php');
      } else {
        $_GLOBALS['errors']="Correo o contraseña inválidos"; // Fix
      }
    }
  }

require_head('https://getbootstrap.com/docs/4.1/examples/sign-in/signin.css');
?>

<main role="main" class="container">
    <?php if(isset($_GLOBALS['errors'])):?>
    <div class="alert alert-danger" role="alert">
         <?php echo $_GLOBALS['errors'];?>
      </div>
    <?php endif; ?>

    <form class="form-signin" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
        <h1 class="h3 mb-3 font-weight-normal">Iniciar sesión</h1>

        <label for="inputEmail" class="sr-only">Dirección de correo</label>
        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Dirección de correo" required autofocus>

        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Contraseña" required>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Recordar usuario
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar sesión</button>
        <br>
        <div class="text-center">
            <a href="<?php echo nav_link("/views/registration/new_user.php") ?>">Registrarse!</a>
        </div>
        <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
    </form>
</main>

<?php require_foot() ?>
