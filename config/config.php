<?php 
$path= dirname(__FILE__);

require_once $path.'/database.php';
require_once $path.'/../admin/clases/cifrado.php';

$db=new Database();
$con= $db->conectar();
 
$sql = "SELECT nombre, valor FROM configuracion";
$result = $con->query($sql);
$datos = $result->fetchAll(PDO::FETCH_ASSOC);  

$config= [];
foreach ($datos as $dato ) {
    $config[$dato["nombre"]] = $dato["valor"];
}


define("CLIENT_ID", "Aah2VBK8RCqKy-e4C1SSo5SB8dQI_WDxaJ_FIkHsS0dVxRrxtCqQFHFgSCZN0meNu8d2GHbxYgtbTLZ_");
define("CURRENCY","USD");
define("SITE_URL","http://localhost/tienda_online");
define("KEY_TOKEN", "APR.wqc-354");
define("MONEDA", "$");

define("MAIL_HOST", $config['correo_smtp']);
define("MAIL_USER", $config['correo_email']);
define("MAIL_PASS", $config['correo_password']);
define("MAIL_PORT", $config['correo_puerto']);


session_name('arkatech_sesion');
session_start();

$num_cart=0;
if(isset( $_SESSION ['carrito']['productos'])){
    $num_cart= count( $_SESSION ['carrito']['productos']);
}