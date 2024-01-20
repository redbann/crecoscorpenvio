<?php
if(strlen(session_id()) < 1)
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CRECOSCORP</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="../reportes/logo.jpg">

    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">    
    <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet"/>
    <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="../public/css/f2.css">

    

  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->
        <a href="escritorio.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">CRECOSCORP</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>CRECOSCORP</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- User Account: style can be found in dropdown.less -->
                 <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagen_usuario']; ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo $_SESSION['nombres'] . " " . $_SESSION['apellidos'];; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../files/usuarios/<?php echo $_SESSION['imagen_usuario']; ?>" class="img-circle" alt="User Image">
                    <p>
                    CRECOSCORP
                      <small>Usuario: <?php echo $_SESSION['nombres'] . " " . $_SESSION['apellidos'];; ?></small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    
                    <div class="pull-right">
                      <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Salir</a>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>

        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
       <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">       
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>

            <?php 
            if ($_SESSION['administrador']==1)
            {
              echo '<li id="escritorio">
              <a href="escritorio.php">
                <i class="fa fa-tasks"></i> <span>Escritorio</span>
              </a>
            </li>';
            echo '<li id="empleados1" class="treeview">
            <a href="#">
              <i class="fa fa-laptop"></i>
              <span>Usuarios</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li id="empleados"><a href="usuario.php"><i class="fa fa-circle-o"></i> Registro de usuarios</a></li>
              <li id="permisos2"><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
            </ul>
          </li>';
          echo '<li id="empleados1" class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Clientes</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li id="empleados"><a href="cliente.php"><i class="fa fa-circle-o"></i> Registro de clientes</a></li>
          </ul>
        </li>';
        echo '<li id="empleados1" class="treeview">
        <a href="#">
          <i class="fa fa-laptop"></i>
          <span>Garantes</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li id="empleados"><a href="garantes.php"><i class="fa fa-circle-o"></i> Registro de garantes</a></li>
        </ul>
      </li>';
        echo '<li id="empleados1" class="treeview">
            <a href="#">
              <i class="fa fa-laptop"></i>
              <span>Préstamos</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li id="empleados"><a href="plazos.php"><i class="fa fa-circle-o"></i>Registrar plazos</a></li>
              <li id="empleados"><a href="prestamos.php"><i class="fa fa-circle-o"></i>Registrar préstamos</a></li>
            </ul>
          </li>';

          echo '<li id="empleados1" class="treeview">
            <a href="#">
              <i class="fa fa-laptop"></i>
              <span>Dashboard</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li id="dashboard"><a href="dashboard.php"><i class="fa fa-circle-o"></i>Ver Dashboard</a></li>
            </ul>
          </li>';
            }
            ?>

            <?php 
            if ($_SESSION['agente']==1)
            {
              echo '<li id="escritorio">
              <a href="escritorio.php">
                <i class="fa fa-tasks"></i> <span>Escritorio</span>
              </a>
            </li>';
              echo '<li id="empleados1" class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Préstamos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="empleados"><a href="pagoprestamos.php"><i class="fa fa-circle-o"></i> Cobro de préstamos</a></li>
                <li id="empleados"><a href="pagospendientes.php"><i class="fa fa-circle-o"></i> Pagos pendientes</a></li>
              </ul>
            </li>';

            echo '<li id="empleados1" class="treeview">
            <a href="#">
              <i class="fa fa-laptop"></i>
              <span>Dashboard</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li id="dashboard"><a href="dashboardagente.php"><i class="fa fa-circle-o"></i>Ver Dashboard</a></li>
            </ul>
          </li>';
          
            }
            ?>  
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>