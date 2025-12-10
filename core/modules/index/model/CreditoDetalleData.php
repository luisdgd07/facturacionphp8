<?php
class CreditoDetalleData
{
    public static $tablename = "credito_detalle";

    public function CreditoDetalleData()
    {
        // $this->cuota = "";
        // $this->creditoId = "";
        // $this->recibido = "";
        // $this->fechaDetalle = "NOW()";
    }
    public function getCliente($id)
    {
        return ClienteData::getById($id);
    }
    public function cliente()
    {
        return ClienteData::getById($this->cliente_id);
    }
    public function credito()
    {
        return CreditoData::getById($this->credito_id);
    }
    public function getCredito($id)
    {
        return CreditoData::getById($id);
    }
    public function registrar_credito_detalle()
    {
        // $sql = "insert into " . self::$tablename . "(`id`, `cuota`, `credito_id`, `importe_credito`, `fecha_detalle`, `moneda_id`)";
        // $sql .= "value (\"$this->cuota\",\"$this->creditoId\",\"$this->recibido\",\"$this->fechaDetalle\",\"$this->moneda\")";
        $sql = "INSERT INTO " . self::$tablename . " (`id`, `cuota`, `credito_id`, `importe_credito`, `saldo_credito`, `fecha_detalle`, `moneda_id`, `cliente_id`,`sucursal_id`, `nrofactura`,`fecha`) VALUES (NULL,\"$this->cuota\", \"$this->creditoId\", \"$this->recibido\", \"$this->recibido\", \"$this->fechaDetalle\",\"$this->monedaId\",\"$this->cliente_id\",\"$this->sucursalId\",\"$this->factura\",\"$this->fecha\");";
        return Executor::doit($sql);
    }
    public function pagos()
    {
        $sql = "update " . self::$tablename . " set saldo_credito=\"$this->saldo_credito\" where id=$this->id";
        return Executor::doit($sql);
    }
    public static function getById($id)
    {
        $sql = "select * from " . self::$tablename . " where credito_id=$id";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CreditoDetalleData");
    }
    public static function getByCuota($id, $cuota)
    {
        $sql = "select * from " . self::$tablename . " where credito_id=$id and cuota = $cuota";
        $query = Executor::doit($sql);
        return Model::one($query[0], "CreditoDetalleData");
    }
    public static function agregar_abono($monto, $id)
    {
        $sql = "UPDATE " . self::$tablename . " SET `saldo_credito` = " . $monto . " WHERE `credito_detalle`.`id` =" . $id . ";";
        Executor::doit($sql);
    }
    public static function anular($id, $saldo, $cuota)
    {
        $sql = "UPDATE `credito_detalle` SET `saldo_credito` = $saldo WHERE `credito_detalle`.`credito_id` = $id and cuota = $cuota; ";
        Executor::doit($sql);
        // return $sql;
    }
    public static function buscar($start, $end)
    {
        $sql = "select * from " . self::$tablename . " where date(fecha) >= \"$start\" and date(fecha) <= \"$end\"";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CreditoDetalleData");
    }
    public static function getAllByDateOp($start, $end, $sucursal)
    {
        $sql = "select * from " . self::$tablename . " where date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and sucursal_id = \"$sucursal\" and importe_credito != 0  order by fecha asc";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CreditoDetalleData");
    }
    public static function getAllByDateOp2($start, $end, $sucursal)
    {
        $sql = "select * from " . self::$tablename . " where date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and sucursal_id = \"$sucursal\" order by fecha asc";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CreditoDetalleData");
    }
    public static function getAllByDateBCOp($cliente_id, $start, $end, $sucursal)
    {
        $sql = "select * from " . self::$tablename . " where date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and cliente_id=$cliente_id and sucursal_id = \"$sucursal\" and importe_credito != 0   order by fecha asc";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CreditoDetalleData");
    }


    // public static function busq_estado($cobro, $cliente_id, $start, $end, $sucursal)
    // {
    //     $sql = "select * from cajas_cabecera where date(FECHA) >= \"$start\" and date(FECHA) <= \"$end\" and ID_CLIENTE=$cliente_id and SUCURSAL_ID = \"$sucursal\"  and COBRO_ID  = \"$cobro\"   order by FECHA asc";
    //     $query = Executor::doit($sql);
    //     return Model::many($query[0], "CreditoDetalleData");
    // }
    public static function busq_estadog($cobro, $cliente_id, $start, $end, $sucursal)
    {
        $sql = "select * from cobro_cabecera where CLIENTE_ID=$cliente_id and SUCURSAL_ID = \"$sucursal\"  and COBRO_ID  = \"$cobro\"   order by FECHA_COBRO asc";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CreditoDetalleData");
    }
    public static function busq_estado($cobro, $cliente_id, $start, $end, $sucursal)
    {
        $sql = "select * from cobro_cabecera where CLIENTE_ID=$cliente_id and SUCURSAL_ID = \"$sucursal\"  and COBRO_ID  = \"$cobro\"   order by FECHA_COBRO asc";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CreditoDetalleData");
    }
    public static function getAllByDateBCOp2($cliente_id, $start, $end, $sucursal)
    {
        $sql = "select * from " . self::$tablename . " where date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and cliente_id=$cliente_id and sucursal_id = \"$sucursal\"  order by fecha asc";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CreditoDetalleData");
    }
    public static function getAllpendiente($cliente_id, $sucursal)
    {
        $sql = "select * from " . self::$tablename . " where  sucursal_id = \"$sucursal\" and saldo_credito != 0 and cliente_id=$cliente_id order by fecha asc";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CreditoDetalleData");
    }

    public static function eliminarCredito($id)
    {
        $sql = "DELETE FROM " . self::$tablename . " WHERE `credito_id` = $id";

        return Executor::doit($sql);
    }

    public static function getBySucursal($id)
    {
        $sql = "select * from " . self::$tablename . " where sucursal_id=$id";
        $query = Executor::doit($sql);

        return Model::many($query[0], "CreditoDetalleData");
    }
}
