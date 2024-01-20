<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Dashboardagente
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function totalclientes()
	{
        $id = $_SESSION["id_usuario"];

		$sql="SELECT count(c.id_cliente) as total FROM clientes c, prestamos p, usuarios u where c.estado_cliente = '1' and c.id_cliente = p.id_cliente
        and p.id_usuario and u.id_usuario and u.id_usuario = '$id'";
		return ejecutarConsulta($sql);
	}

    public function totalganancias()
	{
        $id = $_SESSION["id_usuario"];

		$sql="SELECT IFNULL(ROUND(SUM(pp.totalpagar), 2),0) as total_ganancias FROM pago_prestamos pp, usuarios u, prestamos p 
        where p.id_usuario = u.id_usuario and pp.id_prest = p.id_prest
        and  pp.estado_pago = 'PAGADO' and u.id_usuario = '$id'";
		return ejecutarConsulta($sql);
	}

    public function totalgananciashoy()
	{
        $id = $_SESSION["id_usuario"];

		$sql="SELECT IFNULL(ROUND(SUM(pp.totalpagar), 2),0) as total_saldo FROM pago_prestamos pp, usuarios u, prestamos p WHERE pp.fecha_reg=curdate() 
        and pp.estado_pago = 'PAGADO' and p.id_usuario = u.id_usuario and pp.id_prest = p.id_prest and u.id_usuario = '$id'";
		return ejecutarConsulta($sql);
	}


	public function ventasultimos_12meses()
	{
        $id = $_SESSION["id_usuario"];

		$sql="SELECT DATE_FORMAT(pp.fecha_reg, '%m/%Y') as fecha_actual, ROUND(SUM(pp.totalpagar), 2) as total FROM pago_prestamos pp, usuarios u, prestamos p
        WHERE pp.estado_pago = 'PAGADO' and u.id_usuario = p.id_usuario and p.id_prest = pp.id_prest 
        and u.id_usuario = '$id' GROUP by MONTH(pp.fecha_reg) ORDER BY pp.fecha_reg ASC limit 0,10";
		return ejecutarConsulta($sql);
	}

	/* public function reportediario(){
        $id = $_SESSION["id_usuario"];

		$sql2="SELECT sum(pp.totalpagar) as 'total', u.nombre_usuario, u.apellido_usuario from prestamos p, pago_prestamos pp, 
		usuarios u where p.id_prest = pp.id_prest and p.id_usuario = u.id_usuario and pp.estado_pago = 'PAGADO' and pp.fecha_reg=curdate() GROUP BY u.id_usuario";
		return ejecutarConsulta($sql2);
	} */
    
}

?>