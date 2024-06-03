<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
include('PHPMailer/src/PHPMailer.PHP');
include('PHPMailer/src/SMTP.PHP');
include('PHPMailer/src/Exception.PHP');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMailer/vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP

    $mail->Host       = '';
    $mail->SMTPAuth   = true;
    $mail->Username   = '';
    $mail->Password   = '';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    $mail->CharSet = 'UTF-8';
    //Recipients
    $mail->setFrom('', 'Conecta Gas');
    $mail->addAddress('ventas@conectagas.pe');//Name is optional
    
    if(isset($_REQUEST['celular'])){
        '<b>Nombres: </b>'.$_REQUEST['nombre'].'<br><b>Email: </b>'.$_REQUEST['mail'].'<br><b>Celular: </b>'.$_REQUEST['celular'].'<br><b>Servicios: </b>'.$_REQUEST['servicios'].'<br><b>Mensaje: </b>'.$_REQUEST['mensaje'].'<br>';
    }else{
        '<b>Nombres: </b>'.$_REQUEST['nombre'].'<br><b>Email: </b>'.$_REQUEST['mail'].'<br><b>Servicios: </b>'.$_REQUEST['servicios'].'<br><b>Mensaje: </b>'.$_REQUEST['mensaje'].'<br>';
    }
    //Content
    $mail->isHTML(true);//Set email format to HTML
    $mail->Subject = 'Formulario Web';
    $mail->Body    = $body;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Enviado';
} catch (Exception $e) {
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}