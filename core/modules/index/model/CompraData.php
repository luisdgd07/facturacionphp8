<?php
class CompraData
{
	public static $tablename = "compra";

	public function CompraData()
	{
		$this->nombre = "";
		$this->descripcion = "";
		$this->direccion = "";
		$this->email = "";
		$this->mensaje = "";
		$this->imagen = "";
		$this->fecha = "NOW()";
	}
	public function registrar_compra()
	{
		$sql = "insert into " . self::$tablename . " (nombre,descripcion,usuario_id,pendiente,fecha) ";
		$sql .= "value (\"$this->nombre\",\"$this->descripcion\",\"$this->usuario_id\",1,NOW())";
		Executor::doit($sql);
	}
	public function registrar_imagen()
	{
		$sql = "insert into " . self::$tablename . " (imagen) ";
		$sql .= "value (\"$this->imagen\")";
		Executor::doit($sql);
	}
	public function actuaizarpago()
	{
		$sql = "update " . self::$tablename . " set finalizado=\"$this->finalizado\" where id_compra=$this->id_compra";
		Executor::doit($sql);
	}
	public function Actualizar_gasto()
	{
		$sql = "update " . self::$tablename . " set total=\"$this->total\" where id_compra=$this->id_compra";
		Executor::doit($sql);
	}
	public function actualizar_cliente()
	{
		$sql = "update " . self::$tablename . " set nombre=\"$this->nombre\",apellido=\"$this->apellido\",telefono=\"$this->telefono\",direccion=\"$this->direccion\",email=\"$this->email\" where id_cliente=$this->id_cliente";
		Executor::doit($sql);
	}
	public function actualizar_imagen()
	{
		$sql = "update " . self::$tablename . " set imagen=\"$this->imagen\" where id_cliente=$this->id_cliente";
		Executor::doit($sql);
	}
	public function eliminar()
	{
		$sql = "delete from " . self::$tablename . " where id_cliente=$this->id_cliente";
		Executor::doit($sql);
	}
	public static function getById($id_compra)
	{
		$sql = "select * from " . self::$tablename . " where id_compra=$id_compra";
		$query = Executor::doit($sql);
		return Model::one($query[0], "CompraData");
	}
	public static function getAll()
	{
		$sql = "select * from " . self::$tablename . " order by id_compra asc";
		$query = Executor::doit($sql);
		return Model::many($query[0], "CompraData");
	}
	public static function VerDueño()
	{
		$sql = "select * from " . self::$tablename . " where is_activo=1 order by nombre asc";
		$query = Executor::doit($sql);
		return Model::many($query[0], "CompraData");
	}
	public static function IsCliente()
	{
		$sql = "select * from " . self::$tablename . " where is_cliente=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], "CompraData");
	}
	public static function IsPoveedor()
	{
		$sql = "select * from " . self::$tablename . " where is_proveedor=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], "CompraData");
	}
}

?>