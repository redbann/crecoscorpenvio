<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Pagosprestamos
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para editar registros
	public function editar($id_pago,$totalpagar,$fecha_reg)
	{
        $fechaActual = date('Y-m-d');
		$sql="UPDATE pago_prestamos SET totalpagar='$totalpagar',fecha_reg='$fechaActual', estado_pago = 'PAGADO' 
        WHERE id_pago='$id_pago'";
		return ejecutarConsulta($sql);
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
	public function mostrar($id_pago)
	{
		$sql="SELECT * FROM pago_prestamos pp, prestamos p, clientes c, datospersonales d 
        WHERE pp.id_pago='$id_pago' and pp.id_prest = p.id_prest and c.id_cliente = p.id_cliente and c.id_datosp = d.id_datosp";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function reporte($id_pago)
	{
		$sql="SELECT * FROM pago_prestamos pp, prestamos p, clientes c, datospersonales d 
        WHERE pp.id_pago='$id_pago' and pp.id_prest = p.id_prest and c.id_cliente = p.id_cliente and d.id_datosp = c.id_datosp";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar($fecha_inicio,$fecha_fin)
	{
        $id = $_SESSION["id_usuario"];

		$sql="SELECT * from pago_prestamos pp, prestamos p, usuarios u, clientes c, datospersonales d
        where pp.id_prest = p.id_prest and p.id_usuario = u.id_usuario and d.id_datosp = c.id_datosp
        and c.id_cliente = p.id_cliente and u.id_usuario = '$id' and (pp.fecha_pago>='$fecha_inicio' and pp.fecha_pago<='$fecha_fin' or 
		pp.fecha_limite>='$fecha_inicio' and pp.fecha_limite<='$fecha_fin')";
		return ejecutarConsulta($sql);		
	}

    public function selectprestamos(){
		$sql="SELECT * FROM prestamos p, clientes c, datospersonales d where c.id_cliente = p.id_cliente and d.id_datosp = c.id_datosp";
		return ejecutarConsulta($sql);
    }

	public function actualizar(){
		$fechaActual = date('Y-m-d');
		$diaActual = date('d');
		$mesActual = date('m');
		$anioActual = date('Y');

		$sql="UPDATE pago_prestamos pp, prestamos p SET pp.mora = pp.monto_mensual*(p.interes_mora/100), 
		pp.totalpagar = pp.monto_mensual+(pp.monto_mensual*(p.interes_mora/100)) 
		WHERE p.id_prest = pp.id_prest and '$diaActual' > p.dia_limite and '$mesActual'  >= month(pp.fecha_pago) 
		and '$anioActual'  >= year(pp.fecha_pago) and pp.estado_pago = 'Pendiente'";
		return ejecutarConsulta($sql);
	}
}

?>