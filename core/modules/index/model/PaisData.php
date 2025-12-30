<?php
class PaisData
{
    public static $tablename = "paises";
    public ?string $name = "";
    public ?int $id = 0;
    public ?string $descripcion = "";
    public ?string $codigo = "";


    public static function getAll()
    {
        $sql = "select * from  paises ";
        $query = Executor::doit($sql);
        return Model::many($query[0], "PaisData");
    }


    public static function get($id)
    {
        $sql = "SELECT * FROM `paises` WHERE `id` = $id ";
        $query = Executor::doit($sql);
        return Model::one($query[0], "PaisData");
    }
}
