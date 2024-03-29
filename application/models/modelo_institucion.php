<?php

class Modelo_institucion extends CI_Model {

    //nombre de la tabla
    private $Tabla = 'institucion';

    function __construct() {
        parent::__construct();
    }

	function Insert($Nombre, $Contacto, $Correo, $CodPais, $SitioWeb, $Telefono,
                    $Activo, $Notas) {
        $sql = "INSERT INTO $this->Tabla (Nombre, Contacto, Correo, CodPais, SitioWeb, Telefono,
                                          Activo, Notas) 
				VALUES ('$Nombre', '$Contacto', '$Correo', $CodPais, '$SitioWeb', '$Telefono',
                        $Activo, '$Notas')";
        $this->db->query($sql);
		
		$sql = "SELECT LAST_INSERT_ID() AS Codigo";
        $query = $this->db->query($sql);
        if ( $query->num_rows()>0 )
           return $query->row()->Codigo;
        else        
            return 0;
    }


    function Update($CodInstitucion,$Nombre, $Contacto, $Correo, $CodPais, $SitioWeb, $Telefono,
                    $Activo, $Notas) {
        $sql = "UPDATE $this->Tabla set 
				Nombre='$Nombre', Contacto='$Contacto', Correo='$Correo', CodPais=$CodPais,
				SitioWeb='$SitioWeb', Telefono='$Telefono', Activo=$Activo, Notas='$Notas' 
				WHERE CodInstitucion=$CodInstitucion";
        return $this->db->query($sql);
    }

    function Busqueda($Nombre, $Contacto, $Correo) {
        $sql = "select * from $this->Tabla
				where (Nombre LIKE '%$Nombre%' or '$Nombre'='') 
				and (Contacto LIKE '%$Contacto%' or '$Contacto'='') 
				and (Correo LIKE '%$Correo%' or '$Correo'='') ";
        return $this->db->query($sql);
    }

    function getFila($CodInstitucion) {
        $sql = "select * from $this->Tabla where CodInstitucion=$CodInstitucion";
        return $this->db->query($sql)->row();
    }

    function Delete($CodInstitucion) {
        $this->db->where('CodInstitucion', $CodInstitucion);
        $this->db->delete($this->Tabla);
		$sql = "DELETE FROM usuario WHERE CodInstitucion=$CodInstitucion";
		$this->db->query($sql);
		$this->db->where('CodInstitucion', $CodInstitucion);
        $this->db->delete('contrato');
    }
	
	function ExisteCorreo($s) {
        $sql = "SELECT CodInstitucion FROM $this->Tabla WHERE Correo='$s'";
        $query = $this->db->query($sql);
        return ($query->num_rows()>0);
    }
	
    /*function TablaInstitucions() {
        $sql = "select * from $this->Tabla ORDER BY Orden, CodInstitucion";
        return $this->db->query($sql);	
    }*/

    function ComboInstituciones($CodInstitucion='', $Requerido='1') {
        $sql = "SELECT * FROM  institucion ORDER BY Nombre";
		$resultado = $this->db->query($sql);
        $s = "<select name='CodInstitucion' id='CodInstitucion' ";
		if($Requerido==1)
			$s .= "class='required'";
		$s .= "><option value=''>-Selecci&oacute;n de instituci&oacute;n-</option>";
        foreach($resultado->result() as $row) 
			$s .= "<option value=".$row->CodInstitucion.($CodInstitucion==$row->CodInstitucion? ' selected ':'').">".$row->Nombre."</option>";
        return $s."</select>";		
    }
  
	
	function TablaPaises() {
		$sql = "SELECT * FROM pais ORDER BY Nombre";
		return $this->db->query($sql);
	}   
	
	function GetNombre($CodInstitucion) {
        $sql = "select Nombre from $this->Tabla WHERE CodInstitucion=$CodInstitucion";
        $query = $this->db->query($sql);	
		if( $query->num_rows()>0) {
			$row = $query->row();
			return $row->Nombre;
		} else
			return '';
    }
}

?>