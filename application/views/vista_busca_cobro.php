<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>B&uacute;squeda de cobro</legend>
<br />
<?php 
echo form_open("cobro/BuscaParaModificar/$Modificacion",  array('id' => 'Cobro', 'name' => 'Cobro'));
?>

<label for='Detalle'>Detalle </label>
<input id='Detalle' name='Detalle' size='40' maxlength='50' value='' /><br />

<button class='button positive' style='margin-left:220px;'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='' /> Buscar
</button> 	  
</form>
</fieldset>
</div>