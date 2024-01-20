<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Clientes
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($cedula,$nombre,$apellido,$direccion_dom,$lat,$lng,$telefono,$direccion_tra,$nombre_conyuge,$cedula_conyuge)
	{
		$sql2="INSERT INTO datospersonales (cedula,nombres,apellidos,direccion,telefono)
		VALUES ('$cedula','$nombre','$apellido','$direccion_dom','$telefono')";
		$iddatosp = ejecutarConsulta_retornarID($sql2);

		$sql="INSERT INTO clientes (id_datosp,lat,lng,direccion_tra,nombre_conyuge,cedula_conyuge,estado_cliente)
		VALUES ('$iddatosp','$lat','$lng','$direccion_tra','$nombre_conyuge','$cedula_conyuge','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_cliente,$cedula,$nombre,$apellido,$direccion_dom,$lat,$lng,$telefono,$direccion_tra,$nombre_conyuge,$cedula_conyuge)
	{
		$sql="UPDATE clientes SET lat='$lat', lng = '$lng',
		direccion_tra = '$direccion_tra', nombre_conyuge = '$nombre_conyuge', cedula_conyuge = '$cedula_conyuge' WHERE id_cliente='$id_cliente'";
		ejecutarConsulta($sql);

		$sqld = "SELECT id_datosp from clientes where id_cliente = '$id_cliente'";
		$cd = ejecutarConsultaID10($sqld);

		$sql2="UPDATE datospersonales SET cedula = '$cedula', nombres = '$nombre', apellidos = '$apellido', direccion = '$direccion_dom', telefono = '$telefono'
		where id_datosp = '$cd'";
		return ejecutarConsulta($sql2);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($id_cliente)
	{
		$sql="UPDATE clientes SET estado_cliente ='0' WHERE id_cliente='$id_cliente'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_cliente)
	{
		$sql="UPDATE clientes SET estado_cliente ='1' WHERE id_cliente='$id_cliente'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_cliente)
	{
		$sql="SELECT * FROM clientes c, datospersonales d WHERE d.id_datosp = c.id_datosp 
		and c.id_cliente='$id_cliente'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * from clientes c, datospersonales d where d.id_datosp = c.id_datosp";
		return ejecutarConsulta($sql);		
	}

    public function select(){
		$sql="SELECT * FROM clientes where estado_cliente = '1'";
		return ejecutarConsulta($sql);
    }
}

?>