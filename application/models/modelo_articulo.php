<?php

class Modelo_articulo extends CI_Model {

    private $Tabla = 'articulo';
	private $PrimaryKey = 'CodArticulo';
	private $CodInstitucion;

    function __construct() {
        parent::__construct();
		$this->CodInstitucion=0;
    }
	
	function SetCodInstitucion($CodInstitucion){
		$this->CodInstitucion=$CodInstitucion;
	}
	
	function SetTabla($Tabla){
		$this->Tabla=$Tabla;
		$this->PrimaryKey='Cod'.ucfirst($Tabla);
	}

    function Insert($Nombre) {
		if ($this->session->userdata('UsuarioPrueba')==0){
			$sql = "INSERT INTO $this->Tabla (Nombre,CodInstitucion) VALUES ('$Nombre', '$this->CodInstitucion')";
			return $this->db->query($sql);
		}
        return '';
    }

    function Update($Cod,$Nombre) {
		if ($this->session->userdata('UsuarioPrueba')==0){
			$sql = "UPDATE $this->Tabla SET Nombre='$Nombre' 
					WHERE $this->PrimaryKey=$Cod";
			return $this->db->query($sql);
		}
		return '';
    }

    function Busqueda($Nombre='') {
        $sql = "select * from $this->Tabla 
				where (Nombre like '%$Nombre%' or '$Nombre'='')	and CodInstitucion=$this->CodInstitucion
				ORDER BY Nombre";
        return $this->db->query($sql);
    }

    function getFila($Cod) {
        $sql = "select * from $this->Tabla where $this->PrimaryKey=$Cod and CodInstitucion=$this->CodInstitucion";
        return $this->db->query($sql)->row();
    }
	
	function ComboArticulo($Cod, $Requerido=0) {
        $sql = "select * from $this->Tabla where CodInstitucion=$this->CodInstitucion order by Nombre";
        $resultado = $this->db->query($sql);
		$class_requerido=($Requerido==1) ? 'class="required"' : '';
        $s = "<select name='$this->PrimaryKey' id='$this->PrimaryKey' $class_requerido>";
		$s .= "<option value=''>Seleccione una opcion</option>";
		$CampoCodigo=$this->PrimaryKey;
        foreach($resultado->result() as $row) 
            $s .= "<option value=".$row->$CampoCodigo.($Cod==$row->$CampoCodigo? ' selected ':'').">".$row->Nombre."</option>";
        return $s."</select>";       
    }
	
	function GetCombo($Cod,$Requerido=0){
		return $this->ComboArticulo($Cod,$Requerido);
	}

    function Delete($CodArticulo) {
		if ($this->session->userdata('UsuarioPrueba')==0){
			$this->db->where($this->PrimaryKey, $CodArticulo);
			$this->db->delete($this->Tabla);
		}
    }
	
	function GetNombre($Cod){
		$sql = "SELECT Nombre FROM $this->Tabla WHERE $this->PrimaryKey=$Cod";
        $query = $this->db->query($sql);
        if( $query->num_rows()>0) {
            $row = $query->row();
            return $row->Nombre;
        } else
            return '';
	}
	
	function ExisteNombre($Nombre) {
		$sql = "SELECT Nombre FROM $this->Tabla WHERE Nombre='$Nombre' AND CodInstitucion=$this->CodInstitucion";
        $query = $this->db->query($sql);
        return $query->num_rows()>0;
	}
}

?>