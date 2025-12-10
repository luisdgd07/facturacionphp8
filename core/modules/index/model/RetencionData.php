<?php
class RetencionData
{
    public static $tablename = "retencion_cabecera";
    public function agregar()
    {
        $sql = "insert into " . self::$tablename . "(`id`, `periodo`, `sucursal_id`, `cliente_id`, `factura`, `importe`, `fecha_auditoria`, `usuario`,`retencion`, `tipo`,`monto_retencion`,`cobro_id`) VALUES " .
            " (NULL, $this->periodo, $this->sucursal, $this->cliente, \"$this->factura\", \"$this->importe\", \"$this->fecha\", \"$this->usuario\", \"$this->retencion\", \"$this->tipo\", \"$this->monto\", \"$this->cobro\");";
        return Executor::doit($sql);
        // return $sql;
    }

    public static function totalretenciones($SUCURSAL_ID)
    {
        $sql = "select RC.*, RD.numero_timbrado, CC.anulado from retencion_cabecera RC INNER JOIN retencion_detalle RD ON RD.usuario = RC.id INNER JOIN cobro_cabecera CC ON CC.COBRO_ID = RC.cobro_id where CC.`sucursal_id` = $SUCURSAL_ID ";
        $query = Executor::doit($sql);
        return Model::many($query[0], "RetencionData");
    }


    public function getRetencion($id)
    {
        $sql = "SELECT * FROM `retencion_cabecera` WHERE id = $id;";
        $query = Executor::doit($sql);
        return Model::one($query[0], "RetencionData");
    }
    public function editar()
    {
        $sql = "UPDATE `retencion_cabecera` SET `retencion` = \"$this->ret\", `fecha` = \"$this->fecha\" WHERE `retencion_cabecera`.`id` = $this->id";
        return Executor::doit($sql);
    }
    public function getCliente()
    {
        return ClienteData::getById($this->cliente_id);
    }
    public static function eliminar($id)
    {
        $sql = "DELETE FROM retencion_cabecera WHERE `id` = $id";
        return Executor::doit($sql);
    }
}
