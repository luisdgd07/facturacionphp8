<?php
class TipoProductoData
{
	public static $tablename = "tipo_producto";
	public ?int $ID_TIPO_PROD = 0;
	public ?string $TIPO_PRODUCTO = "";

	public function registrar()
	{
		$sql = "insert into " . self::$tablename . "(DEPOSITO_ID,PRODUCTO_ID, CANTIDAD_STOCK, MINIMO_STOCK, MAXIMO_STOCK,SUCURSAL_ID, COSTO_COMPRA)";
		$sql .= "value ($this->DEPOSITO_ID,$this->PRODUCTO_ID,$this->CANTIDAD_STOCK,$this->MINIMO_STOCK,$this->MAXIMO_STOCK,$this->SUCURSAL_ID,$this->COSTO_COMPRA)";
		Executor::doit($sql);
	}
	public function actualizar()
	{
		$sql = "update " . self::$tablename . " set nombre=\"$this->nombre\",filial=\"$this->filial\",descripcion=\"$this->descripcion\",encargado_id=\"$this->encargado_id\" where id_area=$this->id_area";
		Executor::doit($sql);
	}
	public static function vercontenido()
	{
		$sql = "select * from " . self::$tablename . " order by ID_TIPO_PROD asc";
		$query = Executor::doit($sql);
		return Model::many($query[0], "TipoProductoData");
	}

	public static function vercondicionessnombre($id_condicion)
	{
		$sql = "select * from " . self::$tablename . " where condicion_id=$id_condicion";
		$query = Executor::doit($sql);
		return Model::many($query[0], "TipoProductoData");
	}
	public static function verusucursalusuario($ID_TIPO_PROD)
	{
		$sql = "select * from " . self::$tablename . " where ID_TIPO_PROD=$ID_TIPO_PROD";
		$query = Executor::doit($sql);
		return Model::many($query[0], "TipoProductoData");
	}
	public static function VerId($ID_TIPO_PROD)
	{
		$sql = "select * from " . self::$tablename . " where ID_TIPO_PROD=$ID_TIPO_PROD";
		$query = Executor::doit($sql);
		return Model::one($query[0], "TipoProductoData");
	}
	public function eliminar()
	{
		$sql = "delete from " . self::$tablename . " where ID_TIPO_PROD=$this->ID_TIPO_PROD";
		Executor::doit($sql);
	}
	public static function getByName($TIPO_PRODUCTO)
	{
		$sql = "select * from " . self::$tablename . " where TIPO_PRODUCTO=\"$TIPO_PRODUCTO\"";
		$query = Executor::doit($sql);
		$found = null;
		$data = new TipoProductoData();
		while ($r = $query[0]->fetch_array()) {
			$data->ID_TIPO_PROD = $r['ID_TIPO_PROD'];
			$data->TIPO_PRODUCTO = $r['TIPO_PRODUCTO'];
			$found = $data;
			break;
		}
		return $found;
	}
}
