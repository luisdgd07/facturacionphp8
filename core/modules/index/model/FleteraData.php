<?php
class FleteraData
{
    public static $tablename = "empresa_fletera";
    public ?string $nombre_empresa = "";
    public ?int $id_empresa_flete = 0;
    public ?string $direccion = "";
    public ?string $telefono = "";
    public ?string $ruc = "";
    public ?int $estado = 0;



    public function FleteraData()
    {
    }

    public static function verfletera($id)
    {
        $sql = "SELECT * FROM `empresa_fletera` WHERE `id_sucursal` = $id";
        $query = Executor::doit($sql);
        return Model::many($query[0], "FleteraData");
    }
    public static function ver($id)
    {
        $sql = "SELECT * FROM `empresa_fletera` WHERE `id_empresa_flete` = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], "FleteraData");
    }
    public function crear()
    {
        $sql = "INSERT INTO `empresa_fletera` (`id_empresa_flete`, `nombre_empresa`, `direccion`, `telefono`, `id_sucursal`, `ruc`) VALUES (NULL, \"$this->nombre\", \"$this->direccion\", \"$this->telefono\", \"$this->sucursal\",  \"$this->ruc\")";
        return Executor::doit($sql);
    }


    public static function listar($sucursal)
    {
        $sql = "select * from " . self::$tablename . " where id_sucursal =" . $sucursal;
        $query = Executor::doit($sql);
        return Model::many($query[0], "FleteraData");
    }


    public function actualizar1()
    {
        $sql = "update empresa_fletera set nombre_empresa=\"$this->nombre_empresa\", direccion=\"$this->direccion\",telefono=\"$this->telefono\",ruc=\"$this->ruc\",estado=\"$this->estado\"where id_empresa_flete =$this->id_empresa_flete ";
        return Executor::doit($sql);
    }

    public static function VerId($id_empresa_flete)
    {
        $sql = "select * from empresa_fletera  where id_empresa_flete=$id_empresa_flete";
        $query = Executor::doit($sql);
        return Model::one($query[0], "FleteraData");
    }



}
