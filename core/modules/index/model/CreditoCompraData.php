<?php
class CreditoCompraData
{
    public static function registrar_credito($compra_id, $fecha, $sucursal_id, $moneda_id, $concepto, $credito, $abonado, $vencimiento, $cuotas, $proveedor_id)
    {
        $sql = "";
        try {
            $sql = "insert into credito_compra ( `compra_id`, `fecha`, `sucursal_id`, `moneda_id`, `concepto`, `credito`, `abonado`, `vencimiento`, `cuotas`, `proveedor_id`) 
            VALUES (\"$compra_id\", \"$fecha\", \"$sucursal_id\", \"$moneda_id\", \"$concepto\", \"$credito\", \"$abonado\", \"$vencimiento\",\"$cuotas\", \"$proveedor_id\")";
            $result = Executor::doit($sql);
            return $result[1];
        } catch (Exception $e) {
            echo "error";
            echo $sql;
            return false;
            throw $e;
        }
    }
}
