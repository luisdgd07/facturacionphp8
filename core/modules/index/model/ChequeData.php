<?php
class ChequeData
{

    public static function agregar($cheque, $banco, $fecha, $importe, $moneda, $caja)
    {
        $sql = "INSERT INTO `cheques_recibidos` (`nro_cheque`, `id_banco`, `fecha_cheque`, `importe`, `id_cheques`,`moneda_id`,`caja_id`) VALUES (\"$cheque\", \"$banco\", \"$fecha\", \"$importe\", NULL,\"$moneda\", \"$caja\")";
        return Executor::doit($sql);
    }
    public static function getByCajaId($cajaid)
    {
        $sql = "select * from `cheques_recibidos`  WHERE `caja_id` = $cajaid";
        $query = Executor::doit($sql);
        return Model::one($query[0], new ChequeData());
        // return $sql;
    }
}
