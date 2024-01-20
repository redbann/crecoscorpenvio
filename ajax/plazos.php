<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Plazos.php";
$clientes= new Plazos();

$id_plazo = isset($_POST["id_plazo"])? limpiarCadena($_POST["id_plazo"]):"";
$plazo = isset($_POST["plazo"])? limpiarCadena($_POST["plazo"]):"";
$porc_int = isset($_POST["porc_int"])? limpiarCadena($_POST["porc_int"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        //si el id esta vacio --empty
        //Hash SHA256 en la contraseña
        
        if(empty($id_plazo)){
            $rspta= $clientes->insertar($plazo,$porc_int);
            echo "Plazo registrado";
        }
        else{
            $rspta= $clientes->editar($id_plazo,$plazo,$porc_int);
            echo $rspta ? "Plazo actualizado" : "No se pudo actualizar el plazo";
        }   
        break;

    case 'mostrar':
		$rspta=$clientes->mostrar($id_plazo);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$clientes->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>($reg->estado_plazo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_plazo.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_plazo.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_plazo.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->id_plazo.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->plazo,
                "2"=>$reg->porc_int,
                "3"=>($reg->estado_plazo)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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
            $rspta=$clientes->desactivar($id_plazo);
            echo $rspta ? "Plazo desactivado" : "Plazo no se puede desactivar";
        break;


    case 'activar':
            $rspta=$clientes->activar($id_plazo);
            echo $rspta ? "Plazo activado" : "Plazo no se puede activar";
        break;
}
ob_end_flush();
?>