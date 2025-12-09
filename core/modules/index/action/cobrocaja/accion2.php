<?php
$pagos = $_POST['pagos'];
$id = CobroCabecera::getultimoCobro();

$idCobro = $id->COBRO_ID + 1;
$caja = new CajaCabecera();
$caja->cobroId = $idCobro;
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
var_dump($_POST['venta']);
foreach ($pagos as $pago) {
    // $pago = json_encode($pago);
    $detalle = new CajaDetalle();
    $detalle->cobroId = $idCobro;
    $detalle->clienteId = $_POST['cliente'];
    $detalle->importe = $pago['monto'];
    $detalle->caja = $pago['tipo_id'];


    $detalle->moneda = $pago['moneda_id'];
    $detalle->cambio = $pago['cambio'];
    $detalle->sucursal = $_POST['sucursal'];
    $detalle->venta = $_POST['venta'];
    $d = $detalle->agregarDetalle();
    if ($pago['tipo_id'] == 4) {
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
        $tarjetad->tipo = $pago['tarjeta'];
        $t2 = $tarjetad->agregarTarjeta();
    } else if ($pago['tipo_id'] == 2) {
        CuentaBancariaData::agregar($pago['recibo'], $pago['moneda_id'], $pago['banco'], $pago['monto2'], $d[1]);
    } else if ($pago['tipo_id'] == 3) {
        ChequeData::agregar($pago['recibo'], $pago['banco'], $_POST['fecha'], $pago['monto2'], $pago['moneda_id'], $d[1]);
    }
}

echo json_encode($cajaCa);
