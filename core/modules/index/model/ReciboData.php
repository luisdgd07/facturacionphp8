<?php
class ReciboData {
	public static $tablename = "recibo";
	public function registrar(){
		$sql = "insert into ".self::$tablename." (imagen) ";
		$sql .= "value (\"$this->imagen\")";
		return Executor::doit($sql);
	}
	public function con_cliente(){
		$sql = "insert into ".self::$tablename." (cliente_id,nombre,email,comentario,activo) ";
		$sql .= "value ($this->cliente_id,\"$this->nombre\",\"$this->email\",\"$this->comentario\",1)";
		return Executor::doit($sql);
	}
	public function actualizar(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\",nombre_corto=\"$this->nombre_corto\",is_active=\"$this->is_active\",in_home=\"$this->in_home\",in_menu=\"$this->in_menu\" where id_categoria=$this->id_categoria";
		Executor::doit($sql);
	}
	public function eliminar(){
		$sql = "delete from ".self::$tablename." where id_categoria=$this->id_categoria";
		Executor::doit($sql);
	}
	public static function getByPreffix($id_categoria){
		$sql = "select * from ".self::$tablename." where nombre_corto=\"$id_categoria\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ReciboData());
	}
	public static function getById($id_recibo){
		$sql = "select * from ".self::$tablename." where id_recibo=$id_recibo";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ReciboData());
	}
	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new ReciboData());
	}
	public static function team1(){
		$sql = "select * from ".self::$tablename." where tipo=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ReciboData());
	}
	public static function team2(){
		$sql = "select * from ".self::$tablename." where tipo=2";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ReciboData());
	}
	public static function team3(){
		$sql = "select * from ".self::$tablename." where tipo=3";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ReciboData());
	}
	public static function team4(){
		$sql = "select * from ".self::$tablename." where tipo=4";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ReciboData());
	}
	public static function team5(){
		$sql = "select * from ".self::$tablename." where tipo=5";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ReciboData());
	}
}

?>