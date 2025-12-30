<?php
class UnidadesData
{
    public static $tablename = "unidades";

    public ?string $nombre = "";
    public ?int $id = 0;


    public static function getAll()
    {
        $sql = "SELECT * FROM `unidades`";
        $query = Executor::doit($sql);
        return Model::many($query[0], "UnidadesData");
    }
    public static function getById($id)
    {
        $sql = "SELECT * FROM `unidades` WHERE `id` = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], "UnidadesData");
    }
    public static function getById_($id)
    {
        try {

            $sql = "SELECT * FROM `unidades` WHERE `id` = $id";
            $query = Executor::doit($sql);
            if ($query[0]) {
                return Model::one($query[0], "UnidadesData");
            }
            return false;
        } catch (Exception $e) {
            return false;
            throw $e;
        }
    }
}
