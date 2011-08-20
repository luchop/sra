<?php

class Grupo extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->load->model('modelo_grupo', '', TRUE);
		$this->load->library('funciones');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		
		$this->modelo_grupo->SetCodInstitucion($this->session->userdata('CodInstitucion'));
    }

    function Index() {
	    redirect('grupo/NuevoGrupo','refresh');
    }

    function NuevoGrupo() {
		$this->form_validation->set_rules('Nombre', 'nombre', 'xss_clean');

        $data['VistaMenu'] = 'vista_menu_admin';
        if ($this->form_validation->run()) {
		    $Activo = $this->input->post('Activo')? 1: 0;
			if ($this->session->userdata('UsuarioPrueba')==1){
				$data['Mensaje'] = $this->funciones->MensajePrueba();
			}else{
				$CodGrupo = $this->modelo_grupo->Insert($this->input->post('Nombre'), $this->input->post('Correo'), $Activo);
				$data['Mensaje'] = "Se ha registrado un nuevo grupo.";
			}
            $data['VistaPrincipal'] = 'vista_mensaje';
        } else {
            $data['VistaPrincipal'] = 'vista_nuevo_grupo';
        }
		$this->load->view('vista_maestra', $data);	
    }

    function BuscaParaModificar($Modificacion) {
        $this->form_validation->set_rules('Nombre', 'nombre', 'xss_clean');
		
        $data['VistaMenu'] = 'vista_menu_admin';
        if ($this->form_validation->run()) {
            $registros = $this->modelo_grupo->Busqueda($this->input->post('Nombre'), $this->input->post('Correo'));
            if( $Modificacion==1 )
                $Vista = 'vista_modifica_grupo';
            else
                $Vista = 'vista_consulta_grupo';
                
            if ($registros->num_rows() == 0) {
                $data['Mensaje'] = 'No se encontraron registros que cumplan el criterio de b&uacute;squeda';
                $data['VistaPrincipal'] = 'vista_mensaje';
            } else if ($registros->num_rows() == 1) {
				$data['Fila'] = $registros->row();
                $data['VistaPrincipal'] = $Vista;
            } else {
                $this->load->library('table');
				$this->table->set_empty("&nbsp;");
                $this->table->set_heading('No.', 'Nombre', 'Correo', 'Acci&oacute;n');
                $i = 0;
                foreach ($registros->result() as $registro)
                    $this->table->add_row(++$i, $registro->Nombre, $registro->CorreoAdministrador, 
                            anchor("grupo/CargaVista/$Vista/" . $registro->CodGrupo, 
                            ($Modificacion==1? ' Modificar ':' Ver '), 
                            array('class'=>($Modificacion==1? 'actualiza':'vista'))). '  '.
                            anchor('grupo/BorrarGrupo/' . $registro->CodGrupo, 'Eliminar', array('class'=>'elimina','onclick'=>"return confirm('Realmente desea borrar este registro?')")));
                $data['Tabla'] = $this->table->generate();
                $data['Vista'] = 'vista_busca_grupo';
                $data['VistaPrincipal'] = 'vista_lista_grupos';
            }
        } else {
            $data['VistaPrincipal'] = 'vista_busca_grupo';
            $data['Modificacion'] = $Modificacion;            
        }
		$this->load->view('vista_maestra', $data);
    }

    function ModificaGrupo() {
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
					$this->modelo_grupo->Update($this->input->post('CodGrupo'), $this->input->post('Nombre'), $this->input->post('Correo'), $Activo);
					$data['Mensaje'] = 'Se han modificado los datos del grupo.';
				}
                $data['VistaPrincipal'] = 'vista_mensaje';
            }
            else {
				if ($this->session->userdata('UsuarioPrueba')==1){
					$data['Mensaje'] = $this->funciones->MensajePrueba();
				}else{
					$this->modelo_grupo->Delete($this->input->post('CodGrupo'));
					$data['Mensaje'] = 'Los datos del grupo han sido eliminados';
				}
                $data['VistaPrincipal'] = 'vista_mensaje';
            }
        } else {
            $data['Fila'] = $this->modelo_grupo->getFila($this->input->post('CodGrupo'));
			$data['VistaPrincipal'] = 'vista_modifica_grupo';
        }
		$this->load->view('vista_maestra', $data);
    }

    function CargaVista($Vista, $CodGrupo) {
        $data['VistaMenu'] = 'vista_menu_admin';
        $data['Fila'] = $this->modelo_grupo->getFila($CodGrupo);
		$data['VistaPrincipal'] = $Vista;
        $this->load->view('vista_maestra', $data);
    }

    function BorrarGrupo($CodGrupo) {
		if ($this->session->userdata('UsuarioPrueba')==0)
			$this->modelo_grupo->Delete($CodGrupo);
        redirect('grupo','refresh');
    }

}

?>