<script type="text/javascript">
$(document).ready(function() {
	$("#Cobro").validate();
});
</script>
<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Nueva sala</legend>
<br />
<?php 
echo form_open('cobro/NuevoCobro',  array('id' => 'Cobro', 'name' => 'Cobro'));
?>

<label for='Fecha'>Fecha *</label>
<?php
	echo "<input type='text' name='Fecha' id='Fecha' size='12' maxlength='10' onclick='";
	echo 'fPopCalendar("Fecha")'."' value='".$Fecha."'/>";
?><br />

<label for='Monto'>Monto</label>
<input type='text' id='Monto' name='Monto' size='10' maxlength='10' value='<?php echo set_value('Monto'); ?>' /><br />

<label for='Factura'>Factura</label>
<input type='text' id='Factura' name='Factura' size='10' maxlength='10' value='<?php echo set_value('Factura'); ?>' /><br />

<label for='TalonarioF'>Talonario</label>
<input type='checkbox' id='TalonarioF' name='TalonarioF' checked='checked' /><br />

<label for='Detalle'>Detalle</label>
<input type='text' id='Detalle' name='Detalle' size='40' maxlength='60' value='<?php echo set_value('Detalle'); ?>' />
<?php echo '<br />'.form_error('Detalle'); ?>

<button class='button positive' style='margin-left:220px;'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='' /> Guardar
</button> 	  
</form>
</fieldset>
</div>