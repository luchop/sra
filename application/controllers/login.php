<?php

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->load->model('modelo_usuario', '', true);
		$this->session->set_userdata('CodInstitucion', 14);
    }

	function Index() {
		$data['VistaPrincipal'] = 'vista_login';
        $this->load->view('vista_maestra', $data);
    }
	
	function Autentificacion() {
		$this->form_validation->set_rules('Nick', '"nombre de usuario"', 'required');
		
		$data['VistaPrincipal'] = 'vista_login';
		if($this->form_validation->run()) {
			if( $this->modelo_usuario->ExisteUsuario($this->input->post('Nick'), $this->input->post('Clave'), $this->session->userdata('CodInstitucion'),
			                                         $CodUsuario, $Nombre, $TipoUsuario) ) {
				$UsuarioPrueba=($TipoUsuario<0)?1:0;
				$TipoUsuario=abs($TipoUsuario);
				$this->session->set_userdata(array('CodUsuario' => $CodUsuario, 'Nombre' => $Nombre, 'TipoUsuario' => $TipoUsuario, 'UsuarioPrueba' => $UsuarioPrueba));
				$data['NombreUsuario'] = $Nombre;
				if($TipoUsuario=='0')
					$data['VistaMenu'] = 'vista_menu_super';
				else if($TipoUsuario=='1')
					$data['VistaMenu'] = 'vista_menu_admin';
				else if($TipoUsuario=='2')
					$data['VistaMenu'] = 'vista_menu_operador1';
				else if($TipoUsuario=='3')
					$data['VistaMenu'] = 'vista_menu_operador2';
			} else 
				$data['Error'] = "<span class='error' >Nombre o contrase&ntilde;a incorrecta.</span><br />";
		}
		$this->load->view('vista_maestra', $data);
	}
	
	function Salir() {
        $this->session->unset_userdata('CodUsuario');
		$this->session->unset_userdata('Nombre');
		$this->session->unset_userdata('TipoUsuario');
		$this->session->unset_userdata('UsuarioPrueba');
        $this->session->sess_destroy();
        redirect(base_url().'index.php/login');
    } 
}

?>