<?php 
  $configfactura = new ConfigFacturaData();
  foreach ($_POST as $k => $v) {
    $configfactura->$k = $v;
    # code...
  }
  $a1=$_POST['numeracion_inicial'];
  $a2=$_POST['numeracion_final'];
  $configfactura->diferencia =$a2-$a1;
  // if(isset($_POST["timbrado"])) { $configfactura->timbrado=1; }else{ $configfactura->timbrado=0; }
  // if(isset($_POST["serie"])) { $configfactura->serie=1; }else{ $configfactura->serie=0; }
  // if(isset($_POST["factura"])) { $configfactura->factura=1; }else{ $configfactura->factura=0; }
  $configfactura->registro1();
  // Core::alert("Registro de manera Éxistosa...!");
  Core::redir("index.php?view=cofigfactura&id_sucursal=".$_POST["id_sucursal"]);
 ?>