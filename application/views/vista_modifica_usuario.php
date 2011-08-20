<script type="text/javascript">
$(document).ready(function() {
	$("#Usuario").validate();
});
</script>
<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Modificaci&oacute;n de datos de usuario</legend>
<br />
<?php 
echo form_open('usuario/ModificaUsuario',  array('id' => 'Usuario', 'name' => 'Usuario'));
?>

<input type='hidden' id='CodUsuario' name='CodUsuario' value='<?php echo $Fila->CodUsuario; ?>' />

<label for='Nombre'>Nombre *</label>
<input type='text' id='Nombre' name='Nombre' size='40' maxlength='50' class='required' value='<?php echo $Fila->Nombre; ?>' /><br />

<label for='Correo'>Correo electr&oacute;nico *</label>
<input type='text' id='Correo' name='Correo' size='40' maxlength='60' class='required email' value='<?php echo $Fila->Correo; ?>' />
<?php echo '<br />'.form_error('Correo'); ?>

<label for='Nick'>Nombre de usuario *</label>
<input id='Nick' name='Nick' size='12' maxlength='12' class='required' value='<?php echo $Fila->Nick; ?>' /><br />

<label for='CodTipoUsuario'>Tipo</label>
<?php echo $ComboTipoUsuario; ?><br />

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