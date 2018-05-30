<?php
  include_once dirname(__FILE__) . '/../../Database/credentials.php';
  include_once dirname(__FILE__) . '/../../Database/MysqlAdapter.php';
  include_once dirname(__FILE__) . '/../../Model/Mapper/UserMapper.php';

  $con = new MysqlAdapter(array(DB_HOST, DB_USER,DB_PASSWORD,DB_NAME));
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

      session_start();
      $_SESSION['current_user'] = $user;
      
      // TODO Redirect
    }
  }

  function hash_password($password){
    return password_hash($password, PASSWORD_BCRYPT);
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Biblioteca | Registro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
   
  <!-- Custom styles for this template -->
    <link href="https://v4-alpha.getbootstrap.com/examples/starter-template/starter-template.css" rel="stylesheet">
    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.1/examples/sign-in/signin.css" >
  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top" >
      
      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Eventos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Salas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Equipos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Libros</a>
          </li> 
        </ul>
      </div>
    </nav>

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
        <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
      </form>

    </main>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
  </body>
</html>
