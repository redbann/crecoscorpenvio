<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Prestamos.php";
$clientes= new Prestamos();

$id_prest = isset($_POST["id_prest"])? limpiarCadena($_POST["id_prest"]):"";
$id_usuario = isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
$id_cliente = isset($_POST["id_cliente"])? limpiarCadena($_POST["id_cliente"]):"";
$id_plazo = isset($_POST["id_plazo"])? limpiarCadena($_POST["id_plazo"]):"";
$monto = isset($_POST["monto"])? limpiarCadena($_POST["monto"]):"";
$id_garante = isset($_POST["id_garante"])? limpiarCadena($_POST["id_garante"]):"";
$dia_cobro = isset($_POST["dia_cobro"])? limpiarCadena($_POST["dia_cobro"]):"";
$dia_limite = isset($_POST["dia_limite"])? limpiarCadena($_POST["dia_limite"]):"";
$interes_mora = isset($_POST["interes_mora"])? limpiarCadena($_POST["interes_mora"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        //si el id esta vacio --empty
        //Hash SHA256 en la contraseña
        
        if(empty($id_prest)){
            $rspta= $clientes->insertar($id_usuario,$id_cliente,$id_plazo,$monto,$id_garante,$dia_cobro,$dia_limite,$interes_mora);
            echo "Préstamo registrado";
        }
        else{
            $rspta= $clientes->editar($id_prest,$id_usuario,$id_cliente,$id_plazo,$monto,$id_garante,$dia_cobro,$dia_limite,$interes_mora);
            echo $rspta ? "Préstamo actualizado" : "No se pudo actualizar el préstamo";
        }   
        break;

    case 'mostrar':
		$rspta=$clientes->mostrar($id_prest);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

        $rspta2=$clientes->listar2();
        $data= Array(); //se declara un array
        while($reg2=$rspta2->fetch_object()){ //recorre los registros de la tabla
                $id_prest = $reg2->id_prest;
            $rspta=$clientes->listar($id_prest);
            while($reg=$rspta->fetch_object()){
                    if($reg->id_prest == $id_prest){
                        $data[]=array(
                            "0"=>($reg->estado_prest=='POR APROBAR')?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_prest.')"><i class="fa fa-pencil-square-o"></i></button>'.
                            ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_prest.')"><i class="fa fa-trash"></i></button>'.
                            ' <button class="btn btn-primary" onclick="aprobar('.$reg->id_prest.')"><i class="fa fa-check"></i></button>':
                            '<button class="btn btn-warning" onclick="mostrar('.$reg->id_prest.')"><i class="fa fa-pencil-square-o"></i></button>'.
                            ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_prest.')"><i class="fa fa-trash"></i></button>',
                            "1"=>$reg2->nombre_usuario.' '.$reg2->apellido_usuario,
                            "2"=>$reg->nombres.' '.$reg->apellidos,
                            "3"=>$reg->plazo,
                            "4"=>$reg->monto,
                            "5"=>$reg->dia_cobro,
                            "6"=>$reg->dia_limite,
                            "7"=>($reg->estado_prest == 'APROBADO')?'<span class="label bg-green">'.$reg->estado_prest.'</span>':'<span class="label bg-red">'.$reg->estado_prest.'</span>'
                        );
                    }
                    }
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
            $rspta=$clientes->desactivar($id_prest);
            echo $rspta ? "Préstamo eliminado" : "Préstamo no se puede eliminar";
        break;


    case 'aprobar':
            $rspta=$clientes->aprobar($id_prest);
            echo $rspta ? "Préstamo aprobado" : "Préstamo no se puede aprobar";
        break;

    case 'selectusuarios':
                    $rspta = $clientes -> selectusuarios();
                    while($reg = $rspta->fetch_object())
                    {
                        echo '<option value=' . $reg->id_usuario . '>' . $reg->nombres . ' '. $reg->apellidos .' </option>';
                    }
        break;

        case 'selectclientes':
            $rspta = $clientes -> selectclientes();
            while($reg = $rspta->fetch_object())
            {
                echo '<option value=' . $reg->id_cliente . '>' . $reg->nombres . ' '. $reg->apellidos .' </option>';
            }

            case 'selectgarantes':
                $rspta = $clientes -> selectgarantes();
                while($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->id_garante . '>' . $reg->nombres . ' '. $reg->apellidos .' </option>';
                }
break;

case 'selectplazos':
    $rspta = $clientes -> selectplazos();
    while($reg = $rspta->fetch_object())
    {
        echo '<option value=' . $reg->id_plazo . '>' . $reg->plazo.' </option>';
    }
break;
}
ob_end_flush();
?>