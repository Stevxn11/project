<?php


require_once '../config/config.php';
require_once '../config/database.php';
$db = new Database();
$con = $db->conectar();

$json = file_get_contents('php://input');
$datos = json_decode($json, true);


if (is_array($datos)) {
    $id_cliente = $_SESSION['user_cliente'];
    $sqlprod = $con->prepare("SELECT email FROM clientes WHERE id=? AND estatus=1");
    $sqlprod->execute([$id_cliente]);
    $row_cliente = $sqlprod->fetch(PDO::FETCH_ASSOC);


    $id_transaccion = $datos['detalles']['id'];
    $total = $datos['detalles']['purchase_units']['0']['amount']['value'];
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('y-m-d h:i:s', strtotime($fecha));
    //$email = $datos['detalles']['payer']['email_address'];
    $email = $row_cliente['email'];
    //$id_cliente = $datos['detalles']['payer']['payer_id'];


    $sql = $con->prepare("INSERT INTO compra (id_transaccion, fecha, status, email, id_cliente, total) VALUES(?,?,?,?,?,?)");
    $sql->execute([$id_transaccion, $fecha_nueva, $status, $email, $id_cliente, $total]);
    $id = $con->lastInsertId();

    if ($id > 0) {
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;


        if ($productos != null) {
            foreach ($productos as $clave => $cantidad) {

                $sql = $con->prepare("SELECT id, nombre, precio, descuento FROM productos WHERE id=? AND activo=1");
                $sql->execute([$clave]);
                $row_prod = $sql->fetch(PDO::FETCH_ASSOC);

                $precio = $row_prod['precio'];
                $descuemto = $row_prod['descuento'];
                $precio_desc = $precio - (($precio * $descuemto) / 100);

                $sql_insert = $con->prepare("INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad)VALUES(?,?,?,?,?)");
                if($sql_insert->execute([$id, $clave, $row_prod['nombre'], $precio_desc, $cantidad])){
                    restarStock($row_prod['id'], $cantidad, $con);
                }
            }

            require_once 'mailer.php';
            $asunto = "Detalles de su compra";
            $cuerpo = '<h4> gracias por su compra</h4>';
            $cuerpo = '<p> El ID de su compra es <b> ' . $id_transaccion .  ' </b> </p>';


            $mailer = new Mailer();
            $mailer->enviarEmail($email,$asunto,$cuerpo);
        }

        unset($_SESSION['carrito']);
    }
}

function restarStock($id, $cantidad, $con){

    $sql = $con->prepare('UPDATE productos SET stock = stock - ? WHERE id=?');
    $sql->execute([$cantidad, $id]);
}