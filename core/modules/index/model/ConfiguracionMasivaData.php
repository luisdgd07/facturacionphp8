<?php
class ConfiguracionMasivaData
{
	public static $tablename = "masiva";
	public ?int $cantidad = null;
	public ?string $estado = "";
	public function registro1()
	{
		$sql = "insert into " . self::$tablename . " (sucursal_id,cantidad,estado) ";
		$sql .= "value (\"$this->sucursal_id\",\"$this->cantidad\",1)";
		Executor::doit($sql);
	}
	public static function vercamasivasucursal($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ConfiguracionMasivaData");
	}
	public static function vercamasivaactivosucursal($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and estado=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ConfiguracionMasivaData");
	}
	public static function vercontenido()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], "ConfiguracionMasivaData");
	}
	public static function VerId($id_masiva)
	{
		$sql = "select * from " . self::$tablename . " where id_masiva=$id_masiva";
		$query = Executor::doit($sql);
		return Model::one($query[0], "ConfiguracionMasivaData");
	}

}

?>