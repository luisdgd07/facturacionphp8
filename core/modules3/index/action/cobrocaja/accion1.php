<?php
$pagos = $_POST['pagos'];
foreach ($pagos as $pago) {
    // $pago = json_encode($pago);
    // var_dump($pago);
    $detalle = new CajaDetalle();
    $detalle->cobroId = $_POST['cobro'];
    $detalle->clienteId = $_POST['cliente'];
    $detalle->importe = $pago['monto'];
    $detalle->caja = $pago['tipo_id'];

    $detalle->moneda = $pago['moneda_id'];
    $detalle->sucursal = $_POST['sucursal'];
    $detalle->agregarDetalle();
}
$detalle = new CajaDetalle();
$caja = new CajaCabecera();
$caja->cobroId = $_POST['cobro'];
$caja->clienteId = $_POST['cliente'];
$caja->total = $_POST['total'];
$caja->sucursal = $_POST['sucursal'];
$cajaCa = $caja->agregarCaja();
echo json_encode($cajaCa);