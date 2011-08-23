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
<fieldset><legend>Modificaci&oacute;n de datos de reserva</legend>
<br />
<?php 
echo form_open('reserva/ModificaReserva',  array('id' => 'Reserva', 'name' => 'Reserva'));
?>

<input type='hidden' id='CodReserva' name='CodReserva' value='<?php echo $Fila->CodReserva; ?>' />
<input type='hidden' id='CodRepeticion' name='CodRepeticion' value='<?php echo $Fila->CodRepeticion; ?>' />
<label for='Nombre'>Nombre *</label>
<input type='text' id='Nombre' name='Nombre' size='40' maxlength='50' class='required' value='<?php echo $Fila->Nombre; ?>' /><br />

<label for='Descripcion'>Descripci&oacute;n </label>
<input type='text' id='Descripcion' name='Descripcion' size='40' maxlength='50' value='<?php echo $Fila->Descripcion; ?>' /><br />

<label for='Estado'>Confirmada *</label>
<input type='checkbox' id='Estado' name='Estado' <?php echo ($Fila->Estado==1?'checked':''); ?> /><br />

<label for='CodSala'>Sala *</label>
<?php echo $ComboSalas; ?><br />

<label for='Comienzo'>D&iacute;a de reserva *</label>
<?php
echo "<input type='text' name='Comienzo' id='Comienzo' size='12' maxlength='10' class='required' onclick='";
echo 'fPopCalendar("Comienzo")'."' value='".$Fecha."'/>";
?><br />

<label for='DiaCompleto'>D&iacute;a completo *</label>
<input type='checkbox' id='DiaCompleto' name='DiaCompleto' <?php echo ($Fila->DiaCompleto==1?'checked':''); ?> /><br />

<label for='HoraInicio'>Hora inicio *</label>
<select name='HoraInicio' id='HoraInicio'><?php echo $ComboHoras_Inicio; ?></select><br />

<label for='HoraFin'>Hora fin *</label>
<select name='HoraFin' id='HoraFin'><?php echo $ComboHoras_Fin; ?></select><br />

<hr />
<label for='Repeticion'>Repetici&oacute;n *</label>
<?php echo $Repeticiones; ?><br />

<div id="DivRepeticion" style="display:none;">
	<label for='FechaFinal'>Fecha Final *</label>
	<?php
	echo "<input type='text' name='FechaFinal' id='FechaFinal' size='12' maxlength='10' class='required' onclick='";
	echo 'fPopCalendar("FechaFinal")'."' value='".$FechaFinal."'/>";
	?><br />

	<label for='DiasSemana'>D&iacute;as de la semana *</label><br />
	<?php echo $DiasSemana; ?><br />
</div>

<button class='button positive' style='margin-left:180px;' name='submit' value='Guardar'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='Graba las modificaciones' /> Guardar
</button>
<button class='button positive' name='submit' onclick='return confirm("Realmente desea borrar este registro?")'> 
	<img src='<?php echo base_url();?>bt/images/icons/cross.png' alt='Elimina este registro' value='Borrar' /> Borrar
</button> 	 
 
</form>
</fieldset>
</div>