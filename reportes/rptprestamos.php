<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombres"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['administrador']==1)
{

//Inlcuímos a la clase PDF_MC_Table
require('PDF_MC_Table.php');
 
//Instanciamos la clase para generar el documento pdf
$pdf=new PDF_MC_Table();
 
//Agregamos la primera página al documento pdf
$pdf->AddPage();
 
//Seteamos el inicio del margen superior en 25 pixeles 
$y_axis_initial = 25;
 
$pdf->Image("../files/Maderera.png",-12,1, 250, 45);
$pdf->cell(80);
$pdf->Ln(50);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,6,'',0,0,'C');
$pdf->Cell(100,6,utf8_decode('LISTA DE PRÉSTAMOS'),2,0,'C'); 
$pdf->Ln(10);
 
//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(178,41,48); 
$pdf->SetTextColor(255,255,255); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,utf8_decode('Agente'),1,0,'C',1); 
$pdf->Cell(30,6,utf8_decode('Cliente'),1,0,'C',1);
$pdf->Cell(30,6,utf8_decode('Plazo'),1,0,'C',1);
$pdf->Cell(22,6,utf8_decode('Fecha'),1,0,'C',1);
$pdf->Cell(40,6,utf8_decode('Monto'),1,0,'C',1);
$pdf->Cell(20,6,utf8_decode('Día cobro'),1,0,'C',1);
$pdf->Cell(20,6,utf8_decode('Día límite'),1,0,'C',1);
 
$pdf->Ln(10);
$pdf->SetTextColor(0,0,0);
//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Prestamos.php";
$clientes = new Prestamos();
$rspta2=$clientes->listar2();


//Table with rows and columns
$pdf->SetWidths(array(25,30,30,22,40,20,20));

while($reg2= $rspta2->fetch_object())
{  
  $id_prest = $reg2->id_prest;
  $rspta = $clientes->listar($id_prest);

  while($reg=$rspta->fetch_object()){
    if($reg->id_prest == $id_prest){
      $nombre_usuario = $reg2->nombre_usuario;
      $apellido_usuario = $reg2->apellido_usuario;
      $nombre = $reg->nombres;
      $apellido = $reg->apellidos;
      $plazo =$reg->plazo;
      $fecha_prest = $reg->fecha_prest;
      $monto = $reg->monto;
      $dia_cobro = $reg->dia_cobro;
      $dia_limite = $reg->dia_limite;
     
     $pdf->SetFont('Arial','',10);
      $pdf->Row(array(utf8_decode($nombre_usuario)." ".utf8_decode($apellido_usuario),utf8_decode($nombre)." ".utf8_decode($apellido),utf8_decode($plazo),utf8_decode($fecha_prest),utf8_decode($monto),utf8_decode($dia_cobro),utf8_decode($dia_limite)));
    }
    
  }
   
}
 
//Mostramos el documento pdf
$pdf->Output();

?>
<?php
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>