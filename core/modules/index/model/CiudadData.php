<?php
class CiudadData
{
    public static $tablename = "ciudades";

    public function CiudadData()
    {
    }

    public static function getByDpt($id)
    {
        // SELECT * FROM `distritos` WHERE `codigo` LIKE '145' $sql = "select ciudades.id_ciudad, ciudades.descripcion from " . self::$tablename . " INNER JOIN distritos ON distritos.id_distrito = ciudades.id_distrito WHERE `id_departamento` = 19";
        $sql = "SELECT * FROM `distritos` WHERE `codigo` =  $id";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CiudadData");
    }
    public static function getDpt($id)
    {
        // // SELECT * FROM `distritos` WHERE `codigo` LIKE '145' $sql = "select ciudades.id_ciudad, ciudades.descripcion from " . self::$tablename . " INNER JOIN distritos ON distritos.id_distrito = ciudades.id_distrito WHERE `id_departamento` = 19";

        $sql = "SELECT * FROM `distritos` WHERE `id_departamento` = $id GROUP BY descripcion";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CiudadData");
    }
    public static function getciudad($id)
    {
        // SELECT * FROM `distritos` WHERE `codigo` LIKE '145' $sql = "select ciudades.id_ciudad, ciudades.descripcion from " . self::$tablename . " INNER JOIN distritos ON distritos.id_distrito = ciudades.id_distrito WHERE `id_departamento` = 19";
        $sql = "SELECT * FROM `ciudades` WHERE `id_distrito` = $id";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CiudadData");
    }
}
