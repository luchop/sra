<?php

class Reserva extends CI_Controller {

	private $RangoHoras;
	private $HoraInicioCombo;
	private $HoraFinCombo;
	private $CodUsuario;
	private $CodInstitucion;

    function __construct() {
        parent::__construct();
		$this->load->model('modelo_repeticion', '', TRUE);
		$this->load->model('modelo_reserva', '', TRUE);
		$this->load->model('modelo_sala', '', TRUE);
		$this->load->model('modelo_grupo', '', TRUE);
		$this->load->model('modelo_usuario', '', TRUE);
		$this->load->library('funciones');
		$this->load->library('fpdf');
		//$this->session->set_userdata('UsuarioPrueba', 1);
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->CodInstitucion=(($this->session->userdata('CodInstitucion')) ? $this->session->userdata('CodInstitucion') : 2);
		$this->modelo_sala->SetCodInstitucion($this->CodInstitucion);
		$this->modelo_reserva->SetCodInstitucion($this->CodInstitucion);
		$this->modelo_repeticion->SetCodInstitucion($this->CodInstitucion);
		$this->modelo_grupo->SetCodInstitucion($this->CodInstitucion);
		
		$this->CodUsuario=0;
		$this->modelo_reserva->SetCodUsuario($this->CodUsuario);
		$this->modelo_repeticion->SetCodUsuario($this->CodUsuario);
		
		//Periodo de tiempo entre horas del combo
		$this->RangoHoras='00:30';
		//Horas en las que inicio el combo de seleccion de hora
		$this->HoraInicioCombo='7:00';
		$this->HoraFinCombo='21:00';
    }

    function Index() {
	    redirect('reserva/CalendarioReservas','refresh');
    }
	
	function CalendarioReservas(){
		$data['VistaPrincipal'] = 'vista_calendario_reservas';
		$data['Reservas'] = $this->ObtieneReservas();
		$this->load->view('vista_maestra', $data);
	}
	
	function ObtieneReservas(){
		$registros = $this->modelo_reserva->Busqueda('', '', '');
		$mes=date('n');
		$reservas='[';
		foreach ($registros->result() as $registro){
			$FechaFin=($registro->FechaFinal!='')?date('Y,(n-1),j,',$registro->FechaFinal).date('G,i',$registro->HoraFin):date('Y,(n-1),j,',$registro->HoraInicio).date('G,i',$registro->HoraFin);
			$DiaCompleto=($registro->DiaCompleto==1)?'true':'false';
			$Vista=($this->CodUsuario==$registro->CodUsuario)?'vista_modifica_reserva':'vista_consulta_reserva';
			$reservas.='{"id":"'.$registro->CodReserva.'","title":"'.$registro->Nombre.'","start":new Date('.date('Y,(n-1),j,G,i',$registro->HoraInicio).'),"end":new Date('.$FechaFin.'),allDay: '.$DiaCompleto.',url:"'.base_url().'index.php/reserva/CargaVista/'.$Vista.'/'.$registro->CodReserva.'"}, 
			';
		}
		$reservas.=']';
		return ($reservas);
	}
	
	function ReporteReservas(){
		$this->form_validation->set_rules('Nombre', 'nombre', 'xss_clean');
		
		if ($this->form_validation->run()) {
			$Estado = $this->input->post('Estado')? 1: 0;
			$FechaInicio='';
			if ($this->input->post('Comienzo')!=''){
				$Comienzo=explode('/',$this->input->post('Comienzo'));
				$FechaInicio=mktime(0,0,0, $Comienzo[1],$Comienzo[0],$Comienzo[2]);
			}

			if ($this->input->post('FechaFinal')!='')
				$Final=explode('/',$this->input->post('FechaFinal'));
			else
				$Final=explode('/',date('d/m/Y'));
			$FechaFinal=mktime(0,0,0, $Final[1],$Final[0],$Final[2]);
			
			$data['Tabla'] = $this->modelo_reserva->Reporte($this->input->post('Nombre'),$FechaInicio,$FechaFinal,$this->input->post('CodGrupo'),$this->input->post('CodSala'),$Estado,$this->input->post('CodUsuario'));
			$this->load->view('vista_reporte_reservas_pdf', $data);
		}else{
			$data['VistaPrincipal'] = 'vista_reporte_reservas';
			$data['ComboSalas'] = $this->modelo_sala->ComboSalas(set_value('CodSala'),0);
			$data['ComboGrupos'] = $this->modelo_grupo->ComboGrupos(set_value('CodGrupo'),0);
			$data['ComboUsuarios'] = $this->modelo_usuario->ComboUsuarios($this->CodInstitucion,'',0);
			$this->load->view('vista_maestra', $data);
		}
	}

    function NuevaReserva($anio='',$mes='',$dia='',$Hora='',$Minuto='') {
		$this->form_validation->set_rules('Nombre', 'nombre', 'xss_clean');

        $data['VistaMenu'] = 'vista_menu_admin';
		$mes=($mes=='')?date('m'):$mes;
		$dia=($dia=='')?date('d'):$dia;
		$anio=($anio=='')?date('Y'):$anio;
		$data['Fecha'] = $dia.'/'.$mes.'/'.$anio;
		
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
				$CodReserva = $this->modelo_reserva->Insert($this->input->post('Nombre'), $this->input->post('Descripcion'), $this->input->post('Notas'), $Estado, $this->input->post('CodSala'), $HoraInicio, $HoraFin, $CodRepeticion);
				$data['Mensaje'] = "Se ha registrado una nueva reserva.";
			}
            $data['VistaPrincipal'] = 'vista_mensaje';
        } else {
			$data['ComboSalas'] = $this->modelo_sala->ComboSalas(set_value('CodSala'));
			$data['ComboHoras'] = $this->ComboHoras($Hora,$Minuto);
			$data['DiasSemana'] = $this->DiasSemana();
			$data['Repeticiones'] = $this->TiposRepeticion();
            $data['VistaPrincipal'] = 'vista_nueva_reserva';
        }
		$this->load->view('vista_maestra', $data);	
    }

    function BuscaParaModificar($Modificacion=0) {
        $this->form_validation->set_rules('Nombre', 'nombre', 'xss_clean');
		
        $data['VistaMenu'] = 'vista_menu_admin';
        if ($this->form_validation->run()) {
            $registros = $this->modelo_reserva->Busqueda($this->input->post('Nombre'), $this->input->post('Descripcion'), $this->input->post('CodSala'));
            if( $Modificacion==1 )
                $Vista = 'vista_modifica_reserva';
            else
                $Vista = 'vista_consulta_reserva';
                
            if ($registros->num_rows() == 0) {
                $data['Mensaje'] = 'No se encontraron registros que cumplan el criterio de b&uacute;squeda';
                $data['VistaPrincipal'] = 'vista_mensaje';
            } else if ($registros->num_rows() == 1) {
				$data['Fila'] = $registros->row();
				$data['PeriodoRepeticion']=(!isset($data['Fila']->PeriodoRepeticion) || $data['Fila']->PeriodoRepeticion=='') ? 'N' : $data['Fila']->PeriodoRepeticion;
				$data['ComboSalas'] = $this->modelo_sala->ComboSalas($data['Fila']->CodSala);
				$data['Fecha'] = ($data['Fila']->HoraInicio!='') ? date('d/m/Y',$data['Fila']->HoraInicio):date('d/m/Y');
				$data['FechaFinal'] = ($data['Fila']->FechaFinal!='') ? date('d/m/Y',$data['Fila']->FechaFinal) :date('d/m/Y');
				$data['ComboHoras_Inicio'] = $this->ComboHoras(date('H',$data['Fila']->HoraInicio),date('i',$data['Fila']->HoraInicio));
				$data['ComboHoras_Fin'] = $this->ComboHoras(date('H',$data['Fila']->HoraFin),date('i',$data['Fila']->HoraFin));
				$data['DiasSemana'] = $this->DiasSemana($data['Fila']->DiasSemana);
				$data['Repeticiones'] = $this->TiposRepeticion($data['PeriodoRepeticion']);
								
				$data['NombreSala'] = $this->modelo_sala->NombreSala($data['Fila']->CodSala);		
				$data['HoraInicio']=date('H',$data['Fila']->HoraInicio).':'.(date('i',$data['Fila']->HoraInicio));
				$data['HoraFin']=date('H',$data['Fila']->HoraFin).':'.(date('i',$data['Fila']->HoraFin));
				$data['DiasSemana_consulta'] = $this->DiasSemana($data['Fila']->DiasSemana,1);
				$data['Repeticiones_consulta'] = $this->TiposRepeticion($data['PeriodoRepeticion'],1);
                $data['VistaPrincipal'] = $Vista;
            } else {
                $this->load->library('table');
				$this->table->set_empty("&nbsp;");
                $this->table->set_heading('No.', 'Nombre', 'Sala', 'Acci&oacute;n');
                $i = 0;
                foreach ($registros->result() as $registro)
                    $this->table->add_row(++$i, $registro->Nombre, $registro->NombreSala, 
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
			$data['ComboSalas'] = $this->modelo_sala->ComboSalas(set_value('CodSala'),0);
            $data['Modificacion'] = $Modificacion;            
        }
		$this->load->view('vista_maestra', $data);
    }

    function ModificaReserva() {
		$this->form_validation->set_rules('Nombre', 'nombre', 'trim|xss_clean');

        $data['VistaMenu'] = 'vista_menu_admin';
        if ($this->form_validation->run()) {
            $Accion = $this->input->post("submit");
			if ($Accion == "Guardar") {
                $Estado = $this->input->post('Estado')? 1: 0;
				if ($this->session->userdata('UsuarioPrueba')==1){
					$data['Mensaje'] = $this->funciones->MensajePrueba();
				}else{
					$CodRepeticion=$this->input->post('CodRepeticion');
					$Comienzo=explode('/',$this->input->post('Comienzo'));
					$FechaInicio=mktime(0,0,0, $Comienzo[1],$Comienzo[0],$Comienzo[2]);
					$Final=explode('/',$this->input->post('FechaFinal'));
					$FechaFinal=mktime(0,0,0, $Final[1],$Final[0],$Final[2]);
					$HoraInicio=$this->input->post('HoraInicio')+$FechaInicio;
					$HoraFin=$this->input->post('HoraFin')+$FechaInicio;
					$DiaCompleto = $this->input->post('DiaCompleto')? 1: 0;
					$DiasSemana = (($this->input->post('DiasSemana_1'))?1:0).(($this->input->post('DiasSemana_2'))?1:0).(($this->input->post('DiasSemana_3'))?1:0).(($this->input->post('DiasSemana_4'))?1:0).(($this->input->post('DiasSemana_5'))?1:0).(($this->input->post('DiasSemana_6'))?1:0).(($this->input->post('DiasSemana_7'))?1:0);
					if ($this->input->post('Repeticion')!='N'){
						if ($CodRepeticion!=0)
							$this->modelo_repeticion->Update($CodRepeticion,$this->input->post('Nombre'), $this->input->post('Descripcion'), $Estado, $this->input->post('CodSala'), $HoraInicio, $HoraFin, $DiaCompleto, $FechaFinal, $DiasSemana, $this->input->post('Repeticion'));
						else
							$CodRepeticion=$this->modelo_repeticion->Insert($this->input->post('Nombre'), $this->input->post('Descripcion'), $Estado, $this->input->post('CodSala'), $HoraInicio, $HoraFin, $DiaCompleto, $FechaFinal, $DiasSemana, $this->input->post('Repeticion'));
					} else {
						$this->modelo_repeticion->Delete($CodRepeticion);
						$CodRepeticion=0;
					}
					$CodReserva = $this->modelo_reserva->Update($this->input->post('CodReserva'),$this->input->post('Nombre'), $this->input->post('Descripcion'), $this->input->post('Notas'), $Estado, $this->input->post('CodSala'), $HoraInicio, $HoraFin, $CodRepeticion);
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
		$data['PeriodoRepeticion']=(!isset($data['Fila']->PeriodoRepeticion) || $data['Fila']->PeriodoRepeticion=='') ? 'N' : $data['Fila']->PeriodoRepeticion;
		$data['ComboSalas'] = $this->modelo_sala->ComboSalas($data['Fila']->CodSala);		
		$data['Fecha'] = ($data['Fila']->HoraInicio!='') ? date('d/m/Y',$data['Fila']->HoraInicio):date('d/m/Y');
		$data['FechaFinal'] = ($data['Fila']->FechaFinal!='') ? date('d/m/Y',$data['Fila']->FechaFinal) :date('d/m/Y');
		$data['ComboHoras_Inicio'] = $this->ComboHoras(date('H',$data['Fila']->HoraInicio),date('i',$data['Fila']->HoraInicio));
		$data['ComboHoras_Fin'] = $this->ComboHoras(date('H',$data['Fila']->HoraFin),date('i',$data['Fila']->HoraFin));
		$data['DiasSemana'] = $this->DiasSemana($data['Fila']->DiasSemana);
		$data['Repeticiones'] = $this->TiposRepeticion($data['PeriodoRepeticion']);
		
		$data['NombreSala'] = $this->modelo_sala->NombreSala($data['Fila']->CodSala);		
		$data['HoraInicio']=date('H',$data['Fila']->HoraInicio).':'.(date('i',$data['Fila']->HoraInicio));
		$data['HoraFin']=date('H',$data['Fila']->HoraFin).':'.(date('i',$data['Fila']->HoraFin));
		$data['DiasSemana_consulta'] = $this->DiasSemana($data['Fila']->DiasSemana,1);
		$data['Repeticiones_consulta'] = $this->TiposRepeticion($data['PeriodoRepeticion'],1);
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
	function TiposRepeticion($Tipo='N',$Consulta=0){
		$disabled=($Consulta==1)?'disabled="disabled"':'';
		return " <input type='radio' name='Repeticion' id='Repeticion' $disabled ".(($Tipo=='N')? "checked='checked'":'')." value='N' /> Ninguna &nbsp;&nbsp;&nbsp;
				<input type='radio' name='Repeticion' id='Repeticion' $disabled ".(($Tipo=='D')? "checked='checked'":'')." value='D' /> Diaria &nbsp;&nbsp;&nbsp;
				<input type='radio' name='Repeticion' id='Repeticion' $disabled ".(($Tipo=='S')? "checked='checked'":'')." value='S' /> Semanal &nbsp;&nbsp;&nbsp;
				<input type='radio' name='Repeticion' id='Repeticion' $disabled ".(($Tipo=='M')? "checked='checked'":'')." value='M' /> Mensual <br />";
	}
	
	function DiasSemana($Dias='0000000',$Consulta=0){
		$disabled=($Consulta==1)?'disabled="disabled"':'';
		return "<div style='margin-left:150px;'>
				<input type='checkbox' name='DiasSemana_1' id='DiasSemana_1' $disabled ".(($Dias{0}=='1')? "checked='checked'":'')." value='1' /> Lunes &nbsp;&nbsp;&nbsp;
				<input type='checkbox' name='DiasSemana_2' id='DiasSemana_2' $disabled ".(($Dias{1}=='1')? "checked='checked'":'')." value='1' /> Martes &nbsp;&nbsp;&nbsp;
				<input type='checkbox' name='DiasSemana_3' id='DiasSemana_3' $disabled ".(($Dias{2}=='1')? "checked='checked'":'')." value='1' /> Miercoles <br />
				<input type='checkbox' name='DiasSemana_4' id='DiasSemana_4' $disabled ".(($Dias{3}=='1')? "checked='checked'":'')." value='1' /> Jueves &nbsp;&nbsp;
				<input type='checkbox' name='DiasSemana_5' id='DiasSemana_5' $disabled ".(($Dias{4}=='1')? "checked='checked'":'')." value='1' /> Viernes &nbsp;
				<input type='checkbox' name='DiasSemana_6' id='DiasSemana_6' $disabled ".(($Dias{5}=='1')? "checked='checked'":'')." value='1' /> Sabado <br />
				<input type='checkbox' name='DiasSemana_7' id='DiasSemana_7' $disabled ".(($Dias{6}=='1')? "checked='checked'":'')." value='1' /> Domingo <br />
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