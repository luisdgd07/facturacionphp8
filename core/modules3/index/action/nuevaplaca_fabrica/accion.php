<?php 
  $insertplaca = new PlacaData();
  foreach ($_POST as $k => $v) {
    $insertplaca->$k = $v;
    # code...
  }

  $insertplaca->registro1();
  // Core::alert("Registro de manera Éxistosa...!");
  Core::redir("index.php?view=placa_fabrica&id_sucursal=".$_POST["id_sucursal"]);
 ?>