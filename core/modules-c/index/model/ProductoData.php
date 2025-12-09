<?php
class ProductoData
{
	public static $tablename = "producto";



	public function Userdata()
	{
		$this->nombre = "";
		$this->apellido = "";
		$this->email = "";
		$this->imagen = "";
		$this->password = "";
		$this->fecha_registro = "NOW()";
	}
	public function tipoproducto()
	{
		return TipoProductoData::VerId($this->ID_TIPO_PROD);
	}
	public function precioproducto()
	{
		return PrecioProductoData::VerId($this->ID_TIPO_PROD);
	}
	public function getFullname()
	{
		return $this->nombre . " " . $this->apellido;
	}
	public  function verSocursal()
	{
		return SuccursalData::VerId($this->sucursal_id);
	}

	public static function verproductosucursal($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and activo=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}
	public static function verproductoscate($idcate)
	{
		$sql = "select * from " . self::$tablename . " where categoria_id=$idcate and activo=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}
	// public static function verproductoscateProd($idcate)
	// {
	// 	$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal";
	// 	$query = Executor::doit($sql);
	// 	return Model::many($query[0], new ProductoData());
	// }




	public static function verPRODTIPOSUC($id_sucursal)
	{
		$sql = "select * from tipo_producto where sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}
	public static function verinsumo($id_sucursal)
	{
		$sql = "SELECT * FROM `tipo_producto` WHERE `TIPO_PRODUCTO` LIKE 'Insumo' AND `sucursal_id` = $id_sucursal";
		$query = Executor::doit($sql);
		return Model::one($query[0], new ProductoData());
	}



	public static function getProducto2($id_producto)
	{
		$sql = "select * from " . self::$tablename . " where id_producto=$id_producto";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}




	public static function verdeposito($id_sucursal)
	{
		$sql = "select * from deposito where sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}





	public static function categorian($id_sucursal)
	{
		$sql = "select * from categoria where id_categoria=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}





	public static function deposito($id_sucursal)
	{
		$sql = "select * from deposito where DEPOSITO_ID=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}


	public static function listar_precio($id_sucursal)
	{
		$sql = "select * from  lista_precio where sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}
	public static function listar_tipo_precio($id)
	{
		$sql = "select * from  lista_precio where PRECIO_ID=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new ProductoData());
	}
	public function registrolistaprecio_pro()
	{
		$sql = "insert into productos_precios (PRODUCTO_ID,PRECIO_ID, nombre_product, IMPORTE,MONEDA,SUCURSAL_ID,ID_MONEDA) ";
		$sql .= "value ($this->id_producto,\"$this->id_precio\",\"$this->nombre_prod\",\"$this->importe_precio\",\"$this->moneda_non\",\"$this->sucursal_id\",\"$this->id_moneda\")";
		return Executor::doit($sql);
	}
	public static function listar_precio_producto($id_sucursal)
	{
		$sql = "select * from   productos_precios where sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}
	public static function listar_precio_productos($PRODUCTO_ID)
	{
		$sql = "select * from   productos_precios where PRODUCTO_ID=$PRODUCTO_ID";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}
	public static function listar_precio_productos2($PRODUCTO_ID, $tipo, $id_moneda)
	{
		$sql = "select * from productos_precios where PRODUCTO_ID=$PRODUCTO_ID and PRECIO_ID = $tipo and ID_MONEDA = $id_moneda";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}


	public static function vertipomoneda($id_sucursal)
	{
		$sql = "select * from tipomoneda where sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}




	public static function vertipomonedadescrip($id_sucursal, $id_moneda)
	{
		$sql = "select * from tipomoneda where sucursal_id=$id_sucursal and id_tipomoneda =$id_moneda";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}

	public static function vertipomonedadescrip2($id_sucursal, $id_PRECIO)
	{
		$sql = "select * from  lista_precio where sucursal_id=$id_sucursal and PRECIO_ID =$id_PRECIO";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}


	public static function vertipomonedadescrip3($id_sucursal, $id_prod)
	{
		$sql = "select * from  producto where sucursal_id=$id_sucursal and id_producto =$id_prod";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}


	public static function vertipoproductosuc($id_sucursal)
	{
		$sql = "select * from tipo_producto where sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}
	public function registrotipo()
	{
		$sql = "insert into tipo_producto (sucursal_id,TIPO_PRODUCTO) ";
		$sql .= "value ($this->sucursal_id,\"$this->descripcion\")";
		return Executor::doit($sql);
	}


	public function registrodeposito()
	{
		$sql = "insert into deposito (SUCURSAL_ID,NOMBRE_DEPOSITO) ";
		$sql .= "value ($this->sucursal_id,\"$this->descripcion\")";
		return Executor::doit($sql);
	}



	public function registrolistaprecio()
	{
		$sql = "insert into lista_precio (SUCURSAL_ID,NOMBRE_PRECIO,MONEDA_ID,NOMBRE_MONEDA) ";
		$sql .= "value ($this->sucursal_id,\"$this->descripcion\",\"$this->moneda_id\",\"$this->moneda_non\")";
		return Executor::doit($sql);
	}


	public static function verproductosucursal2($id_sucursal, $producto_id)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal and id_producto =$producto_id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}

	// partiendo de que ya tenemos creado un objecto UserData previamente utilizamos el contexto
	public function registrar_producto()
	{
		$sql = "insert into " . self::$tablename . " (imagen,codigofabricante,codigoimportador,codigo,nombre,categoria_id,serie,modelo,marca,estado,descripcion,presentacion,precio_compra,precio_venta,inventario_minimo,cantidad_inicial,usuario_id,activo,fecha) ";
		$sql .= "value (\"$this->imagen\",\"$this->codigofabricante\",\"$this->codigoimportador\",\"$this->codigo\",\"$this->nombre\",$this->categoria_id,\"$this->serie\",\"$this->modelo\",\"$this->marca\",\"$this->estado\",\"$this->descripcion\",\"$this->presentacion\",\"$this->precio_compra\",\"$this->precio_venta\",\"$this->inventario_minimo\",\"$this->cantidad_inicial\",\"$this->usuario_id\",1,NOW())";
		return Executor::doit($sql);
	}
	public function registrar_producto1()
	{
		$sql = "insert into " . self::$tablename . " (sucursal_id,imagen,codigo,nombre,categoria_id,marca_id,presentacion,descripcion,cantidad_inicial,inventario_minimo,precio_compra,precio_venta,impuesto,usuario_id,activo,fecha, ID_TIPO_PROD) ";
		$sql .= "value ($this->sucursal_id,\"$this->imagen\",\"$this->codigo\",\"$this->nombre\",$this->categoria_id,$this->marca_id,\"$this->presentacion\",\"$this->descripcion\",\"$this->cantidad_inicial\",\"$this->inventario_minimo\",\"$this->precio_compra\",\"$this->precio_venta\",\"$this->impuesto\",\"$this->usuario_id\",1,NOW(),\"$this->ID_TIPO_PROD\")";
		return Executor::doit($sql);
	}
	public function registrar_contrato()
	{
		$sql = "INSERT INTO " . self::$tablename . " (sucursal_id, imagen, codigo, nombre,  descripcion, cantidad_inicial,  impuesto, usuario_id, activo, fecha, ID_TIPO_PROD, cliente_id, precio_venta,contrato_id, cuota, saldo) ";
		$sql .= "VALUES ($this->sucursal_id, \"$this->imagen\", \"$this->codigo\", \"$this->nombre\",  \"$this->descripcion\", $this->cantidad_inicial,  \"$this->impuesto\", \"$this->usuario_id\", 1, NOW(), $this->ID_TIPO_PROD, $this->cliente_id, $this->precio,\"$this->contrato\", \"$this->cuota\", $this->precio)";

		return Executor::doit($sql);
		// return $sql;
	}
	public function actualizar_contrato()
	{

		$sql = "UPDATE " . self::$tablename . " SET saldo = saldo - $this->precio WHERE `id_producto` = $this->id";

		return Executor::doit($sql);
		// return $sql;
	}
	// 	public function registrar_producto1(){
	// 	$sql = "insert into ".self::$tablename." (sucursal_id,imagen,codigofabricante,codigoimportador,codigo,nombre,categoria_id,serie,modelo,marca,estado,descripcion,presentacion,precio_compra,precio_venta,inventario_minimo,cantidad_inicial,impuesto,usuario_id,activo,fecha) ";
	// 	$sql .= "value ($this->sucursal_id,\"$this->imagen\",\"$this->codigofabricante\",\"$this->codigoimportador\",\"$this->codigo\",\"$this->nombre\",$this->categoria_id,\"$this->serie\",\"$this->modelo\",\"$this->marca\",\"$this->estado\",\"$this->descripcion\",\"$this->presentacion\",\"$this->precio_compra\",\"$this->precio_venta\",\"$this->inventario_minimo\",\"$this->cantidad_inicial\",\"$this->impuesto\",\"$this->usuario_id\",1,NOW())";
	// 	return Executor::doit($sql);
	// }
	public function actualizar_Producto()
	{
		$sql = "update " . self::$tablename . " set nombre=\"$this->nombre\",categoria_id=\"$this->categoria_id\",marca_id=\"$this->marca_id\",imagen=\"$this->imagen\",impuesto=\"$this->impuesto\",descripcion=\"$this->descripcion\",presentacion=\"$this->presentacion\",estado=\"$this->estado\",precio_compra=\"$this->precio_compra\",inventario_minimo=\"$this->inventario_minimo\",activo=1 where id_producto=$this->id_producto and sucursal_id=$this->sucursal_id";
		Executor::doit($sql);
		// return $sql;
	}
	public function actualizar_pivilegio()
	{
		$sql = "update " . self::$tablename . " set is_activo=\"$this->is_activo\",is_admin=\"$this->is_admin\",is_publico=\"$this->is_publico\" where id_usuario=$this->id_usuario";
		Executor::doit($sql);
	}
	public function actulizar_datos()
	{
		$sql = "update " . self::$tablename . " set nombre=\"$this->nombre\",apellido=\"$this->apellido\",dni=\"$this->dni\",telefono=\"$this->telefono\",direccion=\"$this->direccion\",genero=\"$this->genero\" where id_usuario=$this->id_usuario";
		Executor::doit($sql);
	}
	public function actualizar()
	{
		$sql = "update " . self::$tablename . " set usuario=\"$this->usuario\" where id_usuario=$this->id_usuario";
		Executor::doit($sql);
	}


	public function actualizardepo()
	{
		$sql = "update deposito set 	NOMBRE_DEPOSITO=\"$this->descripcion\" where DEPOSITO_ID=$this->id_deposito";
		Executor::doit($sql);
	}

	public function acutualizarlistado()
	{
		$sql = "update  lista_precio set 	NOMBRE_PRECIO=\"$this->descripcion\" where MONEDA_ID=$this->moneda_id";
		Executor::doit($sql);
	}


	public function acutualizarprecio_prod()
	{
		$sql = "update  productos_precios set 	IMPORTE=\"$this->importe_precio\"  where PRODUCTO_ID=\"$this->id_producto\" and PRECIO_ID=\"$this->id_precio\" ";
		Executor::doit($sql);
	}

	public function update_password()
	{
		$sql = "update " . self::$tablename . " set password=\"$this->password\" where id_usuario=$this->id_usuario";
		Executor::doit($sql);
	}
	public function actualizar_imagen()
	{
		$sql = "update " . self::$tablename . " set imagen=\"$this->imagen\" where id_producto=$this->id_producto";
		Executor::doit($sql);
	}
	public function update()
	{
		$sql = "update " . self::$tablename . " set name=\"$this->name\",email=\"$this->email\",username=\"$this->username\",lastname=\"$this->lastname\",is_active=\"$this->is_active\",is_admin=\"$this->is_admin\" where id=$this->id";
		Executor::doit($sql);
	}

	public function update_passwd()
	{
		$sql = "update " . self::$tablename . " set password=\"$this->password\" where id=$this->id";
		Executor::doit($sql);
	}


	public static function getNombre($codigo, $id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where codigo=\"$codigo\" and sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while ($r = $query[0]->fetch_array()) {
			$array[$cnt] = new ProductoData();
			$array[$cnt]->codigo = $r['codigo'];
			$cnt++;
		}
		return $array;
	}



	public static function gettipoprod($nombre, $id_sucursal)
	{
		$sql = "select * from tipo_producto where TIPO_PRODUCTO=\"$nombre\" and sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while ($r = $query[0]->fetch_array()) {
			$array[$cnt] = new ProductoData();
			$array[$cnt]->TIPO_PRODUCTO = $r['TIPO_PRODUCTO'];
			$cnt++;
		}
		return $array;
	}



	public static function getdeposito($nombre, $id_sucursal)
	{
		$sql = "select * from deposito where NOMBRE_DEPOSITO=\"$nombre\" and sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while ($r = $query[0]->fetch_array()) {
			$array[$cnt] = new ProductoData();
			$array[$cnt]->NOMBRE_DEPOSITO = $r['NOMBRE_DEPOSITO'];
			$cnt++;
		}
		return $array;
	}



	public static function getlistadopre($nombre, $id_sucursal)
	{
		$sql = "select * from lista_precio where NOMBRE_MONEDA=\"$nombre\" and sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while ($r = $query[0]->fetch_array()) {
			$array[$cnt] = new ProductoData();
			$array[$cnt]->nombre = $r['NOMBRE_MONEDA'];
			$cnt++;
		}
		return $array;
	}




	public static function getlistadoprecio_pro($precio, $producto, $sucursal, $importe)
	{
		$sql = "select * from productos_precios where  PRECIO_ID=$precio and PRODUCTO_ID=$producto  and SUCURSAL_ID=$sucursal and IMPORTE=$importe ";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while ($r = $query[0]->fetch_array()) {
			$array[$cnt] = new ProductoData();
			$array[$cnt]->IMPORTE = $r['IMPORTE'];
			$cnt++;
		}
		return $array;
	}






	public static function getById($id_producto)
	{
		$sql = "select * from " . self::$tablename . " where id_producto=$id_producto";
		$query = Executor::doit($sql);
		return Model::one($query[0], new ProductoData());
	}
	public static function getBycontrato($idcontrato)
	{
		$sql = "select * from " . self::$tablename . " where contrato_id=$idcontrato";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}
	public static function getcontratos($idcliente)
	{
		$sql = "SELECT DISTINCT contrato_id from  " . self::$tablename . " WHERE cliente_id = $idcliente";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
		// var_dump($sql);
	}



	public static function getByCliente($id_producto)
	{
		$sql = "select * from " . self::$tablename . " where cliente_id = $id_producto";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}
	public static function getByCliente2($id_producto, $sucursal)
	{
		$sql = "select * from " . self::$tablename;
		if ($id_producto != "todos") {
			$sql = $sql . " where cliente_id = $id_producto";
		} else {
			$sql = $sql . " where sucursal_id = $sucursal";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}
	public static function getByIddeposito($id_deposito)
	{
		$sql = "select * from  deposito where DEPOSITO_ID=$id_deposito";
		$query = Executor::doit($sql);
		return Model::one($query[0], new ProductoData());
	}


	public static function getByIlistado($id_listado)
	{
		$sql = "select * from  lista_precio where PRECIO_ID=$id_listado";
		$query = Executor::doit($sql);
		return Model::one($query[0], new ProductoData());
	}

	public static function getByIlistadoproducto($id_listado, $id_producto)
	{
		$sql = "select * from  productos_precios where PRECIO_ID=$id_listado and PRODUCTO_ID = $id_producto";
		$query = Executor::doit($sql);
		return Model::one($query[0], new ProductoData());
	}


	public static function getByEmail($id_usuario)
	{
		$sql = "select * from " . self::$tablename . " where email=\"$id_usuario\"";
		$query = Executor::doit($sql);
		return Model::one($query[0], new ProductoData());
	}

	public static function getByNick($nick)
	{
		$sql = "select * from " . self::$tablename . " where email=\"$nick\" or username=\"$nick\"";
		$query = Executor::doit($sql);
		return Model::one($query[0], new ProductoData());
	}
	public static function getnumercionfact($codigo, $id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where codigo=\"$codigo\" and sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while ($r = $query[0]->fetch_array()) {
			$array[$cnt] = new ProductoData();
			$array[$cnt]->codigo = $r['codigo'];
			$cnt++;
		}
		return $array;
	}
	public static function getAll($id_sucursal)
	{
		$sql = "select * from " . self::$tablename . " where sucursal_id=$id_sucursal";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}
	public function eliminar()
	{
		$sql = "delete from " . self::$tablename . " where id_producto=$this->id_producto";
		Executor::doit($sql);
	}
	public static function getLike($p)
	{
		$sql = "select * from " . self::$tablename . " where nombre like '%$p%' or codigo like '%$p%' or id_producto like '%$p%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}
	public static function getInsumo($id_sucursal, $p, $tipo)
	{
		$sql = "select * from " . self::$tablename . " where (sucursal_id=$id_sucursal and nombre like '%$p%' and ID_TIPO_PROD = $tipo) or (codigo like '%$p%' and sucursal_id=$id_sucursal and ID_TIPO_PROD = $tipo) or (sucursal_id=$id_sucursal and id_producto like '%$p%' and ID_TIPO_PROD = $tipo)";
		$query = Executor::doit($sql);
		// return $sql;
		return Model::many($query[0], new ProductoData());
	}
	// public static function getLikee($id_sucursal,$p){
	// 	$sql = "select * from ".self::$tablename." where sucursal_id=$id_sucursal and nombre like '%$p%' or codigo like '%$p%' or id_producto like '%$p%'";
	// 	$query = Executor::doit($sql);
	// 	return Model::many($query[0],new ProductoData());
	// }
	public static function getLikee($id_sucursal, $p, $tipo)
	{
		$sql = "select * from " . self::$tablename . " where (sucursal_id=$id_sucursal and nombre like '%$p%' and ID_TIPO_PROD != $tipo) or (codigo like '%$p%' and sucursal_id=$id_sucursal and ID_TIPO_PROD != $tipo) or (sucursal_id=$id_sucursal and id_producto like '%$p%' and ID_TIPO_PROD != $tipo)";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}
	// ELIMINAR CATEGORIA
	public static function getAllByCategoriaId($categoria_id)
	{
		$sql = "select * from " . self::$tablename . " where categoria_id=$categoria_id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}
	public function del_categoria()
	{
		$sql = "update " . self::$tablename . " set categoria_id=NULL where id_producto=$this->id_producto";
		Executor::doit($sql);
	}
	// *********************************** REPORTES ******************************
	// -----------------------VENTAS-------------------------------
	public static function getAllByDateOfficial($start, $end)
	{
		$sql = "select * from " . self::$tablename . " where date(fecha) >= \"$start\" and date(fecha) <= \"$end\"  order by fecha desc";
		if ($start == $end) {
			$sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\" order by fecha desc";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}

	public static function getAllByDateOfficialBP($producto, $start, $end)
	{
		$sql = "select * from " . self::$tablename . " where date(fecha) >= \"$start\" and date(fecha) <= \"$end\" and id_producto=$producto  order by fecha desc";
		if ($start == $end) {
			$sql = "select * from " . self::$tablename . " where date(fecha) = \"$start\" order by fecha desc";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductoData());
	}
}
