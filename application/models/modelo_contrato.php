<?php

class Modelo_contrato extends CI_Model {

    //nombre de la tabla
    private $Tabla = 'contrato';

    function __construct() {
        parent::__construct();
    }

	function Insert($CodInstitucion, $Desde, $Hasta, $Precio, $Notas) {
        $sql = "INSERT INTO $this->Tabla (CodInstitucion, Desde, Hasta, Precio, Notas) 
				VALUES ($CodInstitucion, '$Desde', '$Hasta', $Precio, '$Notas')";
        $this->db->query($sql);
		$sql = "SELECT LAST_INSERT_ID() AS Codigo";
		$query = $this->db->query($sql);
		if( $query->num_rows()>0 ) {
			$row = $query->row();
			return $row->Codigo;
		} else
			return 0;
    }

    function Update($CodContrato, $CodInstitucion, $Desde, $Hasta, $Precio, $Notas) {
        $sql = "UPDATE $this->Tabla set 
				CodInstitucion=$CodInstitucion, Desde='$Desde', Hasta='$Hasta', Precio=$Precio, Notas='$Notas' 
				WHERE CodContrato=$CodContrato";
        return $this->db->query($sql);
    }

    function Busqueda($CodInstitucion, $Desde, $Hasta) {
        $sql = "SELECT contrato.*, institucion.Nombre FROM contrato, institucion
				WHERE contrato.CodInstitucion=institucion.CodInstitucion 
				and (contrato.CodInstitucion='$CodInstitucion' or '$CodInstitucion'='')
				and (Desde>='$Desde' or '$Desde'='')
				and (Hasta<='$Hasta' or '$Hasta'='')
				ORDER BY Desde";
        return $this->db->query($sql);
    }

    function getFila($CodContrato) {
        $sql = "select * from $this->Tabla where CodContrato=$CodContrato";
        return $this->db->query($sql)->row();
    }

    function Delete($CodContrato) {
        $this->db->where('CodContrato', $CodContrato);
        $this->db->delete($this->Tabla);
    }
}

?>