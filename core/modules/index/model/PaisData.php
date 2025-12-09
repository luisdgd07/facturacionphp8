<?php
class PaisData
{
    public static $tablename = "paises";

    public function PaisData()
    {
    }

    public static function getAll()
    {
        $sql = "select * from  paises ";
        $query = Executor::doit($sql);
        return Model::many($query[0], new PaisData());
    }


    public static function get($id)
    {
        $sql = "SELECT * FROM `paises` WHERE `id` = $id ";
        $query = Executor::doit($sql);
        return Model::one($query[0], new PaisData());
    }
}
