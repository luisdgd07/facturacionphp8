<?php
class BancoData
{

    public static function getBancos()
    {
        try {
            $sql = "SELECT * FROM `banco`";
            $query = Executor::doit($sql);
            return Model::many($query[0], "BancoData");
        } catch (Exception $e) {
            return [];
        }
    }
    public static function getBanco($id)
    {
        try {
            $sql = "SELECT * FROM `banco` WHERE `id_banco` = $id";
            $query = Executor::doit($sql);
            return Model::one($query[0], "BancoData");
        } catch (Exception $e) {
            return [];
        }
    }
}
