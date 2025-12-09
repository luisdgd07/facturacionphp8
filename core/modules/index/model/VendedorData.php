<?php
class VendedorData
{
    public static $tablename = "vendedor";



    public static function getAll($sucursal)
    {
        $sql = "select * from " . self::$tablename . " where id_sucursal = " . $sucursal;
        $query = Executor::doit($sql);
        return Model::many($query[0], new VendedorData());
    }
    public static function getById($id)
    {
        $sql = "select * from " . self::$tablename . " where id = " . $id;
        $query = Executor::doit($sql);
        return Model::one($query[0], new VendedorData());
        // return Model::one($query[0], new VendedorData());
    }
}
