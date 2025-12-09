<?php
class CajaData {
	public static $tablename = "caja";

	public static function vercajasucursal($id_sucursal){
		$sql = "select * from ".self::$tablename." where sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CajaData());
		}
	public static function vercajaporusuario($id_usuario){
		$sql = "select * from ".self::$tablename." where usuario_id=$id_usuario";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CajaData());
		}
	public function CajaData(){
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->image = "";
		$this->password = "";
		$this->fecha = "NOW()";
	}
	public static function vercaja(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new CajaData());
	}
	public static function vercajapersonal($id_usuario){
		$sql = "select * from ".self::$tablename." where usuario_id=$id_usuario and accion=0";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CajaData());
	}
	public function cierre_caja_menuplato(){
		$sql = "insert into caja (fecha) ";
		$sql .= "value ($this->fecha)";
		return Executor::doit($sql);
	}
	public function cierre_caja_postre(){
		$sql = "insert into caja (fecha) ";
		$sql .= "value ($this->fecha)";
		return Executor::doit($sql);
	}
	public function cierre_caja_delivery(){
		$sql = "insert into caja (fecha) ";
		$sql .= "value ($this->fecha)";
		return Executor::doit($sql);
	}
	public function cierre_caja_producto(){
		$sql = "insert into caja (fecha) ";
		$sql .= "value ($this->fecha)";
		return Executor::doit($sql);
	}
	public function cierre_caja_producto1(){
		$sql = "insert into caja (sucursal_id,fecha) ";
		$sql .= "value (\"$this->sucursal_id\",$this->fecha)";
		return Executor::doit($sql);
	}
	public function aperturaporusuario(){
		$sql = "insert into caja (montoinicial,usuario_id,sucursal_id,fecha) ";
		$sql .= "value (\"$this->montoinicial\",\"$this->usuario_id\",\"$this->sucursal_id\",$this->fecha)";
		return Executor::doit($sql);
	}
	public function cierre_caja_producto1porusuario(){
		$sql = "insert into caja (sucursal_id,usuario_id,fecha) ";
		$sql .= "value (\"$this->sucursal_id\",\"$this->usuario_id\",$this->fecha)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

// partiendo de que ya tenemos creado un objecto BoxData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\" where id=$this->id";
		Executor::doit($sql);
	}


	public static function getById($id_caja){
		$sql = "select * from ".self::$tablename." where id_caja=$id_caja";
		$query = Executor::doit($sql);
		return Model::one($query[0],new CajaData());
	}



	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new CajaData();
			$array[$cnt]->id_caja = $r['id_caja'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new BoxData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}
	public function registrodecuierrecajaporusuario(){
		$sql = "update ".self::$tablename." set total=\"$this->total\",sucursal_id=\"$this->sucursal_id\",usuario_id=\"$this->usuario_id\",accion=\"$this->accion\" where id_caja=$this->id_caja";
		Executor::doit($sql);
	}


}

?>