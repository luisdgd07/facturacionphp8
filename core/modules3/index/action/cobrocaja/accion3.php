<?php
$pagos = $_POST['pagos'];
$caja = new CajaCabecera();
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
$cajaCa = $caja->agregarCaja();
foreach ($pagos as $pago) {
    // $pago = json_encode($pago);
    $detalle = new CajaDetalle();
    $detalle->cobroId = $_POST['cobro'];
    $detalle->clienteId = $_POST['cliente'];
    $detalle->importe = $pago['monto'];
    $detalle->caja = $pago['tipo_id'];


    $detalle->moneda = $pago['moneda_id'];
    $detalle->cambio = $pago['cambio'];
    $detalle->sucursal = $_POST['sucursal'];

    $d = $detalle->agregarDetalle();
    if ($pago['vaucher'] != 0) {
        $tarjeta = new TarjetaCabecera();
        $tarjeta->transaccion = $pago['tipo_tar'];
        $tarjeta->importe = $pago['monto'];
        $tarjeta->tarjeta_id = $cajaCa[1];
        $t = $tarjeta->agregarTarjeta();

        $tarjetad = new TarjetaDetalleData();
        $tarjetad->tarjeta = $t[1];
        $tarjetad->transaccion = $d[1];
        $tarjetad->vaucher = $pago['vaucher'];
        $tarjetad->procesadora = $pago['tipo_tar'];
        $tarjetad->importe = $pago['monto'];
        $t2 = $tarjetad->agregarTarjeta();
    }
}


echo json_encode($cajaCa);
