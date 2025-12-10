<!-- ConfigData -->
<?php
class ConfigData
{
	public static $tablename = "empresa";
	public ?string $logo = null;
	public ?string $texto = "";
	public ?string $imagen = "";
	public ?string $nombre = "";

	public ?string $texto1 = "";

	public function ConfigData()
	{
		$this->nombre = "";
		$this->descripcion = "";
		$this->direccion = "";
		$this->gerente = "";
		$this->imagen = "";
		$this->texto1 = "";
		$this->carrucel1 = "";
	}
	public static function getById($id_empresa)
	{
		$sql = "select * from " . self::$tablename . " where id_empresa=$id_empresa";
		$query = Executor::doit($sql);
		return Model::one($query[0], "ConfigData");
	}
	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], "ConfigData");
	}
	public function actualizar()
	{
		$sql = "update " . self::$tablename . " set nombre=\"$this->nombre\",direccion=\"$this->direccion\",telefono=\"$this->telefono\",texto1=\"$this->texto1\",texto6=\"$this->texto6\",footer1=\"$this->footer1\" where id_empresa=$this->id_empresa";
		Executor::doit($sql);
	}

	public function actualizar_image()
	{
		$sql = "update " . self::$tablename . " set imagen=\"$this->imagen\" where id_empresa=$this->id_empresa";
		Executor::doit($sql);
	}
	public function actualizar_logo()
	{
		$sql = "update " . self::$tablename . " set logo=\"$this->logo\" where id_empresa=$this->id_empresa";
		Executor::doit($sql);
	}
	public function actualizar_personal()
	{
		$sql = "update " . self::$tablename . " set usuario_id=\"$this->usuario_id\" where id_empresa=$this->id_empresa";
		Executor::doit($sql);
	}
	public function actualizar_cliente()
	{
		$sql = "update " . self::$tablename . " set cliente_id=\"$this->cliente_id\" where id_configuracion=$this->id_configuracion";
		Executor::doit($sql);
	}
}

?>