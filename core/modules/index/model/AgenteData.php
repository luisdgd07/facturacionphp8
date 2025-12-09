<?php
class AgenteData
{
    public static $tablename = "agente_transporte ";
    public function AgenteData()
    {
    }

    public static function veragentes($id)
    {
        $sql = "SELECT * FROM `agente_transporte` WHERE `id_sucursal` = $id";
        $query = Executor::doit($sql);
        return Model::many($query[0], new AgenteData());
    }
    public static function veragente($id)
    {
        $sql = "SELECT * FROM `agente_transporte` WHERE `id_agente` = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new AgenteData());
    }
    public function crear()
    {
        $sql = "INSERT INTO `agente_transporte` (`id_agente`, `nombre_agente`, `telefono`, `direccion`, `id_sucursal`, `ruc` ) VALUES (NULL,  \"$this->nombre_agente\", \"$this->telefono\", \"$this->direccion\", \"$this->id_sucursal\",  \"$this->ruc\")";
        return Executor::doit($sql);
    }




    public static function listar($sucursal)
    {
        $sql = "select * from " . self::$tablename . " where id_sucursal =" . $sucursal;
        $query = Executor::doit($sql);
        return Model::many($query[0], new AgenteData());
    }

    public function actualizar1()
    {
        $sql = "update  agente_transporte set nombre_agente=\"$this->nombre_agente\", direccion=\"$this->direccion\",telefono=\"$this->telefono\",ruc=\"$this->ruc\",estado=\"$this->estado\"where id_agente =$this->id_agente ";
        return Executor::doit($sql);
    }

    public static function VerId($id_agente)
    {
        $sql = "select * from agente_transporte   where id_agente =$id_agente ";
        $query = Executor::doit($sql);
        return Model::one($query[0], new AgenteData());
    }
}
