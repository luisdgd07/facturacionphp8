<?php

$client = ClienteData::getById($_GET["id_cliente"]);
$client->eliminar();
Core::alert("Cliente eliminado con Exito");
Core::redir("index.php?view=cliente&id_sucursal=".$_GET["id_sucursal"]);
?>