<?php
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'clases/clienteFunciones.php';
$db = new Database();
$con = $db->conectar();

$errors = [];

if (!empty($_POST)) {


  $email = trim($_POST['email']);


  if (esNulo([$email])) {
    $errors[] = 'Debe llenar todos los campos';

  }

  if (!esEmail($email)) {
    $errors[] = 'la dirreccion de correo no es valida';
  }

  if (count($errors) == 0) {
    if (emailExiste($email, $con)) {
      $sql = $con->prepare('SELECT usuarios.id, clientes.nombres FROM usuarios
      INNER JOIN clientes ON usuarios.id_cliente=clientes.id 
      WHERE clientes.email LIKE ? LIMIT 1');
      $sql->execute([$email]);
      $row = $sql->fetch(PDO::FETCH_ASSOC);
      $user_id = $row['id'];
      $nombres = $row['nombres'];


      $token = solicitaPassword($user_id, $con);
      if ($token !== null) {
        require_once 'clases/mailer.php';
        $mailer = new Mailer();

        $url = SITE_URL . '/reset_password.php?id=' . $user_id . '&token=' . $token;

        $asunto = 'Recuperar Contraseña - tienda online';
        $cuerpo = "Estimado $nombres: <br>Si has solicitado el cambio de tu contraseña da click en el 
      siguiente link <a href='$url'> $url</a>";
        $cuerpo .= "<br> Si no hiciste esta solicitud puedes ignorar este email.";

        if ($mailer->enviarEmail($email, $asunto, $cuerpo)) {

          $message = "<p><b> Correo enviado.</b></p>  <p>Hemos enviado un correo electronico a la direccion $email para reestablecer la contraseña.</p>";

        }
      }
    } else {
      $errors[] = "No existe una cuenta asociada a este direccion de correo.";
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
.first-section {
    margin-top: 80px; 
}
  </style>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>
  <?php include 'menu.php'; ?>
  <section class="first-section">
  <main class="form-login m-auto pt-4">
    <h3>Recuperar contraseña</h3>

    <?php

    if (!empty($message)) {

      echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
    }
    mostarMensajes($errors);
    ?>


    <form action="recupera.php" method="post" class="row g-3" autocomplete="off">

      <div class="form-floating">
        <input class="form-control" type="email" name="email" id="email" placeholder="Correo electronico" require_once>
        <label for="email"> Email</label>

      </div>

      <div class="d-grid gap-3 col-12">
        <button type="submit" class="btn btn-primary"> Continuar</button>

      </div>
      <hr>
      <div class="col-12">
        ¿No tienes cuenta? <a href="registro.php"> Registratre aqui</a>

      </div>



    </form>
  </main>
  </section>



</body>

</html>