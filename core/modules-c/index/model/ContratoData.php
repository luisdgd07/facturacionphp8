<?php
class ContratoData
{

    public function ContratoData()
    {
    }

    public  function crear()
    {
        $sql = "INSERT INTO `contratos` (`id`, `cuota`, `monto`, `total`, `entrega`, `id_cliente`, `fecha`, `inicial`, `zona`, `datos`, `descripcion`,`id_sucursal`) VALUES (NULL, \"$this->cuota\", \"$this->monto\", \"$this->total\", \"$this->entrega\", \"$this->cliente\", \"$this->fecha\", \"$this->inicial\", \"$this->zona\", \"$this->datos\", \"$this->descripcion\", \"$this->sucursal\")";
        return Executor::doit($sql);
        // return $sql;
    }
    public static function buscar($id)
    {
        $sql = "SELECT * FROM `contratos` WHERE `id_cliente` = $id";
        $query = Executor::doit($sql);
        // return $sql;
        return Model::many($query[0], new ContratoData());
    }
    public static function buscarId($id)
    {
        $sql = "SELECT * FROM `contratos` WHERE `id` = $id";
        $query = Executor::doit($sql);
        // return $sql;
        return Model::one($query[0], new ContratoData());
    }
    public static function buscarSucursal($id)
    {
        $sql = "SELECT * FROM `contratos` WHERE `id_sucursal` = $id";
        $query = Executor::doit($sql);
        // return $sql;
        return Model::many($query[0], new ContratoData());
    }
    public function actualizar()
    {
        $sql = "UPDATE contratos SET 
        cuota = \"$this->cuota\",
        monto = \"$this->monto\",
        total = \"$this->total\",
        entrega = \"$this->entrega\",
        id_cliente = \"$this->cliente\",
        fecha = \"$this->fecha\",
        inicial = \"$this->inicial\",
        zona = \"$this->zona\",
        datos = \"$this->datos\",
        descripcion = \"$this->descripcion\",
        id_sucursal = \"$this->sucursal\"
        WHERE id = \"$this->id\"";
        Executor::doit($sql);
    }
}
