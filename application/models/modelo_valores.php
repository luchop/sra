<?php

class Modelo_valores extends CI_Model {

    private $Tabla = 'valores';
	private $CodInstitucion;

    function __construct() {
        parent::__construct();
		$this->CodInstitucion=0;
    }
	
	function SetCodInstitucion($CodInstitucion){
		$this->CodInstitucion=$CodInstitucion;
	}

	function SetNumero($Clave, $Numero) {
		$Numero=($Numero=='') ? 0 : $Numero;
        $sql = "insert into $this->Tabla (Clave, Numero,CodInstitucion) values('$Clave', $Numero, $this->CodInstitucion)
				on duplicate key update Numero=$Numero";
        $this->db->query($sql);	
	}
	
	function SetTexto($Clave, $Texto) {
        $sql = "insert into $this->Tabla (Clave, Texto,CodInstitucion) values('$Clave', '$Texto', $this->CodInstitucion)
				on duplicate key update Texto='$Texto'";
        $this->db->query($sql);	
	}
	
	function GetTexto($Clave) {
        $sql = "select Texto from $this->Tabla where Clave='$Clave' and CodInstitucion=$this->CodInstitucion ";
        $query = $this->db->query($sql);	
		if( $query->num_rows()==0 )
			return '';
		else
			return $query->row()->Texto;
	}
	
	function GetNumero($Clave) {
        $sql = "select Numero from $this->Tabla where Clave='$Clave' and CodInstitucion=$this->CodInstitucion ";
        $query = $this->db->query($sql);	
		if( $query->num_rows()==0 )
			return 0;
		else
			return $query->row()->Numero;
	}
}

?>