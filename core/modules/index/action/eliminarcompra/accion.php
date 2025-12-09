<?php
$delete = VentaData::getById($_GET["id_venta"]);
$delete->del();
$delete->del1();
 Core::alert("Registro eliminado  con éxito");
Core::redir("index.php?view=ventas&id_sucursal=".$_GET["id_sucursal"]);
?>