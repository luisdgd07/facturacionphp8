<?php
class DptData
{
    public static $tablename = "ubigeo_departments";

    public ?string $name = "";
    public ?string $descripcion = "";
    public ?string $codigo = "";

    public static function getAll()
    {
        $sql = "select * from  ubigeo_departments ";
        $query = Executor::doit($sql);
        return Model::many($query[0], "DptData");
    }


    public static function getAll2()
    {
        $sql = "select * from  distritos ";
        $query = Executor::doit($sql);
        return Model::many($query[0], "DptData");
    }
}
