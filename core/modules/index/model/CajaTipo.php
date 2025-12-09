<?php
class CajaTipo
{
    public static $tablename = "cajas_tipo";
    public function CajaTipo()
    {
    }
    public static function vercajatipo()
    {
        $sql = "select * from " . self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], new CajaTipo());
    }
    public static function vercaja($id)
    {
        $sql = "SELECT * FROM `tipo_procesadora` WHERE `id_tipo` = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new CajaTipo());
    }
    public static function vercajatipo2()
    {
        $sql = "SELECT * FROM `tipo_procesadora`";
        $query = Executor::doit($sql);
        return Model::many($query[0], new CajaTipo());
    }
    public static function vercajatarjeta()
    {
        $sql = "SELECT * FROM `procesadora`";
        $query = Executor::doit($sql);
        return Model::many($query[0], new CajaTipo());
    }
}
