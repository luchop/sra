<script type="text/javascript">
$(document).ready(function() {
	$("#Cobro").validate();
});
</script>
<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Modifica cobro</legend>
<br />
<?php 
echo form_open('cobro/ModificaCobro',  array('id' => 'Cobro', 'name' => 'Cobro'));
?>

<input type='hidden' id='CodCobro' name='CodCobro' value='<?php echo $Fila->CodCobro; ?>' />
<label for='Fecha'>Fecha *</label>
<?php
	echo "<input type='text' name='Fecha' id='Fecha' size='12' maxlength='10' onclick='";
	echo 'fPopCalendar("Fecha")'."' value='".$Fecha=$this->funciones->FechaDeMySQL($Fila->Fecha)."'/>";
?><br />

<label for='Monto'>Monto</label>
<input type='text' id='Monto' name='Monto' size='10' maxlength='10' value='<?php echo $Fila->Monto; ?>' /><br />

<label for='Factura'>Factura</label>
<input type='text' id='Factura' name='Factura' size='10' maxlength='10' value='<?php echo $Fila->Factura; ?>' /><br />

<label for='TalonarioF'>Talonario</label>
<input type='checkbox' id='TalonarioF' name='TalonarioF' <?php echo ($Fila->TalonarioF==1?'checked':''); ?> /><br />

<label for='Detalle'>Detalle</label>
<input type='text' id='Detalle' name='Detalle' size='40' maxlength='60' value='<?php echo $Fila->Detalle; ?>' />
<?php echo '<br />'.form_error('Detalle'); ?> 

<button class='button positive' style='margin-left:180px;' name='submit' value='Guardar'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='Graba las modificaciones' /> Guardar
</button>
<button class='button positive' name='submit' onclick='return confirm("Realmente desea borrar este registro?")'> 
	<img src='<?php echo base_url();?>bt/images/icons/cross.png' alt='Elimina este registro' value='Borrar' /> Borrar
</button> 	 

</form>
</fieldset>
</div>