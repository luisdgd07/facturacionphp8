<!-- ProveedorData -->
<?php
class ProveedorData
{
	public static $tablename = "cliente";

	public function ProveedorData()
	{
		$this->nombre = "";
		$this->descripcion = "";
		$this->direccion = "";
		$this->email = "";
		$this->mensaje = "";
		$this->imagen = "";
		$this->fecha = "NOW()";
	}



	public static function verproveedorssucursal($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and is_proveedor=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ProveedorData");
	}





	public function registrar_proveedor()
	{
		$sql = "insert into " . self::$tablename . " (sucursal_id,imagen,empresa,nombre,apellido,tipo_doc,dni,ciudad,direccion,email,telefono,celular,is_activo,is_proveedor,fecha) ";
		$sql .= "value ($this->sucursal_id,\"$this->imagen\",\"$this->empresa\",\"$this->nombre\",\"$this->apellido\",\"$this->tipo_doc\",\"$this->dni\",\"$this->ciudad\",\"$this->direccion\",\"$this->email\",\"$this->telefono\",\"$this->celular\",1,1,NOW())";
		Executor::doit($sql);
	}
	public function registrar_proveedor_sin_negocio()
	{
		$sql = "insert into " . self::$tablename . " (nombre,apellido,dni,direccion,imagen,email,telefono,is_activo,is_proveedor,fecha) ";
		$sql .= "value (\"$this->nombre\",\"$this->apellido\",\"$this->dni\",\"$this->direccion\",\"$this->imagen\",\"$this->email\",\"$this->telefono\",1,1,NOW())";
		Executor::doit($sql);
	}
	public function registrar_proveedor_con_negocio()
	{
		$sql = "insert into " . self::$tablename . " (nombre,apellido,dni,direccion,imagen,email,telefono,is_activo,is_proveedor,fecha) ";
		$sql .= "value (\"$this->nombre\",\"$this->apellido\",\"$this->dni\",\"$this->direccion\",\"$this->imagen\",\"$this->email\",\"$this->telefono\",1,1,NOW())";
		Executor::doit($sql);
	}
	public function actualizar_proveedor()
	{
		$sql = "update " . self::$tablename . " set empresa=\"$this->empresa\",nombre=\"$this->nombre\",nif=\"$this->nif\",apellido=\"$this->apellido\",telefono=\"$this->telefono\",celular=\"$this->celular\",direccion=\"$this->direccion\",ciudad=\"$this->ciudad\",tipo_doc=\"$this->tipo_doc\",email=\"$this->email\",is_publico=\"$this->is_publico\",is_activo=\"$this->is_activo\",is_cliente=\"$this->is_cliente\",is_proveedor=\"$this->is_proveedor\" where id_cliente=$this->id_cliente";
		Executor::doit($sql);
	}
	public function actualizar_imagen()
	{
		$sql = "update " . self::$tablename . " set imagen=\"$this->imagen\" where id_cliente=$this->id_cliente";
		Executor::doit($sql);
	}
	// public static function getDni($dni){
	// 	$sql = "select * from ".self::$tablename." where dni=$dni";
	// 	$query = Executor::doit($sql);
	// 	return Model::one($query[0],new ClienteData());
	// }
	public function eliminar()
	{
		$sql = "delete from " . self::$tablename . " where id_cliente=$this->id_cliente";
		Executor::doit($sql);
	}
	public static function getBDni($dni, $id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where dni=\"$dni\"  and  sucursal_id=\"$id_sucursal\" AND is_proveedor=1 ";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while ($r = $query[0]->fetch_array()) {
			$array[$cnt] = new ProveedorData();
			$array[$cnt]->dni = $r['dni'];
			$cnt++;
		}
		return $array;
	}
	public static function getById($id_cliente)
	{
		$sql = "select * from " . self::$tablename . " where id_cliente=$id_cliente";
		$query = Executor::doit($sql);
		return Model::one($query[0], "ProveedorData");
	}
	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], "ProveedorData");
	}
	public static function VerDueño()
	{
		$sql = "select * from " . self::$tablename . " where is_activo=1 order by nombre asc";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ProveedorData");
	}
	public static function IsCliente()
	{
		$sql = "select * from " . self::$tablename . " where is_cliente=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ProveedorData");
	}
	public static function IsPoveedor()
	{
		$sql = "select * from " . self::$tablename . " where is_proveedor=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ProveedorData");
	}
}

?>