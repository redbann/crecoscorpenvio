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
if ($_SESSION['agente']==1)
{
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.print();">
<?php

//Incluímos la clase Venta
require_once "../modelos/Pagosprestamos.php";
//Instanaciamos a la clase con el objeto venta
$ventas = new Pagosprestamos();
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
$rspta = $ventas->reporte($_GET["id"]);
//Recorremos todos los valores obtenidos
$reg = $rspta->fetch_object();

//Establecemos los datos de la empresa
$empresa = "CRECOSCORP";
$nombre = "RECIBO DE PAGO";

?>
<div class="zona_impresion">
<!-- codigo imprimir -->
<br>
<table border="0" align="center" width="300px" class="operaciones">
<tr>
        <td align="center" class="operaciones">
        <!-- Mostramos los datos de la empresa en el documento HTML -->
        .::<strong> <?php echo $empresa; ?></strong>::.<br>
        <?php echo $nombre; ?><br>
        </td>
    </tr>
    <tr>
        <td  style="font-size:90%;">Fecha registrada: <?php echo $reg->fecha_reg; ?></td>
    </tr>
    <tr>
        <td  style="font-size:90%;">Fecha de pago: <?php echo $reg->fecha_pago; ?></td>
    </tr>
    <tr>
        <td  style="font-size:90%;">Fecha límite: <?php echo $reg->fecha_limite; ?></td>
    </tr>
    <tr>
        <!-- Mostramos los datos del cliente en el documento HTML -->
        <td style="font-size:90%;">Cliente: <?php echo $reg->nombres . ' '. $reg->apellidos; ?></td>
    </tr>
    <tr>
        <td style="font-size:90%;"><?php echo "Cédula: ".$reg->cedula ?></td>
    </tr>
    
    <tr>
        <td style="font-size:90%;">Nº de recibo: <?php echo $reg->id_pago ; ?></td>
    </tr>    
</table>
<br>
<!-- Mostramos los detalles de la venta en el documento HTML -->
<table border="0" align="center" width="300px">
    <tr>
        <td>Monto mensual.</td>
        <td>Mora</td>
        <td align="right">Total a pagar</td>
    </tr>
    <tr>
      <td colspan="8">=================================================</td>
    </tr>
    <?php
    $cantidad=0;
        echo "<tr>";
        echo "<td>$".$reg->monto_mensual."</td>";
        echo "<td>$".$reg->mora;
        echo "<td align='right'>$ ".$reg->totalpagar."</td>";
        echo "</tr>";
    
    ?>
    <!-- Mostramos los totales de la venta en el documento HTML -->
    <!-- <tr>
    <td>&nbsp;</td>
    <td align="right"><b>TOTAL:</b></td>
    <td align="right"><b>S/  <?php echo $reg->total_venta;  ?></b></td>
    
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td align="right"><b>IVA:</b></td>
    <td align="right"><b>S/  <?php echo $total_v_f;  ?></b></td>
    
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td align="right"><b>TOTAL FINAL:</b></td>
    <td align="right"><b>S/  <?php echo ROUND($reg->total_venta_final,2);  ?></b></td>
    
    </tr>
    <tr>
      <td colspan="3">Nº de productos: <?php echo $cantidad; ?></td>
    </tr>
    <tr> -->
      <td colspan="3">&nbsp;</td>
    </tr>      
    <tr>
      <td colspan="3" align="center">¡Gracias por su pago!</td>
    </tr>
    <tr>
      <td colspan="3" align="center">CRECOSCORP</td>
    </tr>
    <tr>
      <td colspan="3" align="center">La Libertad - Ecuador</td>
    </tr>
    
</table>
<br>
</div>
<p>&nbsp;</p>

</body>
</html>
<?php 
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>