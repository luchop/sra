<script type="text/javascript">
$(document).ready(function() {
	$("#Grupo").validate();
});
</script>
<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Modificaci&oacute;n de datos de grupo</legend>
<br />
<?php 
echo form_open('grupo/ModificaGrupo',  array('id' => 'Grupo', 'name' => 'Grupo'));
?>

<input type='hidden' id='CodGrupo' name='CodGrupo' value='<?php echo $Fila->CodGrupo; ?>' />

<label for='Nombre'>Nombre *</label>
<input type='text' id='Nombre' name='Nombre' size='40' maxlength='50' class='required' value='<?php echo $Fila->Nombre; ?>' /><br />

<label for='Correo'>Correo electr&oacute;nico *</label>
<input type='text' id='Correo' name='Correo' size='40' maxlength='60' class='required email' value='<?php echo $Fila->CorreoAdministrador; ?>' />
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