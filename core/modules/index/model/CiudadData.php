<?php
class CiudadData
{
    public static $tablename = "ciudades";


    public ?string $descripcion = "";
    public ?string $codigo = "";
    public ?string $id_ciudad = "";
    public ?string $id_distrito = "";

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

        // $sql = "SELECT * FROM `distritos` WHERE `id_departamento` = $id GROUP BY descripcion";
        $sql = "SELECT * FROM `distritos` WHERE `id_departamento` = $id  GROUP BY codigo";

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


    public static function getDistritos($id)
    {
        // SELECT * FROM `distritos` WHERE `codigo` LIKE '145' $sql = "select ciudades.id_ciudad, ciudades.descripcion from " . self::$tablename . " INNER JOIN distritos ON distritos.id_distrito = ciudades.id_distrito WHERE `id_departamento` = 19";
        $sql = "SELECT MIN(id_distrito) as id_distrito, descripcion, MIN(codigo) as codigo, MIN(id_departamento) as id_departamento FROM `distritos` WHERE `id_departamento` = $id GROUP BY descripcion";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CiudadData");
    }


    public static function getCiudades($id)
    {
        $sql = "SELECT MIN(id_ciudad) as id_ciudad, descripcion, MIN(codigo) as codigo, MIN(id_distrito) as id_distrito FROM `ciudades` WHERE `id_distrito` = $id GROUP BY descripcion";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CiudadData");
    }
}
