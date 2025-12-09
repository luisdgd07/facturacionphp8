<?php
class UnidadesData
{
    public static $tablename = "unidades";

    public function UnidadesData()
    {
    }

    public static function getAll()
    {
        // SELECT * FROM `distritos` WHERE `codigo` LIKE '145' $sql = "select ciudades.id_ciudad, ciudades.descripcion from " . self::$tablename . " INNER JOIN distritos ON distritos.id_distrito = ciudades.id_distrito WHERE `id_departamento` = 19";
        $sql = "SELECT * FROM `unidades`";
        $query = Executor::doit($sql);
        return Model::many($query[0], new UnidadesData());
    }
    // SELECT * FROM `unidades` WHERE `id` = 2
    public static function getById($id)
    {
        $sql = "SELECT * FROM `unidades` WHERE `codigo` = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new UnidadesData());
    }
    public static function getById_($id)
    {
        $sql = "SELECT * FROM `unidades` WHERE `id` = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new UnidadesData());
    }
}
