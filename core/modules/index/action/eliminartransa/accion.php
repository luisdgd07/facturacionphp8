<?php
$delete = VentaData::getById($_GET["id_venta"]);
$delete->del();
$delete->del1();
 Core::alert("Registro de transacción eliminado con éxito");
Core::redir("index.php?view=transa&id_sucursal=".$_GET["id_sucursal"]);
?>