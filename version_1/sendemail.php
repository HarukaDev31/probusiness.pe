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
    //$mail->SMTPDebug = 4;
    $mail->SMTPSecure = 'ssl';
    $mail->Host       = 'mail.lae.one';
    
    $mail->Username   = 'noreply@lae.one';
    $mail->Password   = 'Noreply$%&07081993%_dgHGMD3';
    $mail->Port       = 465;
    $mail->Timeout    = 8;

    $mail->CharSet = 'UTF-8';

    //Recipients
    $mail->setFrom('noreply@lae.one', 'Curso de Importación');
    $mail->addAddress($arrPost['email'], $arrPost['firstname']);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Material del Curso - Proyecto Importador';
    
    $sBody = "Listo🙌🏻 " . $arrPost['firstname'] . " para poder acceder a nuestra Aula Virtual 👨🏼‍🏫 le comparto su Usuario y Contraseña para que pueda ingresar: 👇🏼📚" . "<br><br>";
    $sBody .= "✅Usuario: " . $arrPost['username'] . "<br>";
    $sBody .= "✅Contraseña: " . $arrPost['password'] . "<br>";
    $sBody .= "💻Link de Nuestra plataforma: https://aulavirtualprobusiness.com/login/index.php" . "<br><br>";
    $sBody .= "📁Descargar material de curso en el siguiente link: https://probusiness.pe/descargar_material_curso";

    $mail->Body = $sBody;
    
    //$mail->AddAttachment('material/Probusiness_Material_Curso_Importacion.rar', 'Probusiness_Material_Curso_Importacion.rar');

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