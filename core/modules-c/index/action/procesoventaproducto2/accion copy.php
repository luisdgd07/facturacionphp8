<?php
$tipoproducto = $_POST["tipoproducto"];
if ($tipoproducto == "Servicio") {
	print("Servicio");
	if (isset($_SESSION["cart"])) {
		$cart = $_SESSION["cart"];
		if (count($cart) > 0) {
			$num_succ = 0;
			$process = false;
			$errors = array();
			foreach ($cart as $c2) {
				$q = 2;
				if ($c2["q"] <= $q) {
					if (isset($_POST["is_oficiall"])) {
						$qyf = 2; /// son los productos que puedo facturar
						if ($c2["q"] <= $qyf) {
							$num_succ++;
						} else {
							$error = array("producto_id" => $c2["producto_id"], "message" => "No hay suficiente cantidad de producto para facturar en inventario.");
							$errors[count($errors)] = $error;
						}
					} else {
						// si llegue hasta aqui y no voy a facturar, entonces continuo ...
						$num_succ++;
					}
				} else {
					$error = array("producto_id" => $c2["producto_id"], "message" => "No hay suficiente cantidad de producto en inventario.");
					$errors[count($errors)] = $error;
				}
			}
			// ----------------------------
			if ($num_succ == count($cart)) {
				$process = true;
			}
			if ($process == false) {
				$_SESSION["errors"] = $errors;	?>
				<script>
					window.location = "index.php?view=registroventa";
				</script>
			<?php
			}
			// ------------------
			if ($process == true) {
				$sell = new VentaData1();
				$sell->usuario_id = $_SESSION["admin_id"];
				$sell->presupuesto = $_POST["presupuesto"];
				$j1 = $_POST['serie1'];
				$j2 = "-";
				$j5 = $_POST['numeracion_final'];
				$j6 = $_POST['diferencia'];
				$j7 = ($j5 - $j6);
				$j8 = ($j5 - $j6);


				if ($j8 >= 1 & $j8 < 10) {
					$sell->factura = $j1 . "-" . "000000" . $j8;
				} else {
					if ($j8 >= 10 & $j8 < 100) {
						$sell->factura = $j1 . "-" . "00000" . $j8;
					} else {
						if ($j8 >= 100 & $j8 < 1000) {
							$sell->factura = $j1 . "-" . "0000" . $j8;
						} else {
							if ($j8 >= 1000 & $j8 < 10000) {
								$sell->factura = $j1 . "-" . "000" . $j8;
							} else {
								if ($j8 >= 100000 & $j8 < 1000000) {
									$sell->factura = $j1 . "-" . "00" . $j8;
								} else {
									if ($j8 >= 1000000 & $j8 < 10000000) {
										$sell->factura = $j1 . "-" . "0" . $j8;
									} else {
									}
								}
							}
						}
					}
				}





				//$sell->factura =$j1."".$j2.""."000000".$j7;
				$sell->configfactura_id = $_POST["configfactura_id"];
				$sell->tipomoneda_id = trim($_POST["idtipomoneda"]);



				//inicio consulta tipo moneda








				$sell->cambio = $_POST["cambio"];
				$sell->cambio2 = $_POST["cambio2"];
				$sell->simbolo2 = $_POST["simbolo2"];

				$sell->formapago = $_POST["formapago"];
				$sell->codigo = $_POST["codigo"];
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
				$sell->cantidaconfigmasiva = $_POST["cantidaconfigmasiva"];
				$s = 0;
				if (isset($_POST["cliente_id"]) && $_POST["cliente_id"] != "") {
					$sell->cliente_id = $_POST["cliente_id"];
					$s = $sell->venta_producto_cliente1();
				} else {
					$s = $sell->add1();
				}
				foreach ($cart as  $c2) {

					$op = new OperationData1();
					$op->producto_id = $c2["producto_id"];
					$op->accion_id = AccionData::getByName("salida")->id_accion;
					$op->venta_id = $s[1];
					$op->precio1 = $c2["precios"];
					$b = $_POST["sucursal_id"];
					// $ptot =  str_replace(',', '', $_POST["precio_total_"]);


					$stc = $_POST["stock_trans"];
					$op->stock_trans = $stc;
					$op->motivo = "VENTA" . " " . $s[1];


					//este me registra el total final en todo

					$op->sucursal_id = $b;
					$op->q = $c2["q"];
					$op->precio = $c2["precio"];

					if (isset($_POST["is_oficiall"])) {
						$op->is_oficiall = 1;
					}

					$add = $op->registro_producto1();

					// 
					// 
					unset($_SESSION["cart"]);
					setcookie("selled", "selled");
				}
				if (count($_POST) > 0) {
					$configuracionfactura = ConfigFacturaData::VerId($_POST["id_configfactura"]);
					$jl1 = $_POST["diferencia"];
					$jl2 = $s[1];
					$configuracionfactura->diferencia = ($jl1 - 1);
					$configuracionfactura->actualizardiferencia();
				}
				if ($_POST["metodopago"] == "Credito") {
					$fecha_actual = date("d-m-Y");
					$vence = date("Y-m-d", strtotime($fecha_actual . "+ " . $_POST['vencimiento'] . " days"));
					$credito = new CreditoData();
					$credito->sucursalId = $_POST["sucursal_id"];
					$credito->monedaId = trim($_POST["idtipomoneda"]);
					$credito->concepto = $_POST["concepto"];
					$credito->credito = str_replace(',', '', $_POST['total']);
					$credito->cuotas = $_POST['cuotas'];
					$credito->abonado = 0;
					$credito->vencimiento = $vence;
					$credito->ventaId = $s[1];
					$cre = $credito->registrar_credito();
					for ($i = 1; $i < $_POST['cuotas'] + 1; $i++) {
						$detalle = new CreditoDetalleData();

						if ($i == 1) {
						} else {
							$vence = date("Y-m-d", strtotime($vence . "+ " . $_POST['vencimiento'] . " days"));
						}
						$detalle->fechaDetalle = $vence . '';
						$detalle->cuota = $i;
						$detalle->creditoId = $cre[1];
						$detalle->recibido = str_replace(',', '', $_POST['total']) / $_POST['cuotas'];
						$detalle->moneda = 0;
						$d = $detalle->registrar_credito_detalle();
						$detalleCobro = new CobroDetalleData();
						$detalleCobro->creditoDetalle = $d[1];
						$detalleCobro->registrar_credito();
					}
					$cuotas = $_POST['cuotas'];
					print "<script>window.location='index.php?view=creditodetalle&id=$cre[1]&id_venta=$s[1]';</script>";
				}



				////////////////////
				Core::alert("EL REGISTRO DE REMISIÓN HA SIDO TODO UN ÉXITO.....!");
				Core::redir("index.php?view=vender&id_sucursal=" . $_POST["sucursal_id"]);
			}

			// ---------------------------
		}
	}
} else {
	if (isset($_SESSION["cart"])) {
		$cart = $_SESSION["cart"];
		if (count($cart) > 0) {
			$num_succ = 0;
			$process = false;
			$errors = array();
			foreach ($cart as $c2) {
				$q = OperationData::getQYesFf($c2["producto_id"]);
				if ($c2["q"] <= $q) {
					if (isset($_POST["is_oficiall"])) {
						$qyf = OperationData::getQYesFf($c2["producto_id"]); /// son los productos que puedo facturar
						if ($c2["q"] <= $qyf) {
							$num_succ++;
						} else {
							$error = array("producto_id" => $c2["producto_id"], "message" => "No hay suficiente cantidad de producto para facturar en inventario.");
							$errors[count($errors)] = $error;
						}
					} else {
						// si llegue hasta aqui y no voy a facturar, entonces continuo ...
						$num_succ++;
					}
				} else {
					$error = array("producto_id" => $c2["producto_id"], "message" => "No hay suficiente cantidad de producto en inventario.");
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
			if ($process == true) {
				$sell = new VentaData1();
				$sell->usuario_id = $_SESSION["admin_id"];
				$sell->presupuesto = $_POST["presupuesto"];
				$j1 = $_POST['serie1'];
				$j2 = "-";
				$j5 = $_POST['numeracion_final'];
				$j6 = $_POST['diferencia'];
				$j7 = ($j5 - $j6);
				$j8 = ($j5 - $j6);


				if ($j8 >= 1 & $j8 < 10) {
					$sell->factura = $j1 . "-" . "000000" . $j8;
				} else {
					if ($j8 >= 10 & $j8 < 100) {
						$sell->factura = $j1 . "-" . "00000" . $j8;
					} else {
						if ($j8 >= 100 & $j8 < 1000) {
							$sell->factura = $j1 . "-" . "0000" . $j8;
						} else {
							if ($j8 >= 1000 & $j8 < 10000) {
								$sell->factura = $j1 . "-" . "000" . $j8;
							} else {
								if ($j8 >= 100000 & $j8 < 1000000) {
									$sell->factura = $j1 . "-" . "00" . $j8;
								} else {
									if ($j8 >= 1000000 & $j8 < 10000000) {
										$sell->factura = $j1 . "-" . "0" . $j8;
									} else {
									}
								}
							}
						}
					}
				}

				$sell->configfactura_id = $_POST["configfactura_id"];
				$sell->tipomoneda_id = trim($_POST["idtipomoneda"]);

				$sell->cambio = $_POST["cambio"];
				$sell->cambio2 = $_POST["cambio2"];
				$sell->simbolo2 = $_POST["simbolo2"];

				$sell->formapago = $_POST["formapago"];
				$sell->codigo = $_POST["codigo"];
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
				$sell->cantidaconfigmasiva = $_POST["cantidaconfigmasiva"];
				$s = 0;
				if (isset($_POST["cliente_id"]) && $_POST["cliente_id"] != "") {
					$sell->cliente_id = $_POST["cliente_id"];
					$s = $sell->venta_producto_cliente1();
				} else {
					$s = $sell->add1();
				}
				foreach ($cart as  $c2) {

					$op = new OperationData1();
					$op->producto_id = $c2["producto_id"];
					$op->accion_id = AccionData::getByName("salida")->id_accion;
					$op->venta_id = $s[1];
					$op->precio1 = $c2["precios"];
					$b = $_POST["sucursal_id"];
					// $ptot =  str_replace(',', '', $_POST["precio_total_"]);


					$stc = $_POST["stock_trans"];
					$op->stock_trans = $stc;
					$op->motivo = "VENTA" . " " . $s[1];


					//este me registra el total final en todo

					$op->sucursal_id = $b;
					$op->q = $c2["q"];
					$op->precio = $c2["precio"];

					if (isset($_POST["is_oficiall"])) {
						$op->is_oficiall = 1;
					}

					$add = $op->registro_producto1();

					// 

					// 
					unset($_SESSION["cart"]);
					setcookie("selled", "selled");
				}
				if (count($_POST) > 0) {
					$configuracionfactura = ConfigFacturaData::VerId($_POST["id_configfactura"]);
					$jl1 = $_POST["diferencia"];
					$jl2 = $s[1];
					$configuracionfactura->diferencia = ($jl1 - 1);
					$configuracionfactura->actualizardiferencia();
				}
				if ($_POST["metodopago"] == "Credito") {
					$fecha_actual = date("d-m-Y");
					$vence = date("Y-m-d", strtotime($fecha_actual . "+ " . $_POST['vencimiento'] . " days"));
					$credito = new CreditoData();
					$credito->sucursalId = $_POST["sucursal_id"];
					$credito->monedaId = trim($_POST["idtipomoneda"]);
					$credito->concepto = $_POST["concepto"];
					$credito->credito = str_replace(',', '', $_POST['total']);
					$credito->cuotas = $_POST['cuotas'];
					$credito->abonado = 0;
					$credito->vencimiento = $vence;
					$credito->ventaId = $s[1];
					$cre = $credito->registrar_credito();
					for ($i = 1; $i < $_POST['cuotas'] + 1; $i++) {
						$detalle = new CreditoDetalleData();

						if ($i == 1) {
						} else {
							$vence = date("Y-m-d", strtotime($vence . "+ " . $_POST['vencimiento'] . " days"));
						}
						$detalle->fechaDetalle = $vence . '';
						$detalle->cuota = $i;
						$detalle->creditoId = $cre[1];
						$detalle->recibido = str_replace(',', '', $_POST['total']) / $_POST['cuotas'];
						$detalle->moneda = 0;
						$d = $detalle->registrar_credito_detalle();
						$detalleCobro = new CobroDetalleData();
						$detalleCobro->creditoDetalle = $d[1];
						$detalleCobro->registrar_credito();
					}
					$cuotas = $_POST['cuotas'];
					Core::redir("index.php?view=remision&id_sucursal=" . $_POST["sucursal_id"]);
				}



				////////////////////
				Core::alert("EL REGISTRO DE REMISIÓN HA SIDO TODO UN ÉXITO.....!");
				Core::redir("index.php?view=remision&id_sucursal=" . $_POST["sucursal_id"]);
			}
		}
	}
}
?>