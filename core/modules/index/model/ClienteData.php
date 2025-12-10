<?php
class ClienteData
{
	public static $tablename = "cliente";

	public ?string $imagen = "";
	public ?string $nombre = "";
	public ?string $apellido = "";

	public ?string $direccion = "";
	public ?string $celular = "";
	public ?string $ciudad = "";

	public ?string $dni = "";
	public ?string $tipo_doc = "";
	public ?string $email = "";
	public ?string $telefono = "";
	public ?int $id_cliente = 0;

	public ?int $departamento_id = 0;

	public ?int $distrito_id = 0;

	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], "ClienteData");
	}

	public static function verclientessucursal($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and is_cliente=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ClienteData");
	}

	public static function contarClientesPorSucursal($id_sucursal)
	{
		$id_sucursal = intval($id_sucursal);
		$sql = "select count(*) as total from " . self::$tablename . " where sucursal_id=$id_sucursal and is_cliente=1";
		$query = Executor::doit($sql);
		$data = $query[0]->fetch_assoc();
		return intval($data["total"]);
	}

	public static function verClientesSucursalPaginado($id_sucursal, $limit, $offset)
	{
		$id_sucursal = intval($id_sucursal);
		$limit = intval($limit);
		$offset = intval($offset);
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and is_cliente=1 order by id_cliente desc limit $limit offset $offset";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ClienteData");
	}

	public static function contarClientesPorSucursalBuscado($id_sucursal, $q)
	{
		$id_sucursal = intval($id_sucursal);
		$q = trim($q);
		$sql = "select count(*) as total from " . self::$tablename . " where sucursal_id=$id_sucursal and is_cliente=1 and (nombre like '%$q%' or apellido like '%$q%' or dni like '%$q%' or email like '%$q%')";
		$query = Executor::doit($sql);
		$data = $query[0]->fetch_assoc();
		return intval($data["total"]);
	}

	public static function verClientesSucursalPaginadoBuscado($id_sucursal, $q, $limit, $offset)
	{
		$id_sucursal = intval($id_sucursal);
		$limit = intval($limit);
		$offset = intval($offset);
		$q = trim($q);
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and is_cliente=1 and (nombre like '%$q%' or apellido like '%$q%' or dni like '%$q%' or email like '%$q%') order by id_cliente desc limit $limit offset $offset";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ClienteData");
	}


	public static function verclientessucursalB2G($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and is_cliente=1 and tipo_operacion=3";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ClienteData");
	}

	public function registrar_cliente()
	{
		$sql = "insert into " . self::$tablename . " (sucursal_id,nombre,apellido,tipo_doc,dni,ciudad,telefono,celular,direccion,imagen,email,is_activo,is_cliente,fecha,id_precio, distrito_id, departamento_id, pais_id, dias_credito, tipo_operacion) ";
		$sql .= "value ($this->sucursal_id,\"$this->nombre\",\"$this->apellido\",\"$this->tipo_doc\",\"$this->dni\",\"$this->ciudad\",\"$this->telefono\",\"$this->celular\",\"$this->direccion\",\"$this->imagen\",\"$this->email\",1,1,NOW(),\"$this->id_precio\",\"$this->distrito\",\"$this->dpt_id\",\"$this->pais_id\",\"$this->dias_credito\",\"$this->tipo_operacion\")";
		Executor::doit($sql);
	}
	public function registrar_imagen()
	{
		$sql = "insert into " . self::$tablename . " (imagen) ";
		$sql .= "value (\"$this->imagen\")";
		Executor::doit($sql);
	}

	public function actualizar_cliente()
	{
		$sql = "update " . self::$tablename . " set nombre=\"$this->nombre\",apellido=\"$this->apellido\",telefono=\"$this->telefono\",celular=\"$this->celular\",tipo_doc=\"$this->tipo_doc\",dni=\"$this->dni\",direccion=\"$this->direccion\",ciudad=\"$this->ciudad\",email=\"$this->email\",is_publico=\"$this->is_publico\",is_activo=\"$this->is_activo\",is_proveedor=\"$this->is_proveedor\" ,id_precio=\"$this->id_precio\",pais_id=\"$this->pais_id\" ,distrito_id=\"$this->distrito\" ,departamento_id=\"$this->departa\", dias_credito=\"$this->dias_credito\" , tipo_operacion=\"$this->tipo_operacion\"  where id_cliente=$this->id_cliente";
		Executor::doit($sql);
		return $sql;
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
		return Model::one($query[0], "ClienteData");
	}
	public static function VerDueño()
	{
		$sql = "select * from " . self::$tablename . " where is_activo=1 order by fecha desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ClienteData");
	}
	public static function IsCliente()
	{
		$sql = "select * from " . self::$tablename . " where is_cliente=1  ";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ClienteData");
	}
	public static function IsPoveedor()
	{
		$sql = "select * from " . self::$tablename . " where is_proveedor=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], "ClienteData");
	}
}
