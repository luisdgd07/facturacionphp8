<?php

$cart = $_POST['carrito'];
if (count($cart) > 0) {
	/// antes de proceder con lo que sigue vamos a verificar que:
	// haya existencia de productos
	// si se va a facturar la cantidad a facturr debe ser menor o igual al producto facturado en inventario
	$num_succ = 0;
	$process = true;
	$errors = array();
	foreach ($cart as $c) {

		///
		$q = OperationData::getQYesFf($c["producto_id"]);
		if (($c["q"] <= $q) or ($c["q"] >= $q)) {
			if (isset($_POST["is_oficiall"])) {
				$qyf = OperationData::getQYesFf($c["producto_id"]); /// son los productos que puedo facturar
				if ($c["q"] <= $qyf) {
					$num_succ++;
				} else {
				}
			} else {
				// si llegue hasta aqui y no voy a facturar, entonces continuo ...
				$num_succ++;
			}
		} else {
			$process = false;
		}
	}

	if (($process == true) && ($_POST["accion_id"] == 1)) {
		$sell = new VentaData();
		$sell->usuario_id = $_SESSION["admin_id"];
		$a = $_POST["id_sucursal"];
		$j = $_POST["accion_id"];
		$sell->accion_id = $j;      // poner el nombre de la accion aca y en detalle  tambien
		$sell->sucursal_id = $a;
		$sell->fecha = $_POST["sd"];
		$s = $sell->registrotranasaccion();
		$producto = new ProductoData();

		foreach ($cart as  $c) {
			$op = new OperationData();
			$op->producto_id = $c["producto_id"];
			$m = $_POST["accion_id"];
			$stc = $c["stock"];
			$op->stock_trans = $stc;
			$op->accion_id = $m;
			$op->venta_id = $s[1];
			$b = $_POST["id_sucursal"];
			$op->sucursal_id = $b;
			$op->q = $c["q"];
			$op->motivo = $_POST["motivo"];
			$op->observacion = $c["observacion"];
			$op->fecha = $_POST["sd"];


			$op->id_deposito = $_POST["id_deposito"];
			$op2 = $op->registrotransaccionn();
			// var_dump($op2);
			$producto->precio = null;
			$producto->id_producto = $c["producto_id"];
			$producto->updatePrice();



			if (($_POST["id_depositopro"] == $_POST["id_deposito"])) {


				$actualizar = new StockData();
				$resta = $c["stock"] + $c["q"];
				$actualizar->CANTIDAD_STOCK =	$resta;
				$actualizar->DEPOSITO_ID = $_POST["id_deposito"];
				$actualizar->PRODUCTO_ID = $c["producto_id"];
				$actualizar->actualizar2();
			} else {

				$registro2 = new StockData();
				$registro2->DEPOSITO_ID = $_POST['id_deposito'];
				$registro2->PRODUCTO_ID = $c["producto_id"];
				$registro2->CANTIDAD_STOCK = $c["q"];
				$registro2->MINIMO_STOCK = 10;
				$registro2->MAXIMO_STOCK = 10;
				$registro2->SUCURSAL_ID = $_POST["id_sucursal"];
				$registro2->COSTO_COMPRA = $_POST['precio_comp'];
				$registro2->registrar();
			}
		}
		echo 1;
		// Core::alert("Entrada realizada con exito...!");
		// Core::redir("index.php?view=transacciones&id_sucursal=" . $_POST['id_sucursal']);
	} else if (($process == true) && ($_POST["accion_id"] == 2)) {
		$sell = new VentaData();
		$sell->usuario_id = $_SESSION["admin_id"];
		$a = $_POST["id_sucursal"];
		$j = $_POST["accion_id"];
		$sell->accion_id = $j;      // poner el nombre de la accion aca y en detalle  tambien
		$sell->sucursal_id = $a;
		$sell->fecha = $_POST["sd"];
		$s = $sell->registrotranasaccion();
		foreach ($cart as  $c) {
			$op = new OperationData();
			$op->producto_id = $c["producto_id"];
			$m = $_POST["accion_id"];
			$stc = $c["stock"];
			$op->stock_trans = $stc;
			$op->accion_id = $m;
			$op->venta_id = $s[1];
			$b = $_POST["id_sucursal"];
			$op->sucursal_id = $b;
			$op->q = $c["q"];
			$op->motivo = $_POST["motivo"];
			$op->observacion = $c["observacion"];
			$op->fecha = $_POST["sd"];



			$op->id_deposito = $_POST["id_deposito"];
			$op2 = $op->registrotransaccionn();
			// var_dump($op2);

			if (($_POST["id_depositopro"] == $_POST["id_deposito"])) {


				$actualizar = new StockData();
				$resta = $c["stock"] - $c["q"];
				$actualizar->CANTIDAD_STOCK =	$resta;
				$actualizar->DEPOSITO_ID = $_POST["id_deposito"];
				$actualizar->PRODUCTO_ID = $c["producto_id"];
				$actualizar->actualizar2();
			} else {

				// Core::alert("El producto no se encuentra en el deposito...!");
				// Core::redir("index.php?view=transacciones&id_sucursal=" . $_POST['id_sucursal']);
			}
		}
		echo 1;

		// Core::alert("Salida realizada con exito...!");
		// Core::redir("index.php?view=transacciones&id_sucursal=" . $_POST['id_sucursal']);
	} else if (($process == true) && ($_POST["accion_id"] == 3)) {
		$sell = new VentaData();
		$sell->usuario_id = $_SESSION["admin_id"];
		$a = $_POST["id_sucursal"];
		$j = $_POST["accion_id"];
		$sell->accion_id = $j;      // poner el nombre de la accion aca y en detalle  tambien
		$sell->sucursal_id = $a;
		$sell->fecha = $_POST["sd"];
		$s = $sell->registrotranasaccion();
		foreach ($cart as  $c) {
			$op = new OperationData();
			$op->producto_id = $c["producto_id"];
			$m = $_POST["accion_id"];
			$stc = $c["stock"];
			$op->stock_trans = $stc;
			$op->accion_id = $m;
			$op->venta_id = $s[1];
			$b = $_POST["id_sucursal"];
			$op->sucursal_id = $b;
			$op->q = $c["q"];
			$op->motivo = $_POST["motivo"];
			$op->observacion = $c["observacion"];
			$op->fecha = $_POST["sd"];




			$op->id_deposito = $_POST["id_deposito"];
			$op2 = $op->registrotransaccionn();
			// var_dump($op2);
			$stock2 = StockData::vercontenidos3($c["producto_id"], $_POST["id_deposito2"]);
			$actualizar = new StockData();
			if (!isset($stock2->CANTIDAD_STOCK)) {
				$actualizar2 = new StockData();
				$actualizar2->DEPOSITO_ID = $_POST["id_deposito2"];
				$actualizar2->PRODUCTO_ID = $c["producto_id"];
				$actualizar2->CANTIDAD_STOCK =	$c["q"];
				$actualizar2->MINIMO_STOCK = 0;
				$actualizar2->MAXIMO_STOCK = 0;
				$actualizar2->SUCURSAL_ID = $_POST["id_sucursal"];
				$actualizar2->COSTO_COMPRA = 0;
				$actualizar2->registrar();
			} else {
				$resta = $stock2->CANTIDAD_STOCK + $c["q"];
				$actualizar->CANTIDAD_STOCK =	$resta;
				$actualizar->PRODUCTO_ID = $c["producto_id"];
				$actualizar->DEPOSITO_ID = $_POST["id_deposito2"];
				$actualizar->actualizar();
			}
			$actualizar2 = new StockData();
			$resta = $c["stock"] - $c["q"];
			$actualizar2->CANTIDAD_STOCK =	$resta;
			$actualizar2->PRODUCTO_ID = $c["producto_id"];
			$actualizar2->DEPOSITO_ID = $_POST["id_deposito"];
			$actualizar2->actualizar();



			// if (($_POST["id_deposito2"] == $_POST["id_deposito"])) {


			// 	$actualizar = new StockData();
			// 	$resta = $c["stock"] - $c["q"];
			// 	$actualizar->CANTIDAD_STOCK =	$resta;
			// 	$actualizar->DEPOSITO_ID = $_POST["id_deposito"];
			// 	$actualizar->PRODUCTO_ID = $c["producto_id"];
			// 	$actualizar->actualizar2();
			// } else {

			// 	// Core::alert("Producto no se encuentra en el deposito...!");
			// 	// Core::redir("index.php?view=transacciones&id_sucursal=" . $_POST['id_sucursal']);
			// }


			// if (($_POST["id_deposito2"] == $_POST["id_deposito"])) {


			// 	$actualizar = new StockData();
			// 	$resta = $c["stock"] + $c["q"];
			// 	$actualizar->CANTIDAD_STOCK =	$resta;
			// 	$actualizar->DEPOSITO_ID = $_POST["id_deposito2"];
			// 	$actualizar->PRODUCTO_ID = $c["producto_id"];
			// 	$actualizar->actualizar2();
			// } else {

			// 	$registro2 = new StockData();
			// 	$stock2 = StockData::vercontenidos3($c["producto_id"], $_POST["id_deposito2"]);
			// 	$registro2->DEPOSITO_ID = $_POST['id_deposito2'];
			// 	$registro2->PRODUCTO_ID = $c["producto_id"];
			// 	$registro2->CANTIDAD_STOCK = $c["q"];
			// 	$registro2->MINIMO_STOCK = 10;
			// 	$registro2->MAXIMO_STOCK = 10;
			// 	$registro2->SUCURSAL_ID = $_POST["id_sucursal"];
			// 	$registro2->COSTO_COMPRA = $_POST['precio_comp'];
			// 	$registro2->registrar();
			// }
		}
		echo 1;

		// Core::alert("Trasferencia realizada con exito...!");
		// Core::redir("index.php?view=transacciones&id_sucursal=" . $_POST['id_sucursal']);
	}
	if ($process == false) {
		echo -1;
	}
}
