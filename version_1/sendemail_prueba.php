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
    
    $url_path = 'correo/material_curso.php'; 
  
    // Data is an array of key value pairs 
    // to be reflected on the site 
    $data = array('Name' => 'John', 'Age' => '24'); 
    
    // Method specified whether to GET or 
    // POST data with the content specified 
    // by $data variable. 'http' is used 
    // even in case of 'https' 

    $options = array( 
    'http' => array( 
    'method' => 'POST', 
    'content' => http_build_query($data)) 
    ); 

    // Create a context stream with 
    // the specified options 
    $stream = stream_context_create($options); 

    // The data is stored in the  
    // result variable 
    $sBody = file_get_contents( $url_path, false, $stream); 

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