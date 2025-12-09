<?php
$envio = new VentaData();
$id = $_POST['venta'];
$xml = $_POST['xml'] . '';
$estado = $_POST['estado'] . '';
$cdc = $_POST['cdc'] . '';
echo $id;
echo $xml;
echo $estado;
$envio->actualizarFE($id, $estado, $xml, $cdc);
Core::alert("Registro de manera Éxistosa...!");
header('Location: ' . $_SERVER['HTTP_REFERER']);
