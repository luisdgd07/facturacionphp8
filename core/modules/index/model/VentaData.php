<?php
class VentaData
{
	public static $tablename = "venta";

	public function VentaData()
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
		try {
			return MonedaData::VerId($this->tipomoneda_id, $this->sucursal_id);
		} catch (Exception $e) {
			return null;
		}
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
	public static function getbyfactura($codigo, $id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where factura=\"$codigo\" and sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::one($query[0], new VentaData());
	}

	public static function getNombre($codigo, $id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where factura=\"$codigo\" and sucursal_id=$id_sucursal  and ( tipo_venta=0 or tipo_venta=5 ) ";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while ($r = $query[0]->fetch_array()) {
			$array[$cnt] = new VentaData();
			$array[$cnt]->codigo = $r['codigo'];
			$cnt++;
		}
		return $array;
	}


	public static function getNombre2($codigo, $id_sucursal)
	{
		$sql = "select * from remision where factura=\"$codigo\" and sucursal_id=$id_sucursal and tipo_venta=4 ";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while ($r = $query[0]->fetch_array()) {
			$array[$cnt] = new VentaData();
			$array[$cnt]->codigo = $r['codigo'];
			$cnt++;
		}
		return $array;
	}

	public static function getNombre4($codigo, $id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where factura=\"$codigo\" and sucursal_id=$id_sucursal and tipo_venta=15 ";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while ($r = $query[0]->fetch_array()) {
			$array[$cnt] = new VentaData();
			$array[$cnt]->codigo = $r['codigo'];
			$cnt++;
		}
		return $array;
	}


	public static function versucursalventas($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal order by id_venta desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function remision($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and REMISION_ID=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function versucursaltipoventas($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=2 and ( tipo_venta=0) and (estado =1 or estado=2) and fecha >= '2023-01-01' order by id_venta desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}

	public static function versucursaltipoventastot($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=2 and ( tipo_venta=0 or tipo_venta=5  ) and (estado =1 or estado=2) and fecha >= '2023-01-01' order by id_venta desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}


	public static function versucursaltipoventastotN($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=1 and ( tipo_venta=15 ) and (estado =1 or estado=2) and fecha >= '2023-01-01' order by id_venta desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}



	public static function getnota_credito($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=2 and ( tipo_venta=15) and (estado =1 or estado=2) and fecha >= '2023-01-01'  order by id_venta desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}



	public static function versucursaltipoventasremi($id_sucursal)
	{
		$sql = "select * from remision where sucursal_id=$id_sucursal and accion_id=2 and ( tipo_venta=4) and estado =1 and fecha >= '2023-01-01' and  tipo_remision != 3 order by id_venta desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}



	public static function versucursaltipoventasremiexp($id_sucursal)
	{
		$sql = "select * from remision where sucursal_id=$id_sucursal and accion_id=2 and ( tipo_venta=4) and estado =1 and fecha >= '2023-01-01' and  tipo_remision=3 order by id_venta desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}

	public static function versucursaltipoventasremi2($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=2 and ( tipo_venta=4) and  ( estado =1 or  estado =0 or  estado =2) and fecha >= '2023-01-01' order by id_venta desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}


	public static function versucursaltipoventasremi10($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=2 and ( tipo_venta=15) and  ( estado =1 or  estado =0) order by id_venta desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}

	public static function versucursaltipoventasremi4($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=2 and ( tipo_venta=4) and fecha >= '2023-01-01' order by id_venta desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function versucursaltipoventasremi3($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and ( tipo_venta=5) and  ( estado =1 or  estado =0 or  estado =2) and fecha >= '2023-01-01'  order by id_venta desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function versucursaltipoventasexportacion($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and ( tipo_venta=20) and  ( estado =1 or  estado =0 or  estado =2) and fecha >= '2023-01-01'  order by id_venta desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}

	public static function getnumercionfact($comprobante2, $id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where comprobante2 like \"$comprobante2\" and sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}


	public static function versucursaltipoventas_masiva($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=2 and (tipo_venta=1  ) order by factura desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}


	public function venta_producto_cliente_nota()
	{
		$sql = "insert into nota_credito_venta (presupuesto,factura,configfactura_id,tipomoneda_id,cambio,cambio2,simbolo2,formapago,codigo,fechapago,metodopago,total10,iva10,total5,iva5,exenta,total,n,numerocorraltivo,sucursal_id,cliente_id,usuario_id,cantidaconfigmasiva,accion_id,fecha,REMISION_ID, estado, tipo_venta, numero_factura,cdc_fact, timbrado_factura,tipo_nota) ";
		$sql .= "value ($this->presupuesto,\"$this->factura\",$this->configfactura_id,$this->tipomoneda_id,\"$this->cambio\",$this->cambio2,\"$this->simbolo2\",\"$this->formapago\",$this->codigo,\"$this->fechapago\",\"$this->metodopago\",\"$this->total10\",\"$this->iva10\",\"$this->total5\",\"$this->iva5\",\"$this->exenta\",\"$this->total\",$this->n,\"$this->numerocorraltivo\",$this->sucursal_id,$this->cliente_id,$this->usuario_id,\"$this->cantidaconfigmasiva\",1,\"$this->fecha\",$this->REMISION_ID,1,15, \"$this->factura_1\",\"$this->cdc_fact\",\"$this->timbrado_fact\",$this->tipo_nota)";
		return Executor::doit($sql);
		// return $sql;
	}
	public static function cobranza($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=2 and (tipo_venta=0 or  tipo_venta=1 or tipo_venta=5) order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function Pagos($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=1 and tipo_venta=0 order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function verventasporusuario($id_usuario)
	{
		$sql = "select * from " . self::$tablename . " where usuario_id=$id_usuario and accion_id=2 and caja_id is NULL and tipo_venta!=2 order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function versucursaltipocompras($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=1 and tipo_venta=0 order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}


	public static function versucursaltipotrans($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and tipo_venta != 5 order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function versucursaltipotrans2($id_sucursal, $start, $end)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and tipo_venta != 5 and date(fecha) >= \"$start\" and date(fecha) <= \"$end\"  order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}

	public static function verventapadre($id_venta)
	{
		$sql = "select * from " . self::$tablename . " where ventapadre=$id_venta";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
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
		// $sql = "insert into " . self::$tablename . " (total,presupuesto,configfactura_id,tipomoneda_id,formapago,codigo,fechapago,descuento,usuario_id,accion_id,fecha,REMISION_ID, direccion) ";
		// $sql .= "value ($this->total,$this->presupuesto,$this->configfactura_id,$this->tipomoneda_id,$this->formapago,$this->codigo,$this->fechapago,$this->descuento,$this->usuario_id,2,$this->fecha,$this->REMISION_ID,$this->destino)";
		// return Executor::doit($sql);
	}
	public function add2()
	{
		$sql = "insert into " . self::$tablename . " (total,presupuesto,configfactura_id,tipomoneda_id,formapago,codigo,fechapago,descuento,usuario_id,accion_id,fecha,REMISION_ID) ";
		$sql .= "value ($this->total,$this->presupuesto,$this->configfactura_id,$this->tipomoneda_id,$this->formapago,$this->codigo,$this->fechapago,$this->descuento,$this->usuario_id,2,$this->fecha,$this->1)";
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
	public function acturalizar_estado_cleinte_nota()
	{
		$sql = "update credito_detalle set saldo_credito= saldo_credito - $this->total where nrofactura=\"$this->factura_1\" and sucursal_id=$this->sucursal_id";
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
		$sql = "insert into " . self::$tablename . " (presupuesto,factura,configfactura_id,tipomoneda_id,cambio,cambio2,simbolo2,formapago,codigo,fechapago,metodopago,total10,iva10,total5,iva5,exenta,total,n,numerocorraltivo,sucursal_id,cliente_id,usuario_id,cantidaconfigmasiva,accion_id,fecha,REMISION_ID, estado,vendedor,transaccion,id_dncp	) ";
		$sql .= "value ($this->presupuesto,\"$this->factura\",$this->configfactura_id,$this->tipomoneda_id,\"$this->cambio\",$this->cambio2,\"$this->simbolo2\",\"$this->formapago\",$this->codigo,\"$this->fechapago\",\"$this->metodopago\",\"$this->total10\",\"$this->iva10\",\"$this->total5\",\"$this->iva5\",\"$this->exenta\",\"$this->total\",$this->n,\"$this->numerocorraltivo\",$this->sucursal_id,$this->cliente_id,$this->usuario_id,\"$this->cantidaconfigmasiva\",2,\"$this->fecha\",$this->REMISION_ID,1,\"$this->vendedor\",\"$this->transaccion\",$this->dncp)";
		return Executor::doit($sql);
		// return $sql;
	}
	public function venta_producto_cliente_contrato()
	{
		$sql = "insert into " . self::$tablename . " (presupuesto,factura,configfactura_id,tipomoneda_id,cambio,cambio2,simbolo2,formapago,codigo,fechapago,metodopago,total10,iva10,total5,iva5,exenta,total,n,numerocorraltivo,sucursal_id,cliente_id,usuario_id,cantidaconfigmasiva,accion_id,fecha,REMISION_ID, estado) ";
		$sql .= "value ($this->presupuesto,\"$this->factura\",$this->configfactura_id,$this->tipomoneda_id,\"$this->cambio\",$this->cambio2,\"$this->simbolo2\",\"$this->formapago\",$this->codigo,\"$this->fechapago\",\"$this->metodopago\",\"$this->total10\",\"$this->iva10\",\"$this->total5\",\"$this->iva5\",\"$this->exenta\",\"$this->total\",$this->n,\"$this->numerocorraltivo\",$this->sucursal_id,$this->cliente_id,$this->usuario_id,\"$this->cantidaconfigmasiva\",2,\"$this->fecha\",$this->REMISION_ID,1)";
		return Executor::doit($sql);
		// return $sql;
	}
	public function venta_producto_cliente3()
	{
		$sql = "insert into " . self::$tablename . " (presupuesto,factura,configfactura_id,tipomoneda_id,cambio,cambio2,simbolo2,formapago,codigo,fechapago,metodopago,total10,iva10,total5,iva5,exenta,total,n,numerocorraltivo,sucursal_id,cliente_id,usuario_id,cantidaconfigmasiva,accion_id,fecha,REMISION_ID, estado, cdc_fact, numero_factura, tipo_venta,vendedor,transaccion,id_dncp	) ";
		$sql .= "value ($this->presupuesto,\"$this->factura\",$this->configfactura_id,$this->tipomoneda_id,\"$this->cambio\",$this->cambio2,\"$this->simbolo2\",\"$this->formapago\",$this->codigo,\"$this->fechapago\",\"$this->metodopago\",\"$this->total10\",\"$this->iva10\",\"$this->total5\",\"$this->iva5\",\"$this->exenta\",\"$this->total\",$this->n,\"$this->numerocorraltivo\",$this->sucursal_id,$this->cliente_id,$this->usuario_id,\"$this->cantidaconfigmasiva\",2,\"$this->fecha\",$this->REMISION_ID,1,\"$this->cdc_fact\",\"$this->num_fact\",5,\"$this->vendedor\",\"$this->transaccion\",$this->dncp)";
		return Executor::doit($sql);
	}
	public function venta_producto_cliente_exportacion()
	{
		$sql = "insert into " . self::$tablename . " (presupuesto,factura,configfactura_id,tipomoneda_id,cambio,cambio2,simbolo2,formapago,codigo,fechapago,metodopago,total10,iva10,total5,iva5,exenta,total,n,numerocorraltivo,sucursal_id,cliente_id,usuario_id,cantidaconfigmasiva,accion_id,fecha,REMISION_ID, estado, cdc_fact, numero_factura, tipo_venta,agente_id, fletera_id, id_chofer, condiNego, manifiesto,peso_neto, peso_bruto) ";
		$sql .= "value ($this->presupuesto,\"$this->factura\",$this->configfactura_id,$this->tipomoneda_id,\"$this->cambio\",$this->cambio2,\"$this->simbolo2\",\"$this->formapago\",$this->codigo,\"$this->fechapago\",\"$this->metodopago\",\"$this->total10\",\"$this->iva10\",\"$this->total5\",\"$this->iva5\",\"$this->exenta\",\"$this->total\",$this->n,\"$this->numerocorraltivo\",$this->sucursal_id,$this->cliente_id,$this->usuario_id,\"$this->cantidaconfigmasiva\",2,\"$this->fecha\",$this->REMISION_ID,1,\"$this->cdc_fact\",'',\"$this->tipo\",\"$this->agente\" ,\"$this->fletera\",\"$this->chofer_id\",\"$this->condiNego\",\"$this->manifiesto\",\"$this->peson\",\"$this->pesob\")";

		return Executor::doit($sql);
	}
	public function venta_producto_cliente2()
	{
		$sql = "insert into " . self::$tablename . " (presupuesto,factura,configfactura_id,tipomoneda_id,cambio,cambio2,simbolo2,formapago,codigo,fechapago,metodopago,total10,iva10,total5,iva5,exenta,total,n,numerocorraltivo,sucursal_id,cliente_id,usuario_id,cantidaconfigmasiva,accion_id,fecha,REMISION_ID, tipo_venta, estado,id_chofer, id_vehiculo, id_dep, id_ciudad, destino,ninicio, nfin, serie_placa) ";
		$sql .= "value ($this->presupuesto,\"$this->factura\",$this->configfactura_id,$this->tipomoneda_id,\"$this->cambio\",$this->cambio2,\"$this->simbolo2\",\"$this->formapago\",$this->codigo,\"$this->fechapago\",\"$this->metodopago\",\"$this->total10\",\"$this->iva10\",\"$this->total5\",\"$this->iva5\",\"$this->exenta\",\"$this->total\",$this->n,\"$this->numerocorraltivo\",$this->sucursal_id,$this->cliente_id,$this->usuario_id,\"$this->cantidaconfigmasiva\",2,\"$this->fecha\",1,4,1, \"$this->chofer_id\", \"$this->vehiculo_id\", \"$this->dep_id\", \"$this->ciudad_id\",\"$this->destino\",\"$this->inicio\",\"$this->fin\",\"$this->serie_placa\")";
		return Executor::doit($sql);
	}

	/* public function venta_producto_cliente4()
	{
		$sql = "insert into " . self::$tablename . " (presupuesto,factura,configfactura_id,tipomoneda_id,cambio,cambio2,simbolo2,formapago,codigo,fechapago,metodopago,total10,iva10,total5,iva5,exenta,total,n,numerocorraltivo,sucursal_id,cliente_id,usuario_id,cantidaconfigmasiva,accion_id,fecha,REMISION_ID, tipo_venta, estado,id_chofer, id_vehiculo, id_dep, id_ciudad, destino,tipo_remision, contrato_id) ";
		$sql .= "value ($this->presupuesto,\"$this->factura\",$this->configfactura_id,$this->tipomoneda_id,\"$this->cambio\",$this->cambio2,\"$this->simbolo2\",\"$this->formapago\",$this->codigo,\"$this->fechapago\",\"$this->metodopago\",\"$this->total10\",\"$this->iva10\",\"$this->total5\",\"$this->iva5\",\"$this->exenta\",\"$this->total\",$this->n,\"$this->numerocorraltivo\",$this->sucursal_id,$this->cliente_id,$this->usuario_id,\"$this->cantidaconfigmasiva\",2,\"$this->fecha\",1,4,1, \"$this->chofer_id\", \"$this->vehiculo_id\", \"$this->dep_id\", \"$this->ciudad_id\",\"$this->destino\",\"$this->tipo_remision\",\"$this->contrato\")";
		return Executor::doit($sql);
	}
    */
	public function venta_producto_cliente4()
	{
		$sql = "insert into remision (presupuesto,factura,configfactura_id,tipomoneda_id,cambio,cambio2,simbolo2,formapago,codigo,fechapago,metodopago,total10,iva10,total5,iva5,exenta,total,n,numerocorraltivo,sucursal_id,cliente_id,usuario_id,cantidaconfigmasiva,accion_id,fecha,REMISION_ID, tipo_venta, estado,id_chofer, id_vehiculo, id_dep, id_ciudad, destino,tipo_remision, peso_neto, peso_bruto, fletera_id,vendedor,tipo_transporte, id_dncp) ";
		$sql .= "value ($this->presupuesto,\"$this->factura\",$this->configfactura_id,$this->tipomoneda_id,\"$this->cambio\",$this->cambio2,\"$this->simbolo2\",\"$this->formapago\",$this->codigo,\"$this->fechapago\",\"$this->metodopago\",\"$this->total10\",\"$this->iva10\",\"$this->total5\",\"$this->iva5\",\"$this->exenta\",\"$this->total\",$this->n,\"$this->numerocorraltivo\",$this->sucursal_id,$this->cliente_id,$this->usuario_id,\"$this->cantidaconfigmasiva\",2,\"$this->fecha\",1,4,1, \"$this->chofer_id\", \"$this->vehiculo_id\", \"$this->dep_id\", \"$this->ciudad_id\",\"$this->destino\",\"$this->tipo_remision\",\"$this->peson\",\"$this->pesob\",\"$this->fletera\",\"$this->vendedor_id\",\"$this->tipo_transporte\", $this->dncp)";
		return Executor::doit($sql);
	}



	public function actualizaremision()
	{
		$sql = "update remision set estado=0  where id_venta=$this->REMISION_ID";
		return Executor::doit($sql);
	}

	public function cancelar()
	{
		$sql = "update " . self::$tablename . " set enviado='Cancelado'  where id_venta=$this->id";
		return Executor::doit($sql);
	}


	public function actualizarestado()
	{
		$sql = "update venta set estado=2 where id_venta=$this->id_venta ";
		Executor::doit($sql);
	}



	public function actualizarestado5()
	{
		$sql = "update venta set estado=7 where id_venta=$this->id_venta ";
		Executor::doit($sql);
	}
	public static function eliminar($id)
	{
		$sql = "DELETE FROM venta WHERE `venta`.`id_venta` = $id ";
		return Executor::doit($sql);
		// return $sql;
	}
	public function registrotranasaccion()
	{
		$sql = "insert into " . self::$tablename . " (sucursal_id,usuario_id,accion_id,fecha,tipo_venta) ";
		$sql .= "value ($this->sucursal_id,$this->usuario_id,$this->accion_id,\"$this->fecha\",3)";
		return Executor::doit($sql);
	}
	public function registrotranasaccionD()
	{
		$sql = "insert into " . self::$tablename . " (sucursal_id,usuario_id,accion_id,fecha,tipo_venta) ";
		$sql .= "value ($this->sucursal_id,$this->usuario_id,$this->accion_id,NOW(),3)";
		return Executor::doit($sql);
	}
	public function abastecer_producto_proveedor()
	{
		$sql = "insert into " . self::$tablename . " (cliente_id,accion_id,usuario_id,fecha) ";
		$sql .= "value ($this->cliente_id,1,$this->usuario_id,$this->fecha)";
		return Executor::doit($sql);
	}
	public function abastecer_producto_proveedor1()
	{
		$sql = "insert into " . self::$tablename . " (formapago,metodopago,sucursal_id,cliente_id,formapago2,comprobante2,timbrado2,codigo2,fecha2,condicioncompra2,cambio,cambio2,simbolo2,grabada102,iva102,grabada52,iva52,excenta2,total,tipomoneda_id,accion_id,usuario_id,fecha) ";
		$sql .= "value (\"$this->formapago\",\"$this->metodopago\",\"$this->sucursal_id\",$this->cliente_id,\"$this->formapago2\",\"$this->comprobante2\",\"$this->timbrado2\",\"$this->codigo2\",\"$this->fecha2\",\"$this->condicioncompra2\",\"$this->cambio\",$this->cambio2,\"$this->simbolo2\",\"$this->grabada102\",\"$this->iva102\",\"$this->grabada52\",\"$this->iva52\",\"$this->excenta2\",\"$this->total\",\"$this->tipomoneda_id\",1,$this->usuario_id,\"$this->fecha\")";
		return Executor::doit($sql);
		// return $sql;
	}

	public static function delById($id)
	{
		$sql = "delete from " . self::$tablename . " where id=$id";
		Executor::doit($sql);
	}

	public static function vercontenidos($id_venta)
	{
		$sql = "select * from " . self::$tablename . " where id_venta=$id_venta";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
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

	public function actualizarFE($id, $envio, $xml, $cdc, $kude, $fecha, $tipo)
	{
		$sql = "UPDATE " . $tipo . " SET `enviado` = '$envio', `cdc` = '$cdc' , `xml` = '$xml' , `kude` = '$kude', `fecha_envio` = '$fecha' WHERE `id_venta` = $id;";
		Executor::doit($sql);
	}

	public static function getById($id_venta)
	{
		$sql = "select * from " . self::$tablename . " where id_venta=$id_venta";
		$query = Executor::doit($sql);
		return Model::one($query[0], new VentaData());
	}

	public static function getByIdRemision($id_venta)
	{
		$sql = "select * from remision where id_venta=$id_venta";
		$query = Executor::doit($sql);
		return Model::one($query[0], new VentaData());
	}

	public static function getByIdInTable($id_venta, $tabla = "venta")
	{

		$sql = "select * from " . $tabla . " where id_venta=$id_venta";
		$query = Executor::doit($sql);
		return Model::one($query[0], new VentaData());
	}
	public static function getByCLienteId($id)
	{
		$sql = "SELECT * FROM `venta` WHERE `cliente_id` = $id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function getByCLienteIdContrato($id, $contrato)
	{
		$sql = "SELECT * FROM `venta` WHERE `cliente_id` = $id AND contrato_id AND contrato_id = $contrato";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}

	public static function getSells()
	{
		$sql = "select * from " . self::$tablename . " where operation_type_id=2 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}

	public static function getSellsUnBoxed()
	{
		$sql = "select * from " . self::$tablename . " where operation_type_id=2 and box_id is NULL order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}

	public static function getByBoxId($id)
	{
		$sql = "select * from " . self::$tablename . " where operation_type_id=2 and box_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}

	public static function getRes()
	{
		$sql = "select * from " . self::$tablename . " where operation_type_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}

	public static function getAllByPage($start_from, $limit)
	{
		$sql = "select * from " . self::$tablename . " where id<=$start_from limit $limit";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}

	public static function getAllByDateOp($start, $end, $op)
	{
		$sql = "select * from " . self::$tablename . " where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and operation_type_id=$op order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function getAllByDateBCOp($clientid, $start, $end, $op)
	{
		$sql = "select * from " . self::$tablename . " where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and client_id=$clientid  and operation_type_id=$op order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	// CAJAS
	public static function cierre_caja()
	{
		$sql = "select * from " . self::$tablename . " where accion_id=2 and caja_id is NULL order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function cierre_caja1($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=2 and caja_id is NULL order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function cierre_caja1porusuario($id_usuario)
	{
		$sql = "select * from " . self::$tablename . " where usuario_id=$id_usuario and accion_id=2 and caja_id is NULL order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
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
		return Model::many($query[0], new VentaData());
	}
	public static function getId($id_venta)
	{
		$sql = "SELECT * FROM `venta` WHERE `id_venta` = $id_venta order by id_venta desc ";
		$query = Executor::doit($sql);
		return Model::one($query[0], new VentaData());
	}
	public static function getRemisionId($id_venta)
	{
		$sql = "SELECT * FROM `remision` WHERE `id_venta` = $id_venta order by id_venta desc ";
		$query = Executor::doit($sql);
		return Model::one($query[0], new VentaData());
	}


	public static function getVentas($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and accion_id=2 and (tipo_venta=1  or tipo_venta=0 or tipo_venta=5) and total <> 0 order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}





	public static function historial_caja($id_caja)
	{
		$sql = "select * from " . self::$tablename . " where accion_id=2 and caja_id=$id_caja order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
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
		return Model::many($query[0], new VentaData());
	}
	//public static function getAllByDateOfficialGs($start,$end){
	//$sql = "select * from ".self::$tablename." where date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and accion_id=1 order by fecha desc";
	//   if($start == $end){
	//$sql = "select * from ".self::$tablename." where date(fecha) = \"$start\" and accion_id=2 order by fecha desc";
	//}
	//$query = Executor::doit($sql);
	//return Model::many($query[0],new VentaData());
	// }
	public static function getAllByDateOfficialBP($producto, $start, $end)
	{
		$sql = "select * from " . self::$tablename . " where date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and uso_id=$producto and accion_id=2 order by fecha desc";
		if ($start == $end) {
			$sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\" and accion_id=2 order by fecha desc";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public function registrarcobranza()
	{
		$sql = "update " . self::$tablename . " set cash=\"$this->cash\" ,pagado=\"$this->pagado\" where id_venta=$this->id_venta";
		return Executor::doit($sql);
	}


	public static function getAllByDateOfficialGs($start, $end, $id_sucursal, $cliente, $tipo)
	{

		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and accion_id=2 and (tipo_venta=1  or tipo_venta=0 or tipo_venta=5) and cliente_id = $cliente and metodopago LIKE '$tipo' order by fecha desc";
		if ($start == $end) {
			$sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\" and accion_id=2 and (tipo_venta=1  or tipo_venta=0 or tipo_venta=5) and sucursal_id=$id_sucursal order by fecha desc";
		}
		if ($tipo == "todos") {
			$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and accion_id=2 and (tipo_venta=1  or tipo_venta=0 or tipo_venta=5) and cliente_id = $cliente  order by fecha desc";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}



	public static function getAllByDateOfficialGs2($start, $end, $id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and accion_id=1 and tipo_venta=0 order by fecha desc";
		if ($start == $end) {
			$sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\" and accion_id=1  and sucursal_id=$id_sucursal   and tipo_venta=0 order by fecha desc";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function getAllByDateOfficialGs3($start, $end, $id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and date(fecha) >= \"$start\" and date(fecha) <= \"$end\"  order by fecha desc";
		if ($start == $end) {
			$sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\"  and sucursal_id=$id_sucursal   and tipo_venta=0 order by fecha desc";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function getbysucursal($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function getAllByDateOfficialGs4($start, $end, $id_sucursal, $enviado)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and date(fecha) >= \"$start\" and date(fecha) <= \"$end\"   and enviado like \"$enviado\" order by fecha desc";
		if ($start == $end) {
			$sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\"  and sucursal_id=$id_sucursal   and tipo_venta=0 and enviado like \"$enviado\" order by fecha desc";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function getAllByDateOfficialGs5($start, $end, $id_sucursal, $tipo)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and tipo_venta=$tipo order by fecha desc";
		if ($start == $end) {
			$sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\"  and sucursal_id=$id_sucursal   and tipo_venta=0 order by fecha desc";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function getAllByDateOfficialGs6($start, $end, $id_sucursal, $enviado, $tipo)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and tipo_venta=$tipo and enviado like \"$enviado\" order by fecha desc";
		if ($start == $end) {
			$sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\"  and sucursal_id=$id_sucursal   and tipo_venta=0 and enviado like \"$enviado\" order by fecha desc";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function getAllPersonalizado($start, $end, $id_sucursal, $enviado, $tipo, $cliente, $vendedor)
	{
		$sql = "";
		if ($start == $end) {
			$sql = "select * from " . $tipo . " where sucursal_id=$id_sucursal and date(fecha) = \"$start\"  ";
			// 	$sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\"  and sucursal_id=$id_sucursal   and tipo_venta=0 and enviado like \"$enviado\" order by fecha desc";

		} else {
			$sql = "select * from " . $tipo . " where sucursal_id=$id_sucursal and date(fecha) >= \"$start\" and date(fecha) <= \"$end\"";
		}
		if ($enviado != "todos") {
			if ($enviado == "no enviado") {
				$sql = $sql . " and enviado is NULL ";
			} else {
				$sql = $sql . " and enviado Like '" . $enviado . "'";
			}
		}

		if ($tipo != "todos") {
			if ($tipo == "venta") {
				$sql = $sql . " and (tipo_venta= 0 or tipo_venta= 5 or tipo_venta=15)";
			}
		}

		if ($cliente != "todos") {
			$sql = $sql . " and cliente_id = " . $cliente;
		}

		if ($vendedor != "todos") {
			$sql = $sql . " and vendedor = " . $vendedor;
		}



		// " and tipo_venta=$tipo and enviado like \"$enviado\"";
		$sql = $sql . " order by fecha desc";
		if ($start == $end) {
			// 	$sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\"  and sucursal_id=$id_sucursal   and tipo_venta=0 and enviado like \"$enviado\" order by fecha desc";

		}
		// return $sql;
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}




	public static function getAllPersonalizado_import($start, $end, $id_sucursal, $enviado, $tipo, $cliente)
	{
		$sql = "";
		if ($start == $end) {
			$sql = "select * from " . $tipo .  " where sucursal_id=$id_sucursal and date(fecha) = \"$start\"  ";
			// 	$sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\"  and sucursal_id=$id_sucursal   and tipo_venta=0 and enviado like \"$enviado\" order by fecha desc";

		} else {
			$sql = "select * from " . $tipo . " where sucursal_id=$id_sucursal and date(fecha) >= \"$start\" and date(fecha) <= \"$end\"";
		}
		if ($enviado != "todos") {
			if ($enviado == "no enviado") {
				$sql = $sql . " and enviado is NULL ";
			} else {
				$sql = $sql . " and enviado Like '" . $enviado . "'";
			}
		}

		if ($tipo == "ventas") {
			$sql = $sql . " and (tipo_venta= 0 or tipo_venta= 5)";
		} else {
			$sql = $sql . " and tipo_venta= " . $tipo;
		}

		if ($cliente != "todos") {
			$sql = $sql . " and cliente_id = " . $cliente;
		}
		// " and tipo_venta=$tipo and enviado like \"$enviado\"";
		$sql = $sql . " order by fecha desc";
		if ($start == $end) {
			// 	$sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\"  and sucursal_id=$id_sucursal   and tipo_venta=0 and enviado like \"$enviado\" order by fecha desc";

		}


		// return $sql;
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}



	public function enviocorreo()
	{
		$sql = "update " . self::$tablename . " set email_enviado=1  where id_venta=$this->id";
		return Executor::doit($sql);
	}

	public static function buscarFactura($id_sucursal, $factura)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and numero_factura='$factura' and tipo_venta=15";


		$query = Executor::doit($sql);
		return Model::one($query[0], new VentaData());
	}
	public static function buscarVentas($id_sucursal, $offset, $busqueda, $desde, $hasta, $cliente)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and `factura` like \"%$busqueda%\"   and accion_id=2 and ( tipo_venta=0 or tipo_venta=5  ) and (estado =1 or estado=2) ";
		if ($desde == NULL || $hasta == NULL) {
		} else if ($desde == $hasta) {
			$sql .= " and date(fecha) = \"$desde\"  ";
		} else {
			$sql .= " and date(fecha) >= \"$desde\" and date(fecha) <= \"$hasta\" ";
		}
		if ($cliente != "todos") {
			$sql .= " and cliente_id = \"$cliente\"  ";
		}
		$sql .= "order by id_venta desc LIMIT 10 OFFSET $offset";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function buscarVentasPaginacion($id_sucursal, $offset, $busqueda, $desde, $hasta, $cliente)
	{
		$sql = "select COUNT(*) AS total_registros from " . self::$tablename . " where sucursal_id=$id_sucursal and `factura` like \"%$busqueda%\"   and accion_id=2 and ( tipo_venta=0 or tipo_venta=5  ) and (estado =1 or estado=2) ";
		if ($desde == NULL || $hasta == NULL) {
		} else if ($desde == $hasta) {
			$sql .= " and date(fecha) = \"$desde\"  ";
		} else {
			$sql .= " and date(fecha) >= \"$desde\" and date(fecha) <= \"$hasta\" ";
		}
		if ($cliente != "todos") {
			$sql .= " and cliente_id = \"$cliente\"  ";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function buscarRemisiones($id_sucursal, $offset, $busqueda, $desde, $hasta, $cliente)
	{
		$sql = "select * from remision where sucursal_id=$id_sucursal and `factura` like \"%$busqueda%\"   and accion_id=2 and ( tipo_venta=4) ";
		if ($desde == NULL || $hasta == NULL) {
		} else if ($desde == $hasta) {
			$sql .= " and date(fecha) = \"$desde\"  ";
		} else {
			$sql .= " and date(fecha) >= \"$desde\" and date(fecha) <= \"$hasta\" ";
		}
		if ($cliente != "todos") {
			$sql .= " and cliente_id = \"$cliente\"  ";
		}
		$sql .= "order by id_venta desc LIMIT 10 OFFSET $offset";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function buscarRemisionesPaginacion($id_sucursal, $offset, $busqueda, $desde, $hasta, $cliente)
	{
		$sql = "select COUNT(*) AS total_registros from remision where sucursal_id=$id_sucursal and `factura` like \"%$busqueda%\" and accion_id=2 and ( tipo_venta=4)";
		if ($desde == NULL || $hasta == NULL) {
		} else if ($desde == $hasta) {
			$sql .= " and date(fecha) = \"$desde\"  ";
		} else {
			$sql .= " and date(fecha) >= \"$desde\" and date(fecha) <= \"$hasta\" ";
		}
		if ($cliente != "todos") {
			$sql .= " and cliente_id = \"$cliente\"  ";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function buscarVentaRemisiones($id_sucursal, $offset, $busqueda, $desde, $hasta, $cliente)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and `factura` like \"%$busqueda%\"  and ( tipo_venta=5) and  ( estado =1 or  estado =0 or  estado =2) ";
		if ($desde == NULL || $hasta == NULL) {
		} else if ($desde == $hasta) {
			$sql .= " and date(fecha) = \"$desde\"  ";
		} else {
			$sql .= " and date(fecha) >= \"$desde\" and date(fecha) <= \"$hasta\" ";
		}
		if ($cliente != "todos") {
			$sql .= " and cliente_id = \"$cliente\"  ";
		}
		$sql .= "order by id_venta desc LIMIT 10 OFFSET $offset";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function buscarVentaRemisionesPaginacion($id_sucursal, $offset, $busqueda, $desde, $hasta, $cliente)
	{
		$sql = "select COUNT(*) AS total_registros from " . self::$tablename . " where sucursal_id=$id_sucursal and `factura` like \"%$busqueda%\" and ( tipo_venta=5) and  ( estado =1 or  estado =0 or  estado =2) ";
		if ($desde == NULL || $hasta == NULL) {
		} else if ($desde == $hasta) {
			$sql .= " and date(fecha) = \"$desde\"  ";
		} else {
			$sql .= " and date(fecha) >= \"$desde\" and date(fecha) <= \"$hasta\" ";
		}
		if ($cliente != "todos") {
			$sql .= " and cliente_id = \"$cliente\"  ";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}

	public static function buscarVentaExportacion($id_sucursal, $offset, $busqueda, $desde, $hasta, $cliente)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and `factura` like \"%$busqueda%\"  and ( tipo_venta=20 or tipo_venta=50) and  ( estado =1 or  estado =0 or  estado =2) ";
		if ($desde == NULL || $hasta == NULL) {
		} else if ($desde == $hasta) {
			$sql .= " and date(fecha) = \"$desde\"  ";
		} else {
			$sql .= " and date(fecha) >= \"$desde\" and date(fecha) <= \"$hasta\" ";
		}
		if ($cliente != "todos") {
			$sql .= " and cliente_id = \"$cliente\"  ";
		}
		$sql .= "order by id_venta desc LIMIT 10 OFFSET $offset";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function buscarVentaExportacionPaginacion($id_sucursal, $offset, $busqueda, $desde, $hasta, $cliente)
	{
		$sql = "select COUNT(*) AS total_registros from " . self::$tablename . " where sucursal_id=$id_sucursal and `factura` like \"%$busqueda%\" and ( tipo_venta=20 or tipo_venta=50) and  ( estado =1 or  estado =0 or  estado =2) ";
		if ($desde == NULL || $hasta == NULL) {
		} else if ($desde == $hasta) {
			$sql .= " and date(fecha) = \"$desde\"  ";
		} else {
			$sql .= " and date(fecha) >= \"$desde\" and date(fecha) <= \"$hasta\" ";
		}
		if ($cliente != "todos") {
			$sql .= " and cliente_id = \"$cliente\"  ";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function buscarNotaCredito($id_sucursal, $offset, $busqueda, $desde, $hasta, $cliente)
	{
		$sql = "select * from nota_credito_venta where sucursal_id=$id_sucursal and `factura` like \"%$busqueda%\"  and ( tipo_venta=15 ) and (estado =1 or estado=2) ";
		if ($desde == NULL || $hasta == NULL) {
		} else if ($desde == $hasta) {
			$sql .= " and date(fecha) = \"$desde\"  ";
		} else {
			$sql .= " and date(fecha) >= \"$desde\" and date(fecha) <= \"$hasta\" ";
		}
		if ($cliente != "todos") {
			$sql .= " and cliente_id = \"$cliente\"  ";
		}
		$sql .= "order by id_venta desc LIMIT 10 OFFSET $offset";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}
	public static function buscarNotaCreditoPaginacion($id_sucursal, $offset, $busqueda, $desde, $hasta, $cliente)
	{
		$sql = "select COUNT(*) AS total_registros from nota_credito_venta where sucursal_id=$id_sucursal and `factura` like \"%$busqueda%\"  and ( tipo_venta=15 ) and (estado =1 or estado=2) ";
		if ($desde == NULL || $hasta == NULL) {
		} else if ($desde == $hasta) {
			$sql .= " and date(fecha) = \"$desde\"  ";
		} else {
			$sql .= " and date(fecha) >= \"$desde\" and date(fecha) <= \"$hasta\" ";
		}
		if ($cliente != "todos") {
			$sql .= " and cliente_id = \"$cliente\"  ";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new VentaData());
	}

	public static function buscarFactura2($id_sucursal, $factura)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and numero_factura='$factura'";


		$query = Executor::doit($sql);
		return Model::one($query[0], new VentaData());
	}
}
