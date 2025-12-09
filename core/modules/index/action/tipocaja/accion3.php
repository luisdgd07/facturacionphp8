<?php



$pagos = $_POST['pagos'];
$sucursal = $_POST["sucursal"];
$monto = $_POST["total"];
$nrofactura = $_POST['factura'];
// *__VALIDATION_BLOCK__*
// Normalizamos y validamos que los pagos no superen el total y que exista al menos un pago.
if (!isset($pagos) || !is_array($pagos) || count($pagos) === 0) {
    http_response_code(400);
    echo "Error: Debe registrar al menos un método de pago.";
    exit;
}
// Sumar en moneda base (Gs) usando 'monto2' que llega convertido a la moneda de la venta.
$__suma_pagos = 0;
foreach ($pagos as $__p) { $__suma_pagos += floatval($__p['monto2']); }
$__monto_total = floatval($monto);
if ($__suma_pagos - $__monto_total > 0.0001) {
    http_response_code(400);
    echo "Error: El total de pagos ($__suma_pagos) supera el total de la venta ($__monto_total).";
    exit;
}
if ($__suma_pagos < $__monto_total - 0.0001) {
    http_response_code(400);
    echo "Error: El total de pagos ($__suma_pagos) es menor al total a cobrar ($__monto_total).";
    exit;
}



CajaDetalle::eliminarVenta(intval($_POST['venta']));
CobroDetalleData::eliminarVenta($nrofactura);
// *__CLEANUP_EXTENSIONS__*
// Borramos también registros auxiliares (tarjeta, transferencia/cuenta, cheques)
if (class_exists('TarjetaDetalleData') && method_exists('TarjetaDetalleData','eliminarPorFactura')) {
    TarjetaDetalleData::eliminarPorFactura($nrofactura);
}
if (class_exists('CuentaBancariaData') && method_exists('CuentaBancariaData','eliminarPorFactura')) {
    CuentaBancariaData::eliminarPorFactura($nrofactura);
}
if (class_exists('ChequeData') && method_exists('ChequeData','eliminarPorFactura')) {
    ChequeData::eliminarPorFactura($nrofactura);
}

$i = 0;
foreach ($pagos as $pago) {
    $i = $i + 1;
    $registro2 = new CobroDetalleData();
    $registro2->COBRO_ID =  $_POST['cobro'];

    $registro2->NUMERO_FACTURA = $nrofactura;
    $registro2->CUOTA = $i;
    $registro2->NUMERO_CREDITO = intval($_POST['venta']);
    $registro2->CLIENTE_ID = $_POST['cliente'];     // probar id cliente si carga bien
    $registro2->IMPORTE_COBRO = $pago['monto'];
    $registro2->IMPORTE_CREDITO = $monto;
    $registro2->tipo = 1;
    $registro2->SUCURSAL_ID = $sucursal;
    $registro2->registro();


    // $pago = json_encode($pago);
    $detalle = new CajaDetalle();
    $detalle->cobroId = $_POST['cobro'];
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
        $tarjeta->moneda = $pago['moneda_id'];
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
