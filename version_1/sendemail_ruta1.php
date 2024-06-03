<?php

//developer
/*
error_reporting(-1);
ini_set('display_errors', 1);
*/

//production

ini_set('display_errors', 0);
if (version_compare(PHP_VERSION, '5.3', '>='))
{
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
}
else
{
  error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
}


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
    $mail->SMTPAuth   = true;
    $mail->SMTPDebug = 4;
    $mail->SMTPSecure = 'ssl';
    $mail->Host       = 'mail.lae.one';
    
    $mail->Username   = 'noreply@lae.one';
    $mail->Password   = 'Noreply$%&07081993%_dgHGMD3';
    $mail->Port       = 465;
    $mail->Timeout    = 8;

    $mail->CharSet = 'UTF-8';

    //Recipients
    $mail->setFrom('noreply@lae.one', 'Curso de Importación');
    $mail->addAddress('ceo.lae.systems@gmail.com', 'gean');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Ruta 1 - Proyecto Importador';
    $mail->Body = 'Bienvenido';
    
    $mail->AddAttachment('curso_importador_ruta_1/ruta_1.pdf', 'ruta_1.pdf');

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