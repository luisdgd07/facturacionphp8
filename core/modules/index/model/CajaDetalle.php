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
        $sql = "INSERT INTO `caja_detalle` (`ID`, `COBRO_ID`, `CAJA`, `IMPORTE`, `ID_MONEDA`, `SUCURSAL_ID`,`CAMBIO`,`id_venta`,`id_caja_cabecera`) ";
        $sql .= "VALUES (NULL, \"$this->cobroId\", \"$this->caja\", \"$this->importe\", \"$this->moneda\", \"$this->sucursal\", \"$this->cambio\", \"$this->venta\", \"$this->idCajaCabecera\");";
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
        return Model::one($query[0], new CajaDetalle());
    }
    public static function obtenerVarios($id)
    {
        $sql = "SELECT * FROM `caja_detalle` WHERE `COBRO_ID` = $id";
        $query = Executor::doit($sql);
        return Model::many($query[0], new CajaCabecera());
    }
    public static function obtenerVenta($id)
    {
        $sql = "SELECT * FROM `caja_detalle` WHERE `id_venta` = $id";
        $query = Executor::doit($sql);
        return Model::many($query[0], new CajaCabecera());
    }
    public static function eliminarVenta($id)
    {
        $sql = "DELETE FROM `caja_detalle` WHERE `id_venta` = $id";
        return Executor::doit($sql);
    }

    public static function eliminarCobro($id)
    {
        $sql = "DELETE FROM `caja_detalle` WHERE `COBRO_ID` = $id";
        return Executor::doit($sql);
    }
    public static function obtenerSucursal($id)
    {
        $sql = "SELECT * FROM `caja_detalle` WHERE `SUCURSAL_ID` = $id ORDER BY `ID` DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new CajaCabecera());
    }
    public static function obtenerById($id)
    {
        $sql = "SELECT * FROM `caja_detalle` WHERE `ID` = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new CajaDetalle());
    }
}
