<script type="text/javascript">
$(document).ready(function() {
	$("#Reserva").validate();
	MuestraRepeticion('<?php echo $PeriodoRepeticion; ?>');
	HabilitaHoras(<?php echo ($Fila->DiaCompleto==1 ? 0 : 1); ?>);
	
	$("#DiaCompleto").click(function() {
		if ($(this).is(':checked'))
			HabilitaHoras(0);
		else
			HabilitaHoras(1);
	});

	$("input[name$='Repeticion']").click(function() {
        var tipo = $(this).val();
        MuestraRepeticion(tipo);
    }); 
	
	$("#HoraInicio").change(function() {
		var hora = parseInt($(this).val())+3600;
		$("#HoraFin").val(hora);
	});
});

function MuestraRepeticion(tipo){
	if(tipo=='N')
		$("#DivRepeticion").slideUp();
	else
		$("#DivRepeticion").slideDown();
}

function HabilitaHoras(tipo){
	if (tipo==1){
		$('#HoraInicio').removeAttr('disabled');
		$('#HoraFin').removeAttr('disabled');
	} else {
		$('#HoraInicio').attr('disabled','disabled');
		$('#HoraFin').attr('disabled','disabled');
	}
}
</script>
<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Consulta de datos de reserva</legend>

<label for='Nombre'>Nombre</label>
<?php echo $Fila->Nombre; ?><br />

<label for='Descripcion'>Descripci&oacute;n </label>
<?php echo $Fila->Descripcion; ?><br />

<label for='Notas'>Notas </label>
<textarea id='Notas' name='Notas' rows='4' cols='30' readonly='readonly'><?php echo $Fila->Notas; ?></textarea><br />

<label for='Estado'>Confirmada</label>
<input type='checkbox' id='Estado' name='Estado' disabled='disabled' <?php echo ($Fila->Estado==1?'checked':''); ?> /><br />

<label for='CodSala'>Sala</label>
<?php echo $NombreSala; ?><br />

<label for='Comienzo'>D&iacute;a de reserva</label>
<?php echo $Fecha; ?><br />

<label for='DiaCompleto'>D&iacute;a completo</label>
<input type='checkbox' id='DiaCompleto' name='DiaCompleto' disabled='disabled' <?php echo ($Fila->DiaCompleto==1?'checked':''); ?> /><br />

<label for='HoraInicio'>Hora inicio</label>
<?php echo $HoraInicio; ?><br />

<label for='HoraFin'>Hora fin</label>
<?php echo $HoraFin; ?><br />

<hr />
<label for='Repeticion'>Repetici&oacute;n</label>
<?php echo $Repeticiones_consulta; ?><br />

<div id="DivRepeticion" style="display:none;">
	<label for='FechaFinal'>Fecha Final *</label>
	<?php echo $FechaFinal;	?><br />

	<label for='DiasSemana'>D&iacute;as de la semana</label><br />
	<?php echo $DiasSemana_consulta; ?><br />
</div>

</fieldset>
</div>