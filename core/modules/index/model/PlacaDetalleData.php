<?php
class PlacaDetalleData
{
    public static $tablename = "detalle_placa";
    public function registro_placa()
    {

        $sql = "insert into " . self::$tablename . "  (`id_detalle`, `id_venta`, `id_producto`, `cantidad`, `id_sucursal`, `numero_placa_ini`, `numero_placa_fin`, `registro_serie`,`id_de_placa`)
         VALUES (NULL, \"$this->venta\", \"$this->producto\", \"$this->cantidad\", \"$this->sucursal\", \"$this->numero_placa_ini\",\"$this->numero_placa_fin\",\"$this->registro_serie\",\"$this->id_placa\")";
        return Executor::doit($sql);
    }
    public function eliminar($id)
    {
        $sql = "DELETE FROM `placas` WHERE `id_venta` = $id";
        return Executor::doit($sql);
    }
    public static function eliminar2($id)
    {
        $sql = "DELETE FROM `placas` WHERE `id_venta` = $id";
        return Executor::doit($sql);
    }
    public function resta()
    {
        $sql = "UPDATE `placas_fabrica` SET `diferencia` = \"$this->total\",`placa_inicio` = \"$this->inicio\" WHERE `id_placa` = \"$this->id\"";
        return Executor::doit($sql);
        // return $sql;
    }
    public function obtener($id)
    {
        $sql = "select * FROM `detalle_placa` WHERE `id_venta` = $id";
        $query = Executor::doit($sql);
        return Model::many($query[0], "PlacaDetalleData");
    }
    public static function obtenerPlaca($id)
    {
        $sql = "SELECT * FROM `placas_fabrica` WHERE `id_placa` = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], "PlacaDetalleData");
    }
}
