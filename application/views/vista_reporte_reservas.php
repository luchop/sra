<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Reporte de reservas</legend>
<br />
<?php 
echo form_open("reserva/ReporteReservas",  array('id' => 'Reserva', 'name' => 'Reserva'));
?>

<label for='Nombre'>Nombre </label>
<input id='Nombre' name='Nombre' size='40' maxlength='50' value='' /><br />

<label for='Comienzo'>Fecha inicio</label>
<?php
echo "<input type='text' name='Comienzo' id='Comienzo' size='12' maxlength='10' class='required' onclick='";
echo 'fPopCalendar("Comienzo")'."' value=''/>";
?><br />

<label for='FechaFinal'>Fecha Final</label>
<?php
	echo "<input type='text' name='FechaFinal' id='FechaFinal' size='12' maxlength='10' class='required' onclick='";
	echo 'fPopCalendar("FechaFinal")'."' value=''/>";
?><br />

<label for='CodGrupo'>Grupo </label>
<?php echo $ComboGrupos; ?><br />

<label for='CodSala'>Sala </label>
<?php echo $ComboSalas; ?><br />

<label for='Estado'>Confirmada</label>
<input type='checkbox' id='Estado' name='Estado' checked='checked' /><br />

<label for='CodUsuario'>Usuario </label>
<?php echo $ComboUsuarios; ?><br />

<button class='button positive' style='margin-left:220px;'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='' /> Buscar
</button> 	  
</form>
</fieldset>
</div>