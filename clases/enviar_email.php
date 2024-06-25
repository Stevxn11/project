<?php
use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

require_once 'phpmailer/src/PHPMailer.php';
require_once 'phpmailer/src/SMTP.php';
require_once 'phpmailer/src/Exception.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'stevenruizxx@gmail.com';                     
    $mail->Password   = 'jfvzttaqznuphgzr';                               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    $mail->Port       = 465;                                   

    //Recipients
    $mail->setFrom('stevenruizxx@gmail.com', 'owen');
    $mail->addAddress('granadosdilam1@gmail.com', 'Arka');     //Add a recipient
                  //Name is optional


   

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Detalles de su compra';
    $cuerpo = '<h4> gracias por su compra</h4>';
    $cuerpo = '<p> El ID de su compra es <b> ' . $id_transaccion .  ' </b> </p>';

    $mail->Body    = $cuerpo;
    $mail->AltBody = 'Le enviamos los detalles de su compra.';

    $mail-> setLanguage('es','../phpmailer/language/phpmailer.lang-es.php');

    $mail->send();
   
} catch (Exception $e) {
    echo "Error al enviar el email de la compra: {$mail->ErrorInfo}";
    
}