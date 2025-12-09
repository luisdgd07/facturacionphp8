<?php



$c = VentaData::getNombre2($_POST["facturan"], $_POST["sucursal_id"]);

// if ($c == null) {


$cart = $_POST["cart"];
$tipoproducto = $cart[0]["tipo"];
// if ($tipoproducto == "Servicio") {
// 	print("Servicio");
// 	if (isset($_POST["cart"])) {
// 		$cart = $_POST["cart"];
// 		if (count($cart) > 0) {
// 			$num_succ = 0;
// 			$process = false;
// 			$errors = array();
// 			// foreach ($cart as $c2) {
// 			// 	$q = 2;
// 			// 	if ($c2["cantidad"] <= $q) {
// 			// 		if (isset($_POST["is_oficiall"])) {
// 			// 			$qyf = 2; /// son los productos que puedo facturar
// 			// 			if ($c2["cantidad"] <= $qyf) {
// 			// 				$num_succ++;
// 			// 			} else {
// 			// 				$error = array("id" => $c2["id"], "message" => "No hay suficiente cantidad de producto para facturar en inventario.");
// 			// 				$errors[count($errors)] = $error;
// 			// 			}
// 			// 		} else {
// 			// 			// si llegue hasta aqui y no voy a facturar, entonces continuo ...
// 			$num_succ++;
// 			// 		}
// 			// 	} else {
// 			// 		$error = array("id" => $c2["id"], "message" => "No hay suficiente cantidad de producto en inventario.");
// 			// 		$errors[count($errors)] = $error;
// 			// 	}
// 			// }
// 			if ($num_succ == count($cart)) {
// 				$process = true;
// 			}
// 			if ($process == false) {
// 				$_SESSION["errors"] = $errors;	
?>

// <?php
	// 			}
	// 			if ($process == true) {
	// 				$sell = new VentaData1();
	// 				$sell->usuario_id = $_SESSION["admin_id"];
	// 				$sell->presupuesto = $_POST["presupuesto"];
	// 				$j1 = $_POST['serie1'];
	// 				$j2 = "-";
	// 				$j5 = $_POST['numeracion_final'];
	// 				$j6 = $_POST['diferencia'];
	// 				$j7 = ($j5 - $j6);
	// 				$j8 = ($j5 - $j6);

	// 				$sell->factura = $_POST['facturan'];
	// 				// if ($j8 >= 1 & $j8 < 10) {
	// 				// 	$sell->factura = $j1 . "-" . "000000" . $j8;
	// 				// } else {
	// 				// 	if ($j8 >= 10 & $j8 < 100) {
	// 				// 		$sell->factura = $j1 . "-" . "00000" . $j8;
	// 				// 	} else {
	// 				// 		if ($j8 >= 100 & $j8 < 1000) {
	// 				// 			$sell->factura = $j1 . "-" . "0000" . $j8;
	// 				// 		} else {
	// 				// 			if ($j8 >= 1000 & $j8 < 10000) {
	// 				// 				$sell->factura = $j1 . "-" . "000" . $j8;
	// 				// 			} else {
	// 				// 				if ($j8 >= 100000 & $j8 < 1000000) {
	// 				// 					$sell->factura = $j1 . "-" . "00" . $j8;
	// 				// 				} else {
	// 				// 					if ($j8 >= 1000000 & $j8 < 10000000) {
	// 				// 						$sell->factura = $j1 . "-" . "0" . $j8;
	// 				// 					} else {
	// 				// 					}
	// 				// 				}
	// 				// 			}
	// 				// 		}
	// 				// 	}
	// 				// }





	// 				$sell->configfactura_id = $_POST["configfactura_id"];
	// 				$sell->tipomoneda_id = trim($_POST["idtipomoneda"]);


	// 				$sell->cambio = $_POST["cambio"];
	// 				$sell->cambio2 = $_POST["cambio2"];
	// 				$sell->destino = $_POST["destino"];
	// 				$sell->simbolo2 = $_POST["simbolo2"];

	// 				$sell->formapago = $_POST["formapago"];
	// 				$sell->codigo = $_POST["codigo"];
	// 				$sell->fechapago = date('Y-m-d', strtotime($_POST['fecha']));
	// 				$sell->metodopago = $_POST["metodopago"];
	// 				$sell->total10 = str_replace(',', '', $_POST["total10"]);
	// 				$sell->iva10 = str_replace(',', '', $_POST["iva10"]);
	// 				$sell->total5 = str_replace(',', '', $_POST["total5"]);
	// 				$sell->iva5 = str_replace(',', '', $_POST["iva5"]);
	// 				$sell->exenta = str_replace(',', '', $_POST["exenta"]);
	// 				$a1 = $_POST['total'];
	// 				$sell->total = str_replace(',', '', $a1);
	// 				$sell->n = 1;
	// 				$sell->numerocorraltivo = $j8;
	// 				$a = $_POST["sucursal_id"];
	// 				$sell->inicio = $_POST["inicio"];
	// 				$sell->serie_placa = $_POST["serie_placa"];

	// 				$sell->fin = $_POST["fin"];
	// 				$sell->sucursal_id = $a;
	// 				$sell->fecha = $_POST["fecha"];
	// 				$sell->cantidaconfigmasiva = $_POST["cantidaconfigmasiva"];

	// 				$s = 0;
	// 				if (isset($_POST["cliente_id"]) && $_POST["cliente_id"] != "") {
	// 					$sell->cliente_id = $_POST["cliente_id"];
	// 					$s = $sell->venta_producto_cliente4();
	// 				} else {
	// 					$s = $sell->add1();
	// 				}

	// 				foreach ($cart as  $c2) {

	// 					$op = new OperationData1();
	// 					$op->producto_id = $c2["producto_id"];
	// 					$op->fecha = $_POST["fecha"];
	// 					$op->accion_id = AccionData::getByName("salida")->id_accion;
	// 					$op->venta_id = $s[1];
	// 					$op->precio1 = $c2["precioc"];
	// 					$b = $_POST["sucursal_id"];



	// 					$stc = $_POST["stock_trans"];
	// 					$op->stock_trans = $stc;
	// 					$op->motivo = "VENTA" . " " . $s[1];




	// 					$op->sucursal_id = $b;
	// 					$op->q = $c2["cantidad"];
	// 					$op->deposito = $c2["deposito"];
	// 					$op->deposito_nombre = $c2["depositotext"];
	// 					$op->precio = $c2["precio"];

	// 					if (isset($_POST["is_oficiall"])) {
	// 						$op->is_oficiall = 1;
	// 					}
	// 					$op->deposito = $c2["deposito"];
	// 					$op->deposito_nombre = $c2["depositotext"];
	// 					$add = $op->registro_producto1();

	// 					// 

	// 					$actualizar = new StockData();
	// 					$resta = $c2["stock"] - $c2["cantidad"];
	// 					$actualizar->CANTIDAD_STOCK =    $resta;
	// 					$actualizar->PRODUCTO_ID = $c2["id"];
	// 					$actualizar->DEPOSITO_ID = $c2["deposito"];
	// 					$ac = $actualizar->actualizar2();
	// 					// 
	// 					//unset($_SESSION["cart"]);
	// 					//setcookie("selled", "selled");
	// 				}
	// 				if (count($_POST) > 0) {
	// 					$configuracionfactura = ConfigFacturaData::VerId($_POST["id_configfactura"]);
	// 					$jl1 = $_POST["diferencia"];
	// 					$jl2 = $s[1];
	// 					$configuracionfactura->diferencia = ($jl1 - 1);
	// 					$configuracionfactura->actualizardiferencia();
	// 				}
	// 				// if ($_POST["metodopago"] == "Credito") {
	// 				// 	$fecha_actual = date("d-m-Y");
	// 				// 	$vence = date("Y-m-d", strtotime($fecha_actual . "+ " . $_POST['vencimiento'] . " days"));
	// 				// 	$credito = new CreditoData();
	// 				// 	$credito->sucursalId = $_POST["sucursal_id"];
	// 				// 	$credito->monedaId = trim($_POST["idtipomoneda"]);
	// 				// 	$credito->concepto = $_POST["concepto"];
	// 				// 	$credito->cliente_id = $_POST["cliente_id"];
	// 				// 	$credito->credito = str_replace(',', '', $_POST['total']);
	// 				// 	$credito->cuotas = $_POST['cuotas'];
	// 				// 	$credito->abonado = 0;
	// 				// 	$credito->vencimiento = $vence;
	// 				// 	$credito->ventaId = $s[1];
	// 				// 	$cre = $credito->registrar_credito();
	// 				// 	for ($i = 1; $i < $_POST['cuotas'] + 1; $i++) {
	// 				// 		$detalle = new CreditoDetalleData();

	// 				// 		if ($i == 1) {
	// 				// 		} else {
	// 				// 			$vence = date("Y-m-d", strtotime($vence . "+ " . $_POST['vencimiento'] . " days"));
	// 				// 		}
	// 				// 		$detalle->fechaDetalle = $vence . '';
	// 				// 		$detalle->cuota = $i;
	// 				// 		$detalle->creditoId = $cre[1];
	// 				// 		$detalle->recibido = str_replace(',', '', $_POST['total']) / $_POST['cuotas'];
	// 				// 		$detalle->moneda = 0;
	// 				// 		$detalle->cliente_id = $_POST["cliente_id"];
	// 				// 		$detalle->sucursalId = $_POST["sucursal_id"];
	// 				// 		$detalle->factura = $sell->factura;
	// 				// 		$detalle->monedaId = trim($_POST["idtipomoneda"]);
	// 				// 		$d = $detalle->registrar_credito_detalle();
	// 				// 		$detalleCobro = new CobroDetalleData();
	// 				// 		$detalleCobro->creditoDetalle = $d[1];
	// 				// 		$detalleCobro->registrar_credito();
	// 				// 	}
	// 				// 	$cuotas = $_POST['cuotas'];
	// 				// 	// print "<script>window.location='index.php?view=creditodetalle&id=$cre[1]&id_venta=$s[1]';</script>";
	// 				// }


	// 				header("Content-type:application/json");
	// 				$jsdata = json_decode(file_get_contents('php://input'), true);
	// 				header("HTTP/1.1 200 OK");
	// 				header('Content-Type: text/plain');
	// 				echo json_encode($s[1]);
	// 			}
	// 		}
	// 	}
	// } else {
	if (isset($_POST["cart"])) {
		if (count($cart) > 0) {
			$num_succ = 0;
			$process = false;
			$errors = array();
			$cantidad = 0;
			foreach ($cart as $c2) {
				$cantidad += $c2['cantidad'];
				$cant = StockData::vercontenidos3($c2['id'], $c2['deposito']);
				// var_dump($cant);
				// echo $cant->CANTIDAD_STOCK;

				// echo $cant->CANTIDAD_STOCK - $c2['cantidad'];
				$num_succ++;
				// $error = array("id" => $c2["id"], "message" => "No hay suficiente cantidad de producto para facturar en inventario.");
				//             $errors[count($errors)] = $error;
				// $q = OperationData::getQYesFf($c2["id"]);
				// if ($c2["cantidad"] <= $q) {
				//     if (isset($_POST["is_oficiall"])) {
				//         $qyf = OperationData::getQYesFf($c2["id"]);
				//         if ($c2["cantidad"] <= $qyf) {
				//             $num_succ++;
				//         } else {
				//             $error = array("id" => $c2["id"], "message" => "No hay suficiente cantidad de producto para facturar en inventario.");
				//             $errors[count($errors)] = $error;
				//         }
				//     } else {
				//         $num_succ++;
				//     }
				// } else {
				//     // echo "no hay suficiente producto";
				//     $error = array("id" => $c2["id"], "message" => "No hay suficiente cantidad de producto en inventario.");
				//     $errors[count($errors)] = $error;
				// }
			}
			// $process = false;
			if ($num_succ == count($cart)) {


				$process = true;
			} else {
				echo -1;
			}

			if ($num_succ == count($cart)) {
				$process = true;
			}

			if ($process == false) {
				$_SESSION["errors"] = $errors;
	?>

<?php
			}
			if ($process == true) {
				$sell = new VentaData();
				$sell->usuario_id = $_SESSION["admin_id"];
				$sell->presupuesto = $_POST["presupuesto"];
				$j1 = $_POST['serie1'];
				$j2 = "-";
				$j5 = $_POST['numeracion_final'];
				$j6 = $_POST['diferencia'];
				$j7 = ($j5 - $j6);
				$j8 = ($j5 - $j6);
				$sell->factura = $_POST['facturan'];

				// if ($j8 >= 1 & $j8 < 10) {
				// 	$sell->factura = $j1 . "-" . "000000" . $j8;
				// } else {
				// 	if ($j8 >= 10 & $j8 < 100) {
				// 		$sell->factura = $j1 . "-" . "00000" . $j8;
				// 	} else {
				// 		if ($j8 >= 100 & $j8 < 1000) {
				// 			$sell->factura = $j1 . "-" . "0000" . $j8;
				// 		} else {
				// 			if ($j8 >= 1000 & $j8 < 10000) {
				// 				$sell->factura = $j1 . "-" . "000" . $j8;
				// 			} else {
				// 				if ($j8 >= 100000 & $j8 < 1000000) {
				// 					$sell->factura = $j1 . "-" . "00" . $j8;
				// 				} else {
				// 					if ($j8 >= 1000000 & $j8 < 10000000) {
				// 						$sell->factura = $j1 . "-" . "0" . $j8;
				// 					} else {
				// 						$sell->factura = $j1 . "-" .  $j8;
				// 					}
				// 				}
				// 			}
				// 		}
				// 	}
				// }

				$sell->configfactura_id = $_POST["configfactura_id"];
				$sell->tipomoneda_id = trim($_POST["idtipomoneda"]);

				$sell->cambio = $_POST["cambio"];
				$sell->cambio2 = $_POST["cambio2"];
				$sell->simbolo2 = $_POST["simbolo2"];

				$sell->formapago = $_POST["formapago"];
				$sell->codigo = $_POST["codigo"];
				$sell->tipo_remision = $_POST['tipo_doc'];
				$sell->fechapago = date('Y-m-d', strtotime($_POST['fecha']));
				$sell->metodopago = $_POST["metodopago"];
				// $sell->total10 = $_POST["total10"];
				$sell->total10 = str_replace(',', '', $_POST["total10"]);
				// $sell->iva10 = $_POST["iva10"];
				$sell->iva10 = str_replace(',', '', $_POST["iva10"]);
				// $sell->total5 = $_POST["total5"];
				$sell->total5 = str_replace(',', '', $_POST["total5"]);
				// $sell->iva5 = $_POST["iva5"];
				$sell->iva5 = str_replace(',', '', $_POST["iva5"]);
				// $sell->exenta = $_POST["exenta"];
				$sell->exenta = str_replace(',', '', $_POST["exenta"]);
				$a1 = $_POST['total'];
				// $a2=(($a1/2000)+1);
				// $sell->total = $a1;
				$sell->total = str_replace(',', '', $a1);
				$sell->n = 1;
				$sell->numerocorraltivo = $j8;
				$a = $_POST["sucursal_id"];
				$sell->sucursal_id = $a;
				$sell->fecha = $_POST["fecha"];
				$sell->chofer_id = $_POST["chofer_id"];
				$sell->vehiculo_id = $_POST["vehiculo_id"];
				$sell->dep_id = $_POST["dep_id"];
				$sell->ciudad_id = $_POST["ciudad_id"];
				$sell->destino = $_POST["destino"];
				// $sell->inicio = $_POST["inicio"];
				// $sell->serie_placa = $_POST["serie_placa"];
				// $sell->fin = $_POST["fin"];
				$sell->cantidaconfigmasiva = $_POST["cantidaconfigmasiva"];
				$s = 0;
				$sell->cliente_id = $_POST["cliente_id"];
				$sell->contrato = $_POST["contrato"];
				$s = $sell->venta_producto_cliente4();


				$placaData = new PlacaData();
				$cant = 0;
				if (isset($_POST['placas'])) {
					$placas = $_POST['placas'];
					foreach ($placas as $c2) {
						$cant += $c2['cantidad'];
					}


					$placaData->nini = 1;
					$placaData->nfin = 1;

					$placaData->serie_placa = 1;



					$placaData->venta = $s[1];
					$placaData->cantidad = $cant;
					$placaData->sucursal = $_POST["sucursal_id"];
					$placaData->registro_placa();
					foreach ($placas as $c2) {
						$placaDetalleData = new PlacaDetalleData();
						$placaDetalleData->producto = 1;
						$placaDetalleData->venta = $s[1];
						$placaDetalleData->cantidad = $c2["cantidad"];
						$placaDetalleData->numero_placa_ini = $c2['ini'];
						$placaDetalleData->numero_placa_fin = $c2['fin'];
						//$placaDetalleData->numero_placa_fin = $c2['cantidad'];
						$placaDetalleData->registro_serie = $c2['serie'];
						$placaDetalleData->sucursal = $_POST["sucursal_id"];
						$placaDetalleData->id_placa = $c2['id'];
						$placaDetalleData->registro_placa();
						$placaDetalleD = new PlacaDetalleData();
						$dap = PlacaDetalleData::obtenerPlaca($c2['id']);
						$placaDetalleD->total = $dap->diferencia + $c2["cantidad"];
						$placaDetalleD->id = $c2['id'];
						$t = $placaDetalleD->resta();
					}
				}

				foreach ($cart as  $c2) {

					$op = new OperationData();
					$op->producto_id = $c2["id"];
					$op->fecha = $_POST["fecha"];
					$op->accion_id = AccionData::getByName("salida")->id_accion;
					$op->venta_id = $s[1];
					$op->precio1 = $c2["precioc"];
					$b = $_POST["sucursal_id"];
					// $ptot =  str_replace(',', '', $_POST["precio_total_"]);


					$stc = $_POST["stock_trans"];
					$op->stock_trans = $stc;
					$op->motivo = "VENTA" . " " . $s[1];


					//este me registra el total final en todo

					$op->sucursal_id = $b;
					$op->q = $c2["cantidad"];
					$op->precio = $c2["precio"];

					if (isset($_POST["is_oficiall"])) {
						$op->is_oficiall = 1;
					}
					$op->deposito = $c2["deposito"];
					$op->deposito_nombre = $c2["depositotext"];
					$add = $op->registro_producto1();

					$stock2 = StockData::vercontenidos3($c2["id"], $c2["deposito"]);
					$actualizar = new StockData();

					$resta = $stock2->CANTIDAD_STOCK - $c2["cantidad"];
					$actualizar->CANTIDAD_STOCK =    $resta;
					$actualizar->PRODUCTO_ID = $c2["id"];
					$actualizar->DEPOSITO_ID = $c2["deposito"];
					$ac = $actualizar->actualizar2();
					$insumosData = InsumosData::find($c2["id"]);
					foreach ($insumosData as $insumo) {
						$op = new OperationData();
						$op->producto_id = $insumo->insumo_id;
						$op->fecha = $_POST["fecha"];
						$op->accion_id = AccionData::getByName("salida")->id_accion;
						$op->venta_id = $s[1];
						$op->precio1 = 0;
						$b = $_POST["sucursal_id"];


						$stc = $_POST["stock_trans"];
						$op->stock_trans = $stc;
						$op->motivo = "VENTA" . " " . $s[1];



						$op->sucursal_id = $b;
						$op->q = $insumo->cantidad;
						$op->precio = $insumo->total;

						if (isset($_POST["is_oficiall"])) {
							$op->is_oficiall = 1;
						}
						$op->deposito = $c2["deposito"];
						$op->deposito_nombre = $c2["depositotext"];
						$add = $op->registro_producto1();



						$stocki = StockData::vercontenidos3($insumo->insumo_id, $c2["deposito"]);
						$actualizari = new StockData();
						$resta = $stocki->CANTIDAD_STOCK - $insumo->cantidad;
						$actualizari->CANTIDAD_STOCK =    $resta;
						$actualizari->PRODUCTO_ID = $insumo->insumo_id;
						$actualizari->DEPOSITO_ID = $c2["deposito"];
						$aci = $actualizari->actualizar2();
					}
				}
				if (count($_POST) > 0) {
					$configuracionfactura = ConfigFacturaData::VerId($_POST["id_configfactura"]);
					$jl1 = $_POST["diferencia"];
					$jl2 = $s[1];
					$configuracionfactura->diferencia = ($jl1 - 1);
					$configuracionfactura->actualizardiferencia();
				}
				// if ($_POST["metodopago"] == "Credito") {
				// 	$fecha_actual = date("d-m-Y");
				// 	$vence = date("Y-m-d", strtotime($fecha_actual . "+ " . $_POST['vencimiento'] . " days"));
				// 	$credito = new CreditoData();
				// 	$credito->sucursalId = $_POST["sucursal_id"];
				// 	$credito->monedaId = trim($_POST["idtipomoneda"]);
				// 	$credito->concepto = $_POST["concepto"];
				// 	$credito->cliente_id = $_POST["cliente_id"];
				// 	$credito->credito = str_replace(',', '', $_POST['total']);
				// 	$credito->cuotas = $_POST['cuotas'];
				// 	$credito->abonado = 0;
				// 	$credito->vencimiento = $vence;
				// 	$credito->ventaId = $s[1];
				// 	$cre = $credito->registrar_credito();
				// 	for ($i = 1; $i < $_POST['cuotas'] + 1; $i++) {
				// 		$detalle = new CreditoDetalleData();

				// 		if ($i == 1) {
				// 		} else {
				// 			$vence = date("Y-m-d", strtotime($vence . "+ " . $_POST['vencimiento'] . " days"));
				// 		}
				// 		$detalle->sucursalId = $_POST["sucursal_id"];
				// 		$detalle->fechaDetalle = $vence . '';
				// 		$detalle->cuota = $i;
				// 		$detalle->creditoId = $cre[1];
				// 		$detalle->cliente_id = $_POST["cliente_id"];
				// 		$detalle->monedaId = trim($_POST["idtipomoneda"]);
				// 		$detalle->factura = $sell->factura;
				// 		$detalle->recibido = str_replace(',', '', $_POST['total']) / $_POST['cuotas'];
				// 		$detalle->moneda = 0;
				// 		$d = $detalle->registrar_credito_detalle();
				// 		$detalleCobro = new CobroDetalleData();
				// 		$detalleCobro->creditoDetalle = $d[1];
				// 		$detalleCobro->registrar_credito();
				// 	}

				header("Content-type:application/json");
				$jsdata = json_decode(file_get_contents('php://input'), true);
				header("HTTP/1.1 200 OK");
				header('Content-Type: text/plain');
				echo json_encode($s[1]);
			}
		}
	}
	// } else {
	// 	// Core::alert("NUMERO DE remision EXISTENTE...!");
	// 	// Core::redir("index.php?view=remision&id_sucursal=" . $_POST["id_sucursal"]);
	// }

?>