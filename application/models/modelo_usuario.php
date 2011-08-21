<?php

class Modelo_usuario extends CI_Model {

    //nombre de la tabla
    private $Tabla = 'usuario';

    function __construct() {
        parent::__construct();
    }
	
	function GeneraClaveUnica() {
		$Clave = ClavePronunciable();
		do {
			$sql = "select CodUsuario from $this->Tabla where Clave=MD5('$Clave')";
			$query = $this->db->query($sql);
		} while($query->num_rows() > 0); 
		return $Clave;
	}
	
    function ExisteUsuario($Nick, $Clave, $CodInstitucion, &$CodUsuario, &$Nombre, &$Tipo) {
		$sql = "SELECT * FROM $this->Tabla WHERE Nick=? AND Clave=md5(?) AND CodInstitucion=?";
		$query = $this->db->query($sql, array($Nick, $Clave, $CodInstitucion));
		if ($query->num_rows() > 0) {
			$row = $query->row(); 
			$CodUsuario = $row->CodUsuario;
            $Nombre = $row->Nombre;
            $Tipo = $row->TipoUsuario;
			return true;
		}
		else
			return false;
	}
	
	function UpdateInstitucion($CodInstitucion, $CorreoOriginal, $Nombre, $Correo, $Activo) {
		$sql = "UPDATE $this->Tabla SET Nombre='$Nombre', Correo='$Correo', Activo=$Activo
				WHERE CodInstitucion=$CodInstitucion AND Correo='$CorreoOriginal'";
		$this->db->query($sql);  
	}

	function Insert($Nombre, $Correo, $Nick, $Clave, $Activo, $TipoUsuario, $CodInstitucion) {
        $sql = "INSERT INTO $this->Tabla (Nombre, Correo, Nick, Clave, Activo, TipoUsuario, CodInstitucion) 
                VALUES ('$Nombre', '$Correo', '$Nick', MD5('$Clave'), $Activo, '$TipoUsuario', $CodInstitucion)";
        $this->db->query($sql);  
    }
	
	function Update($CodUsuario, $Nombre, $Correo, $Nick, $Activo, $TipoUsuario) {
		$sql = "UPDATE $this->Tabla SET Nombre='$Nombre', Correo='$Correo', Nick='$Nick',
			    Activo=$Activo, TipoUsuario='$TipoUsuario' 
                WHERE CodUsuario=$CodUsuario";
        return $this->db->query($sql);
    }
	
	function UpdateClave($Correo, $Clave) {
		$sql = "UPDATE $this->Tabla SET Clave=MD5('$Clave')
                WHERE Correo=$Correo";
        return $this->db->query($sql);
    }

    function Busqueda($Nombre, $Nick, $CodInstitucion) {
        $sql = "select * from $this->Tabla where 
                (Nombre like '%$Nombre%' or '$Nombre'='') and 
                (Nick like '%$Nick%' or '$Nick'='') and
				CodInstitucion=$CodInstitucion
                ORDER BY Nombre";
        return $this->db->query($sql);
    }

    function getFila($CodUsuario) {
        $sql = "select * from $this->Tabla where CodUsuario=$CodUsuario";
        return $this->db->query($sql)->row();
    }

    function Delete($CodUsuario) {
        $this->db->where('CodUsuario', $CodUsuario);
        $this->db->delete($this->Tabla);
    }
    
    function BuscarUsuario($Usuario){
        $sql = "SELECT * FROM $this->Tabla
                WHERE Nombres LIKE('%$Usuario%')
                OR Apellidos LIKE('%$Usuario%')
                ORDER BY Nombres, Apellidos";
        $resultado=mysql_query($sql,$link); 
        return $resultado;
    }
    
    function NombreUsuario($CodUsuario) {
        $sql = "select * FROM $this->Tabla WHERE CodUsuario=$CodUsuario";
        $query = $this->db->query($sql);
        if($query->num_rows()>0) {
            $row = $query->row();
            return $row->Nombre;
        } else
            return '';
    }
	
	function TiposUsuario($CodInstitucion) {
		$sql = "select * from tipo_usuario where CodInstitucion=$CodInstitucion order by Nombre";
        return $this->db->query($sql);
	}
    
    function ComboUsuarios($CodInstitucion, $CodUsuario='', $Requerido=1) {
        $sql = "select * from $this->Tabla where CodInstitucion=$CodInstitucion order by Nombre";
        $resultado = $this->db->query($sql);
        $s = "<select name='CodUsuario' id='CodUsuario'>";
		if ($Requerido==0)
			$s .= "<option value=''>-- Seleccione el usuario --</option>";
        foreach($resultado->result() as $row) 
            $s .= "<option value=".$row->CodUsuario.($CodUsuario==$row->CodUsuario? ' selected ':'').">".$row->Nombre."</option>";
        return $s."</select>";       
    }

	function ExisteNick($Nick, $CodInstitucion){
        $sql = "SELECT CodUsuario FROM $this->Tabla WHERE Nick='$Nick' AND CodInstitucion=$CodInstitucion";
        $query = $this->db->query($sql);
        return ($query->num_rows()>0);
    }
        
    function getDatos($CodUsuario, &$Nombre, &$Tipo) {
        $sql = "SELECT Nombre, Tipo FROM $this->Tabla WHERE CodUsuario=$CodUsuario";
        $query = $this->db->query($sql);
        if( $query->num_rows()>0) {
            $row = $query->row();
            $Nombre = $row->Nombre;
            $Tipo = $row->Tipo;
            return 1;
        }
        else {
            $Nombre = '';
            $Tipo = '';
            return 0;
        }
    }
	
	function ClaveCorrespondeUsuario($Clave, $CodUsuario) {
        $sql = "SELECT CodUsuario FROM $this->Tabla WHERE CodUsuario=$CodUsuario
				AND Clave=MD5('$Clave')";
        $query = $this->db->query($sql);
		return ($query->num_rows()>0);	
	}
    
    function CambiaClave( $CodUsuario, $NuevaClave ) {
        $sql = "UPDATE $this->Tabla SET Clave=MD5('$NuevaClave') WHERE CodUsuario=$CodUsuario";
        $this->db->query($sql);
    }  
	
	function ExisteCorreo($s) {
        $sql = "SELECT CodUsuario FROM $this->Tabla WHERE Correo='$s'";
        $query = $this->db->query($sql);
        return ($query->num_rows()>0);
    }
}

?>