<?php
class CajaDetalle
{
    public function CajaDetalle()
    {
        $this->cobroId = "";
        $this->clienteId = "";
        $this->caja = "";
        $this->importe = "";
        $this->moneda = "";
        $this->fecha = "NOW()";
        $this->sucursal = "";
    }
    public function agregarDetalle()
    {
        $sql = "INSERT INTO `caja_detalle` (`ID`, `COBRO_ID`, `CAJA`, `IMPORTE`, `ID_MONEDA`, `SUCURSAL_ID`,`CAMBIO`) ";
        $sql .= "VALUES (NULL, \"$this->cobroId\", \"$this->caja\", \"$this->importe\", \"$this->moneda\", \"$this->sucursal\", \"$this->cambio\");";
        return Executor::doit($sql);
    }



    public static function cajadetllecambio($id_cobro)
    {
        $sql = "select * from caja_detalle where `COBRO_ID` = $id_cobro ";
        $query = Executor::doit($sql);
        return Model::many($query[0], new CajaDetalle());
    }



    public static function obtener($id)
    {
        $sql = "SELECT * FROM `caja_detalle` WHERE `COBRO_ID` = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new CajaCabecera());
    }
}
