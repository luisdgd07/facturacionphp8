<?php
$ventas = $_POST["data"];
$fecha = $_POST["fecha"];
var_dump($ventas);
$i = 0;
foreach ($ventas as $venta) {

    $envio = new VentaData();
    $id = $venta["venta"];
    $xml = $venta["xml"];
    $estado = $venta["estado"];
    $cdc = $venta["cdc"];
    $kude = $venta["kude"];
    echo $venta["xml"];
    $enviado = $envio->actualizarFE($id, $estado, $xml, $cdc, $kude, $fecha);
    $i++;
    echo $enviado;
}
// Core::alert("Registro de manera Éxistosa...!");
// header('Location: ' . $_SERVER['HTTP_REFERER']);
