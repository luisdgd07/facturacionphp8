<?php

if (isset($_SESSION["cart"])) {
	$cart = $_SESSION["cart"];
	if (count($cart) > 0) {
		/// antes de proceder con lo que sigue vamos a verificar que:
		// haya existencia de productos
		// si se va a facturar la cantidad a facturr debe ser menor o igual al producto facturado en inventario
		$num_succ = 0;
		$process = false;
		$errors = array();
		foreach ($cart as $c) {

			///
			$q = OperationData::getQYesFf($c["producto_id"]);
			if ($c["q"] <= $q) {
				if (isset($_POST["is_oficiall"])) {
					$qyf = OperationData::getQYesFf($c["producto_id"]); /// son los productos que puedo facturar
					if ($c["q"] <= $qyf) {
						$num_succ++;
					} else {
						$error = array("producto_id" => $c["producto_id"], "message" => "No hay suficiente cantidad de producto para facturar en inventario.");
						$errors[count($errors)] = $error;
					}
				} else {
					// si llegue hasta aqui y no voy a facturar, entonces continuo ...
					$num_succ++;
				}
			} else {
				$error = array("producto_id" => $c["producto_id"], "message" => "No hay suficiente cantidad de producto en inventario.");
				$errors[count($errors)] = $error;
			}
		}

		if ($num_succ == count($cart)) {
			$process = true;
		}

		if ($process == false) {
			$_SESSION["errors"] = $errors;
?>
			<script>
				window.location = "index.php?view=registroventa";
			</script>
<?php
		}









		//////////////////////////////////
		if ($process == true) {
			$sell = new VentaData();
			$sell->usuario_id = $_SESSION["admin_id"];

			$sell->total = $_POST["total"];
			$sell->descuento = $_POST["descuento"];
			// if(isset($_POST["bolivar"])) { $sell->bolivar=1; }else{ $sell->bolivar=0; }
			// if(isset($_POST["dolar"])) { $sell->dolar=1; }else{ $sell->dolar=0; }

			if (isset($_POST["cliente_id"]) && $_POST["cliente_id"] != "") {
				$sell->cliente_id = $_POST["cliente_id"];
				$s = $sell->venta_producto_cliente();
			} else {
				$s = $sell->add();
			}


			foreach ($cart as  $c) {


				$op = new OperationData();
				$op->producto_id = $c["producto_id"];
				$op->accion_id = AccionData::getByName("salida")->id_accion;
				$op->venta_id = $s[1];
				$op->q = $c["q"];

				if (isset($_POST["is_oficiall"])) {
					$op->is_oficiall = 1;
				}

				$add = $op->registro_producto();

				unset($_SESSION["cart"]);
				setcookie("selled", "selled");
			}
			////////////////////
			print "<script>window.location='index.php?view=detalleventaproducto&id_venta=$s[1]';</script>";
		}
	}
}



?>