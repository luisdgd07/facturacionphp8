<?php



$pagos = $_POST['pagos'];
$sucursal = $_POST["sucursal"];
$monto = $_POST["total"];
$nrofactura = $_POST['factura'];

$detalleAnterior = CajaDetalle::obtenerVenta($_POST['venta']);
CajaDetalle::eliminarVenta(intval($_POST['venta']));
CobroDetalleData::eliminarVenta($nrofactura);
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
    $detalle->idCajaCabecera = $detalleAnterior[0]->id_caja_cabecera;


    $detalle->moneda = $pago['moneda_id'];
    $detalle->cambio = $pago['cambio'];
    $detalle->sucursal = $_POST['sucursal'];
    $detalle->venta = $_POST['venta'];
    $d = $detalle->agregarDetalle();
    if ($pago['tipo_id'] == 4) {
        $tarjeta = new TarjetaCabecera();
        $tarjeta->transaccion =  $d[1];
        $tarjeta->importe = $pago['monto'];
        $tarjeta->tarjeta_id =  $detalleAnterior[0]->id_caja_cabecera;
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
