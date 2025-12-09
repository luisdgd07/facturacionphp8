<?php
class OperationData
{
	public static $tablename = "operacion";
	public function registro_producto()
	{
		$sql = "insert into " . self::$tablename . " (producto_id,q,precio,accion_id,venta_id,fecha) ";
		$sql .= "value (\"$this->producto_id\",\"$this->q\",$this->precio,$this->accion_id,$this->venta_id,NOW())";
		return Executor::doit($sql);
	}
	public function eliminar($id)
	{
		$sql = "DELETE FROM operacion WHERE `operacion`.`id_proceso` = $id ";
		return Executor::doit($sql);
		// return $sql;
	}
	public function registro_producto1()
	{
		$sql = "insert into " . self::$tablename . " (sucursal_id,precio,producto_id,q,accion_id,venta_id,fecha, motivo, stock_trans, precio1,deposito,deposito_nombre) ";
		$sql .= "value (\"$this->sucursal_id\",\"$this->precio\",\"$this->producto_id\",\"$this->q\",$this->accion_id,$this->venta_id,\"$this->fecha\",\"$this->motivo\",$this->stock_trans,$this->precio1,$this->deposito, \"$this->deposito_nombre\")";
		return Executor::doit($sql);
	}
	public function registro_producto2()
	{
		$sql = "insert into " . self::$tablename . " (sucursal_id,precio,producto_id,q,accion_id,venta_id,fecha, motivo, stock_trans, precio1,precio3) ";
		$sql .= "value (\"$this->sucursal_id\",\"$this->precio\",\"$this->producto_id\",\"$this->q\",$this->accion_id,$this->venta_id,NOW(),\"$this->motivo\",$this->stock_trans,$this->precio1,$this->precio3)";
		return Executor::doit($sql);
	}


	public function actualizar2()
	{
		$sql = "update producto set precio_compra=\"$this->precio\" where id_producto=$this->producto_id and  sucursal_id=$this->sucursal_id";
		Executor::doit($sql);
	}

	public function registrotransaccionn2()
	{
		$sql = "insert into " . self::$tablename . " (sucursal_id,accion_id,motivo,id_cobro,transaccion,fecha) ";
		$sql .= "value (\"$this->sucursal_id\",$this->accion_id,\"$this->motivo\",\"$this->id_cobro\",1,NOW())";
		return Executor::doit($sql);
	}
	public function registrotransaccionn()
	{
		$sql = "insert into " . self::$tablename . " (sucursal_id,producto_id,q,accion_id,venta_id,motivo,transaccion,fecha,stock_trans,deposito,observacion) ";
		$sql .= "value (\"$this->sucursal_id\",\"$this->producto_id\",\"$this->q\",$this->accion_id,$this->venta_id,\"$this->motivo\",1,\"$this->fecha\",$this->stock_trans,$this->id_deposito,\"$this->observacion\")";
		return Executor::doit($sql);
		// return $sql;
	}
	public function registrotransaccionD()
	{
		$sql = "insert into " . self::$tablename . " (sucursal_id,producto_id,q,accion_id,venta_id,motivo,transaccion,fecha,stock_trans,deposito,observacion) ";
		$sql .= "value (\"$this->sucursal_id\",\"$this->producto_id\",\"$this->q\",$this->accion_id,$this->venta_id,\"$this->motivo\",1,NOW(),$this->stock_trans,$this->id_deposito,\"$this->observacion\")";
		return Executor::doit($sql);
		// return $sql;
	}
	public static function getById($id_proceso)
	{
		$sql = "select * from " . self::$tablename . " where id_proceso=$id_proceso";
		$query = Executor::doit($sql);
		return Model::one($query[0], new OperationData());
	}


	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
	public static function verTransacciones($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where transaccion=1 and sucursal_id=$id_sucursal OR( transaccion=0 AND accion_id=1 and sucursal_id=$id_sucursal) or ( transaccion=0 AND accion_id=2 and sucursal_id=$id_sucursal)  ";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
	public static function verproductoprocesos($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal order by id_proceso desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
	public static function verproductmasivas($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=2 and transaccion =0 order by id_proceso desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
	public function actualizarmasiva()
	{
		$sql = "update " . self::$tablename . " set masiva=\"$this->masiva\" where id_proceso=$this->id_proceso";
		return Executor::doit($sql);
	}

	public function getPlato()
	{
		return PlatoData::getById($this->plato_id);
	}
	public function getAccion()
	{
		return AccionData::getById($this->accion_id);
	}
	public function getMesa()
	{
		return MesaData::getById($this->mesa_id);
	}
	public function getDelivery()
	{
		return DeliveryData::getById($this->delivery_id);
	}
	public function getProducto()
	{
		return ProductoData::getById($this->producto_id);
	}
	public function getVenta()
	{
		return VentaData::getById($this->venta_id);
	}
	public function getPostre()
	{
		return PostreData::getById($this->postre_id);
	}
	// public function VerVenta(){ return VentaData::getById($this->producto_id);}
	public function getCaja()
	{
		return CajaData::getById($this->caja_id);
	}

	public static function getQYesF($plato_id)
	{
		$q = 0;
		$procesos = self::getAllByPlato($plato_id);
		$input_id = AccionData::getByName("entrada")->id_accion;
		$output_id = AccionData::getByName("salida")->id_accion;
		foreach ($procesos as $proceso) {
			if ($proceso->accion_id == $input_id) {
				$q += $proceso->q;
			} else if ($proceso->accion_id == $output_id) {
				$q += (-$proceso->q);
			}
		}
		// print_r($data);
		return $q;
	}
	public static function getQYesFf($producto_id)
	{
		$q = 0;
		$procesos = self::getAllByProducto($producto_id);
		$input_id = AccionData::getByName("entrada")->id_accion;
		$output_id = AccionData::getByName("salida")->id_accion;
		foreach ($procesos as $proceso) {
			if ($proceso->accion_id == $input_id) {
				$q += $proceso->q;
			} else if ($proceso->accion_id == $output_id) {
				$q += (-$proceso->q);
			}
		}
		// print_r($data);
		return $q;
	}
	public static function getQYesFff($postre_id)
	{
		$q = 0;
		$procesos = self::getAllByPostre($postre_id);
		$input_id = AccionData::getByName("entrada")->id_accion;
		$output_id = AccionData::getByName("salida")->id_accion;
		foreach ($procesos as $proceso) {
			if ($proceso->accion_id == $input_id) {
				$q += $proceso->q;
			} else if ($proceso->accion_id == $output_id) {
				$q += (-$proceso->q);
			}
		}
		// print_r($data);
		return $q;
	}

	public static function getAllByPlato($plato_id)
	{
		$sql = "select * from " . self::$tablename . " where plato_id=$plato_id  order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
	public static function getAllByProducto($producto_id)
	{
		$sql = "select * from " . self::$tablename . " where producto_id=$producto_id  order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
	public static function getAllByPostre($postre_id)
	{
		$sql = "select * from " . self::$tablename . " where postre_id=$postre_id  order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
	public static function getAllProductsBySellId($mesa_id)
	{
		$sql = "select * from " . self::$tablename . " where mesa_id=$mesa_id order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
	public static function getAllProductsBySellIdd($delivery_id)
	{
		$sql = "select * from " . self::$tablename . " where delivery_id=$delivery_id order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
	public static function getAllProductsBySellIddd($venta_id)
	{
		$sql = "select * from " . self::$tablename . " where venta_id=$venta_id order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
	public static function getAllProductsBySellIddd2($venta_id)
	{
		$sql = "select * from " . self::$tablename . " where venta_id=$venta_id order by fecha desc";
		$query = Executor::doit($sql);
		return Model::one($query[0], new OperationData());
	}
	public static function getAllProductsBySellIdddd($venderpostre_id)
	{
		$sql = "select * from " . self::$tablename . " where venderpostre_id=$venderpostre_id order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
	public static function getAllProductsBySellIddddd($verderpostre_id)
	{
		$sql = "select * from " . self::$tablename . " where verderpostre_id=$verderpostre_id order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
	////////////////////////////////////////////////////////////////////////////

	// CAJAS
	// public static function cierre_caja(){
	// 	$sql = "select * from ".self::$tablename." where accion_id=2 and caja_id is NULL order by fecha desc";
	// 	$query = Executor::doit($sql);
	// 	return Model::many($query[0],new OperationData());
	// }
	public static function getAllByPlatoId($plato_id)
	{
		$sql = "select * from " . self::$tablename . " where plato_id=$plato_id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
	public static function getAllByPostreId($postre_id)
	{
		$sql = "select * from " . self::$tablename . " where postre_id=$postre_id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
	public static function getAllByProductoId($producto_id)
	{
		$sql = "select * from " . self::$tablename . " where producto_id=$producto_id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
	public static function getByProductoId($sucursal, $producto_id, $start, $end)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$sucursal and precio!=0 and producto_id=$producto_id and date(fecha) >= \"$start\" and date(fecha) <= \"$end\"";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
	public static function getByProductoId4($sucursal, $producto_id, $start, $end)
	{
		// $sql = "select * from " . self::$tablename . " where sucursal_id=$sucursal and producto_id=$producto_id and date(fecha) >= \"$start\" and date(fecha) <= \"$end\" order by id_proceso desc";
		$sql = "select operacion.*, venta.tipo_venta from operacion INNER JOIN venta ON venta.id_venta = operacion.venta_id where operacion.sucursal_id=$sucursal and operacion.producto_id=$producto_id and date(operacion.fecha) >= \"$start\" and date(operacion.fecha) <= \"$end\" AND venta.tipo_venta !=5 order by fecha desc;";
		if ($start == $end) {
			// $sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\" and producto_id=$producto_id order by id_proceso desc";
			$sql = "select operacion.*, venta.tipo_venta from operacion INNER JOIN venta ON venta.id_venta = operacion.venta_id where operacion.sucursal_id=$sucursal and operacion.producto_id=$producto_id and date(operacion.fecha) = \"$start\" AND venta.tipo_venta !=5 order by fecha desc;";
		}
		$query = Executor::doit($sql);
		// return $sql;
		return Model::many($query[0], new OperationData());
	}
	public static function getByProductoId2($sucursal, $start, $end)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$sucursal  and precio!=0 and date(fecha) >= \"$start\" and date(fecha) <= \"$end\"";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
		// return $sql;
	}
	public static function getByProductoId3($sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$sucursal ";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
		// return $sql;
	}
	public function del()
	{
		$sql = "delete from " . self::$tablename . " where id_proceso=$this->id_proceso";
		Executor::doit($sql);
	}
	public static function getLike($p)
	{
		$sql = "select * from " . self::$tablename . " where venta_id like '%$p%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData1());
	}
	public static function verTransacciones2($id_sucursal, $producto, $start, $end)
	{
		$sql = "select * from " . self::$tablename . " where producto_id=$producto  and transaccion=1 and sucursal_id=$id_sucursal OR( transaccion=0 AND accion_id=1 and sucursal_id=$id_sucursal) or ( transaccion=0 AND accion_id=2 and sucursal_id=$id_sucursal) and date(fecha) >= \"$start\" and date(fecha) <= \"$end\"  ";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}



	public static function verTransacciones3($id_sucursal, $start, $end)
	{
		$sql = "select * from " . self::$tablename . " where  transaccion=1 and sucursal_id=$id_sucursal OR( transaccion=0 AND accion_id=1 and sucursal_id=$id_sucursal) or ( transaccion=0 AND accion_id=2 and sucursal_id=$id_sucursal) and date(fecha) >= \"$start\" and date(fecha) <= \"$end\"  ";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
	public static function verTransacciones12($id_sucursal, $producto)
	{
		$sql = "select * from " . self::$tablename . " where producto_id=$producto  and transaccion=1 and sucursal_id=$id_sucursal OR( transaccion=0 AND accion_id=1 and sucursal_id=$id_sucursal) or ( transaccion=0 AND accion_id=2 and sucursal_id=$id_sucursal) ";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}



	public static function verTransacciones13($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where  transaccion=1 and sucursal_id=$id_sucursal OR( transaccion=0 AND accion_id=1 and sucursal_id=$id_sucursal) or ( transaccion=0 AND accion_id=2 and sucursal_id=$id_sucursal)   ";
		$query = Executor::doit($sql);
		return Model::many($query[0], new OperationData());
	}
}
