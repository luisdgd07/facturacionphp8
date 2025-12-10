<?php
class ChoferData
{
    public static $tablename = "choferes";


    public static function getAll()
    {
        $sql = "select * from " . self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], "ChoferData");
    }
    public static function getId($id)
    {
        $sql = "select * from " . self::$tablename . "  WHERE `id_chofer` = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], "ChoferData");
        // return $sql;
    }



    public function registro1()
    {
        $sql = "insert into choferes (id_sucursal,nombre,direccion,telefono,cedula,estado,fecha) ";
        $sql .= "value ($this->sucursal_id,\"$this->nombre\",\"$this->direccion\",\"$this->telefono\",\"$this->cedula\",\"$this->estado\",NOW())";
        return Executor::doit($sql);
    }




    public function actualizar1()
    {
        $sql = "update choferes set nombre=\"$this->nombre\", direccion=\"$this->direccion\",telefono=\"$this->telefono\",cedula=\"$this->cedula\",estado=\"$this->estado\"where id_chofer=$this->id_chofer";
        return Executor::doit($sql);
    }



    public static function VerId($id_chofer)
    {
        $sql = "select * from choferes where id_chofer=$id_chofer";
        $query = Executor::doit($sql);
        return Model::one($query[0], "ChoferData");
    }





    public static function listar($sucursal)
    {
        $sql = "select * from " . self::$tablename . " where id_sucursal =" . $sucursal;
        $query = Executor::doit($sql);
        return Model::many($query[0], "ChoferData");
    }


}
