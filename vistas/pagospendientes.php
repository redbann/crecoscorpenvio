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
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
        <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                    <center><h1 class="box-title">PAGOS PENDIENTES (CON INTERÉS POR MORA)</h1></center>
                            
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <link rel="stylesheet" type="text/css" href="../public/css/estilomapa.css">
                    <div class="panel-body table-responsive" id="listadoregistros">
                    <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                          <label>Fecha Inicio</label>
                          <input onchange='listar()' type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                          <label>Fecha Fin</label>
                          <input type="date" onchange='listar()' class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d"); ?>">
                        </div> 
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Monto</th>
                            <th>Cliente</th>
                            <th>Fecha de pago</th>
                            <th>Fecha límite</th>
                            <th>Fecha registrada</th>
                            <th>Monto mensual</th>
                            <th>Interés de mora</th>
                            <th>Total a pagar</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Monto</th>
                            <th>Cliente</th>
                            <th>Fecha de pago</th>
                            <th>Fecha límite</th>
                            <th>Fecha registrada</th>
                            <th>Monto mensual</th>
                            <th>Interés de mora</th>
                            <th>Total a pagar</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label>Préstamo(*):</label> 
                            <input type="hidden" name="id_pago" id="id_pago">
                            <select id="id_prest" name="id_prest" class="form-control selectpicker" data-live-search="true" disabled></select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Monto mensual(*):</label>
                            <input type="number" step = ".01" class="form-control" name="monto_mensual" id="monto_mensual" placeholder="Monto mensual" disabled>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha de pago(*):</label>
                            <input type="date" class="form-control" name="fecha_pago" id="fecha_pago"  placeholder="Fecha de pago" disabled>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha límite(*):</label>
                            <input type="date" class="form-control" name="fecha_limite" id="fecha_limite" placeholder="Fecha límite" disabled>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Interés de mora(*):</label>
                            <input type="number" step=".01" class="form-control" name="mora" id="mora" placeholder="Interés de mora" disabled>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Total a pagar(*):</label>
                            <input type="number" step=".01" class="form-control" name="totalpagar" id="totalpagar" placeholder="Total a pagar" disabled>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha registrada(*):</label>
                            <input type="date" class="form-control" name="fecha_reg" id="fecha_reg" placeholder="Fecha registrada" disabled>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Latitud:</label>
                            <input type="text" class="form-control" name="lat" id="lat" placeholder="Latitud" maxlength="200" disabled>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Longitud:</label>
                            <input type="text" class="form-control" name="lng" id="lng" placeholder="Longitud" maxlength="200" disabled>
                          </div>
                          <div id="floating-panel">
      <b>Mode of Travel: </b>
      <select id="mode">
        <option value="DRIVING">Manejando</option>
        <option value="WALKING">Caminando</option>
      </select>
    </div>
    <div>
                            <dir id="map-canvas"></dir>
                          </div>
                         <center>
                         <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                           <!--  <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Pagar</button> -->

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                         </center>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}
else
{
require 'noacceso.php';
} 
require 'footer.php';
?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwyS_si7Zj2XWzOwiEACJtBfTc6KHKuSA"></script>
<script type="text/javascript" src="scripts/pagospendientes.js"></script>
<?php 
}
ob_end_flush();
?>