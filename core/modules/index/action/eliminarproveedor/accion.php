<?php

$client = ProveedorData::getById($_GET["id_cliente"]);
$client->eliminar();
Core::alert("Eliminacion con Exito");
Core::redir("index.php?view=proveedor");
?>