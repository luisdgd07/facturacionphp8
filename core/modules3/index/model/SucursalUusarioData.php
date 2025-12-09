<?php 
	class SucursalUusarioData{
		public static $tablename="sucursalusuario";

		public  function verUsuario(){ return UserData::getById($this->usuario_id);}
		public  function verSocursal(){ return SuccursalData::VerId($this->sucursal_id);}

		public function registro(){
			$sql = "insert into ".self::$tablename."(usuario_id,sucursal_id)";
			$sql .= "value ($this->usuario_id,\"$this->sucursal_id\")";
			Executor::doit($sql);
		}
		public function actualizar(){
			$sql = "update ".self::$tablename." set nombre=\"$this->nombre\",filial=\"$this->filial\",descripcion=\"$this->descripcion\",encargado_id=\"$this->encargado_id\" where id_area=$this->id_area";
			Executor::doit($sql);
		}
		public static function vercondicionessnombre($id_condicion){
		$sql = "select * from ".self::$tablename." where condicion_id=$id_condicion";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SucursalUusarioData());
		}
		public static function verusucursalusuarios($id_usuario){
		$sql = "select * from ".self::$tablename." where usuario_id=$id_usuario";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SucursalUusarioData());
		}
		public static function VerId($id_sucursalusuario){
		$sql = "select * from ".self::$tablename." where id_sucursalusuario=$id_sucursalusuario";
		$query = Executor::doit($sql);
		return Model::one($query[0],new SucursalUusarioData());
		}
		public function eliminar(){
		$sql = "delete from ".self::$tablename." where id_sucursalusuario=$this->id_sucursalusuario";
		Executor::doit($sql);
		}
		public static function verusuariosucursal($id_usuario){
		$sql = "select * from ".self::$tablename." where usuario_id=$id_usuario";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SucursalUusarioData());
		}
	}
 ?>