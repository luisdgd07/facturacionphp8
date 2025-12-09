<?php
class MarcaData {
	public static $tablename = "marca";



	public function MarcaData(){
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->image = "";
		$this->password = "";
		$this->fecha = "NOW()";
	}
	public static function vermarcasucursal($id_sucursal){
		$sql = "select * from ".self::$tablename." where sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0],new MarcaData());
		}

	public function nueva_categoria(){
		$sql = "insert into categoria (nombre,descripcion,fecha) ";
		$sql .= "value (\"$this->nombre\",\"$this->descripcion\",NOW())";
		return Executor::doit($sql);
	}
	public function nueva_categoria1(){
		$sql = "insert into categoria (sucursal_id,nombre,descripcion,fecha) ";
		$sql .= "value ($this->sucursal_id,\"$this->nombre\",\"$this->descripcion\",NOW())";
		return Executor::doit($sql);
	}
	public function registro(){
		$sql = "insert into marca (sucursal_id,nombre,descripcion,fecha) ";
		$sql .= "value ($this->sucursal_id,\"$this->nombre\",\"$this->descripcion\",NOW())";
		return Executor::doit($sql);
	}
	public function actualizar(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\",descripcion=\"$this->descripcion\" where id_marca=$this->id_marca";
		Executor::doit($sql);
	}
	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id_marca=$this->id_marca";
		Executor::doit($sql);
	}
	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new MarcaData());
	}
	public static function getById($id_marca){
		 $sql = "select * from ".self::$tablename." where id_marca=$id_marca";
		$query = Executor::doit($sql);
		return Model::one($query[0],new MarcaData());
	}
// partiendo de que ya tenemos creado un objecto BoxData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\" where id=$this->id";
		Executor::doit($sql);
	}
	public static function getCategoria($nombre, $id_sucursal){
		$sql = "select * from ".self::$tablename." where nombre=\"$nombre\" and sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new CategoriaData();
			$array[$cnt]->nombre = $r['nombre'];
			$cnt++;
		}
		return $array;
	}


}

?>