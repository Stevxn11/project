<?php

require_once 'config/config.php';
require_once 'config/database.php';
require_once 'clases/clienteFunciones.php'; // Agregar esta línea
$db = new Database();
$con = $db->conectar();

$proceso = isset($_GET['pago']) ? 'pago' : 'login';

$errors = [];

if (!empty($_POST)) {
  $usuario = trim($_POST['usuario']);
  $password = trim($_POST['password']);
  $proceso = $_POST['proceso'] ?? 'login';

  if (esNulo([$usuario, $password])) {
    $errors[] = 'Debe llenar todos los campos';
  }

  if (count($errors) == 0) {
    $errors[] = login($usuario, $password, $con, $proceso); // Ahora la función login() debería estar disponible
  }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Arkatech

  </title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="css/estilos.css">

</head>

<body>
  <style>
    .first-section {
      margin-top: 80px;
    
    }
  </style>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <?php include 'menu.php'; ?>
  <section class="first-section">

    <main class="form-login m-auto pt-4 ">
      <h2>Iniciar Sesion</h2>

      <?php mostarMensajes($errors); ?>

      <form action="login.php" method="post" autocomplete="off" class="row g-3">

        <input type="hidden" name="proceso" value="<?php echo $proceso; ?>">

        <div class="form-floating">
          <input class="form-control" type="text" name="usuario" id="usuario" placeholder="usuario" require_once>
          <label for="usuario"> Usuario</label>

        </div>

        <div class="form-floating">
          <input class="form-control" type="password" name="password" id="password" placeholder="usuario" require_once>
          <label for="password"> Contraseña</label>
        </div>

        <div class="col-12">
          <a href="recupera.php">¿Olvidaste tu contraseña?</a>
        </div>

        <div class="d-grid gap-3 col-12">
          <button type="submit" class="btn btn-primary">Ingresar</button>

        </div>


        <hr>
        <div class="col-12">
          ¿No tienes cuenta? <a href="registro.php"> Registratre aqui</a>
        </div>

        <div class="d-grid gap-3 col-12">
          <a href="http://localhost/tienda_online/admin/" class="btn btn-info"> Panel de administracion</a>

        </div>


      </form>

    </main>
  </section>


</body>

</html>