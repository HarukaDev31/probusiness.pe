<?php
array_debug($_POST);
/*
//clean character
$sNombresApellidos = trim($_POST["sNombresApellidos"]);
$sNombresApellidos = filter_var($sNombresApellidos);

$iCelular = trim($_POST["iCelular"]);
$iCelular = filter_var($iCelular);
$iCelular = strtoupper($iCelular);

$sEmail = trim($_POST["sEmail"]);
$sEmail = filter_var($sEmail);
$sEmail = filter_var($sEmail, FILTER_SANITIZE_EMAIL);// Remove all illegal characters from email
$regex = '/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/';// regular expression for email check

if ( !preg_match("/^[A-Za-z\\-ñ \']+$/", $sNombresApellidos) && strlen($sNombresApellidos) < 3 && strtoupper($sNombresApellidos) != 'NOMBRES Y APELLIDOS' && strtoupper($sNombresApellidos) != 'NOMBRES' && strtoupper($sNombresApellidos) != 'APELLIDOS' ) {
    echo json_encode(array(
        'type'=>'danger',
        'message'=>'Debes ingresar un nombre válido.'
    ));
    exit();
} else if ( strlen($iCelular) < 9 && is_numeric($iCelular) && $iCelular != 'CELULAR' && $iCelular != 'CELULARES' ) {
    echo json_encode(array(
        'type'=>'danger',
        'message'=>'Debes ingresar un número válido.'
    ));
    exit();
} else if ( !filter_var($sEmail, FILTER_VALIDATE_EMAIL) && !preg_match($regex, $sEmail) && strtoupper($sEmail) != 'CORREO' && strtoupper($sEmail) != 'EMAIL') {
    echo json_encode(array(
        'type'=>'danger',
        'message'=>'Debes ingresar un email válido.'
    ));
    exit();
} else {// Validate e-mail    
    $sBody = "Nombres: " . $sNombresApellidos . "\n";
    $sBody .= "Celular: " . $iCelular . "\n";
    $sBody .= "Correo: " . $sEmail . "\n";

    //Guardar data de cliente en laesystems - posible cliente
    //$arrParamsFE['ruta'] = "http://localhost/librerias.laesystems.com/WebInformativa/client_lae";//localhost
    $arrParamsFE['ruta'] = 'https://laesystems.com/librerias/WebInformativa/client_lae';//cloud
    $arrParamsFE['token'] = '';

    $sNota = '';
    if(isset($_POST['sDominio']))
        $sNota .= 'Dominio: ' . $_POST['sDominio'];
    if(isset($_POST['sTypeService']))
        $sNota .= '<br>' . 'Formulario: ' . $_POST['sTypeService'];

    $arrPost = array(
        'iTipoEntidad' => 0,//Cliente
        'sNombresApellidos' => $sNombresApellidos,
        'iCelular' => $iCelular,
        'sEmail' => $sEmail,
        'sNota' => $sNota,
    );
    $data_json = json_encode($arrPost);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $arrParamsFE['ruta']);
    curl_setopt(
        $ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Token token="'.$arrParamsFE['token'].'"',
        'Content-Type: application/json',
        'X-API-Key: ' . $arrParamsFE['token'],
        )
    );
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $respuesta = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE );	
    curl_close($ch);

    echo json_encode(array('type' => 'success', 'message' => 'Mas informacion de Tiendaris' . "\n\n" . $sBody, 'response' => $respuesta));
    exit;
    //FIN Guardar data de cliente en laesystems - posible cliente
}// Validate e-mail
*/