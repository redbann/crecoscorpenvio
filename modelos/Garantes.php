<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Garantes
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($cedula,$nombres,$apellidos,$direccion,$telefono)
	{
		$sql2="INSERT INTO datospersonales (cedula,nombres,apellidos,direccion,telefono)
		VALUES ('$cedula','$nombres','$apellidos','$direccion','$telefono')";
		$iddatosp = ejecutarConsulta_retornarID($sql2);

		$sql="INSERT INTO garantes (id_datosp,estado_garante)
		VALUES ('$iddatosp','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_garante,$cedula,$nombres,$apellidos,$direccion,$telefono)
	{

		$sqld = "SELECT id_datosp from garantes where id_garante = '$id_garante'";
		$cd = ejecutarConsultaID10($sqld);

		$sql2="UPDATE datospersonales SET cedula = '$cedula', nombres = '$nombres', apellidos = '$apellidos', direccion = '$direccion',
        telefono = '$telefono' where id_datosp = '$cd'";
		return ejecutarConsulta($sql2);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($id_garante)
	{
		$sql="UPDATE garantes SET estado_garante ='0' WHERE id_garante='$id_garante'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_garante)
	{
		$sql="UPDATE garantes SET estado_garante ='1' WHERE id_garante='$id_garante'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_garante)
	{
		$sql="SELECT * FROM garantes c, datospersonales d WHERE d.id_datosp = c.id_datosp 
		and c.id_garante='$id_garante'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * from garantes c, datospersonales d where d.id_datosp = c.id_datosp";
		return ejecutarConsulta($sql);		
	}

    public function select(){
		$sql="SELECT * FROM garantes where estado_garante = '1'";
		return ejecutarConsulta($sql);
    }
}

?>