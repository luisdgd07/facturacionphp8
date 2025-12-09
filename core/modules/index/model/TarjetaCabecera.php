<?php
class TarjetaCabecera
{
    public static $tablename = "tarjeta_cabecera";

    public function TarjetaCabecera()
    {
        $this->fecha_registro = "NOW()";
    }

    public function agregarTarjeta()
    {
        $sql = "INSERT INTO " . self::$tablename . "(`id_tarjeta`, `tarjeta_id`, `transaccion`, `importetotal`, `fecha`,`moneda_id`) VALUES (NULL, \"$this->tarjeta_id\", \"$this->transaccion\", \"$this->importe\", NOW(),\"$this->moneda\");";
        var_dump($sql);
        return Executor::doit($sql);
    }
    public static function getByCobro($id)
    {
        $sql = "SELECT * FROM `tarjeta_cabecera` WHERE `ID` = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new TarjetaCabecera());
    }

    public static function getByMonedas($moneda1, $moneda2)
    {
        $sql = "SELECT * FROM `tarjeta_cabecera` WHERE `moneda_id` = $moneda1 OR moneda_id = $moneda2";
        $query = Executor::doit($sql);
        return Model::many($query[0], new CuentaBancariaData());
        // return $sql;
    }
    public static function eliminar($id)
    {
        $sql = "DELETE FROM `tarjeta_cabecera` WHERE `id_tarjeta` = $id";
        return Executor::doit($sql);
    }
}
