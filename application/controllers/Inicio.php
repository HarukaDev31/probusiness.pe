<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inicio extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default');
        $this->load->model('InicioModel');

        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->model('CursoModel');
    }

    public function index()
    {
        $this->load->view('Web/header');
        $iNumeroWhatsApp = '51992583703'; //stephany
        $sMessageWhatsApp = 'Hola+ProBusiness+deseo+m%C3%A1s+informaci%C3%B3n'; //stephany
        $this->load->view('Web/layout/menu', array(
            'iNumeroWhatsApp' => $iNumeroWhatsApp,
        ));
        $this->load->view('Web/Inicio', array(
            'iNumeroWhatsApp' => $iNumeroWhatsApp,
        ));
    }

    public function politicas()
    {
        $this->load->view('Web/header');
        $iNumeroWhatsApp = '51992583703'; //stephany
        $this->load->view('Web/layout/menu', array(
            'iNumeroWhatsApp' => $iNumeroWhatsApp,
        ));
        $this->load->view('Web/politicas');
    }

    public function terminos()
    {
        $this->load->view('Web/header');
        $iNumeroWhatsApp = '51992583703'; //stephany
        $this->load->view('Web/layout/menu', array(
            'iNumeroWhatsApp' => $iNumeroWhatsApp,
        ));
        $this->load->view('Web/politicas');
    }

    public function nosotros()
    {
        $this->load->view('Web/header');
        $iNumeroWhatsApp = '51992583703'; //stephany
        $this->load->view('Web/layout/menu', array(
            'iNumeroWhatsApp' => $iNumeroWhatsApp,
        ));
        $this->load->view('Web/aboutus');
    }

    public function agente_compra()
    {
        $this->load->view('Web/header');
        $iNumeroWhatsApp = '51992583703'; //agente_compra
        $this->load->view('Web/layout/menu', array(
            'iNumeroWhatsApp' => $iNumeroWhatsApp,
        ));
        $this->load->view('Web/agente_compra', array(
            'iNumeroWhatsApp' => $iNumeroWhatsApp,
        ));
    }

    public function carga_consolidada()
    {
        $this->load->view('Web/header');
        $iNumeroWhatsApp = '51992583703'; //alexis carga consolidad
        $this->load->view('Web/layout/menu', array(
            'iNumeroWhatsApp' => $iNumeroWhatsApp,
        ));
        $this->load->view('Web/carga_consolidada', array(
            'iNumeroWhatsApp' => $iNumeroWhatsApp,
        ));
    }

    public function importacion_grupal()
    {
        $this->load->view('Web/header');
        $iNumeroWhatsApp = '51992583703'; //alexis carga consolidad
        $this->load->view('Web/layout/menu', array(
            'iNumeroWhatsApp' => $iNumeroWhatsApp,
        ));
        $this->load->view('Web/importacion_grupal', array(
            'iNumeroWhatsApp' => $iNumeroWhatsApp,
        ));
    }

    public function curso_v2()
    {
        $this->load->view('Web/header', array(
            'iCssFileCurso' => true,
        ));
        $iNumeroWhatsApp = '51992583703'; //alexis carga consolidad
        $this->load->view('Web/layout/menu', array(
            'iNumeroWhatsApp' => $iNumeroWhatsApp,
        ));
        $this->load->view('Web/curso_v2', array(
            'iNumeroWhatsApp' => $iNumeroWhatsApp,
        ));
    }

    public function curso()
    {
        $arrPais = $this->CursoModel->getPais();

        //unset($_SESSION['departamento']);
        //unset($_SESSION['provincia']);
        //unset($_SESSION['distrito']);

        //get Departamento
        if (!isset($_SESSION['departamento'])) {
            $_SESSION['departamento'] = $this->CursoModel->getDepartamento();
        }

        //get provincia
        if (!isset($_SESSION['provincia'])) {
            $_SESSION['provincia'] = $this->CursoModel->getProvincia();
        }
        //get distrito
        if (!isset($_SESSION['distrito'])) {
            $_SESSION['distrito'] = $this->CursoModel->getDistrito();
        }

        //update izipay variables

        /* Username, password and endpoint used for server to server web-service calls */
        //(En el Back Office) Copiar Usuario
        Lyra\Client::setDefaultUsername("81411861");

        //(En el Back Office) Copiar Contraseña de test
        //Lyra\Client::setDefaultPassword("testpassword_cC71d22bmbbkpXlhKVzxy3BVG1FZm7Z4ILlTKL3lZDB4o");
        //(En el Back Office) Copiar Contraseña de produccion
        Lyra\Client::setDefaultPassword("prodpassword_xcB3HEJ7QapGAuFV1h8lpQawobshT9TcLjxE88DSvmXpm");

        //(En el Back Office) Copiar Contraseña de Nombre del servidor API REST
        Lyra\Client::setDefaultEndpoint("https://api.micuentaweb.pe");

        /* publicKey and used by the javascript client */
        //(En el Back Office) Copiar Clave pública de test
        //Lyra\Client::setDefaultPublicKey("78655451:testpublickey_07vuSHY0ErsDxStV4VSfZfiPrIKXMg4ZAM7WWzYSqYUoL");
        //(En el Back Office) Copiar Clave pública de produccion
        Lyra\Client::setDefaultPublicKey("81411861:publickey_QAAACVPh5FTZELHq9ERBxPdOnnDOyKHA3BxfCSCnYTe9s");

        /* SHA256 key */
        //(En el Back Office) Clave HMAC-SHA-256 de test
        //Lyra\Client::setDefaultSHA256Key("G6pEoysq3vLZBpOYSfY7ZInsXS2o6OHodOd40Q8BjhnDU");
        //(En el Back Office) Clave HMAC-SHA-256 de produccion
        Lyra\Client::setDefaultSHA256Key("LAG3JHyRVzI1mQeWW4xx5syC0Lh7fL7k78snNsx9CmsR6");

        $client = new Lyra\Client();

        $store = array(
            "amount" => 200* 100,
            //"amount" => 109 * 100,
            "currency" => "PEN",
            "orderId" => uniqid("id"),
        );
        $response = $client->post("V4/Charge/CreatePayment", $store);

        $store = array(
            "amount" => 300 * 100,
            "currency" => "PEN",
            "orderIdv2" => uniqid("id") . '2',
        );
        $responsev2 = $client->post("V4/Charge/CreatePayment", $store);

        $store = array(
            "amount" => 385 * 100,
            "currency" => "PEN",
            "orderIdv3" => uniqid("id") . '3',
        );
        $responsev3 = $client->post("V4/Charge/CreatePayment", $store);

        /* I check if there are some errors */
        if ($response['status'] != 'SUCCESS') {
            /* an error occurs, I throw an exception */
            //display_error($response);
            $error = $response['answer'];
            //throw new Exception("error " . $error['errorCode'] . ": " . $error['errorMessage'] );
            $response_izipay = array(
                'status' => 'error',
                'message' => $error['errorMessage'],
                'code_error' => $error['errorCode'],
            );
            echo json_encode($response_izipay);
            exit();
        }

        /* everything is fine, I extract the formToken */
        $formToken = $response["answer"]["formToken"];
        $formTokenv2 = $responsev2["answer"]["formToken"];
        $formTokenv3 = $responsev3["answer"]["formToken"];
        /* fin izipay */

        $this->load->view('Web/header', array(
            'iPagarIzipay' => 1,
            'client' => $client,
        ));
        $iNumeroWhatsApp = '51992583703'; //stephany
        $sMessageWhatsApp = 'Hola+ProBusiness+deseo+m%C3%A1s+informaci%C3%B3n+sobre+el+curso+de+importaciones'; //stephany
        $this->load->view('Web/layout/menu', array(
            'iNumeroWhatsApp' => $iNumeroWhatsApp,
            'sMessageWhatsApp' => $sMessageWhatsApp,
        ));

        $this->load->view('Web/curso_membresia', array(
            'iNumeroWhatsApp' => $iNumeroWhatsApp,
            'sMessageWhatsApp' => $sMessageWhatsApp,
            'arrPais' => $arrPais,
            'formToken' => $formToken,
            'formTokenv2' => $formTokenv2,
            'formTokenv3' => $formTokenv3,
        ));
    }

    public function viaje_negocios()
    {
        $this->load->view('Web/header');
        $iNumeroWhatsApp = '51992583703'; //stephany

        $arrPais = $this->InicioModel->getPais();
        $this->load->view('Web/layout/menu', array(
            'iNumeroWhatsApp' => $iNumeroWhatsApp,
        ));
        $this->load->view('Web/agente_viajes', array(
            'iNumeroWhatsApp' => $iNumeroWhatsApp,
            'arrPais' => $arrPais,
        ));
    }

    public function sendwhatsapp()
    {
        //array_debug($this->input->post());
        //<pre>Array ( [firstname] => ANTONY GEANCARLOS [lastname] => COLLAZOS CHUMBILE [email] => youokperu@gmail.com [celular] => 915914064 [message] => sdgsdgsdg ) </pre>

        $name = $this->input->post('firstname') . ' ' . $this->input->post('lastname');
        $email = $this->input->post('email');
        $celular = $this->input->post('celular');

        if (empty($name) && strlen($name) < 3) {
            $response_izipay = array(
                'status' => 'warning',
                'message' => 'Ingresar nombres / apellidos',
            );
            echo json_encode($response_izipay);
            exit();
        }
        if (empty($celular) && strlen($celular) < 9) {
            $response_izipay = array(
                'status' => 'warning',
                'message' => 'Ingresar celular',
            );
            echo json_encode($response_izipay);
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response_izipay = array(
                'status' => 'warning',
                'message' => 'Email inválido',
            );
            echo json_encode($response_izipay);
            exit();
        }

        if (!is_valid_email($email)) {
            $response_izipay = array(
                'status' => 'warning',
                'message' => 'Email inválido',
            );
            echo json_encode($response_izipay);
            exit();
        }

        if (!is_valid_email_expresion_regular($email)) {
            $response_izipay = array(
                'status' => 'warning',
                'message' => 'Email inválido',
            );
            echo json_encode($response_izipay);
            exit();
        }
        $message = '';
        // if(isset($_POST['web_inicio']))
        //     $message = 'Web: Inicio <br> ';
        // if(isset($_POST['web_nosotros']))
        //     $message = 'Web: Nosotros <br> ';
        // if(isset($_POST['web_curso']))
        //     $message = 'Web: Curso <br> ';

        // if(isset($_POST['rubro']) && !empty($_POST['rubro']))
        //     $message .= 'Rubro: ' . $_POST['rubro'] . ' <br> ';

        // if(isset($_POST['perfil_compra']) && !empty($_POST['perfil_compra'])) {
        //     $sPerfilCompra="Minorista";
        //     if($_POST['perfil_compra']==2)
        //         $sPerfilCompra="Mayorista";
        //     else if($_POST['perfil_compra']==3)
        //         $sPerfilCompra="Uso personal";
        //     $message .= 'Perfil de Compra: ' . $sPerfilCompra . ' <br> ';
        // }

        //if(isset($_POST['date']) && !empty($_POST['date']))
        //$message .= 'Fecha de Viaje: ' . $_POST['date'] . ' <br> ';

        $message .= (!empty($this->input->post('message')) ? $this->input->post('message') : '');

        $message_whastapp = 'Deseo información sobre ';
        $NU_AGENTE_COMPRA = 0;
		$NU_CARGA_CONSOLIDADA = 0;
		$NU_IMPORTACION_GRUPAL = 0;
		$WEB_CURSO = 0;
		$NU_VIAJE_NEGOCIOS = 0;
        $message_whastapp = 'Deseo información sobre ';
        if (isset($_POST['Nu_Agente_Compra']) || (isset($_POST['select']) && $_POST['select'] == 'Nu_Agente_Compra')) {
            $message_whastapp .= ' de Agente de Compra';
			$NU_AGENTE_COMPRA = 1;
        }elseif (isset($_POST['Nu_Carga_Consolidada']) || (isset($_POST['select']) && $_POST['select'] == 'Nu_Carga_Consolidada')) {
			$message_whastapp .= ' de Carga Consolidada';
			$NU_CARGA_CONSOLIDADA = 1;
		}elseif (isset($_POST['Nu_Importacion_Grupal']) || (isset($_POST['select']) && $_POST['select'] == 'Nu_Importacion_Grupal')) {
			$message_whastapp .= ' de Importación Grupal';
			$NU_IMPORTACION_GRUPAL = 1;
		}elseif (isset($_POST['web_curso']) || (isset($_POST['select']) && $_POST['select'] == 'web_curso')) {
			$message_whastapp .= ' de Curso';
			$WEB_CURSO = 1;
		}elseif (isset($_POST['Nu_Viaje_Negocios']) || (isset($_POST['select']) && $_POST['select'] == 'Nu_Viaje_Negocios')) {
			$message_whastapp .= ' de Viaje de Negocios';
			$NU_VIAJE_NEGOCIOS = 1;
		}

        // $message .= $this->input->post('message');

        // enviar correo con las credenciales
        $this->load->library('email');

        $data_email["name"] = $name;
        $data_email["celular"] = $celular;
        $data_email["email"] = $email;
        $data_email["message"] = $message;
        $message_email = $this->load->view('Correos/puesto_trabajo', $data_email, true);

        $this->email->from('noreply@lae.one', 'ProBusiness'); //de
        //reemplazar correo de destino de mensajes marketing@probusiness.pe
        $this->email->to('marketing@probusiness.pe'); //para
        //$this->email->to($result->No_Usuario);//para //mvillegas@probusiness.pe
        $this->email->subject($message_whastapp);
        $this->email->message($message_email);
        $this->email->set_newline("\r\n");

        
        $data = array(
            'ID_Empresa' => 1,
            'ID_Organizacion' => 1,
            'Nu_Tipo_Entidad' => 0, //0=Cliente
            'ID_Tipo_Documento_Identidad' => 1, //OTROS
            'Nu_Documento_Identidad' => '',
            'No_Entidad' => $name,
            'Nu_Celular_Entidad' => $celular,
            'Txt_Email_Entidad' => $email,
            'Txt_Descripcion' => nl2br($message),
            'Nu_Estado' => 1,
            'Nu_Agente_Compra' => $NU_AGENTE_COMPRA,
            'Nu_Carga_Consolidada' => $NU_CARGA_CONSOLIDADA,
            'Nu_Importacion_Grupal' => $NU_IMPORTACION_GRUPAL,
            'Nu_Curso' => $WEB_CURSO,
            'Nu_Viaje_Negocios' =>$NU_VIAJE_NEGOCIOS,
        );

        if (isset($_POST['cbo-pais']) && !empty($_POST['cbo-pais'])) {
            $data = array_merge($data, array('ID_Pais' => $_POST['cbo-pais']));
        }

       $this->InicioModel->insertPosibleCliente($data, $message_whastapp);
		$isSend = $this->email->send();
        if ($isSend) {
            $response = array(
                'status' => 'success',
                'message' => 'Mensaje enviado,pronto te contactaremos.',
            );
            echo json_encode($response);
            exit();
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'No se pudo enviar email, inténtelo más tarde.',
                'error_message_mail' => $this->email->print_debugger(),
            );
            echo json_encode($response);
            exit();
        }

    }

    public function sendemail()
    {
        $name = $this->input->post('firstname') . ' ' . $this->input->post('lastname');
        $email = $this->input->post('email');
        $celular = $this->input->post('celular');

        if (empty($name) && strlen($name) < 1) {
            $response_izipay = array(
                'status' => 'warning',
                'message' => 'Ingresar nombres / apellidos',
            );
            echo json_encode($response_izipay);
            exit();
        }

        if (empty($celular) && strlen($celular) < 9) {
            $response_izipay = array(
                'status' => 'warning',
                'message' => 'Ingresar celular',
            );
            echo json_encode($response_izipay);
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response_izipay = array(
                'status' => 'warning',
                'message' => 'Email inválido',
            );
            echo json_encode($response_izipay);
            exit();
        }

        if (!is_valid_email($email)) {
            $response_izipay = array(
                'status' => 'warning',
                'message' => 'Email inválido',
            );
            echo json_encode($response_izipay);
            exit();
        }

        if (!is_valid_email_expresion_regular($email)) {
            $response_izipay = array(
                'status' => 'warning',
                'message' => 'Email inválido',
            );
            echo json_encode($response_izipay);
            exit();
        }

        $message = 'Más información para trabajar en ProBusiness <br>';
        $message .= $this->input->post('message');

        // enviar correo con las credenciales
        $this->load->library('email');

        $data_email["name"] = $name;
        $data_email["celular"] = $celular;
        $data_email["email"] = $email;
        $data_email["message"] = $message;
        $message_email = $this->load->view('Correos/puesto_trabajo', $data_email, true);

        $this->email->from('noreply@lae.one', 'ProBusiness'); //de
        $this->email->to('marketing@probusiness.pe'); //para
        //$this->email->to($result->No_Usuario);//para //mvillegas@probusiness.pe
        $this->email->subject($name . ' se postuló para trabajar en ProBusiness');
        $this->email->message($message_email);
        $this->email->set_newline("\r\n");

        $isSend = $this->email->send();
        if ($isSend) {
            $response = array(
                'status' => 'success',
                'message' => 'Se envío email',
            );
            echo json_encode($response);
            exit();
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'No se pudo enviar email, inténtelo más tarde.',
                'error_message_mail' => $this->email->print_debugger(),
            );
            echo json_encode($response);
            exit();
        }
    }
}
