<?php
class CursoModel extends CI_Model{
	public function __construct(){
		parent::__construct();
    }
      
    public function getPais(){
        //aqui falta que me envíen ID caso contrario no pueden ingresar aquí
        $query = "SELECT * FROM pais WHERE Nu_Estado=1";

        if ( !$this->db->simple_query($query) ){
            $error = $this->db->error();
            return array(
                'status' => 'danger',
                'message' => 'Problemas al obtener datos',
                'code_sql' => $error['code'],
                'message_sql' => $error['message']
            );
        }
        $arrResponseSQL = $this->db->query($query);
        if ( $arrResponseSQL->num_rows() > 0 ){
            return array(
                'status' => 'success',
                'message' => 'Si hay registros',
                'result' => $arrResponseSQL->result()
            );
        }
        
        return array(
            'status' => 'warning',
            'message' => 'No hay registros'
        );
    }

    public function getDepartamento(){
        //aqui falta que me envíen ID caso contrario no pueden ingresar aquí
        $query = "SELECT * FROM departamento WHERE Nu_Estado=1 ORDER BY No_Departamento";

        if ( !$this->db->simple_query($query) ){
            $error = $this->db->error();
            return array(
                'status' => 'danger',
                'message' => 'Problemas al obtener datos',
                'code_sql' => $error['code'],
                'message_sql' => $error['message']
            );
        }
        $arrResponseSQL = $this->db->query($query);
        if ( $arrResponseSQL->num_rows() > 0 ){
            return array(
                'status' => 'success',
                'message' => 'Si hay registros',
                'result' => $arrResponseSQL->result()
            );
        }
        
        return array(
            'status' => 'warning',
            'message' => 'No hay registros'
        );
    }
  
    public function getProvincia(){
        //aqui falta que me envíen ID caso contrario no pueden ingresar aquí
        $query = "SELECT * FROM provincia WHERE Nu_Estado=1 ORDER BY No_Provincia";

        if ( !$this->db->simple_query($query) ){
            $error = $this->db->error();
            return array(
                'status' => 'danger',
                'message' => 'Problemas al obtener datos',
                'code_sql' => $error['code'],
                'message_sql' => $error['message']
            );
        }
        $arrResponseSQL = $this->db->query($query);
        if ( $arrResponseSQL->num_rows() > 0 ){
            return array(
                'status' => 'success',
                'message' => 'Si hay registros',
                'result' => $arrResponseSQL->result()
            );
        }
        
        return array(
            'status' => 'warning',
            'message' => 'No hay registros'
        );
    }
  
    public function getDistrito(){
        //aqui falta que me envíen ID caso contrario no pueden ingresar aquí
        $query = "SELECT * FROM distrito WHERE Nu_Estado=1 ORDER BY No_Distrito";

        if ( !$this->db->simple_query($query) ){
            $error = $this->db->error();
            return array(
                'status' => 'danger',
                'message' => 'Problemas al obtener datos',
                'code_sql' => $error['code'],
                'message_sql' => $error['message']
            );
        }
        $arrResponseSQL = $this->db->query($query);
        if ( $arrResponseSQL->num_rows() > 0 ){
            return array(
                'status' => 'success',
                'message' => 'Si hay registros',
                'result' => $arrResponseSQL->result()
            );
        }
        
        return array(
            'status' => 'warning',
            'message' => 'No hay registros'
        );
    }
}