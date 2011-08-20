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

	function Insert($Nombre, $Descripcion, $Estado, $CodSala, $HoraInicio, $HoraFin, $CodRepeticion) {
        $sql = "INSERT INTO $this->Tabla (Nombre, Descripcion, Estado, CodSala, HoraInicio, HoraFin, CodRepeticion, CodUsuario, CodInstitucion) 
                VALUES ('$Nombre', '$Descripcion', '$Estado', '$CodSala', '$HoraInicio', '$HoraFin', '$CodRepeticion', $this->CodUsuario, $this->CodInstitucion)";
        $this->db->query($sql);
    }
	
	function Update($CodReserva, $Nombre, $Descripcion, $CodGrupo, $Capacidad, $CorreoAdministrador, $Activo, $Orden) {
		$sql = "UPDATE $this->Tabla SET Nombre='$Nombre', Descripcion='$Descripcion', CodGrupo='$CodGrupo', Capacidad='$Capacidad',
				CorreoAdministrador='$CorreoAdministrador', Activo=$Activo, Orden='$Orden'
                WHERE CodReserva=$CodReserva";
        return $this->db->query($sql);
    }

    function Busqueda($Nombre,$Correo) {
        $sql = "select * from $this->Tabla where 
                (Nombre like '%$Nombre%' or '$Nombre'='') and 
                (CorreoAdministrador like '%$Correo%' or '$Correo'='') and
				CodInstitucion=$this->CodInstitucion
                ORDER BY Orden";
        return $this->db->query($sql);
    }

    function getFila($CodReserva) {
        $sql = "select * from $this->Tabla where CodReserva=$CodReserva";
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