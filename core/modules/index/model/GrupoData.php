<?php
class GrupoData
{
	public static $tablename = "grupo";



	public function GrupoData()
	{
		$this->nombre = "";
		$this->grupo_ini = "";

		$this->fecha = "NOW()";
	}
	public static function vergrupossucursal($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], "GrupoData");
	}


	public function nuevo_grupo()
	{
		$sql = "insert into grupo (sucursal_id,nombre_grupo,grupo_ini,fecha) ";
		$sql .= "value ($this->sucursal_id,\"$this->nombre\",\"$this->grupo_ini\",NOW())";
		return Executor::doit($sql);
	}
	public function actualizar()
	{
		$sql = "update " . self::$tablename . " set nombre_grupo=\"$this->nombre\" where id_grupo=$this->id_grupo";
		Executor::doit($sql);
	}
	public static function delById($id)
	{
		$sql = "delete from " . self::$tablename . " where id=$id";
		Executor::doit($sql);
	}
	public function del()
	{
		$sql = "delete from " . self::$tablename . " where id_grupo=$this->id_grupo";
		Executor::doit($sql);
	}
	// public static function getAll(){
	// 	$sql = "select * from ".self::$tablename;
	// 	$query = Executor::doit($sql);
	// 	return Model::many($query[0],new GrupoData());
	// }
	public static function getById($id_grupo)
	{
		$sql = "select * from " . self::$tablename . " where id_grupo=$id_grupo";
		$query = Executor::doit($sql);
		return Model::one($query[0], "GrupoData");
	}
	// partiendo de que ya tenemos creado un objecto BoxData previamente utilizamos el contexto
	public function update()
	{
		$sql = "update " . self::$tablename . " set name=\"$this->name\" where id=$this->id";
		Executor::doit($sql);
	}
	public static function getgrupo($nombre_grupo, $id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where nombre_grupo=\"$nombre_grupo\" and sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while ($r = $query[0]->fetch_array()) {
			$array[$cnt] = new GrupoData();
			$array[$cnt]->nombre_grupo = $r['nombre_grupo'];
			$cnt++;
		}
		return $array;
	}

	public static function getAll($id_sucursal)
	{
		$sql = "SELECT * FROM " . self::$tablename . " WHERE sucursal_id = $id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], "GrupoData");
	}
}

?>