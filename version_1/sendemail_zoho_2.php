<?php
//developer
error_reporting(-1);
ini_set('display_errors', 1);

//production
/*
ini_set('display_errors', 0);
if (version_compare(PHP_VERSION, '5.3', '>='))
{
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
}
else
{
  error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
}
*/

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.zoho.com';
    $mail->SMTPAuth   = true;
    $mail->SMTPDebug = 4;
    $mail->Username   = 'administracion.aura@aurasac.com';
    $mail->Password   = 'Correo$%&07081993';
    //$mail->SMTPSecure = 'ssl';
    //$mail->Port       = 465;
$mail->SMTPSecure = "tls";
$mail->Port = 587;

    $mail->CharSet = 'UTF-8';
    //Recipients
    $mail->setFrom('administracion.aura@aurasac.com', 'Formulario Web');
    $mail->addAddress('ceo.lae.systems@gmail.com');               //Name is optional

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'hola';
    $mail->Body    = 'ggga';

    if($mail->send()){
        echo json_encode(array('status' => 'success', 'message' => 'Correo enviado satisfactoriamente'));
        exit;
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'No se pudo enviar correo. Mailer Error: ' . $mail->ErrorInfo));
        exit;
    }
} catch (Exception $e) {
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}