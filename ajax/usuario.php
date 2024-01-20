<?php
ob_start();
if (strlen(session_id()) < 1){
    session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Usuario.php";
$empleados= new Usuario();

$id_usuario = isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
$cedula_usuario = isset($_POST["cedula_usuario"])? limpiarCadena($_POST["cedula_usuario"]):"";
$nombre_usuario = isset($_POST["nombre_usuario"])? limpiarCadena($_POST["nombre_usuario"]):"";
$apellido_usuario = isset($_POST["apellido_usuario"])? limpiarCadena($_POST["apellido_usuario"]):"";
$telefono_usuario = isset($_POST["telefono_usuario"])? limpiarCadena($_POST["telefono_usuario"]):"";
$direccion_usuario = isset($_POST["direccion_usuario"])? limpiarCadena($_POST["direccion_usuario"]):"";
$login_us = isset($_POST["login_us"])? limpiarCadena($_POST["login_us"]):"";
$clave_us = isset($_POST["clave_us"])? limpiarCadena($_POST["clave_us"]):"";
$imagen_usuario = isset($_POST["imagen_usuario"])? limpiarCadena($_POST["imagen_usuario"]):"";
$id_permiso = isset($_POST["id_permiso"])? limpiarCadena($_POST["id_permiso"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        //si el id esta vacio --empty
        if(!file_exists($_FILES['imagen_usuario']['tmp_name']) || !is_uploaded_file($_FILES['imagen_usuario']['tmp_name']))
        {
            $imagen_usuario=$_POST["imagenactual"];
        }else{
            $ext = explode(".", $_FILES["imagen_usuario"]["name"]);
            if($_FILES['imagen_usuario']['type'] == "image/jpg" || $_FILES['imagen_usuario']['type'] == "image/jpeg" || $_FILES['imagen_usuario']['type'] == "image/png")
            {
                $imagen_usuario = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["imagen_usuario"]["tmp_name"],"../files/usuarios/" . $imagen_usuario);
            }
        }

        //Hash SHA256 en la contraseña
        $clave1 = hash("MD5",$clave_us);
        $clavehash=hash("SHA256",$clave1);

        if(empty($id_usuario)){
            $rspta2 = $empleados->mostrar_login($login_us);
            $cantidad2 = count($rspta2);

            $rsptaced = $empleados->mostrar_cedula($cedula_usuario);
            $cantidadced = count($rsptaced);

            if($cantidad2 == 0){
                if(strlen($clave_us)<8){
                    echo $rspta2 ? "La clave debe tener al menos 8 caracteres" : "La clave debe tener al menos 8 caracteres";
                }else{
                        if($cantidadced == 0){
                            $rspta= $empleados->insertar($cedula_usuario,$nombre_usuario,$apellido_usuario,$telefono_usuario,$direccion_usuario,$login_us,$clave_us,$imagen_usuario,$id_permiso);
                            echo $rspta ? "Usuario Registrado" : "No se pudo registrar el usuario";
                        }else{
                            echo "Usuario ya existe";
                        }
                }
            }else{
                echo $rspta2 ? "Nombre de usuario ya existe" : "Nombre de usuario ya existe";
            } 

           
        }
        else{
            $rspta3 = $empleados->mostrar_login2($login_us,$id_usuario);
            $cantidad3 = count($rspta3);
            $rspta4 = $empleados->mostrar_login($login_us);
            $cantidad4  = count($rspta4);

            $rsptaced2 = $empleados->mostrar_cedula2($cedula_usuario,$id_usuario);
            $cantidadced2 = count($rsptaced2);
            $rsptaced3 = $empleados->mostrar_cedula($cedula_usuario);
            $cantidadced3 = count($rsptaced3);

            if($cantidad3 == 1){
               
                    if(strlen($clave_us) == 64){
                        $rspta= $empleados->editar($id_usuario,$cedula_usuario,$nombre_usuario,$apellido_usuario,$telefono_usuario,$direccion_usuario,$login_us,$clave_us,$imagen_usuario,$id_permiso);
                 echo $rspta ? "Usuario actualizado" : "No se pudo actualizar el Usuario";
                 }else{
                     $rspta= $empleados->editar($id_usuario,$cedula_usuario,$nombre_usuario,$apellido_usuario,$telefono_usuario,$direccion_usuario,$login_us,$clavehash,$imagen_usuario,$id_permiso);
                 echo $rspta ? "Usuario actualizado" : "No se pudo actualizar el Usuario";
                 }
                }else if($cantidadced3 == 0){
                    if(strlen($clave_us) == 64){
                        $rspta= $empleados->editar($id_usuario,$cedula_usuario,$nombre_usuario,$apellido_usuario,$telefono_usuario,$direccion_usuario,$login_us,$clave_us,$imagen_usuario,$id_permiso);
                 echo $rspta ? "Usuario actualizado" : "No se pudo actualizar el Usuario";
                 }else{
                     $rspta= $empleados->editar($id_usuario,$cedula_usuario,$nombre_usuario,$apellido_usuario,$telefono_usuario,$direccion_usuario,$login_us,$clavehash,$imagen_usuario,$id_permiso);
                 echo $rspta ? "Usuario actualizado" : "No se pudo actualizar el Usuario";
                 }
               
            }else if($cantidad4 == 0){
               
                    if(strlen($clave_us) == 64){
                        $rspta= $empleados->editar($id_usuario,$cedula_usuario,$nombre_usuario,$apellido_usuario,$telefono_usuario,$direccion_usuario,$login_us,$clave_us,$imagen_usuario,$id_permiso);
                 echo $rspta ? "Usuario actualizado" : "No se pudo actualizar el Usuario";
                 }else{
                     $rspta= $empleados->editar($id_usuario,$cedula_usuario,$nombre_usuario,$apellido_usuario,$telefono_usuario,$direccion_usuario,$login_us,$clavehash,$imagen_usuario,$id_permiso);
                 echo $rspta ? "Usuario actualizado" : "No se pudo actualizar el Usuario";
                 }
                
                    if(strlen($clave_us) == 64){
                        $rspta= $empleados->editar($id_usuario,$cedula_usuario,$nombre_usuario,$apellido_usuario,$telefono_usuario,$direccion_usuario,$login_us,$clave_us,$imagen_usuario,$id_permiso);
                 echo $rspta ? "Usuario actualizado" : "No se pudo actualizar el Usuario";
                 }else{
                     $rspta= $empleados->editar($id_usuario,$cedula_usuario,$nombre_usuario,$apellido_usuario,$telefono_usuario,$direccion_usuario,$login_us,$clavehash,$imagen_usuario,$id_permiso);
                 echo $rspta ? "Usuario actualizado" : "No se pudo actualizar el Usuario";
                 }
                
            }else{
                echo $rspta3 ? "Nombre de usuario ya existe".$cantidad4 : "Nombre de usuario ya existe".$cantidad4;
            }
        }   
        break;

    case 'mostrar':
		$rspta=$empleados->mostrar($id_usuario);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
        break;

    case 'listar':

     $rspta=$empleados->listar();
        $data= Array(); //se declara un array
        while($reg=$rspta->fetch_object()){ //recorre los registros de la tabla
            $data[]=array(
                "0"=>($reg->estado_usuario)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_usuario.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_usuario.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->id_usuario.')"><i class="fa fa-pencil-square-o"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->id_usuario.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombres,
                "2"=>$reg->apellidos,
                "3"=>$reg->telefono,
                "4"=>$reg->direccion,
                "5"=>$reg->login_us,
                "6"=>"<img src ='../files/usuarios/".$reg->imagen_usuario."' height='50px', width='50px'>",
                "7"=>($reg->estado_usuario)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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
            $rspta=$empleados->desactivar($id_usuario);
            echo $rspta ? "Empleado eliminado" : "Empleado no se puede eliminar";
        break;


    case 'activar':
            $rspta=$empleados->activar($id_usuario);
            echo $rspta ? "Empleado activado" : "Empleado no se puede activar";
        break;

    case 'verificar':
        $logina=$_POST['logina'];
        $clavea=$_POST['clavea'];

        //Hash SHA256 en la contraseña
        $clave1 = hash("MD5",$clavea);
        $clavehash=hash("SHA256",$clave1);

        $rspta=$empleados->verificar($logina,$clavehash);

        $fetch=$rspta->fetch_object();

        if(isset($fetch))
        {
            //Declaramos las variables de sesión
            $_SESSION['id_usuario']=$fetch->id_usuario;
            $_SESSION['nombres']=$fetch->nombres;
            $_SESSION['apellidos']=$fetch->apellidos;
            $_SESSION['login_us']=$fetch->login_us;
            $_SESSION['imagen_usuario']=$fetch->imagen_usuario;


            //Obtenemos los permisos del usuario
            $marcados = $empleados->listarmarcados($fetch->id_usuario);

            //Declaramos el array para almacenar todos los permisos marcados
            $valores = array();

            //Almacenamos los permisos marcados en el array
            while($per = $marcados->fetch_object())
            {
                array_push($valores, $per->id_permiso);
            }

            //Determinamos los accesos del usuario
            in_array(1, $valores)?$_SESSION['administrador']=1:$_SESSION['administrador']=0;
            in_array(2, $valores)?$_SESSION['agente']=1:$_SESSION['agente']=0;
        }
            echo json_encode($fetch);
break;

    case 'salir':
        //Limpiamos las variables de sesión
    session_unset();
    //Destruimos la sesión
    session_destroy();
    //Redireccionamos al login
    header("Location: ../index.php");

    if (session_destroy()) {
    echo "Sesión destruida correctamente";
} else {
    echo "Error al destruir la sesión";
}

    break;
}
ob_end_flush();
?>