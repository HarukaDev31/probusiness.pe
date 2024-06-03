<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/MoodleRestPro.php');

class Curso extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->database('default');
		$this->load->library('session');
		$this->load->library('encryption');
		$this->load->model('CursoModel');
	}

	public function index(){
		$arrPais = $this->CursoModel->getPais();

		//unset($_SESSION['departamento']);
		//unset($_SESSION['provincia']);
		//unset($_SESSION['distrito']);

		//get Departamento
		if(!isset($_SESSION['departamento'])) {
			$_SESSION['departamento'] = $this->CursoModel->getDepartamento();
		}

		//get provincia
		if(!isset($_SESSION['provincia'])) {
			$_SESSION['provincia'] = $this->CursoModel->getProvincia();
		}
		//get distrito
		if(!isset($_SESSION['distrito'])) {
			$_SESSION['distrito'] = $this->CursoModel->getDistrito();
		}

		/* cargando izipay */
		
		/* Username, password and endpoint used for server to server web-service calls */
		//(En el Back Office) Copiar Usuario
		Lyra\Client::setDefaultUsername("78655451");
		
		//(En el Back Office) Copiar Contraseña de test
		//Lyra\Client::setDefaultPassword("testpassword_cC71d22bmbbkpXlhKVzxy3BVG1FZm7Z4ILlTKL3lZDB4o");
		//(En el Back Office) Copiar Contraseña de producción
		Lyra\Client::setDefaultPassword("prodpassword_sYm6SzBGdM2XIgf3COOOclUcbOTcaYTt3iZlz1WcDdSD7");

		//(En el Back Office) Copiar Contraseña de Nombre del servidor API REST
		Lyra\Client::setDefaultEndpoint("https://api.micuentaweb.pe");

		/* publicKey and used by the javascript client */
		//(En el Back Office) Copiar Clave pública de test
		//Lyra\Client::setDefaultPublicKey("78655451:testpublickey_07vuSHY0ErsDxStV4VSfZfiPrIKXMg4ZAM7WWzYSqYUoL");
		//(En el Back Office) Copiar Clave pública de produccion
		Lyra\Client::setDefaultPublicKey("78655451:publickey_U2z6srU6cQGJPbbJwm6ssrpyiWdE1ZAom4AYgjcXwkUlm");

		/* SHA256 key */
		//(En el Back Office) Clave HMAC-SHA-256 de test
		//Lyra\Client::setDefaultSHA256Key("G6pEoysq3vLZBpOYSfY7ZInsXS2o6OHodOd40Q8BjhnDU");
		//(En el Back Office) Clave HMAC-SHA-256 de produccion
		Lyra\Client::setDefaultSHA256Key("KhHFiouLSgCFB9gsRzafqcwpppQlY6YzzxXwTTLU4mG5S");

		$client = new Lyra\Client();

		$store = array(
			"amount" => 159 * 100,
			//"amount" => 109 * 100,
			"currency" => "PEN",
			"orderId" => uniqid("id"),
		);
		$response = $client->post("V4/Charge/CreatePayment", $store);

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
		/* fin izipay */

		$this->load->view('Curso/Registro',
			array(
				'arrPais' => $arrPais,
				'client' => $client,
				'formToken' => $formToken
			)
		);
	}

	function searchForIdDepartamento() {
		$id = $this->input->post('ID_Pais');
		if(isset($_SESSION['departamento']) && $_SESSION['departamento']['status']=='success') {
			$arrDepartamento = array();
			foreach ($_SESSION['departamento']['result'] as $row) {
				if ($row->ID_Pais == $id) {
					$arrDepartamento[] = [
						'ID_Departamento' => $row->ID_Departamento,
						'No_Departamento' => $row->No_Departamento,
					];
				}
			}

            echo json_encode(array(
                'status' => 'success',
                'message' => 'Si hay registros',
                'result' => $arrDepartamento
            ));
			exit();
		} else {
            echo json_encode(array(
                'status' => 'warning',
                'message' => 'No hay registros'
            ));
			exit();
		}
	}

	function searchForIdProvincia() {
		$id = $this->input->post('ID_Departamento');
		if(isset($_SESSION['provincia']) && $_SESSION['provincia']['status']=='success') {
			$arrProvincia = array();
			foreach ($_SESSION['provincia']['result'] as $row) {
				if ($row->ID_Departamento == $id) {
					$arrProvincia[] = [
						'ID_Provincia' => $row->ID_Provincia,
						'No_Provincia' => $row->No_Provincia,
					];
				}
			}

            echo json_encode(array(
                'status' => 'success',
                'message' => 'Si hay registros',
                'result' => $arrProvincia
            ));
			exit();
		} else {
            echo json_encode(array(
                'status' => 'warning',
                'message' => 'No hay registros'
            ));
			exit();
		}
	}

	function searchForIdDistrito() {
		$id = $this->input->post('ID_Provincia');
		if(isset($_SESSION['distrito']) && $_SESSION['distrito']['status']=='success') {
			$arrResult = array();
			foreach ($_SESSION['distrito']['result'] as $row) {
				if ($row->ID_Provincia == $id) {
					$arrResult[] = [
						'ID_Distrito' => $row->ID_Distrito,
						'No_Distrito' => $row->No_Distrito
					];
				}
			}

            echo json_encode(array(
                'status' => 'success',
                'message' => 'Si hay registros',
                'result' => $arrResult
            ));
			exit();
		} else {
            echo json_encode(array(
                'status' => 'warning',
                'message' => 'No hay registros'
            ));
			exit();
		}
	}
	
	public function crearUsuario(){
		$email_cliente = $this->input->post('email');
		if (!filter_var($email_cliente, FILTER_VALIDATE_EMAIL)) {
			$response_izipay = array(
				'status' => 'warning',
				'message' => 'Correo inválido',
			);
			echo json_encode($response_izipay);
			exit();
		}

		if (!is_valid_email($email_cliente)) {
			$response_izipay = array(
				'status' => 'warning',
				'message' => 'Correo inválido',
			);
			echo json_encode($response_izipay);
			exit();
		}

		if (!is_valid_email_expresion_regular($email_cliente)) {
			$response_izipay = array(
				'status' => 'warning',
				'message' => 'Correo inválido',
			);
			echo json_encode($response_izipay);
			exit();
		}

		echo json_encode($this->CursoModel->crearUsuario($this->input->post()));
		exit();
	}
	
	public function respuestaIzipay(){
		//test
		//Lyra\Client::setDefaultSHA256Key("G6pEoysq3vLZBpOYSfY7ZInsXS2o6OHodOd40Q8BjhnDU");
		//produccion
		Lyra\Client::setDefaultSHA256Key("KhHFiouLSgCFB9gsRzafqcwpppQlY6YzzxXwTTLU4mG5S");
		
		$client = new Lyra\Client();

		if (!$client->checkHash()) {
			//actualizar pedido
			$id_pedido_curso = $this->input->post('acme-id');
			$where = array('ID_Pedido_Curso' => $id_pedido_curso);
			$data_upd = array('Nu_Estado' => '4');//4=rechazado
			$this->CursoModel->actualizarPedido($where, $data_upd);

			$response_izipay = array(
				'status' => 'error',
				'message' => 'invalid signature'
			);
			$this->load->view('Web/header');
			$iNumeroWhatsApp = '51953314683';//stephany
			$sMessageWhatsApp = 'Hola+ProBusiness+compre+el+curso';//stephany
			$this->load->view('Web/layout/menu', array(
				'iNumeroWhatsApp' => $iNumeroWhatsApp
			));
			$this->load->view('Web/GraciasIzipay',
				array(
					'response_izipay' => $response_izipay
				)
			);
			return true;
		}

		$rawAnswer = $client->getParsedFormAnswer();

		$formAnswer = $rawAnswer['kr-answer'];

		$transaction = $formAnswer['transactions'][0];
		
		$result['orderStatus'] = $formAnswer['orderStatus'];
		$result['orderId'] = $formAnswer['orderDetails']['orderId'];
		$result['orderTotalAmount'] = round($formAnswer['orderDetails']['orderTotalAmount'] / 100);
		$result['transactionUuid'] = $transaction['uuid'];

		if( $result['orderStatus']=='PAID' ){
			//actualizar pedido
			$id_pedido_curso = $this->input->post('acme-id');
			$where = array('ID_Pedido_Curso' => $id_pedido_curso);
			$data_upd = array(
				'Nu_Estado' => '2',
				'ID_Referencia_Pago_Online' => $result['orderId'],
				'Ss_Total' => $result['orderTotalAmount']
			);
			$this->CursoModel->actualizarPedido($where, $data_upd);

			//crear usuario y cursos para moodle
			$MoodleRestPro = new MoodleRestPro();
			$arrPost = array(
				'username' => $this->input->post('acme-email'),
				'password' => $this->input->post('acme-password'),
				'firstname' => $this->input->post('acme-name'),
				'email' => $this->input->post('acme-email')
			);
			$response_usuario_moodle = $MoodleRestPro->createUser($arrPost);

			if($response_usuario_moodle['status']=='success'){
				// Property added to the object
				$arrParams['criteria'][0]['key']='username';
				$arrParams['criteria'][0]['value']=$this->input->post('acme-email');
				$response_usuario = $MoodleRestPro->getUser($arrParams);
			
				if($response_usuario['status']=='success'){
					$result_usuario = $response_usuario['response'];
				
					$id_usuario = $result_usuario->id;
					$arrParamsCurso = array(
						'id_usuario' => $id_usuario//id_usuario
					);
					$response_curso = $MoodleRestPro->crearCursoUsuario($arrParamsCurso);
					if($response_curso['status']!='success'){
						$where = array('ID_Pedido_Curso' => $id_pedido_curso);
						$data_upd = array(
							'Nu_Estado_Usuario_Externo' => '3',
							'Ss_Total' => $result['orderTotalAmount']
						);//usuario no creado en moodle
						$this->CursoModel->actualizarPedido($where, $data_upd);
						$response_izipay = array(
							'status' => 'success',
							'message' => 'Gracias por tu compra <br> Nro. ' . $id_pedido_curso . ' pero se asigno curso'
						);
						$this->load->view('Web/header');
						$iNumeroWhatsApp = '51953314683';//stephany
						$sMessageWhatsApp = 'Hola+ProBusiness+compre+el+curso';//stephany
						$this->load->view('Web/layout/menu', array(
							'iNumeroWhatsApp' => $iNumeroWhatsApp
						));
						$this->load->view('Web/GraciasIzipay',
							array(
								'response_izipay' => $response_izipay
							)
					  );
					  return true;
					}
				} else {
					$where = array('ID_Pedido_Curso' => $id_pedido_curso);
					$data_upd = array(
						'Nu_Estado_Usuario_Externo' => '3',
						'Ss_Total' => $result['orderTotalAmount']
					);//usuario no creado en moodle
					$this->CursoModel->actualizarPedido($where, $data_upd);
				  	$response_izipay = array(
						'status' => 'success',
						'message' => 'Gracias por tu compra <br> Nro. ' . $id_pedido_curso . ' pero se encontro usuario para curso'
				  	);
					  $this->load->view('Web/header');
					  $iNumeroWhatsApp = '51953314683';//stephany
					  $sMessageWhatsApp = 'Hola+ProBusiness+compre+el+curso';//stephany
					  $this->load->view('Web/layout/menu', array(
						  'iNumeroWhatsApp' => $iNumeroWhatsApp
					  ));
				  	$this->load->view('Web/GraciasIzipay',
						array(
							'response_izipay' => $response_izipay
						)
					);
					return true;
				}
			} else {
				$where = array('ID_Pedido_Curso' => $id_pedido_curso);
				$data_upd = array(
					'Nu_Estado_Usuario_Externo' => '3',
					'Ss_Total' => $result['orderTotalAmount']
				);//usuario no creado en moodle
				$this->CursoModel->actualizarPedido($where, $data_upd);

				$response_izipay = array(
					'status' => 'success',
					'message' => 'Gracias por tu compra <br> Nro. ' . $id_pedido_curso . ' pero no se creo usuario moodle'
				);
				$this->load->view('Web/header');
				$iNumeroWhatsApp = '51953314683';//stephany
				$sMessageWhatsApp = 'Hola+ProBusiness+compre+el+curso';//stephany
				$this->load->view('Web/layout/menu', array(
					'iNumeroWhatsApp' => $iNumeroWhatsApp
				));
				$this->load->view('Web/GraciasIzipay',
					array(
						'response_izipay' => $response_izipay
					)
			  	);
				return true;
			}

			// marcar usuario moodle generado
			$where = array('ID_Pedido_Curso' => $id_pedido_curso);
			$data_upd = array(
				'Nu_Estado_Usuario_Externo' => '2',
				'Ss_Total' => $result['orderTotalAmount']
			);
			$this->CursoModel->actualizarPedido($where, $data_upd);

			// enviar correo con las credenciales
			$this->load->library('email');

			$data_email["email"] = $this->input->post('acme-email');
			$data_email["password"] = $this->input->post('acme-password');
			$data_email["name"] = $this->input->post('acme-name');
			$message_email = $this->load->view('Correos/cuenta_moodle', $data_email, true);
			
			$this->email->from('noreply@lae.one', 'ProBusiness');//de
			$this->email->to($this->input->post('acme-email'));//para
			$this->email->subject('🎉 Bienvenido al curso');
			$this->email->message($message_email);
			$this->email->set_newline("\r\n");

			$isSend = $this->email->send();
			if($isSend) {
			} else {
				$response_izipay = array(
					'status' => 'success',
					'message' => 'Gracias por tu compra <br> Nro. ' . $id_pedido_curso . ' pero no se envio email'
				);
				$this->load->view('Web/header');
				$iNumeroWhatsApp = '51953314683';//stephany
				$sMessageWhatsApp = 'Hola+ProBusiness+compre+el+curso';//stephany
				$this->load->view('Web/layout/menu', array(
					'iNumeroWhatsApp' => $iNumeroWhatsApp
				));
				$this->load->view('Web/GraciasIzipay',
					array(
						'response_izipay' => $response_izipay
					)
			  	);
				return true;
			}

			$response_izipay = array(
				'status' => 'success',
				'message' => 'Gracias por tu compra'
			);
		} else {
			$response_izipay = array(
				'status' => 'error',
				'message' => 'code: ' . $transaction['errorCode'] . 'message: ' . $transaction['errorMessage']
			);

			//actualizar pedido
			$id_pedido_curso = $this->input->post('acme-id');
			$where = array('ID_Pedido_Curso' => $id_pedido_curso);
			$data_upd = array(
				'Nu_Estado' => '4',
				'ID_Referencia_Pago_Online' => $result['orderId'],
				'Ss_Total' => $result['orderTotalAmount']
			);
			$this->CursoModel->actualizarPedido($where, $data_upd);
		}

		$this->load->view('Web/header');
		$iNumeroWhatsApp = '51953314683';//stephany
		$sMessageWhatsApp = 'Hola+ProBusiness+compre+el+curso';//stephany
		$this->load->view('Web/layout/menu', array(
			'iNumeroWhatsApp' => $iNumeroWhatsApp
		));
		$this->load->view('Web/GraciasIzipay',
			array(
				'response_izipay' => $response_izipay
			)
		);
	}
}
