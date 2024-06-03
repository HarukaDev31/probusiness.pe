<?php
class InicioModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPais()
    {
        //aqui falta que me envíen ID caso contrario no pueden ingresar aquí
        $query = "SELECT * FROM pais WHERE Nu_Estado=1";

        if (!$this->db->simple_query($query)) {
            $error = $this->db->error();
            return array(
                'status' => 'danger',
                'message' => 'Problemas al obtener datos',
                'code_sql' => $error['code'],
                'message_sql' => $error['message'],
            );
        }
        $arrResponseSQL = $this->db->query($query);
        if ($arrResponseSQL->num_rows() > 0) {
            return array(
                'status' => 'success',
                'message' => 'Si hay registros',
                'result' => $arrResponseSQL->result(),
            );
        }

        return array(
            'status' => 'warning',
            'message' => 'No hay registros',
        );
    }

    public function insertPosibleCliente($data, $message_whastapp)
    {
        try {
            if ($this->db->insert('entidad', $data) > 0) {
                return array('status' => 'success', 'message' => 'Mensaje enviado. En unos momentos te contactaremos', 'message_whastapp' => $message_whastapp);
            }

            return array('status' => 'error', 'message' => '¡Oops! Algo salió mal. Inténtalo mas tarde');
        } catch (Exception $e) {
            return array('status' => 'error', 'message' => '¡Oops! Algo salió mal. Inténtalo mas tarde');
        }
    }
}
