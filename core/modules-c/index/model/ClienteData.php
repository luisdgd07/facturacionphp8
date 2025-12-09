<?php
class ClienteData
{
	public static $tablename = "cliente";

	public function ClienteData()
	{
		$this->nombre = "";
		$this->sucursal_id = "";
		$this->descripcion = "";
		$this->direccion = "";
		$this->email = "";
		$this->mensaje = "";
		$this->imagen = "";
		$this->fecha = "NOW()";
	}

	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new ClienteData());
	}

	public static function verclientessucursal($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and is_cliente=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ClienteData());
	}


	public function registrar_cliente()
	{
		$sql = "insert into " . self::$tablename . " (sucursal_id,nombre,apellido,tipo_doc,dni,ciudad,telefono,celular,direccion,imagen,email,is_activo,is_cliente,fecha,id_precio, distrito_id, departamento_id) ";
		$sql .= "value ($this->sucursal_id,\"$this->nombre\",\"$this->apellido\",\"$this->tipo_doc\",\"$this->dni\",\"$this->ciudad\",\"$this->telefono\",\"$this->celular\",\"$this->direccion\",\"$this->imagen\",\"$this->email\",1,1,NOW(),\"$this->id_precio\",\"$this->distrito\",\"$this->dpt_id\")";
		Executor::doit($sql);
	}
	public function registrar_imagen()
	{
		$sql = "insert into " . self::$tablename . " (imagen) ";
		$sql .= "value (\"$this->imagen\")";
		Executor::doit($sql);
	}
	// public function actualizar_cliente(){
	// 	$sql = "update ".self::$tablename." set nombre=\"$this->nombre\",apellido=\"$this->apellido\",telefono=\"$this->telefono\",celular=\"$this->celular\",direccion=\"$this->direccion\",ciudad=\"$this->ciudad\",email=\"$this->email\",is_publico=\"$this->is_publico\",is_admin=\"$this->is_admin\",is_activo=\"$this->is_activo\",is_proveedor=\"$this->is_proveedor\" where id_cliente=$this->id_cliente";
	// 	Executor::doit($sql);
	// }
	public function actualizar_cliente()
	{
		$sql = "update " . self::$tablename . " set nombre=\"$this->nombre\",apellido=\"$this->apellido\",telefono=\"$this->telefono\",celular=\"$this->celular\",tipo_doc=\"$this->tipo_doc\",dni=\"$this->dni\",direccion=\"$this->direccion\",ciudad=\"$this->ciudad\",email=\"$this->email\",is_publico=\"$this->is_publico\",is_activo=\"$this->is_activo\",is_proveedor=\"$this->is_proveedor\" ,id_precio=\"$this->id_precio\" 
		,distrito_id=\"$this->distrito\" ,departamento_id=\"$this->departa\"  where id_cliente=$this->id_cliente";
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
	// public static function getDni($dni){
	// 	$sql = "select * from ".self::$tablename." where dni=$dni";
	// 	$query = Executor::doit($sql);
	// 	return Model::one($query[0],new ClienteData());
	// }
	public static function getBDni($dni, $id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where dni=\"$dni\" and  sucursal_id=\"$id_sucursal\" AND is_cliente=1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while ($r = $query[0]->fetch_array()) {
			$array[$cnt] = new ClienteData();
			$array[$cnt]->dni = $r['dni'];
			$cnt++;
		}
		return $array;
	}
	public static function getById($id_cliente)
	{
		$sql = "select * from " . self::$tablename . " where id_cliente=$id_cliente";
		$query = Executor::doit($sql);
		return Model::one($query[0], new ClienteData());
	}
	public static function VerDueño()
	{
		$sql = "select * from " . self::$tablename . " where is_activo=1 order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ClienteData());
	}
	public static function IsCliente()
	{
		$sql = "select * from " . self::$tablename . " where is_cliente=1  ";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ClienteData());
	}
	public static function IsPoveedor()
	{
		$sql = "select * from " . self::$tablename . " where is_proveedor=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ClienteData());
	}
}
