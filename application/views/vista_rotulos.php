<script type="text/javascript">
$(document).ready(function() {
	$("#Rotulos").validate();
});
</script>
<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Configuraci&oacute;n de r&oacute;tulos</legend>
<br />
<?php 
echo form_open('configuracion/Rotulos',  array('id' => 'Rotulos', 'name' => 'Rotulos'));
?>

<label for='Rotulo1'>R&oacute;tulo 1 *</label>
<input type='text' id='Rotulo1' name='Rotulo1' size='15' maxlength='12' class='required' value='<?php echo $Rotulo1; ?>' /> (original: 'Art&iacute;culo')<br />

<label for='Rotulo2'>R&oacute;tulo 2 *</label>
<input type='text' size='15' maxlength='12'  id='Rotulo2' name='Rotulo2' class='required' value='<?php echo $Rotulo2; ?>' /> (original: 'Marca')<br />

<label for='Rotulo3'>R&oacute;tulo 3 *</label>
<td><input type='text' size='15' maxlength='12'  id='Rotulo3' name='Rotulo3' class='required' value='<?php echo $Rotulo3; ?>' /> (original: 'Modelo')<br />

<button class='button positive' style='margin-left:220px;'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='' /> Guardar
</button> 	
  
</form>
</fieldset>
</div>