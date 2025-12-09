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
        $sql = "INSERT INTO " . self::$tablename . "(`id_tarjeta`, `tarjeta_id`, `transaccion`, `importetotal`, `fecha`) VALUES (NULL, \"$this->tarjeta_id\", \"$this->transaccion\", \"$this->importe\", NOW());";
        return Executor::doit($sql);
    }
}
