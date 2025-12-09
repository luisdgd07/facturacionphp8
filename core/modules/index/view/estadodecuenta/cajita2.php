<?php
$u = null;

if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
    $u = UserData::getById($_SESSION["admin_id"]);
?>
    <?php if ($u->is_empleado) : ?>
        <?php
        $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
        ?>



        <div class="content-wrapper">
            <section class="content-header">
                <h1> <i class="fa fa-cubes"></i>
                    Estado de cuenta Cliente
                    <small> </small>
                </h1>
            </section>
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <div class="panel-body">
                            <form>
                                <input type="hidden" name="view" value="estadodecuenta">
                                <div class="row">
                                    <div class="col-md-3">



                                        <select required="" name="cliente_id" class="form-control">

                                            <option value="">Seleccionar Cliente</option>
                                            <?php $clientes = ClienteData::verclientessucursal($sucursales->id_sucursal);
                                            if (count($clientes) > 0) {
                                                foreach ($clientes as $p) : ?>
                                                    <option value="<?php echo $p->id_cliente; ?>"><?php echo $p->nombre . " " . $p->apellido; ?></option>
                                            <?php endforeach;
                                            } ?>
                                        </select>
                                    </div>
                                    
                                  
                                    <div class="col-md-3">
                                        <input type="date" name="sd" id="sd" value="<?php if (isset($_GET["sd"])) {
                                                                                        echo $_GET["sd"];
                                                                                    } ?>" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" name="ed" id="ed" value="<?php if (isset($_GET["ed"])) {
                                                                                        echo $_GET["ed"];
                                                                                    } ?>" class="form-control">
                                    </div>





                                    <script type="text/javascript">
                                        function obtenerFechaActual() {
                                            n = new Date();
                                            y = n.getFullYear();
                                            m = n.getMonth() + 1;
                                            d = n.getDate();
                                            return y + "-" + (m > 9 ? m : "0" + m) + "-" + (d > 9 ? d : "0" + d)
                                        }

                                        //inicializar las fechas del reporte
                                        $("#sd").val(obtenerFechaActual());
                                        $("#ed").val(obtenerFechaActual());
                                    </script>

                                    <div class="col-md-3">
                                        <input type="submit" class="btn btn-success btn-block" value="Procesar">
                                        <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">

                                    </div>
                                </div>
                            </form>
                            <?php if (isset($_GET["sd"]) && isset($_GET["ed"])) : ?>
                                <?php if ($_GET["sd"] != "" && $_GET["ed"] != "") : ?>
                                    <?php
                                    $operations = array();

                                    if ($_GET["cliente_id"] == "") {
                                        $operations = CreditoDetalleData::getAllByDateOp($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
                                    } else {
                                        $operations = CreditoDetalleData::getAllByDateBCOp($_GET["cliente_id"], $_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
                                    }
                                    $estados = array();
                                    // if ($_GET["product"] === "todos") {
                                    //     $ops = OperationData::getByProductoId2($_GET["id_sucursal"], $_GET["sd"], $_GET["ed"]);
                                    // } else {
                                    //     $ops = OperationData::getByProductoId($_GET["id_sucursal"], $_GET["prod"], $_GET["sd"], $_GET["ed"]);
                                    // }
                                    // // echo $ops;
                                    // //$sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
                                    // $operations = array();
                                    // // var_dump($ops);
                                    // if (count($ops) > 0) {
                                    //     foreach ($ops as $op) {
                                    //         // var_dump()
                                    //         $d = VentaData::getId($op->venta_id);
                                    //         if ($_GET['cliente'] == 'todos') {
                                    //             if ($d->cliente_id !== NULL) {
                                    //                 array_push($operations, VentaData::getId($op->venta_id));
                                    //             }
                                    //         } else if ($d->cliente_id == $_GET['cliente']) {
                                    //             array_push($operations, VentaData::getId($op->venta_id));
                                    //         }
                                    //         // $operations = VentaData::getId($op->venta_id);
                                    //     }
                                    // } else {
                                    //     echo "No hay Ventas";
                                    // }
                                    $numero = 0;
                                    $recibo = 0;
                                    $fecha = 0;
                                    $caduca = 0;
                                    $turno = 0;
                                    $ventarecibo = 0;
                                    $ventafactura = 0;
                                    $cliente = 0;

                                    $apellido = 0;
                                    $dni = 0;
                                    $id_cliente = 0;
                                    $sucursal = 0;
                                    $moneda = 0;
                                    if (count($operations) > 0) :
                                        foreach ($operations as $oper) {
                                            $cliente = $oper->cliente()->nombre;
                                            $apellido = $oper->cliente()->apellido;
                                            $dni = $oper->cliente()->dni;
                                            $id_cliente = $oper->cliente()->id_cliente;
                                            $recibo = $oper->credito()->venta_id;
                                            $caduca = $oper->credito()->vencimiento;
                                            $sucursal = $oper->credito()->sucursal_id;
                                            $fecha = $oper->fecha;
                                            $turno = 0;
                                        }
                                        $ventas = VentaData::vercontenidos($recibo);
                                        if (count($ventas) > 0) {
                                            foreach ($ventas as $venta) {
                                                $ventarecibo = $venta->VerConfiFactura()->diferencia;
                                                $ventafactura = $venta->factura;
                                                $moneda = $venta->tipomoneda_id;
                                            }
                                        }
                                    ?>
                                        <br>
                                        <form class="form-horizontal" enctype="multipart/form-data" method="post" action="index.php?action=cobranzacredito" role="form">


                                            <input type="hidden" name="factura" id="num1">
                                            <input type="hidden" name="numeracion_inicial" id="numinicio">
                                            <input type="hidden" name="numeracion_final" id="numfin">
                                            <input type="hidden" name="serie1" id="serie">



                                            <div class="col-md-12">


                                                <?php
                                                $sumatotal = 0;
                                                $suma = 0;
                                                $total = 0;
                                                foreach ($operations as $credy) :

                                                    // aca obtenfo el simbolo de la mondeda
                                                    $ventas2 = MonedaData::cboObtenerValorPorSucursal2($credy->sucursal_id, $credy->moneda_id);
                                                    if (count($ventas2) > 0) {

                                                        $simbolomon = 0;
                                                        foreach ($ventas2 as $simbolos) {
                                                            $simbolomon = $simbolos->simbolo;
                                                        }
                                                    }


                                                ?>
                                                    <!-- <tr>
                                                            <td>
                                                                <p><?= $credy->credito_id; ?></p>
                                                            </td>

                                                            <td><?= $credy->nrofactura; ?></td>
                                                            <td><?= $credy->cuota; ?></td>
                                                            <td><?php
                                                                $total += $credy->saldo_credito;
                                                                ?>

                                                                <?= $credy->importe_credito; ?></td>
                                                            <td><?= $simbolomon; ?></td>

                                                            <td><?= $credy->fecha; ?></td>
                                                            <td <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                            }  ?>><?= $credy->fecha_detalle; ?></td>
                                                            <td <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                            }  ?>>VENTAS</td>
                                                        </tr> -->



                                                <?php





                                                endforeach; ?>

                                                <table id="example1" class="table table-bordered table-hover table-responsive ">
                                                    <thead>
                                                        <th style="width: 50px !important;">Nº Crédito</th>
                                                        <th style="width: 50px;">Nº Factura</th>
                                                        <th style="width: 50px;">Cuota</th>
                                                        <th style="width: 50px;">Importe Crédito</th>
                                                        <th style="width: 50px;">Mon</th>
                                                        <th style="width: 50px;">Importe Cobro</th>

                                                        <th style="width: 50px;">Fecha Crédito</th>
                                                        <th style="width: 50px;">Fecha Venc</th>
                                                        <th style="width: 50px;">Tipo Venta</th>
                                                    </thead>
                                                    <?php
                                                    $sumatotal = 0;
                                                    $suma = 0;
                                                    foreach ($operations as $credy) :
                                                        $venta = VentaData::getbyfactura($credy->nrofactura, $_GET['id_sucursal']);
                                                        $ventas2 = MonedaData::cboObtenerValorPorSucursal2($credy->sucursal_id, $credy->moneda_id);
                                                        if (count($ventas2) > 0) {

                                                            $simbolomon = 0;
                                                            foreach ($ventas2 as $simbolos) {
                                                                $simbolomon = $simbolos->simbolo;
                                                            }
                                                        }
                                                        if ($_GET['product'] == 'todos') {
                                                            $contieneElProducto = true;
                                                        } else {
                                                            $productos = OperationData::getAllProductsBySellIddd($venta->id_venta);
                                                            $contieneElProducto = false;
                                                            foreach ($productos as $prod) {
                                                                if ($prod->producto_id == $_GET['product']) {
                                                                    $contieneElProducto = true;
                                                                }
                                                            }
                                                        }

                                                        if (!$contieneElProducto) {
                                                            echo 'no tiene';
                                                        } else {
                                                        }


                                                    ?>
                                                        <tr>
                                                            <input type="hidden" name="saldo_credito_cli[]" id="saldo_credito_cli" value="<?php echo $credy->saldo_credito; ?>">

                                                            <td>
                                                                <!-- <?php var_dump(VentaData::getbyfactura($credy->nrofactura, $_GET['id_sucursal'])) ?> -->
                                                                <input style="width: 70px;" <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                                                        }  ?> type="text" name="credito[]" value="<?= $credy->credito_id; ?>" class="form-control">
                                                            </td>

                                                            <td><input style="width: 130px;" <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                                                        }  ?> style="width: 130px;" type="hidden" class="form-control" name="clientes[]" id="cliente" value="<?php echo $id_cliente; ?>"><input <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                                                                                                                                                                                                                                                            }  ?> class="form-control" type="text" name="factura[]" style="width: 130px;" value="<?= $credy->nrofactura; ?>">
                                                                <p style="display: none;"><?= $credy->nrofactura; ?></p>
                                                            </td>
                                                            <td><input style="width: 40px;" <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                                                        }  ?> class="form-control" type="text" name="couta[]" value="<?= $credy->cuota; ?>"></td>
                                                            <td><input style="width: 80px;" <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                                                        }  ?> class="form-control" type="text" name="importecred[]" value="<?= $credy->importe_credito; ?>"></td>
                                                            <td><input <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                                    }  ?> class="form-control" type="text" name="simbolo[]" value="<?= $simbolomon; ?>"></td>
                                                            <td><input <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                                    }  ?> class="form-control" type="number" name="monto[]" value="<?= $suma = $credy->saldo_credito; ?>"> </td>

                                                            <td><input <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                                    }  ?> type="hidden" class="form-control" name="sucursall[]" id="sucursall" value="<?php echo $sucursal; ?>"><?= $credy->fecha; ?></td>
                                                            <td <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                            }  ?>><?= $credy->fecha_detalle; ?></td>
                                                            <td <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                            }  ?>>VENTAS</td>
                                                        </tr>

                                                        <!-- <tr>
                              <td> </td>

                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr> -->
                                                        <?php


                                                        ?>


                                                    <?php





                                                    endforeach; ?>

                                                </table>
                                                <br>
                                                <hr>


                                                <div class="row">
                                                    <div class="col-lg-2">


                                                        <h3>Total: <?php echo  number_format($total, 2, ',', ' '); ?></h3>



                                                    </div>


                                                </div>




                                                <div class="row">


                                                    <div class="col-lg-2 ">
                                                        <a class="btn btn-success mt-4" href="impresionestado.php?cliente_id=<?= $_GET['cliente_id'] ?>&sd=<?= $_GET['sd'] ?>&ed=<?= $_GET['ed'] ?>&id_sucursal=<?= $_GET['id_sucursal'] ?>"> Imprimir</a>

                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail1" class="col-lg-2 control-label">De Fecha:</label>
                                                    <div class="col-lg-2">
                                                        <input type="date" class="form-control" name="direccion" id="direccion" value="<?php echo $_GET["sd"]; ?>">
                                                    </div>
                                                    <label for="inputEmail1" class="col-lg-2 control-label">A Fecha:</label>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $_GET["ed"]; ?>">
                                                    </div>

                                                </div>
                                            <?php else :
                                            // si no hay operaciones
                                            ?>
                                                <script>
                                                    $("#wellcome").hide();
                                                </script>
                                                <div class="jumbotron">
                                                    <h2>No hay registro de cuotas pendientes a cobrar</h2>
                                                    <p>El rango de fechas seleccionado no proporciono ningun resultado.</p>
                                                </div>

                                            <?php endif; ?>
                                        <?php else : ?>
                                            <script>
                                                $("#wellcome").hide();
                                            </script>
                                            <div class="jumbotron">
                                                <h2>Fecha Incorrectas</h2>
                                                <p>Puede ser que no selecciono un rango de fechas, o el rango seleccionado es incorrecto.</p>
                                            </div>
                                            </div>







                                        </form>
                                    <?php endif; ?>

                                <?php endif; ?>

                        </div>
                    </div>
                </div>
            </section>
        </div>

    <?php endif ?>
<?php endif ?>