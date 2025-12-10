<?php
class CuentaBancariaData
{

    public static function agregar($recibo, $moneda, $banco, $importe, $caja)
    {
        $sql = "INSERT INTO `cuenta_bancaria` (`id_cuenta_bancaria`, `nro_cuenta`, `id_moneda`, `id_banco`, `importe`,`caja_id`) VALUES (NULL, \"$recibo\", \"$moneda\", \"$banco\", \"$importe\", \"$caja\")";
        var_dump($sql);
        return Executor::doit($sql);
    }
    public static function getByCajaId($cajaid)
    {
        $sql = "select * from `cuenta_bancaria`  WHERE `caja_id` = $cajaid";
        $query = Executor::doit($sql);
        return Model::one($query[0], "CuentaBancariaData");
        // return $sql;
    }
    public static function getByMonedas($moneda1, $moneda2)
    {
        $sql = "select * from `cuenta_bancaria`  WHERE id_moneda = $moneda1 OR id_moneda = $moneda2";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CuentaBancariaData");
        // return $sql;
    }
    public static function eliminar($id)
    {
        $sql = "DELETE FROM `cuenta_bancaria` WHERE `id_cuenta_bancaria` = $id";
        return Executor::doit($sql);
    }
}
