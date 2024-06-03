<?php
class CursoModel extends CI_Model{
	public function __construct(){
		parent::__construct();
    }
  
    public function crearUsuario($arrPost){
        //array_debug($arrPost);

        /*
            [email] => ceo.laesystems@gmail.com
            [codigo_pais] => 51
            [celular] => 915914064
            [dni] => 48354216
            [name] => geancarlos collazos
            [edad] => 30
            [radioSexo] => 1
            [cbo-pais] => 1
            [cbo-departamento] => 0
            [cbo-provincia] => 0
            [cbo-distrito] => 0
        */

		$this->db->trans_begin();

        //crear cliente si no existe
        $sNombreEntidad = trim($arrPost['name']);
        $sNumeroDocumentoIdentidad = trim($arrPost['dni']);
        
        /*
        if ( strlen($sNumeroDocumentoIdentidad) == 8 ) {
            $iTipoDocumentoIdentidad = '2';//2=DNI
            $sTipoDocumentoIdentidad = 'RUC';
        } else if ( strlen($sNumeroDocumentoIdentidad) == 11 ) {
            $iTipoDocumentoIdentidad = '4';//4=RUC
            $sTipoDocumentoIdentidad = 'RUC';
        } else if ( strlen($sNumeroDocumentoIdentidad) >= 9 && strlen($sNumeroDocumentoIdentidad) <= 12 ) {
            $iTipoDocumentoIdentidad = '3';//3=CARNET EXTRANJERIA
            $sTipoDocumentoIdentidad = 'CARNET EXTRANJERIA';
        } else {
            $iTipoDocumentoIdentidad = '1';//1=OTROS
            $sTipoDocumentoIdentidad = 'OTROS';
        }
        */

        $query = "SELECT ID_Entidad FROM entidad WHERE ID_Empresa = 1 AND Nu_Tipo_Entidad = 0 AND Txt_Email_Entidad = '" . $arrPost['email'] . "' LIMIT 1";
        $objVerificarCliente = $this->db->query($query)->row();
        if (is_object($objVerificarCliente)){
            $ID_Entidad = $objVerificarCliente->ID_Entidad;
        } else {
            $arrCliente = array(
                'ID_Empresa' => 1,
                'ID_Organizacion' => 1,
                'Nu_Tipo_Entidad' => 0,//0=Cliente
                //'ID_Tipo_Documento_Identidad' => $iTipoDocumentoIdentidad,
                'ID_Tipo_Documento_Identidad' => $arrPost['cbo-tipo_documento_identidad'],
                'Nu_Documento_Identidad' => $sNumeroDocumentoIdentidad,
                'No_Entidad' => $sNombreEntidad,
                'Nu_Estado' => 1,
                'Nu_Codigo_Pais' => $arrPost['codigo_pais'],
                'Nu_Celular_Entidad' => $arrPost['celular_v2'],
                'Txt_Email_Entidad'	=> $arrPost['email'],
                'Nu_Edad' => $arrPost['edad'],
                'Nu_Tipo_Sexo' => $arrPost['radioSexo'],
                'ID_Pais' => $arrPost['cbo-pais'],
                'ID_Departamento' => $arrPost['cbo-departamento'],
                'ID_Provincia' => $arrPost['cbo-provincia'],
                'ID_Distrito' => $arrPost['cbo-distrito'],
                'Nu_Curso' => 1,
                'Fe_Nacimiento' => ToDate($arrPost['date']),
                'Nu_Como_Entero_Empresa' => $arrPost['radioRedSocial'],
                'No_Otros_Como_Entero_Empresa' => $arrPost['otros_red_social'],
            );

            $this->db->insert('entidad', $arrCliente);
            $ID_Entidad = $this->db->insert_id();
        }
        //caso contrario ubicar id

        $email = strtolower($arrPost['email']);
        $arrUsername = explode("@", $email);
        $username = $arrUsername[0];
        $password = strtoupper(substr($username,0,1)) . substr($username,1,strlen($username)) . date('Y') . date('m') . '$Pb';
        if (is_numeric($username)) {
          $password_v2 = $arrUsername[1];
          $password = strtoupper(substr($password_v2,0,1)) . substr($password_v2,1,strlen($password_v2)) . date('Y') . date('m') . '$Pb';
        }

        $query = "SELECT ID_Usuario FROM usuario WHERE ID_Empresa = 1 AND No_Usuario = '" . $email . "' LIMIT 1";
        $objVerificarUsuario = $this->db->query($query)->row();
        if (is_object($objVerificarUsuario)){
            $ID_Usuario = $objVerificarUsuario->ID_Usuario;
        } else {
            //crear usuario
            $usuario = array(
                'ID_Empresa'            => 1,
                'ID_Organizacion'       => 1,
                'ID_Grupo'				=> 1205,
                'No_Usuario'			=> $email,
                'No_Nombres_Apellidos'	=> $arrPost['name'],
                'No_Password'			=> $this->encryption->encrypt($password),
                'Txt_Email'				=> $email,
                'No_IP'					=> $this->input->ip_address(),
                'Nu_Estado'				=> 1,
                'ID_Entidad'			=> $ID_Entidad,
                'Nu_Celular'            => $arrPost['celular_v2'],
            );

            $this->db->insert('usuario', $usuario);
            $ID_Usuario = $this->db->insert_id();

            //crear usuario
            $grupo_usuario = array(
                'ID_Empresa'            => 1,
                'ID_Organizacion'       => 1,
                'ID_Grupo'				=> 1205,
                'ID_Usuario'			=> $ID_Usuario,
            );

            $this->db->insert('grupo_usuario', $grupo_usuario);
        }

        //insert venta
        $pedido_curso = array(
            'ID_Empresa'                => 1,
            'ID_Organizacion'           => 1,
            'Nu_Estado'                 => 1,
            'Nu_Estado_Usuario_Externo' => 1,
            'Ss_Total' => 159,
            'ID_Pais' => $arrPost['cbo-pais'],
            'ID_Entidad' => $ID_Entidad,
            'Fe_Emision' => dateNow('fecha'),
            'ID_Moneda' => 1,
            'ID_Medio_Pago' => 2,//tarjeta de crédito
        );

        $this->db->insert('pedido_curso', $pedido_curso);
        $ID_Pedido_Curso = $this->db->insert_id();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return array(
				'status' => 'error',
				'message' => '¡Oops! Algo salió mal. Inténtalo mas tarde detalle usuario'
			);
		} else {
			$this->db->trans_commit();
			return array(
				'status' => 'success',
				'message' => 'Usuario registrado, valida tu pago',
                'result' => array(
                    'id' => $ID_Pedido_Curso,
                    'email' => $email,
                    'password' => $password,
                    'name' => $arrPost['name']
                )
			);
		}
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

    public function actualizarPedido($where, $data){
        if ( $this->db->update('pedido_curso', $data, $where) > 0 )
            return array('status' => 'success', 'message' => 'Registro modificado');
        return array('status' => 'error', 'message' => 'Error al modificar');
    }
}