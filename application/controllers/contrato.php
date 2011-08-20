<?php

class Contrato extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('modelo_contrato', '', TRUE);
		$this->load->model('modelo_institucion', '', TRUE);			
		$this->load->model('modelo_valores', '', TRUE);			
    }

    function Index() {
	    $data['VistaPrincipal'] = 'vista_menu_super';
        $this->load->view('vista_maestra', $data);
    }

    function NuevoContrato() {
		$this->form_validation->set_rules('CodInstitucion', 'institucion', 'xss_clean');
        $this->form_validation->set_rules('Desde', 'fecha inicial', 'xss_clean');
		$this->form_validation->set_rules('Hasta', 'fecha final', 'xss_clean');
		$this->form_validation->set_rules('Precio', 'precio', 'xss_clean');
		
        $data['VistaMenu'] = 'vista_menu_super';
		$data['Desde'] = date('d/m/Y');
		$data['Hasta'] = date('d/m/Y');
        if ($this->form_validation->run()) {
		    $Desde = $this->funciones->FechaParaMySQL($this->input->post('Desde'));
			$Hasta = $this->funciones->FechaParaMySQL($this->input->post('Hasta'));
			$CodContrato = $this->modelo_contrato->Insert($this->input->post('CodInstitucion'), $Desde,
                                            $Hasta,$this->input->post('Precio'), $this->input->post('Notas'));
            $data['Mensaje'] = 'Se ha registrado un nuevo contrato.';
            $data['VistaPrincipal'] = 'vista_mensaje';
        } else {
           	$data['ComboInstituciones'] = $this->modelo_institucion->ComboInstituciones($this->input->post('CodInstitucion'));
            $data['VistaPrincipal'] = 'vista_nuevo_contrato';
        }
		$this->load->view('vista_maestra', $data);	
    }

    function BuscaParaModificar($Modificacion) {
        $this->form_validation->set_rules('CodInstitucion', 'instituci&oacute;n', 'xss_clean');
        $this->form_validation->set_rules('Desde', 'fecha inicial', 'xss_clean');
		$this->form_validation->set_rules('Hasta', 'fecha final', 'xss_clean');
		
        $data['VistaMenu'] = 'vista_menu_super';
		$data['ComboInstituciones'] = $this->modelo_institucion->ComboInstituciones('', 0);
        if ($this->form_validation->run()) {
            $Desde = $this->funciones->FechaParaMySQL($this->input->post('Desde'));
			$Hasta = $this->funciones->FechaParaMySQL($this->input->post('Hasta'));

			$registros = $this->modelo_contrato->Busqueda($this->input->post('CodInstitucion'),
                                                $Desde, $Hasta);

            if( $Modificacion==1 )
                $Vista = 'vista_modifica_contrato';
            else
                $Vista = 'vista_consulta_contrato';
                
            if ($registros->num_rows() == 0) {
                $data['Mensaje'] = 'No se encontraron registros que cumplan el criterio de b&uacute;squeda';
                $data['VistaPrincipal'] = 'vista_mensaje';
				$this->load->view('vista_maestra', $data);
            } else if ($registros->num_rows() == 1) {            //solo un registro encontrado
                $data['Fila'] = $registros->row();
				$data['ComboInstituciones'] = $this->modelo_institucion->ComboInstituciones($data['Fila']->CodInstitucion);
                $data['VistaPrincipal'] = $Vista;                      //'vista_modifica_contrato' o 'vista_consulta_contrato';
                $this->load->view('vista_maestra', $data);
            } else {                                             // varios registros encontrados: muestra lista
                $this->load->library('table');
                $this->table->set_empty("&nbsp;");
                $this->table->set_heading('No.', 'Nombre de la institucion', 'Desde ', 'Hasta', 'Acci&oacute;n');
                $aux = array('table_open' => '<table class="tablaseleccion">');
                $this->table->set_template($aux);
                $i = 0;
                foreach ($registros->result() as $registro)
                    $this->table->add_row(++$i, $registro->Nombre, $registro->Desde, $registro->Hasta,
                            anchor("contrato/CargaVista/$Vista/" . $registro->CodContrato, 
                            ($Modificacion=='TRUE'? ' Modificar ':' Ver '), 
                            array('class'=>($Modificacion=='TRUE'? 'actualiza':'vista'))). '  '.
                            anchor('contrato/BorrarContrato/' . $registro->CodContrato, 'Eliminar', array('class'=>'elimina','onclick'=>"return confirm('Realmente desea borrar este registro?')")));
                $data['Tabla'] = $this->table->generate();
                $data['Vista'] = 'vista_busca_contrato';
                $data['VistaPrincipal'] = 'vista_lista_contratos';
                $this->load->view('vista_maestra', $data);
            }
        } else {
            $data['VistaPrincipal'] = 'vista_busca_contrato';
            $data['Modificacion'] = $Modificacion;            
			$this->load->view('vista_maestra', $data);
        }
    }

    function ModificaContrato() {
		$this->form_validation->set_rules('CodInstitucion', 'institucion', 'xss_clean');
        $this->form_validation->set_rules('Desde', 'fecha inicial', 'xss_clean');
		$this->form_validation->set_rules('Hasta', 'fecha final', 'xss_clean');
		$this->form_validation->set_rules('Precio', 'precio', 'xss_clean');
		
        $data['VistaMenu'] = 'vista_menu_super';
        if ($this->form_validation->run()) {
            $Accion = $this->input->post("submit");
            if ($Accion == "Guardar") {
                $Desde = $this->funciones->FechaParaMySQL($this->input->post('Desde'));
				$Hasta = $this->funciones->FechaParaMySQL($this->input->post('Hasta'));
				$this->modelo_contrato->Update($this->input->post('CodContrato'), $this->input->post('CodInstitucion'), $Desde,
												$Hasta,$this->input->post('Precio'), $this->input->post('Notas'));
				$data['Mensaje'] = 'Se han modificado los datos del contrato.';
                $data['VistaPrincipal'] = 'vista_mensaje';
            }
            else {
                $this->modelo_contrato->Delete($this->input->post('CodContrato'));
                $data['Mensaje'] = 'Los datos del contrato han sido eliminados';
                $data['VistaPrincipal'] = 'vista_mensaje';
            }
        } else {
            $data['Fila'] = $this->modelo_contrato->getFila($this->input->post('CodContrato'));
			$data['ComboInstituciones'] = $this->modelo_institucion->ComboInstituciones();
			$data['VistaPrincipal'] = 'vista_modifica_contrato';
        }
		$this->load->view('vista_maestra', $data);
    }

    function CargaVista($Vista, $CodContrato) {
        $data['VistaMenu'] = 'vista_menu_super';
        $data['Fila'] = $this->modelo_contrato->getFila($CodContrato);
        $data['ComboInstituciones'] = $this->modelo_institucion->ComboInstituciones($data['Fila']->CodInstitucion);
        $data['VistaPrincipal'] = $Vista;
        $this->load->view('vista_maestra', $data);
    }

    function BorrarContrato($CodContrato) {
        $this->modelo_contrato->Delete($CodContrato);
        redirect('contrato','refresh');
    }
    
    function MenuContratos() {
        $data['VistaMenu'] = 'vista_menu_administrador';
        $this->load->view('vista_maestra', $data);
    }    
	
	function Boletin() {
		$CodContrato = $this->modelo_contrato->GetCodContrato($this->session->userdata('CodUsuario'));
		$data['VistaMenu'] = 'vista_menu_contrato';
		if( $this->modelo_contrato->CuotasAlDia($CodContrato) ) {
			$Trimestre = $this->modelo_valores->GetNumero('TRIMESTRE');			
			$data['VistaPrincipal'] = 'vista_boletin';
			$data['TablaNotas'] = $this->modelo_contrato->TablaNotas($CodContrato);
			$data['TablaHabitos'] = $this->modelo_contrato->TablaHabitos($CodContrato);
			$data['Observaciones'] = $this->modelo_contrato->Observaciones($CodContrato, $Trimestre);
		} else {
		    $data['VistaPrincipal'] = 'vista_mensaje';
			$data['Mensaje'] = 'No puede ver este bolet&iacute;n porque el contrato tiene cuotas en mora. ';
		}
		$this->load->view('vista_maestra', $data);
	}
	
	function Historial() {
		$CodContrato = $this->modelo_contrato->GetCodContrato($this->session->userdata('CodUsuario'));
		$data['CodContrato'] = $CodContrato;
		$data['VistaMenu'] = 'vista_menu_contrato';
		$data['VistaPrincipal'] = 'vista_historial';
		$data['TablaHistorial'] = $this->modelo_contrato->TablaHistorial($CodContrato);
		$this->load->view('vista_maestra', $data);
	}
	
	function HistorialPDF() {
		$this->load->library('fpdf');
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));
		$CodContrato = $this->modelo_contrato->GetCodContrato($this->session->userdata('CodUsuario'));
		$data['CodContrato'] = $CodContrato;

		$data['TablaHistorial'] = $this->modelo_contrato->getHistorial($CodContrato);
		$data['Linea1'] =  $this->modelo_valores->GetTexto('LINEA1'); 
		$data['Linea2'] =  $this->modelo_valores->GetTexto('LINEA2');
		$data['Linea3'] =  $this->modelo_valores->GetTexto('LINEA3');
		$Fila = $this->modelo_contrato->getFila($CodContrato);
		$data['NombreContrato'] = $Fila->Nombres." ".$Fila->Paterno." ".$Fila->Materno;
		$data['NombreCurso'] = $Fila->NombreCurso;
		$this->load->view('vista_historial_pdf', $data);
	}
	
	function BoletinPDF() {
		$this->load->library('fpdf');
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));
		$Trimestre = $this->modelo_valores->GetNumero('TRIMESTRE');
		$CodContrato = $this->modelo_contrato->GetCodContrato($this->session->userdata('CodUsuario'));
		
		$data['Notas'] = $this->modelo_contrato->getNotas($CodContrato);
		$data['Habitos'] = $this->modelo_contrato->getHabitos($CodContrato);
		$data['Observaciones'] = $this->modelo_contrato->getObservaciones($CodContrato, $Trimestre);
		
		$data['Linea1'] =  $this->modelo_valores->GetTexto('LINEA1'); 
		$data['Linea2'] =  $this->modelo_valores->GetTexto('LINEA2');
		$data['Linea3'] =  $this->modelo_valores->GetTexto('LINEA3');
		$Fila = $this->modelo_contrato->getFila($CodContrato);
		$data['NombreContrato'] = $Fila->Nombres." ".$Fila->Paterno." ".$Fila->Materno;
		$data['NombreCurso'] = $Fila->NombreCurso;
		$this->load->view('vista_contrato_boleta', $data);
	}
	
	function NotasDiarias() {
		$this->form_validation->set_rules('DesdeFecha', '"fecha inicial"', 'required|valid_date');
		$this->form_validation->set_rules('HastaFecha', '"fecha final"', 'required|valid_date');
		
		$CodContrato = $this->modelo_contrato->GetCodContrato($this->session->userdata('CodUsuario'));
		$CodCurso = $this->modelo_contrato->GetCodCurso($CodContrato);
		$data['NombreCurso'] = $this->modelo_curso->GetNombre($CodCurso);
		
		$data['DesdeFecha'] = strtotime("now -10 days");
		$data['HastaFecha'] = strtotime("now");
		if ( $this->form_validation->run() ) {
			$DesdeFecha = $this->input->post("DesdeFecha");
			$HastaFecha = $this->input->post("HastaFecha");
			$Accion = $this->input->post("submit");
			$AuxFecha1 = date('Y-m-d', $DesdeFecha);
			$AuxFecha2 = date('Y-m-d', $HastaFecha);
			if ($Accion == " << ") {
				$DesdeFecha = strtotime("$AuxFecha -1 day");
			}
			else {
				$Fecha = strtotime("$AuxFecha +1 day");
			}
			$data['Fecha'] = $Fecha;
		}
		//timestamp a fecha 
		$AuxFecha = date('Y-m-d', $data['Fecha']);
		$data['FechaLiteral'] = $this->funciones->FechaLiteral($AuxFecha, 4);
		$data['TablaTareas'] = $this->modelo_tarea->TablaTareas($CodCurso, $AuxFecha);
		$data['VistaMenu'] = 'vista_menu_contrato';
		$data['VistaPrincipal'] = 'vista_tareas';
		$this->load->view('vista_maestra', $data);
	}
}

?>