<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Usuario
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function mostrar_login($login_us)
	{
		$sql="SELECT * FROM usuarios WHERE login_us = '$login_us'";
		return ejecutarConsultaContar($sql);
	}

	public function mostrar_login2($login_us, $id_usuario)
	{
		$sql="SELECT * FROM usuarios WHERE login_us = '$login_us' and id_usuario = '$id_usuario'";
		return ejecutarConsultaContar($sql);
	}

	public function mostrar_cedula($cedula_usuario)
	{
		$sql="SELECT * FROM usuarios u, datospersonales d WHERE d.id_datosp = u.id_datosp and d.cedula = '$cedula_usuario'";
		return ejecutarConsultaContar($sql);
	}

	public function mostrar_cedula2($cedula_usuario, $id_usuario)
	{
		$sql="SELECT * FROM usuarios u, datospersonales d WHERE d.id_datosp = u.id_datosp and d.cedula = '$cedula_usuario' and u.id_usuario = '$id_usuario'";
		return ejecutarConsultaContar($sql);
	}

	//Implementamos un método para insertar registros
	public function insertar($cedula_usuario,$nombre_usuario,$apellido_usuario,$telefono_usuario,$direccion_usuario,$login_us,$clave_us,$imagen_usuario,$id_permiso)
	{
		$sql2="INSERT INTO datospersonales (cedula,nombres,apellidos,direccion,telefono)
		VALUES ('$cedula_usuario','$nombre_usuario','$apellido_usuario','$direccion_usuario','$telefono_usuario')";
		$iddatosp = ejecutarConsulta_retornarID($sql2);

		$sql="INSERT INTO usuarios (id_datosp,login_us,clave_us,imagen_usuario,estado_usuario)
		VALUES ('$iddatosp','$login_us','$clave_us','$imagen_usuario','1')";
		//return ejecutarConsulta($sql);
		$idusuarionew=ejecutarConsulta_retornarID($sql);
	
			$sql_detalle = "INSERT INTO usuario_permisos(id_usuario, id_permiso) VALUES('$idusuarionew', '$id_permiso')";
			return ejecutarConsulta($sql_detalle);
		
	}

	//Implementamos un método para editar registros
	public function editar($id_usuario,$cedula_usuario,$nombre_usuario,$apellido_usuario,$telefono_usuario,$direccion_usuario,$login_us,$clave_us,$imagen_usuario,$id_permiso)
	{
		$sql="UPDATE usuarios SET login_us='$login_us',clave_us='$clave_us',imagen_usuario='$imagen_usuario' WHERE id_usuario='$id_usuario'";
		ejecutarConsulta($sql);

		$sqld = "SELECT id_datosp from usuarios where id_usuario = '$id_usuario'";
		$cd = ejecutarConsultaID10($sqld);

		$sql2="UPDATE datospersonales SET cedula = '$cedula_usuario', nombres = '$nombre_usuario', apellidos = '$apellido_usuario', direccion = '$direccion_usuario', telefono = '$telefono_usuario'
		where id_datosp = '$cd'";
		ejecutarConsulta($sql2);

		$sql_detalle = "UPDATE usuario_permisos SET id_permiso = '$id_permiso' where id_usuario = '$id_usuario'";
		return ejecutarConsulta($sql_detalle);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($id_usuario)
	{
		$sql="UPDATE usuarios SET estado_usuario='0' WHERE id_usuario='$id_usuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_usuario)
	{
		$sql="UPDATE usuarios SET estado_usuario='1' WHERE id_usuario='$id_usuario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_usuario)
	{
		$sql="SELECT * FROM usuarios u, datospersonales d, permisos p, usuario_permisos up WHERE  
		u.id_usuario = up.id_usuario and p.id_permiso = up.id_permiso and u.id_usuario='$id_usuario'
		and d.id_datosp = u.id_datosp";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM usuarios u, permisos p, usuario_permisos up, datospersonales d 
		where d.id_datosp = u.id_datosp and p.id_permiso = up.id_permiso and u.id_usuario = up.id_usuario and (p.id_permiso = 1 || p.id_permiso = 2)";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los permisos marcados
	public function listarmarcados($id_usuario)
	{
		$sql="SELECT * FROM usuario_permisos WHERE id_usuario='$id_usuario'";
		return ejecutarConsulta($sql);
	}

	//Función para verificar el acceso al sistema
	public function verificar($login_us,$clave_us)
    {
    	$sql="SELECT * FROM usuarios u, datospersonales d WHERE u.id_datosp = d.id_datosp and u.login_us='$login_us' AND u.clave_us='$clave_us'"; 
    	return ejecutarConsulta($sql);  
    }
}

?>