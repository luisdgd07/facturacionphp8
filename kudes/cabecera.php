<?php
if (isset($_GET['venta'])) {
    $venta = VentaData::getByIdInTable($_GET['venta'], "venta");
} else if (isset($_GET['remision'])) {
    $venta = VentaData::getByIdInTable($_GET['remision'], "remision");
} else if (isset($_GET['notacredito'])) {
    $venta = VentaData::getByIdInTable($_GET['notacredito'], "nota_credito_venta");
} else {
    die("No se encontro la venta");
}
$sucursal = SuccursalData::VerId($venta->sucursal_id);
if (isset($_GET['remision'])) {
    $tipo = "Remisión";
} else if (isset($_GET['notacredito'])) {
    $tipo = "Nota de Crédito";
} else {
    $tipo = "Factura";
}

if ($sucursal->is_envia_factura == 1) {
    $tipo .= " Electrónica";
}
ob_start();
if ($sucursal->id_sucursal == 17) {
    include 'cabeceras/strada.php';
} else {
    include 'cabeceras/defecto.php';
}
$html = $html . ob_get_clean();