<?php

class Sala extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->load->model('modelo_sala', '', TRUE);
		$this->load->model('modelo_grupo', '', TRUE);
		$this->load->library('funciones');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		
		$CodInstitucion=$this->session->userdata('CodInstitucion');
		$this->modelo_sala->SetCodInstitucion($CodInstitucion);
		$this->modelo_grupo->SetCodInstitucion($CodInstitucion);
    }

    function Index() {
	    redirect('sala/NuevaSala','refresh');
    }

    function NuevaSala() {
		$this->form_validation->set_rules('Nombre', 'nombre', 'xss_clean');

        $data['VistaMenu'] = 'vista_menu_admin';
        if ($this->form_validation->run()) {
		    $Activo = $this->input->post('Activo')? 1: 0;
			if ($this->session->userdata('UsuarioPrueba')==1){
				$data['Mensaje'] = $this->funciones->MensajePrueba();
			}else{
				$CodSala = $this->modelo_sala->Insert($this->input->post('Nombre'),$this->input->post('Descripcion'), $this->input->post('CodGrupo'), $this->input->post('Capacidad'), $this->input->post('Correo'), $Activo, $this->input->post('Orden'));
				$data['Mensaje'] = "Se ha registrado una nueva sala.";
			}
            $data['VistaPrincipal'] = 'vista_mensaje';
        } else {
            $data['ComboGrupos'] = $this->modelo_grupo->ComboGrupos(set_value('CodGrupo'));
            $data['VistaPrincipal'] = 'vista_nueva_sala';
        }
		$this->load->view('vista_maestra', $data);	
    }

    function BuscaParaModificar($Modificacion) {
        $this->form_validation->set_rules('Nombre', 'nombre', 'xss_clean');
		
        $data['VistaMenu'] = 'vista_menu_admin';
        if ($this->form_validation->run()) {
            $registros = $this->modelo_sala->Busqueda($this->input->post('Nombre'), $this->input->post('Correo'));
            if( $Modificacion==1 )
                $Vista = 'vista_modifica_sala';
            else
                $Vista = 'vista_consulta_sala';
                
            if ($registros->num_rows() == 0) {
                $data['Mensaje'] = 'No se encontraron registros que cumplan el criterio de b&uacute;squeda';
                $data['VistaPrincipal'] = 'vista_mensaje';
            } else if ($registros->num_rows() == 1) {
				$data['Fila'] = $registros->row();
				$data['ComboGrupos'] = $this->modelo_grupo->ComboGrupos($data['Fila']->CodGrupo);
                $data['VistaPrincipal'] = $Vista;
            } else {
                $this->load->library('table');
				$this->table->set_empty("&nbsp;");
                $this->table->set_heading('No.', 'Nombre', 'Capacidad', 'Correo', 'Acci&oacute;n');
                $i = 0;
                foreach ($registros->result() as $registro)
                    $this->table->add_row(++$i, $registro->Nombre, $registro->Capacidad, $registro->CorreoAdministrador, 
                            anchor("sala/CargaVista/$Vista/" . $registro->CodSala, 
                            ($Modificacion==1? ' Modificar ':' Ver '), 
                            array('class'=>($Modificacion==1? 'actualiza':'vista'))). '  '.
                            anchor('sala/BorrarSala/' . $registro->CodSala, 'Eliminar', array('class'=>'elimina','onclick'=>"return confirm('Realmente desea borrar este registro?')")));
                $data['Tabla'] = $this->table->generate();
                $data['Vista'] = 'vista_busca_sala';
                $data['VistaPrincipal'] = 'vista_lista_salas';
            }
        } else {
            $data['VistaPrincipal'] = 'vista_busca_sala';
            $data['Modificacion'] = $Modificacion;            
        }
		$this->load->view('vista_maestra', $data);
    }

    function ModificaSala() {
		$this->form_validation->set_rules('Nombre', 'nombre', 'trim|xss_clean');
		$this->form_validation->set_rules('Correo', 'correo', 'trim|xss_clean');

        $data['VistaMenu'] = 'vista_menu_admin';
        if ($this->form_validation->run()) {
            $Accion = $this->input->post("submit");
			if ($Accion == "Guardar") {
                $Activo = $this->input->post('Activo')? 1: 0;
				if ($this->session->userdata('UsuarioPrueba')==1){
					$data['Mensaje'] = $this->funciones->MensajePrueba();
				}else{
					$this->modelo_sala->Update($this->input->post('CodSala'), $this->input->post('Nombre'), $this->input->post('Descripcion'), 
												$this->input->post('CodGrupo'), $this->input->post('Capacidad'), $this->input->post('Correo'), 
												$Activo, $this->input->post('Orden'));
					$data['Mensaje'] = 'Se han modificado los datos de la sala.';
				}
                $data['VistaPrincipal'] = 'vista_mensaje';
            }
            else {
				if ($this->session->userdata('UsuarioPrueba')==1){
					$data['Mensaje'] = $this->funciones->MensajePrueba();
				}else{
					$this->modelo_sala->Delete($this->input->post('CodSala'));
					$data['Mensaje'] = 'Los datos de la sala han sido eliminados';
				}
                $data['VistaPrincipal'] = 'vista_mensaje';
            }
        } else {
            $data['Fila'] = $this->modelo_sala->getFila($this->input->post('CodSala'));
			$data['VistaPrincipal'] = 'vista_modifica_sala';
        }
		$this->load->view('vista_maestra', $data);
    }

    function CargaVista($Vista, $CodSala) {
        $data['VistaMenu'] = 'vista_menu_admin';
        $data['Fila'] = $this->modelo_sala->getFila($CodSala);
		$data['ComboGrupos'] = $this->modelo_grupo->ComboGrupos($data['Fila']->CodGrupo);
		$data['NombreGrupo'] = $this->modelo_grupo->NombreGrupo($data['Fila']->CodGrupo);
		$data['VistaPrincipal'] = $Vista;
        $this->load->view('vista_maestra', $data);
    }

    function BorrarSala($CodSala) {
		if ($this->session->userdata('UsuarioPrueba')==0)
			$this->modelo_sala->Delete($CodSala);
        redirect('sala','refresh');
    }

	function CorreoUnico($Correo) {
		if( $this->modelo_sala->ExisteCorreo($Correo) ) {
			$this->form_validation->set_message('CorreoUnico', 'Este correo ya se encuentra registrado.');
			return FALSE;
		}
		else
			return TRUE;
	}

}

?>