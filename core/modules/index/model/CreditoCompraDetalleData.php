<?php
class CreditoCompraDetalleData
{
    public static function registrar_credito($cuota, $credito_id, $importe_credito, $fecha_detalle, $compra_id, $saldo_credito, $fecha, $sucursal)
    {
        $sql = "";
        try {
            $sql = "insert into credito_compra_detalle ( `cuota`, `credito_id`, `importe_credito`, `fecha_detalle`, `compra_id`, `saldo_credito`, `fecha`, `sucursal_id`) 
            VALUES (\"$cuota\", \"$credito_id\", \"$importe_credito\", \"$fecha_detalle\", \"$compra_id\", \"$saldo_credito\", \"$fecha\" ,\"$sucursal\")";
            return Executor::doit($sql);
        } catch (Exception $e) {
            echo "error";
            echo $sql;
            return false;
            throw $e;
        }
    }
}
