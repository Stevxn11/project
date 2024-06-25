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


$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$descuento = $_POST['descuento'];
$stock = $_POST['stock'];
$categoria = $_POST['categoria'];

$sql = "INSERT INTO productos (nombre, descripcion, precio, descuento, stock, id_categoria, activo) 
VALUES (?,?,?,?,?,?,1)";
$stm = $con->prepare($sql);
if ($stm->execute([$nombre, $descripcion, $precio, $descuento, $stock, $categoria])) {
    $id = $con->lastInsertId();

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
                echo "Error al cargar el archivo";
            }
        } else {
            echo "Archivo no permitido";
        }
    } else {
        echo "No enviaste archivo";
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
            foreach ($_FILES['otras_imagenes']['tmp_name'] as $key => $tmp_name)  {

            $fileName = $_FILES['otras_imagenes']['name'][$key];

            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($extension, $permitidos)) {
                $ruta_img = $dir . $contador . '.' . $extension;

                if (move_uploaded_file($tmp_name, $ruta_img)) {
                    echo "El archivo se cargo correctamente.<br>";
                    $contador++;
                } else {
                    echo "Error al cargar el archivo";
                }
            } else {
                echo "Archivo no permitido. <br> ";
            }
            
        }
    }
}
}

header('Location: index.php');
