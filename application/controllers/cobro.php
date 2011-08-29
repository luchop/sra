<?php

class Cobro extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->load->model('modelo_cobro', '', TRUE);
		$this->load->library('funciones');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		
		$CodInstitucion=$this->session->userdata('CodInstitucion');
		$this->modelo_cobro->SetCodInstitucion($CodInstitucion);
		
		$this->CodAlCuota=1;
    }

    function Index() {
	    redirect('cobro/NuevoCobro','refresh');
    }

    function NuevoCobro() {
		$this->form_validation->set_rules('Monto', 'monto', 'xss_clean');

        $data['VistaMenu'] = 'vista_menu_admin';
		$data['Fecha']=date('d/m/Y');
        if ($this->form_validation->run()) {
			$TalonarioF = $this->input->post('TalonarioF')? 1: 0;
			if ($this->session->userdata('UsuarioPrueba')==1){
				$data['Mensaje'] = $this->funciones->MensajePrueba();
			}else{
				$Fecha=$this->funciones->FechaParaMySQL($this->input->post('Fecha'));
				$CodCobro = $this->modelo_cobro->Insert($this->CodAlCuota,$Fecha,$this->input->post('Monto'), $this->input->post('Factura'), $TalonarioF, $this->input->post('Detalle'));
				$data['Mensaje'] = "Se ha registrado un nuevo cobro.";
			}
            $data['VistaPrincipal'] = 'vista_mensaje';
        } else {
            $data['VistaPrincipal'] = 'vista_nuevo_cobro';
        }
		$this->load->view('vista_maestra', $data);	
    }

    function BuscaParaModificar($Modificacion) {
        $this->form_validation->set_rules('Monto', 'monto', 'xss_clean');
		
        $data['VistaMenu'] = 'vista_menu_admin';
        if ($this->form_validation->run()) {
            $registros = $this->modelo_cobro->Busqueda($this->input->post('Detalle'));
            if( $Modificacion==1 )
                $Vista = 'vista_modifica_cobro';
            else
                $Vista = 'vista_consulta_cobro';
                
            if ($registros->num_rows() == 0) {
                $data['Mensaje'] = 'No se encontraron registros que cumplan el criterio de b&uacute;squeda';
                $data['VistaPrincipal'] = 'vista_mensaje';
            } else if ($registros->num_rows() == 1) {
				$data['Fila'] = $registros->row();
                $data['VistaPrincipal'] = $Vista;
            } else {
                $this->load->library('table');
				$this->table->set_empty("&nbsp;");
                $this->table->set_heading('No.', 'Fecha', 'Monto', 'Acci&oacute;n');
                $i = 0;
                foreach ($registros->result() as $registro)
                    $this->table->add_row(++$i, $this->funciones->FechaLiteral($registro->Fecha), $registro->Monto, 
                            anchor("cobro/CargaVista/$Vista/" . $registro->CodCobro, 
                            ($Modificacion==1? ' Modificar ':' Ver '), 
                            array('class'=>($Modificacion==1? 'actualiza':'vista'))). '  '.
                            anchor('cobro/BorrarCobro/' . $registro->CodCobro, 'Eliminar', array('class'=>'elimina','onclick'=>"return confirm('Realmente desea borrar este registro?')")));
                $data['Tabla'] = $this->table->generate();
                $data['Vista'] = 'vista_busca_sala';
                $data['VistaPrincipal'] = 'vista_lista_salas';
            }
        } else {
            $data['VistaPrincipal'] = 'vista_busca_cobro';
            $data['Modificacion'] = $Modificacion;            
        }
		$this->load->view('vista_maestra', $data);
    }

    function ModificaCobro() {
		$this->form_validation->set_rules('Monto', 'monto', 'trim|xss_clean');

        $data['VistaMenu'] = 'vista_menu_admin';
        if ($this->form_validation->run()) {
            $Accion = $this->input->post("submit");
			if ($Accion == "Guardar") {
				$TalonarioF = $this->input->post('TalonarioF')? 1: 0;
                if ($this->session->userdata('UsuarioPrueba')==1){
					$data['Mensaje'] = $this->funciones->MensajePrueba();
				}else{
					$Fecha=$this->funciones->FechaParaMySQL($this->input->post('Fecha'));
					$this->modelo_cobro->Update($this->input->post('CodCobro'),$this->CodAlCuota,$Fecha,$this->input->post('Monto'), 
										$this->input->post('Factura'), $TalonarioF, $this->input->post('Detalle'));
					$data['Mensaje'] = 'Se han modificado los datos del cobro.';
				}
                $data['VistaPrincipal'] = 'vista_mensaje';
            }
            else {
				if ($this->session->userdata('UsuarioPrueba')==1){
					$data['Mensaje'] = $this->funciones->MensajePrueba();
				}else{
					$this->modelo_cobro->Delete($this->input->post('CodCobro'));
					$data['Mensaje'] = 'Los datos del cobro han sido eliminados';
				}
                $data['VistaPrincipal'] = 'vista_mensaje';
            }
        } else {
            $data['Fila'] = $this->modelo_cobro->getFila($this->input->post('CodCobro'));
			$data['VistaPrincipal'] = 'vista_modifica_cobro';
        }
		$this->load->view('vista_maestra', $data);
    }

    function CargaVista($Vista, $CodCobro) {
        $data['VistaMenu'] = 'vista_menu_admin';
        $data['Fila'] = $this->modelo_cobro->getFila($CodCobro);
		$data['VistaPrincipal'] = $Vista;
        $this->load->view('vista_maestra', $data);
    }

    function BorrarCobro($CodCobro) {
		if ($this->session->userdata('UsuarioPrueba')==0)
			$this->modelo_cobro->Delete($CodCobro);
        redirect('cobro','refresh');
    }

}

?>