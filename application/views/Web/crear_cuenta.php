<?php
define('RECAPTCHA_V3_SECRET_KEY', '6LcqpNEkAAAAAFtLG8JdThOOnX3TMYzNevP85HJF');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $res = verifyReCaptchaV3();

    if($res['success']){
        //clean character
        $iCelular = trim($_POST["iCelular"]);
        $iCelular = filter_var($iCelular);
        $iCelular = strtoupper($iCelular);

        $sEmail = trim($_POST["sEmail"]);
        $sEmail = filter_var($sEmail);
        $sEmail = filter_var($sEmail, FILTER_SANITIZE_EMAIL);// Remove all illegal characters from email
        $regex = '/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/';// regular expression for email check

        if ( strlen($iCelular) < 9 && is_numeric($iCelular) && $iCelular != 'CELULAR' && $iCelular != 'CELULARES' ) {
            echo json_encode(array(
                'type'=>'danger',
                'message'=>'Debes ingresar un número válido.'
            ));
            exit();
        } else if ( !filter_var($sEmail, FILTER_VALIDATE_EMAIL) && preg_match($regex, $sEmail) && strtoupper($sEmail) != 'CORREO' && strtoupper($sEmail) != 'EMAIL') {
            echo json_encode(array(
                'type'=>'danger',
                'message'=>'Debes ingresar un email válido.'
            ));
            exit();
        } else {// Validate e-mail    
            //CREAR TIENDA por API de librerias.laesystems
            //$arrParamsFE['ruta'] = "http://localhost/librerias.laesystems.com/ApiController/new_user_client_lae";//localhost
            $arrParamsFE['ruta'] = 'https://laesystems.com/librerias/ApiController/new_user_client_lae';//cloud
            $arrParamsFE['token'] = 'mrrN2CoLA3hidRyds5Yi6lJjz7Fep0R03PzurEif';

            $sPassword = trim($_POST["sPassword"]);
            $sPassword = filter_var($sPassword);

            $arrPost = array(
                'Nu_Tipo_Proveedor_FE' => 3,//para tiendaris colocamos -> 3=INTERNO
                'ID_Tipo_Documento_Identidad' => 1,//para tiendaris colocamos -> 1=OTROS (2=DNI 4=RUC y 1=OTROS)
                'Nu_Documento_Identidad' => rand(123456,654321),//tiene que ser así porque el sistema valida numero de documento de identidad
                'Nu_Celular' => $iCelular,
                'Txt_Email' => $sEmail,
                'No_Nombres_Apellidos' => '-',//para tiendaris colocamos -> -
                'Nu_Lae_Gestion' => 0,//LaeGestion
                'Nu_Lae_Shop' => 1,//LaeShop
                'Nu_Tipo_Plan_Lae_Gestion' => 0,//para tiendaris colocamos -> 0=Ninguno
                'ID_Tipo_Rubro_Empresa' => 16,//para tiendaris colocamos -> 16=General
                'No_Password' => $sPassword,//Nuevo campo agregado
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
            curl_close($ch);

            $respuesta = json_decode($respuesta);
            if($respuesta->status == 'success') {
                $sBody = "Acceso del sistema:" . "\n";
                $sBody .= "Usuario: " . $sEmail . "\n";
                $sBody .= "Contraseña: " . $sPassword . "\n\n";
                $sBody .= "Aquí podrás modificar datos de tu tienda como nombre, logo y más." . "\n";
                $sBody .= "*Enlace a tu sistema administrativo:* " . "\n";
                $sBody .= "https://laesystems.com/principal" . "\n\n";
                $sBody .= "*Enlace a tu tienda virtual:*" . "\n";
                $sBody .= "https://" . $respuesta->subdominio_tienda_virtual . "\n";
                $arrDominio = explode('.', $respuesta->subdominio_tienda_virtual);
                $sBody .= "Se creo un nombre temporal de tu tienda *" . $arrDominio[0] . "*.\nModíficalo en el sistema administrativo." . "\n";
                //$sBody .= "Esta información también te llegará al correo." . "\n";

                //Guardar data de cliente en laesystems - posible cliente
                //$arrParamsFE['ruta'] = "http://localhost/librerias.laesystems.com/WebInformativa/client_lae";//localhost
                $arrParamsFE['ruta'] = 'https://laesystems.com/librerias/WebInformativa/client_lae';//cloud

                $sNota = '';
                $sNota .= 'Dominio: tiendaris.com';
                $sNota .= '<br>' . 'Formulario: Crea tu tienda';

                $arrPost = array(
                    'iTipoEntidad' => 0,//Cliente
                    'sNombresApellidos' => $sEmail,
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
                $respuesta2 = curl_exec($ch);
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE );	
                curl_close($ch);

                echo json_encode(array('type' => 'success', 'message' => '¡Bienvenido a *Tiendaris*!' . "\n\n" . $sBody, 'respone' => $respuesta, 'respone2' => $respuesta2));
                exit;
                //FIN Guardar data de cliente en laesystems - posible cliente
            } else {
                echo json_encode(array('type' => 'warning', 'message' => $respuesta->message, 'result' => $respuesta));
                exit;
            }
        }// Validate e-mail
    } else {
        echo json_encode(array(
            'type'=>'danger',
            'message'=>'Error 2'
        ));
        exit();
    }
} else {
    echo json_encode(array(
        'type'=>'danger',
        'message'=>'Error'
    ));
    exit();
}// validate only method POST

function verifyReCaptchaV3(){
    $site_verify_url = "https://www.google.com/recaptcha/api/siteverify";
    
    $data = [
        'secret' => constant('RECAPTCHA_V3_SECRET_KEY'),
        'response' => $_POST['g-recaptcha-response'],
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];
    
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    
    $context  = stream_context_create($options);
    
    $response = file_get_contents($site_verify_url, false, $context);
    
    $res = json_decode($response, true);
    
    return $res;
}