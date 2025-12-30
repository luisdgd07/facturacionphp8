<?php

// Incluir utilidades de venta
// require_once("./model/VentaUtils.php");

/**
 * Inserta cabecera + detalles de cobro usando AUTO_INCREMENT en una transacción.
 * Devuelve el COBRO_ID generado.
 */
function registrarCobroConDetalles(array $params)
{
    $totalNumber = is_string($params['total']) ? floatval(str_replace(',', '', $params['total'])) : $params['total'];
    try {
        Executor::doit("START TRANSACTION");

        $cab = new CobroCabecera();
        $cab->RECIBO = $params['nrofactura'];
        $cab->configfactura_id = $params['configfactura_id'];
        $cab->CLIENTE_ID = (int) $params['cliente_id'];
        $cab->TOTAL_COBRO = $totalNumber;
        $cab->SUCURSAL_ID = (int) $params['sucursal_id'];
        $cab->FECHA_COBRO = $params['fecha'];
        $cab->MONEDA_ID = (int) $params['moneda_id'];
        $cab->NIVEL1 = isset($params['nivel1']) ? (int) $params['nivel1'] : 1;
        $cab->NIVEL2 = isset($params['nivel2']) ? (int) $params['nivel2'] : 1;
        $cab->COMENTARIO = isset($params['comentario']) ? $params['comentario'] : '';
        $cab->anulado = 0;
        $cab->ventaId = $params['ventaId'];
        $id_cobro = $cab->registro();

        $i = 0;
        if (!empty($params['tablaCobro']) && is_array($params['tablaCobro'])) {
            foreach ($params['tablaCobro'] as $cobroItem) {
                $i++;
                $det = new CobroDetalleData();
                $det->COBRO_ID = $id_cobro;
                $det->NUMERO_FACTURA = $params['nrofactura'];
                $det->CUOTA = $i;
                $det->NUMERO_CREDITO = $params['numero_credito'];
                $det->CLIENTE_ID = (int) $params['cliente_id'];
                $det->IMPORTE_COBRO = is_string($cobroItem['monto2']) ? floatval(str_replace(',', '', $cobroItem['monto2'])) : $cobroItem['monto2'];
                $det->IMPORTE_CREDITO = $totalNumber;
                $det->tipo = 1;
                $det->SUCURSAL_ID = (int) $params['sucursal_id'];
                $det->registro();
            }
        }

        Executor::doit("COMMIT");
        return $id_cobro;
    } catch (Exception $e) {
        Executor::doit("ROLLBACK");
        throw $e;
    }
}

// Verificar si la factura ya existe
$c = VentaData::getNombre($_POST["facturan"], $_POST["sucursal_id"]);

if ($c == null) {
    $remision_id = $_POST["remision_id"];
    $cart = $_POST["cart"];

    if ($remision_id == 0) {
        // Nueva venta (no remisión)
        procesarNuevaVenta($_POST, $cart);
    } else {
        // Venta desde remisión
        procesarVentaRemision($_POST, $cart);
    }
} else {
    Core::alert("NUMERO DE FACTURA EXISTENTE...!");
    Core::redir("index.php?view=vender&id_sucursal=" . $_POST["sucursal_id"]);
}

/**
 * Procesa una nueva venta (sin remisión)
 */
function procesarNuevaVenta($params, $cart)
{
    $tipoproducto = $cart[0]["tipo"];

    if ($tipoproducto == "Servicio") {
        procesarVentaServicio($params, $cart);
    } else {
        procesarVentaProducto($params, $cart);
    }
}

/**
 * Procesa venta de servicios
 */
function procesarVentaServicio($params, $cart)
{
    $sell = new VentaData();
    VentaUtils::configurarVenta($sell, $params);

    $resultado = $sell->venta_producto_cliente1();
    $ventaId = $resultado[1];

    // Procesar operaciones de servicio
    foreach ($cart as $item) {
        $operacion = VentaUtils::crearOperacion($ventaId, $item, $params);
        $operacion->registro_producto1();
    }

    // Actualizar numeración y procesar pago
    finalizarVenta($ventaId, $params);
}

/**
 * Procesa venta de productos
 */
function procesarVentaProducto($params, $cart)
{
    // Verificar stock
    if (!VentaUtils::verificarStock($cart)) {
        echo -1;
        return;
    }

    $sell = new VentaData();
    VentaUtils::configurarVenta($sell, $params);

    $resultado = $sell->venta_producto_cliente1();
    $ventaId = $resultado[1];

    // Procesar productos
    foreach ($cart as $item) {
        $operacion = VentaUtils::crearOperacion($ventaId, $item, $params);
        $operacion->registro_producto1();

        // Actualizar stock
        VentaUtils::actualizarStock($item);

        // Procesar insumos
        VentaUtils::procesarInsumos($ventaId, $item, $params);
    }

    // Actualizar numeración y procesar pago
    finalizarVenta($ventaId, $params);
}

/**
 * Procesa venta desde remisión
 */
function procesarVentaRemision($params, $cart)
{
    $tipoproducto = $cart[0]["tipo"];

    if ($tipoproducto == "Servicio") {
        procesarVentaRemisionServicio($params, $cart);
    } else {
        procesarVentaRemisionProducto($params, $cart);
    }
}

/**
 * Procesa venta de servicios desde remisión
 */
function procesarVentaRemisionServicio($params, $cart)
{
    $sell = new VentaData();
    VentaUtils::configurarVenta($sell, $params);

    $resultado = $sell->venta_producto_cliente3();
    $ventaId = $resultado[1];

    $sell->actualizaremision();

    // Procesar operaciones de servicio
    foreach ($cart as $item) {
        $operacion = VentaUtils::crearOperacion($ventaId, $item, $params);
        $operacion->registro_producto1();
    }

    // Actualizar numeración y procesar pago
    finalizarVenta($ventaId, $params);
}

/**
 * Procesa venta de productos desde remisión
 */
function procesarVentaRemisionProducto($params, $cart)
{
    $sell = new VentaData();
    VentaUtils::configurarVenta($sell, $params);

    $resultado = $sell->venta_producto_cliente3();
    $ventaId = $resultado[1];

    $sell->actualizaremision();

    // Procesar productos
    foreach ($cart as $item) {
        $operacion = VentaUtils::crearOperacion($ventaId, $item, $params);
        $operacion->registro_producto1();
    }

    // Actualizar numeración y procesar pago
    finalizarVenta($ventaId, $params);
}

/**
 * Finaliza la venta (actualiza numeración y procesa pago)
 */
function finalizarVenta($ventaId, $params)
{
    // Actualizar numeración de factura
    VentaUtils::actualizarNumeracionFactura($params);

    // Procesar método de pago
    if ($params["metodopago"] == "Credito") {
        VentaUtils::crearCredito($ventaId, $params);
    } else {
        $paramsCobro = [
            'nrofactura' => $params["facturan"],
            'total' => $params['total'],
            'cliente_id' => $params["cliente_id"],
            'sucursal_id' => $params["sucursal_id"],
            'moneda_id' => $params["idtipomoneda"],
            'fecha' => $params['fecha'],
            'configfactura_id' => $params["configfactura_id"],
            'tablaCobro' => $params['tablaCobro'],
            'numero_credito' => $ventaId,
            'ventaId' => $ventaId,
        ];
        registrarCobroConDetalles($paramsCobro);
    }

    // Responder con el ID de la venta
    header("Content-type:application/json");
    header("HTTP/1.1 200 OK");
    header('Content-Type: text/plain');
    echo json_encode($ventaId);
}
