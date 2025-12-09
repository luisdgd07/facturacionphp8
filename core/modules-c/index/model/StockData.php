<?php
class StockData
{
	public static $tablename = "stock";

	public function registrar()
	{
		$sql = "insert into " . self::$tablename . "(DEPOSITO_ID,PRODUCTO_ID, CANTIDAD_STOCK, MINIMO_STOCK, MAXIMO_STOCK,SUCURSAL_ID, COSTO_COMPRA)";
		$sql .= "value ($this->DEPOSITO_ID,$this->PRODUCTO_ID,$this->CANTIDAD_STOCK,$this->MINIMO_STOCK,$this->MAXIMO_STOCK,$this->SUCURSAL_ID,$this->COSTO_COMPRA)";
		Executor::doit($sql);
		// return $sql;
	}
	public function actualizar()
	{
		$sql = "update " . self::$tablename . " set CANTIDAD_STOCK=\"$this->CANTIDAD_STOCK\" where PRODUCTO_ID=$this->PRODUCTO_ID AND DEPOSITO_ID=\"$this->DEPOSITO_ID\"";
		return Executor::doit($sql);
	}



	public function actualizar2()
	{
		$sql = "update " . self::$tablename . " set CANTIDAD_STOCK=\"$this->CANTIDAD_STOCK\" where PRODUCTO_ID=$this->PRODUCTO_ID AND DEPOSITO_ID=$this->DEPOSITO_ID";
		return Executor::doit($sql);
		// return $sql;
	}





	public function actualizarprecio()
	{
		$sql = "update " . self::$tablename . " set COSTO_COMPRA=\"$this->COSTO_COMPRA\", MINIMO_STOCK=\"$this->MINIMO_STOCK\" where PRODUCTO_ID=$this->PRODUCTO_ID and DEPOSITO_ID=$this->DEPOSITO_ID";
		return Executor::doit($sql);
	}




	public static function vercontenido()
	{
		$sql = "select * from " . self::$tablename . " order by id_sucursal asc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new StockData());
	}
	public static function vercontenidos3($PRODUCTO_ID, $deposito)
	{
		$sql = "select * from " . self::$tablename . " where PRODUCTO_ID=$PRODUCTO_ID AND DEPOSITO_ID = $deposito ";
		$query = Executor::doit($sql);
		return Model::one($query[0], new StockData());
	}
	public static function vercontenidos2($PRODUCTO_ID)
	{
		$sql = "select * from " . self::$tablename . " where PRODUCTO_ID=$PRODUCTO_ID";
		$query = Executor::doit($sql);
		return Model::one($query[0], new StockData());
	}
	public static function vercontenidos4($PRODUCTO_ID)
	{
		$sql = "select * from " . self::$tablename . " where PRODUCTO_ID=$PRODUCTO_ID";
		$query = Executor::doit($sql);
		return Model::one($query[0], new StockData());
	}
	public static function vercontenidos($PRODUCTO_ID)
	{
		$sql = "select * from " . self::$tablename . " where PRODUCTO_ID=$PRODUCTO_ID";
		$query = Executor::doit($sql);
		return Model::many($query[0], new StockData());
	}
	public static function verdeposito($deposito)
	{
		$sql = "select * from deposito where DEPOSITO_ID=$deposito";
		$query = Executor::doit($sql);
		return Model::many($query[0], new StockData());
	}


	public static function vercondicionessnombre($id_condicion)
	{
		$sql = "select * from " . self::$tablename . " where condicion_id=$id_condicion";
		$query = Executor::doit($sql);
		return Model::many($query[0], new StockData());
	}
	public static function verusucursalusuario($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where id_sucursal=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], new StockData());
	}
	public static function VerId($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where id_sucursal=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::one($query[0], new StockData());
	}
	public function eliminar()
	{
		$sql = "delete from " . self::$tablename . " where id_sucursal=$this->id_sucursal";
		Executor::doit($sql);
	}
	public static function getSucursal($nombre)
	{
		$sql = "select * from " . self::$tablename . " where nombre=\"$nombre\"";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while ($r = $query[0]->fetch_array()) {
			$array[$cnt] = new StockData();
			$array[$cnt]->nombre = $r['nombre'];
			$cnt++;
		}
		return $array;
	}
}
