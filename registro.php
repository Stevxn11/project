<?php
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'clases/clienteFunciones.php';
$db = new Database();
$con = $db->conectar();

$errors = [];

if (!empty($_POST)) {

  $nombres = trim($_POST["nombres"]);
  $apellidos = trim($_POST['apellidos']);
  $email = trim($_POST['email']);
  $telefono = trim($_POST['telefono']);
  $dni = trim($_POST['dni']);
  $usuario = trim($_POST['usuario']);
  $password = trim($_POST['password']);
  $reepassword = trim($_POST['reepassword']);

  if (esNulo([$nombres, $apellidos, $email, $telefono, $dni, $usuario, $password, $reepassword])) {
    $errors[] = 'Debe llenar todos los campos';

  }

  if (!esEmail($email)) {
    $errors[] = 'la dirreccion de correo no es valida';
  }
  if (!validaPass($password, $reepassword)) {
    $errors[] = 'Las contaseñas no coinciden';
  }

  if (usuarioExiste($usuario, $con)) {
    $errors[] = "el nombre de usuario $usuario ya existe";
  }

  if (emailExiste($email, $con)) {
    $errors[] = "el email $email ya existe.";
  }


  if (count($errors) == 0) {


    $id = registraCliente([$nombres, $apellidos, $email, $telefono, $dni], $con);
    if ($id > 0) {
      require_once 'clases/mailer.php';
      $mailer = new Mailer();
      $token = generarToken();
      $pass_hash = password_hash($password, PASSWORD_DEFAULT);

      $idUsuario = registraUsuario([$usuario, $pass_hash, $token, $id], $con);

      if ($idUsuario > 0) {
        $url = SITE_URL . '/activa_cliente.php?id=' . $idUsuario . '&token=' . $token;
        //http://localhost/tienda_online/activa_cliente.php?id=23&token=0ce84f957deadccc6d6e6910744c9d22
        $asunto = 'activar cuenta - tienda online';
        $cuerpo = "Estimado $nombres: <br> Para continuar con el proceso de registro es indispensable que des click en el siguiente link
         <a href='$url'> Activar cuenta</a>";

        if ($mailer->enviarEmail($email, $asunto, $cuerpo)) {
          $message= "Para finalizar el registro siga las instrucciones 
            que le enviamos a su email $email";

        }
      } else {
        $errors[] = 'Error al registrar usuario';
      }
    } else {
      $errors[] = 'error al registar cliente';
    }

  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Arkatech</title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="css/estilos.css">

</head>

<body>
<style>
    .main-content {
    padding-top: 80px;
}
  </style>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>
    <?php include 'menu.php'; ?>
    <main class="main-content">

    <div class="container">
      <h2> Datos del cliente</h2>
      <?php
      if(!empty($message)) {

      echo '<div class="alert alert-success" role="alert">'. $message .'</div>';
      }
      mostarMensajes($errors);
      ?>


      <form action="registro.php" method="post" class="row g-3" autocomplete="off">
        <div class="col-md-6">
          <label for="nombres"><span class="text-danger">*</span> Nombres</label>
          <input type="text" name="nombres" id="nombres" class="form-control" requireda>

        </div>

        <div class="col-md-6">
          <label for="apellidos"><span class="text-danger">*</span> Apellidos</label>
          <input type="text" name="apellidos" id="apellidos" class="form-control" requireda>

        </div>

        <div class="col-md-6">
          <label for="email"><span class="text-danger">*</span> Email</label>
          <input type="email" name="email" id="email" class="form-control" requireda>

        </div>

        <div class="col-md-6">
          <label for="telefono"><span class="text-danger">*</span> Telefono</label>
          <input type="tel" name="telefono" id="telefono" class="form-control" requireda>

        </div>

        <div class="col-md-6">
          <label for="dni"><span class="text-danger">*</span> Dni</label>
          <input type="text" name="dni" id="dni" class="form-control" requireda>

        </div>

        <div class="col-md-6">
          <label for="usuario"><span class="text-danger">*</span> Usuario</label>
          <input type="text" name="usuario" id="usuario" class="form-control" requireda>

        </div>

        <div class="col-md-6">
          <label for="password"><span class="text-danger">*</span> Contraseña</label>
          <input type="password" name="password" id="password" class="form-control" requireda>

        </div>

        <div class="col-md-6">
          <label for="reepassword"><span class="text-danger">*</span> Repetir Contraseña</label>
          <input type="password" name="reepassword" id="reepassword" class="form-control" requireda>

        </div>

        <i><b>Nota:</b> Los campos con asteriscos son obligatorios</i>

        <div class="col-12">
          <button type="submit" class="btn btn-primary"> Registrar</button>

        </div>





      </form>

    </div>
  </main>



</body>

</html>