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
$pdf->Cell(100,6,'LISTA DE CLIENTES',2,0,'C'); 
$pdf->Ln(10);
 
//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(178,41,48); 
$pdf->SetTextColor(255,255,255); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,utf8_decode('RUC/Cédula'),1,0,'C',1); 
$pdf->Cell(30,6,utf8_decode('Nombre'),1,0,'C',1);
$pdf->Cell(30,6,utf8_decode('Apellido'),1,0,'C',1);
$pdf->Cell(22,6,utf8_decode('Teléfono'),1,0,'C',1);
$pdf->Cell(40,6,utf8_decode('Dirección domicilio'),1,0,'C',1);
$pdf->Cell(40,6,utf8_decode('Dirección trabajo'),1,0,'C',1);
 
$pdf->Ln(10);
$pdf->SetTextColor(0,0,0);
//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Clientes.php";
$clientes = new Clientes();

$rspta = $clientes->listar();

//Table with rows and columns
$pdf->SetWidths(array(25,30,30,22,40,40));

while($reg= $rspta->fetch_object())
{  
    $cedula_cliente = $reg->cedula;
    $nombre_cliente = $reg->nombres;
    $apellido_cliente = $reg->apellidos;
    $telefono_cliente = $reg->telefono;
    $direccion_cliente =$reg->direccion;
    $direccion_tra = $reg->direccion_tra;
 	
 	$pdf->SetFont('Arial','',10);
    $pdf->Row(array(utf8_decode($cedula_cliente),utf8_decode($nombre_cliente),utf8_decode($apellido_cliente),utf8_decode($telefono_cliente),utf8_decode($direccion_cliente),utf8_decode($direccion_tra)));
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