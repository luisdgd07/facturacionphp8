<?php
class CobroCabecera
{
	public static $tablename = "cobro_cabecera";


	public function CobroCabecera()
	{
		// $this->fecha = "NOW()";
	}

	public function registro()
	{
		$sql = "insert into cobro_cabecera (RECIBO,FECHA_COBRO,CLIENTE_ID,TOTAL_COBRO,SUCURSAL_ID,MONEDA_ID,configfactura_id) ";
		$sql .= "value (\"$this->RECIBO\",\"$this->FECHA_COBRO\",$this->CLIENTE_ID,\"$this->TOTAL_COBRO\",$this->SUCURSAL_ID,$this->MONEDA_ID,$this->configfactura_id)";
		return Executor::doit($sql);
	}
	public static function anular($id)
	{
		$sql = "update " . self::$tablename . " set anulado = 1 where COBRO_ID=" . $id . "; ";
		Executor::doit($sql);
		// return $sql;
	}
	public static function obtener($id)
	{
		$sql = "select * from " . self::$tablename . " where COBRO_ID=" . $id . "; ";
		Executor::doit($sql);
	}

	public static function getCobro($id)
	{
		$sql = "select * from " . self::$tablename . " where COBRO_ID = " . $id . " ";
		$query = Executor::doit($sql);
		return Model::one($query[0], new CobroCabecera());
	}




	public static function totalcobros2($SUCURSAL_ID)
	{
		$sql = "select * from cobro_cabecera where `SUCURSAL_ID` = $SUCURSAL_ID ";
		$query = Executor::doit($sql);
		return Model::one($query[0], new CobroCabecera());
	}

	public function getCliente()
	{
		return ClienteData::getById($this->CLIENTE_ID);
	}


	public static function totalcobros($SUCURSAL_ID, $cliente, $start, $end)
	{
		$sql = "SELECT * from cobro_cabecera C INNER JOIN cobro_detalle d ON C.COBRO_ID = d.COBRO_ID and d.venta =0 ";
		if ($cliente !== "todos") {
			$sql = $sql . "and C.CLIENTE_ID = " . $cliente;
		}
		$sql = $sql . " and date(FECHA_COBRO) >= \"$start\" and date(FECHA_COBRO) <= \"$end\"  and C.SUCURSAL_ID = $SUCURSAL_ID  order by FECHA_COBRO desc";

		// return $sql;
		$query = Executor::doit($sql);
		return Model::many($query[0], new CobroCabecera());
	}
	public static function totalcobrosG($SUCURSAL_ID, $cliente, $start, $end, $credito)
	{
		$sql = "SELECT * from cobro_cabecera C INNER JOIN cobro_detalle d ON C.COBRO_ID = d.COBRO_ID and d.venta =0 ";
		if ($cliente !== "todos") {
			$sql = $sql . "and C.CLIENTE_ID = " . $cliente;
		}
		$sql = $sql . " and d.NUMERO_CREDITO=$credito and date(FECHA_COBRO) >= \"$start\" and date(FECHA_COBRO) <= \"$end\"  and C.SUCURSAL_ID = $SUCURSAL_ID  order by FECHA_COBRO desc";

		// return $sql;
		$query = Executor::doit($sql);
		return Model::many($query[0], new CobroCabecera());
	}
	public static function totalestadocobros($SUCURSAL_ID, $cliente, $start, $end)
	{
		$sql = "SELECT v.factura,v.cliente_id, v.total, creditos.* FROM `creditos` INNER join venta v on v.id_venta = creditos.venta_id  where  date(v.fecha) >= \"$start\" and date(v.fecha) <= \"$end\" and v.sucursal_id =$SUCURSAL_ID";
		if ($cliente !== "todos") {
			$sql = $sql . " and v.cliente_id = " . $cliente;
		}
		$sql = $sql . " order by v.fecha desc";

		// return $sql;
		$query = Executor::doit($sql);
		return Model::many($query[0], new CobroCabecera());
	}

	public static function totalcobros3($SUCURSAL_ID)
	{
		$sql = "SELECT *, C.anulado from cobro_cabecera C INNER JOIN cobro_detalle d ON C.COBRO_ID = d.COBRO_ID and C.SUCURSAL_ID = $SUCURSAL_ID   order by RECIBO desc";

		$query = Executor::doit($sql);
		return Model::many($query[0], new CobroCabecera());
	}
	public static function getultimoCobro()
	{
		$sql
			=	"SELECT * FROM `cobro_cabecera` ORDER BY `cobro_cabecera`.`COBRO_ID` DESC LIMIT 1";
		$query = Executor::doit($sql);
		return Model::one($query[0], new CobroCabecera());
	}
	public static function getVenta($factura)
	{
		$sql
			=	"SELECT * FROM `venta` WHERE `factura` LIKE '$factura'";
		$query = Executor::doit($sql);
		return Model::one($query[0], new CobroCabecera());
	}

	public static function getCredito($idventa)
	{
		$sql
			=	"SELECT * FROM `creditos` WHERE `venta_id` = $idventa";
		$query = Executor::doit($sql);
		return Model::one($query[0], new CobroCabecera());
	}
	public static function getMoneda($id)
	{
		$sql
			=	"SELECT * FROM `tipomoneda` WHERE `id_tipomoneda` = $id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new CobroCabecera());
	}
}
