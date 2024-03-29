<?php

class Configuracion extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('modelo_valores', '', TRUE);
		$this->load->library('funciones');
		$this->modelo_valores->SetCodInstitucion($this->session->userdata('CodInstitucion'));
    }

    function Index() {
        $data['VistaPrincipal'] = 'vista_menu_admin';
        $this->load->view('vista_maestra', $data);
    }
	
	function Identificacion() {
        // reglas de validacion
        $this->form_validation->set_rules('Linea1', '"Linea 1"', 'xss_clean');
		$this->form_validation->set_rules('Linea2', '"Linea 2"', 'xss_clean');
		$this->form_validation->set_rules('Linea3', '"Linea 3"', 'xss_clean');
		
        $data['Linea1'] = $this->modelo_valores->GetTexto( 'LINEA1' );
		$data['Linea2'] = $this->modelo_valores->GetTexto( 'LINEA2' );
		$data['Linea3'] = $this->modelo_valores->GetTexto( 'LINEA3' );
		$data['ImprimirId'] = $this->modelo_valores->GetNumero( 'IMPRIMIRID' );
		
		$data['VistaMenu'] = 'vista_menu_admin';
        if( $this->form_validation->run() ) {
			if ($this->session->userdata('UsuarioPrueba')==1){
				$data['Mensaje'] = $this->funciones->MensajePrueba();
			}else{
				$this->modelo_valores->SetTexto( 'LINEA1', $this->input->post('Linea1'));
				$this->modelo_valores->SetTexto( 'LINEA2', $this->input->post('Linea2'));
				$this->modelo_valores->SetTexto( 'LINEA3', $this->input->post('Linea3'));
				$this->modelo_valores->SetNumero( 'IMPRIMIRID', $this->input->post('ImprimirId'));
				$data['Mensaje'] = 'La identificaci&oacute;n de la instituci&oacute;n ha sido registrada.';
			}
            $data['VistaPrincipal'] = 'vista_mensaje';            
        }
        else           
            $data['VistaPrincipal'] = 'vista_identificacion';
        $this->load->view('vista_maestra', $data);
	}
	
	function Rotulos() {
        // reglas de validacion
        $this->form_validation->set_rules('Rotulo1', '"Articulo"', 'xss_clean');
		$this->form_validation->set_rules('Rotulo2', '"Marca"', 'xss_clean');
		$this->form_validation->set_rules('Rotulo3', '"Modelo"', 'xss_clean');
		
        $data['Rotulo1'] = $this->modelo_valores->GetTexto( 'ROTULO1' );
		$data['Rotulo2'] = $this->modelo_valores->GetTexto( 'ROTULO2' );
		$data['Rotulo3'] = $this->modelo_valores->GetTexto( 'ROTULO3' );
		
		$data['VistaMenu'] = 'vista_menu_admin';
        if( $this->form_validation->run() ) {
			if ($this->session->userdata('UsuarioPrueba')==1){
				$data['Mensaje'] = $this->funciones->MensajePrueba();
			}else{
				$this->modelo_valores->SetTexto( 'ROTULO1', $this->input->post('Rotulo1'));
				$this->modelo_valores->SetTexto( 'ROTULO2', $this->input->post('Rotulo2'));
				$this->modelo_valores->SetTexto( 'ROTULO3', $this->input->post('Rotulo3'));
				$data['Mensaje'] = 'Los nuevos r&oacute;tulos han sido registrados.';
			}
            $data['VistaPrincipal'] = 'vista_mensaje';
        }
        else         
            $data['VistaPrincipal'] = 'vista_rotulos';
        $this->load->view('vista_maestra', $data);
	}
    
}

?>