<script type="text/javascript">
$(document).ready(function() {
	$("#Grupo").validate();
});
</script>
<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Nuevo grupo</legend>
<br />
<?php 
echo form_open('grupo/NuevoGrupo',  array('id' => 'Grupo', 'name' => 'Grupo'));
?>

<label for='Nombre'>Nombre *</label>
<input id='Nombre' name='Nombre' size='40' maxlength='50' class='required' value='<?php echo set_value('Nombre'); ?>' /><br />

<label for='Correo'>Correo del administrador *</label>
<input id='Correo' name='Correo' size='40' maxlength='60' class='required email' value='<?php echo set_value('Correo'); ?>' />
<?php echo '<br />'.form_error('Correo'); ?>

<label for='Activo'>Activo *</label>
<input type='checkbox' id='Activo' name='Activo' checked='checked' /><br />

<button class='button positive' style='margin-left:220px;'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='' /> Guardar
</button> 	  
</form>
</fieldset>
</div>