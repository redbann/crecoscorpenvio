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

if ($_SESSION['administrador']==1 || $_SESSION['agente']==1)
{
  

?>

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      

    <!--  <div class="content-wrapper">
      <section class="content-section" id="portfolio">
            <div class="container px-4 px-lg-5">
              <br><br>-->

              <div class="content-wrapper fpi">
     
            <div >
              <!-- BEGINS: AUTO-GENERATED MUSES RADIO PLAYER CODE -->
<!-- ENDS: AUTO-GENERATED MUSES RADIO PLAYER CODE -->
</div>
               



<?php
  
}else{
  require 'noacceso.php';
}

require 'footer2.php';
?>

<script type="text/javascript" src="scripts/escritorio.js"></script>


<?php 
}
ob_end_flush();
?>


