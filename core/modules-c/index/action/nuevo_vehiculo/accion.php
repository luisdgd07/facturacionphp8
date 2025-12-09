<?php 
  $insertvehiculo = new VehiculoData();
  foreach ($_POST as $k => $v) {
    $insertvehiculo->$k = $v;
    # code...
  }

  $insertvehiculo->registro1();
 // Core::alert("Registro de vehiculo Éxistosa...!");
  Core::redir("index.php?view=vehiculos&id_sucursal=".$_POST["id_sucursal"]);
 ?>