<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" type="text/css" href="ticket.css">
    <script>
        function printPantalla() {
            document.getElementById('cuerpoPagina').style.marginRight = "0";
            document.getElementById('cuerpoPagina').style.marginTop = "1";
            document.getElementById('cuerpoPagina').style.marginLeft = "1";
            document.getElementById('cuerpoPagina').style.marginBottom = "0";
            document.getElementById('botonPrint').style.display = "none";
            window.print();
        }
    </script>
    <style>
        @page {
            size: A4;
            margin: auto
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;

            }

            /* ... the rest of the rules ... */
        }
    </style>
</head>

<body id="cuerpoPagina">
    <?php
    include "core/autoload.php";
    include "core/modules/index/model/CreditoDetalleData.php";
    include "core/modules/index/model/CreditoData.php";
    include "core/modules/index/model/SuccursalData.php";
    include "core/modules/index/model/VentaData.php";
    include "core/modules/index/model/ClienteData.php";
    include "core/modules/index/model/ConfigFacturaData.php";
    include "core/modules/index/model/CobroDetalleData.php";
    include "core/modules/index/model/MonedaData.php";
    include "CifrasEnLetras.php";
    $sucur = SuccursalData::VerId($_GET["id_sucursal"]);
    ?>
    <div class="zona_impresion" style="width: 70%;margin:0px 100px">
        <?php if (isset($_GET["sd"]) && isset($_GET["ed"])) :  if ($_GET["sd"] != "" && $_GET["ed"] != "") :
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
                    $sucur = SuccursalData::VerId($_GET["id_sucursal"]);
        ?>
                    <div class="" style="text-align: center;">
                        <img src="./<?php echo $sucur->logo ?>" height="150" alt="">
                    </div>
                    <br>

                    <h1 style="text-align: center;">INFORME DE EXTRACTO DE CUENTAS DE CLIENTES</h1>
                    <span style="margin-left: 65%;">
                        Fecha: <?= date('d', time());
                                echo "/" . date('n');
                                echo "/" . date('Y', time()); ?>
                    </span>

                    <h4>Desde : <?php echo $_GET["sd"] ?>

                    </h4>
                    <h4>Hasta : <?php echo $_GET["ed"] ?> </h4>



                    <div class="col-md-12" style="margin: auto;">

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

                        <table class="table table-bordered table-hover table-responsive " style="display: none;">
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
                            $totalcobro = 0;
                            $saldoanterior = 0;
                            $totalDebe = 0;
                            $totalHaber = 0;
                            $totalSaldo = 0;
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
                                    <td style="text-align: center;">


                                        <?php



                                        $operations2 = CobroDetalleData::cobranza_creditosum($credy->credito_id, $credy->cuota);
                                        //$cred = $operations[0]->IMPORTE_CREDITO;
                                        $totalcobro = 0;
                                        if (count($operations2) > 0) {

                                            foreach ($operations2 as $op) {

                                        ?>

                                                <?php




                                                $COBRO_ID = $op->COBRO_ID;

                                                ?>
                                                <?php




                                                $operations3 = CreditoDetalleData::busq_estado($COBRO_ID, $_GET["cliente_id"], $_GET["sd"], $_GET["ed"], $_GET["id_sucursal"]);
                                                //$cred = $operations[0]->IMPORTE_CREDITO;

                                                if (count($operations3) > 0) {

                                                    foreach ($operations3 as $op2) {
                                                        // if ($op2->FECHA <= $_GET['ed'] && $op2->FECHA >= $_GET['sd']) {
                                                ?>


                                                        <?php


                                                        $saldoanterior  += $op2->TOTAL_COBRO;
                                                        // }

                                                        ?>

                                                <?php

                                                    }
                                                }
                                                ?>






                                        <?php

                                            }
                                        }
                                        ?>






                                        <?php

                                        ?>

                                        <?= number_format($totalcobro, 2, ',', '.');   ?></td>


                                    <td style="text-align: center"><?= number_format($credy->importe_credito, 2, ',', '.'); ?> </td>


                                    <td style="text-align: center"><?= number_format($credy->importe_credito - $totalcobro, 2, ',', '.'); ?> </td>




                                    <td style="text-align: center;"><input <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                                        }  ?> type="hidden" class="form-control" name="sucursall[]" id="sucursall" value="<?php echo $sucursal; ?>"><?= $credy->fecha; ?></td>
                                    <td style="text-align: center;" <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                                }  ?>><?= $credy->fecha_detalle; ?></td>

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

                                $totalDebe += $totalcobro;
                                $totalHaber += $credy->importe_credito;
                                $totalSaldo += $credy->importe_credito - $totalcobro;

                                ?>


                            <?php





                            endforeach; ?>
                            <tr style="margin-top: 10px;">

                                <td style="text-align: center;"><b>
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


                                <td style="text-align: center"><b> <?php echo number_format($totalSaldo, 2, ',', '.') ?></b></td>




                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>

                            </tr>
                        </table>
                        <table class="table table-bordered table-hover table-responsive ">
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
                            $totalHaber = 0;
                            $nuevafecha =  date($_GET["sd"]);
                            $n = date("Y-m-d", strtotime($nuevafecha . "- 1 days"));
                            $operationsante = CreditoDetalleData::getAllByDateBCOp($_GET["cliente_id"], '1988-01-09', $n, $_GET["id_sucursal"]);
                            // var_dump($operationsante);

                            foreach ($operationsante as $credy2) {
                                $operations2 = CobroDetalleData::cobranza_creditosum($credy2->credito_id, $credy2->cuota);
                                //$cred = $operations[0]->IMPORTE_CREDITO;
                                $totalHaber += $credy2->importe_credito;
                                $totalcobro = 0;
                                if (count($operations2) > 0) {

                                    foreach ($operations2 as $op) {

                            ?>

                                        <?php




                                        $COBRO_ID = $op->COBRO_ID;

                                        ?>
                                        <?php




                                        $operations3 = CreditoDetalleData::busq_estado($COBRO_ID, $_GET["cliente_id"], '1988-01-09', $_GET["ed"], $_GET["id_sucursal"]);
                                        //$cred = $operations[0]->IMPORTE_CREDITO;

                                        if (count($operations3) > 0) {

                                            foreach ($operations3 as $op2) {
                                                // if ($op2->FECHA <= $_GET['ed'] && $op2->FECHA >= $_GET['sd']) {
                                        ?>


                                                <?php


                                                $totalcobro += $op2->TOTAL_COBRO;


                                                $totalSaldo += $credy->importe_credito - $totalcobro;
                                                // }

                                                ?>

                                        <?php

                                            }
                                        }
                                        ?>






                                <?php

                                    }
                                }
                                ?>






                                <?php

                                ?>

                            <?php
                                $anterior += $totalcobro;
                                $anterior2 = $totalHaber;
                                $anterior3 = $totalSaldo;
                                // echo number_format($totalcobro, 2, ',', '.');
                                // echo '<br>';
                            }
                            ?>
                            <tr style="margin-top: 10px;">

                                <td style="text-align: center;"><b>
                                        Saldo anterior:</b>
                                </td>
                                <td style="text-align: center;;">
                                </td>
                                <td style="text-align: center;;">
                                </td>
                                <td style="text-align: center;;"></td>

                                <td style="text-align: center;;"></td>





                                <td style="text-align: center;"><b> <?php echo number_format($anterior, 2, ',', '.')  ?></b></td>


                                <td style="text-align: center"><b> <?php echo number_format($anterior2, 2, ',', '.')  ?></b></td>


                                <td style="text-align: center"><b> <?php echo number_format($anterior3, 2, ',', '.')  ?></b></td>




                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>

                            </tr>
                            <?php
                            $totalcobro = 0;
                            $totalDebe = 0;
                            $totalHaber = 0;
                            $totalSaldo = 0;
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
                                    <td style="text-align: center;">


                                        <?php



                                        $operations2 = CobroDetalleData::cobranza_creditosum($credy->credito_id, $credy->cuota);
                                        //$cred = $operations[0]->IMPORTE_CREDITO;
                                        $totalcobro = 0;
                                        if (count($operations2) > 0) {

                                            foreach ($operations2 as $op) {

                                        ?>

                                                <?php




                                                $COBRO_ID = $op->COBRO_ID;

                                                ?>
                                                <?php




                                                $operations3 = CreditoDetalleData::busq_estado($COBRO_ID, $_GET["cliente_id"], $_GET["sd"], $_GET["ed"], $_GET["id_sucursal"]);
                                                //$cred = $operations[0]->IMPORTE_CREDITO;

                                                if (count($operations3) > 0) {

                                                    foreach ($operations3 as $op2) {
                                                        // if ($op2->FECHA <= $_GET['ed'] && $op2->FECHA >= $_GET['sd']) {
                                                ?>


                                                        <?php


                                                        $totalcobro += $op2->TOTAL_COBRO;
                                                        // }

                                                        ?>

                                                <?php

                                                    }
                                                }
                                                ?>






                                        <?php

                                            }
                                        }
                                        ?>






                                        <?php

                                        ?>

                                        <?= number_format($totalcobro, 2, ',', '.');   ?></td>


                                    <td style="text-align: center"><?= number_format($credy->importe_credito, 2, ',', '.'); ?> </td>


                                    <td style="text-align: center"><?= number_format($credy->importe_credito - $totalcobro, 2, ',', '.'); ?> </td>




                                    <td style="text-align: center;"><input <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                                        }  ?> type="hidden" class="form-control" name="sucursall[]" id="sucursall" value="<?php echo $sucursal; ?>"><?= $credy->fecha; ?></td>
                                    <td style="text-align: center;" <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                                }  ?>><?= $credy->fecha_detalle; ?></td>

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

                                $totalDebe += $totalcobro;
                                $totalHaber += $credy->importe_credito;
                                $totalSaldo += $credy->importe_credito - $totalcobro;

                                ?>


                            <?php





                            endforeach; ?>
                            <tr style="margin-top: 10px;">

                                <td style="text-align: center;"><b>
                                        Total:</b>
                                </td>
                                <td style="text-align: center;;">
                                </td>
                                <td style="text-align: center;;">
                                </td>
                                <td style="text-align: center;;"></td>

                                <td style="text-align: center;;"></td>





                                <td style="text-align: center;"><b> <?php echo number_format($totalDebe + $anterior, 2, ',', '.')  ?></b></td>


                                <td style="text-align: center"> <b><?php echo number_format($totalHaber, 2, ',', '.') ?></b></td>


                                <td style="text-align: center"><b> <?php echo number_format($totalSaldo, 2, ',', '.') ?></b></td>




                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>

                            </tr>
                        </table>
                        <br>
                        <hr>


                        <div class="row">
                            <div class="col-lg-2">


                                <td>Total a cobrar: <?php echo  number_format($total, 2, ',', ' '); ?></td>



                            </div>


                        </div>

                        <div style="margin-left:245px;"><button id="botonPrint" onClick="printPantalla()"><img src="printer.png" border="0" style="cursor:pointer" title="Imprimir"></button></div>

                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>

                        <br>
            <?php

                endif;
            endif;
        endif;
            ?>
</body>

</html>