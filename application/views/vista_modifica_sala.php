<script type="text/javascript">
$(document).ready(function() {
	$("#Sala").validate();
});
</script>
<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Modificaci&oacute;n de datos de sala</legend>
<br />
<?php 
echo form_open('sala/ModificaSala',  array('id' => 'Sala', 'name' => 'Sala'));
?>

<input type='hidden' id='CodSala' name='CodSala' value='<?php echo $Fila->CodSala; ?>' />
<label for='Nombre'>Nombre *</label>
<input type='text' id='Nombre' name='Nombre' size='40' maxlength='50' class='required' value='<?php echo $Fila->Nombre; ?>' /><br />

<label for='Descripcion'>Descripci&oacute;n</label>
<input type='text' id='Descripcion' name='Descripcion' size='40' maxlength='50' value='<?php echo $Fila->Descripcion; ?>' /><br />

<label for='CodGrupo'>Grupo *</label>
<?php echo $ComboGrupos; ?><br />

<label for='Capacidad'>Capacidad *</label>
<input type='text' id='Capacidad' name='Capacidad' size='5' maxlength='5' class='required' value='<?php echo $Fila->Capacidad; ?>' /><br />

<label for='Correo'>Correo electr&oacute;nico</label>
<input type='text' id='Correo' name='Correo' size='40' maxlength='60' value='<?php echo $Fila->CorreoAdministrador; ?>' />
<?php echo '<br />'.form_error('Correo'); ?>

<label for='Activo'>Activo</label>
<input type='checkbox' id='Activo' name='Activo' <?php echo ($Fila->Activo==1?'checked':''); ?> /><br />

<button class='button positive' style='margin-left:180px;' name='submit' value='Guardar'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='Graba las modificaciones' /> Guardar
</button>
<button class='button positive' name='submit' onclick='return confirm("Realmente desea borrar este registro?")'> 
	<img src='<?php echo base_url();?>bt/images/icons/cross.png' alt='Elimina este registro' value='Borrar' /> Borrar
</button> 	 
 
</form>
</fieldset>
</div>