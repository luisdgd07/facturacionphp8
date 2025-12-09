<?php


$delete = CotizacionData::getById($_GET["id_cotizacion"]);
$delete->dell();
 Core::alert("Eliminacion con Exito");
Core::redir("index.php?view=cotizacion&id_sucursal=".$_GET["id_sucursal"]);



?>