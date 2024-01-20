<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Pagospendientes.php";
$clientes= new Pagospendientes();

$id_pago = isset($_POST["id_pago"])? limpiarCadena($_POST["id_pago"]):"";
$id_prest = isset($_POST["id_prest"])? limpiarCadena($_POST["id_prest"]):"";
$monto_mensual = isset($_POST["monto_mensual"])? limpiarCadena($_POST["monto_mensual"]):"";
$fecha_pago = isset($_POST["fecha_pago"])? limpiarCadena($_POST["fecha_pago"]):"";
$fecha_limite = isset($_POST["fecha_limite"])? limpiarCadena($_POST["fecha_limite"]):"";
$mora = isset($_POST["mora"])? limpiarCadena($_POST["mora"]):"";
$totalpagar = isset($_POST["totalpagar"])? limpiarCadena($_POST["totalpagar"]):"";
$fecha_reg = isset($_POST["fecha_reg"])? limpiarCadena($_POST["fecha_reg"]):"";
$lat = isset($_POST["lat"])? limpiarCadena($_POST["lat"]):"";
$lng = isset($_POST["lng"])? limpiarCadena($_POST["lng"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        //si el id esta vacio --empty
        //Hash SHA256 en la contraseña
        
        if(empty($id_pago)){
        }
        else{
            $rspta= $clientes->editar($id_pago,$totalpagar,$fecha_reg);
            echo $rspta ? "Pago realizado" : "No se pudo realizar el pago";
        }   
        break;

    case 'mostrar':
		$rspta=$clientes->mostrar($id_pago);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':
        $fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];

     $rspta=$clientes->listar($fecha_inicio,$fecha_fin);
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $url='../reportes/exTicket.php?id=';
            $data[]=array(
                "0"=>($reg->estado_pago == 'Pendiente')?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_pago.')"><i class="fa fa-eye"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_pago.')"><i class="fa fa-eye"></i></button>'.
                '<a target="_blank" href="'.$url.$reg->id_pago.'"> <button class="btn btn-success"><i class="fa fa-file"></i></button></a>',
                "1"=>$reg->monto,
                "2"=>$reg->nombres.' '.$reg->apellidos,
                "3"=>$reg->fecha_pago,
                "4"=>$reg->fecha_limite,
                "5"=>$reg->fecha_reg,
                "6"=>$reg->monto_mensual,
                "7"=>$reg->mora,
                "8"=>$reg->totalpagar,
                "9"=>($reg->estado_pago=='PAGADO')?'<span class="label bg-green">PAGADO</span>':'<span class="label bg-yellow">PENDIENTE</span>'
            );
        }

        $results = array(
            "sEcho"=>1, 
            "iTotalRecords"=>count($data), //enviar total de registros al datatable
            "iTotalDisplayRecords"=>count($data), //envio total de registros a visualizar
            "aaData"=>$data
        );
        echo json_encode($results);

        break;

        case 'actualizar':
            $rspta= $clientes->actualizar();
            echo $rspta;
            break;

       

case 'desactivar':
            $rspta=$clientes->desactivar($id_pago);
            echo $rspta ? "Cliente desactivado" : "Cliente no se puede desactivar";
        break;


    case 'activar':
            $rspta=$clientes->activar($id_pago);
            echo $rspta ? "Pago realizado" : "Cliente no se puede activar";
        break;

        case 'selectprestamos':
            $rspta = $clientes -> selectprestamos();
            while($reg = $rspta->fetch_object())
            {
                echo '<option value=' . $reg->id_prest . '>' .'Cédula: '. $reg->cedula . ' - Cliente: '. $reg->nombres .' '. $reg->apellidos .' - Monto: $'. $reg->monto .' </option>';
            }
break;
}
ob_end_flush();
?>