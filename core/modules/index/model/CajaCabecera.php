<?php
class CajaCabecera
{
    public function CajaCabecera()
    {
        $this->cobroId = "";
        $this->clienteId = "";
        $this->total = "";
        $this->sucursal = "";
    }
    public function agregarCaja()
    {
        $sql = "INSERT INTO `cajas_cabecera` (`ID`,`COBRO_ID`, `ID_CLIENTE`, `FECHA`, `TOTAL_COBRO`, `SUCURSAL_ID`, `concepto`)";
        // $sql .= "VALUES (, '', '', '', '', '');";
        $sql .= "VALUES (NULL,\"$this->cobroId\", \"$this->clienteId\", \"$this->fecha\", \"$this->total\", \"$this->sucursal\", \"$this->concepto\");";

        return Executor::doit($sql);
    }



    public static function cajacabeceraconcepto($id_cobro)
    {
        $sql = "select * from cajas_cabecera where `COBRO_ID` = $id_cobro ";
        $query = Executor::doit($sql);
        return Model::many($query[0], new CajaCabecera());
    }


    public static function obtener($id)
    {
        $sql = "SELECT * FROM `cajas_cabecera` WHERE `COBRO_ID` = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new CajaCabecera());
    }
    public function actualizarCaja()
    {
        $sql = "INSERT INTO `cajas_cabecera` (`ID`,`COBRO_ID`, `ID_CLIENTE`, `FECHA`, `TOTAL_COBRO`, `SUCURSAL_ID`, `concepto`)";
        // $sql .= "VALUES (, '', '', '', '', '');";
        $sql .= "VALUES (NULL,\"$this->cobroId\", \"$this->clienteId\", \"$this->fecha\", \"$this->total\", \"$this->sucursal\", \"$this->concepto\");";
        return Executor::doit($sql);
    }
    public static function obtenerSucursal($id)
    {
        $sql = "SELECT * FROM `cajas_cabecera` WHERE `SUCURSAL_ID` = $id ORDER BY `cajas_cabecera`.`FECHA` DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new CajaCabecera());
    }

    public static function eliminarCobro($id)
    {
        $sql = "DELETE FROM cajas_cabecera WHERE `COBRO_ID` = $id";
        return  Executor::doit($sql);
    }

    public static function obtenerCobroId($id)
    {
        $sql = "SELECT * FROM `cajas_cabecera` WHERE `COBRO_ID` = $id ";
        $query = Executor::doit($sql);
        return Model::one($query[0], new CajaCabecera());
    }
    public static function obtenerById($id)
    {
        $sql = "SELECT * FROM `cajas_cabecera` WHERE `ID` = $id ";
        $query = Executor::doit($sql);
        return Model::one($query[0], new CajaCabecera());
    }
}
