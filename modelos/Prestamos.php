<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Prestamos
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($id_usuario,$id_cliente,$id_plazo,$monto,$id_garante,$dia_cobro,$dia_limite,$interes_mora)
	{
		$sql="INSERT INTO prestamos (id_usuario,id_cliente,id_plazo,monto,id_garante,dia_cobro,dia_limite,interes_mora,estado_prest)
		VALUES ('$id_usuario','$id_cliente','$id_plazo','$monto','$id_garante','$dia_cobro','$dia_limite','$interes_mora','POR APROBAR')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_prest,$id_usuario,$id_cliente,$id_plazo,$monto,$id_garante,$dia_cobro,$dia_limite,$interes_mora)
	{
		$sql="UPDATE prestamos SET id_usuario='$id_usuario',id_cliente='$id_cliente',id_garante='$id_garante', 
        monto = '$monto',dia_cobro='$dia_cobro',dia_limite='$dia_limite',interes_mora='$interes_mora' WHERE id_prest='$id_prest'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($id_prest)
	{
		$sql="DELETE FROM prestamos where id_prest = '$id_prest'";
		ejecutarConsulta($sql);

        $sql2="DELETE FROM pagos_prestamos where id_prest = '$id_prest'";
        return ejecutarConsulta($sql2);
	}

	//Implementamos un método para activar categorías
	public function aprobar($id_prest)
	{
        $fechaActual = date('Y-m-d');
		$sql="UPDATE prestamos SET estado_prest ='APROBADO', fecha_prest = '$fechaActual' WHERE id_prest='$id_prest'";
		ejecutarConsulta($sql);

        $num_plazo = "SELECT id_plazo FROM prestamos where id_prest = '$id_prest'";
        $id_plazo = ejecutarConsultaID4($num_plazo);

        $num_dia = "SELECT dia_cobro FROM prestamos where id_prest = '$id_prest'";
        $dia_pago = ejecutarConsultaID5($num_dia);

        $num_lim = "SELECT dia_limite FROM prestamos where id_prest = '$id_prest'";
        $dia_limite = ejecutarConsultaID6($num_lim);

        $num = "SELECT count(*) as 'id_pago' FROM pago_prestamos where id_prest = '$id_prest'";
        $num2 = ejecutarConsultaID7($num);

        $anioActual = date('Y');

        $nummes = "SELECT month(pr.fecha_prest) as 'mesactual' FROM prestamos pr where pr.id_prest = '$id_prest' LIMIT 1";
        $mesactual = ejecutarConsultaID8($nummes);

        $montom = "SELECT ROUND(((p.monto * (pl.porc_int/100)+p.monto))/pl.plazo,2) as 'montomensual' from prestamos p, plazos pl where p.id_plazo = pl.id_plazo and p.id_prest = '$id_prest'";
        $montomensual = ejecutarConsultaID9($montom);

        //echo $mesactual;

        if($id_plazo == '1'){
            //12 MESES - PLAZO
                do{
                    $sw=true;
                    for($i=($mesactual+1); $i<=12; $i++){
                        $mespago= $anioActual.'-'.$i.'-'.$dia_pago;
                        $meslim= $anioActual.'-'.$i.'-'.$dia_limite;
                        $sql2="INSERT INTO pago_prestamos (id_prest, monto_mensual, fecha_pago, fecha_limite, mora, totalpagar, estado_pago) VALUES ('$id_prest','$montomensual','$mespago','$meslim','0','$montomensual','Pendiente')";
                        ejecutarConsulta($sql2) or $sw = false;
                    }

                }while($i <= 12 && $aniopago == $anioActual);

            $num3 = "SELECT count(*) as 'id_pago' FROM pago_prestamos where id_prest = '$id_prest' and year(fecha_pago) = '$anioActual'";
            $num4 = ejecutarConsultaID7($num3);

            $num12 = 12;
            $diferencia = $num12 - $num4;

            //echo $diferencia;
            
                 for($j=1; $j<=$diferencia; $j++){
                    $mespago= ($anioActual+1).'-'.$j.'-'.$dia_pago;
                    $meslim= ($anioActual+1).'-'.$j.'-'.$dia_limite;
                    $sql3="INSERT INTO pago_prestamos (id_prest, monto_mensual, fecha_pago, fecha_limite, mora, totalpagar, estado_pago) VALUES ('$id_prest','$montomensual','$mespago','$meslim','0','$montomensual','Pendiente')";
                    ejecutarConsulta($sql3) or $sw = false;
                } 
          return $sw;
        }else if($id_plazo == '2'){
            //24 MESES - PLAZO -------------------------------------------------------------------------------------------------------
            do{
                $sw=true;
                for($i=($mesactual+1); $i<=12; $i++){
                    $mespago= $anioActual.'-'.$i.'-'.$dia_pago;
                    $meslim= $anioActual.'-'.$i.'-'.$dia_limite;
                    $sql2="INSERT INTO pago_prestamos (id_prest, monto_mensual, fecha_pago, fecha_limite, mora, totalpagar, estado_pago) VALUES ('$id_prest','$montomensual','$mespago','$meslim','0','$montomensual','Pendiente')";
                    ejecutarConsulta($sql2) or $sw = false;
                }
            }while($i <= 12 && $aniopago == $anioActual);

            $num3 = "SELECT count(*) as 'id_pago' FROM pago_prestamos where id_prest = '$id_prest' and year(fecha_pago) = '$anioActual'";
            $num4 = ejecutarConsultaID7($num3);

            $num12 = 24;
            $diferencia = $num12 - $num4;

            if($diferencia <= 12){
            for($j=1; $j<=$diferencia; $j++){
                $mespago= ($anioActual+1).'-'.$j.'-'.$dia_pago;
                $meslim= ($anioActual+1).'-'.$j.'-'.$dia_limite;
                $sql3="INSERT INTO pago_prestamos (id_prest, monto_mensual, fecha_pago, fecha_limite, mora, totalpagar, estado_pago) VALUES ('$id_prest','$montomensual','$mespago','$meslim','0','$montomensual','Pendiente')";
                ejecutarConsulta($sql3) or $sw = false;
            } 
            }else if($diferencia > 12){
                for($j=1; $j<=12; $j++){
                    $mespago= ($anioActual+1).'-'.$j.'-'.$dia_pago;
                    $meslim= ($anioActual+1).'-'.$j.'-'.$dia_limite;
                    $sql3="INSERT INTO pago_prestamos (id_prest, monto_mensual, fecha_pago, fecha_limite, mora, totalpagar, estado_pago) VALUES ('$id_prest','$montomensual','$mespago','$meslim','0','$montomensual','Pendiente')";
                    ejecutarConsulta($sql3) or $sw = false;
                } 
            }

            $num5 = "SELECT count(*) as 'id_pago' FROM pago_prestamos where id_prest = '$id_prest' and year(fecha_pago) = '$anioActual' OR year(fecha_pago) = ('$anioActual'+1)";
            $num6 = ejecutarConsultaID7($num5);

            $num12 = 24;
            $diferencia2 = $num12 - $num6;

            for($k=1; $k<=$diferencia2; $k++){
                $mespago= ($anioActual+2).'-'.$k.'-'.$dia_pago;
                $meslim= ($anioActual+2).'-'.$k.'-'.$dia_limite;
                $sql4="INSERT INTO pago_prestamos (id_prest, monto_mensual, fecha_pago, fecha_limite, mora, totalpagar, estado_pago) VALUES ('$id_prest','$montomensual','$mespago','$meslim','0','$montomensual','Pendiente')";
                ejecutarConsulta($sql4) or $sw = false;
            } 
            return $sw;
        }else if($id_plazo == '3'){
            //36 MESES - PLAZO ---------------------------------------------------------------------------------
            do{
                $sw=true;
                for($i=($mesactual+1); $i<=12; $i++){
                    $mespago= $anioActual.'-'.$i.'-'.$dia_pago;
                    $meslim= $anioActual.'-'.$i.'-'.$dia_limite;
                    $sql2="INSERT INTO pago_prestamos (id_prest, monto_mensual, fecha_pago, fecha_limite, mora, totalpagar, estado_pago) VALUES ('$id_prest','$montomensual','$mespago','$meslim','0','$montomensual','Pendiente')";
                    ejecutarConsulta($sql2) or $sw = false;
                }
            }while($i <= 12 && $aniopago == $anioActual);


            for($j=1; $j<=12; $j++){
                $mespago= ($anioActual+1).'-'.$j.'-'.$dia_pago;
                $meslim= ($anioActual+1).'-'.$j.'-'.$dia_limite;
                $sql3="INSERT INTO pago_prestamos (id_prest, monto_mensual, fecha_pago, fecha_limite, mora, totalpagar, estado_pago) VALUES ('$id_prest','$montomensual','$mespago','$meslim','0','$montomensual','Pendiente')";
                ejecutarConsulta($sql3) or $sw = false;
            } 

            $num5 = "SELECT count(*) as 'id_pago' FROM pago_prestamos where id_prest = '$id_prest' and year(fecha_pago) = '$anioActual' OR year(fecha_pago) = ('$anioActual'+1)";
            $num6 = ejecutarConsultaID7($num5);

            $num12 = 36;
            $diferencia2 = $num12 - $num6;

            //echo $diferencia2;

            if($diferencia2 <= 12){
                for($k=1; $k<=$diferencia2; $k++){
                    $mespago= ($anioActual+2).'-'.$k.'-'.$dia_pago;
                    $meslim= ($anioActual+2).'-'.$k.'-'.$dia_limite;
                    $sql3="INSERT INTO pago_prestamos (id_prest, monto_mensual, fecha_pago, fecha_limite, mora, totalpagar, estado_pago) VALUES ('$id_prest','$montomensual','$mespago','$meslim','0','$montomensual','Pendiente')";
                    ejecutarConsulta($sql3) or $sw = false;
                } 
                }else if($diferencia2 > 12){
                    for($k=1; $k<=12; $k++){
                        $mespago= ($anioActual+2).'-'.$k.'-'.$dia_pago;
                        $meslim= ($anioActual+2).'-'.$k.'-'.$dia_limite;
                        $sql3="INSERT INTO pago_prestamos (id_prest, monto_mensual, fecha_pago, fecha_limite, mora, totalpagar, estado_pago) VALUES ('$id_prest','$montomensual','$mespago','$meslim','0','$montomensual','Pendiente')";
                        ejecutarConsulta($sql3) or $sw = false;
                    } 
                }

                $num7 = "SELECT count(*) as 'id_pago' FROM pago_prestamos where id_prest = '$id_prest' and year(fecha_pago) = '$anioActual' OR year(fecha_pago) = ('$anioActual'+1) or year(fecha_pago) = ('$anioActual'+2)";
                $num8 = ejecutarConsultaID7($num7);

                $num12 = 36;
                $diferencia3 = $num12 - $num8;


                for($l=1; $l<=$diferencia3; $l++){
                    $mespago= ($anioActual+3).'-'.$l.'-'.$dia_pago;
                    $meslim= ($anioActual+3).'-'.$l.'-'.$dia_limite;
                    $sql5="INSERT INTO pago_prestamos (id_prest, monto_mensual, fecha_pago, fecha_limite, mora, totalpagar, estado_pago) VALUES ('$id_prest','$montomensual','$mespago','$meslim','0','$montomensual','Pendiente')";
                    ejecutarConsulta($sql5) or $sw = false;
                } 
                return $sw;
        }else if($id_plazo == '4'){
            //48 MESES - PLAZO
            do{
                $sw=true;
                for($i=($mesactual+1); $i<=12; $i++){
                    $mespago= $anioActual.'-'.$i.'-'.$dia_pago;
                    $meslim= $anioActual.'-'.$i.'-'.$dia_limite;
                    $sql2="INSERT INTO pago_prestamos (id_prest, monto_mensual, fecha_pago, fecha_limite, mora, totalpagar, estado_pago) VALUES ('$id_prest','$montomensual','$mespago','$meslim','0','$montomensual','Pendiente')";
                    ejecutarConsulta($sql2) or $sw = false;
                }
            }while($i <= 12 && $aniopago == $anioActual);

            for($j=1; $j<=12; $j++){
                $mespago= ($anioActual+1).'-'.$j.'-'.$dia_pago;
                $meslim= ($anioActual+1).'-'.$j.'-'.$dia_limite;
                $sql3="INSERT INTO pago_prestamos (id_prest, monto_mensual, fecha_pago, fecha_limite, mora, totalpagar, estado_pago) VALUES ('$id_prest','$montomensual','$mespago','$meslim','0','$montomensual','Pendiente')";
                ejecutarConsulta($sql3) or $sw = false;
            } 

            for($k=1; $k<=12; $k++){
                $mespago= ($anioActual+2).'-'.$k.'-'.$dia_pago;
                $meslim= ($anioActual+2).'-'.$k.'-'.$dia_limite;
                $sql3="INSERT INTO pago_prestamos (id_prest, monto_mensual, fecha_pago, fecha_limite, mora, totalpagar, estado_pago) VALUES ('$id_prest','$montomensual','$mespago','$meslim','0','$montomensual','Pendiente')";
                ejecutarConsulta($sql3) or $sw = false;
            } 

            $num7 = "SELECT count(*) as 'id_pago' FROM pago_prestamos where id_prest = '$id_prest' and year(fecha_pago) = '$anioActual' OR year(fecha_pago) = ('$anioActual'+1) or year(fecha_pago) = ('$anioActual'+2)";
            $num8 = ejecutarConsultaID7($num7);

            $num12 = 48;
            $diferencia3 = $num12 - $num8;

            if($diferencia3 <= 12){
                for($l=1; $l<=$diferencia3; $l++){
                    $mespago= ($anioActual+3).'-'.$l.'-'.$dia_pago;
                    $meslim= ($anioActual+3).'-'.$l.'-'.$dia_limite;
                    $sql3="INSERT INTO pago_prestamos (id_prest, monto_mensual, fecha_pago, fecha_limite, mora, totalpagar, estado_pago) VALUES ('$id_prest','$montomensual','$mespago','$meslim','0','$montomensual','Pendiente')";
                    ejecutarConsulta($sql3) or $sw = false;
                } 
                }else if($diferencia3 > 12){
                    for($m=1; $m<=12; $m++){
                        $mespago= ($anioActual+3).'-'.$m.'-'.$dia_pago;
                        $meslim= ($anioActual+3).'-'.$m.'-'.$dia_limite;
                        $sql3="INSERT INTO pago_prestamos (id_prest, monto_mensual, fecha_pago, fecha_limite, mora, totalpagar, estado_pago) VALUES ('$id_prest','$montomensual','$mespago','$meslim','0','$montomensual','Pendiente')";
                        ejecutarConsulta($sql3) or $sw = false;
                    } 
                }

            $num9 = "SELECT count(*) as 'id_pago' FROM pago_prestamos where id_prest = '$id_prest' and year(fecha_pago) = '$anioActual' OR year(fecha_pago) = ('$anioActual'+1) or year(fecha_pago) = ('$anioActual'+2) or year(fecha_pago) = ('$anioActual'+3)";
            $num10 = ejecutarConsultaID7($num9);

            $num12 = 48;
            $diferencia4 = $num12 - $num10;

            for($n=1; $n<=$diferencia4; $n++){
                $mespago= ($anioActual+4).'-'.$n.'-'.$dia_pago;
                $meslim= ($anioActual+4).'-'.$n.'-'.$dia_limite;
                $sql5="INSERT INTO pago_prestamos (id_prest, monto_mensual, fecha_pago, fecha_limite, mora, totalpagar, estado_pago) VALUES ('$id_prest','$montomensual','$mespago','$meslim','0','$montomensual','Pendiente')";
                ejecutarConsulta($sql5) or $sw = false;
            } 
            return $sw;
        }
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_prest)
	{
		$sql="SELECT * FROM prestamos WHERE id_prest='$id_prest'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar($id_prest)
	{

        $sql="SELECT p.*,c.*,pl.*,d.*, u.* from prestamos p, clientes c, usuarios u, plazos pl, datospersonales d
        where p.id_cliente = c.id_cliente and d.id_datosp = c.id_datosp and p.id_usuario = u.id_usuario and p.id_plazo = pl.id_plazo and p.id_prest = '$id_prest'";
        return ejecutarConsulta($sql);
	}

    public function listar2()
	{
        $sql="SELECT p.*,pl.*,d.* , d.nombres as 'nombre_usuario', d.apellidos as 'apellido_usuario' from prestamos p, usuarios u, plazos pl, datospersonales d
        where d.id_datosp = u.id_datosp and p.id_usuario = u.id_usuario and p.id_plazo = pl.id_plazo";
        return ejecutarConsulta($sql);
	}

    public function select(){
		$sql="SELECT * FROM prestamos where estado_prest = '1'";
		return ejecutarConsulta($sql);
    }

    public function selectusuarios(){
        $sql="SELECT * FROM usuarios u, permisos p, usuario_permisos up, datospersonales d
        where u.estado_usuario = '1' and p.id_permiso = '2'  and d.id_datosp = u.id_datosp
        and up.id_usuario = u.id_usuario and up.id_permiso = p.id_permiso";
        return ejecutarConsulta($sql);
    }

    public function selectclientes(){
        $sql="SELECT * FROM clientes c, datospersonales d where d.id_datosp = c.id_datosp and c.estado_cliente = '1'";
        return ejecutarConsulta($sql);
    }

    public function selectgarantes(){
        $sql="SELECT * FROM garantes c, datospersonales d where d.id_datosp = c.id_datosp and c.estado_garante = '1'";
        return ejecutarConsulta($sql);
    }

    public function selectplazos(){
        $sql="SELECT * FROM plazos where estado_plazo = '1'";
        return ejecutarConsulta($sql);
    }
}

?>