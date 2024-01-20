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
$pdf->Cell(100,6,utf8_decode('PAGOS DE PRÉSTAMO'),2,0,'C'); 
$pdf->Ln(10);
 
//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(178,41,48); 
$pdf->SetTextColor(255,255,255); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,utf8_decode('Estado'),1,0,'C',1); 
$pdf->Cell(30,6,utf8_decode('Nombre'),1,0,'C',1);
$pdf->Cell(18,6,utf8_decode('Pago'),1,0,'C',1);
$pdf->Cell(34,6,utf8_decode('Fecha registrada'),1,0,'C',1);
$pdf->Cell(40,6,utf8_decode('Fecha de pago'),1,0,'C',1);
$pdf->Cell(40,6,utf8_decode('Fecha límite'),1,0,'C',1);
 
$pdf->Ln(10);
$pdf->SetTextColor(0,0,0);
//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Dashboard.php";
$clientes = new Dashboard();

$fecha_inicio=$_GET["fecha_inicio"];
$fecha_fin=$_GET["fecha_fin"];
$id_cliente=$_GET["id_cliente"];

$rspta = $clientes->listarpagosclientes($id_cliente,$fecha_inicio,$fecha_fin);

//Table with rows and columns
$pdf->SetWidths(array(25,30,18,34,40,40));

while($reg= $rspta->fetch_object())
{  
    $cedula_cliente = $reg->estado_pago;
    $nombre_cliente = $reg->nombres;
    $apellido_cliente = $reg->apellidos;
    $totalpagar = $reg->totalpagar;
    $fecha_reg =$reg->fecha_reg;
    $fecha_pago = $reg->fecha_pago;
    $fecha_limite = $reg->fecha_limite;
 	
 	$pdf->SetFont('Arial','',10);
    $pdf->Row(array(utf8_decode($cedula_cliente),utf8_decode($nombre_cliente)." ".utf8_decode($apellido_cliente),utf8_decode($totalpagar),utf8_decode($fecha_reg),utf8_decode($fecha_pago),utf8_decode($fecha_limite)));
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