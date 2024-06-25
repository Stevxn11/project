<?php
require_once 'config/config.php';
require_once 'config/database.php';


$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$db = new Database();
$con = $db->conectar();

$lista_carrito = array();

if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {

        $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
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

</head>

<body>

<style>
    .main-content {
    padding-top: 80px; 
}
  </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <?php include 'menu.php'; ?>
    <main class="main-content">

        <div class="container">

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Productos</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($lista_carrito == null) {
                            echo '<tr> <td colspan="5" class="text-center"> <b> Lista vacia</b></td></tr>';
                        } else {
                            $total = 0;
                            foreach ($lista_carrito as $productos) {
                                $_id = $productos['id'];
                                $nombre = $productos['nombre'];
                                $precio = $productos['precio'];
                                $descuemto = $productos['descuento'];
                                $cantidad = $productos['cantidad'];
                                $precio_desc = $precio - (($precio * $descuemto) / 100);
                                $subtotal = $cantidad * $precio_desc;
                                $total += $subtotal;
                        ?>


                                <tr>
                                    <td> <?php echo $nombre ?></td>
                                    <td> <?php echo MONEDA . number_format($precio_desc, 2, '.', '.'); ?></td>
                                    <td> <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad ?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizaCantidad(this.value, <?php echo $_id ?>)">

                                    </td>
                                    <td>
                                        <div id="subtotal_<?php echo $_id ?>" name="subtotal[]">
                                            <?php echo MONEDA . number_format($subtotal, 2, '.', '.'); ?> USD </div>
                                    </td>

                                    <td>
                                        <a id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal" data-bs-target="#elimaModal">Eliminar</a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="3">
                                    <p class="h3" id="total"> <?php echo MONEDA . number_format($total, 2, '.', '.'); ?> USD </p>
                                </td>
                            </tr>

                    </tbody>
                <?php } ?>

                </table>

            </div>
            <?php if ($lista_carrito != null) { ?>
                <div class="row">
                    <div class="col-md-5 offset-md-7 d-grid gap-2">
                        <?php if (isset($_SESSION['user_cliente'])) { ?>
                            <a href="pago.php" class="btn btn-primary btn-lg">Realizar Pago</a>

                        <?php } else { ?>
                            <a href="login.php?pago" class="btn btn-primary btn-lg">Realizar Pago</a>
                        <?php } ?>

                    </div>

                </div>
            <?php } ?>


        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="elimaModal" tabindex="-1" aria-labelledby="elimaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Desea eliminar el producto de la lista?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        let elimaModal = document.getElementById('elimaModal')
        elimaModal.addEventListener('show.bs.modal', function(event) {

            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let buttonElimina = elimaModal.querySelector('.modal-footer #btn-elimina')
            buttonElimina.value = id
        })


        function actualizaCantidad(cantidad, id) {
            let url = 'clases/actualizar_carrito.php'
            let formData = new FormData()
            formData.append('action', 'agregar')
            formData.append('id', id)
            formData.append('cantidad', cantidad)

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        let divsubtotal = document.getElementById('subtotal_' + id)
                        divsubtotal.innerHTML = data.sub

                        let total = 0.00;
                        let list = document.getElementsByName('subtotal[]')

                        for (let i = 0; i < list.length; i++) {
                            total += parseFloat(list[i].innerHTML.replace(/[<?php echo MONEDA ?>,]/g, ''))
                        }
                        total = new Intl.NumberFormat('en-US', {
                            minimumFractionDigits: 2
                        }).format(total)
                        document.getElementById('total').innerHTML = '<?php echo MONEDA ?>' + total
                    } else {
                        let inputCantidad = document.getElementById('cantidad_' + id);
                        inputCantidad.value = data.cantidadAnterior;
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


        function eliminar() {
            let botonElimina = document.getElementById('btn-elimina')
            let id = botonElimina.value

            let url = 'clases/actualizar_carrito.php'
            let formData = new FormData()
            formData.append('action', 'eliminar')
            formData.append('id', id)

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        location.reload()
                    }
                })
        }
    </script>

</body>

</html>