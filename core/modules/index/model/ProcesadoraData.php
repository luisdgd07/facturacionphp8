<?php
class ProcesadoraData
{
    public static $tablename = "procesadora";

    public function ProcesadoraData()
    {
    }

    public static function getAll()
    {
        $sql = "select * from " . self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], "ProcesadoraData");
    }
}
