<?php
class TarjetaDetalleData
{
    public static $tablename = "tarjeta_detalle";

    public function TarjetaDetalleData()
    {
        $this->fecha_registro = "NOW()";
    }

    public function agregarTarjeta()
    {
        // $sql = "INSERT INTO " . self::$tablename . "(`id_detalletarjeta`, `tarjeta_id`, `transaccion`, `numero_vaucher`, `procesadora_id`, `importe`) VALUES (NULL, \"$this->tarjeta\", \"$this->transaccion\", '\"$this->vaucher\"', \"$this->procesadora\", \"$this->importe\"";
        $sql = "INSERT INTO `tarjeta_detalle` (`id_detalletarjeta`, `tarjeta_id`, `transaccion`, `numero_vaucher`, `procesadora_id`, `importe`,`tipo`) VALUES (NULL, \"$this->tarjeta\", \"$this->transaccion\", \"$this->vaucher\", \"$this->procesadora\", \"$this->importe\", \"$this->tipo\");";
        return Executor::doit($sql);
    }
    public static function getByCobro($id)
    {
        $sql = "SELECT * FROM `tarjeta_detalle` WHERE `transaccion` = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new TarjetaDetalleData());
    }
    public static function eliminar($id)
    {
        $sql = "DELETE FROM `tarjeta_detalle` WHERE `tarjeta_id` = $id";
        return Executor::doit($sql);
    }
}
