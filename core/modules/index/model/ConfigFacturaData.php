<?php
class ConfigFacturaData
{
	public static $tablename = "configfactura";
	public ?string $comprobante1 = "";
	public ?string $diferencia = "";
	public ?string $serie1 = "";
	public ?int $id_configfactura = 0;
	public function registro1()
	{
		$sql = "insert into configfactura (sucursal_id,numeracion_inicial,numeracion_final,comprobante1,serie1,timbrado1,numeroactual1,inicio_timbrado,fin_timbrado,diferencia,activo,fecha) ";
		$sql .= "value ($this->sucursal_id,\"$this->numeracion_inicial\",\"$this->numeracion_final\",\"$this->comprobante1\",\"$this->serie1\",\"$this->timbrado1\",\"$this->numeroactual1\",\"$this->inicio_timbrado\",\"$this->fin_timbrado\",\"$this->diferencia\",1,NOW())";
		return Executor::doit($sql);
	}
	public static function obtenerdatosFactura($id_configfactura)
	{
		$sql = "select serie1,numeroactual1,numeracion_inicial,numeracion_final,id_configfactura,diferencia from " . self::$tablename . " where id_configfactura = $id_configfactura";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ConfigFacturaData");
	}
	public function actualizardiferencia()
	{
		$sql = "update " . self::$tablename . " set diferencia=\"$this->diferencia\" where id_configfactura=$this->id_configfactura";
		return Executor::doit($sql);
	}
	public function actualizar1()
	{
		$sql = "update " . self::$tablename . " set diferencia=\"$this->numeracion_final\"-\"$this->numeroactual1\", comprobante1=\"$this->comprobante1\",serie1=\"$this->serie1\",timbrado1=\"$this->timbrado1\",numeroactual1=\"$this->numeroactual1\",numeracion_inicial=\"$this->numeracion_inicial\",numeracion_final=\"$this->numeracion_final\",inicio_timbrado=\"$this->inicio_timbrado\",fin_timbrado=\"$this->fin_timbrado\" where id_configfactura=$this->id_configfactura";
		return Executor::doit($sql);
	}
	// public function registro1(){
	// 	$sql = "insert into configfactura (sucursal_id,numeracion_inicial,numeracion_final,fecha_inicio,fecha_fin,comprobante1,serie1,timbrado1,numeroactual1,inicio_timbrado,fin_timbrado,activo,fecha) ";
	// 	$sql .= "value ($this->sucursal_id,\"$this->numeracion_inicial\",\"$this->numeracion_final\",\"$this->fecha_inicio\",\"$this->fecha_fin\",\"$this->comprobante1\",\"$this->serie1\",\"$this->timbrado1\",\"$this->numeroactual1\",\"$this->inicio_timbrado\",\"$this->fin_timbrado\",1,NOW())";
	// 	return Executor::doit($sql);
	// }
	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], "ConfigFacturaData");
	}
	public static function verfacturasucursal($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where (sucursal_id=$id_sucursal and comprobante1 = 'Factura') or (sucursal_id=$id_sucursal and comprobante1 = 'Masiva') ";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ConfigFacturaData");
	}


	public static function verfacturasucursalall($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal  ";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ConfigFacturaData");
	}
	public static function verRecibo($idsucursal)
	{
		$sql = "SELECT * FROM `configfactura` WHERE `comprobante1` LIKE 'Recibo' AND sucursal_id = $idsucursal ORDER BY `configfactura`.`id_configfactura` DESC LIMIT 1;";
		$query = Executor::doit($sql);
		return Model::one($query[0], "ConfigFacturaData");
	}
	// 


	public static function verfacturasucursal10($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and comprobante1 = 'Nota de Credito'  ";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ConfigFacturaData");
	}




	public static function verfacturasucursal2($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and comprobante1 = 'Remision'  ";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ConfigFacturaData");
	}


	public static function verfacturasucursal3($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and comprobante1 = 'Recibo'  ";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ConfigFacturaData");
	}



	public static function VerId($id_configfactura)
	{
		$sql = "select * from " . self::$tablename . " where id_configfactura=$id_configfactura";
		$query = Executor::doit($sql);
		return Model::one($query[0], "ConfigFacturaData");
	}
	public function eliminar()
	{
		$sql = "delete from " . self::$tablename . " where id_configfactura=$this->id_configfactura";
		Executor::doit($sql);
	}
	// public function registro1(){
	// 	$sql = "insert into configfactura (sucursal_id,numeracion_inicial,numeracion_final,fecha_inicio,fecha_fin,comprobante1,serie1,timbrado1,inicio_timbrado,fin_timbrado,timbrado,serie,factura,fecha) ";
	// 	$sql .= "value ($this->sucursal_id,\"$this->numeracion_inicial\",\"$this->numeracion_final\",\"$this->fecha_inicio\",\"$this->fecha_fin\",\"$this->comprobante1\",\"$this->serie1\",\"$this->timbrado1\",\"$this->inicio_timbrado\",\"$this->fin_timbrado\",\"$this->timbrado\",\"$this->serie\",\"$this->factura\",NOW())";
	// 	return Executor::doit($sql);
	// }

}
?>