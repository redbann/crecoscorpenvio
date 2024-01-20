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
                    <center><h1 class="box-title">PRÉSTAMOS </h1></center>
                            <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> 
                            <a href="../reportes/rptprestamos.php" target="_blank"><button class="btn btn-info" id="btnreporte"><i class="fa fa-clipboard"></i> Reporte</button></a></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <link rel="stylesheet" type="text/css" href="../public/css/estilomapa.css">
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Agente</th>
                            <th>Cliente</th>
                            <th>Plazo</th>
                            <th>Monto</th>
                            <th>Día de cobro</th>
                            <th>Día límite</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Agente</th>
                            <th>Cliente</th>
                            <th>Plazo</th>
                            <th>Monto</th>
                            <th>Día de cobro</th>
                            <th>Día límite</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label>Agente crediticio(*):</label> 
                            <input type="hidden" name="id_prest" id="id_prest">
                            <select id="id_usuario" name="id_usuario" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cliente(*):</label>
                            <select id="id_cliente" name="id_cliente" class="form-control selectpicker" data-live-search="true" required></select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" id="plazodiv">
                            <label>Plazo de pago(*):</label>
                            <select id="id_plazo" name="id_plazo" class="form-control selectpicker" data-live-search="true" required></select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Monto(*):</label>
                            <input type="number" step = ".01" class="form-control" name="monto" id="monto" placeholder="Monto" required>
                          </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Garante(*):</label>
                            <select id="id_garante" name="id_garante" class="form-control selectpicker" data-live-search="true" required></select>
                            </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Día de cobro(*):</label>
                            <input type="number" class="form-control" name="dia_cobro" id="dia_cobro" placeholder="Día de cobro" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Día límite(*):</label>
                            <input type="number" class="form-control" name="dia_limite" id="dia_limite" placeholder="Día límite" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Interés de mora(*):</label>
                            <input type="number" step = ".01" class="form-control" name="interes_mora" id="interes_mora" placeholder="Interés de mora" required>
                          </div>
                            <br>
                         <center>
                         <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

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

<script type="text/javascript" src="scripts/prestamos.js"></script>
<?php 
}
ob_end_flush();
?>