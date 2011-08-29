<?php

class Modelo_reserva extends CI_Model {

    //nombre de la tabla
    private $Tabla = 'reserva';
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

	function Insert($Nombre, $Descripcion, $Notas, $Estado, $CodSala, $HoraInicio, $HoraFin, $CodRepeticion) {
        $sql = "INSERT INTO $this->Tabla (Nombre, Descripcion, Notas, Estado, CodSala, HoraInicio, HoraFin, CodRepeticion, CodUsuario, CodInstitucion) 
                VALUES ('$Nombre', '$Descripcion', '$Notas', '$Estado', '$CodSala', '$HoraInicio', '$HoraFin', '$CodRepeticion', $this->CodUsuario, $this->CodInstitucion)";
        $this->db->query($sql);
    }
	
	function Update($CodReserva, $Nombre, $Descripcion, $Notas, $Estado, $CodSala, $HoraInicio, $HoraFin, $CodRepeticion) {
		$sql = "UPDATE $this->Tabla SET Nombre='$Nombre', Descripcion='$Descripcion', Notas='$Notas', Estado='$Estado', CodSala='$CodSala', 
				HoraInicio='$HoraInicio', HoraFin='$HoraFin', CodRepeticion='$CodRepeticion'
                WHERE CodReserva=$CodReserva";
        return $this->db->query($sql);
    }

    function Busqueda($Nombre,$Descripcion,$Sala) {
        $sql = "select $this->Tabla.*,sala.Nombre as NombreSala,rep.FechaFinal,rep.DiaCompleto,rep.FechaFinal,rep.DiasSemana,rep.PeriodoRepeticion from $this->Tabla 
				left join sala on $this->Tabla.CodSala=sala.CodSala
				left join repeticion rep on $this->Tabla.CodRepeticion=rep.CodRepeticion
				where 
                ($this->Tabla.Nombre like '%$Nombre%' or '$Nombre'='') and 
                ($this->Tabla.Descripcion like '%$Descripcion%' or '$Descripcion'='') and 
                ($this->Tabla.CodSala = '$Sala' or '$Sala'='') and
				$this->Tabla.CodInstitucion=$this->CodInstitucion				
                ORDER BY $this->Tabla.Nombre";
        return $this->db->query($sql);
    }
	
	function Reporte($Nombre,$FechaInicio,$FechaFinal,$CodGrupo,$CodSala,$Estado,$CodUsuario) {
		$WhereDates="(DATE(FROM_UNIXTIME($this->Tabla.HoraInicio)) BETWEEN DATE(FROM_UNIXTIME($FechaInicio)) and DATE(FROM_UNIXTIME($FechaFinal))) ";
		if ($FechaInicio=='')
			$WhereDates="(DATE(FROM_UNIXTIME($this->Tabla.HoraInicio)) <= DATE(FROM_UNIXTIME($FechaFinal))) ";
		
        $sql = "select $this->Tabla.*,sala.Nombre as NombreSala,rep.FechaFinal,rep.DiaCompleto,usuario.Nombre as NombreUsuario from $this->Tabla 
				left join sala on $this->Tabla.CodSala=sala.CodSala
				left join repeticion rep on $this->Tabla.CodRepeticion=rep.CodRepeticion
				left join usuario on $this->Tabla.CodUsuario=usuario.CodUsuario
				where 
                ($this->Tabla.Nombre like '%$Nombre%' or '$Nombre'='') and 
                ($this->Tabla.Descripcion like '%$Nombre%' or '$Nombre'='') and 
				$WhereDates and
                (sala.CodGrupo = '$CodGrupo' or '$CodGrupo'='') and
				($this->Tabla.CodSala = '$CodSala' or '$CodSala'='') and
                ($this->Tabla.Estado = '$Estado' or '$Estado'='') and
                ($this->Tabla.CodUsuario = '$CodUsuario' or '$CodUsuario'='') and
				$this->Tabla.CodInstitucion=$this->CodInstitucion				
                ORDER BY $this->Tabla.Nombre";
        return $this->db->query($sql);
    }

    function getFila($CodReserva) {
        $sql = "select $this->Tabla.*,rep.DiaCompleto,rep.FechaFinal,rep.DiasSemana,rep.PeriodoRepeticion from $this->Tabla
				left join repeticion rep on $this->Tabla.CodRepeticion=rep.CodRepeticion
				where $this->Tabla.CodReserva=$CodReserva";
        return $this->db->query($sql)->row();
    }

    function Delete($CodReserva) {
        $this->db->where('CodReserva', $CodReserva);
        $this->db->delete($this->Tabla);
    }
    
    function NombreSala($CodReserva) {
        $sql = "select * FROM $this->Tabla WHERE CodReserva=$CodReserva";
        $query = $this->db->query($sql);
        if($query->num_rows()>0) {
            $row = $query->row();
            return $row->Nombre;
        } else
            return '';
    }
    
    function ComboSalas($CodReserva='', $Requerido=1) {
        $sql = "select * from $this->Tabla where CodInstitucion=$this->CodInstitucion order by Nombre";
        $resultado = $this->db->query($sql);
        $s = "<select name='CodReserva' id='CodReserva'>";
		if ($Requerido==0)
			$s .= "<option value=''>-- Seleccione el usuario --</option>";
        foreach($resultado->result() as $row) 
            $s .= "<option value=".$row->CodReserva.($CodReserva==$row->CodReserva? ' selected ':'').">".$row->Nombre."</option>";
        return $s."</select>";       
    }
	
}

?>