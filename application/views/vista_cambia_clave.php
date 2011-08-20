<script type="text/javascript">

$(document).ready(function(){
    $("#Clave").validate({
  rules: {
    ClaveActual: {
      required: true
    },
	NuevaClave1: {
      required: true,
      minlength: 6
    },
	NuevaClave2: {
      required: true,
      minlength: 6,
	  equalTo: NuevaClave1
    }
  }
})});
</script>
<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Cambio de contrase&ntilde;a</legend>
<br />
<?php 
echo form_open("cambia_clave",  array('id' => 'Clave', 'name' => 'Clave'));
?>

<label for='ClaveActual'>Clave actual *</label>
<input type='password' name='ClaveActual' id='ClaveActual' maxlength='15' size='20' value='' /><br />

<label for='NuevaClave1'>Nueva clave *</label>
<input type='password' name='NuevaClave1' id='NuevaClave1' maxlength='15' size='20' minlength='6' value='' /><br />

<label for='NuevaClave2'>Confirmaci&oacute;n de clave *</label>
<input type='password' name='NuevaClave2' id='NuevaClave2' maxlength='15' size='20' value='' /><br />

<button class='button positive' style='margin-left:220px;'> 
	<img src='<?php echo base_url();?>bt/images/icons/tick.png' alt='' /> Guardar
</button> 	  
</form>
</fieldset>
</div>