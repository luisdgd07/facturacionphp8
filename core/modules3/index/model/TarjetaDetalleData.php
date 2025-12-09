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
        $sql = "INSERT INTO `tarjeta_detalle` (`id_detalletarjeta`, `tarjeta_id`, `transaccion`, `numero_vaucher`, `procesadora_id`, `importe`) VALUES (NULL, \"$this->tarjeta\", \"$this->transaccion\", \"$this->vaucher\", \"$this->procesadora\", \"$this->importe\");";
        return Executor::doit($sql);
    }
}
