<?php

require_once 'config/config.php';
require_once 'config/database.php';
$db = new Database();
$con = $db->conectar();

$id_transaccion = isset($_GET['key']) ? $_GET['key'] : '0';

$error = '';
if ($id_transaccion == '') {
    $error = 'error al procesar la peticion';
} else {
    
    $sql = $con->prepare("SELECT count(id) FROM compra WHERE id_transaccion	=? AND status=?");
    $sql->execute([$id_transaccion, 'COMPLETED']);
    if ($sql->fetchColumn() > 0) {
        $sql = $con->prepare("SELECT id, fecha, email, total FROM compra WHERE id_transaccion=? AND status=? LIMIT 1");
        $sql->execute([$id_transaccion, 'COMPLETED']);
        
        if ($sql->rowCount() > 0) {
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            
            $idCompra = $row['id'];
            $total = $row['total'];
            $fecha = $row['fecha'];
            
            $sqlDet = $con->prepare("SELECT nombre, precio, cantidad FROM detalle_compra WHERE id_compra = ?");
            $sqlDet->execute([$idCompra]);
        } else {
            $error = 'La compra no existe';
        }
    } else {
        $error = 'Error al comprobar la compra';
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
        
        <?php include 'menu.php';?>

    <main class="main-content">

        <div class="container">
            <?php if (strlen($error) > 0) { ?>
                <div class="row">
                    <div class="col">
                        <h1> <?php echo $error; ?></h1>
                    </div>
                </div>

            <?php } else { ?>
                <div class="row">
                    <div class="col">

                        <b>Folio de compra: </b><?php echo $id_transaccion ?><br>
                        <b>Fecha de compra: </b><?php echo $fecha ?><br>
                        <b>Total: </b><?php echo MONEDA . number_format($total, 2, '.', ',') ?><br>
                    </div>
                </div>

                <div class="row">
                    <div class="col">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Producto</th>
                                    <th>Importe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row_det = $sqlDet->fetch(PDO::FETCH_ASSOC)) {
                                    $importe = $row_det['precio'] * $row_det['cantidad'] ?>
                                    <tr>
                                        <td> <?php echo $row_det['cantidad'] ?></td>
                                        <td> <?php echo $row_det['nombre'] ?></td>
                                        <td> <?php echo $importe ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>


                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
</body>

</html>