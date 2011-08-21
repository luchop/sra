<?php

class Usuario extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->load->model('modelo_usuario', '', TRUE);
		$this->load->model('modelo_valores', '', TRUE);	
		$this->load->library('funciones');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		
    }

    function Index() {
	    $data['VistaPrincipal'] = 'vista_menu_admin';
        $this->load->view('vista_maestra', $data);
    }

    function NuevoUsuario() {
		$this->form_validation->set_rules('Nombre', 'nombre', 'xss_clean');
		$this->form_validation->set_rules('Correo', 'correo', 'callback_CorreoUnico');
		$this->form_validation->set_rules('Nick', 'nombre de usuario', 'callback_NickUnico');
		
        $data['VistaMenu'] = 'vista_menu_admin';
		$data['ComboTipoUsuario'] = $this->ComboTipoUsuario(0);
        if ($this->form_validation->run()) {
		    $Activo = $this->input->post('Activo')? 1: 0;
			$Clave = $this->modelo_usuario->GeneraClaveUnica();
			if ($this->session->userdata('UsuarioPrueba')==1){
					$data['Mensaje'] = $this->funciones->MensajePrueba();
			}else{
				$CodUsuario = $this->modelo_usuario->Insert($this->input->post('Nombre'), $this->input->post('Correo'), 
			                                $this->input->post('Nick'), $Clave,
                                            $Activo, $this->input->post('CodTipoUsuario'), 
											$this->session->userdata('CodInstitucion'));
				$data['Mensaje'] = "Se ha registrado un nuevo usuario. (Codigo: $Clave)";			
			}
            $data['VistaPrincipal'] = 'vista_mensaje';
        } else {
            $data['VistaPrincipal'] = 'vista_nuevo_usuario';
        }
		$this->load->view('vista_maestra', $data);	
    }

    function BuscaParaModificar($Modificacion) {
        $this->form_validation->set_rules('Nombre', 'nombre', 'xss_clean');
		$this->form_validation->set_rules('Nick', 'nombre de usuario', 'xss_clean');
		
        $data['VistaMenu'] = 'vista_menu_admin';
        if ($this->form_validation->run()) {
            $registros = $this->modelo_usuario->Busqueda($this->input->post('Nombre'), $this->input->post('Nick'),
			                                             $this->session->userdata('CodInstitucion') );
            if( $Modificacion==1 )
                $Vista = 'vista_modifica_usuario';
            else
                $Vista = 'vista_consulta_usuario';
                
            if ($registros->num_rows() == 0) {
                $data['Mensaje'] = 'No se encontraron registros que cumplan el criterio de b&uacute;squeda';
                $data['VistaPrincipal'] = 'vista_mensaje';
            } else if ($registros->num_rows() == 1) {
				$data['Fila'] = $registros->row();
				$data['ComboTipoUsuario'] = $this->ComboTipoUsuario($data['Fila']->TipoUsuario);
                $data['VistaPrincipal'] = $Vista;
            } else {
                $this->load->library('table');
				$this->table->clear();
				$this->table->set_template( $this->DefinicionTablaSeleccion() );
                $this->table->set_empty("&nbsp;");
                $this->table->set_heading('No.', 'Nombre', 'Nick', 'Acci&oacute;n');
                $i = 0;
                foreach ($registros->result() as $registro)
                    $this->table->add_row(++$i, $registro->Nombre, $registro->Nick, 
                            anchor("usuario/CargaVista/$Vista/" . $registro->CodUsuario, 
                            ($Modificacion==1? ' Modificar ':' Ver '), 
                            array('class'=>($Modificacion==1? 'actualiza':'vista'))). '  '.
                            anchor('usuario/BorrarUsuario/' . $registro->CodUsuario, 'Eliminar', array('class'=>'elimina','onclick'=>"return confirm('Realmente desea borrar este registro?')")));
                $data['Tabla'] = $this->table->generate();
                $data['Vista'] = 'vista_busca_usuario';
                $data['VistaPrincipal'] = 'vista_lista_usuarios';
            }
        } else {
            $data['VistaPrincipal'] = 'vista_busca_usuario';
            $data['Modificacion'] = $Modificacion;            
        }
		$this->load->view('vista_maestra', $data);
    }

    function ModificaUsuario() {
		$this->form_validation->set_rules('Nombre', 'nombre', 'trim|xss_clean');
		$this->form_validation->set_rules('Correo', 'correo', 'trim|xss_clean');
		$this->form_validation->set_rules('Nick', 'nombre de usuario', 'trim|xss_clean');
			
        $data['VistaMenu'] = 'vista_menu_admin';
        if ($this->form_validation->run()) {
            $Accion = $this->input->post("submit");
			if ($Accion == "Guardar") {
                $Activo = $this->input->post('Activo')? 1: 0;
				if ($this->session->userdata('UsuarioPrueba')==1){
					$data['Mensaje'] = $this->funciones->MensajePrueba();
				}else{
					$this->modelo_usuario->Update($this->input->post('CodUsuario'), $this->input->post('Nombre'), $this->input->post('Correo'), 
			                                $this->input->post('Nick'), 
                                            $Activo, $this->input->post('CodTipoUsuario'));
					$data['Mensaje'] = 'Se han modificado los datos del usuario.';
				}
                $data['VistaPrincipal'] = 'vista_mensaje';
            }
            else {
				if ($this->session->userdata('UsuarioPrueba')==1){
					$data['Mensaje'] = $this->funciones->MensajePrueba();
				}else{
					$this->modelo_usuario->Delete($this->input->post('CodUsuario'));
					$data['Mensaje'] = 'Los datos del usuario han sido eliminados';
				}
                $data['VistaPrincipal'] = 'vista_mensaje';
            }
        } else {
            $data['Fila'] = $this->modelo_usuario->getFila($this->input->post('CodUsuario'));
			$data['VistaPrincipal'] = 'vista_modifica_usuario';
        }
		$this->load->view('vista_maestra', $data);
    }

    function CargaVista($Vista, $CodUsuario) {
        $data['VistaMenu'] = 'vista_menu_admin';
        $data['Fila'] = $this->modelo_usuario->getFila($CodUsuario);
        $data['ComboTipoUsuario'] = $this->ComboTipoUsuario($data['Fila']->TipoUsuario);
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

    function BorrarUsuario($CodUsuario) {
		if ($this->session->userdata('UsuarioPrueba')==0)
			$this->modelo_usuario->Delete($CodUsuario);
        redirect('usuario','refresh');
    }
	
	function ComboTipoUsuario($CodTipoUsuario='0') {
        //$resultado = $this->modelo_usuario->TiposUsuario($this->session->userdata('CodInstitucion'));        
		$resultado = $this->modelo_usuario->TiposUsuario(0);      // ago/11:tipo unico  para toda institucion  
        $s = "<select name='CodTipoUsuario' id='CodTipoUsuario' class='required'><option value=''>-Selecci&oacute;n de tipo de usuario-</option>";
        foreach($resultado->result() as $row) 
            $s .= "<option value=".$row->CodTipoUsuario.($CodTipoUsuario==$row->CodTipoUsuario? ' selected ':'').">".$row->Nombre."</option>";
        return $s."</select>";       
	}
	
	function CorreoUnico($Correo) {
		if( $this->modelo_usuario->ExisteCorreo($Correo) ) {
			$this->form_validation->set_message('CorreoUnico', 'Este correo ya se encuentra registrado.');
			return FALSE;
		}
		else
			return TRUE;
	}
	
	function CorreoExiste($Correo) {
		if( $this->modelo_usuario->ExisteCorreo($Correo) )			
			return TRUE;
		else {
			$this->form_validation->set_message('CorreoExiste', 'Este correo no se encuentra registrado en nuestra base de datos.');
			return TRUE;
		}
	}
	
	function NickUnico($Nick) {
		$CodInstitucion = $this->session->userdata('CodInstitucion');
		if( $this->modelo_usuario->ExisteNick($Nick, $CodInstitucion) ) {
			$this->form_validation->set_message('NickUnico', 'Este nombre de usuario no est&aacute; disponible.');
			return FALSE;
		}
		else
			return TRUE;
	}
	
	function EnviaCorreoCambiaClave($Correo, $Clave) {
	
	}
	
	function RestablecerClave() {
		$this->form_validation->set_rules('Correo', 'correo', 'callback_CorreoExiste');
		
        $data['VistaMenu'] = 'vista_menu_admin';
        if ($this->form_validation->run()) {
			$Clave = $this->modelo_usuario->GeneraClaveUnica();
			$this->modelo_usuario->UpdateClave($this->input->post('Correo'), $Clave);
			$msg = 'Tu nueva clave es: $Clave';
			$this->EnviaCorreoCambiaClave($this->input->post('Correo'), $Clave);
			$data['Mensaje'] = "Se ha reestablecido su contrase&ntilde;a. Revise su correo, por favor.";			
			}
            $data['VistaPrincipal'] = 'vista_mensaje';
        } else {
            $data['VistaPrincipal'] = 'vista_restablece_clave';
        }
		$this->load->view('vista_maestra', $data);		
	}
}

?>