<?php

$client = ProductoData::getById($_GET["id_producto"]);
$client->eliminar();
Core::alert("Eliminacion con Exito");
Core::redir("index.php?view=producto&id_sucursal=".$_GET["id_sucursal"]);
?>