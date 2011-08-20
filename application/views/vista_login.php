<script type="text/javascript">
$(document).ready(function() {
	$("#login").validate();
});
</script>
<?php
echo "<div class='span-12 prefix-7 suffix-5 last'>";
echo "<div style='background-image:url(".base_url()."imagenes/borde.jpg); background-repeat:no-repeat'>";
	echo "<div style='position:relative; left:50px; top:100px;'>";
	echo form_open('login/Autentificacion',  array('id' => 'login', 'name' => 'login'));
	if( isset($Error) ) echo "<em>$Error</em><br />";
	echo "Nombre de usuario<br />
	<input type='text' id='Nick' name='Nick' size='15' class='required' minlength='3' /><br /><br />
	Contrase&ntilde;a<br />
	<input type='password' id='Clave' name='Clave' size='15' class='required' minlength='6' /><br /><br />
	
	<button class='button positive' style='margin-left:80px;'> 
        <img src='".base_url()."bt/images/icons/key.png' alt='' /> Ingresar
    </button> 	  

	<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></div>"; 
echo "</form></div></div>";
?>