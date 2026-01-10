<?php
class VehiculoData
{
    public static $tablename = "vehiculos";

    public ?string $nombre_empresa = "";
    public ?string $chapa_nro = "";
    public ?string $rua_nro = "";
    public ?string $marca = "";
    public ?string $modelo = "";
    public ?string $anio = "";
    public ?string $color = "";
    public ?string $tipo = "";
    public ?string $estado = "";
    public ?int $id_vehiculo = 0;

    public function ClienteData()
    {
    }

    public static function getAll()
    {
        $sql = "select * from " . self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], "VehiculoData");
    }
    public static function getId($id)
    {
        $sql = "select * from " . self::$tablename . "  WHERE `id_vehiculo` = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], "VehiculoData");
        // return $sql;
    }


    public static function listar($sucursal)
    {
        $sql = "select * from vehiculos where id_sucursal =" . $sucursal;
        $query = Executor::doit($sql);
        return Model::many($query[0], "VehiculoData");
    }






    public function actualizar1()
    {
        $sql = "update vehiculos set marca=\"$this->marca\", chapa_nro=\"$this->chapa_nro\",rua_nro=\"$this->rua_nro\",estado=\"$this->estado\"where id_vehiculo =$this->id_vehiculo ";
        return Executor::doit($sql);
    }



    public static function VerId($id_vehiculo)
    {
        $sql = "select * from vehiculos where id_vehiculo=$id_vehiculo";
        $query = Executor::doit($sql);
        return Model::one($query[0], "VehiculoData");
    }


    public function registro1()
    {
        $sql = "insert into vehiculos (id_sucursal,marca,chapa_nro,rua_nro,estado,fecha) ";
        $sql .= "value ($this->sucursal_id,\"$this->marca\",\"$this->chapa_nro\",\"$this->rua_nro\",\"$this->estado\",NOW())";
        return Executor::doit($sql);
    }




}
