<?php

$c = VentaData2::getNombre($_POST["facturan"], $_POST["sucursal_id"]);

if ($c == null) {

    $remision_id = $_POST["remision_id"];
    $cart = $_POST["cart"];
    $sumatotal = 0;
    if ($remision_id == 0) {

        $tipoproducto = $cart[0]["tipo"];
        if ($tipoproducto == "Servicio") {

            if (isset($_POST["cart"])) {
                if (count($cart) > 0) {
                    $num_succ = 0;
                    $process = false;
                    $errors = array();
                    foreach ($cart as $c2) {
                        // $q = 2;
                        // if ($c2["cantidad"] <= $q) {
                        //     if (isset($_POST["is_oficiall"])) {
                        //         $qyf = 2;
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
                        //     $error = array("id" => $c2["id"], "message" => "No hay suficiente cantidad de producto en inventario.");
                        //     $errors[count($errors)] = $error;
                        // }
                        $num_succ++;
                    }
                    $sell = new VentaData2();
                    $sell->usuario_id = $_SESSION["admin_id"];
                    $sell->presupuesto = $_POST["presupuesto"];
                    $sell->REMISION_ID = $_POST["remision_id"];
                    $j1 = $_POST['serie1'];
                    $j2 = "-";
                    $j5 = $_POST['numeracion_final'];
                    $j6 = $_POST['diferencia'];
                    $j7 = ($j5 - $j6);
                    $j8 = ($j5 - $j6);
                    $sell->factura = $_POST['facturan'];
                    $nrofactura = $_POST['facturan'];
                    // $nrofactura = "";

                    // if ($j8 >= 1 & $j8 < 10) {
                    //     $nrofactura = $sell->factura = $j1 . "-" . "000000" . $j8;
                    // } else {
                    //     if ($j8 >= 10 & $j8 < 100) {
                    //         $nrofactura = $sell->factura = $j1 . "-" . "00000" . $j8;
                    //     } else {
                    //         if ($j8 >= 100 & $j8 < 1000) {
                    //             $nrofactura = $sell->factura = $j1 . "-" . "0000" . $j8;
                    //         } else {
                    //             if ($j8 >= 1000 & $j8 < 10000) {
                    //                 $nrofactura = $sell->factura = $j1 . "-" . "000" . $j8;
                    //             } else {
                    //                 if ($j8 >= 100000 & $j8 < 1000000) {
                    //                     $nrofactura = $sell->factura = $j1 . "-" . "00" . $j8;
                    //                 } else {
                    //                     if ($j8 >= 1000000 & $j8 < 10000000) {
                    //                         $nrofactura = $sell->factura = $j1 . "-" . "0" . $j8;
                    //                     } else {
                    //                     }
                    //                 }
                    //             }
                    //         }
                    //     }
                    // }

                    $sell->configfactura_id = $_POST["configfactura_id"];
                    $sell->tipomoneda_id = trim($_POST["idtipomoneda"]);

                    $sell->cambio = $_POST["cambio"];
                    $sell->cambio2 = $_POST["cambio2"];
                    $sell->simbolo2 = $_POST["simbolo2"];

                    $sell->formapago = $_POST["formapago"];
                    $sell->codigo = $_POST["codigo"];
                    $sell->fechapago = date('Y-m-d', strtotime($_POST['fecha']));
                    $sell->metodopago = $_POST["metodopago"];
                    $sell->total10 = str_replace(',', '', $_POST["total10"]);
                    $sell->iva10 = str_replace(',', '', $_POST["iva10"]);
                    $sell->total5 = str_replace(',', '', $_POST["total5"]);
                    $sell->iva5 = str_replace(',', '', $_POST["iva5"]);
                    $sell->exenta = str_replace(',', '', $_POST["exenta"]);
                    $a1 = $_POST['total'];
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

                        $op = new OperationData();
                        $op->producto_id = $c2["id"];
                        $op->fecha = $_POST["fecha"];
                        $op->accion_id = AccionData::getByName("salida")->id_accion;
                        $op->venta_id = $s[1];
                        $op->precio1 = $c2["precioc"];
                        $b = $_POST["sucursal_id"];


                        $stc = $_POST["stock_trans"];
                        $op->stock_trans = $stc;
                        $op->motivo = "VENTA" . " " . $s[1];



                        $op->sucursal_id = $b;
                        $op->q = $c2["cantidad"];
                        $op->precio = $c2["precio"];

                        if (isset($_POST["is_oficiall"])) {
                            $op->is_oficiall = 1;
                        }
                        $op->deposito = $c2["deposito"];
                        $op->deposito_nombre = $c2["depositotext"];
                        $add = $op->registro_producto1();

                        // $actualizar = new StockData();
                        // $resta = $c2["stock"] - $c2["cantidad"];
                        // $actualizar->CANTIDAD_STOCK =    $resta;
                        // $actualizar->PRODUCTO_ID = $c2["id"];
                        // $actualizar->DEPOSITO_ID = $c2["deposito"];
                        // $ac = $actualizar->actualizar2();
                    }
                    if (count($_POST) > 0) {
                        $configuracionfactura = ConfigFacturaData::VerId($_POST["id_configfactura"]);
                        $jl1 = $_POST["diferencia"];
                        $jl2 = $s[1];
                        $configuracionfactura->diferencia = ($jl1 - 1);
                        $configuracionfactura->actualizardiferencia();
                    }
                    if ($_POST["metodopago"] == "Credito") {
                        $fecha_actual = $_POST['fecha'];



                        $vence = date("Y-m-d", strtotime($fecha_actual . "+ " . $_POST['vencimiento'] . " days"));
                        $credito = new CreditoData();
                        $credito->sucursalId = $_POST["sucursal_id"];
                        $credito->monedaId = trim($_POST["idtipomoneda"]);
                        $credito->concepto = $_POST["concepto"];
                        $credito->credito = str_replace(',', '', $_POST['total']);
                        $credito->cuotas = $_POST['cuotas'];
                        $credito->abonado = 0;
                        $credito->vencimiento = $vence;
                        $credito->fecha = $fecha_actual;

                        $credito->cliente_id = $_POST["cliente_id"];
                        $credito->ventaId = $s[1];
                        $cre = $credito->registrar_credito();
                        $clientss = $_POST["cliente_id"];
                        for ($i = 1; $i < $_POST['cuotas'] + 1; $i++) {
                            $detalle = new CreditoDetalleData();

                            if ($i == 1) {
                            } else {
                                $vence = date("Y-m-d", strtotime($vence . "+ " . $_POST['vencimiento'] . " days"));
                            }
                            $detalle->fechaDetalle = $vence . '';
                            $detalle->cuota = $i;
                            $detalle->creditoId = $cre[1];
                            $detalle->sucursalId = $_POST["sucursal_id"];
                            $detalle->factura = $nrofactura;
                            $detalle->fecha = $fecha_actual;

                            $detalle->monedaId = trim($_POST["idtipomoneda"]);
                            $detalle->cliente_id = $_POST["cliente_id"];
                            $detalle->recibido = str_replace(',', '', $_POST['total']) / $_POST['cuotas'];
                            $detalle->moneda = 0;
                            $d = $detalle->registrar_credito_detalle();
                            $detalleCobro = new CobroDetalleData();
                            $detalleCobro->creditoDetalle = $d[1];
                            $detalleCobro->registrar_credito();
                        }
                        $cuotas = $_POST['cuotas'];
                        header("Content-type:application/json");
                        $jsdata = json_decode(file_get_contents('php://input'), true);
                        header("HTTP/1.1 200 OK");
                        header('Content-Type: text/plain');
                        echo json_encode($s[1]);
                        // Core::redir("index.php?view=vender&id_sucursal=" . $_POST["sucursal_id"]);
                    } else {
                        // 
                        // 
                        // 
                        // 

                        $registro1 = new CobroCabecera();


                        $j1 = $_POST['serie1'];
                        $j2 = "-";
                        $j5 = $_POST['numeracion_final'];
                        $j6 = $_POST['diferencia'];
                        $j7 = ($j5 - $j6);
                        $j8 = ($j5 - $j6);
                        $nrofactura = "";
                        $sell->factura = $_POST['facturan'];
                        $nrofactura = $_POST['facturan'];
                        // if (
                        //     $j8 >= 1 & $j8 < 10
                        // ) {
                        //     $nrofactura = $sell->factura = $j1 . "-" . "000000" . $j8;
                        // } else {
                        //     if (
                        //         $j8 >= 10 & $j8 < 100
                        //     ) {
                        //         $nrofactura = $j1 . "-" . "00000" . $j8;
                        //     } else {
                        //         if ($j8 >= 100 & $j8 < 1000) {
                        //             $nrofactura = $j1 . "-" . "0000" . $j8;
                        //         } else {
                        //             if (
                        //                 $j8 >= 1000 & $j8 < 10000
                        //             ) {
                        //                 $nrofactura = $j1 . "-" . "000" . $j8;
                        //             } else {
                        //                 if ($j8 >= 100000 & $j8 < 1000000) {
                        //                     $nrofactura = $j1 . "-" . "00" . $j8;
                        //                 } else {
                        //                     if ($j8 >= 1000000 & $j8 < 10000000) {
                        //                         $nrofactura = $j1 . "-" . "0" . $j8;
                        //                     } else {
                        //                     }
                        //                 }
                        //             }
                        //         }
                        //     }
                        // }



                        if (
                            count($_POST) > 0
                        ) {
                            $configuracionfactura = ConfigFacturaData::VerId($_POST["id_configfactura"]);
                            $jl1 = $_POST["diferencia"];
                            //$jl2 = $s[1];
                            $configuracionfactura->diferencia = ($jl1 - 1);
                            $configuracionfactura->actualizardiferencia();
                        }

                        $registro1->RECIBO = $nrofactura;
                        $registro1->configfactura_id = $_POST["configfactura_id"];
                        $registro1->CLIENTE_ID = $_POST["cliente_id"];
                        $registro1->TOTAL_COBRO = $_POST['total'];
                        $registro1->SUCURSAL_ID = $_POST["sucursal_id"];
                        $registro1->FECHA_COBRO = $_POST['fecha'];
                        $registro1->MONEDA_ID = $_POST["idtipomoneda"];

                        $id_cobro = $registro1->registro();


                        // inicio Registro de detalle


                        $saldo = 0;
                        $monto = $_POST["total"];
                        $suma = 0;
                        // $factura = $_POST["factura"];
                        $couta = 1;
                        $credito = $s[1];
                        $cliente = $_POST["cliente_id"];
                        $importecred = $_POST["total"];
                        $sucursall = $_POST["sucursal_id"];

                        $cobrosrealizados = $_POST['tablaCobro'];
                        $i = 0;
                        foreach ($cobrosrealizados as $cobroh) {
                            $i = $i + 1;
                            $registro2 = new CobroDetalleData();
                            $registro2->COBRO_ID = $id_cobro[1];
                            $registro2->NUMERO_FACTURA = $nrofactura;
                            $registro2->CUOTA = $i;
                            $registro2->NUMERO_CREDITO = $credito;
                            $registro2->CLIENTE_ID = $cliente;     // probar id cliente si carga bien
                            $registro2->IMPORTE_COBRO = $cobroh['monto2'];
                            $registro2->IMPORTE_CREDITO = $importecred;
                            $registro2->tipo = 1;
                            $registro2->SUCURSAL_ID = $sucursall;
                            $registro2->registro();
                        }
                        header("Content-type:application/json");
                        $jsdata = json_decode(file_get_contents('php://input'), true);
                        header("HTTP/1.1 200 OK");
                        header('Content-Type: text/plain');
                        echo json_encode($s[1]);
                    }
                }
            }
        }
        if ($tipoproducto == "Contrato") {

            if (isset($_POST["cart"])) {
                if (count($cart) > 0) {
                    $num_succ = 0;
                    $process = false;
                    $errors = array();
                    foreach ($cart as $c2) {
                        // $q = 2;
                        // if ($c2["cantidad"] <= $q) {
                        //     if (isset($_POST["is_oficiall"])) {
                        //         $qyf = 2;
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
                        //     $error = array("id" => $c2["id"], "message" => "No hay suficiente cantidad de producto en inventario.");
                        //     $errors[count($errors)] = $error;
                        // }
                        $num_succ++;
                    }
                    $sell = new VentaData2();
                    $sell->usuario_id = $_SESSION["admin_id"];
                    $sell->presupuesto = $_POST["presupuesto"];
                    $sell->REMISION_ID = $_POST["remision_id"];
                    $j1 = $_POST['serie1'];
                    $j2 = "-";
                    $j5 = $_POST['numeracion_final'];
                    $j6 = $_POST['diferencia'];
                    $j7 = ($j5 - $j6);
                    $j8 = ($j5 - $j6);
                    $sell->factura = $_POST['facturan'];
                    $nrofactura = $_POST['facturan'];
                    // $nrofactura = "";

                    // if ($j8 >= 1 & $j8 < 10) {
                    //     $nrofactura = $sell->factura = $j1 . "-" . "000000" . $j8;
                    // } else {
                    //     if ($j8 >= 10 & $j8 < 100) {
                    //         $nrofactura = $sell->factura = $j1 . "-" . "00000" . $j8;
                    //     } else {
                    //         if ($j8 >= 100 & $j8 < 1000) {
                    //             $nrofactura = $sell->factura = $j1 . "-" . "0000" . $j8;
                    //         } else {
                    //             if ($j8 >= 1000 & $j8 < 10000) {
                    //                 $nrofactura = $sell->factura = $j1 . "-" . "000" . $j8;
                    //             } else {
                    //                 if ($j8 >= 100000 & $j8 < 1000000) {
                    //                     $nrofactura = $sell->factura = $j1 . "-" . "00" . $j8;
                    //                 } else {
                    //                     if ($j8 >= 1000000 & $j8 < 10000000) {
                    //                         $nrofactura = $sell->factura = $j1 . "-" . "0" . $j8;
                    //                     } else {
                    //                     }
                    //                 }
                    //             }
                    //         }
                    //     }
                    // }

                    $sell->configfactura_id = $_POST["configfactura_id"];
                    $sell->tipomoneda_id = trim($_POST["idtipomoneda"]);

                    $sell->cambio = $_POST["cambio"];
                    $sell->cambio2 = $_POST["cambio2"];
                    $sell->simbolo2 = $_POST["simbolo2"];

                    $sell->formapago = $_POST["formapago"];
                    $sell->codigo = $_POST["codigo"];
                    $sell->fechapago = date('Y-m-d', strtotime($_POST['fecha']));
                    $sell->metodopago = $_POST["metodopago"];
                    $sell->total10 = str_replace(',', '', $_POST["total10"]);
                    $sell->iva10 = str_replace(',', '', $_POST["iva10"]);
                    $sell->total5 = str_replace(',', '', $_POST["total5"]);
                    $sell->iva5 = str_replace(',', '', $_POST["iva5"]);
                    $sell->exenta = str_replace(',', '', $_POST["exenta"]);
                    $a1 = $_POST['total'];
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
                        $productod = new ProductoData();
                        $productod->id = $c2['id'];
                        $productod->precio = $c2['precio'];
                        $pr = $productod->actualizar_contrato();
                        var_dump($pr);
                        $op = new OperationData();
                        $op->producto_id = $c2["id"];
                        $op->fecha = $_POST["fecha"];
                        $op->accion_id = AccionData::getByName("salida")->id_accion;
                        $op->venta_id = $s[1];
                        $op->precio1 = $c2["precioc"];
                        $b = $_POST["sucursal_id"];


                        $stc = $_POST["stock_trans"];
                        $op->stock_trans = $stc;
                        $op->motivo = "VENTA" . " " . $s[1];



                        $op->sucursal_id = $b;
                        $op->q = $c2["cantidad"];
                        $op->precio = $c2["precio"];

                        if (isset($_POST["is_oficiall"])) {
                            $op->is_oficiall = 1;
                        }
                        $op->deposito = $c2["deposito"];
                        $op->deposito_nombre = $c2["depositotext"];
                        $add = $op->registro_producto1();

                        // $actualizar = new StockData();
                        // $resta = $c2["stock"] - $c2["cantidad"];
                        // $actualizar->CANTIDAD_STOCK =    $resta;
                        // $actualizar->PRODUCTO_ID = $c2["id"];
                        // $actualizar->DEPOSITO_ID = $c2["deposito"];
                        // $ac = $actualizar->actualizar2();
                    }
                    if (count($_POST) > 0) {
                        $configuracionfactura = ConfigFacturaData::VerId($_POST["id_configfactura"]);
                        $jl1 = $_POST["diferencia"];
                        $jl2 = $s[1];
                        $configuracionfactura->diferencia = ($jl1 - 1);
                        $configuracionfactura->actualizardiferencia();
                    }
                    if ($_POST["metodopago"] == "Credito") {
                        $fecha_actual = $_POST['fecha'];



                        $vence = date("Y-m-d", strtotime($fecha_actual . "+ " . $_POST['vencimiento'] . " days"));
                        $credito = new CreditoData();
                        $credito->sucursalId = $_POST["sucursal_id"];
                        $credito->monedaId = trim($_POST["idtipomoneda"]);
                        $credito->concepto = $_POST["concepto"];
                        $credito->credito = str_replace(',', '', $_POST['total']);
                        $credito->cuotas = $_POST['cuotas'];
                        $credito->abonado = 0;
                        $credito->vencimiento = $vence;
                        $credito->fecha = $fecha_actual;

                        $credito->cliente_id = $_POST["cliente_id"];
                        $credito->ventaId = $s[1];
                        $cre = $credito->registrar_credito();
                        $clientss = $_POST["cliente_id"];
                        for ($i = 1; $i < $_POST['cuotas'] + 1; $i++) {
                            $detalle = new CreditoDetalleData();

                            if ($i == 1) {
                            } else {
                                $vence = date("Y-m-d", strtotime($vence . "+ " . $_POST['vencimiento'] . " days"));
                            }
                            $detalle->fechaDetalle = $vence . '';
                            $detalle->cuota = $i;
                            $detalle->creditoId = $cre[1];
                            $detalle->sucursalId = $_POST["sucursal_id"];
                            $detalle->factura = $nrofactura;
                            $detalle->fecha = $fecha_actual;

                            $detalle->monedaId = trim($_POST["idtipomoneda"]);
                            $detalle->cliente_id = $_POST["cliente_id"];
                            $detalle->recibido = str_replace(',', '', $_POST['total']) / $_POST['cuotas'];
                            $detalle->moneda = 0;
                            $d = $detalle->registrar_credito_detalle();
                            $detalleCobro = new CobroDetalleData();
                            $detalleCobro->creditoDetalle = $d[1];
                            $detalleCobro->registrar_credito();
                        }
                        $cuotas = $_POST['cuotas'];
                        header("Content-type:application/json");
                        $jsdata = json_decode(file_get_contents('php://input'), true);
                        header("HTTP/1.1 200 OK");
                        header('Content-Type: text/plain');
                        echo json_encode($s[1]);
                        // Core::redir("index.php?view=vender&id_sucursal=" . $_POST["sucursal_id"]);
                    } else {
                        // 
                        // 
                        // 
                        // 

                        $registro1 = new CobroCabecera();


                        $j1 = $_POST['serie1'];
                        $j2 = "-";
                        $j5 = $_POST['numeracion_final'];
                        $j6 = $_POST['diferencia'];
                        $j7 = ($j5 - $j6);
                        $j8 = ($j5 - $j6);
                        $nrofactura = "";
                        $sell->factura = $_POST['facturan'];
                        $nrofactura = $_POST['facturan'];
                        // if (
                        //     $j8 >= 1 & $j8 < 10
                        // ) {
                        //     $nrofactura = $sell->factura = $j1 . "-" . "000000" . $j8;
                        // } else {
                        //     if (
                        //         $j8 >= 10 & $j8 < 100
                        //     ) {
                        //         $nrofactura = $j1 . "-" . "00000" . $j8;
                        //     } else {
                        //         if ($j8 >= 100 & $j8 < 1000) {
                        //             $nrofactura = $j1 . "-" . "0000" . $j8;
                        //         } else {
                        //             if (
                        //                 $j8 >= 1000 & $j8 < 10000
                        //             ) {
                        //                 $nrofactura = $j1 . "-" . "000" . $j8;
                        //             } else {
                        //                 if ($j8 >= 100000 & $j8 < 1000000) {
                        //                     $nrofactura = $j1 . "-" . "00" . $j8;
                        //                 } else {
                        //                     if ($j8 >= 1000000 & $j8 < 10000000) {
                        //                         $nrofactura = $j1 . "-" . "0" . $j8;
                        //                     } else {
                        //                     }
                        //                 }
                        //             }
                        //         }
                        //     }
                        // }



                        if (
                            count($_POST) > 0
                        ) {
                            $configuracionfactura = ConfigFacturaData::VerId($_POST["id_configfactura"]);
                            $jl1 = $_POST["diferencia"];
                            //$jl2 = $s[1];
                            $configuracionfactura->diferencia = ($jl1 - 1);
                            $configuracionfactura->actualizardiferencia();
                        }

                        $registro1->RECIBO = $nrofactura;
                        $registro1->configfactura_id = $_POST["configfactura_id"];
                        $registro1->CLIENTE_ID = $_POST["cliente_id"];
                        $registro1->TOTAL_COBRO = $_POST['total'];
                        $registro1->SUCURSAL_ID = $_POST["sucursal_id"];
                        $registro1->FECHA_COBRO = $_POST['fecha'];
                        $registro1->MONEDA_ID = $_POST["idtipomoneda"];

                        $id_cobro = $registro1->registro();


                        // inicio Registro de detalle


                        $saldo = 0;
                        $monto = $_POST["total"];
                        $suma = 0;
                        // $factura = $_POST["factura"];
                        $couta = 1;
                        $credito = $s[1];
                        $cliente = $_POST["cliente_id"];
                        $importecred = $_POST["total"];
                        $sucursall = $_POST["sucursal_id"];

                        $cobrosrealizados = $_POST['tablaCobro'];
                        $i = 0;
                        foreach ($cobrosrealizados as $cobroh) {
                            $i = $i + 1;
                            $registro2 = new CobroDetalleData();
                            $registro2->COBRO_ID = $id_cobro[1];
                            $registro2->NUMERO_FACTURA = $nrofactura;
                            $registro2->CUOTA = $i;
                            $registro2->NUMERO_CREDITO = $credito;
                            $registro2->CLIENTE_ID = $cliente;     // probar id cliente si carga bien
                            $registro2->IMPORTE_COBRO = $cobroh['monto2'];
                            $registro2->IMPORTE_CREDITO = $importecred;
                            $registro2->tipo = 1;
                            $registro2->SUCURSAL_ID = $sucursall;
                            $registro2->registro();
                        }
                        header("Content-type:application/json");
                        $jsdata = json_decode(file_get_contents('php://input'), true);
                        header("HTTP/1.1 200 OK");
                        header('Content-Type: text/plain');
                        echo json_encode($s[1]);
                    }
                }
            }
        } else {

            if (isset($_POST["cart"])) {

                $cart = $_POST["cart"];

                if (count($cart) > 0) {
                    $num_succ = 0;
                    $process = false;
                    $errors = array();
                    foreach ($cart as $c2) {
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
                    $process = true;
                    if ($num_succ == count($cart)) {


                        $process = true;
                    } else {
                        echo -1;
                    }
                }

                if ($process == true) {
                    $sell = new VentaData2();

                    $sell->usuario_id = $_SESSION["admin_id"];
                    $sell->presupuesto = $_POST["presupuesto"];
                    $sell->REMISION_ID = $_POST["remision_id"];
                    $j1 = $_POST['serie1'];
                    $j2 = "-";
                    $j5 = $_POST['numeracion_final'];
                    $j6 = $_POST['diferencia'];
                    $j7 = ($j5 - $j6);
                    $j8 = ($j5 - $j6);
                    $nrofactura = "";
                    $sell->factura = $_POST['facturan'];
                    $nrofactura = $_POST['facturan'];
                    // if ($j8 >= 1 & $j8 < 10) {
                    //     $nrofactura = $sell->factura = $j1 . "-" . "000000" . $j8;
                    // } else {
                    //     if ($j8 >= 10 & $j8 < 100) {
                    //         $nrofactura = $sell->factura = $j1 . "-" . "00000" . $j8;
                    //     } else {
                    //         if ($j8 >= 100 & $j8 < 1000) {
                    //             $nrofactura = $sell->factura = $j1 . "-" . "0000" . $j8;
                    //         } else {
                    //             if ($j8 >= 1000 & $j8 < 10000) {
                    //                 $nrofactura = $sell->factura = $j1 . "-" . "000" . $j8;
                    //             } else {
                    //                 if ($j8 >= 100000 & $j8 < 1000000) {
                    //                     $nrofactura = $sell->factura = $j1 . "-" . "00" . $j8;
                    //                 } else {
                    //                     if ($j8 >= 1000000 & $j8 < 10000000) {
                    //                         $nrofactura = $sell->factura = $j1 . "-" . "0" . $j8;
                    //                     } else {
                    //                     }
                    //                 }
                    //             }
                    //         }
                    //     }
                    // }

                    $sell->configfactura_id = $_POST["configfactura_id"];
                    $sell->tipomoneda_id = trim($_POST["idtipomoneda"]);

                    $sell->cambio = $_POST["cambio"];
                    $sell->cambio2 = $_POST["cambio2"];
                    $sell->simbolo2 = $_POST["simbolo2"];

                    $sell->formapago = $_POST["formapago"];
                    $sell->codigo = $_POST["codigo"];
                    $sell->fechapago = date('Y-m-d', strtotime($_POST['fecha']));
                    $sell->metodopago = $_POST["metodopago"];
                    $sell->total10 = str_replace(',', '', $_POST["total10"]);
                    $sell->iva10 = str_replace(',', '', $_POST["iva10"]);
                    $sell->total5 = str_replace(',', '', $_POST["total5"]);
                    $sell->iva5 = str_replace(',', '', $_POST["iva5"]);
                    $sell->exenta = str_replace(',', '', $_POST["exenta"]);
                    $a1 = $_POST['total'];
                    $sell->total = str_replace(',', '', $a1);
                    $sell->n = 1;
                    $sell->numerocorraltivo = $j8;
                    $a = $_POST["sucursal_id"];
                    $sell->sucursal_id = $a;
                    $sell->fecha = $_POST["fecha"];
                    $sell->cantidaconfigmasiva = $_POST["cantidaconfigmasiva"];
                    $s = 0;
                    $sell->cliente_id = $_POST["cliente_id"];
                    $s = $sell->venta_producto_cliente1();
                    foreach ($cart as  $c2) {

                        $op = new OperationData();
                        $op->producto_id = $c2["id"];
                        $op->fecha = $_POST["fecha"];
                        $op->accion_id = AccionData::getByName("salida")->id_accion;
                        $op->venta_id = $s[1];
                        $op->precio1 = $c2["precioc"];
                        $b = $_POST["sucursal_id"];


                        $stc = $_POST["stock_trans"];
                        $op->stock_trans = $stc;
                        $op->motivo = "VENTA" . " " . $s[1];



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
                    if ($_POST["metodopago"] == "Credito") {
                        $fecha_actual = $_POST['fecha'];
                        $vence = date("Y-m-d", strtotime($fecha_actual . "+ " . $_POST['vencimiento'] . " days"));
                        $credito = new CreditoData();
                        $credito->sucursalId = $_POST["sucursal_id"];
                        $credito->monedaId = trim($_POST["idtipomoneda"]);
                        $credito->concepto = $_POST["concepto"];
                        $credito->credito = str_replace(',', '', $_POST['total']);
                        $credito->cuotas = $_POST['cuotas'];
                        $credito->abonado = 0;
                        $credito->cliente_id = $_POST["cliente_id"];
                        $credito->vencimiento = $vence;
                        $credito->fecha = $fecha_actual;

                        $credito->ventaId = $s[1];
                        $cre = $credito->registrar_credito();
                        $clientss = $_POST["cliente_id"];
                        for ($i = 1; $i < $_POST['cuotas'] + 1; $i++) {
                            $detalle = new CreditoDetalleData();

                            if ($i == 1) {
                            } else {
                                $vence = date("Y-m-d", strtotime($vence . "+ " . $_POST['vencimiento'] . " days"));
                            }
                            $detalle->fechaDetalle = $vence . '';
                            $detalle->cuota = $i;
                            $detalle->creditoId = $cre[1];
                            $detalle->sucursalId = $_POST["sucursal_id"];
                            $detalle->factura = $nrofactura;

                            $detalle->fecha = $fecha_actual;

                            $detalle->monedaId = trim($_POST["idtipomoneda"]);
                            $detalle->cliente_id = $_POST["cliente_id"];

                            $detalle->recibido = str_replace(',', '', $_POST['total']) / $_POST['cuotas'];
                            $detalle->moneda = 0;
                            $d = $detalle->registrar_credito_detalle();
                            $detalleCobro = new CobroDetalleData();
                            $detalleCobro->creditoDetalle = $d[1];
                            $detalleCobro->registrar_credito();
                        }
                        $cuotas = $_POST['cuotas'];
                        header("Content-type:application/json");
                        $jsdata = json_decode(file_get_contents('php://input'), true);
                        header("HTTP/1.1 200 OK");
                        header('Content-Type: text/plain');
                        echo json_encode($s[1]);
                    } else {
                        // 
                        // 
                        // 
                        // 

                        $registro1 = new CobroCabecera();


                        $j1 = $_POST['serie1'];
                        $j2 = "-";
                        $j5 = $_POST['numeracion_final'];
                        $j6 = $_POST['diferencia'];
                        $j7 = ($j5 - $j6);
                        $j8 = ($j5 - $j6);
                        $nrofactura = "";
                        $sell->factura = $_POST['facturan'];
                        $nrofactura = $_POST['facturan'];
                        // if (
                        //     $j8 >= 1 & $j8 < 10
                        // ) {
                        //     $nrofactura = $sell->factura = $j1 . "-" . "000000" . $j8;
                        // } else {
                        //     if (
                        //         $j8 >= 10 & $j8 < 100
                        //     ) {
                        //         $nrofactura = $j1 . "-" . "00000" . $j8;
                        //     } else {
                        //         if ($j8 >= 100 & $j8 < 1000) {
                        //             $nrofactura = $j1 . "-" . "0000" . $j8;
                        //         } else {
                        //             if (
                        //                 $j8 >= 1000 & $j8 < 10000
                        //             ) {
                        //                 $nrofactura = $j1 . "-" . "000" . $j8;
                        //             } else {
                        //                 if ($j8 >= 100000 & $j8 < 1000000) {
                        //                     $nrofactura = $j1 . "-" . "00" . $j8;
                        //                 } else {
                        //                     if ($j8 >= 1000000 & $j8 < 10000000) {
                        //                         $nrofactura = $j1 . "-" . "0" . $j8;
                        //                     } else {
                        //                     }
                        //                 }
                        //             }
                        //         }
                        //     }
                        // }



                        if (
                            count($_POST) > 0
                        ) {
                            $configuracionfactura = ConfigFacturaData::VerId($_POST["id_configfactura"]);
                            $jl1 = $_POST["diferencia"];
                            //$jl2 = $s[1];
                            $configuracionfactura->diferencia = ($jl1 - 1);
                            $configuracionfactura->actualizardiferencia();
                        }

                        $registro1->RECIBO = $nrofactura;
                        $registro1->configfactura_id = $_POST["configfactura_id"];
                        $registro1->CLIENTE_ID = $_POST["cliente_id"];
                        $registro1->TOTAL_COBRO = $_POST['total'];
                        $registro1->SUCURSAL_ID = $_POST["sucursal_id"];
                        $registro1->MONEDA_ID = $_POST["idtipomoneda"];
                        $registro1->FECHA_COBRO = $_POST['fecha'];
                        $id_cobro = $registro1->registro();


                        // inicio Registro de detalle


                        $saldo = 0;
                        $monto = $_POST["total"];
                        $suma = 0;
                        // $factura = $_POST["factura"];
                        $couta = 1;
                        $credito = $s[1];
                        $cliente = $_POST["cliente_id"];
                        $importecred = $_POST["total"];
                        $sucursall = $_POST["sucursal_id"];

                        $registro2 = new CobroDetalleData();
                        $cobrosrealizados = $_POST['tablaCobro'];
                        $i = 0;
                        foreach ($cobrosrealizados as $cobroh) {
                            $i = $i + 1;
                            $registro2 = new CobroDetalleData();
                            $registro2->COBRO_ID = $id_cobro[1];
                            $registro2->NUMERO_FACTURA = $nrofactura;
                            $registro2->CUOTA = $i;
                            $registro2->NUMERO_CREDITO = $credito;
                            $registro2->CLIENTE_ID = $cliente;     // probar id cliente si carga bien
                            $registro2->IMPORTE_COBRO = $cobroh['monto2'];
                            $registro2->IMPORTE_CREDITO = $importecred;
                            $registro2->tipo = 1;
                            $registro2->SUCURSAL_ID = $sucursall;
                            $registro2->registro();
                        }

                        header("Content-type:application/json");
                        $jsdata = json_decode(file_get_contents('php://input'), true);
                        header("HTTP/1.1 200 OK");
                        header('Content-Type: text/plain');
                        echo json_encode($s[1]);
                    }
                } else {
                }
            }
        }
    }
    if ($remision_id != 0) {
        $tipoproducto = $cart[0]["tipo"];
        if ($tipoproducto == "Servicio") {
            if (isset($_POST["cart"])) {
                $cart = $_POST["cart"];
                if (count($cart) > 0) {
                    $num_succ = 0;
                    $process = false;
                    $errors = array();
                    // foreach ($cart as $c2) {
                    //     $q = 2;
                    //     if ($c2["cantidad"] <= $q) {
                    //         if (isset($_POST["is_oficiall"])) {
                    //             $qyf = 2;
                    //             if ($c2["cantidad"] <= $qyf) {
                    //                 $num_succ++;
                    //             } else {
                    //                 $error = array("id" => $c2["id"], "message" => "No hay suficiente cantidad de producto para facturar en inventario.");
                    //                 $errors[count($errors)] = $error;
                    //             }
                    //         } else {
                    $num_succ++;
                    //         }
                    //     } else {
                    //         $error = array("id" => $c2["id"], "message" => "No hay suficiente cantidad de producto en inventario.");
                    //         $errors[count($errors)] = $error;
                    //     }
                    // }

                    $process = true;

                    if ($process == true) {
                        $sell = new VentaData2();
                        $sell->usuario_id = $_SESSION["admin_id"];
                        $sell->presupuesto = $_POST["presupuesto"];
                        $sell->REMISION_ID = $_POST["remision_id"];
                        $sell->cdc_fact = $_POST["cdc_fact"];
                        $sell->num_fact = $_POST["num_fact"];
                        $j1 = $_POST['serie1'];
                        $j2 = "-";
                        $j5 = $_POST['numeracion_final'];
                        $j6 = $_POST['diferencia'];
                        $j7 = ($j5 - $j6);
                        $j8 = ($j5 - $j6);
                        $nrofactura = "";
                        $sell->factura = $_POST['facturan'];
                        $nrofactura = $_POST['facturan'];
                        // if ($j8 >= 1 & $j8 < 10) {
                        //     $nrofactura = $sell->factura = $j1 . "-" . "000000" . $j8;
                        // } else {
                        //     if ($j8 >= 10 & $j8 < 100) {
                        //         $nrofactura = $sell->factura = $j1 . "-" . "00000" . $j8;
                        //     } else {
                        //         if ($j8 >= 100 & $j8 < 1000) {
                        //             $nrofactura = $sell->factura = $j1 . "-" . "0000" . $j8;
                        //         } else {
                        //             if ($j8 >= 1000 & $j8 < 10000) {
                        //                 $nrofactura = $sell->factura = $j1 . "-" . "000" . $j8;
                        //             } else {
                        //                 if ($j8 >= 100000 & $j8 < 1000000) {
                        //                     $nrofactura = $sell->factura = $j1 . "-" . "00" . $j8;
                        //                 } else {
                        //                     if ($j8 >= 1000000 & $j8 < 10000000) {
                        //                         $nrofactura = $sell->factura = $j1 . "-" . "0" . $j8;
                        //                     } else {
                        //                     }
                        //                 }
                        //             }
                        //         }
                        //     }
                        // }





                        $sell->configfactura_id = $_POST["configfactura_id"];
                        $sell->tipomoneda_id = trim($_POST["idtipomoneda"]);

                        $sell->cambio = $_POST["cambio"];
                        $sell->cambio2 = $_POST["cambio2"];
                        $sell->simbolo2 = $_POST["simbolo2"];

                        $sell->formapago = $_POST["formapago"];
                        $sell->codigo = $_POST["codigo"];
                        $sell->fechapago = date('Y-m-d', strtotime($_POST['fecha']));
                        $sell->metodopago = $_POST["metodopago"];
                        $sell->total10 = str_replace(',', '', $_POST["total10"]);
                        $sell->iva10 = str_replace(',', '', $_POST["iva10"]);
                        $sell->total5 = str_replace(',', '', $_POST["total5"]);
                        $sell->iva5 = str_replace(',', '', $_POST["iva5"]);
                        $sell->exenta = str_replace(',', '', $_POST["exenta"]);
                        $a1 = $_POST['total'];
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
                            $s = $sell->venta_producto_cliente3();


                            $sell->actualizaremision();
                        } else {
                            $s = $sell->add1();
                        }
                        foreach ($cart as  $c2) {

                            $op = new OperationData();
                            $op->producto_id = $c2["id"];
                            $op->fecha = $_POST["fecha"];
                            $op->accion_id = AccionData::getByName("salida")->id_accion;
                            $op->venta_id = $s[1];
                            $op->precio1 = $c2["precioc"];
                            $b = $_POST["sucursal_id"];


                            $stc = $_POST["stock_trans"];
                            $op->stock_trans = $stc;
                            $op->motivo = "VENTA" . " " . $s[1];

                            $op->sucursal_id = $b;
                            $op->q = $c2["cantidad"];
                            $op->precio3 = 0;
                            $op->precio = $c2["precio"];

                            if (isset($_POST["is_oficiall"])) {
                                $op->is_oficiall = 1;
                            }
                            $op->deposito = $c2["deposito"];
                            $op->deposito_nombre = $c2["depositotext"];
                            $add = $op->registro_producto1();
                        }
                        if (count($_POST) > 0) {
                            $configuracionfactura = ConfigFacturaData::VerId($_POST["id_configfactura"]);
                            $jl1 = $_POST["diferencia"];
                            $jl2 = $s[1];
                            $configuracionfactura->diferencia = ($jl1 - 1);
                            $configuracionfactura->actualizardiferencia();
                        }
                        if ($_POST["metodopago"] == "Credito") {
                            $fecha_actual = $_POST['fecha'];
                            $vence = date("Y-m-d", strtotime($fecha_actual . "+ " . $_POST['vencimiento'] . " days"));
                            $credito = new CreditoData();
                            $credito->sucursalId = $_POST["sucursal_id"];
                            $credito->monedaId = trim($_POST["idtipomoneda"]);
                            $credito->concepto = $_POST["concepto"];
                            $credito->credito = str_replace(',', '', $_POST['total']);
                            $credito->cuotas = $_POST['cuotas'];
                            $credito->abonado = 0;
                            $credito->vencimiento = $vence;

                            $credito->fecha = $fecha_actual;
                            $credito->cliente_id = $_POST["cliente_id"];
                            $credito->ventaId = $s[1];
                            $cre = $credito->registrar_credito();
                            $clientss = $_POST["cliente_id"];
                            for ($i = 1; $i < $_POST['cuotas'] + 1; $i++) {
                                $detalle = new CreditoDetalleData();

                                if ($i == 1) {
                                } else {
                                    $vence = date("Y-m-d", strtotime($vence . "+ " . $_POST['vencimiento'] . " days"));
                                }
                                $detalle->fechaDetalle = $vence . '';
                                $detalle->cuota = $i;
                                $detalle->creditoId = $cre[1];
                                $detalle->sucursalId = $_POST["sucursal_id"];
                                $detalle->factura = $nrofactura;
                                $detalle->fecha = $fecha_actual;


                                $detalle->monedaId = trim($_POST["idtipomoneda"]);
                                $detalle->cliente_id = $_POST["cliente_id"];
                                $detalle->recibido = str_replace(',', '', $_POST['total']) / $_POST['cuotas'];
                                $detalle->moneda = 0;
                                $d = $detalle->registrar_credito_detalle();
                                $detalleCobro = new CobroDetalleData();
                                $detalleCobro->creditoDetalle = $d[1];
                                $detalleCobro->registrar_credito();
                            }
                            $cuotas = $_POST['cuotas'];
                            header("Content-type:application/json");
                            $jsdata = json_decode(file_get_contents('php://input'), true);
                            header("HTTP/1.1 200 OK");
                            header('Content-Type: text/plain');
                            echo json_encode($s[1]);
                        } else {
                            // 
                            // 
                            // 
                            // 

                            $registro1 = new CobroCabecera();


                            $j1 = $_POST['serie1'];
                            $j2 = "-";
                            $j5 = $_POST['numeracion_final'];
                            $j6 = $_POST['diferencia'];
                            $j7 = ($j5 - $j6);
                            $j8 = ($j5 - $j6);
                            $nrofactura = "";
                            $sell->factura = $_POST['facturan'];
                            $nrofactura = $_POST['facturan'];
                            // if (
                            //     $j8 >= 1 & $j8 < 10
                            // ) {
                            //     $nrofactura = $sell->factura = $j1 . "-" . "000000" . $j8;
                            // } else {
                            //     if (
                            //         $j8 >= 10 & $j8 < 100
                            //     ) {
                            //         $nrofactura = $j1 . "-" . "00000" . $j8;
                            //     } else {
                            //         if ($j8 >= 100 & $j8 < 1000) {
                            //             $nrofactura = $j1 . "-" . "0000" . $j8;
                            //         } else {
                            //             if (
                            //                 $j8 >= 1000 & $j8 < 10000
                            //             ) {
                            //                 $nrofactura = $j1 . "-" . "000" . $j8;
                            //             } else {
                            //                 if ($j8 >= 100000 & $j8 < 1000000) {
                            //                     $nrofactura = $j1 . "-" . "00" . $j8;
                            //                 } else {
                            //                     if ($j8 >= 1000000 & $j8 < 10000000) {
                            //                         $nrofactura = $j1 . "-" . "0" . $j8;
                            //                     } else {
                            //                     }
                            //                 }
                            //             }
                            //         }
                            //     }
                            // }



                            if (
                                count($_POST) > 0
                            ) {
                                $configuracionfactura = ConfigFacturaData::VerId($_POST["id_configfactura"]);
                                $jl1 = $_POST["diferencia"];
                                //$jl2 = $s[1];
                                $configuracionfactura->diferencia = ($jl1 - 1);
                                $configuracionfactura->actualizardiferencia();
                            }

                            $registro1->RECIBO = $nrofactura;
                            $registro1->configfactura_id = $_POST["configfactura_id"];
                            $registro1->CLIENTE_ID = $_POST["cliente_id"];
                            $registro1->TOTAL_COBRO = $_POST['total'];
                            $registro1->SUCURSAL_ID = $_POST["sucursal_id"];
                            $registro1->MONEDA_ID = $_POST["idtipomoneda"];
                            $registro1->FECHA_COBRO = $_POST['fecha'];
                            $id_cobro = $registro1->registro();


                            // inicio Registro de detalle


                            $saldo = 0;
                            $monto = $_POST["total"];
                            $suma = 0;
                            // $factura = $_POST["factura"];
                            $couta = 1;
                            $credito = $s[1];
                            $cliente = $_POST["cliente_id"];
                            $importecred = $_POST["total"];
                            $sucursall = $_POST["sucursal_id"];
                            $cobrosrealizados = $_POST['tablaCobro'];
                            $i = 0;
                            foreach ($cobrosrealizados as $cobroh) {
                                $i = $i + 1;
                                $registro2 = new CobroDetalleData();
                                $registro2->COBRO_ID = $id_cobro[1];
                                $registro2->NUMERO_FACTURA = $nrofactura;
                                $registro2->CUOTA = $i;
                                $registro2->NUMERO_CREDITO = $credito;
                                $registro2->CLIENTE_ID = $cliente;     // probar id cliente si carga bien
                                $registro2->IMPORTE_COBRO = $cobroh['monto2'];
                                $registro2->IMPORTE_CREDITO = $importecred;
                                $registro2->SUCURSAL_ID = $sucursall;
                                $registro2->tipo = 1;
                                $registro2->registro();
                            }
                            header("Content-type:application/json");
                            $jsdata = json_decode(file_get_contents('php://input'), true);
                            header("HTTP/1.1 200 OK");
                            header('Content-Type: text/plain');
                            echo json_encode($s[1]);
                        }
                    }
                }
            }
        } else {
            if (isset($_POST["cart"])) {
                $cart = $_POST["cart"];
                if (count($cart) > 0) {
                    $num_succ = 0;
                    foreach ($cart as $c2) {
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



                    $process = true;

                    if ($process == true) {
                        $sell = new VentaData2();
                        $sell->usuario_id = $_SESSION["admin_id"];
                        $sell->presupuesto = $_POST["presupuesto"];
                        $sell->REMISION_ID = $_POST["remision_id"];
                        $sell->cdc_fact = $_POST["cdc_fact"];
                        $sell->num_fact = $_POST["num_fact"];
                        $j1 = $_POST['serie1'];
                        $j2 = "-";
                        $j5 = $_POST['numeracion_final'];
                        $j6 = $_POST['diferencia'];
                        $j7 = ($j5 - $j6);
                        $j8 = ($j5 - $j6);
                        $nrofactura = "";
                        $sell->factura = $_POST['facturan'];
                        $nrofactura = $_POST['facturan'];
                        // if ($j8 >= 1 & $j8 < 10) {
                        //     $nrofactura = $sell->factura = $j1 . "-" . "000000" . $j8;
                        // } else {
                        //     if ($j8 >= 10 & $j8 < 100) {
                        //         $nrofactura = $sell->factura = $j1 . "-" . "00000" . $j8;
                        //     } else {
                        //         if ($j8 >= 100 & $j8 < 1000) {
                        //             $nrofactura = $sell->factura = $j1 . "-" . "0000" . $j8;
                        //         } else {
                        //             if ($j8 >= 1000 & $j8 < 10000) {
                        //                 $nrofactura = $sell->factura = $j1 . "-" . "000" . $j8;
                        //             } else {
                        //                 if ($j8 >= 100000 & $j8 < 1000000) {
                        //                     $nrofactura = $sell->factura = $j1 . "-" . "00" . $j8;
                        //                 } else {
                        //                     if ($j8 >= 1000000 & $j8 < 10000000) {
                        //                         $nrofactura = $sell->factura = $j1 . "-" . "0" . $j8;
                        //                     } else {
                        //                     }
                        //                 }
                        //             }
                        //         }
                        //     }
                        // }

                        $sell->configfactura_id = $_POST["configfactura_id"];
                        $sell->tipomoneda_id = trim($_POST["idtipomoneda"]);

                        $sell->cambio = $_POST["cambio"];
                        $sell->cambio2 = $_POST["cambio2"];
                        $sell->simbolo2 = $_POST["simbolo2"];

                        $sell->formapago = $_POST["formapago"];
                        $sell->codigo = $_POST["codigo"];
                        $sell->fechapago = date('Y-m-d', strtotime($_POST['fecha']));
                        $sell->metodopago = $_POST["metodopago"];
                        $sell->total10 = str_replace(',', '', $_POST["total10"]);
                        $sell->iva10 = str_replace(',', '', $_POST["iva10"]);
                        $sell->total5 = str_replace(',', '', $_POST["total5"]);
                        $sell->iva5 = str_replace(',', '', $_POST["iva5"]);
                        $sell->exenta = str_replace(',', '', $_POST["exenta"]);
                        $a1 = $_POST['total'];
                        $sell->total = str_replace(',', '', $a1);
                        $sell->n = 1;
                        $sell->numerocorraltivo = $j8;
                        $a = $_POST["sucursal_id"];
                        $sell->sucursal_id = $a;
                        $sell->fecha = $_POST["fecha"];
                        $sell->cantidaconfigmasiva = $_POST["cantidaconfigmasiva"];
                        $s = 0;
                        $sell->cliente_id = $_POST["cliente_id"];
                        $s = $sell->venta_producto_cliente3();

                        $sell->actualizaremision();
                        foreach ($cart as  $c2) {

                            $op = new OperationData();
                            $op->producto_id = $c2["id"];
                            $op->fecha = $_POST["fecha"];
                            $op->accion_id = AccionData::getByName("salida")->id_accion;
                            $op->venta_id = $s[1];
                            $op->precio1 = $c2["precioc"];
                            $b = $_POST["sucursal_id"];


                            $stc = $_POST["stock_trans"];
                            $op->stock_trans = $stc;
                            $op->motivo = "VENTA" . " " . $s[1];


                            $op->sucursal_id = $b;
                            $op->q = $c2["cantidad"];
                            $op->precio3 = $c2["cantidad"];
                            $op->precio = $c2["precio"];

                            if (isset($_POST["is_oficiall"])) {
                                $op->is_oficiall = 1;
                            }
                            $op->deposito = $c2["deposito"];
                            $op->deposito_nombre = $c2["depositotext"];
                            $add = $op->registro_producto1();
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



                                // $stocki = StockData::vercontenidos3($insumo->insumo_id, $c2["deposito"]);
                                // $actualizari = new StockData();
                                // $resta = $stocki->CANTIDAD_STOCK - $insumo->cantidad;
                                // $actualizari->CANTIDAD_STOCK =    $resta;
                                // $actualizari->PRODUCTO_ID = $insumo->insumo_id;
                                // $actualizari->DEPOSITO_ID = $c2["deposito"];
                                // $aci = $actualizari->actualizar2();
                            }
                            /*  $actualizar = new StockData();
                        $resta = $c2["stock"] - $c2["cantidad"];
                        $actualizar->CANTIDAD_STOCK =    $resta;
                        $actualizar->PRODUCTO_ID = $c2["id"];
                        $actualizar->actualizar(); */
                        }
                        if (count($_POST) > 0) {
                            $configuracionfactura = ConfigFacturaData::VerId($_POST["id_configfactura"]);
                            $jl1 = $_POST["diferencia"];
                            $jl2 = $s[1];
                            $configuracionfactura->diferencia = ($jl1 - 1);
                            $configuracionfactura->actualizardiferencia();
                        }
                        if ($_POST["metodopago"] == "Credito") {
                            $fecha_actual = $_POST['fecha'];




                            $vence = date("Y-m-d", strtotime($fecha_actual . "+ " . $_POST['vencimiento'] . " days"));
                            $credito = new CreditoData();
                            $credito->sucursalId = $_POST["sucursal_id"];
                            $credito->monedaId = trim($_POST["idtipomoneda"]);
                            $credito->concepto = $_POST["concepto"];
                            $credito->credito = str_replace(',', '', $_POST['total']);
                            $credito->cuotas = $_POST['cuotas'];
                            $credito->abonado = 0;
                            $credito->cliente_id = $_POST["cliente_id"];
                            $credito->vencimiento = $vence;

                            $credito->fecha = $fecha_actual;

                            $credito->ventaId = $s[1];
                            $cre = $credito->registrar_credito();
                            $clientss = $_POST["cliente_id"];
                            for ($i = 1; $i < $_POST['cuotas'] + 1; $i++) {
                                $detalle = new CreditoDetalleData();

                                if ($i == 1) {
                                } else {
                                    $vence = date("Y-m-d", strtotime($vence . "+ " . $_POST['vencimiento'] . " days"));
                                }
                                $detalle->fechaDetalle = $vence . '';
                                $detalle->cuota = $i;
                                $detalle->creditoId = $cre[1];
                                $detalle->sucursalId = $_POST["sucursal_id"];
                                $detalle->factura = $nrofactura;

                                $detalle->fecha = $fecha_actual;

                                $detalle->monedaId = trim($_POST["idtipomoneda"]);
                                $detalle->cliente_id = $_POST["cliente_id"];

                                $detalle->recibido = str_replace(',', '', $_POST['total']) / $_POST['cuotas'];
                                $detalle->moneda = 0;
                                $d = $detalle->registrar_credito_detalle();
                                $detalleCobro = new CobroDetalleData();
                                $detalleCobro->creditoDetalle = $d[1];
                                $detalleCobro->registrar_credito();
                            }
                            $cuotas = $_POST['cuotas'];
                            header("Content-type:application/json");
                            $jsdata = json_decode(file_get_contents('php://input'), true);
                            header("HTTP/1.1 200 OK");
                            header('Content-Type: text/plain');


                            echo json_encode($s[1]);
                        } else {
                            // 
                            // 
                            // 
                            // 

                            $registro1 = new CobroCabecera();


                            $j1 = $_POST['serie1'];
                            $j2 = "-";
                            $j5 = $_POST['numeracion_final'];
                            $j6 = $_POST['diferencia'];
                            $j7 = ($j5 - $j6);
                            $j8 = ($j5 - $j6);
                            $nrofactura = "";
                            $sell->factura = $_POST['facturan'];
                            $nrofactura = $_POST['facturan'];
                            // if (
                            //     $j8 >= 1 & $j8 < 10
                            // ) {
                            //     $nrofactura = $sell->factura = $j1 . "-" . "000000" . $j8;
                            // } else {
                            //     if (
                            //         $j8 >= 10 & $j8 < 100
                            //     ) {
                            //         $nrofactura = $j1 . "-" . "00000" . $j8;
                            //     } else {
                            //         if ($j8 >= 100 & $j8 < 1000) {
                            //             $nrofactura = $j1 . "-" . "0000" . $j8;
                            //         } else {
                            //             if (
                            //                 $j8 >= 1000 & $j8 < 10000
                            //             ) {
                            //                 $nrofactura = $j1 . "-" . "000" . $j8;
                            //             } else {
                            //                 if ($j8 >= 100000 & $j8 < 1000000) {
                            //                     $nrofactura = $j1 . "-" . "00" . $j8;
                            //                 } else {
                            //                     if ($j8 >= 1000000 & $j8 < 10000000) {
                            //                         $nrofactura = $j1 . "-" . "0" . $j8;
                            //                     } else {
                            //                     }
                            //                 }
                            //             }
                            //         }
                            //     }
                            // }



                            if (
                                count($_POST) > 0
                            ) {
                                $configuracionfactura = ConfigFacturaData::VerId($_POST["id_configfactura"]);
                                $jl1 = $_POST["diferencia"];
                                //$jl2 = $s[1];
                                $configuracionfactura->diferencia = ($jl1 - 1);
                                $configuracionfactura->actualizardiferencia();
                            }

                            $registro1->RECIBO = $nrofactura;
                            $registro1->configfactura_id = $_POST["configfactura_id"];
                            $registro1->CLIENTE_ID = $_POST["cliente_id"];
                            $registro1->TOTAL_COBRO = $_POST['total'];
                            $registro1->SUCURSAL_ID = $_POST["sucursal_id"];
                            $registro1->MONEDA_ID = $_POST["idtipomoneda"];
                            $registro1->FECHA_COBRO = $_POST['fecha'];
                            $id_cobro = $registro1->registro();


                            // inicio Registro de detalle


                            $saldo = 0;
                            $monto = $_POST["total"];
                            $suma = 0;
                            // $factura = $_POST["factura"];
                            $couta = 1;
                            $credito = $s[1];
                            $cliente = $_POST["cliente_id"];
                            $importecred = $_POST["total"];
                            $sucursall = $_POST["sucursal_id"];
                            $cobrosrealizados = $_POST['tablaCobro'];
                            $i = 0;
                            foreach ($cobrosrealizados as $cobroh) {
                                $i = $i + 1;
                                $registro2 = new CobroDetalleData();
                                $registro2->COBRO_ID = $id_cobro[1];
                                $registro2->NUMERO_FACTURA = $nrofactura;
                                $registro2->CUOTA = $i;
                                $registro2->NUMERO_CREDITO = $credito;
                                $registro2->CLIENTE_ID = $cliente;     // probar id cliente si carga bien
                                $registro2->IMPORTE_COBRO = $cobroh['monto2'];
                                $registro2->IMPORTE_CREDITO = $importecred;
                                $registro2->SUCURSAL_ID = $sucursall;
                                $registro2->tipo = 1;
                                $registro2->registro();
                            }

                            header("Content-type:application/json");
                            $jsdata = json_decode(file_get_contents('php://input'), true);
                            header("HTTP/1.1 200 OK");
                            header('Content-Type: text/plain');
                            echo json_encode($s[1]);
                        }
                    }
                }
            }
        }
    } else {
    }
} else {
    Core::alert("NUMERO DE FACTURA EXISTENTE...!");
    Core::redir("index.php?view=vender&id_sucursal=" . $_POST["id_sucursal"]);
}
