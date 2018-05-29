<?php
  include_once dirname(__FILE__) . '/../../Database/credentials.php';
  include_once dirname(__FILE__) . '/../../Database/MysqlAdapter.php';
  include_once dirname(__FILE__) . '/../../Model/Mapper/UserMapper.php';

  $con = new MysqlAdapter(array(DB_HOST, DB_USER,DB_PASSWORD,DB_NAME));
  $um = new UserMapper($con);

  if(isset($_POST['inputEmail'])){
    $fetch_result = $um->find("Email='" . $_POST['inputEmail'] . "'")->toArray();
    if(empty($fetch_result)){ // Invalid email
      echo "Correo o contraseña inválidos"; // Fix
    } else {
      $user = $fetch_result[0];
      if(password_verify($_POST['inputPassword'], $user->password)){
        session_start();
        $_SESSION['current_user'] = $user;
        echo "Ok!"; // Fix
        
        // TODO Redirect
      } else {
        echo "Correo o contraseña inválidos"; // Fix
      }
    }
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

    <title>Biblioteca | Iniciar sesión</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
   
  <!-- Custom styles for this template -->
    <link href="https://v4-alpha.getbootstrap.com/examples/starter-template/starter-template.css" rel="stylesheet">
    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.1/examples/sign-in/signin.css" >
  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      
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

    <main role="main" class="container">

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
