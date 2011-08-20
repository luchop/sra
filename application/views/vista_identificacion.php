<script type="text/javascript">
$(document).ready(function() {
	$("#Identificacion").validate();
});
</script>
<div id='formulario' class='span-16 prefix-4 suffix-4 last'>
<fieldset><legend>Identificaci&oacute;n de la instituci&oacute;n</legend>
<br />
<?php 
echo form_open('configuracion/Identificacion',  array('id' => 'Identificacion', 'name' => 'Identificacion'));
?>

<label for='Linea1'>L&iacute;nea 1 </label>
<input type='text' size='50' maxlength='100' id='Linea1' name='Linea1' value='<?php echo $Linea1; ?>' /><br />

<label for='Linea2'>L&iacute;nea 2 </label>
<input type='text' size='50' maxlength='100'  id='Linea2' name='Linea2' value='<?php echo $Linea2; ?>' /><br />

<label for='Linea3'>L&iacute;nea 3 </label>
<input type='text' size='50' maxlength='100'  id='Linea3' name='Linea3' value='<?php echo $Linea3; ?>' /><br />

<label for='ImprimirId'>Imprimir en reportes </label>
<input type="checkbox" id="ImprimirId" name="ImprimirId" <?php echo ($ImprimirId==1) ? 'checked="checked"' : '' ?> value="1" /><br />

<button class='button positive' style='margin-left:220px;'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='' /> Guardar
</button> 	
  
</form>
</fieldset>
</div>

		