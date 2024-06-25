<?php


require_once '../config/database.php';
require_once '../config/config.php';


if (!isset($_SESSION['user_type'])) {
    header('Location: ../index.php');
    exit;
}

if ($_SESSION['user_type'] != 'admin') {
    header('Location: ../../index.php');
    exit;
}

$db = new Database();
$con = $db->conectar();


$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$descuento = $_POST['descuento'];
$stock = $_POST['stock'];
$categoria = $_POST['categoria'];

$sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, descuento=?, stock=?, id_categoria=? WHERE id=?";

$stm = $con->prepare($sql);
if ($stm->execute([$nombre, $descripcion, $precio, $descuento, $stock, $categoria, $id])) {


    if ($_FILES['imagen_principal']['error'] == UPLOAD_ERR_OK) {
        $dir = '../../imagenes/productos/' . $id . '/';
        $permitidos = ['jpeg', 'jpg'];

        $extension = strtolower(pathinfo($_FILES['imagen_principal']['name'], PATHINFO_EXTENSION));

        if (in_array($extension, $permitidos)) {
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $ruta_img = $dir . 'principal.' . $extension;
            if (move_uploaded_file($_FILES['imagen_principal']['tmp_name'], $ruta_img)) {
                echo "El archivo se cargo correctamente";
            } else {
                echo "Error al cargar el archivo. <br>";
            }
        } else {
            echo "Archivo no permitido.<br>";
        }
    } else {
        echo "No enviaste archivo.<br>";
    }

    // imagenes otras
    if (isset($_FILES['otras_imagenes'])) {
        $dir = '../../imagenes/productos/' . $id . '/';
        $permitidos = ['jpeg', 'jpg'];
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $contador = 1;
        if (is_array($_FILES['otras_imagenes']['tmp_name'])) {
            foreach ($_FILES['otras_imagenes']['tmp_name'] as $key => $tmp_name) {

                $fileName = $_FILES['otras_imagenes']['name'][$key];

                $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $nuevoNombre = $dir . uniqid() . '.' . $extension;
                if (in_array($extension, $permitidos)) {
                    if (move_uploaded_file($tmp_name, $nuevoNombre)) {
                        echo "El archivo se cargo correctamente.<br>";
                    } else {
                        echo "Error al cargar el archivo.<br>";
                    }
                } else {
                    echo "Archivo no permitido. <br> ";
                }
            }
        }
    }

    $idVariante = $_POST["id_variante"] ?? [];
    $almacen = $_POST['almacenamiento'] ?? [];
    $color = $_POST['color'] ?? [];
    $precioVariante = $_POST['precio_variante'] ?? [];
    $stockVariante = $_POST['stock_variante'] ?? [];

    $gb = count($almacen);

    if($gb == count($color) && $gb == count($precioVariante) && $gb == count($stockVariante)) 
    {
        $sql = 'INSERT INTO productos_variantes (id_producto, id_almacenamiento, id_color, precio, stock)
        VALUES (?,?,?,?,?)';
        $stm = $con->prepare($sql);

        $sqlUpdate = 'UPDATE productos_variantes SET  id_almacenamiento=?, id_color=?, precio=?, stock=? WHERE
        id=?';
        $stmUpdate = $con->prepare($sqlUpdate);


        for($i= 0; $i < $gb; $i++){
            $idAlma = (int)$almacen[$i];
            $idcolor =(int) $color[$i];
            $stock = $stockVariante[$i];
            $precio = $precioVariante[$i];

            if(isset($idVariante[$i])){
                $stmUpdate->execute([$idAlma, $idcolor, $precio, $stock, $idVariante[$i]]);
            }else{
                $stm->execute([$id, $idAlma, $idcolor, $precio, $stock]);
            }

            
        }

    }
}

header('Location: index.php');
