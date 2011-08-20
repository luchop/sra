<?php
class Cambia_clave extends CI_Controller {
	
	private $Menu; 
	
	function __construct() {
		parent::__construct();
		$this->load->model('modelo_usuario', '', TRUE);
		$this->load->library('funciones');
		$TipoUsuario = $this->session->userdata('TipoUsuario');
		$this->Menu = $this->funciones->ObtieneVista($TipoUsuario);
	}
	
	function index() {
        $this->form_validation->set_rules('ClaveActual', '"contrase&ntilde;a actual"', 'required|min_length[5]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('NuevaClave1', '"nueva contrase&ntilde;a"', 'required|min_length[5]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('NuevaClave2', '"confirmaci&oacute;n de contrase&ntilde;a"', 'required|matches[NuevaClave1]|xss_clean');
		$this->form_validation->set_error_delimiters('<p class="error">','</p>');
		
		$data['VistaMenu'] = $this->Menu;
		if( $this->form_validation->run() ) {
		    $CodUsuario = $this->session->userdata('CodUsuario');
            if( $this->modelo_usuario->ClaveCorrespondeUsuario($this->input->post('ClaveActual'), $CodUsuario) )  {
				if ($this->session->userdata('UsuarioPrueba')==1){
					$data['Mensaje'] = $this->funciones->MensajePrueba();
				}else{
					$this->modelo_usuario->CambiaClave( $CodUsuario, $this->input->post('NuevaClave1'));
					$data['Mensaje'] = 'La contrase&ntilde;a ha sido cambiada correctamente.';
				}
			} else 
				$data['Mensaje'] = 'Contrase&ntilde;a incorrecta';
			$data['VistaPrincipal'] = 'vista_mensaje';
        } else  {
            $data['VistaPrincipal'] = 'vista_cambia_clave';
        }
        $this->load->view('vista_maestra', $data);
	}
}
?>