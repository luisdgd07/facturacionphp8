<?php
class CobroData
{
    public static $tablename = "cobros";


    public function registrar_credito()
    {
        $sql = "insert into " . self::$tablename . " (`id`, `id_credito`, `fecha_cobro`, `total`, `comentario`) 
        VALUES (NULL, '', '', '', ''); ";
        // $sql .= "value (NULL,\"$this->ventaId\",NOW(),\"$this->sucursalId\",\"$this->monedaId\",\"$this->concepto\",
        // \"$this->credito\",\"$this->abonado\",\"$this->vencimiento\",\"$this->cuotas\")";
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
}
