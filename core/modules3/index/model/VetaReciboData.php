<?php
class VetaReciboData {
	public static $tablename = "ventarecibo";

	public function getRecibo(){ return ReciboData::getById($this->recibo_id); }
	public function getVenta(){ return VentaData::getById($this->venta_id); }
	// public function getClient(){ return ClienteData::getById($this->cliente_id);}
	public function si(){
		$sql = "insert into ".self::$tablename." (recibo_id,venta_id) ";
		$sql .= "value (\"$this->recibo_id\",$this->venta_id)";
		return Executor::doit($sql);
	}

	public function registro_peridocarpeta(){
		$sql = "insert into ".self::$tablename." (periodo_id) ";
		$sql .= "value ($this->periodo_id)";
		return Executor::doit($sql);
	}
	public function add(){
		$sql = "insert into periodocarpeta (carpeta_id) ";
		$sql .= "value (\"$this->carpeta_id\")";
		Executor::doit($sql);
	}
	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where archivo_id=$this->archivo_id and carpeta_id=$this->carpeta_id";
		Executor::doit($sql);
	}

// partiendo de que ya tenemos creado un objecto AlumnTeamData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id_ventarecibo){
		$sql = "select * from ".self::$tablename." where id_ventarecibo=$id_ventarecibo";
		$query = Executor::doit($sql);
		return Model::one($query[0],new VetaReciboData());
	}


	public static function getByAT($a,$t){
		$sql = "select * from ".self::$tablename." where alumn_id=$a and team_id=$t";
		$query = Executor::doit($sql);
		return Model::one($query[0],new VetaReciboData());
	}


	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new VetaReciboData());

	}

		public static function getAllByTeamId($id_venta){
		$sql = "select * from ".self::$tablename." where venta_id=$id_venta";
		$query = Executor::doit($sql);
		return Model::many($query[0],new VetaReciboData());
	}

		public static function getAllByAlumnId($producto_id){
		$sql = "select * from ".self::$tablename." where producto_id=$producto_id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new VetaReciboData());
	}
	
	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new VetaReciboData());
	}


}

?>