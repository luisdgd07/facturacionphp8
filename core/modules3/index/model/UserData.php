<?php
class UserData {
	public static $tablename = "usuario";



	public function Userdata(){
		$this->nombre = "";
		$this->apellido = "";
		$this->email = "";
		$this->imagen = "";
		$this->password = "";
		$this->fecha_registro = "NOW()";
	}

	public function getFullname(){ return $this->nombre." ".$this->apellido; }
	public  function verSocursal(){ return SuccursalData::VerId($this->sucursal_id);}


// partiendo de que ya tenemos creado un objecto UserData previamente utilizamos el contexto
	public function registrar_nuevo_administrador(){
		$sql = "insert into ".self::$tablename." (nombre,apellido,dni,direccion,imagen,email,telefono,usuario,password,is_activo,is_admin,fecha) ";
		$sql .= "value (\"$this->nombre\",\"$this->apellido\",\"$this->dni\",\"$this->direccion\",\"$this->imagen\",\"$this->email\",\"$this->telefono\",\"$this->usuario\",\"$this->password\",1,1,NOW())";
		Executor::doit($sql);
	}
	public function registrar_nuevo_trabajador(){
		$sql = "insert into ".self::$tablename." (nombre,apellido,dni,direccion,imagen,email,telefono,usuario,password,is_activo,is_empleado,fecha) ";
		$sql .= "value (\"$this->nombre\",\"$this->apellido\",\"$this->dni\",\"$this->direccion\",\"$this->imagen\",\"$this->email\",\"$this->telefono\",\"$this->usuario\",\"$this->password\",1,1,NOW())";
		Executor::doit($sql);
	}
	public function actualizar_administrador(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\",apellido=\"$this->apellido\",telefono=\"$this->telefono\",dni=\"$this->dni\",direccion=\"$this->direccion\",email=\"$this->email\",is_publico=\"$this->is_publico\",is_admin=\"$this->is_admin\",is_activo=\"$this->is_activo\",is_mozo=\"$this->is_mozo\",is_empleado=\"$this->is_empleado\",is_cheff=\"$this->is_cheff\",is_ayudante=\"$this->is_ayudante\",is_cocinero=\"$this->is_cocinero\",is_panadero=\"$this->is_panadero\",is_confitero=\"$this->is_confitero\",is_barman=\"$this->is_barman\",is_personal_limpieza=\"$this->is_personal_limpieza\",is_empleado=\"$this->is_empleado\",is_cajero=\"$this->is_cajero\" where id_usuario=$this->id_usuario";
		Executor::doit($sql);
	}
	public function actualizar_pivilegio(){
		$sql = "update ".self::$tablename." set is_activo=\"$this->is_activo\",is_admin=\"$this->is_admin\",is_publico=\"$this->is_publico\" where id_usuario=$this->id_usuario";
		Executor::doit($sql);
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


	public static function getById($id_usuario){
		$sql = "select * from ".self::$tablename." where id_usuario=$id_usuario";
		$query = Executor::doit($sql);
		return Model::one($query[0],new UserData());
	}

	public static function getByEmail($id_usuario){
		$sql = "select * from ".self::$tablename." where email=\"$id_usuario\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new UserData());
	}

	public static function getByNick($nick){
		$sql = "select * from ".self::$tablename." where email=\"$nick\" or username=\"$nick\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new UserData());

	}
	public static function getBDni($dni){
		$sql = "select * from ".self::$tablename." where dni=\"$dni\"";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new UserData();
			$array[$cnt]->dni = $r['dni'];
			$cnt++;
		}
		return $array;
	}
	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new UserData());
	}
	public static function IsAdmin(){
		$sql = "select * from ".self::$tablename." where is_admin=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new UserData());
	}
	public static function IsEmpleado(){
		$sql = "select * from ".self::$tablename." where is_empleado=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new UserData());
	}
	// MOZO
	public static function IsMozo(){
		$sql = "select * from ".self::$tablename." where is_mozo=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new UserData());
	}
	public function registrar_nuevo_mozo(){
		$sql = "insert into ".self::$tablename." (nombre,apellido,dni,direccion,imagen,email,telefono,is_activo,is_mozo,fecha) ";
		$sql .= "value (\"$this->nombre\",\"$this->apellido\",\"$this->dni\",\"$this->direccion\",\"$this->imagen\",\"$this->email\",\"$this->telefono\",1,1,NOW())";
		Executor::doit($sql);
	}
	public function actualizar_mozo(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\",apellido=\"$this->apellido\",telefono=\"$this->telefono\",dni=\"$this->dni\",direccion=\"$this->direccion\",email=\"$this->email\",is_publico=\"$this->is_publico\",is_admin=\"$this->is_admin\",is_activo=\"$this->is_activo\",is_mozo=\"$this->is_mozo\",is_empleado=\"$this->is_empleado\",is_cheff=\"$this->is_cheff\",is_ayudante=\"$this->is_ayudante\",is_cocinero=\"$this->is_cocinero\",is_panadero=\"$this->is_panadero\",is_confitero=\"$this->is_confitero\",is_barman=\"$this->is_barman\",is_personal_limpieza=\"$this->is_personal_limpieza\",is_empleado=\"$this->is_empleado\",is_cajero=\"$this->is_cajero\" where id_usuario=$this->id_usuario";
		Executor::doit($sql);
	}
	public function eliminar(){
		$sql = "delete from ".self::$tablename." where id_usuario=$this->id_usuario";
		Executor::doit($sql);
	}
	
	// EMPLEADO
	public function registrar_nuevo_empleado(){
		$sql = "insert into ".self::$tablename." (nombre,apellido,dni,direccion,imagen,email,telefono,is_activo,is_empleado,fecha) ";
		$sql .= "value (\"$this->nombre\",\"$this->apellido\",\"$this->dni\",\"$this->direccion\",\"$this->imagen\",\"$this->email\",\"$this->telefono\",1,1,NOW())";
		Executor::doit($sql);
	}
	public function actualizar_empleado(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\",apellido=\"$this->apellido\",telefono=\"$this->telefono\",dni=\"$this->dni\",direccion=\"$this->direccion\",email=\"$this->email\",is_publico=\"$this->is_publico\",is_admin=\"$this->is_admin\",is_activo=\"$this->is_activo\",is_mozo=\"$this->is_mozo\",is_empleado=\"$this->is_empleado\",is_cheff=\"$this->is_cheff\",is_ayudante=\"$this->is_ayudante\",is_cocinero=\"$this->is_cocinero\",is_panadero=\"$this->is_panadero\",is_confitero=\"$this->is_confitero\",is_barman=\"$this->is_barman\",is_personal_limpieza=\"$this->is_personal_limpieza\",is_empleado=\"$this->is_empleado\",is_cajero=\"$this->is_cajero\" where id_usuario=$this->id_usuario";
		Executor::doit($sql);
	}
}

?>