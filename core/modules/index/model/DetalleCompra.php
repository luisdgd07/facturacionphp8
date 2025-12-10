<?php
class DetalleCompra
{
	public static $tablename = "detallecompra";

	public function getCompras()
	{
		return ComprasData::getById($this->compras_id);
	}
	public function getCompra()
	{
		return CompraData::getById($this->compra_id);
	}

	public function si()
	{
		$sql = "insert into " . self::$tablename . " (compras_id,compra_id) ";
		$sql .= "value (\"$this->compras_id\",$this->compra_id)";
		return Executor::doit($sql);
	}
	public function uno()
	{
		$sql = "insert into " . self::$tablename . " (carpeta_id) ";
		$sql .= "value (\"$this->carpeta_id\")";
		return Executor::doit($sql);
	}

	public function dos()
	{
		$sql = "insert into " . self::$tablename . " (carpeta_id) ";
		$sql .= "value ($this->carpeta_id)";
		return Executor::doit($sql);
	}
	public function registro_peridocarpeta()
	{
		$sql = "insert into " . self::$tablename . " (periodo_id) ";
		$sql .= "value ($this->periodo_id)";
		return Executor::doit($sql);
	}
	public function add()
	{
		$sql = "insert into periodocarpeta (carpeta_id) ";
		$sql .= "value (\"$this->carpeta_id\")";
		Executor::doit($sql);
	}
	public static function delById($id)
	{
		$sql = "delete from " . self::$tablename . " where id=$id";
		Executor::doit($sql);
	}
	public function del()
	{
		$sql = "delete from " . self::$tablename . " where alumn_id=$this->alumn_id and team_id=$this->team_id";
		Executor::doit($sql);
	}

	// partiendo de que ya tenemos creado un objecto AlumnTeamData previamente utilizamos el contexto
	public function update()
	{
		$sql = "update " . self::$tablename . " set name=\"$this->name\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id_periodocarpeta)
	{
		$sql = "select * from " . self::$tablename . " where id_periodocarpeta=$id_periodocarpeta";
		$query = Executor::doit($sql);
		return Model::one($query[0], "DetalleCompra");
	}


	public static function getByAT($a, $t)
	{
		$sql = "select * from " . self::$tablename . " where alumn_id=$a and team_id=$t";
		$query = Executor::doit($sql);
		return Model::one($query[0], "DetalleCompra");
	}


	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], "DetalleCompra");

	}

	public static function getAllByTeamId($id_compra)
	{
		$sql = "select * from " . self::$tablename . " where compra_id=$id_compra";
		$query = Executor::doit($sql);
		return Model::many($query[0], "DetalleCompra");
	}

	public static function getAllByAlumnId($id)
	{
		$sql = "select * from " . self::$tablename . " where alumn_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0], "DetalleCompra");
	}

	public static function getLike($q)
	{
		$sql = "select * from " . self::$tablename . " where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], "DetalleCompra");
	}


}

?>