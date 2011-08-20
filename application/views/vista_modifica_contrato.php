<script type="text/javascript">
$(document).ready(function() {
	$("#Contrato").validate();
});
</script>
<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Modificacion de datos de contrato</legend>
<br />
<?php 
echo form_open('contrato/ModificaContrato',  array('id' => 'Contrato', 'name' => 'Contrato'));
?>

<label for='CodInstitucion'>Institucion *</label>
<?php echo $ComboInstituciones; ?><br />

<input type='hidden' id='CodContrato' name='CodContrato' value='<?php echo $Fila->CodContrato; ?>' />

<label for='Desde'>Desde *</label>
<?php
echo "<input type='text' name='Desde' id='Desde' size='12' maxlength='10' class='required date' onclick='";
echo 'fPopCalendar("Desde")'."' value='".$this->funciones->FechaDeMySQL($Fila->Desde)."'/>";
?><br />

<label for='Hasta'>Hasta *</label>
<?php
echo "<input type='text' name='Hasta' id='Hasta' size='12' maxlength='10' class='required date' onclick='";
echo 'fPopCalendar("Hasta")'."' value='".$this->funciones->FechaDeMySQL($Fila->Hasta)."'/>";
?><br />

<label for='Precio'>Precio *</label>
<input type='text' id='Precio' name='Precio' size='10' maxlength='10' class='required number' value='<?php echo $Fila->Precio; ?>' /><br />

<label for='Notas'>Notas</label>
<textarea id='Notas' name='Notas' cols='45' rows='4'>
<?php echo $Fila->Notas; ?>
</textarea><br /><br />

<button name='submit' class='button positive' style='margin-left:220px;' value='Guardar'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='' /> Guardar cambios
</button> 	  
</form>
</fieldset>
</div>