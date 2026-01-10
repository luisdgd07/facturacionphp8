<?php
class InsumosData
{
    public ?int $producto_id = null;
    public ?int $nombre = null;
    public ?int $cantidad = null;
    public ?int $id_sucursal = null;
    public ?int $insumo_id = null;
    public ?int $precio = null;
    public ?int $total = null;
    public static $tablename = "insumos";

    public function registrarnuevo()
    {
        $sql = "INSERT INTO `insumos` (`id`, `producto_id`, `nombre`, `cantidad`, `id_sucursal`, `insumo_id`,`precio`,`total`) VALUES (NULL, \"$this->producto_id\", \"$this->nombre\", \"$this->cantidad\", \"$this->id_sucursal\", \"$this->insumo_id\", \"$this->precio\",\"$this->total\")";
        return Executor::doit($sql);
        // return $sql;
    }
    public function find($id)
    {
        $sql = "SELECT * FROM `insumos` WHERE `producto_id` = $id";
        $query = Executor::doit($sql);
        return Model::many($query[0], "InsumosData");
    }
    public static function find2($id)
    {
        $sql = "SELECT * FROM `insumos` WHERE `producto_id` = $id";
        $query = Executor::doit($sql);
        return Model::many($query[0], "InsumosData");
    }
    public function delete()
    {
        $sql = "DELETE FROM `insumos` WHERE `producto_id` = $this->id";
        $query = Executor::doit($sql);
    }
}
