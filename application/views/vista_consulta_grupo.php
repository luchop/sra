<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Consulta de datos de grupo</legend>
<br />
<label for='Nombre'>Nombre</label>
<?php echo $Fila->Nombre; ?><br />

<label for='Correo'>Correo electr&oacute;nico</label>
<?php echo $Fila->CorreoAdministrador; ?>
<?php echo '<br />'.form_error('Correo'); ?>

<label for='Activo'>Activo</label>
<input type='checkbox' id='Activo' name='Activo' disabled='disabled' <?php echo ($Fila->Activo==1?'checked':''); ?> /><br />

</fieldset>
</div>