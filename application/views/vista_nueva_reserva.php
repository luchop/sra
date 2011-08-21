<script type="text/javascript">
$(document).ready(function() {
	$("#Reserva").validate();

    $("input[name$='Repeticion']").click(function() {
        var test = $(this).val();
        if(test=='N')
			$("#DivRepeticion").slideUp();
		else
			$("#DivRepeticion").slideDown();
    }); 
});

</script>
<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Nueva reserva</legend>
<br />
<?php 
echo form_open('reserva/NuevaReserva',  array('id' => 'Reserva', 'name' => 'Reserva'));
?>

<label for='Nombre'>Nombre *</label>
<input type='text' id='Nombre' name='Nombre' size='40' maxlength='50' class='required' value='<?php echo set_value('Nombre'); ?>' /><br />

<label for='Descripcion'>Descripci&oacute;n </label>
<input type='text' id='Descripcion' name='Descripcion' size='40' maxlength='50' value='<?php echo set_value('Descripcion'); ?>' /><br />

<label for='Estado'>Confirmada *</label>
<input type='checkbox' id='Estado' name='Estado' checked='checked' /><br />

<label for='CodSala'>Sala *</label>
<?php echo $ComboSalas; ?><br />

<label for='Comienzo'>D&iacute;a de reserva *</label>
<?php
echo "<input type='text' name='Comienzo' id='Comienzo' size='12' maxlength='10' class='required' onclick='";
echo 'fPopCalendar("Comienzo")'."' value='".$Fecha."'/>";
?><br />

<label for='DiaCompleto'>D&iacute;a completo *</label>
<input type='checkbox' id='DiaCompleto' name='DiaCompleto' /><br />

<label for='HoraInicio'>Hora inicio *</label>
<select name='HoraInicio' id='HoraInicio'><?php echo $ComboHoras; ?></select><br />

<label for='HoraFin'>Hora fin *</label>
<select name='HoraFin' id='HoraFin'><?php echo $ComboHoras; ?></select><br />

<hr />
<label for='Repeticion'>Repetici&oacute;n *</label>
<?php echo $Repeticiones; ?><br />

<div id="DivRepeticion" style="display:none;">
	<label for='FechaFinal'>Fecha Final *</label>
	<?php
	echo "<input type='text' name='FechaFinal' id='FechaFinal' size='12' maxlength='10' class='required' onclick='";
	echo 'fPopCalendar("FechaFinal")'."' value='".$Fecha."'/>";
	?><br />

	<label for='DiasSemana'>D&iacute;as de la semana *</label><br />
	<?php echo $DiasSemana; ?><br />
</div>
 
<button class='button positive' style='margin-left:220px;'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='' /> Guardar
</button> 	  
</form>
</fieldset>
</div>