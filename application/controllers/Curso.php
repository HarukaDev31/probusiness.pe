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
		Lyra\Client::setDefaultUsername("81411861");
		
		//(En el Back Office) Copiar Contraseña de test
		//Lyra\Client::setDefaultPassword("testpassword_cC71d22bmbbkpXlhKVzxy3BVG1FZm7Z4ILlTKL3lZDB4o");
		//(En el Back Office) Copiar Contraseña de producción
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
			"amount" => 1 * 100,
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

		$this->load->config('integraciones', true);
		$post = $this->input->post();
		$montos = $this->_obtenerMontosPlanesCurso();
		$tp = isset($post['plan_tipo_pago']) ? (int) $post['plan_tipo_pago'] : 1;
		if ($tp < 1) {
			$tp = 1;
		}
		$ssTotal = isset($montos[$tp]) ? (int) $montos[$tp] : 159;
		if (isset($post['plan_price_amount']) && (int) $post['plan_price_amount'] > 0) {
			$clientAmt = (int) $post['plan_price_amount'];
			if ($clientAmt !== $ssTotal) {
				log_message('notice', 'Curso::crearUsuario plan_price_amount cliente=' . $clientAmt . ' servidor=' . $ssTotal . ' tipo_pago=' . $tp);
			}
		}
		$post['Ss_Total_plan'] = $ssTotal;

		echo json_encode($this->CursoModel->crearUsuario($post));
		exit();
	}

	/**
	 * Mismos montos que Izipay (API pública planes + fallback integraciones).
	 *
	 * @return array [tipo_pago => monto_pen, ...]
	 */
	private function _obtenerMontosPlanesCurso()
	{
		$fallback = $this->config->item('curso_izipay_pen_montos_fallback', 'integraciones');
		if (!is_array($fallback)) {
			$fallback = array(1 => 200, 2 => 300, 3 => 385);
		}

		$apiUrl = $this->config->item('api_curso_membresia_planes_url', 'integraciones');
		if (empty($apiUrl)) {
			return $fallback;
		}

		$ctx = stream_context_create(array(
			'http' => array(
				'method' => 'GET',
				'header' => "Accept: application/json\r\n",
				'timeout' => 5,
				'ignore_errors' => true,
			),
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
			),
		));

		$json = @file_get_contents($apiUrl, false, $ctx);
		if ($json === false) {
			log_message('error', 'Curso::_obtenerMontosPlanesCurso - No se pudo conectar a ' . $apiUrl);
			return $fallback;
		}

		$data = json_decode($json, true);
		if (!is_array($data) || !isset($data['planes']) || !is_array($data['planes'])) {
			log_message('error', 'Curso::_obtenerMontosPlanesCurso - Respuesta inesperada de ' . $apiUrl);
			return $fallback;
		}

		$montos = array();
		foreach ($data['planes'] as $plan) {
			$tp = isset($plan['tipo_pago']) ? (int) $plan['tipo_pago'] : 0;
			$amt = isset($plan['price_amount']) ? (int) $plan['price_amount'] : 0;
			if ($tp > 0 && $amt > 0) {
				$montos[$tp] = $amt;
			}
		}

		foreach ($fallback as $tp => $val) {
			if (!isset($montos[$tp])) {
				$montos[$tp] = $val;
			}
		}

		return $montos;
	}
	
	public function respuestaIzipay(){
		//update izipay shakey here
	
		Lyra\Client::setDefaultSHA256Key("LAG3JHyRVzI1mQeWW4xx5syC0Lh7fL7k78snNsx9CmsR6");
		
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
			$iNumeroWhatsApp = '51992583703';//stephany
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
						$iNumeroWhatsApp = '51992583703';//stephany
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
					  $iNumeroWhatsApp = '51992583703';//stephany
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
				$iNumeroWhatsApp = '51992583703';//stephany
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
				$iNumeroWhatsApp = '51992583703';//stephany
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
		$iNumeroWhatsApp = '51992583703';//stephany
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
