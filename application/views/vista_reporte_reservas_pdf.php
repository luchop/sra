<?php
$Titulo = "Reporte de reservas";

$this->fpdf->SetAutoPageBreak(TRUE, 20);
$this->fpdf->Open();
$this->fpdf->setMargins(25, 10, 20);
$this->fpdf->SetTextColor(0,0,0);
$this->fpdf->AliasNbPages();
$this->fpdf->AddPage('P', 'Letter');

$this->fpdf->setFont('Arial', '', 12);

//$this->fpdf->Cell(25,5, 'Docente:', 0, 0, 'L');  $this->fpdf->Cell(0,5, utf8_decode($NombreDocente), 0, 1, 'L');
//$this->fpdf->Cell(25,5, 'Curso:', 0, 0, 'L');    $this->fpdf->Cell(40,5, utf8_decode($NombreCurso), 0, 1, 'L');
//$this->fpdf->Cell(25,5, 'Materia:', 0, 0, 'L');  $this->fpdf->Cell(40,5, utf8_decode($NombreMateria), 0, 1, 'L');
$this->fpdf->Cell(25,5, 'Fecha:', 0, 0, 'L');    $this->fpdf->Cell(25,5, $this->funciones->FechaLiteral(date('Y-m-d'),4), 0, 1, 'L');
//Espacio de separacion
$this->fpdf->Cell(25,5, '', 0, 1, 'L');

//cabezera de fila
$this->fpdf->setFont('times', 'B', 10);

$this->fpdf->setFillColor(220, 220, 220);
$this->fpdf->Cell(8, 5, ' No.', 1, 0, 'C',1);
$this->fpdf->Cell(25, 5, 'Fecha', 1, 0, 'C',1);
$this->fpdf->Cell(30, 5, 'Hora', 1, 0, 'C',1);
$this->fpdf->Cell(25, 5, 'Sala', 1, 0, 'C',1);
$this->fpdf->Cell(50, 5, 'Nombre', 1, 0, 'C',1);
$this->fpdf->Cell(25, 5, 'Usuario', 1, 1, 'C',1);

//cuerpo del reporte
$this->fpdf->setFont('times', '', 10);
$cont=0;
foreach ($Tabla->result() as $fila){
	$cont++;
	$this->fpdf->Cell(8, 5, $cont, 1, 0, 'R');
	$Fechas=$this->funciones->FechaLiteral(date('Y-m-d',$fila->HoraInicio));
	$this->fpdf->Cell(25, 5, ($Fechas), 1, 0, 'C');
	$Horas=date('H:i',$fila->HoraInicio).' - '.date('H:i',$fila->HoraFin);
	if ($fila->DiaCompleto==1)
		$Horas='Todo el dia';
	$this->fpdf->Cell(30, 5, ($Horas), 1, 0, 'C');
	$this->fpdf->Cell(25, 5, ($fila->NombreSala), 1, 0, 'L');
	$this->fpdf->Cell(50, 5, utf8_decode($fila->Nombre) , 1, 0, 'L');	
	$this->fpdf->Cell(25, 5, ($fila->NombreUsuario), 1, 1, 'L');
	
	if ($fila->Notas!='')
		$this->fpdf->Cell(163, 5, 'Notas: '.$fila->Notas, 1, 1, 'L');
}

$aux = "Reporte.pdf";
$this->fpdf->Output($aux,'D');