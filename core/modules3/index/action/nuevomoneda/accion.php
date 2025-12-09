<?php
  $moneda = new MonedaData();
  foreach ($_POST as $k => $v) {
    $moneda->$k = $v;
    # code...
  }

  $_SESSION["registro"]= 1;
  $moneda->registro();
  // Core::alert("Registro de manera Éxistosa...!");
  Core::redir("index.php?view=moneda&id_sucursal=".$_POST["id_sucursal"]);
  // Core::redir("index.php?view=ajustarstock&id_sucursal=".$_POST["id_sucursal"]);

?>