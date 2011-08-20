<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>B&uacute;squeda de sala</legend>
<br />
<?php 
echo form_open("sala/BuscaParaModificar/$Modificacion",  array('id' => 'Sala', 'name' => 'Sala'));
?>

<label for='Nombre'>Nombre </label>
<input id='Nombre' name='Nombre' size='40' maxlength='50' value='' /><br />

<button class='button positive' style='margin-left:220px;'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='' /> Buscar
</button> 	  
</form>
</fieldset>
</div>