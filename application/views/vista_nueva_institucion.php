<script type="text/javascript">
$(document).ready(function() {
	$("#Institucion").validate();
});
</script>
<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Nueva instituci&oacute;n</legend>
<br />
<?php 
echo form_open('institucion/NuevaInstitucion',  array('id' => 'Institucion', 'name' => 'Institucion'));
?>

<label for='Nombre'>Nombre *</label>
<input id='Nombre' name='Nombre' size='40' maxlength='50' class='required' value='<?php echo set_value('Nombre'); ?>' /><br />

<label for='Contacto'>Contacto</label>
<input id='Contacto' name='Contacto' size='40' maxlength='50' value='<?php echo set_value('Contacto'); ?>' /><br />

<label for='Correo'>Correo electronico *</label>
<input id='Correo' name='Correo' size='40' maxlength='60' class='required email' value='<?php echo set_value('Correo'); ?>' />
<?php echo '<br />'.form_error('Correo'); ?>;

<label for='Telefono'>Telefono</label>
<input id='Telefono' name='Telefono' size='20' maxlength='20'  value='<?php echo set_value('Telefono'); ?>' /><br />

<label for='SitioWeb'>Sitio web</label>
<input id='SitioWeb' name='SitioWeb' size='40' maxlength='60' class='url'  value='<?php echo set_value('SitioWeb'); ?>' /><br />

<label for='CodPais'>Pais *</label>
<?php echo $ComboPais; ?><br />

<label for='Activo'>Activo</label>
<input type='checkbox' id='Activo' name='Activo' checked='checked' /><br />

<label for='Notas'>Notas</label>
<textarea id='Notas' name='Notas' cols='45' rows='4'>
<?php echo set_value('Notas'); ?>
</textarea><br /><br />

<button class='button positive' style='margin-left:220px;'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='' /> Guardar
</button> 	  
</form>
</fieldset>
</div>