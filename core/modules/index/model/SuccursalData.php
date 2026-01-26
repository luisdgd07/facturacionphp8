<?php
class SuccursalData
{
	public static $tablename = "sucursal";
	public ?int $id_sucursal = null;
	public ?string $ruc = null;
	public ?string $descripcion = null;
	public ?string $representante = null;
	public ?string $telefono = null;
	public ?string $nombre = null;

	public ?string $direccion = null;
	public ?string $clave = null;
	public ?string $entorno = null;
	public ?string $email = null;
	public ?string $logo = null;

	public ?string $dpt_id = null;
	public ?string $distrito_id = null;
	public ?int $is_facturador = null;
	public ?string $venta_de = null;
	public ?string $timbrado = null;
	public ?int $id_envio = null;
	public ?int $is_envia_factura = null;

	public ?string $establecimiento = null;
	public ?string $fecha_firma = null;
	public ?string $razon_social = null;
	public ?string $nombre_fantasia = null;
	public ?string $codigo_act = null;
	public ?string $actividad = null;
	public ?string $fecha_tim = null;
	public ?string $numero_casa = null;
	public ?string $com_dir = null;
	public ?string $com_dir2 = null;
	public ?string $departamento_descripcion = null;
	public ?string $distrito_descripcion = null;
	public ?string $ciudad_descripcion = null;
	public ?string $ciudad = null;
	public ?string $razonsocial = null;

	public ?string $id_ciudad = null;
	public ?string $tipo_venta = null;
	public ?string $tipo_recibo = null;
	public ?string $cod_depart = null;
	public ?string $certificado_url = null;
	public ?string $denominacion = null;
	public ?string $host = null;
	public ?string $port = null;
	public ?string $pass = null;
	public ?string $qr_envio = null;


	public ?int $id_venta = null;

	public function __construct()
	{
	}
	public function registro()
	{
		$sql = "insert into " . self::$tablename . "(nombre,ruc, cod_depart, distrito_id, descripcion, representante, telefono,direccion, activo,fecha,is_envia_factura,ti_producto)";
		$sql .= "value (\"$this->nombre\",\"$this->ruc\",\"$this->dpt_id\",\"$this->distrito_id\",\"$this->descripcion\",\"$this->representante\",\"$this->telefono\",\"$this->direccion\",1,NOW(),\"$this->is_facturador\",\"$this->venta_de\")";
		Executor::doit($sql);
	}
	public function actualizar()
	{
		$sql = "update " . self::$tablename . " set nombre=\"$this->nombre\",ruc=\"$this->ruc\",distrito_id=\"$this->distrito_id\", cod_depart=\"$this->cod_depart\", clave=\"$this->clave\",entorno=\"$this->entorno\",descripcion=\"$this->descripcion\",representante=\"$this->representante\",telefono=\"$this->telefono\",direccion=\"$this->direccion\",is_envia_factura=$this->is_facturador,ti_producto=$this->venta_de, timbrado=$this->timbrado, establecimiento=$this->establecimiento,  fecha_firma='$this->fecha_firma', razon_social='$this->razon_social', nombre_fantasia='$this->nombre_fantasia', codigo_act='$this->codigo_act', actividad='$this->actividad', fecha_tim='$this->fecha_tim', numero_casa='$this->numero_casa', com_dir='$this->com_dir', com_dir2='$this->com_dir2', departamento_descripcion='$this->departamento_descripcion', distrito_descripcion='$this->distrito_descripcion', ciudad_descripcion='$this->ciudad_descripcion',id_ciudad='$this->id_ciudad' ,email='$this->email' where id_sucursal=$this->id_sucursal";
		return Executor::doit($sql);
	}


	public function actualizartipoventa()
	{
		$sql = "update " . self::$tablename . " set tipo_venta=\"$this->tipo_venta\" where id_venta=$this->id_venta";
		return Executor::doit($sql);
	}


	public static function vercontenido()
	{
		$sql = "select * from " . self::$tablename . " order by id_sucursal asc";
		$query = Executor::doit($sql);
		return Model::many($query[0], "SuccursalData");
	}
	public static function vercondicionessnombre($id_condicion)
	{
		$sql = "select * from " . self::$tablename . " where condicion_id=$id_condicion";
		$query = Executor::doit($sql);
		return Model::many($query[0], "SuccursalData");
	}

	public static function actualizarlogo($id, $logo)
	{
		$sql = "UPDATE `sucursal` SET `logo` = '$logo' WHERE `sucursal`.`id_sucursal` = $id;";

		return Executor::doit($sql);
	}
	public static function actualizarcert($id, $cert)
	{
		$sql = "UPDATE `sucursal` SET `certificado_url` = '$cert' WHERE `sucursal`.`id_sucursal` = $id;";

		return Executor::doit($sql);
	}
	public static function verusucursalusuario($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where id_sucursal=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], "SuccursalData");
	}
	public static function VerId($id_sucursal)
	{
		$sql = "select * from sucursal where id_sucursal= " . $id_sucursal;
		$query = Executor::doit($sql);
		return Model::one($query[0], "SuccursalData");
	}
	public function eliminar()
	{
		$sql = "delete from " . self::$tablename . " where id_sucursal=$this->id_sucursal";
		Executor::doit($sql);
	}
	public static function getSucursal($nombre)
	{
		$sql = "select * from " . self::$tablename . " where nombre=\"$nombre\"";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while ($r = $query[0]->fetch_array()) {
			$array[$cnt] = new SuccursalData();
			$array[$cnt]->nombre = $r['nombre'];
			$cnt++;
		}
		return $array;
	}
}
