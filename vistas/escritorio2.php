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

if ($_SESSION['clientes']==1)
{
  

?>

    
<?php
  

?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
      <section class="content-section" id="portfolio">
            <div class="container px-4 px-lg-5">
               
  

<?php
   ?>








<?php
}else
{
  require 'noacceso.php';
}

require 'footer.php';
?>



<?php 
}
ob_end_flush();
?>


