<?php

class Institucion extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('modelo_institucion', '', TRUE);
		$this->load->model('modelo_usuario', '', TRUE);
		$this->load->model('modelo_valores', '', TRUE);	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		
    }

    function Index() {
	    $data['VistaPrincipal'] = 'vista_menu_super';
        $this->load->view('vista_maestra', $data);
    }

    function NuevaInstitucion() {
		$this->form_validation->set_rules('Nombre', 'nombre', 'xss_clean');
		$this->form_validation->set_rules('Contacto', 'contacto', 'xss_clean');
		$this->form_validation->set_rules('Telefono', 'telefono', 'xss_clean');
		$this->form_validation->set_rules('SitioWeb', 'sitio web', 'xss_clean');
		$this->form_validation->set_rules('Notas', 'notas', 'xss_clean');
		$this->form_validation->set_rules('Correo', 'correo', 'callback_CorreoUnico');
		
        $data['VistaMenu'] = 'vista_menu_super';
		$data['ComboPais'] = $this->ComboPais(0);
        if ($this->form_validation->run()) {
		    $Activo = $this->input->post('Activo')? 1: 0;
			$CodInstitucion = $this->modelo_institucion->Insert($this->input->post('Nombre'), $this->input->post('Contacto'),
                                            $this->input->post('Correo'), $this->input->post('CodPais'),
                                            $this->input->post('SitioWeb'), $this->input->post('Telefono'),
                                            $Activo, $this->input->post('Notas'));
			$Clave = $this->modelo_usuario->GeneraClaveUnica();
            $this->modelo_usuario->Insert($this->input->post('Nombre'), $this->input->post('Correo'), 
			                              'admin', $Clave, $Activo, '1', $CodInstitucion);  //'1':administrador
            $data['Mensaje'] = "Se ha registrado una nueva institucion. (Codigo: $Clave)";
            $data['VistaPrincipal'] = 'vista_mensaje';
        } else {
            $data['VistaPrincipal'] = 'vista_nueva_institucion';
        }
		$this->load->view('vista_maestra', $data);	
    }

    function BuscaParaModificar($Modificacion) {
        $this->form_validation->set_rules('Nombre', 'nombre', 'xss_clean');
		$this->form_validation->set_rules('Contacto', 'contacto', 'xss_clean');
		$this->form_validation->set_rules('Correo', 'correo', 'xss_clean');
		
        $data['VistaMenu'] = 'vista_menu_super';
        if ($this->form_validation->run()) {
            $registros = $this->modelo_institucion->Busqueda($this->input->post('Nombre'),
                                                $this->input->post('Contacto'), $this->input->post('Correo'));
            if( $Modificacion==1 )
                $Vista = 'vista_modifica_institucion';
            else
                $Vista = 'vista_consulta_institucion';
                
            if ($registros->num_rows() == 0) {
                $data['Mensaje'] = 'No se encontraron registros que cumplan el criterio de b&uacute;squeda';
                $data['VistaPrincipal'] = 'vista_mensaje';
            } else if ($registros->num_rows() == 1) {
                $data['Fila'] = $registros->row();
				$data['ComboPais'] = $this->ComboPais($data['Fila']->CodPais);
				$data['CorreoOriginal'] = $data['Fila']->Correo;
                $data['VistaPrincipal'] = $Vista;
            } else {
                $this->load->library('table');
				$this->table->clear();
				$this->table->set_template( $this->DefinicionTablaSeleccion() );
                $this->table->set_empty("&nbsp;");
                $this->table->set_heading('No.', 'Nombre', 'Contacto', 'Acci&oacute;n');
                $i = 0;
                foreach ($registros->result() as $registro)
                    $this->table->add_row(++$i, $registro->Nombre, $registro->Contacto, 
                            anchor("institucion/CargaVista/$Vista/" . $registro->CodInstitucion, 
                            ($Modificacion==1? ' Modificar ':' Ver '), 
                            array('class'=>($Modificacion==1? 'actualiza':'vista'))). '  '.
                            anchor('institucion/BorrarInstitucion/' . $registro->CodInstitucion, 'Eliminar', array('class'=>'elimina','onclick'=>"return confirm('Realmente desea borrar este registro?')")));
                $data['Tabla'] = $this->table->generate();
                $data['Vista'] = 'vista_busca_institucion';
                $data['VistaPrincipal'] = 'vista_lista_instituciones';
            }
        } else {
            $data['VistaPrincipal'] = 'vista_busca_institucion';
            $data['Modificacion'] = $Modificacion;            
        }
		$this->load->view('vista_maestra', $data);
    }

    function ModificaInstitucion() {
		$this->form_validation->set_rules('Nombre', 'nombre', 'trim|xss_clean');
		$this->form_validation->set_rules('Contacto', 'contacto', 'trim|xss_clean');
		$this->form_validation->set_rules('Telefono', 'telefono', 'trim|xss_clean');
		$this->form_validation->set_rules('SitioWeb', 'sitio web', 'trim|xss_clean');
		$this->form_validation->set_rules('Correo', 'correo', 'trim|xss_clean');
		$this->form_validation->set_rules('Notas', 'notas', 'trim|xss_clean');
			
        $data['VistaMenu'] = 'vista_menu_super';
        if ($this->form_validation->run()) {
            $Accion = $this->input->post("submit");
			if ($Accion == "Guardar") {
                $Activo = $this->input->post('Activo')? 1: 0;
				$this->modelo_institucion->Update($this->input->post('CodInstitucion'), $this->input->post('Nombre'), $this->input->post('Contacto'),
                                            $this->input->post('Correo'), $this->input->post('CodPais'),
                                            $this->input->post('SitioWeb'), $this->input->post('Telefono'),
                                            $Activo, $this->input->post('Notas'));
				$this->modelo_usuario->UpdateInstitucion($this->input->post('CodInstitucion'), $this->input->post('CorreoOriginal'), 
				                                         $this->input->post('Nombre'), $this->input->post('Correo'), $Activo);
				$data['Mensaje'] = 'Se han modificado los datos de la institucion.';
                $data['VistaPrincipal'] = 'vista_mensaje';
            }
            else {
                $this->modelo_institucion->Delete($this->input->post('CodInstitucion'), $this->input->post('Correo'));
                $data['Mensaje'] = 'Los datos de la institucion han sido eliminados';
                $data['VistaPrincipal'] = 'vista_mensaje';
            }
        } else {
            $data['Fila'] = $this->modelo_institucion->getFila($this->input->post('CodInstitucion'));
			$data['VistaPrincipal'] = 'vista_modifica_institucion';
        }
		$this->load->view('vista_maestra', $data);
    }

    function CargaVista($Vista, $CodInstitucion) {
        $data['VistaMenu'] = 'vista_menu_super';
        $data['Fila'] = $this->modelo_institucion->getFila($CodInstitucion);
        $data['ComboPais'] = $this->ComboPais($data['Fila']->CodPais);
		$data['VistaPrincipal'] = $Vista;
        $this->load->view('vista_maestra', $data);
    }
	
	function DefinicionTablaSeleccion() {
		$tmp = array (
			'table_open'          => '<table class="tablaseleccion">',

			'heading_row_start'   => '<tr>',
			'heading_row_end'     => '</tr>',
			'heading_cell_start'  => '<th>',
			'heading_cell_end'    => '</th>',

			'row_start'           => '<tr style="background-color:#f6f6f6">',
			'row_end'             => '</tr>',
			'cell_start'          => '<td>',
			'cell_end'            => '</td>',

			'row_alt_start'       => '<tr>',
			'row_alt_end'         => '</tr>',
			'cell_alt_start'      => '<td>',
			'cell_alt_end'        => '</td>',

			'table_close'         => '</table>'
		);
		return $tmp;
	}

    function BorrarInstitucion($CodInstitucion) {
        $this->modelo_institucion->Delete($CodInstitucion);
        redirect('institucion','refresh');
    }
	
	function ComboPais($CodPais='0') {
        $resultado = $this->modelo_institucion->TablaPaises();        
        $s = "<select name='CodPais' id='CodPais' class='required'><option value=''>-Selecci&oacute;n de pais-</option>";
        foreach($resultado->result() as $row) 
            $s .= "<option value=".$row->CodPais.($CodPais==$row->CodPais? ' selected ':'').">".$row->Nombre."</option>";
        return $s."</select>";       
	}
	
	function CorreoUnico($Correo) {
		if( $this->modelo_institucion->ExisteCorreo($Correo) ) {
			$this->form_validation->set_message('CorreoUnico', 'Este correo ya se encuentra registrado.');
			return FALSE;
		}
		else
			return TRUE;
	}
}

?>