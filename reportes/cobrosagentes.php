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
$pdf->Cell(100,6,utf8_decode('COBROS DE PRÉSTAMO'),2,0,'C'); 
$pdf->Ln(10);
 
//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(178,41,48); 
$pdf->SetTextColor(255,255,255); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,6,utf8_decode('Estado'),1,0,'C',1); 
$pdf->Cell(30,6,utf8_decode('Agente'),1,0,'C',1);
$pdf->Cell(29,6,utf8_decode('Cliente'),1,0,'C',1);
$pdf->Cell(18,6,utf8_decode('Pago'),1,0,'C',1);
$pdf->Cell(30,6,utf8_decode('Fecha registrada'),1,0,'C',1);
$pdf->Cell(30,6,utf8_decode('Fecha de pago'),1,0,'C',1);
$pdf->Cell(30,6,utf8_decode('Fecha límite'),1,0,'C',1);
 
$pdf->Ln(10);
$pdf->SetTextColor(0,0,0);
//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Dashboard.php";
$clientes = new Dashboard();

$fecha_inicio=$_GET["fecha_inicio"];
$fecha_fin=$_GET["fecha_fin"];
$id_usuario=$_GET["id_usuario"];

require_once "../modelos/Prestamos.php";
$clientes = new Prestamos();
$rspta2=$clientes->listar2();

//Table with rows and columns
$pdf->SetWidths(array(20,30,29,18,30,30,30));

while($reg2= $rspta2->fetch_object())
{  
  $id_prest = $reg2->id_prest;

  require_once "../modelos/Dashboard.php";
  $clientes = new Dashboard();
  $rspta = $clientes->listarcobrosagentes($id_usuario,$fecha_inicio,$fecha_fin);

  while($reg=$rspta->fetch_object()){
    if($reg->id_prest == $id_prest){
      $nombre_usuario = $reg2->nombre_usuario;
      $apellido_usuario = $reg2->apellido_usuario;
      $est = $reg->estado_pago;
      $usu3 = $reg->nombres;
      $usu4 = $reg->apellidos;
      $totalpagar = $reg->totalpagar;
      $fecha_reg =$reg->fecha_reg;
      $fecha_pago = $reg->fecha_pago;
      $fecha_limite = $reg->fecha_limite;
     
 	
 	  $pdf->SetFont('Arial','',10);
    $pdf->Row(array(utf8_decode($est),utf8_decode($nombre_usuario)." ".utf8_decode($apellido_usuario),utf8_decode($usu3)." ".utf8_decode($usu4),utf8_decode($totalpagar),utf8_decode($fecha_reg),utf8_decode($fecha_pago),utf8_decode($fecha_limite)));
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