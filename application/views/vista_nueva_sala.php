<script type="text/javascript">
$(document).ready(function() {
	$("#Sala").validate();
});
</script>
<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Nueva sala</legend>
<br />
<?php 
echo form_open('sala/NuevaSala',  array('id' => 'Sala', 'name' => 'Sala'));
?>

<label for='Nombre'>Nombre *</label>
<input type='text' id='Nombre' name='Nombre' size='40' maxlength='50' class='required' value='<?php echo set_value('Nombre'); ?>' /><br />

<label for='Descripcion'>Descripci&oacute;n</label>
<input type='text' id='Descripcion' name='Descripcion' size='40' maxlength='50' value='<?php echo set_value('Descripcion'); ?>' /><br />

<label for='CodGrupo'>Grupo *</label>
<?php echo $ComboGrupos; ?><br />

<label for='Capacidad'>Capacidad *</label>
<input type='text' id='Capacidad' name='Capacidad' size='5' maxlength='5' class='required' value='<?php echo set_value('Capacidad'); ?>' /><br />

<label for='Correo'>Correo del administrador</label>
<input type='text' id='Correo' name='Correo' size='40' maxlength='60' value='<?php echo set_value('Correo'); ?>' />
<?php echo '<br />'.form_error('Correo'); ?>

<label for='Activo'>Activo *</label>
<input type='checkbox' id='Activo' name='Activo' checked='checked' /><br />

<button class='button positive' style='margin-left:220px;'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='' /> Guardar
</button> 	  
</form>
</fieldset>
</div>