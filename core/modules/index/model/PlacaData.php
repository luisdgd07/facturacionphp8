<?php
class PlacaData
{
	public static $tablename = "placas";
	public function registro_placa()
	{

		$sql = "insert into " . self::$tablename . "(`id_placa`, `nro_ini`, `nro_fin`, `fecha_remi`, `id_venta`, `cantidad_total`, `id_sucursal`, `serie_placa`) VALUES (NULL, \"$this->nini\", \"$this->nfin\", NOW(), \"$this->venta\", \"$this->cantidad\", \"$this->sucursal\", \"$this->serie_placa\");";
		return Executor::doit($sql);
	}
	public static function listar2($sucursal)
	{
		$sql = "select * from detalle_placa where id_sucursal =" . $sucursal;
		$query = Executor::doit($sql);
		return Model::many($query[0], "PlacaData");
	}
	public static function listar3($sucursal)
	{
		$sql = "select * from `placas` where id_sucursal =" . $sucursal;
		$query = Executor::doit($sql);
		return Model::many($query[0], "PlacaData");
	}
	public static function listar($sucursal)
	{
		$sql = "select * from placas_fabrica where id_sucursal =" . $sucursal;
		$query = Executor::doit($sql);
		return Model::many($query[0], "PlacaData");
	}

	public static function obtener($placa)
	{
		$sql = "select * from detalle_placa where id_venta =" . $placa;
		$query = Executor::doit($sql);
		return Model::many($query[0], "PlacaData");
	}
	public static function VerId($id_placa)
	{
		$sql = "select * from placas_fabrica where id_placa=$id_placa";
		$query = Executor::doit($sql);
		return Model::one($query[0], new ConfigFacturaData());
	}



	public function actualizar1()
	{
		$sql = "update placas_fabrica set placa_inicio=\"$this->placa_inicio\", placa_fin=\"$this->placa_fin\",total_placas=\"$this->total_placas\",diferencia=\"$this->diferencia\",registro=\"$this->registro\",estado_placa=\"$this->estado_placa\"where id_placa=$this->id_placa";
		return Executor::doit($sql);
	}


	public function registro1()
	{
		$sql = "insert into placas_fabrica (id_sucursal,placa_inicio,placa_fin,total_placas,diferencia,registro,estado_placa,fecha) ";
		$sql .= "value ($this->sucursal_id,\"$this->placa_inicio\",\"$this->placa_fin\",\"$this->total_placas\",\"$this->diferencia\",\"$this->registro\",\"$this->estado_placa\",NOW())";
		return Executor::doit($sql);
	}

	public function eliminar($id)
	{
		$sql = "DELETE FROM `detalle_placa` WHERE `id_venta` = $id";
		return Executor::doit($sql);
	}
	public static function eliminar2($id)
	{
		$sql = "DELETE FROM `detalle_placa` WHERE `id_venta` = $id";
		return Executor::doit($sql);
	}

	public static function listar_placas($sucursal)
	{
		$sql = "select * from placas_fabrica where id_sucursal =" . $sucursal;
		$query = Executor::doit($sql);
		return Model::many($query[0], "PlacaData");
	}
}
