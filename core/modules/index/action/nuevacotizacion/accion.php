<?php
  $moneda = new CotizacionData();
  foreach ($_POST as $k => $v) {
    $moneda->$k = $v;
    # code...
  }

  $_SESSION["registro"]= 1;
  $moneda->registro();
   $moneda->actualizar2();
  // Core::alert("Registro de manera Éxistosa...!");
  Core::redir("index.php?view=cotizacion&id_sucursal=".$_POST["id_sucursal"]);
  // Core::redir("index.php?view=ajustarstock&id_sucursal=".$_POST["id_sucursal"]);

?>