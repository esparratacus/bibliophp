<?php
require_once '../../includes/includes.php';
include_once ROOT_PATH . '/Model/Mapper/UserMapper.php';


  $um = new UserMapper($con);

  if(isset($_POST['new_user'])){
    $user = new User($_POST['new_user']);
    $fetch_result = $um->find("Email='" . $user->email . "'")->toArray();
    if(!empty($fetch_result)){ // Email is already registered
      $_GLOBALS['errors']="El correo ya se encuentra registrado"; // Fix
    } else { //Register the new user
      $user->password = hash_password($user->password); 
      $um->insert($user, $user);

      $_GLOBALS['success_notifications']=  "Usuario creado"; // Remove

      $_SESSION['current_user'] = $user;
      
      // TODO Redirect
    }
  }

  require_head("https://getbootstrap.com/docs/4.1/examples/sign-in/signin.css" );
?>


<main role="main" class="container" style="margin-top: 60px;">

<?php if(isset($_GLOBALS['errors'])):?>
    <div class="alert alert-danger" role="alert">
         <?php echo $_GLOBALS['errors'];?>
      </div>
    <?php endif; ?>
    <?php if(isset($_GLOBALS['success_notifications'])):?>
    <div class="alert alert-success" role="alert">
         <?php echo $_GLOBALS['success_notifications'];?>
      </div>
    <?php endif; ?>
      <form class="form-signin" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
        <h1 class="h3 mb-3 font-weight-normal">Nuevo usuario</h1>
        <div class="form-group">
          <label for="new_user[username]" >Nombre de usuario</label>
          <input type="text" id="inputUsername" name="new_user[username]" class="form-control" placeholder="Nombre de usuario" required autofocus>
        </div>

        <div class="form-group">
          <label for="new_user[email]" >Dirección de correo</label>
          <input type="email" id="inputEmail" name="new_user[email]" class="form-control" placeholder="Correo" required autofocus>
        </div>

        <div class="form-group">
          <label for="new_user[password]" >Contraseña</label>
          <input type="password" id="inputPassword" name="new_user[password]" class="form-control" placeholder="Contraseña" required>
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Registrarse</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
      </form>

    </main>

<?php require_foot() ?>