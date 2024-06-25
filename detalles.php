<?php
require_once 'config/config.php';
require_once 'config/database.php';
$db = new Database();
$con = $db->conectar();
$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
if ($id == '' || $token == '') {
  echo 'Error al procesar la peticion';
  exit;
} else {
  $token_tmp = sha1($id, false);
  if ($token_tmp == $token) {

    $sql = $con->prepare("SELECT COUNT(*) FROM productos WHERE id=? AND activo=1");
    $sql->execute([$id]);
    if ($sql->fetchColumn() > 0) {

      $sql = $con->prepare('SELECT nombre, descripcion, precio, descuento FROM productos WHERE id=? AND activo=1 LIMIT 1');
      $sql->execute([$id]);
      $row = $sql->fetch(PDO::FETCH_ASSOC);
      $nombre = $row['nombre'];
      $precio = $row['precio'];
      $descripcion = $row['descripcion'];
      $descuemto = $row['descuento'];
      $precio_desc = $precio - (($precio * $descuemto) / 100);
      $dir_imagenes = 'imagenes/productos/' . $id . '/';
      $rutaImg = $dir_imagenes . 'principal.jpg';

      if (!file_exists($rutaImg)) {
        $rutaImg = 'imagenes/no-photo.jpg';
      }

      $images = array();
      if (file_exists($dir_imagenes)) {


        $dir = dir($dir_imagenes);

        while (($archivo = $dir->read()) != false) {
          if ($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))) {
            $images[] = $dir_imagenes . $archivo;
          }
        }
        $dir->close();
      }

      $sqlAlma = $con->prepare("SELECT DISTINCT al.id, al.nombre FROM productos_variantes AS pv 
      INNER JOIN c_almacenamiento as al ON pv.id_almacenamiento = al.id 
      WHERE pv.id_producto =?");
      $sqlAlma->execute([$id]);
      $alma = $sqlAlma->fetchAll(PDO::FETCH_ASSOC);

      $sqlColores = $con->prepare("SELECT DISTINCT c.id, c.nombre FROM productos_variantes AS pv 
      INNER JOIN c_colores as c ON pv.id_color = c.id 
      WHERE pv.id_producto =?");
      $sqlColores->execute([$id]);
      $colores = $sqlColores->fetchAll(PDO::FETCH_ASSOC);
    }
  } else {
    echo 'Error al procesar la peticion';
    exit;
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Arkatech</title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="css/estilos.css">
  <script src="https://kit.fontawesome.com/3ca10496d2.js" crossorigin="anonymous"></script>

</head>

<body>
  <style>
    .main-content {
    padding-top: 80px; 
}
  </style>


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <?php
  include 'menu.php';
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


  <main class="main-content">

    <div class="container">
      <div class="row">
        <div class="col-md-6 order-md-1">


          <div id="carouseImagenes" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">

                <img src="<?php echo $rutaImg . '?id=' . time(); ?>" class="d-block w-100">
              </div>

              <?php foreach ($images as $img) { ?>
                <div class="carousel-item">
                  <img class="d-block w-100" src="<?php echo $img . '?id=' . time(); ?>">

                </div>
              <?php } ?>

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouseImagenes" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouseImagenes" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>

        </div>
        <div class="col-md-6 order-md-2">
          <h2> <?php echo $nombre ?></h2>
          <?php if ($descuemto > 0) { ?>
            <p> <del><?php echo number_format($row['precio'], 2, ',', '.'); ?> </del></p>
            <h2> <?php echo MONEDA . number_format($precio_desc, 2, ',', '.'); ?>
              <small class="text-success"> <?php echo $descuemto; ?> % descuento</small>
            </h2>


          <?php } else { ?>

            <h2> $ <?php echo number_format($row['precio'], 2, ',', '.'); ?> </h2>
          <?php } ?>

          <p class="lead"><?php echo $descripcion ?></p>

          <div class="row g-2">
            <?php if ($alma) { ?>
              <div class="col-3 my-3">
                <label for="alma" class="form-label">Almacenamiento:</label>
                <select class="form-select form-select-lg" name="alma" id="alma" onchange="cargarColores()">
                  <?php foreach ($alma as $almas) { ?>
                    <option value="<?php echo $almas['id'] ?>"><?php echo $almas['nombre'] ?></option>
                  <?php } ?>
                </select>

              </div>
            <?php } ?>

            <?php if ($colores) { ?>
              <div class="col-3 my-3" id="div-colores">
                <label for="colores" class="form-label">Colores:</label>
                <select class="form-select form-select-lg" name="colores" id="colores">
                  <?php foreach ($colores as $color) { ?>
                    <option value="<?php echo $color['id'] ?>"><?php echo $color['nombre'] ?></option>
                  <?php } ?>
                </select>
              </div>
            <?php } ?>
          </div>

          <div class="col-3 my-3">
            Cantidad: <input class="form-control" id="cantidad" name="cantidad" type="number" min="1" max="10" value="1">
          </div>


          <div class="col-3 my-3">
            <input class="form-control" id="nuevo_precio">
          </div>


          <div class="d-grid gap-3 col-10 mx-auto">

            <button class="btn btn-primary" type="button" onclick="comprarAhora(<?php echo $id; ?>, cantidad.value)"> Comprar ahora</button>
            <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $id; ?>, cantidad.value , 
            '<?php echo $token_tmp; ?>')"> Agregar al
              carrito</button>
          </div>

        </div>
      </div>
    </div>
  </main>

  <script>
    function addProducto(id, cantidad, token) {
      var url = 'clases/carrito.php'
      var formData = new FormData()
      formData.append('id', id)
      formData.append('cantidad', cantidad)
      formData.append('token', token)

      fetch(url, {
          method: 'post',
          body: formData,
          mode: 'cors'
        }).then(response => response.json())
        .then(data => {
          if (data.ok) {
            let elemento = document.getElementById("num_cart")
            elemento.innerHTML = data.numero
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'No hay suficientes existencias.',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Aceptar'
            });
          }
        })
    }

    const cbxAlmacena = document.getElementById('alma')
    cargarColores()

    const cbxColores = document.getElementById('colores')
    cbxColores.addEventListener('change', cargarVariante, false)

    function cargarColores() {

      let idAlma = 0;

      if (document.getElementById('alma')) {
        idAlma = document.getElementById('alma').value
      }


      const cbxColores = document.getElementById('colores')
      const divColores = document.getElementById('div-colores')

      var url = 'clases/productosAjax.php'
      var formData = new FormData()
      formData.append('id_producto', '<?php echo $id; ?>');
      formData.append('id_almacenamiento', idAlma);
      formData.append('action', 'buscarColoresPorAlma');

      fetch(url, {
          method: 'POST',
          body: formData,
          mode: 'cors'
        }).then(response => response.json())
        .then(data => {
          if (data.colores != '') {
            divColores.style.display = 'block';
            cbxColores.innerHTML = data.colores;
          } else {
            divColores.style.display = 'none';
            cbxColores.innerHTML = '';
            cbxColores.value = 0;
          }
          cargarVariante()
        })

    }


    function cargarVariante() {



      let idAlma = 0;

      if (document.getElementById('alma')) {
        idAlma = document.getElementById('alma').value
      }

      let idColor = 0;
      if (document.getElementById('colores')) {
        idColor = document.getElementById('colores').value
      }



      var url = 'clases/productosAjax.php'
      var formData = new FormData()
      formData.append('id_producto', '<?php echo $id; ?>');

      if (idAlma !== 0 && idAlma !== '') {
        formData.append('id_almacenamiento', idAlma);
      }

      if (idColor !== 0 && idColor !== '') {
        formData.append('id_color', idColor);
      }
      formData.append('action', 'buscaIdVariante');

      fetch(url, {
          method: 'POST',
          body: formData,
          mode: 'cors'
        }).then(response => response.json())
        .then(data => {
          if (data.variante != '') {
            document.getElementById('nuevo_precio').value = data.variante.precio
          } else {
            document.getElementById('nuevo_precio').value = 'No encontro.'
          }
        })
    }


    function comprarAhora(id, cantidad) {
      var url = 'clases/carrito.php';
      var formData = new FormData();
      formData.append('id', id);
      formData.append('cantidad', cantidad);


      fetch(url, {
          method: 'POST',
          body: formData,
          mode: 'cors',
        }).then(response => response.json())
        .then(data => {
          if (data.ok) {
            let elemento = document.getElementById("num_cart")
            elemento.innerHTML = data.numero;
            location.href = 'checkout.php';
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'No hay suficientes existencias.',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Aceptar'
            });
          }
        })
    }
  </script>

</body>

</html>