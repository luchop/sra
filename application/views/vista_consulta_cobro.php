<div id='formulario' class='span-14 prefix-5 suffix-5 last'>
<fieldset><legend>Consulta cobro</legend>

<input type='hidden' id='CodCobro' name='CodCobro' value='<?php echo $Fila->CodCobro; ?>' />
<label for='Fecha'>Fecha *</label>
<?php echo $Fecha=$this->funciones->FechaDeMySQL($Fila->Fecha);
?><br />

<label for='Monto'>Monto</label>
<?php echo $Fila->Monto; ?><br />

<label for='Factura'>Factura</label>
<?php echo $Fila->Factura; ?><br />

<label for='TalonarioF'>Talonario</label>
<input type='checkbox' id='TalonarioF' name='TalonarioF' disabled='disabled' <?php echo ($Fila->TalonarioF==1?'checked':''); ?> /><br />

<label for='Detalle'>Detalle</label>
<?php echo $Fila->Detalle; ?>

</fieldset>
</div>