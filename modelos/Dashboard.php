<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if(strlen(session_id()) < 1)
	session_start();

Class Dashboard
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function totalclientes()
	{
		$sql="SELECT count(id_cliente) as total FROM clientes where estado_cliente = '1'";
		return ejecutarConsulta($sql);
	}

	public function totalagentes()
	{
		$sql="SELECT COUNT(u.id_usuario) AS total2 FROM usuarios u, permisos p, usuario_permisos up WHERE up.id_usuario = u.id_usuario
        and up.id_permiso = p.id_permiso and u.estado_usuario = '1' and p.id_permiso = '2'";
		return ejecutarConsulta($sql);
	}

	public function totalprestporaprobar()
	{
		$sql="SELECT COUNT(id_prest) AS id_prest FROM prestamos WHERE estado_prest = 'POR APROBAR'";
		return ejecutarConsulta($sql);
	}

	public function totalprestaprobados()
	{
		$sql="SELECT COUNT(id_prest) AS id_prest FROM prestamos WHERE estado_prest = 'APROBADO'";
		return ejecutarConsulta($sql);
	}

    public function totalganancias()
	{
		$sql="SELECT IFNULL(ROUND(SUM(totalpagar), 2),0) as total_ganancias FROM pago_prestamos where estado_pago = 'PAGADO'";
		return ejecutarConsulta($sql);
	}

    public function totalgananciashoy()
	{
		$sql="SELECT IFNULL(ROUND(SUM(totalpagar), 2),0) as total_saldo FROM pago_prestamos WHERE fecha_reg=curdate() and estado_pago = 'PAGADO'";
		return ejecutarConsulta($sql);
	}


	public function ventassultimos_10dias()
	{
		$sql="SELECT DATE_FORMAT(fecha_reg, '%d/%m') as fecha,ROUND(SUM(totalpagar), 2)as total FROM pago_prestamos WHERE estado_pago = 'PAGADO' GROUP by DAY(fecha_reg) ORDER BY fecha_reg ASC limit 0,10";
		return ejecutarConsulta($sql);
	}

	public function ventasultimos_12meses()
	{
		$sql="SELECT DATE_FORMAT(fecha_reg, '%m/%Y') as fecha_actual, ROUND(SUM(totalpagar), 2) as total FROM pago_prestamos WHERE estado_pago = 'PAGADO' GROUP by MONTH(fecha_reg) ORDER BY fecha_reg ASC limit 0,10";
		return ejecutarConsulta($sql);
	}

	public function listarpagosclientes($id_cliente,$fecha_inicio,$fecha_fin)
	{
		$sql="SELECT * FROM clientes c, pago_prestamos pp, prestamos p, datospersonales d where d.id_datosp = c.id_datosp and c.id_cliente = p.id_cliente and pp.id_prest = p.id_prest
		and pp.fecha_pago>='$fecha_inicio' AND pp.fecha_pago<='$fecha_fin' and c.id_cliente = '$id_cliente'";
		return ejecutarConsulta($sql);		
	}

	public function listarcobrosagentes($id_usuario,$fecha_inicio,$fecha_fin)
	{
		$sql="SELECT * FROM usuarios u, pago_prestamos pp, prestamos p, clientes c, datospersonales d where c.id_datosp = d.id_datosp and pp.id_prest = p.id_prest
		and pp.fecha_pago>='$fecha_inicio' AND pp.fecha_pago<='$fecha_fin' and p.id_usuario = '$id_usuario' and c.id_cliente = p.id_cliente and u.id_usuario = p.id_usuario";
		return ejecutarConsulta($sql);		
	}

	public function listarcobrospendientes($fecha_inicio,$fecha_fin){
        $sql="SELECT * FROM pago_prestamos pp, usuarios u, clientes c, prestamos p, datospersonales d where d.id_datosp = c.id_datosp and p.id_prest = pp.id_prest 
        and c.id_cliente = p.id_cliente and pp.fecha_pago>='$fecha_inicio' AND pp.fecha_pago<='$fecha_fin' and pp.estado_pago = 'Pendiente' and u.id_usuario = p.id_usuario";
        return ejecutarConsulta($sql);
    }

    public function listarcobrosrealizados($fecha_inicio,$fecha_fin){
        $sql="SELECT * FROM pago_prestamos pp, usuarios u, clientes c, prestamos p, datospersonales d where d.id_datosp = c.id_datosp and
		p.id_prest = pp.id_prest and p.id_usuario = u.id_usuario 
        and c.id_cliente = p.id_cliente and pp.fecha_pago>='$fecha_inicio' AND pp.fecha_pago<='$fecha_fin' and pp.estado_pago = 'PAGADO'";
        return ejecutarConsulta($sql);
    }

	public function reportediario(){
		$sql2="SELECT sum(pp.totalpagar) as 'total', d.nombres, d.apellidos from prestamos p, pago_prestamos pp, 
		usuarios u, datospersonales d where p.id_prest = pp.id_prest and
		d.id_datosp = u.id_datosp and p.id_usuario = u.id_usuario and 
		pp.estado_pago = 'PAGADO' and pp.fecha_reg=curdate() GROUP BY u.id_usuario";
		return ejecutarConsulta($sql2);
	}
    
}

?>