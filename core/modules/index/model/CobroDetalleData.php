<?php
class CobroDetalleData
{
    public static $tablename = "cobro_detalle";

    public function CobroDetalleData()
    {
        // $this->ventaId = "";
        // $this->sucursalId = "";
        // $this->monedaId = "";
        // $this->concepto = "";
        // $this->credito = "";
        // $this->abonado = "";
        // $this->vencimiento = "";
        // $this->cuotas = "";
        $this->fecha = "NOW()";
    }
    public function registrar_credito()
    {
        $sql = "insert into " . self::$tablename . "(`id`, `credito_detalle_id`, `cobro`)
         VALUES (NULL,\"$this->creditoDetalle\", 0); ";
        // $sql .= "value (NULL,\"$this->ventaId\",NOW(),\"$this->sucursalId\",\"$this->monedaId\",\"$this->concepto\",
        // \"$this->credito\",\"$this->abonado\",\"$this->vencimiento\",\"$this->cuotas\")";
        return Executor::doit($sql);
    }





    public function registro()
    {
        $sql = "insert into cobro_detalle (COBRO_ID,NUMERO_FACTURA,CUOTA,NUMERO_CREDITO,CLIENTE_ID,IMPORTE_COBRO,IMPORTE_CREDITO,SUCURSAL_ID, venta) ";
        $sql .= "value (\"$this->COBRO_ID\",\"$this->NUMERO_FACTURA\",\"$this->CUOTA\",\"$this->NUMERO_CREDITO\",\"$this->CLIENTE_ID\",\"$this->IMPORTE_COBRO\",\"$this->IMPORTE_CREDITO\",\"$this->SUCURSAL_ID\",\"$this->tipo\")";
        return Executor::doit($sql);
    }
    public static function cobranza($id_sucursal)
    {

        $sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal order by id desc";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CreditoDetalleData");
    }


    public static function cobranza_credito($COBRO_ID)
    {

        $sql = "select * from " . self::$tablename . " where COBRO_ID=$COBRO_ID order by COBRO_ID asc";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CobroDetalleData");
    }

    public function getCliente()
    {
        return ClienteData::getById($this->CLIENTE_ID);
    }



    public static function cobranza_creditosum($credito, $cuota)
    {

        $sql = "select * from cobro_detalle where NUMERO_CREDITO=$credito and cuota=$cuota and venta=0";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CobroDetalleData");
    }
    public static function cobranza_creditosum2($credito)
    {

        $sql = "select * from cobro_detalle where NUMERO_CREDITO=$credito and venta=0";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CobroDetalleData");
    }
    public static function cobranza_credito2($credito)
    {

        $sql = "select * from " . self::$tablename . " where NUMERO_CREDITO=$credito order by NUMERO_CREDITO asc";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CobroDetalleData");
    }

    public static function cobranza_credito_detalle()
    {

        $sql = "SELECT id as idT,`NUMERO_FACTURA`, SUM(`IMPORTE_COBRO`) as importeCO, SUM(`IMPORTE_CREDITO`) as importeC FROM `cobro_detalle` GROUP BY `NUMERO_FACTURA`;";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CobroDetalleData");
    }

    public static function agregar_abono($monto, $id)
    {
        $sql = "update " . self::$tablename . " set abonado=abonado+" . $monto . " where venta_id=" . $id . "; ";
        Executor::doit($sql);
    }
    public static function anular($id)
    {
        $sql = "update " . self::$tablename . " set venta = 1 where COBRO_ID=" . $id . "; ";
        Executor::doit($sql);
    }
    public static function obtener($id)
    {
        $sql = "select * from " . self::$tablename . " where COBRO_ID=" . $id . "; ";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CobroDetalleData");
    }
    public static function getCredito($id)
    {
        $sql = "select * from " . self::$tablename . " where credito_detalle_id = " . $id . " ";
        $query = Executor::doit($sql);
        return Model::one($query[0], "CobroDetalleData");
    }
    public static function getByCredito($id)
    {
        $sql = "select * from " . self::$tablename . " where NUMERO_CREDITO= " . $id . " ";
        $query = Executor::doit($sql);
        return Model::many($query[0], "CobroDetalleData");
    }
    public static function getcobroid($id)
    {
        $sql = "SELECT * FROM `cobro_detalle` WHERE `COBRO_ID` = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], "CobroDetalleData");
    }


    public static function totalcobrosdet($id)
    {
        $sql = "SELECT * FROM `cobro_detalle` WHERE `COBRO_ID` = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], "CobroDetalleData");
    }


    public static function eliminarVenta($factura)
    {
        $sql = "DELETE FROM `cobro_detalle` WHERE `NUMERO_FACTURA` like \"$factura\" ";
        return Executor::doit($sql);
    }

    public static function eliminarVentaCliente($factura, $cliente)
    {
        $sql = "DELETE FROM `cobro_detalle` WHERE `NUMERO_FACTURA` like \"$factura\" AND `CLIENTE_ID` = $cliente";
        return Executor::doit($sql);
    }


    public static function eliminarById($id)
    {
        $sql = "DELETE FROM `cobro_detalle` WHERE `id` = $id";
        return Executor::doit($sql);
    }
}
