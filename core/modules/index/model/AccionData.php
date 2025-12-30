<?php
class AccionData
{
	public static $tablename = "accion";
	public ?int $id_accion = 0;
	public ?string $nombre = "";

	public static function VerAccion()
	{
		$sql = "select * from " . self::$tablename . " order by nombre asc";
		$query = Executor::doit($sql);
		return Model::many($query[0], "AccionData");
	}
	public static function Veringreso()
	{
		$sql = "select * from " . self::$tablename . " where id_accion=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], "AccionData");
	}
	public static function Versalida()
	{
		$sql = "select * from " . self::$tablename . " where id_accion=2";
		$query = Executor::doit($sql);
		return Model::many($query[0], "AccionData");
	}
	public static function getByIdd($id_accion)
	{
		$sql = "select * from " . self::$tablename . " where id_accion=$id_accion";
		$query = Executor::doit($sql);
		return Model::one($query[0], "AccionData");
	}
	public static function getById($id_accion)
	{
		$sql = "select * from " . self::$tablename . " where id_accion=$id_accion";
		$query = Executor::doit($sql);
		$found = null;
		$data = new AccionData();
		while ($r = $query[0]->fetch_array()) {
			$data->id_accion = $r['id_accion'];
			$data->nombre = $r['nombre'];
			$found = $data;
			break;
		}
		return $found;
	}
	public static function getByName($nombre)
	{
		$sql = "select * from " . self::$tablename . " where nombre=\"$nombre\"";
		$query = Executor::doit($sql);
		$found = null;
		$data = new AccionData();
		while ($r = $query[0]->fetch_array()) {
			$data->id_accion = $r['id_accion'];
			$data->nombre = $r['nombre'];
			$found = $data;
			break;
		}
		return $found;
	}
}

?>