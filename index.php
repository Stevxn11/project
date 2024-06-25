<?php
require_once 'config/config.php';
require_once 'config/database.php';
$db = new Database();
$con = $db->conectar();

$idCategoria = $_GET['cat'] ?? '';
$orden = $_GET['orden'] ?? '';

$orders = [
  'asc' => 'nombre ASC',
  'desc' => 'nombre DESC',
  'precio_alto' => 'precio DESC',
  'precio_bajo' => 'precio ASC',
];
$order = $orders[$orden] ?? '';

if (!empty($order)) {
  $order = " ORDER BY  $order";
}

if (!empty($idCategoria)) {
  $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1 AND id_categoria=?
  $order");
  $sql->execute([$idCategoria]);
} else {

  $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1 $order");
  $sql->execute();
}



$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

$sqlCategorias = $con->prepare('SELECT id, nombre FROM categorias WHERE activo=1');
$sqlCategorias->execute();
$categorias = $sqlCategorias->fetchAll(PDO::FETCH_ASSOC);

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

  <style>
    .main-header-image {
      width: 100%;
      height: 900px;
      object-fit: cover;
    }

    .company-description {
      padding: 2rem 0;
    }
  </style>


</head>

<body class="d-flex flex-column min-vh-100">
  <div class="flex-grow-1">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <?php include 'menu_index.php'; ?>

    <div class="container-fluid p-0">
      <img src="imagenes/img-pri.jpeg" alt="Imagen principal de Arkatech" class="main-header-image">
    </div>

    <div class="container">
      <hr class="my-4">


      <div class="company-description">
        <h2 class="text-center mb-4">Bienvenido a Arkatech</h2>
        <p class="lead text-center">
          Arkatech es tu destino premium para todo lo relacionado con Apple. Somos
          especialistas en ofrecer la última tecnología de Apple, desde iPhones y iPads
          hasta MacBooks y accesorios. Nuestro compromiso es proporcionar productos
          Apple auténticos, respaldados por un servicio al cliente excepcional y
          asesoramiento experto. Ya sea que busques actualizar tu dispositivo o explorar
          el ecosistema Apple por primera vez, en Arkatech encontrarás todo lo que
          necesitas para potenciar tu experiencia digital.
        </p>
      </div>
    </div>

    <hr class="my-4">
    <div class="flex-shrink-0">
      <h2 class="text-center" id="C">Catalogo</h2>
      <div id="catalogo" class="container-fluid px-4">
        <div class="row">
          <div class="col-3 col-md-2 pe-0">
            <div class="card shadow-sm">
              <div class="card-header">
                Categorias
              </div>
              <div class="lis-group">

              <a href="index.php#catalogo" class="list-group-item lis-group-item-action">
  Todo
</a>
                <?php foreach ($categorias as $categoria) { ?>
                  <a href="index.php?cat=<?php echo $categoria['id']; ?>#catalogo" class="list-group-item lis-group-item-action <?php if ($idCategoria == $categoria['id']) echo 'active' ?>">
                    <?php echo $categoria['nombre'] ?>
                  </a>
                <?php } ?>
              </div>
            </div>
          </div>




          <div class="col-12 col-md-9">

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 justify-content-end g-4">
              <div class="col mb-2">
                <form action="index.php" id="ordenForm" method="get">

                  <input type="hidden" name="cat" id="cat" value="<?php echo $idCategoria; ?>">



                  <select name="orden" id="orden" class="form-select form-select-sm" onchange="submitForm()">
                    <option value="">Ordenar por</option>
                    <option value="precio_alto" <?php echo ($orden === 'precio_alto') ? 'selected' : ''; ?>>Precios mas altos</option>
                    <option value="precio_bajo" <?php echo ($orden === 'precio_bajo') ? 'selected' : ''; ?>>Precios mas bajos</option>
                    <option value="asc" <?php echo ($orden === 'asc') ? 'selected' : ''; ?>>Nombre A-Z</option>
                    <option value="desc" <?php echo ($orden === 'desc') ? 'selected' : ''; ?>>Nombre Z-A</option>
                  </select>
                </form>
              </div>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
              <?php foreach ($resultado as $row) { ?>
                <div class="col-lg-4 col-md-6 col-sm-6">
                  <div class="card mb-4 shadow-2-strong m-2">
                    <?php
                    $id = $row['id'];
                    $imagen = "imagenes/productos/$id/principal.jpg";
                    if (!file_exists($imagen)) {
                      $imagen = "imagenes/no-photo.jpg";
                    }
                    ?>
                    <img class="card-img-top" src="<?php echo $imagen . '?id=' . time(); ?>" alt="<?php echo $row['nombre']; ?>">
                    <div class="card-body text-center">
                      <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                      <p class="card-text mb-0">$ <?php echo number_format($row['precio'], 2, ',', '.'); ?></p>
                      <div class="d-flex justify-content-center mt-2">
                        <a href="detalles.php?id=<?php echo $row['id']; ?>&token=<?php echo sha1($row['id']); ?>" class="btn btn-primary  me-2">Detalles</a>
                        <button class="btn btn-outline-success btn-sm" onclick="addProducto(<?php echo $row['id']; ?>, '<?php echo sha1($row['id']); ?>')">Agregar al carrito</button>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    </main>


    <script>
      function addProducto(id, token) {
        let url = 'clases/carrito.php'
        let formData = new FormData()
        formData.append('id', id)
        formData.append('token', token)

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
          }).then(response => response.json())
          .then(data => {
            if (data.ok) {
              let elemento = document.getElementById("num_cart")
              elemento.innerHTML = data.numero

              // Mostrar mensaje de confirmación
              Swal.fire({
                icon: 'success',
                title: '¡Producto agregado!',
                text: 'El producto se ha agregado al carrito de compras.',
                showConfirmButton: false,
                timer: 1500
              });
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

      function submitForm() {
        document.getElementById('ordenForm').submit()
      }

      document.addEventListener('DOMContentLoaded', function() {
    if(window.location.hash) {
      var hash = window.location.hash;
      if(hash === '#catalogo') {
        var element = document.querySelector(hash);
        if(element) {
          element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      }
    }
  });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </div>
  <?php include 'footer.php'; ?>
</body>



</html>