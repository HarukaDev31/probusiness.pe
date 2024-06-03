<?php
class ImportacionGrupalModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getTrendProducts()
    {
        $query = $this->db->query("select No_Producto,No_Imagen_Item  from importacion_grupal_cabecera igc
		join importacion_grupal_detalle igd  on igc.ID_Importacion_Grupal=igd.ID_Importacion_Grupal
		join producto p  on igd.ID_Producto =p.ID_Producto
		where igc.Nu_Estado =1
		;
		");
        return $query->result();
    }
}
