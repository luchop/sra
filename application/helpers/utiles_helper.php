<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function Cero($n) {
	if( $n>0 )
		return round($n, 1);
	else
		return '';
}

function ConsonanteAleatoria($Longitud) {
	$Letras = 'bcdfFgjJlmnNpPqQrstvyzZ';  //23 car
	$s = '';
	for($i=0; $i<$Longitud; $i++)
		$s .= $Letras[rand(0, strlen($Letras)-1)];
	return $s;
}

function VocalAleatoria($Longitud) {
	$Letras = 'aAeEiouU';
	$s = '';
	for($i=0; $i<$Longitud; $i++)
		$s .= $Letras[rand(0, strlen($Letras)-1)];
	return $s;
}

function ClavePronunciable() {
	return ConsonanteAleatoria(1) . VocalAleatoria(1) . ConsonanteAleatoria(1) .
            VocalAleatoria(1) . ConsonanteAleatoria(1) . VocalAleatoria(1) .
            rand(11,99);
}


/* End of file utiles.php */