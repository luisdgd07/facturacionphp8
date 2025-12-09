<?php
$ventas = $_POST["data"];
$fecha = $_POST["fecha"];
$i = 0;
foreach ($ventas as $venta) {

    $envio = new VentaData();
    $id = $venta["venta"];
    $xml = $venta["xml"];
    $estado = $venta["estado"];
    $cdc = $venta["cdc"];
    $kude = $venta["kude"];
    $enviado = $envio->actualizarFE_remision($id, $estado, $xml, $cdc, $kude, $fecha);
    $i++;
    var_dump($enviado);
    // echo $enviado;
}
// Core::alert("Registro de manera Éxistosa...!");
// header('Location: ' . $_SERVER['HTTP_REFERER']);
