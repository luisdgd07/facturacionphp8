<?php
class VentaData1
{
	public static $tablename = "venta1";

	public function VentaData1()
	{
		// $this->fecha = "NOW()";
	}

	public function getCliente()
	{
		return ClienteData::getById($this->cliente_id);
	}
	public function getUser()
	{
		return UserData::getById($this->usuario_id);
	}
	public function getAccion()
	{
		return AccionData::getById($this->accion_id);
	}
	public function getCaja()
	{
		return CajaData::getById($this->caja_id);
	}
	public function verSocursal()
	{
		return SuccursalData::VerId($this->sucursal_id);
	}
	public function VerTipoModena()
	{
		return MonedaData::VerId($this->tipomoneda_id, $this->sucursal_id);
	}

	public function VerTipoModenasimbol()
	{
		return MonedaData::VerId_simbol($this->sucursal_id);
	}

	public function VerConfiFactura()
	{
		return ConfigFacturaData::VerId($this->configfactura_id);
	}
	public function getProducto()
	{
		return ProductoData::getById($this->producto_id);
	}

	// public function add(){
	// 	$sql = "insert into ".self::$tablename." (total,descuento,bolivar,dolar,usuario_id,accion_id,fecha) ";
	// 	$sql .= "value ($this->total,$this->descuento,$this->bolivar,$this->dolar,$this->usuario_id,2,$this->fecha)";
	// 	return Executor::doit($sql);
	// }
	public static function versucursalventas($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}
	public static function versucursaltipoventas($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=2 and ( tipo_venta=0) order by factura desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}


	public static function getnumercionfact($comprobante2, $id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where comprobante2=\"$comprobante2\" and sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while ($r = $query[0]->fetch_array()) {
			$array[$cnt] = new VentaData1();
			$array[$cnt]->comprobante2 = $r['comprobante2'];
			$cnt++;
		}
		return $array;
	}


	public static function versucursaltipoventas_masiva($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=2 and (tipo_venta=1  ) order by factura desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}



	public static function cobranza($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=2 and (tipo_venta=0 or  tipo_venta=1) order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}
	public static function Pagos($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=1 and tipo_venta=0 order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}
	public static function verventasporusuario($id_usuario)
	{
		$sql = "select * from " . self::$tablename . " where usuario_id=$id_usuario and accion_id=2 and caja_id is NULL and tipo_venta!=2 order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}
	public static function versucursaltipocompras($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=1 and tipo_venta=0 order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}
	public static function verventapadre($id_venta)
	{
		$sql = "select * from " . self::$tablename . " where ventapadre=$id_venta";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}
	public function actualizartipoventa()
	{
		$sql = "update " . self::$tablename . " set tipo_venta=\"$this->tipo_venta\" where id_venta=$this->id_venta";
		return Executor::doit($sql);
	}
	public function add()
	{
		$sql = "insert into " . self::$tablename . " (total,presupuesto,configfactura_id,tipomoneda_id,formapago,codigo,fechapago,descuento,bolivar,dolar,usuario_id,accion_id,fecha) ";
		$sql .= "value ($this->total,$this->presupuesto,$this->configfactura_id,$this->tipomoneda_id,$this->formapago,$this->codigo,$this->fechapago,$this->descuento,$this->bolivar,$this->dolar,$this->usuario_id,2,$this->fecha)";
		return Executor::doit($sql);
	}
	public function add1()
	{
		$sql = "insert into " . self::$tablename . " (total,presupuesto,configfactura_id,tipomoneda_id,formapago,codigo,fechapago,descuento,usuario_id,accion_id,fecha) ";
		$sql .= "value ($this->total,$this->presupuesto,$this->configfactura_id,$this->tipomoneda_id,$this->formapago,$this->codigo,$this->fechapago,$this->descuento,$this->usuario_id,2,$this->fecha)";
		return Executor::doit($sql);
	}

	public function add_abastecer()
	{
		$sql = "insert into " . self::$tablename . " (usuario_id,accion_id,fecha) ";
		$sql .= "value ($this->usuario_id,1,$this->fecha)";
		return Executor::doit($sql);
	}
	public function add_abastecer1()
	{
		$sql = "insert into " . self::$tablename . " (sucursal_id,usuario_id,formapago2,comprobante2,timbrado2,codigo2,fecha2,condicioncompra2,cambio2,grabada102,iva102,grabada52,iva52,excenta2,total,accion_id,fecha) ";
		$sql .= "value ($this->sucursal_id,$this->usuario_id,\"$this->formapago2\",\"$this->comprobante2\",\"$this->timbrado2\",\"$this->codigo2\",\"$this->fecha2\",\"$this->condicioncompra2\",\"$this->cambio2\",\"$this->grabada102\",\"$this->iva102\",\"$this->grabada52\",\"$this->iva52\",\"$this->excenta2\",\"$this->total\",1,$this->fecha)";
		return Executor::doit($sql);
	}
	public function registro1()
	{
		$sql = "insert into " . self::$tablename . "(sucursal_id,usuario_id,cliente_id,producto_id,tipomoneda_id,configfactura_id,total,cantidad,iva10,total10,iva5,total5,exenta,factura,numerocorraltivo,cambio,cambio2,simbolo2,metodopago,formapago,ventapadre,tipo_venta,fechapago,fecha)";
		$sql .= "value (\"$this->sucursal_id\",\"$this->usuario_id\",\"$this->cliente_id\",\"$this->producto_id\",\"$this->tipomoneda_id\",\"$this->configfactura_id\",\"$this->total\",\"$this->cantidad\",\"$this->iva10\",\"$this->total10\",\"$this->iva5\",\"$this->total5\",\"$this->exenta\",\"$this->factura\",\"$this->numerocorraltivo\",\"$this->cambio\",\"$this->cambio2\",\"$this->simbolo2\",\"$this->metodopago\",\"$this->formapago\",\"$this->ventapadre\",\"$this->tipo_venta\",\"$this->fechapago\",\"$this->fecha\")";
		return Executor::doit($sql);
	}
	public function venta_producto_cliente()
	{
		$sql = "insert into " . self::$tablename . " (total,descuento,cliente_id,usuario_id,accion_id,fecha) ";
		$sql .= "value ($this->total,$this->descuento,$this->cliente_id,$this->usuario_id,2,$this->fecha)";
		return Executor::doit($sql);
	}
	public function venta_producto_cliente1()
	{
		$sql = "insert into " . self::$tablename . " (presupuesto,factura,configfactura_id,tipomoneda_id,cambio,cambio2,simbolo2,formapago,codigo,fechapago,metodopago,total10,iva10,total5,iva5,exenta,total,n,numerocorraltivo,sucursal_id,cliente_id,usuario_id,cantidaconfigmasiva,accion_id,fecha) ";
		$sql .= "value ($this->presupuesto,\"$this->factura\",$this->configfactura_id,$this->tipomoneda_id,\"$this->cambio\",$this->cambio2,\"$this->simbolo2\",\"$this->formapago\",$this->codigo,\"$this->fechapago\",\"$this->metodopago\",\"$this->total10\",\"$this->iva10\",\"$this->total5\",\"$this->iva5\",\"$this->exenta\",\"$this->total\",$this->n,\"$this->numerocorraltivo\",$this->sucursal_id,$this->cliente_id,$this->usuario_id,\"$this->cantidaconfigmasiva\",2,\"$this->fecha\")";
		return Executor::doit($sql);
	}
	public function registrotranasaccion()
	{
		$sql = "insert into " . self::$tablename . " (sucursal_id,usuario_id,accion_id,fecha,tipo_venta) ";
		$sql .= "value ($this->sucursal_id,$this->usuario_id,$this->accion_id,NOW(),3)";
		return Executor::doit($sql);
	}

	// public function venta_producto_cliente1(){
	// 	$sql = "insert into ".self::$tablename." (total,presupuesto,configfactura_id,tipomoneda_id,formapago,codigo,fechapago,descuento,cliente_id,usuario_id,accion_id,fecha) ";
	// 	$sql .= "value ($this->total,$this->presupuesto,$this->configfactura_id,$this->tipomoneda_id,$this->formapago,$this->codigo,$this->fechapago,$this->descuento,$this->cliente_id,$this->usuario_id,2,$this->fecha)";
	// 	return Executor::doit($sql);
	// }
	// public function venta_producto_cliente(){
	// 	$sql = "insert into ".self::$tablename." (total,descuento,bolivar,dolar,cliente_id,usuario_id,accion_id,fecha) ";
	// 	$sql .= "value ($this->total,$this->descuento,$this->bolivar,$this->dolar,$this->cliente_id,$this->usuario_id,2,$this->fecha)";
	// 	return Executor::doit($sql);
	// }
	public function abastecer_producto_proveedor()
	{
		$sql = "insert into " . self::$tablename . " (cliente_id,accion_id,usuario_id,fecha) ";
		$sql .= "value ($this->cliente_id,1,$this->usuario_id,$this->fecha)";
		return Executor::doit($sql);
	}
	public function abastecer_producto_proveedor1()
	{
		$sql = "insert into " . self::$tablename . " (sucursal_id,cliente_id,formapago2,comprobante2,timbrado2,codigo2,fecha2,condicioncompra2,cambio,cambio2,simbolo2,grabada102,iva102,grabada52,iva52,excenta2,total,tipomoneda_id,accion_id,usuario_id,fecha) ";
		$sql .= "value (\"$this->sucursal_id\",$this->cliente_id,\"$this->formapago2\",\"$this->comprobante2\",\"$this->timbrado2\",\"$this->codigo2\",\"$this->fecha2\",\"$this->condicioncompra2\",\"$this->cambio\",$this->cambio2,\"$this->simbolo2\",\"$this->grabada102\",\"$this->iva102\",\"$this->grabada52\",\"$this->iva52\",\"$this->excenta2\",\"$this->total\",\"$this->tipomoneda_id\",1,$this->usuario_id,\"$this->fecha\")";
		return Executor::doit($sql);
	}

	public static function delById($id)
	{
		$sql = "delete from " . self::$tablename . " where id=$id";
		Executor::doit($sql);
	}
	public static function getVentas($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=2 and (tipo_venta=1  or tipo_venta=0) order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}
	public function del()
	{
		$sql = "delete from operacion where venta_id=$this->id_venta";
		Executor::doit($sql);
	}

	public function del1()
	{
		$sql = "delete from " . self::$tablename . " where id_venta=$this->id_venta ";
		Executor::doit($sql);
	}

	public function update_box()
	{
		$sql = "update " . self::$tablename . " set box_id=$this->box_id where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id_venta)
	{
		$sql = "select * from " . self::$tablename . " where id_venta=$id_venta";
		$query = Executor::doit($sql);
		return Model::one($query[0], new VentaData1());
	}



	public static function getSells()
	{
		$sql = "select * from " . self::$tablename . " where operation_type_id=2 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}

	public static function getSellsUnBoxed()
	{
		$sql = "select * from " . self::$tablename . " where operation_type_id=2 and box_id is NULL order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}

	public static function getByBoxId($id)
	{
		$sql = "select * from " . self::$tablename . " where operation_type_id=2 and box_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}

	public static function getRes()
	{
		$sql = "select * from " . self::$tablename . " where operation_type_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}

	public static function getAllByPage($start_from, $limit)
	{
		$sql = "select * from " . self::$tablename . " where id<=$start_from limit $limit";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}

	public static function getAllByDateOp($start, $end, $op)
	{
		$sql = "select * from " . self::$tablename . " where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and operation_type_id=$op order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1VentaData1());
	}
	public static function getAllByDateBCOp($clientid, $start, $end, $op)
	{
		$sql = "select * from " . self::$tablename . " where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and client_id=$clientid  and operation_type_id=$op order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1VentaData1());
	}
	// CAJAS
	public static function cierre_caja()
	{
		$sql = "select * from " . self::$tablename . " where accion_id=2 and caja_id is NULL order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1VentaData1());
	}
	public static function cierre_caja1($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=2 and caja_id is NULL order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1VentaData1());
	}
	public static function cierre_caja1porusuario($id_usuario)
	{
		$sql = "select * from " . self::$tablename . " where usuario_id=$id_usuario and accion_id=2 and caja_id is NULL order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1VentaData1());
	}
	public function actualizar_caja()
	{
		$sql = "update " . self::$tablename . " set caja_id=$this->caja_id where id_venta=$this->id_venta";
		Executor::doit($sql);
	}
	public static function mostrar_caja($id_venta)
	{
		$sql = "select * from " . self::$tablename . " where accion_id=2 and caja_id=$id_venta order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}
	public static function historial_caja($id_caja)
	{
		$sql = "select * from " . self::$tablename . " where accion_id=2 and caja_id=$id_caja order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}
	// *********************************** REPORTES ******************************
	// -----------------------VENTAS-------------------------------
	public static function getAllByDateOfficial($start, $end)
	{
		$sql = "select * from " . self::$tablename . " where date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and accion_id=2 order by fecha desc";
		if ($start == $end) {
			$sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\" and accion_id=2 order by fecha desc";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}
	//public static function getAllByDateOfficialGs($start,$end){
	//$sql = "select * from ".self::$tablename." where date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and accion_id=1 order by fecha desc";
	//   if($start == $end){
	//$sql = "select * from ".self::$tablename." where date(fecha) = \"$start\" and accion_id=2 order by fecha desc";
	//}
	//$query = Executor::doit($sql);
	//return Model::many($query[0],new VentaData1VentaData1());
	// }
	public static function getAllByDateOfficialBP($producto, $start, $end)
	{
		$sql = "select * from " . self::$tablename . " where date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and uso_id=$producto and accion_id=2 order by fecha desc";
		if ($start == $end) {
			$sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\" and accion_id=2 order by fecha desc";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1VentaData1());
	}
	public function registrarcobranza()
	{
		$sql = "update " . self::$tablename . " set cash=\"$this->cash\" ,pagado=\"$this->pagado\" where id_venta=$this->id_venta";
		return Executor::doit($sql);
	}


	public static function getAllByDateOfficialGs($start, $end, $id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and accion_id=2 and (tipo_venta=1  or tipo_venta=0) order by fecha desc";
		if ($start == $end) {
			$sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\" and accion_id=2 and (tipo_venta=1  or tipo_venta=0) and sucursal_id=$id_sucursal order by fecha desc";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}



	public static function getAllByDateOfficialGs2($start, $end, $id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and accion_id=1 and tipo_venta=0 order by fecha desc";
		if ($start == $end) {
			$sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\" and accion_id=1  and sucursal_id=$id_sucursal   and tipo_venta=0 order by fecha desc";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData1());
	}
	public static function vercontenidos($id_venta){
		$sql = "select * from ".self::$tablename." where id_venta=$id_venta";
		$query = Executor::doit($sql);
		return Model::many($query[0],new VentaData1());
	}

}
