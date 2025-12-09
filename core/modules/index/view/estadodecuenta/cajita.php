<?php
$u = null;

if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
    $u = UserData::getById($_SESSION["admin_id"]);
?>
    <script>
        $(function() {
            $('#example5').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': false,
                'autoWidth': true
            })
        })
    </script>
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
                                    $nuevafecha =  date($_GET["sd"]);
                                    $n = date("Y-m-d", strtotime($nuevafecha . "- 1 days"));
                                    $VentasAnte = CobroCabecera::totalestadocobros($_GET['id_sucursal'], $_GET['cliente_id'], '1988-01-09', $n);
                                    $moneda = 0;
                                    $totalAnte2 = 0;
                                    foreach ($VentasAnte as $v) {
                                        $totalAnte2 += $v->credito;
                                    }
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
                                                $totalHaber = 0;

                                                $total = 0;
                                                ?>

                                                <table id="examp" class="table table-bordered table-hover table-responsive ">
                                                    <thead>
                                                        <th style="width: 100px">Nº Crédito</th>
                                                        <th style="width: 100px">Cliente</th>
                                                        <th style="width: 200px;">Nº Factura</th>
                                                        <th style="width: 50px;">Cuota</th>

                                                        <th style="width: 50px;">Mon</th>


                                                        <th style="width: 150px;">Debe</th>


                                                        <th style="width: 150px;">Haber</th>

                                                        <th style="width: 150px;">Saldo</th>

                                                        <th style="width: 150px;">Fecha Crédito</th>
                                                        <th style="width: 150px;">Fecha Venc</th>

                                                    </thead>

                                                    <?php
                                                    $saldoanterior = 0;
                                                    $anterior = 0;
                                                    $anterior2 = 0;

                                                    $anterior3 = 0;
                                                    // echo 'ssssss';
                                                    $totalSaldo = 0;
                                                    $nuevafecha =  date($_GET["sd"]);
                                                    $n = date("Y-m-d", strtotime($nuevafecha . "- 1 days"));
                                                    $operationsante = CreditoDetalleData::getAllByDateBCOp($_GET["cliente_id"], '1988-01-09', $n, $_GET["id_sucursal"]);
                                                    // var_dump($operationsante);

                                                    foreach ($operationsante as $credy2) {
                                                        // //$cred = $operations[0]->IMPORTE_CREDITO;
                                                        $totalHaber += $credy2->importe_credito;
                                                        // $totalcobro = 0;
                                                        // if (count($operations2) > 0) {

                                                        //     foreach ($operations2 as $op) {






                                                        // $COBRO_ID = $op->COBRO_ID;


                                                        // 
                                                        // $totalC = 0;
                                                        $totalcobro = 0;

                                                        $users = CobroCabecera::totalcobrosG($_GET['id_sucursal'], $_GET['cliente_id'], '1988-01-09', $_GET["sd"], $credy2->credito_id);
                                                        foreach ($users as $Co) {
                                                            $totalcobro += $Co->TOTAL_COBRO;
                                                            $anterior += $Co->TOTAL_COBRO;
                                                        }
                                                        //    $users = CobroCabecera::totalcobrosG($_GET['id_sucursal'], $_GET['cliente_id'], $_GET['sd'], $_GET['ed'], $credy->credito_id);
                                                        //                                                         foreach ($users as $Co) {
                                                        //                                                             $totalcobro += $Co->TOTAL_COBRO;
                                                        //                                                         }
                                                        // 



                                                        // $operations3 = CreditoDetalleData::busq_estado($COBRO_ID, $_GET["cliente_id"], '1988-01-09', $_GET["ed"], $_GET["id_sucursal"]);
                                                        // //$cred = $operations[0]->IMPORTE_CREDITO;

                                                        // if (count($operations3) > 0) {

                                                        //     foreach ($operations3 as $op2) {



                                                        //         $totalcobro += $op2->TOTAL_COBRO;


                                                        //         $totalSaldo += $credy2->importe_credito - $totalcobro;
                                                        //         // }


                                                        //     }
                                                        // }
                                                    }
                                                    // }

                                                    // $anterior = $totalcobro;
                                                    $anterior2 = $totalHaber;
                                                    $anterior3 = $totalSaldo;
                                                    // echo number_format($totalcobro, 2, ',', '.');
                                                    // echo '<br>';
                                                    // }
                                                    ?>
                                                    <thead>

                                                        <th style="text-align: center;"><b>
                                                                Saldo anterior:</b>
                                                        </th>
                                                        <th style="text-align: center;;">
                                                        </th>
                                                        <th style="text-align: center;;">
                                                        </th>
                                                        <th style="text-align: center;;"></th>

                                                        <th style="text-align: center;;"></th>





                                                        <th style="text-align: center;"><b> <?php echo number_format($anterior, 2, ',', '.')  ?></b></th>


                                                        <th style="text-align: center"><b> <?php echo number_format($anterior2, 2, ',', '.')  ?></b></th>


                                                        <th style="text-align: center"><b> <?php
                                                                                            $anterior3 = $anterior2 - $anterior;
                                                                                            echo number_format($anterior3, 2, ',', '.')  ?></b></th>




                                                        <th style="text-align: center;"></th>
                                                        <th style="text-align: center;"></th>

                                                    </thead>

                                                    <?php
                                                    $totalDebe = 0;
                                                    $totalHaber = 0;
                                                    $totalSaldo = 0;
                                                    $sumatotal = 0;
                                                    $suma = 0;
                                                    $saldoD = 0;
                                                    foreach ($operations as $credy) :
                                                        $venta = VentaData::getbyfactura($credy->nrofactura, $_GET['id_sucursal']);
                                                        $ventas2 = MonedaData::cboObtenerValorPorSucursal2($credy->sucursal_id, $credy->moneda_id);
                                                        if (count($ventas2) > 0) {

                                                            $simbolomon = 0;
                                                            foreach ($ventas2 as $simbolos) {
                                                                $simbolomon = $simbolos->simbolo;
                                                            }
                                                        }



                                                    ?>
                                                        <tr>

                                                            <td style="text-align: center;">
                                                                <?= $credy->credito_id; ?>
                                                            </td>

                                                            <td class="width:30px;">


                                                                <?php if ($credy->getCliente($_GET['cliente_id']) == "SIN NOMBRE") {
                                                                    $credy->getCliente($_GET['cliente_id'])->tipo_doc;
                                                                    $cliente = $credy->getCliente($_GET['cliente_id'])->tipo_doc;
                                                                    echo $cliente;
                                                                } else {
                                                                    $credy->getCliente($_GET['cliente_id'])->nombre . " " . $credy->getCliente($_GET['cliente_id'])->apellido;
                                                                    $cliente = $credy->getCliente($_GET['cliente_id'])->nombre . " " . $credy->getCliente($_GET['cliente_id'])->apellido;

                                                                    echo $cliente;
                                                                }                                                ?>


                                                            </td>
                                                            <td style="text-align: center;;"><?= $credy->nrofactura; ?>
                                                            </td>
                                                            <td style="text-align: center;;"><?= $credy->cuota; ?></td>

                                                            <td style="text-align: center;;"><?= $simbolomon; ?></td>

                                                            <td>
                                                                <?php
                                                                $totalC = 0;
                                                                $totalcobro = 0;
                                                                $totalcobrof = 0;



                                                                $users = CobroCabecera::totalcobrosG($_GET['id_sucursal'], $_GET['cliente_id'], $_GET['sd'], $_GET['ed'], $credy->credito_id);
                                                                foreach ($users as $Co) {



                                                                    $totalcobro += $Co->TOTAL_COBRO;
                                                                }
                                                                // $coDetalle =  CobroDetalleData::cobranza_credito($Co->COBRO_ID);


                                                                $ventaData = VentaData::buscarFactura($_GET['id_sucursal'], $credy->nrofactura);
                                                                // var_dump($ventaData);
                                                                $totalcobro += $ventaData->total;
                                                                $totalDebe += $totalcobro;



                                                                echo
                                                                number_format($totalcobro, 2, ',', '.');
                                                                // $totalcobro = $users->TOTAL_COBRO;
                                                                ?>
                                                            </td>


                                                            <td style="text-align: center"><?= number_format($credy->importe_credito, 2, ',', '.'); ?> </td>


                                                            <td style="text-align: center"><?php
                                                                                            $saldoD += $credy->importe_credito;
                                                                                            $saldoD -= $totalcobro;

                                                                                            echo number_format($saldoD, 2, ',', '.'); ?> </td>




                                                            <td style="text-align: center;"><input <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                                                                }  ?> type="hidden" class="form-control" name="sucursall[]" id="sucursall" value="<?php echo $sucursal; ?>"><?= $credy->fecha; ?></td>
                                                            <td style="text-align: center;" <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                                                        }  ?>><?= $credy->fecha_detalle; ?></td>

                                                        </tr>
                                                        <?php

                                                        // $totalDebe += $totalcobro;
                                                        $totalHaber += $credy->importe_credito;
                                                        $totalSaldo += $credy->importe_credito - $totalcobro;

                                                        ?>


                                                    <?php





                                                    endforeach; ?>
                                                    <tr style="margin-top: 10px;">

                                                        <td style="text-align: center;">
                                                            <p style="display: none;">zzz</p><b>
                                                                Total:</b>
                                                        </td>
                                                        <td style="text-align: center;;">
                                                        </td>
                                                        <td style="text-align: center;;">
                                                        </td>
                                                        <td style="text-align: center;;"></td>

                                                        <td style="text-align: center;;"></td>





                                                        <td style="text-align: center;"><b> <?php echo number_format($totalDebe, 2, ',', '.')  ?></b></td>


                                                        <td style="text-align: center"> <b><?php echo number_format($totalHaber, 2, ',', '.') ?></b></td>


                                                        <td style="text-align: center"><b> <?php echo number_format($totalHaber - $totalDebe, 2, ',', '.') ?></b></td>




                                                        <td>
                                                            <p style="display: none;">9999-12-12</p>
                                                        </td>
                                                        <td>
                                                            <p style="display: none;">9999-12-12</p>
                                                        </td>

                                                    </tr>
                                                </table>
                                                <br>
                                                <hr>


                                                <div class="row">
                                                    <div class="col-lg-2">


                                                        <td><b>Total a cobrar: <?php echo  number_format($totalSaldo, 2, ',', '.'); ?></b></td>



                                                    </div>


                                                </div>



                                        </form>

                                        <div class="row">


                                            <div class="col-lg-2 ">
                                                <p class="btn btn-success mt-4" onclick="imprimir()"> Imprimir</p>

                                            </div>

                                            <div class="col-lg-2 ">
                                                <p class="btn btn-success mt-4" onclick="excel()"> Excel</p>

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







                    <?php endif; ?>

                <?php endif; ?>

                    </div>
                </div>
        </div>
        </section>
        <script>
            function imprimir() {
                window.open('pdfs/estados.php?cliente_id=<?= $_GET['cliente_id'] ?>&sd=<?= $_GET['sd'] ?>&ed=<?= $_GET['ed'] ?>&id_sucursal=<?= $_GET['id_sucursal'] ?>')
            }


            function excel() {
                window.open('excels/csvestadocuentas.php?cliente_id=<?= $_GET['cliente_id'] ?>&sd=<?= $_GET['sd'] ?>&ed=<?= $_GET['ed'] ?>&id_sucursal=<?= $_GET['id_sucursal'] ?>')
            }
        </script>
        </div>

    <?php endif ?>
<?php endif ?>