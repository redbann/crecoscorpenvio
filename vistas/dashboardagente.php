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

if ($_SESSION['agente']==1)
{
  require_once "../modelos/Dashboardagente.php";
  $consulta = new Dashboardagente();
  $rsptac = $consulta->totalclientes();
  $regc=$rsptac->fetch_object();
  $totalc=$regc->total; 

  /* $rsptaa = $consulta->totalprestporaprobar();
  $regca=$rsptaa->fetch_object();
  $totalca=$regca->id_prest;

  $rsptav = $consulta->totalprestaprobados();
  $regv=$rsptav->fetch_object();
  $totalv=$regv->id_prest;  */

  $rsptav2 = $consulta->totalganancias();
  $regv2=$rsptav2->fetch_object();
  $totalv2=$regv2->total_ganancias; 

  $rsptav3 = $consulta->totalgananciashoy();
  $regv3=$rsptav3->fetch_object();
  $totalv3=$regv3->total_saldo; 

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
                              <a href="pagoprestamos.php" class="small-box-footer">Clientes <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                          </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                          <div class="small-box bg-blue-active">
                              <div class="inner">
                                <h4 style="font-size:17px;">
                                  <strong>$<?php echo $totalv2; ?></strong>
                                </h4>
                                <p>Total de cobros realizados</p>
                              </div>
                              <div class="icon">
                                <i class="ion ion-cash"></i>
                              </div>
                              <a href="pagoprestamos.php" class="small-box-footer">Cobros de préstamos<i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                          <div class="small-box bg-blue">
                              <div class="inner">
                                <h4 style="font-size:17px;">
                                  <strong>$<?php echo $totalv3; ?></strong>
                                </h4>
                                <p>Total de cobros realizados (HOY)</p>
                              </div>
                              <div class="icon">
                                <i class="ion ion-cash"></i>
                              </div>
                              <a href="pagoprestamos.php" class="small-box-footer">Cobros de préstamos<i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        </div>

                     
                    
                    <div class="panel-body">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <div class="box box-primary">
                              <div class="box-header with-border">
                                Cobros de préstamos de los últimos 12 meses
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

var ctx = document.getElementById("ventas12").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'line',
    fontcolor: "red",
    data: {
        labels: [<?php echo $fechasv?>],
        datasets: [{
            label: 'Cobros de préstamos en $ de los últimos 12 Meses',
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


<?php 
}
ob_end_flush();
?>


