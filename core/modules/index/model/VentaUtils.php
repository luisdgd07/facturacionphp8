<?php

/**
 * Utilidades para operaciones de venta
 * Contiene funciones comunes para evitar duplicación de código
 */
class VentaUtils
{
    /**
     * Crea una operación de venta estándar
     */
    public static function crearOperacion($ventaId, $item, $params)
    {
        $operacion = new OperationData();
        $operacion->producto_id = $item["id"];
        $operacion->fecha = $params["fecha"];
        $operacion->accion_id = AccionData::getByName("salida")->id_accion;
        $operacion->venta_id = $ventaId;
        $operacion->precio1 = $item["precioc"];
        $operacion->stock_trans = $params["stock_trans"];
        $operacion->motivo = "VENTA " . $ventaId;
        $operacion->sucursal_id = $params["sucursal_id"];
        $operacion->q = $item["cantidad"];
        $operacion->precio = $item["precio"];
        $operacion->is_oficiall = isset($params["is_oficiall"]) ? 1 : 0;
        $operacion->deposito = $item["deposito"];
        $operacion->deposito_nombre = $item["depositotext"];
        
        return $operacion;
    }
    
    /**
     * Actualiza el stock de un producto
     */
    public static function actualizarStock($item)
    {
        $stock = StockData::vercontenidos3($item['id'], $item['deposito']);
        $actualizar = new StockData();
        $actualizar->CANTIDAD_STOCK = $stock->CANTIDAD_STOCK - $item['cantidad'];
        $actualizar->PRODUCTO_ID = $item['id'];
        $actualizar->DEPOSITO_ID = $item['deposito'];
        return $actualizar->actualizar2();
    }
    
    /**
     * Procesa insumos de un producto
     */
    public static function procesarInsumos($ventaId, $item, $params)
    {
        $insumosData = new InsumosData();
        $insumos = $insumosData->find($item['id']);
        
        foreach ($insumos as $insumo) {
            $operacion = new OperationData();
            $operacion->producto_id = $insumo->insumo_id;
            $operacion->fecha = $params["fecha"];
            $operacion->accion_id = AccionData::getByName("salida")->id_accion;
            $operacion->venta_id = $ventaId;
            $operacion->precio1 = 0;
            $operacion->stock_trans = $params["stock_trans"];
            $operacion->motivo = "VENTA " . $ventaId;
            $operacion->sucursal_id = $params["sucursal_id"];
            $operacion->q = $insumo->cantidad * $item['cantidad'];
            $operacion->precio = $insumo->total;
            $operacion->is_oficiall = isset($params["is_oficiall"]) ? 1 : 0;
            $operacion->deposito = $item["deposito"];
            $operacion->deposito_nombre = $item["depositotext"];
            $operacion->registro_producto1();
            
            // Actualizar stock del insumo
            $stockInsumo = StockData::vercontenidos3($insumo->insumo_id, $item['deposito']);
            $actualizarInsumo = new StockData();
            $actualizarInsumo->CANTIDAD_STOCK = $stockInsumo->CANTIDAD_STOCK - ($insumo->cantidad * $item['cantidad']);
            $actualizarInsumo->PRODUCTO_ID = $insumo->insumo_id;
            $actualizarInsumo->DEPOSITO_ID = $item['deposito'];
            $actualizarInsumo->actualizar2();
        }
    }
    
    /**
     * Crea un crédito con sus cuotas
     */
    public static function crearCredito($ventaId, $params)
    {
        $fechaActual = $params['fecha'];
        $vence = date("Y-m-d", strtotime($fechaActual . "+ " . $params['vencimiento'] . " days"));
        
        $credito = new CreditoData();
        $credito->sucursalId = $params["sucursal_id"];
        $credito->monedaId = trim($params["idtipomoneda"]);
        $credito->concepto = $params["concepto"];
        $credito->credito = str_replace(',', '', $params['total']);
        $credito->cuotas = $params['cuotas'];
        $credito->abonado = 0;
        $credito->vencimiento = $vence;
        $credito->fecha = $fechaActual;
        $credito->cliente_id = $params["cliente_id"];
        $credito->ventaId = $ventaId;
        
        $resultadoCredito = $credito->registrar_credito();
        
        // Crear cuotas
        for ($i = 1; $i <= $params['cuotas']; $i++) {
            if ($i > 1) {
                $vence = date("Y-m-d", strtotime($vence . "+ " . $params['vencimiento'] . " days"));
            }
            
            $detalle = new CreditoDetalleData();
            $detalle->fechaDetalle = $vence;
            $detalle->cuota = $i;
            $detalle->creditoId = $resultadoCredito[1];
            $detalle->sucursalId = $params["sucursal_id"];
            $detalle->factura = $params["facturan"];
            $detalle->fecha = $fechaActual;
            $detalle->monedaId = trim($params["idtipomoneda"]);
            $detalle->cliente_id = $params["cliente_id"];
            $detalle->recibido = str_replace(',', '', $params['total']) / $params['cuotas'];
            $detalle->moneda = 0;
            
            $resultadoDetalle = $detalle->registrar_credito_detalle();
            
            $detalleCobro = new CobroDetalleData();
            $detalleCobro->creditoDetalle = $resultadoDetalle[1];
            $detalleCobro->registrar_credito();
        }
        
        return $resultadoCredito[1];
    }
    
    /**
     * Actualiza numeración de factura
     */
    public static function actualizarNumeracionFactura($params)
    {
        if (isset($params["id_configfactura"])) {
            $configuracion = ConfigFacturaData::VerId($params["id_configfactura"]);
            $configuracion->diferencia = $params["diferencia"] - 1;
            $configuracion->actualizardiferencia();
        }
    }
    
    /**
     * Calcula numeración de factura
     */
    public static function calcularNumeracion($params)
    {
        $numeracionFinal = $params['numeracion_final'];
        $diferencia = $params['diferencia'];
        return ($numeracionFinal - $diferencia);
    }
    
    /**
     * Configura una venta estándar
     */
    public static function configurarVenta($venta, $params)
    {
        $venta->usuario_id = $_SESSION["admin_id"];
        $venta->presupuesto = $params["presupuesto"];
        $venta->REMISION_ID = $params["remision_id"];
        $venta->cdc_fact = isset($params["cdc_fact"]) ? $params["cdc_fact"] : '';
        $venta->num_fact = isset($params["num_fact"]) ? $params["num_fact"] : '';
        $venta->factura = $params["facturan"];
        $venta->configfactura_id = $params["configfactura_id"];
        $venta->tipomoneda_id = trim($params["idtipomoneda"]);
        $venta->vendedor = $params["vendedor_id"];
        $venta->cambio = $params["cambio"];
        $venta->cambio2 = $params["cambio2"];
        $venta->simbolo2 = $params["simbolo2"];
        $venta->formapago = $params["formapago"];
        $venta->codigo = $params["codigo"];
        $venta->fechapago = date('Y-m-d', strtotime($params['fecha']));
        $venta->metodopago = $params["metodopago"];
        $venta->total10 = str_replace(',', '', $params["total10"]);
        $venta->iva10 = str_replace(',', '', $params["iva10"]);
        $venta->total5 = str_replace(',', '', $params["total5"]);
        $venta->iva5 = str_replace(',', '', $params["iva5"]);
        $venta->exenta = str_replace(',', '', $params["exenta"]);
        $venta->total = str_replace(',', '', $params["total"]);
        $venta->n = 1;
        $venta->numerocorraltivo = self::calcularNumeracion($params);
        $venta->sucursal_id = $params["sucursal_id"];
        $venta->dncp = $params["dncp"];
        $venta->fecha = $params["fecha"];
        $venta->transaccion = $params["transaccion"];
        $venta->cantidaconfigmasiva = $params["cantidaconfigmasiva"];
        $venta->cliente_id = $params["cliente_id"];
        
        return $venta;
    }
    
    /**
     * Verifica stock disponible
     */
    public static function verificarStock($cart)
    {
        foreach ($cart as $item) {
            $stock = StockData::vercontenidos3($item['id'], $item['deposito']);
            if (!$stock || $stock->CANTIDAD_STOCK < $item['cantidad']) {
                return false;
            }
        }
        return true;
    }
}
