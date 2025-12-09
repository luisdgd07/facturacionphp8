<?php
$client = MonedaData::VerId($_GET["id_tipomoneda"]);
$client->eliminar();
// Core::alert("Eliminacion con Exito");
Core::redir("index.php?view=moneda&id_sucursal=".$_GET["id_sucursal"]);
?>