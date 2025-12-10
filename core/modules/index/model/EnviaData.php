<?php
class EnviaData
{
    public static $tablename = "envio";
    public function CompraData()
    {
        $this->factura = "";
        $this->estado = "";
    }
    public function registrarnuevo()
    {
        $sql = "insert into " . self::$tablename . " ( factura, estado)";
        $sql .= "value (\"$this->factura\",\"$this->estado\")";
        Executor::doit($sql);
    }
    public static function getAll()
    {
        $sql = "select * from " . self::$tablename . " ";
        $query = Executor::doit($sql);
        return Model::many($query[0], "EnviaData");
    }
}
