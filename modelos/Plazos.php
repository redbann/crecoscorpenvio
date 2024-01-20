<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Plazos
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($plazo,$porc_int)
	{
		$sql="INSERT INTO plazos (plazo,porc_int,estado_plazo)
		VALUES ('$plazo','$porc_int','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_plazo,$plazo,$porc_int)
	{
		$sql="UPDATE plazos SET plazo='$plazo',porc_int='$porc_int' WHERE id_plazo='$id_plazo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($id_plazo)
	{
		$sql="UPDATE plazos SET estado_plazo ='0' WHERE id_plazo='$id_plazo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_plazo)
	{
		$sql="UPDATE plazos SET estado_plazo ='1' WHERE id_plazo='$id_plazo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_plazo)
	{
		$sql="SELECT * FROM plazos WHERE id_plazo='$id_plazo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * from plazos";
		return ejecutarConsulta($sql);		
	}

    public function select(){
		$sql="SELECT * FROM plazos where estado_plazo = '1'";
		return ejecutarConsulta($sql);
    }
}

?>