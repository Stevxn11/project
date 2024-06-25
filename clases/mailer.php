<?php
use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

class Mailer{
    function enviarEmail($email, $asunto, $cuerpo)
    {
        require_once __DIR__.'/../config/config.php';
        require_once __DIR__.'/./phpmailer/src/PHPMailer.php';
        require_once __DIR__.'/./phpmailer/src/SMTP.php';
        require_once __DIR__.'/./phpmailer/src/Exception.php';
         
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();                                            
            $mail->Host       = 'smtp.gmail.com';                     
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'stevenruizxx@gmail.com';                     
            $mail->Password   = 'jfvzttaqznuphgzr';                               
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
            $mail->Port       = 465;                                   
 
            //Recipients
            $mail->setFrom('stevenruizxx@gmail.com', 'owen');
            $mail->addAddress($email);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = $cuerpo;
            $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');

            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "Error al enviar el email de la compra: {$mail->ErrorInfo}";
            return false;
        }
    }
}