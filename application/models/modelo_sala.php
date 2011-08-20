<?php

class Modelo_sala extends CI_Model {

    //nombre de la tabla
    private $Tabla = 'sala';
	private $CodInstitucion;

    function __construct() {
        parent::__construct();
		$this->CodInstitucion=0;
    }
	
	function SetCodInstitucion($CodInstitucion){
		$this->CodInstitucion=$CodInstitucion;
	}

	function Insert($Nombre, $Descripcion, $CodGrupo, $Capacidad, $CorreoAdministrador, $Activo, $Orden) {
        $sql = "INSERT INTO $this->Tabla (Nombre, Descripcion, CodGrupo, Capacidad, CorreoAdministrador, Activo, Orden, CodInstitucion) 
                VALUES ('$Nombre', '$Descripcion', '$CodGrupo', '$Capacidad', '$CorreoAdministrador', $Activo, '$Orden', $this->CodInstitucion)";
        $this->db->query($sql);
    }
	
	function Update($CodSala, $Nombre, $Descripcion, $CodGrupo, $Capacidad, $CorreoAdministrador, $Activo, $Orden) {
		$sql = "UPDATE $this->Tabla SET Nombre='$Nombre', Descripcion='$Descripcion', CodGrupo='$CodGrupo', Capacidad='$Capacidad',
				CorreoAdministrador='$CorreoAdministrador', Activo=$Activo, Orden='$Orden'
                WHERE CodSala=$CodSala";
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

    function getFila($CodSala) {
        $sql = "select * from $this->Tabla where CodSala=$CodSala";
        return $this->db->query($sql)->row();
    }

    function Delete($CodSala) {
        $this->db->where('CodSala', $CodSala);
        $this->db->delete($this->Tabla);
    }
    
    function NombreSala($CodSala) {
        $sql = "select * FROM $this->Tabla WHERE CodSala=$CodSala";
        $query = $this->db->query($sql);
        if($query->num_rows()>0) {
            $row = $query->row();
            return $row->Nombre;
        } else
            return '';
    }
    
    function ComboSalas($CodSala='', $Requerido=1) {
        $sql = "select * from $this->Tabla where CodInstitucion=$this->CodInstitucion order by Nombre";
        $resultado = $this->db->query($sql);
        $s = "<select name='CodSala' id='CodSala'>";
		if ($Requerido==0)
			$s .= "<option value=''>-- Seleccione el usuario --</option>";
        foreach($resultado->result() as $row) 
            $s .= "<option value=".$row->CodSala.($CodSala==$row->CodSala? ' selected ':'').">".$row->Nombre."</option>";
        return $s."</select>";       
    }
	
	function ClaveCorrespondeSala($Clave, $CodSala) {
        $sql = "SELECT CodSala FROM $this->Tabla WHERE CodSala=$CodSala
				AND Clave=MD5('$Clave')";
        $query = $this->db->query($sql);
		return ($query->num_rows()>0);	
	}
    
    function ExisteCorreo($s) {
        $sql = "SELECT CodSala FROM $this->Tabla WHERE CorreoAdministrador='$s' and CodInstitucion=$this->CodInstitucion ";
        $query = $this->db->query($sql);
        return ($query->num_rows()>0);
    }
}

?>