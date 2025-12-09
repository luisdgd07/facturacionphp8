<?php
class ComprasData {
	public static $tablename = "compras";



	public function Userdata(){
		$this->nombre = "";
		$this->apellido = "";
		$this->email = "";
		$this->imagen = "";
		$this->password = "";
		$this->fecha_registro = "NOW()";
	}

	public function getFullname(){ return $this->nombre." ".$this->apellido; }



// partiendo de que ya tenemos creado un objecto UserData previamente utilizamos el contexto
	public function registrar_compra(){
		$sql = "insert into ".self::$tablename." (imagen,codigofabricante,codigoimportador,codigo,nombre,serie,modelo,marca,estado,descripcion,presentacion,cantidad,total,precio_compra,usuario_id,activo,fecha) ";
		$sql .= "value (\"$this->imagen\",\"$this->codigofabricante\",\"$this->codigoimportador\",\"$this->codigo\",\"$this->nombre\",\"$this->serie\",\"$this->modelo\",\"$this->marca\",\"$this->estado\",\"$this->descripcion\",\"$this->presentacion\",\"$this->cantidad\",\"$this->total\",\"$this->precio_compra\",\"$this->usuario_id\",1,NOW())";
		return Executor::doit($sql);
	}
	public function actulizar_datos(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\",apellido=\"$this->apellido\",dni=\"$this->dni\",telefono=\"$this->telefono\",direccion=\"$this->direccion\",genero=\"$this->genero\" where id_usuario=$this->id_usuario";
		Executor::doit($sql);
	}
	public function actualizar(){
		$sql = "update ".self::$tablename." set usuario=\"$this->usuario\" where id_usuario=$this->id_usuario";
		Executor::doit($sql);
	}
	public function update_password(){
		$sql = "update ".self::$tablename." set password=\"$this->password\" where id_usuario=$this->id_usuario";
		Executor::doit($sql);
	}
	public function actualizar_imagen(){
		$sql = "update ".self::$tablename." set imagen=\"$this->imagen\" where id_usuario=$this->id_usuario";
		Executor::doit($sql);
	}
	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",email=\"$this->email\",username=\"$this->username\",lastname=\"$this->lastname\",is_active=\"$this->is_active\",is_admin=\"$this->is_admin\" where id=$this->id";
		Executor::doit($sql);
	}

	public function update_passwd(){
		$sql = "update ".self::$tablename." set password=\"$this->password\" where id=$this->id";
		Executor::doit($sql);
	}


	public static function getById($id_compras){
		$sql = "select * from ".self::$tablename." where id_compras=$id_compras";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ComprasData());
	}

	public static function getByEmail($id_usuario){
		$sql = "select * from ".self::$tablename." where email=\"$id_usuario\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ComprasData());
	}

	public static function getByNick($nick){
		$sql = "select * from ".self::$tablename." where email=\"$nick\" or username=\"$nick\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ComprasData());

	}
	public static function getNombre($nombre){
		$sql = "select * from ".self::$tablename." where nombre=\"$nombre\"";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ComprasData();
			$array[$cnt]->nombre = $r['nombre'];
			$cnt++;
		}
		return $array;
	}
	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new ComprasData());
	}
	public function eliminar(){
		$sql = "delete from ".self::$tablename." where id_usuario=$this->id_usuario";
		Executor::doit($sql);
	}
	public static function getLike($p){
		$sql = "select * from ".self::$tablename." where nombre like '%$p%' or codigo like '%$p%' or id_producto like '%$p%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ComprasData());
	}
	

}

?>