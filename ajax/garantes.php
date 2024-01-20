<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Garantes.php";
$clientes= new Garantes();

$id_garante = isset($_POST["id_garante"])? limpiarCadena($_POST["id_garante"]):"";
$cedula = isset($_POST["cedula"])? limpiarCadena($_POST["cedula"]):"";
$nombres = isset($_POST["nombres"])? limpiarCadena($_POST["nombres"]):"";
$apellidos = isset($_POST["apellidos"])? limpiarCadena($_POST["apellidos"]):"";
$direccion = isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono = isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        //si el id esta vacio --empty
        //Hash SHA256 en la contraseña
        
        if(empty($id_garante)){
            $rspta= $clientes->insertar($cedula,$nombres,$apellidos,$direccion,$telefono);
            echo "Garante registrado";
        }
        else{
            $rspta= $clientes->editar($id_garante,$cedula,$nombres,$apellidos,$direccion,$telefono);
            echo $rspta ? "Garante actualizado" : "No se pudo actualizar el garante";
        }   
        break;

    case 'mostrar':
		$rspta=$clientes->mostrar($id_garante);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$clientes->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>($reg->estado_garante)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_garante.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_garante.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_garante.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->id_garante.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->cedula,
                "2"=>$reg->nombres.' '.$reg->apellidos,
                "3"=>$reg->direccion,
                "4"=>$reg->telefono,
                "5"=>($reg->estado_garante)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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
            $rspta=$clientes->desactivar($id_garante);
            echo $rspta ? "Garante desactivado" : "Garante no se puede desactivar";
        break;


    case 'activar':
            $rspta=$clientes->activar($id_garante);
            echo $rspta ? "Garante activado" : "Garante no se puede activar";
        break;
}
ob_end_flush();
?>