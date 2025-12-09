<?php
class MonedaData
{
	public static $tablename = "tipomoneda";






	public function registro()
	{
		$sql = "insert into " . self::$tablename . "(sucursal_id,nombre,valor,simbolo,descripcion,estado)";
		$sql .= "value ($this->sucursal_id,\"$this->nombre\",\"$this->valor\",\"$this->simbolo\",\"$this->descripcion\",1)";
		Executor::doit($sql);
	}

	public static function cboObtenerValorPorSucursal($sucursalId)
	{
		$sql = "select id_tipomoneda, simbolo, nombre from " . self::$tablename . " where sucursal_id = $sucursalId order by estado desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new MonedaData());
	}
	public static function vermonedaid($id)
	{
		$sql = "select * from " . self::$tablename . " where id_tipomoneda=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new MonedaData());
	}

	public static function cboObtenerValorPorSucursal2($sucursalId, $Idmoneda)
	{
		$sql = "select id_tipomoneda, simbolo, nombre, fecha_cotizacion from " . self::$tablename . " where sucursal_id = $sucursalId and id_tipomoneda = $Idmoneda order by estado desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new MonedaData());
	}


	public static function cboObtenerValorPorSucursal3($sucursalId)
	{
		$sql = "select id_tipomoneda, simbolo, nombre, valor, valor2, fecha_cotizacion from " . self::$tablename . " where sucursal_id = $sucursalId and `estado`=0  order by estado desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new MonedaData());
	}



	public static function obtenerCambioMonedaPorSimbolo($sucursalId, $simbolo)
	{
		$sql = "select valor, valor2, id_tipomoneda from " . self::$tablename . " where sucursal_id = $sucursalId and simbolo = '$simbolo'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new MonedaData());
	}


	public static function obtenerCambioMonedaPorSimbolo2($sucursalId, $simbolo)
	{
		$sql = "select valor, valor2, id_tipomoneda from " . self::$tablename . " where sucursal_id = $sucursalId and simbolo = '$simbolo'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new MonedaData());
	}



	public static function obtenerCambioMoneda($sucursalId)
	{
		$sql = "select valor, valor2, id_tipomoneda from " . self::$tablename . " where sucursal_id = $sucursalId ";
		$query = Executor::doit($sql);
		return Model::many($query[0], new MonedaData());
	}
	public function actualizar()
	{
		$sql = "update " . self::$tablename . " set nombre=\"$this->nombre\",valor=\"$this->valor\",simbolo=\"$this->simbolo\",descripcion=\"$this->descripcion\" where id_tipomoneda=$this->id_tipomoneda";
		Executor::doit($sql);
	}

	public static function vercontenido()
	{
		$sql = "select * from " . self::$tablename . " order by id_sucursal asc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new MonedaData());
	}
	public static function versucursalmoneda($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], new MonedaData());
	}
	public static function VerId($id_tipomoneda, $id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where id_tipomoneda=$id_tipomoneda and sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::one($query[0], new MonedaData());
	}

	public static function VerId_simbol($id_sucursal)
	{
		$sql = "SELECT valor FROM `tipomoneda` WHERE `estado`=0 and `sucursal_id` =$id_sucursal";
		$query = Executor::doit($sql);
		return Model::one($query[0], new MonedaData());
	}

	public function eliminar()
	{
		$sql = "delete from " . self::$tablename . " where id_tipomoneda=$this->id_tipomoneda";
		Executor::doit($sql);
	}
	public static function getSucursal($nombre)
	{
		$sql = "select * from " . self::$tablename . " where nombre=\"$nombre\"";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while ($r = $query[0]->fetch_array()) {
			$array[$cnt] = new MonedaData();
			$array[$cnt]->nombre = $r['nombre'];
			$cnt++;
		}
		return $array;
	}
}
