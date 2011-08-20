<script type="text/javascript">
$(document).ready(function() {
	$("#Contrato").validate();
});
</script>
<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Nuevo contrato</legend>
<br />
<?php 
echo form_open('contrato/NuevoContrato',  array('id' => 'Contrato', 'name' => 'Contrato'));
?>

<label for='CodInstitucion'>Institucion *</label>
<?php echo $ComboInstituciones; ?><br />

<label for='Desde'>Desde *</label>
<?php
echo "<input type='text' name='Desde' id='Desde' size='12' maxlength='10' class='required date' onclick='";
echo 'fPopCalendar("Desde")'."' value='".$Desde."'/>";
?><br />

<label for='Hasta'>Hasta *</label>
<?php
echo "<input type='text' name='Hasta' id='Hasta' size='12' maxlength='10' class='required date' onclick='";
echo 'fPopCalendar("Hasta")'."' value='".$Hasta."'/>";
?><br />

<label for='Precio'>Precio *</label>
<input type='text' id='Precio' name='Precio' size='10' maxlength='10' class='required number' value='<?php echo set_value('Precio'); ?>' /><br />

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