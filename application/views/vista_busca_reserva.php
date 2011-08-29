<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>B&uacute;squeda de reservas</legend>
<br />
<?php 
echo form_open("reserva/BuscaParaModificar/$Modificacion",  array('id' => 'Reserva', 'name' => 'Reserva'));
?>

<label for='Nombre'>Nombre </label>
<input id='Nombre' name='Nombre' size='40' maxlength='50' value='' /><br />

<label for='Descripcion'>Descripci&oacute;n </label>
<input id='Descripcion' name='Descripcion' size='40' maxlength='50' value='' /><br />

<label for='CodSala'>Sala </label>
<?php echo $ComboSalas; ?><br />

<button class='button positive' style='margin-left:220px;'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='' /> Buscar
</button>
</form>
</fieldset>
</div>