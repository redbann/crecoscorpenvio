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
                    <center><h1 class="box-title">CLIENTES </h1></center>
                            <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> 
                            <a href="../reportes/rptclientes.php" target="_blank"><button class="btn btn-info" id="btnreporte"><i class="fa fa-clipboard"></i> Reporte</button></a></h1>
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
                            <th>Cédula</th>
                            <th>Nombre</th>
                            <th>Dirección domiciliaria</th>
                            <th>Teléfono</th>
                            <th>Dirección del trabajo</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Cédula</th>
                            <th>Nombre</th>
                            <th>Dirección domiciliaria</th>
                            <th>Teléfono</th>
                            <th>Dirección del trabajo</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label>Cédula(*):</label> 
                            <input type="hidden" name="id_cliente" id="id_cliente">
                            <input type="number" class="form-control" name="cedula" id="cedula" maxlength="13" placeholder="Cédula" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombres(*):</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombres" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Apellidos(*):</label>
                            <input type="text" class="form-control" name="apellido" id="apellido" maxlength="100" placeholder="Apellidos" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Teléfono(*):</label>
                            <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Teléfono" maxlength="20">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre del cónyuge(*):</label>
                            <input type="text" class="form-control" name="nombre_conyuge" id="nombre_conyuge" placeholder="Nombre del cónyuge" maxlength="200">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cédula del cónyuge(*):</label>
                            <input type="text" class="form-control" name="cedula_conyuge" id="cedula_conyuge" placeholder="Cédula del cónyuge" maxlength="20">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Dirección del trabajo(*):</label>
                            <input type="text" class="form-control" name="direccion_tra" id="direccion_tra" placeholder="Dirección de trabajo" maxlength="200" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Dirección domiciliaria(*):</label>
                            <input type="text" class="form-control" name="direccion_dom" id="direccion_dom" placeholder="Dirección domiciliaria" maxlength="200" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Latitud:</label>
                            <input type="text" class="form-control" name="lat" id="lat" placeholder="Latitud" maxlength="200">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Longitud:</label>
                            <input type="text" class="form-control" name="lng" id="lng" placeholder="Longitud" maxlength="200">
                          </div>
                          <div>
                            <dir id="map-canvas"></dir>
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwyS_si7Zj2XWzOwiEACJtBfTc6KHKuSA"></script>
<script type="text/javascript" src="scripts/cliente.js"></script>
<?php 
}
ob_end_flush();
?>