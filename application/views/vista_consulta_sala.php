<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Consulta de datos de sala</legend>
<br />
<label for='Nombre'>Nombre </label>
<?php echo $Fila->Nombre; ?><br />

<label for='Descripcion'>Descripci&oacute;n </label>
<?php echo $Fila->Descripcion; ?><br />

<label for='CodGrupo'>Grupo </label>
<?php echo $NombreGrupo; ?><br />

<label for='Capacidad'>Capacidad </label>
<?php echo $Fila->Capacidad; ?><br />

<label for='Correo'>Correo electr&oacute;nico </label>
<?php echo $Fila->CorreoAdministrador; ?><br />

<label for='Activo'>Activo</label>
<input type='checkbox' id='Activo' name='Activo' disabled='disabled' <?php echo ($Fila->Activo==1?'checked':''); ?> /><br />

<label for='Orden'>Orden </label>
<?php echo $Fila->Orden; ?><br />

</fieldset>
</div>