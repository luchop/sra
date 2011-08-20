<?php

class Portal extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation', 'session'));
        $this->load->model('modelo_participante', '', TRUE);
		$this->session->set_userdata('CodInstitucion', 1);
		$this->session->set_userdata('CodEvento', 1);
    }

    function Index() {
		$data['VistaPrincipal'] = 'vista_portal';
        $this->load->view('vista_maestra', $data);
    }
	
	function Inscripcion() {
		$data['Fecha'] = date('d/m/Y');
		$data['Tarjetas'] = $this->load->view('vista_tarjetas', '', true);
		$data['ComboCDU'] = $this->modelo_participante->ComboCDU();
		$data['VistaPrincipal'] = 'vista_nuevo_participante';
        $this->load->view('vista_maestra', $data);
    }
	
	function Participantes() {
		$CodInstitucion = $this->session->userdata('CodInstitucion');
		$CodEvento = $this->session->userdata('CodEvento');
		$data['CodInstitucion'] = $CodInstitucion;
		$data['Tarjetas'] = $this->load->view('vista_tarjetas', '', true);
		$data['ListaParticipantes'] = $this->modelo_participante->ListaParticipantes($CodInstitucion, $CodEvento);
		$data['VistaPrincipal'] = 'vista_participantes';
        $this->load->view('vista_maestra', $data);
    }
    
    function Salir() {
        $this->session->unset_userdata('CodUsuario');
        $this->session->sess_destroy();
        redirect(base_url().'index.php');
    }
}

?>