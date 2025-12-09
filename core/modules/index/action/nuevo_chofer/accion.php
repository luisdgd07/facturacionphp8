<?php 
  $insertplaca = new ChoferData();
  foreach ($_POST as $k => $v) {
    $insertplaca->$k = $v;
    # code...
  }

  $insertplaca->registro1();
  // Core::alert("Registro de manera Éxistosa...!");
  Core::redir("index.php?view=choferes&id_sucursal=".$_POST["id_sucursal"]);
 ?>