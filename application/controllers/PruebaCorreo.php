<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PruebaCorreo extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		echo "entro";

		$this->load->library('email');

		$data = array();
		$message = $this->load->view('Correos/curso_ruta_1', $data, true);
		
		$this->email->from('noreply@lae.one', 'ProBusiness');//de
		//$this->email->from('cursodeimpo@gmail.com', 'Laesystems');//de
		$this->email->to('ceo.lae.systems@gmail.com');//para
		$this->email->subject('Ruta de aprendizaje aéreo');

		$this->email->message($message);
		$this->email->set_newline("\r\n");

		$this->email->attach(base_url() . 'assets/curso_importador_ruta_1/ruta_1.pdf');

		$isSend = $this->email->send();
		
		array_debug($this->email->print_debugger());

		if($isSend) {
			$peticion = array(
				'status' => 'success',
				'type' => 'user',
				'message' => 'Correo enviado. Si no se encuentra en tu bandeja de entrada, revisar en correo no deseado o spam, luego confirmar como seguro.',
			);
		} else {
			$peticion = array(
				'status' => 'error',
				'type' => 'user',
				'message' => 'No se pudo enviar el correo, inténtelo más tarde.',
			);
		}
	}
}
