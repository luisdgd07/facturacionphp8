<?php
class DNCPData
{
    public static $tablename = "dncp";
    public function DNCPData() {}

    public static function ver($id)
    {
        $sql = "SELECT * FROM `dncp` WHERE `id_sucursal` = $id";
        $query = Executor::doit($sql);
        return Model::many($query[0], new DNCPData());
    }


    public static function verId($id)
    {
        $sql = "SELECT * FROM `dncp` WHERE `id` = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new DNCPData());
    }
    public function crear()
    {
        $sql = "INSERT INTO `dncp` (`id`, `modalidad`, `entidad`, `agno`, `secuencia`, `fecha`, `id_sucursal`, `cliente_id`) VALUES (NULL, \"$this->modalidad\", \"$this->entidad\", \"$this->agno\", \"$this->secuencia\", \"$this->fecha\", \"$this->id_sucursal\", \"$this->cliente_id\")";
        return Executor::doit($sql);
    }

    public static function eliminar($id)
    {
        $sql = "DELETE FROM `dncp` WHERE `dncp`.`id` = $id";
        return Executor::doit($sql);
    }



    public static function listar($sucursal)
    {
        $sql = "select * from " . self::$tablename . " where id_sucursal =" . $sucursal;
        $query = Executor::doit($sql);
        return Model::many($query[0], new DNCPData());
    }

    public function actualizar1()
    {
        $sql = "UPDATE " . self::$tablename . " SET modalidad = \"$this->modalidad\", entidad = \"$this->entidad\", agno = \"$this->agno\", secuencia = \"$this->secuencia\", fecha = \"$this->fecha\", cliente_id = \"$this->cliente_id\" WHERE id = $this->id";
        return Executor::doit($sql);
    }

    public static function listarCliente($cliente)
    {
        $sql = "select * from " . self::$tablename . " where cliente_id =" . $cliente;
        $query = Executor::doit($sql);
        return Model::many($query[0], new DNCPData());
    }
}
