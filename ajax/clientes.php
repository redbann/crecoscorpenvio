<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Clientes.php";
$clientes= new Clientes();

$id_cliente = isset($_POST["id_cliente"])? limpiarCadena($_POST["id_cliente"]):"";
$cedula = isset($_POST["cedula"])? limpiarCadena($_POST["cedula"]):"";
$nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$apellido = isset($_POST["apellido"])? limpiarCadena($_POST["apellido"]):"";
$direccion_dom = isset($_POST["direccion_dom"])? limpiarCadena($_POST["direccion_dom"]):"";
$lat = isset($_POST["lat"])? limpiarCadena($_POST["lat"]):"";
$lng = isset($_POST["lng"])? limpiarCadena($_POST["lng"]):"";
$telefono = isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$direccion_tra = isset($_POST["direccion_tra"])? limpiarCadena($_POST["direccion_tra"]):"";
$nombre_conyuge = isset($_POST["nombre_conyuge"])? limpiarCadena($_POST["nombre_conyuge"]):"";
$cedula_conyuge = isset($_POST["cedula_conyuge"])? limpiarCadena($_POST["cedula_conyuge"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        //si el id esta vacio --empty
        //Hash SHA256 en la contraseña
        
        if(empty($id_cliente)){
            $rspta= $clientes->insertar($cedula,$nombre,$apellido,$direccion_dom,$lat,$lng,$telefono,$direccion_tra,$nombre_conyuge,$cedula_conyuge);
            echo "Cliente registrado";
        }
        else{
            $rspta= $clientes->editar($id_cliente,$cedula,$nombre,$apellido,$direccion_dom,$lat,$lng,$telefono,$direccion_tra,$nombre_conyuge,$cedula_conyuge);
            echo $rspta ? "Cliente actualizado" : "No se pudo actualizar el cliente";
        }   
        break;

    case 'mostrar':
		$rspta=$clientes->mostrar($id_cliente);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$clientes->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>($reg->estado_cliente)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_cliente.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_cliente.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_cliente.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->id_cliente.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->cedula,
                "2"=>$reg->nombres.' '.$reg->apellidos,
                "3"=>$reg->direccion,
                "4"=>$reg->telefono,
                "5"=>$reg->direccion_tra,
                "6"=>($reg->estado_cliente)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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

       

case 'desactivar':
            $rspta=$clientes->desactivar($id_cliente);
            echo $rspta ? "Cliente desactivado" : "Cliente no se puede desactivar";
        break;


    case 'activar':
            $rspta=$clientes->activar($id_cliente);
            echo $rspta ? "Cliente activado" : "Cliente no se puede activar";
        break;
}
ob_end_flush();
?>