<?php
class RetencionDetalleData
{
    public static $tablename = "retencion_detalle";
    public function agregar()
    {
        $sql = "insert into " . self::$tablename . "(`id`, `periodo`, `sucursal`, `cliente_id`, `factura`, `importe`, `fecha_auditoria`, `usuario`, `numero_timbrado`) VALUES " .
            "(NULL, '\"$this->periodo\"', \"$this->sucursal\",  \"$this->cliente\", \"$this->factura\",  \"$this->importe\", \"$this->fechaauditoria\",\"$this->usuarion\", \"$this->num\")";
        return Executor::doit($sql);
        // return $sql;
    }
    public static function retencion($id)
    {
        $sql = "select * from " . self::$tablename . " where usuario=$id order by id desc";
        $query = Executor::doit($sql);
        return Model::many($query[0], new RetencionDetalleData());
    }


    public function getCliente()
    {
        return ClienteData::getById($this->cliente_id);
    }
    public static function retencionfactura($id)
    {
        $sql = "select * from " . self::$tablename . " where factura like '$id' order by id desc";
        $query = Executor::doit($sql);
        return Model::many($query[0], new RetencionDetalleData());
    }
    public function editar()
    {
        $sql = "UPDATE `retencion_detalle` SET `fecha_auditoria` = \"$this->fecha\", `numero_timbrado` = \"$this->timbrado\" WHERE `retencion_detalle`.`usuario` =$this->id";
        return Executor::doit($sql);
    }
}
