<?php
$delete = MarcaData::getById($_GET["id_marca"]);
$delete->del();
// Core::alert("Eliminacion con Exito");
Core::redir("index.php?view=marca&id_sucursal=".$_GET["id_sucursal"]);
?>