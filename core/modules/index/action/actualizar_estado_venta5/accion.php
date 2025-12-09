<?php



$update = VentaData::getById($_GET["id_venta"]);
$update->actualizarestado5();


Core::alert("Registro cancelado para facturacion con éxito");
Core::redir("index.php?view=remision2&id_sucursal=" . $_GET["id_sucursal"]);
