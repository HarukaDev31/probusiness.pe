<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImportacionGrupal extends CI_Controller {
    function __construct(){
		parent::__construct();
		$this->load->database('default');
		$this->load->model('InicioModel');
		
		$this->load->library('session');
		$this->load->library('encryption');
		$this->load->model('ImportacionGrupalModel');
	}
    public function getTrendProducts(){
        $data = $this->ImportacionGrupalModel->getTrendProducts();
        echo json_encode($data);
    }
}