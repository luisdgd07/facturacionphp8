<?php
class TarjetaData
{
    public static $tablename = "tarjeta";

    public function TarjetaData()
    {
    }

    public static function agregarVenta()
    {
        $sql = "INSERT INTO " . self::$tablename . " (`tarjeta_id`, `transaccion_id`, `procesadora_id`) VALUES (NULL, \"$this->transaccion\", \"$this->proc\");";
        $query = Executor::doit($sql);
        return Model::many($query[0], "TarjetaData");
    }
}
