<?php
$pagos = $_POST['pagos'];
$caja = new RetencionData();
$caja->cobroId = $_POST['cobro'];
$caja->clienteId = $_POST['cliente'];
$caja->total = $_POST['total'];
$caja->sucursal = $_POST['sucursal'];
if (isset($_POST['concepto'])) {
    $caja->concepto = $_POST['concepto'];
    $caja->fecha = $_POST['fecha'];
} else {
    $caja->concepto = '';
    $caja->fecha = date('d/m/y');
}
$cajaCa = $caja->agregar();
foreach ($pagos as $pago) {
    // $pago = json_encode($pago);
    $detalle = new RetencionDetalleData();
    $detalle->cobroId = $_POST['cobro'];
    $detalle->clienteId = $_POST['cliente'];
    $detalle->importe = $pago['monto'];
    $detalle->caja = $pago['tipo_id'];


    $detalle->moneda = $pago['moneda_id'];
    $detalle->cambio = $pago['cambio'];
    $detalle->sucursal = $_POST['sucursal'];

    $d = $detalle->agregar();
}


echo json_encode($cajaCa);
