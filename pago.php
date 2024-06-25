<?php
require_once 'config/config.php';
require_once 'config/database.php';
$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();

if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {

        $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);

    }
} else {
    header("Location: index.php");
    exit;
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
        <script src="https://kit.fontawesome.com/3ca10496d2.js" crossorigin="anonymous"></script>

        <?php include 'menu.php';?>

    <main class="main-content">

        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h4>Detalles de pago</h4>
                    <div id="paypal-button-container" ></div>

                </div>

                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Productos</th>
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
                                            <td> <?php echo $productos['nombre']; ?></td>
                                            <td> <?php echo $cantidad.' x '. MONEDA .'<b>' .
                                            number_format($subtotal, 2, '.', '.') . '</b>';?></td>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="3">
                                            <p class="h3 text-end" id="total">
                                                <?php echo MONEDA . number_format($total, 2, '.', '.'); ?> </p>
                                        </td>
                                    </tr>

                            <?php } ?>
                            
                            </tbody>

                        </table>

                    </div>

                </div>
    </main>



    
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID?>&currency=<?php echo CURRENCY ?>">
    </script>

    <script>
    paypal.Buttons({
        style:{
            color: 'blue',
            shape: 'pill',
            label: 'pay'
        },
        createOrder:function(data, actions){
            return actions.order.create({
             purchase_units:[{
                amount: {
                    value: <?php echo $total;?>
                }
             }]
            });
        },
        onApprove:function(data, actions){
            let URL = 'clases/capture.php'
            actions.order.capture().then(function(detalles){
                console.log(detalles)
                let url= 'clases/capture.php'

                return fetch(url,{
                    method: 'post',
                    headers: {
                        'content-type': 'application/json'

                    },
                    body: JSON.stringify({
                        detalles: detalles
                    })
                }).then(function(response){
                window.location.href ="completado.php?key=" + detalles['id'];
            })
            });

        },
        onCancel:function(data){
            alert("pago cancelado")
            console.log(data);
        }

    }).render('#paypal-button-container');
</script>
</body>

</html>