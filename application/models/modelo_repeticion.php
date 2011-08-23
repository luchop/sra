<?php

class Modelo_repeticion extends CI_Model {

    //nombre de la tabla
    private $Tabla = 'repeticion';
	private $CodInstitucion;
	private $CodUsuario;

    function __construct() {
        parent::__construct();
		$this->CodInstitucion=0;
		$this->CodUsuario=0;
    }
	
	function SetCodInstitucion($CodInstitucion){
		$this->CodInstitucion=$CodInstitucion;
	}
	
	function SetCodUsuario($CodUsuario){
		$this->CodUsuario=$CodUsuario;
	}

	function Insert($Nombre, $Descripcion, $Estado, $CodSala, $HoraInicio, $HoraFin, $DiaCompleto, $FechaFinal, $DiasSemana, $PeriodoRepeticion) {
        $sql = "INSERT INTO $this->Tabla (Nombre, Descripcion, Estado, CodSala, HoraInicio, HoraFin, DiaCompleto, FechaFinal, DiasSemana, PeriodoRepeticion, CodUsuario, CodInstitucion) 
                VALUES ('$Nombre', '$Descripcion', '$Estado', '$CodSala', '$HoraInicio', '$HoraFin', '$DiaCompleto', '$FechaFinal', '$DiasSemana', '$PeriodoRepeticion', $this->CodUsuario, $this->CodInstitucion)";
        $this->db->query($sql);
		return $this->db->insert_id();
    }

	function Update($CodRepeticion, $Nombre, $Descripcion, $Estado, $CodSala, $HoraInicio, $HoraFin, $DiaCompleto, $FechaFinal, $DiasSemana, $PeriodoRepeticion) {
		$sql = "UPDATE $this->Tabla SET Nombre='$Nombre', Descripcion='$Descripcion', Estado='$Estado', CodSala='$CodSala', HoraInicio='$HoraInicio', 
				HoraFin='$HoraFin', DiaCompleto='$DiaCompleto', FechaFinal='$FechaFinal', DiasSemana='$DiasSemana', PeriodoRepeticion='$PeriodoRepeticion'
                WHERE CodRepeticion=$CodRepeticion";
        return $this->db->query($sql);
    }

    function getFila($CodRepeticion) {
        $sql = "select * from $this->Tabla where CodRepeticion=$CodRepeticion";
        return $this->db->query($sql)->row();
    }

    function Delete($CodRepeticion) {
        $this->db->where('CodRepeticion', $CodRepeticion);
        $this->db->delete($this->Tabla);
    }
}

?>