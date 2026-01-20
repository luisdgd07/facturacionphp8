<?php
class CreditoData
{
    public static $tablename = "creditos";


    public ?int $id = null;
    public ?int $venta_id = null;
    public ?string $fecha = null;
    public ?int $sucursal_id = null;
    public ?int $moneda_id = null;
    public ?string $concepto = null;
    public ?int $credito = null;
    public ?int $abonado = null;
    public ?int $sucursalId = null;
    public ?int $monedaId = null;
    public ?int $ventaId = null;


    public ?string $vencimiento = null;
    public ?int $cuotas = null;
    public ?int $cliente_id = null;
    public function venta()
    {
        return VentaData::getById($this->venta_id);
    }
    public function getVenta($id)
    {
        return VentaData::getById($id);
    }
    public static function anular($id)
    {
        $sql = "UPDATE " . self::$tablename . " SET `credito` = 0 WHERE `credito_detalle`.`id` =" . $id . ";";
        Executor::doit($sql);
    }

    public function registrar_credito()
    {
        $sql = "insert into " . self::$tablename . " (`id`, `venta_id`, `fecha`,
         `sucursal_id`, `moneda_id`, `concepto`, `credito`, `abonado`, `vencimiento`,`cuotas`,`cliente_id`)  ";
        $sql .= "value (NULL,\"$this->ventaId\",\"$this->fecha\",\"$this->sucursalId\",\"$this->monedaId\",\"$this->concepto\",
        \"$this->credito\",\"$this->abonado\",\"$this->vencimiento\",\"$this->cuotas\",\"$this->cliente_id\")";
        return Executor::doit($sql);
    }
    public static function cobranza($id_sucursal)
    {

        $sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal order by fecha desc";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CreditoData");
    }
    public static function agregar_abono($monto, $id)
    {
        $sql = "update " . self::$tablename . " set abonado=abonado+" . $monto . " where venta_id=" . $id . "; ";
        Executor::doit($sql);
    }
    public static function getById($id)
    {
        $sql = "select * from " . self::$tablename . " where id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], "CreditoData");
    }
    public static function getByVentaId($id)
    {
        $sql = "select * from " . self::$tablename . " where venta_id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], "CreditoData");
    }
    public static function getAllByDateOp($start, $end, $sucursal)
    {
        $sql = "select * from " . self::$tablename . " where date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and sucursal_id = \"$sucursal\" and credito != 0  order by fecha asc";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CreditoDetalleData");
    }
    public static function getAllByDateBCOp($cliente_id, $start, $end, $sucursal)
    {
        $sql = "select * from " . self::$tablename . " where date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and cliente_id=$cliente_id and sucursal_id = \"$sucursal\" and credito != 0   order by fecha asc";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CreditoDetalleData");
    }
    public static function busq_estado($cobro, $cliente_id, $start, $end, $sucursal)
    {
        $sql = "select * from cobro_cabecera where date(FECHA_COBRO) >= \"$start\" and date(FECHA_COBRO) <= \"$end\" and CLIENTE_ID=$cliente_id and SUCURSAL_ID = \"$sucursal\"  and COBRO_ID  = \"$cobro\"   order by FECHA_COBRO asc";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CreditoDetalleData");
    }

    public static function getBySucursal($id)
    {
        $sql = "select * from " . self::$tablename . " where sucursal_id=$id";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CreditoData");
    }
    public static function eliminarCredito($id)
    {
        $sql = "DELETE FROM " . self::$tablename . " WHERE `id` = $id";

        return Executor::doit($sql);
    }
}
