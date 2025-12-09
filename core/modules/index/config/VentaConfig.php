<?php

/**
 * Configuración centralizada para operaciones de venta
 */
class VentaConfig
{
    // Tipos de producto
    const TIPO_SERVICIO = "Servicio";
    const TIPO_PRODUCTO = "Producto";
    
    // Métodos de pago
    const METODO_CREDITO = "Credito";
    const METODO_CONTADO = "Contado";
    
    // Estados de venta
    const ESTADO_ACTIVA = 1;
    const ESTADO_ANULADA = 0;
    
    // Configuración de stock
    const STOCK_MINIMO = 0;
    
    // Configuración de crédito
    const CREDITO_DEFAULT_CUOTAS = 1;
    const CREDITO_DEFAULT_ABONADO = 0;
    
    // Headers de respuesta
    const HEADER_JSON = "Content-type:application/json";
    const HEADER_OK = "HTTP/1.1 200 OK";
    const HEADER_TEXT = "Content-Type: text/plain";
    
    /**
     * Obtiene configuración de numeración de factura
     */
    public static function getConfiguracionNumeracion($params)
    {
        return [
            'serie' => $params['serie1'],
            'numeracion_final' => $params['numeracion_final'],
            'diferencia' => $params['diferencia'],
            'numerocorraltivo' => ($params['numeracion_final'] - $params['diferencia'])
        ];
    }
    
    /**
     * Obtiene parámetros de cobro estándar
     */
    public static function getParamsCobro($ventaId, $params)
    {
        return [
            'nrofactura'       => $params["facturan"],
            'total'            => $params['total'],
            'cliente_id'       => $params["cliente_id"],
            'sucursal_id'      => $params["sucursal_id"],
            'moneda_id'        => $params["idtipomoneda"],
            'fecha'            => $params['fecha'],
            'configfactura_id' => $params["configfactura_id"],
            'tablaCobro'       => $params['tablaCobro'],
            'numero_credito'   => $ventaId,
            'ventaId'          => $ventaId,
        ];
    }
    
    /**
     * Valida parámetros requeridos
     */
    public static function validarParametrosRequeridos($params)
    {
        $requeridos = [
            'facturan', 'cliente_id', 'sucursal_id', 'fecha', 
            'total', 'configfactura_id', 'idtipomoneda'
        ];
        
        foreach ($requeridos as $campo) {
            if (!isset($params[$campo]) || empty($params[$campo])) {
                throw new Exception("Campo requerido faltante: {$campo}");
            }
        }
        
        if (!isset($params['cart']) || !is_array($params['cart']) || empty($params['cart'])) {
            throw new Exception("Carrito de compras inválido");
        }
    }
    
    /**
     * Obtiene configuración de venta estándar
     */
    public static function getConfiguracionVenta($params)
    {
        return [
            'usuario_id' => $_SESSION["admin_id"],
            'presupuesto' => $params["presupuesto"],
            'REMISION_ID' => $params["remision_id"],
            'cdc_fact' => isset($params["cdc_fact"]) ? $params["cdc_fact"] : '',
            'num_fact' => isset($params["num_fact"]) ? $params["num_fact"] : '',
            'factura' => $params["facturan"],
            'configfactura_id' => $params["configfactura_id"],
            'tipomoneda_id' => trim($params["idtipomoneda"]),
            'vendedor' => $params["vendedor_id"],
            'cambio' => $params["cambio"],
            'cambio2' => $params["cambio2"],
            'simbolo2' => $params["simbolo2"],
            'formapago' => $params["formapago"],
            'codigo' => $params["codigo"],
            'fechapago' => date('Y-m-d', strtotime($params['fecha'])),
            'metodopago' => $params["metodopago"],
            'total10' => str_replace(',', '', $params["total10"]),
            'iva10' => str_replace(',', '', $params["iva10"]),
            'total5' => str_replace(',', '', $params["total5"]),
            'iva5' => str_replace(',', '', $params["iva5"]),
            'exenta' => str_replace(',', '', $params["exenta"]),
            'total' => str_replace(',', '', $params["total"]),
            'n' => 1,
            'numerocorraltivo' => self::getConfiguracionNumeracion($params)['numerocorraltivo'],
            'sucursal_id' => $params["sucursal_id"],
            'dncp' => $params["dncp"],
            'fecha' => $params["fecha"],
            'transaccion' => $params["transaccion"],
            'cantidaconfigmasiva' => $params["cantidaconfigmasiva"],
            'cliente_id' => $params["cliente_id"],
        ];
    }
}
