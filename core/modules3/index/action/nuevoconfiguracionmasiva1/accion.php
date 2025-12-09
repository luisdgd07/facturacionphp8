<?php
$registro = new ConfiguracionMasivaData();
foreach ($_POST as $k => $v) {
  $registro->$k = $v;
  # code...
}
$registro->registro1();
Core::redir("index.php?view=configmasiva&id_sucursal=".$_POST["id_sucursal"]);
?>