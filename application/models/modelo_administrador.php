<?php

class Modelo_administrador extends CI_Model {

    //nombre de la tabla
    private $Tabla = 'administrador';

    function __construct() {
        parent::__construct();
    }

    //devuelve codigo de administrador.	
    function ExisteAdministrador($nick, $clave, $CodInstitucion, &$Codigo) {
		$sql = "SELECT CodParticipante FROM participante WHERE Nick=? AND Clave=md5(?)
				and TipoUsuario='A' and Activo=1 and CodInstitucion=$CodInstitucion";
		$query = $this->db->query($sql, array($nick, $clave));
		if ($query->num_rows() > 0) {    //encontrado 
			$row = $query->row(); 
			$Codigo = $row->CodParticipante;
			return true;
		}
		else
			return false;
	}
}

?>