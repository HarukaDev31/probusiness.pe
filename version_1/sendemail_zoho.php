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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

$arrPost = $_POST;

try {
    $mail->isSMTP();
    $mail->IsHTML(true);
    
    //Server settings
    $mail->Host       = 'smtp.zoho.com';
    $mail->SMTPAuth   = true;
    $mail->SMTPDebug = 4;
    $mail->Username   = 'gcollazos@youok.pe';
    $mail->Password   = 'Youok$%&2023';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    $mail->CharSet = 'UTF-8';

    //Recipients
    $mail->setFrom('gcollazos@youok.pe', 'Curso de Importación');
    $mail->addAddress('ceo.lae.systems@gmail.com', 'gean');
    
    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Material del Curso - Proyecto Importador';
    
    $sBody = "Hola";

    $mail->Body = $sBody;

    if($mail->send()){
        echo json_encode(array('status' => 'success', 'message' => 'Correo enviado satisfactoriamente'));
        exit;
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'No se pudo enviar correo. Mailer Error: ' . $mail->ErrorInfo));
        exit;
    }
} catch (Exception $e) {
    echo json_encode(array('status' => 'error', 'message' => 'No se pudo enviar correo. Mailer Error: (2)' . $mail->ErrorInfo));
    exit;
}