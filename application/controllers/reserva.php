<?php

class Reserva extends CI_Controller {

	private $RangoHoras;
	private $HoraInicioCombo;
	private $HoraFinCombo;

    function __construct() {
        parent::__construct();
		$this->load->model('modelo_repeticion', '', TRUE);
		$this->load->model('modelo_reserva', '', TRUE);
		$this->load->model('modelo_sala', '', TRUE);
		$this->load->library('funciones');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		
		$CodInstitucion=$this->session->userdata('CodInstitucion');
		$this->modelo_sala->SetCodInstitucion($CodInstitucion);
		$this->modelo_reserva->SetCodInstitucion($CodInstitucion);
		$this->modelo_repeticion->SetCodInstitucion($CodInstitucion);
		
		$CodUsuario=0;
		$this->modelo_reserva->SetCodUsuario($CodUsuario);
		$this->modelo_repeticion->SetCodUsuario($CodUsuario);
		
		//Periodo de tiempo entre horas del combo
		$this->RangoHoras='00:30';
		//Horas en las que inicio el combo de seleccion de hora
		$this->HoraInicioCombo='7:00';
		$this->HoraFinCombo='21:00';
    }

    function Index() {
	    redirect('reserva/NuevaReserva','refresh');
    }

    function NuevaReserva() {
		$this->form_validation->set_rules('Nombre', 'nombre', 'xss_clean');

        $data['VistaMenu'] = 'vista_menu_admin';
		$data['Fecha'] = date('d/m/Y');
        if ($this->form_validation->run()) {
		    $Estado = $this->input->post('Estado')? 1: 0;
			if ($this->session->userdata('UsuarioPrueba')==1){
				$data['Mensaje'] = $this->funciones->MensajePrueba();
			}else{
				$CodRepeticion=0;
				$Comienzo=explode('/',$this->input->post('Comienzo'));
				$FechaInicio=mktime(0,0,0, $Comienzo[1],$Comienzo[0],$Comienzo[2]);
				$Final=explode('/',$this->input->post('FechaFinal'));
				$FechaFinal=mktime(0,0,0, $Final[1],$Final[0],$Final[2]);
				$HoraInicio=$this->input->post('HoraInicio')+$FechaInicio;
				$HoraFin=$this->input->post('HoraFin')+$FechaInicio;
				$DiaCompleto = $this->input->post('DiaCompleto')? 1: 0;
				$DiasSemana = (($this->input->post('DiasSemana_1'))?1:0).(($this->input->post('DiasSemana_2'))?1:0).(($this->input->post('DiasSemana_3'))?1:0).(($this->input->post('DiasSemana_4'))?1:0).(($this->input->post('DiasSemana_5'))?1:0).(($this->input->post('DiasSemana_6'))?1:0).(($this->input->post('DiasSemana_7'))?1:0);
				if ($this->input->post('Repeticion')!='N'){
					$CodRepeticion=$this->modelo_repeticion->Insert($this->input->post('Nombre'), $this->input->post('Descripcion'), $Estado, $this->input->post('CodSala'), $HoraInicio, $HoraFin, $DiaCompleto, $FechaFinal, $DiasSemana, $this->input->post('Repeticion'));
				}
				$CodReserva = $this->modelo_reserva->Insert($this->input->post('Nombre'), $this->input->post('Descripcion'), $Estado, $this->input->post('CodSala'), $HoraInicio, $HoraFin, $CodRepeticion);
				$data['Mensaje'] = "Se ha registrado una nueva reserva.";
			}
            $data['VistaPrincipal'] = 'vista_mensaje';
        } else {
			$data['ComboSalas'] = $this->modelo_sala->ComboSalas(set_value('CodSala'));
			$data['ComboHoras'] = $this->ComboHoras();
			$data['DiasSemana'] = $this->DiasSemana();
			$data['Repeticiones'] = $this->TiposRepeticion();
            $data['VistaPrincipal'] = 'vista_nueva_reserva';
        }
		$this->load->view('vista_maestra', $data);	
    }

    function BuscaParaModificar($Modificacion) {
        $this->form_validation->set_rules('Nombre', 'nombre', 'xss_clean');
		
        $data['VistaMenu'] = 'vista_menu_admin';
        if ($this->form_validation->run()) {
            $registros = $this->modelo_reserva->Busqueda($this->input->post('Nombre'), $this->input->post('Correo'));
            if( $Modificacion==1 )
                $Vista = 'vista_modifica_reserva';
            else
                $Vista = 'vista_consulta_reserva';
                
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
                            anchor("reserva/CargaVista/$Vista/" . $registro->CodReserva, 
                            ($Modificacion==1? ' Modificar ':' Ver '), 
                            array('class'=>($Modificacion==1? 'actualiza':'vista'))). '  '.
                            anchor('reserva/BorrarReserva/' . $registro->CodReserva, 'Eliminar', array('class'=>'elimina','onclick'=>"return confirm('Realmente desea borrar este registro?')")));
                $data['Tabla'] = $this->table->generate();
                $data['Vista'] = 'vista_busca_reserva';
                $data['VistaPrincipal'] = 'vista_lista_reservas';
            }
        } else {
            $data['VistaPrincipal'] = 'vista_busca_reserva';
            $data['Modificacion'] = $Modificacion;            
        }
		$this->load->view('vista_maestra', $data);
    }

    function ModificaReserva() {
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
					$this->modelo_reserva->Update($this->input->post('CodReserva'), $this->input->post('Nombre'), $this->input->post('Correo'), $Activo);
					$data['Mensaje'] = 'Se han modificado los datos de la reserva.';
				}
                $data['VistaPrincipal'] = 'vista_mensaje';
            }
            else {
				if ($this->session->userdata('UsuarioPrueba')==1){
					$data['Mensaje'] = $this->funciones->MensajePrueba();
				}else{
					$this->modelo_reserva->Delete($this->input->post('CodReserva'));
					$data['Mensaje'] = 'Los datos de la reserva han sido eliminados';
				}
                $data['VistaPrincipal'] = 'vista_mensaje';
            }
        } else {
            $data['Fila'] = $this->modelo_reserva->getFila($this->input->post('CodReserva'));
			$data['VistaPrincipal'] = 'vista_modifica_reserva';
        }
		$this->load->view('vista_maestra', $data);
    }

    function CargaVista($Vista, $CodReserva) {
        $data['VistaMenu'] = 'vista_menu_admin';
        $data['Fila'] = $this->modelo_reserva->getFila($CodReserva);
		$data['VistaPrincipal'] = $Vista;
        $this->load->view('vista_maestra', $data);
    }

    function BorrarReserva($CodReserva) {
		if ($this->session->userdata('UsuarioPrueba')==0)
			$this->modelo_reserva->Delete($CodReserva);
        redirect('reserva','refresh');
    }
	
	/*function TiposRepeticion($Tipo='N'){
		return " <input type='radio' name='Repeticion' id='Repeticion' ".(($Tipo=='N')? "checked='checked'":'')." value='N' /> Ninguna <br />
				<label>&nbsp;</label><input type='radio' name='Repeticion' id='Repeticion' ".(($Tipo=='D')? "checked='checked'":'')." value='D' /> Diaria <br />
				<label>&nbsp;</label><input type='radio' name='Repeticion' id='Repeticion' ".(($Tipo=='S')? "checked='checked'":'')." value='S' /> Semanal <br />
				<label>&nbsp;</label><input type='radio' name='Repeticion' id='Repeticion' ".(($Tipo=='M')? "checked='checked'":'')." value='M' /> Mensual <br />";
	}*/
	function TiposRepeticion($Tipo='N'){
		return " <input type='radio' name='Repeticion' id='Repeticion' ".(($Tipo=='N')? "checked='checked'":'')." value='N' /> Ninguna &nbsp;&nbsp;&nbsp;
				<input type='radio' name='Repeticion' id='Repeticion' ".(($Tipo=='D')? "checked='checked'":'')." value='D' /> Diaria &nbsp;&nbsp;&nbsp;
				<input type='radio' name='Repeticion' id='Repeticion' ".(($Tipo=='S')? "checked='checked'":'')." value='S' /> Semanal &nbsp;&nbsp;&nbsp;
				<input type='radio' name='Repeticion' id='Repeticion' ".(($Tipo=='M')? "checked='checked'":'')." value='M' /> Mensual <br />";
	}
	
	function DiasSemana($Dias='0000000'){
		return "<div style='margin-left:150px;'>
				<input type='checkbox' name='DiasSemana_1' id='DiasSemana_1' ".(($Dias{0}=='1')? "checked='checked'":'')." value='1' /> Lunes &nbsp;&nbsp;&nbsp;
				<input type='checkbox' name='DiasSemana_2' id='DiasSemana_2' ".(($Dias{1}=='1')? "checked='checked'":'')." value='1' /> Martes &nbsp;&nbsp;&nbsp;
				<input type='checkbox' name='DiasSemana_3' id='DiasSemana_3' ".(($Dias{2}=='1')? "checked='checked'":'')." value='1' /> Miercoles <br />
				<input type='checkbox' name='DiasSemana_4' id='DiasSemana_4' ".(($Dias{3}=='1')? "checked='checked'":'')." value='1' /> Jueves &nbsp;&nbsp;
				<input type='checkbox' name='DiasSemana_5' id='DiasSemana_5' ".(($Dias{4}=='1')? "checked='checked'":'')." value='1' /> Viernes &nbsp;
				<input type='checkbox' name='DiasSemana_6' id='DiasSemana_6' ".(($Dias{5}=='1')? "checked='checked'":'')." value='1' /> Sabado <br />
				<input type='checkbox' name='DiasSemana_7' id='DiasSemana_7' ".(($Dias{6}=='1')? "checked='checked'":'')." value='1' /> Domingo <br />
				</div>";
	}

	function ComboHoras($Hora='',$Minuto=''){
		$HoraInicio=explode(':',$this->HoraInicioCombo);
		$MinutoInicio=$HoraInicio[1];
		$HoraInicio=$HoraInicio[0];
		
		$HoraFin=explode(':',$this->HoraFinCombo);
		$MinutoFin=$HoraFin[1];
		$HoraFin=$HoraFin[0];
		
		$Rango=explode(':',$this->RangoHoras);
		$Rango=$Rango[1];
		$combo='';

		for ($h=$HoraInicio;$h<=$HoraFin;$h++){
			for ($m=0;$m<60;$m=$m+$Rango){
				$selected=($Hora==$h && $Minuto==$m)? "selected='selected'" : '';
				if (!($h==$HoraInicio && $m<$MinutoInicio))
					$combo.="<option value='".gmmktime($h,$m,0, 1,1,1970)."' $selected>".$h.":".FormatoMinuto($m)."</option>";
			}
		}
		return $combo;
	}

}

?>