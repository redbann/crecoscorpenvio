<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombres"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';

if ($_SESSION['administrador']==1)
{
  require_once "../modelos/Dashboard.php";
  $consulta = new Dashboard();
  $rsptac = $consulta->totalclientes();
  $regc=$rsptac->fetch_object();
  $totalc=$regc->total; 

  $rsptap = $consulta->totalagentes();
  $regcp=$rsptap->fetch_object();
  $totalcp=$regcp->total2;
  
  $rsptaa = $consulta->totalprestporaprobar();
  $regca=$rsptaa->fetch_object();
  $totalca=$regca->id_prest;

  $rsptav = $consulta->totalprestaprobados();
  $regv=$rsptav->fetch_object();
  $totalv=$regv->id_prest; 

  $rsptav2 = $consulta->totalganancias();
  $regv2=$rsptav2->fetch_object();
  $totalv2=$regv2->total_ganancias; 

  $rsptav3 = $consulta->totalgananciashoy();
  $regv3=$rsptav3->fetch_object();
  $totalv3=$regv3->total_saldo; 

  $ventas1a = $consulta->reportediario();
  $fechasc2='';
  $totalesc2='';
  while ($regfechac2= $ventas1a->fetch_object()) {
    $fechasc2=$fechasc2.'"'.$regfechac2->nombres ." ".$regfechac2->apellidos .'",';
    $totalesc2=$totalesc2.$regfechac2->total .','; 
  }

  //Datos para mostrar el gráfico de barras de las compras
  $ventas10 = $consulta->ventassultimos_10dias();
  $fechasc='';
  $totalesc='';
  while ($regfechac= $ventas10->fetch_object()) {
    $fechasc=$fechasc.'"'.$regfechac->fecha .'",';
    $totalesc=$totalesc.$regfechac->total .','; 
  }

  //Quitamos la última coma
  $fechasc=substr($fechasc, 0, -1);
  $totalesc=substr($totalesc, 0, -1); 

   //Datos para mostrar el gráfico de barras de las ventas
  $ventas12 = $consulta->ventasultimos_12meses();
  $fechasv='';
  $fechasv2='';
  $totalesv='';
  while ($regfechav= $ventas12->fetch_object()) {
    $fechasv=$fechasv.'"'.$regfechav->fecha_actual .'",';
    $totalesv=$totalesv.$regfechav->total .','; 
  }

  //Quitamos la última coma
  $fechasv=substr($fechasv, 0, -1);
  $totalesv=substr($totalesv, 0, -1);

?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                    <center><h1 class="box-title">DASHBOARD </h1></center>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->

                    <div class="panel-body">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                              <div class="small-box bg-light-blue-active">
                              <div class="inner">
                                <h4 style="font-size:17px;">
                                  <strong><?php echo $totalc; ?></strong>
                                </h4>
                                <p>Total de clientes</p>
                              </div>
                              <div class="icon">
                                <i class="ion-person"></i>
                              </div>
                              <a href="cliente.php" class="small-box-footer">Clientes <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                          </div>

                          <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                          <div class="small-box bg-teal">
                              <div class="inner">
                                <h4 style="font-size:17px;">
                                  <strong><?php echo $totalcp; ?></strong>
                                </h4>
                                <p>Total de agentes crediticios</p>
                              </div>
                              <div class="icon">
                                <i class="ion-person"></i>
                              </div>
                              <a href="usuario.php" class="small-box-footer">Agentes crediticios <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                          <div class="small-box bg-aqua">
                              <div class="inner">
                                <h4 style="font-size:17px;">
                                  <strong><?php echo $totalca; ?></strong>
                                </h4>
                                <p>Total de préstamos por aprobar</p>
                              </div>
                              <div class="icon">
                                <i class="ion-load-a"></i>
                              </div>
                              <a href="prestamos.php" class="small-box-footer">Préstamos <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                          <div class="small-box bg-olive-active">
                              <div class="inner">
                                <h4 style="font-size:17px;">
                                  <strong><?php echo $totalv; ?></strong>
                                </h4>
                                <p>Total de préstamos aprobados</p>
                              </div>
                              <div class="icon">
                                <i class="ion ion-load-b"></i>
                              </div>
                              <a href="prestamos.php" class="small-box-footer">Préstamos<i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                          <div class="small-box bg-blue-active">
                              <div class="inner">
                                <h4 style="font-size:17px;">
                                  <strong>$<?php echo $totalv2; ?></strong>
                                </h4>
                                <p>Total de ganancias</p>
                              </div>
                              <div class="icon">
                                <i class="ion ion-cash"></i>
                              </div>
                              <a href="prestamos.php" class="small-box-footer">Préstamos<i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                          <div class="small-box bg-blue">
                              <div class="inner">
                                <h4 style="font-size:17px;">
                                  <strong>$<?php echo $totalv3; ?></strong>
                                </h4>
                                <p>Total de ganancias (HOY)</p>
                              </div>
                              <div class="icon">
                                <i class="ion ion-cash"></i>
                              </div>
                              <a href="prestamos.php" class="small-box-footer">Préstamos<i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                          <label>Fecha Inicio</label>
                          <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                          <label>Fecha Fin</label>
                          <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Cliente(*):</label>
                            <select id="id_cliente" name="id_cliente" class="form-control selectpicker" data-live-search="true" required></select>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Agente crediticio(*):</label> 
                            <select id="id_usuario" name="id_usuario" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <a target="_blank"><button onclick="cobrospendientes()" class="btn btn-info" id="btnreporte2" ><i class="fa fa-clipboard"></i> Reporte (Cobros pendientes)</button></a>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <a target="_blank"><button onclick="cobrosrealizados()" class="btn btn-info" id="btnreporte2" ><i class="fa fa-clipboard"></i> Reporte (Cobros realizados)</button></a>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <a target="_blank"><button onclick="pagosclientes()" class="btn btn-info" id="btnreporte2" ><i class="fa fa-clipboard"></i> Reporte (Pagos de clientes)</button></a>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <a target="_blank"><button onclick="cobrosagentes()" class="btn btn-info" id="btnreporte2" ><i class="fa fa-clipboard"></i> Reporte (Cobros de agentes)</button></a>
                        </div>
                    </div>
                    
                    <div class="panel-body">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <div class="box box-primary">
                              <div class="box-header with-border">
                                Ganancias en el día por agente crediticio
                              </div>
                              <div class="box-body">
                                <canvas id="ventas1a" width="400" height="300"></canvas>
                              </div>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <div class="box box-primary">
                              <div class="box-header with-border">
                                Ganancias de los últimos 12 meses
                              </div>
                              <div class="box-body">
                                <canvas id="ventas12" width="400" height="300"></canvas>
                              </div>
                          </div>
                        </div>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

  <script src="../public/js/chart.min.js"></script>
<script src="../public/js/Chart.bundle.min.js"></script> 
<script type="text/javascript">

var ctx = document.getElementById("ventas1a").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [<?php echo $fechasc2; ?>],
        datasets: [{
            label: 'Ganancias en el día por agente crediticio',
            data: [<?php echo $totalesc2; ?>],
            fill: false,
            backgroundColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderColor: [
                'rgba(51, 198, 255, 0.5)',
                'rgba(23, 124, 228, 0.5)',
                'rgba(23, 43, 228, 0.5)',
                'rgba(101, 23, 228, 0.5)',
                'rgba(151, 23, 228, 0.5)',
                'rgba(198, 23, 228, 0.5)',
                'rgba(23, 171, 228, 0.5)',
                'rgba(23, 228, 217, 0.5)',
                'rgba(23, 228, 164, 0.5)',
                'rgba(23, 228, 109, 0.5)'
            ],
            borderWidth: 2
        }]
    },
 
});

var ctx = document.getElementById("ventas12").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'line',
    fontcolor: "red",
    data: {
        labels: [<?php echo $fechasv?>],
        datasets: [{
            label: 'Ganancias en $ de los últimos 12 Meses',
            data: [<?php echo  $totalesv; ?>],
            fill: false,
            backgroundColor: [
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)'
            ],
            borderColor: [
              'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)',
                'rgba(255, 99, 71, 0.5)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                    steps: 10,
                    stepValue: 6,
                    max: 5000 //max value for the chart is 60
                }
            }],
        }
    }
});
</script>


</script>

<?php


}
else{
  if ($_SESSION['asistente']==1)
{
  

  

?>
     <?php
}else
{
  require 'noacceso.php';
}
}



require 'footer.php';
?>


<script type="text/javascript" src="scripts/dashboard.js"></script>
<?php 
}
ob_end_flush();
?>


