<script type="text/javascript">
$(document).ready(function() {
	$("#Institucion").validate();
});
</script>
<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Modificaci&oacute;n de datos de instituci&oacute;n</legend>
<br />
<?php 
echo form_open('institucion/ModificaInstitucion',  array('id' => 'Institucion', 'name' => 'Institucion'));
?>

<input type='hidden' id='CorreoOriginal' name='CorreoOriginal' value='<?php echo $Fila->Correo; ?>' />
<input type='hidden' id='CodInstitucion' name='CodInstitucion' value='<?php echo $Fila->CodInstitucion; ?>' />

<label for='Nombre'>Nombre *</label>
<input type='text' id='Nombre' name='Nombre' size='40' maxlength='50' class='required' value='<?php echo $Fila->Nombre; ?>' /><br />

<label for='Contacto'>Contacto</label>
<input type='text' id='Contacto' name='Contacto' size='40' maxlength='50' value='<?php echo $Fila->Contacto; ?>' /><br />

<label for='Correo'>Correo electr&oacute;nico *</label>
<input type='text' id='Correo' name='Correo' size='40' maxlength='60' class='required email' value='<?php echo $Fila->Correo; ?>' />
<?php echo '<br />'.form_error('Correo'); ?>;

<label for='Telefono'>Tel&eacute;fono</label>
<input type='text' id='Telefono' name='Telefono' size='20' maxlength='20'  value='<?php echo $Fila->Telefono; ?>' /><br />

<label for='SitioWeb'>Sitio web</label>
<input type='text' id='SitioWeb' name='SitioWeb' size='40' maxlength='60' class='url'  value='<?php echo $Fila->SitioWeb; ?>' /><br />

<label for='CodPais'>Pais</label>
<?php echo $ComboPais; ?><br />

<label for='Activo'>Activo</label>
<input type='checkbox' id='Activo' name='Activo' checked='<?php ($Fila->Activo==1?'checked':''); ?>' /><br />

<label for='Notas'>Notas</label>
<textarea id='Notas' name='Notas' cols='45' rows='4'>
<?php echo $Fila->Notas; ?>
</textarea><br /><br />

<button class='button positive' style='margin-left:180px;' name='submit' value='Guardar'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='Graba las modificaciones' /> Guardar
</button>
<button class='button positive' name='submit' onclick='return confirm("Realmente desea borrar este registro?")'> 
	<img src='<?php echo base_url();?>bt/images/icons/cross.png' alt='Elimina este registro' value='Borrar' /> Borrar
</button> 	 
 
</form>
</fieldset>
</div>