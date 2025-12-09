<?php



$update = VentaData::getById($_GET["id_venta"]);
$update->actualizarestado();


Core::alert("Registro anulado con éxito");
Core::redir("index.php?view=remision2&id_sucursal=" . $_GET["id_sucursal"]);
