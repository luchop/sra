<?php

class Modelo_cobro extends CI_Model {

    //nombre de la tabla
    private $Tabla = 'cobro';
	private $CodInstitucion;

    function __construct() {
        parent::__construct();
		$this->CodInstitucion=0;
    }
	
	function SetCodInstitucion($CodInstitucion){
		$this->CodInstitucion=$CodInstitucion;
	}

	function Insert($CodAlCuota, $Fecha, $Monto, $Factura, $TalonarioF, $Detalle) {
        $sql = "INSERT INTO $this->Tabla (CodAlCuota, Fecha, Monto, Factura, TalonarioF, Detalle)
                VALUES ('$CodAlCuota', '$Fecha', '$Monto', '$Factura', '$TalonarioF', '$Detalle')";
        $this->db->query($sql);
    }
	
	function Update($CodCobro, $CodAlCuota, $Fecha, $Monto, $Factura, $TalonarioF, $Detalle) {
		$sql = "UPDATE $this->Tabla SET CodAlCuota='$CodAlCuota', Fecha='$Fecha', Monto='$Monto', Factura='$Factura', TalonarioF='$TalonarioF', 
				Detalle='$Detalle'
                WHERE CodCobro=$CodCobro";
        return $this->db->query($sql);
    }

    function Busqueda($Detalle) {
        $sql = "select * from $this->Tabla where 
                Detalle like '%$Detalle%' or '$Detalle'=''
                ORDER BY 1";
        return $this->db->query($sql);
    }

    function getFila($CodCobro) {
        $sql = "select * from $this->Tabla where CodCobro=$CodCobro";
        return $this->db->query($sql)->row();
    }

    function Delete($CodCobro) {
        $this->db->where('CodCobro', $CodCobro);
        $this->db->delete($this->Tabla);
    }
    
    function NombreSala($CodCobro) {
        $sql = "select * FROM $this->Tabla WHERE CodCobro=$CodCobro";
        $query = $this->db->query($sql);
        if($query->num_rows()>0) {
            $row = $query->row();
            return $row->Nombre;
        } else
            return '';
    }
    
    function ComboSalas($CodCobro='', $Requerido=1) {
        $sql = "select * from $this->Tabla where CodInstitucion=$this->CodInstitucion order by Nombre";
        $resultado = $this->db->query($sql);
        $s = "<select name='CodCobro' id='CodCobro'>";
		if ($Requerido==0)
			$s .= "<option value=''>-- Seleccione la sala --</option>";
        foreach($resultado->result() as $row) 
            $s .= "<option value=".$row->CodCobro.($CodCobro==$row->CodCobro? ' selected ':'').">".$row->Nombre."</option>";
        return $s."</select>";       
    }
}

?>