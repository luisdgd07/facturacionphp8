<?php
class CotizacionData
{
	public static $tablename = "cotizacion";


	public function __construct(
		public ?int $id_cotizacion = null,
		public ?int $sucursal_id = null,
		public ?int $id_tipomoneda = null,
		public string $valor_compra = "",
		public string $valor_venta = "",
		public string $fecha_cotizacion = "",
		public string $estado = "",
		public ?string $fecha_creacion = null,
		public ?string $fecha_actualizacion = null,
		public ?string $usuario_creacion = null,
		public ?string $usuario_actualizacion = null,
		public ?int $usuario_id = null
	) {
	}

	public function registro()
	{
		$sql = "insert into " . self::$tablename . "(sucursal_id,id_tipomoneda,valor_compra,valor_venta,fecha_cotizacion)";
		$sql .= "value ($this->sucursal_id,\"$this->id_tipomoneda\",\"$this->valor_compra\",\"$this->valor_venta\",\"$this->fecha_cotizacion\")";
		Executor::doit($sql);
	}


	public function actualizar2()
	{
		$sql = "update tipomoneda set valor=\"$this->valor_compra\",valor2=\"$this->valor_venta\",fecha_cotizacion=\"$this->fecha_cotizacion\" where id_tipomoneda=$this->id_tipomoneda and  sucursal_id=$this->sucursal_id";
		Executor::doit($sql);
	}



	public static function cboObtenerValorPorSucursal($sucursalId)
	{
		$sql = "select simbolo, nombre from " . self::$tablename . " where sucursal_id = $sucursalId order by estado desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], "CotizacionData");
	}

	public static function obtenerCambioMonedaPorSimbolo($sucursalId, $simbolo)
	{
		$sql = "select valor, id_tipomoneda from " . self::$tablename . " where sucursal_id = $sucursalId and simbolo = '$simbolo'";
		$query = Executor::doit($sql);
		return Model::many($query[0], "CotizacionData");
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
		return Model::many($query[0], "CotizacionData");
	}
	public static function versucursalcotizacion($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], "CotizacionData");
	}
	public static function VerId($id_tipomoneda)
	{
		$sql = "select * from " . self::$tablename . " where id_tipomoneda=$id_tipomoneda";
		$query = Executor::doit($sql);
		return Model::one($query[0], "CotizacionData");
	}
	public function dell()
	{
		$sql = "delete from " . self::$tablename . " where id_cotizacion=$this->id_cotizacion";
		Executor::doit($sql);



	}

	public static function getById($id_marca)
	{
		$sql = "select * from " . self::$tablename . " where id_cotizacion =$id_marca";
		$query = Executor::doit($sql);
		return Model::one($query[0], "CotizacionData");
	}

	public static function getSucursal($nombre)
	{
		$sql = "select * from " . self::$tablename . " where nombre=\"$nombre\"";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while ($r = $query[0]->fetch_array()) {
			$array[$cnt] = new CotizacionData();
			$array[$cnt]->nombre = $r['nombre'];
			$cnt++;
		}
		return $array;
	}
}
?>