<script type="text/javascript">
$(document).ready(function() {
	$("#Contrato").validate();
});
</script>
<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>B&uacute;squeda de contrato</legend>
<br />
<?php 
echo form_open("contrato/BuscaParaModificar/$Modificacion",  array('id' => 'Contrato', 'name' => 'Contrato'));
?>

<label for='CodInstitucion'>Instituci&oacute;n </label>
<?php echo $ComboInstituciones; ?><br />

<label for='Desde'>Desde </label>
<?php
echo "<input type='text' name='Desde' id='Desde' size='12' maxlength='10' class='date' onclick='";
echo 'fPopCalendar("Desde")'."' value='".$Desde."'/>";
?><br />

<label for='Hasta'>Hasta </label>
<?php
echo "<input type='text' name='Hasta' id='Hasta' size='12' maxlength='10' class='date' onclick='";
echo 'fPopCalendar("Hasta")'."' value='".$Hasta."'/>";
?><br />

<button class='button positive' style='margin-left:220px;'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='' /> Buscar
</button> 	  
</form>
</fieldset>
</div>