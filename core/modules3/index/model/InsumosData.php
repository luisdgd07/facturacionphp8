<?php
class InsumosData
{
    public static $tablename = "insumos";

    public function registrarnuevo()
    {
        $sql = "INSERT INTO `insumos` (`id`, `producto_id`, `nombre`, `cantidad`, `id_sucursal`, `insumo_id`,`precio`,`total`) VALUES (NULL, \"$this->producto_id\", \"$this->nombre\", \"$this->cantidad\", \"$this->id_sucursal\", \"$this->insumo_id\", \"$this->precio\",\"$this->total\")";
        Executor::doit($sql);
    }
    public function find($id)
    {
        $sql = "SELECT * FROM `insumos` WHERE `producto_id` = $id";
        $query = Executor::doit($sql);
        return Model::many($query[0], new InsumosData());
    }
    public function delete()
    {
        $sql = "DELETE FROM `insumos` WHERE `producto_id` = $this->id";
        $query = Executor::doit($sql);
    }
}
