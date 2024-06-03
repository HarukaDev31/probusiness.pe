<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CorreoRutaAerea extends CI_Controller {

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
		
		$this->load->library('email');

		$data = array();
		$data['tipo_correo'] = $this->input->post('tipo_correo');
		$message = $this->load->view('Correos/curso_ruta_1', $data, true);
		
		$this->email->from('noreply@lae.one', 'Ayuda importadora');//de
		//$this->email->to('mvalle@probusiness.pe', 'Hola');//para
		//$this->email->to('ceo.lae.systems@gmail.com');//para
		$this->email->to($this->input->post('email'), $this->input->post('firstname'));//para
		//$this->email->cc('mvalle@probusiness.pe');

		$sSubject = '🔝 Pro Business: Resultado de tu Perfil Importador ✈️';
		if ($this->input->post('tipo_correo')!='aerea')
			$sSubject = '🔝 Pro Business: Resultado de tu Perfil Importador 🚢';

		$this->email->subject($sSubject);

		$this->email->message($message);
		$this->email->set_newline("\r\n");

		if ($this->input->post('tipo_correo')=='aerea')
			$this->email->attach(base_url() . 'assets/curso_importador_ruta_1/probusiness_ruta_aprendizaje_aereo.pdf');
			
		if ($this->input->post('tipo_correo')=='maritima')
			$this->email->attach(base_url() . 'assets/curso_importador_ruta_1/probusiness_ruta_aprendizaje_maritimo_c.c.pdf');
			
		if ($this->input->post('tipo_correo')=='maritima_independiente')
			$this->email->attach(base_url() . 'assets/curso_importador_ruta_1/probusiness_ruta_aprendizaje_maritimo_independiente.pdf');

		$isSend = $this->email->send();
		
		//array_debug($this->email->print_debugger());

		if($isSend) {
			$response = array(
				'status' => 'success',
				'message' => 'Correo enviado',
			);
			echo json_encode($response);
			exit;
		} else {
			$response = array(
				'status' => 'error',
				'message' => 'No se pudo enviar el correo, inténtelo más tarde.',
			);
			echo json_encode($response);
			exit;
		}
	}
}
