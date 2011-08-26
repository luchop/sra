<?php

class Modelo_grupo extends CI_Model {

    //nombre de la tabla
    private $Tabla = 'grupo';
	private $CodInstitucion;

    function __construct() {
        parent::__construct();
		$this->CodInstitucion=0;
    }
	
	function SetCodInstitucion($CodInstitucion){
		$this->CodInstitucion=$CodInstitucion;
	}

	function Insert($Nombre, $CorreoAdministrador, $Activo) {
        $sql = "INSERT INTO $this->Tabla (Nombre, CorreoAdministrador, Activo, CodInstitucion) 
                VALUES ('$Nombre', '$CorreoAdministrador', $Activo, $this->CodInstitucion)";
        $this->db->query($sql);
    }
	
	function Update($CodGrupo, $Nombre, $CorreoAdministrador, $Activo) {
		$sql = "UPDATE $this->Tabla SET Nombre='$Nombre', CorreoAdministrador='$CorreoAdministrador', Activo=$Activo
                WHERE CodGrupo=$CodGrupo";
        return $this->db->query($sql);
    }

    function Busqueda($Nombre,$Correo) {
        $sql = "select * from $this->Tabla where 
                (Nombre like '%$Nombre%' or '$Nombre'='') and 
                (CorreoAdministrador like '%$Correo%' or '$Correo'='') and
				CodInstitucion=$this->CodInstitucion
                ORDER BY Nombre";
        return $this->db->query($sql);
    }

    function getFila($CodGrupo) {
        $sql = "select * from $this->Tabla where CodGrupo=$CodGrupo";
        return $this->db->query($sql)->row();
    }

    function Delete($CodGrupo) {
        $this->db->where('CodGrupo', $CodGrupo);
        $this->db->delete($this->Tabla);
    }
    
    function NombreGrupo($CodGrupo) {
        $sql = "select * FROM $this->Tabla WHERE CodGrupo=$CodGrupo";
        $query = $this->db->query($sql);
        if($query->num_rows()>0) {
            $row = $query->row();
            return $row->Nombre;
        } else
            return '';
    }
    
    function ComboGrupos($CodGrupo='', $Requerido=1) {
        $sql = "select * from $this->Tabla where CodInstitucion=$this->CodInstitucion order by Nombre";
        $resultado = $this->db->query($sql);
        $s = "<select name='CodGrupo' id='CodGrupo'>";
		if ($Requerido==0)
			$s .= "<option value=''>-- Seleccione el grupo --</option>";
        foreach($resultado->result() as $row) 
            $s .= "<option value=".$row->CodGrupo.($CodGrupo==$row->CodGrupo? ' selected ':'').">".$row->Nombre."</option>";
        return $s."</select>";
    }
        
    function getDatos($CodGrupo, &$Nombre) {
        $sql = "SELECT * FROM $this->Tabla WHERE CodGrupo=$CodGrupo";
        $query = $this->db->query($sql);
        if( $query->num_rows()>0) {
            $row = $query->row();
            $Nombre = $row->Nombre;
            return 1;
        }
        else {
            $Nombre = '';
            $Tipo = '';
            return 0;
        }
    }
	
	function ClaveCorrespondeGrupo($Clave, $CodGrupo) {
        $sql = "SELECT CodGrupo FROM $this->Tabla WHERE CodGrupo=$CodGrupo
				AND Clave=MD5('$Clave')";
        $query = $this->db->query($sql);
		return ($query->num_rows()>0);	
	}
    
    function ExisteCorreo($s) {
        $sql = "SELECT CodGrupo FROM $this->Tabla WHERE CorreoAdministrador='$s' and CodInstitucion=$this->CodInstitucion ";
        $query = $this->db->query($sql);
        return ($query->num_rows()>0);
    }
}

?>