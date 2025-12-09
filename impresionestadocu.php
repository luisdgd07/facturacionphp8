<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="">
    <!-- <link rel="stylesheet" type="text/css" href="ticket.css"> -->
    <script>
        function printPantalla() {
            // document.getElementById('cuerpoPagina').style.marginRight = "0";
            // document.getElementById('cuerpoPagina').style.marginTop = "1";
            // document.getElementById('cuerpoPagina').style.marginLeft = "1";
            document.getElementById('cuerpoPagina').style.marginBottom = "0";
            document.getElementById('botonPrint').style.display = "none";
            var elms = document.querySelectorAll("[id='impresion']");

            for (var i = 0; i < elms.length; i++) {

                elms[i].style.marginBottom = "-125px";

            }
            // document.getElementsByClassName("impresion").style.marginBottom = "-125px";
            // document.getElementById('impresion').style.marginBottom = "-125px";
            // document.getElementById('impresion')[1].style.marginBottom = "-125px";
            // document.getElementById('impresion')[2].style.marginBottom = "-125px";
            // document.getElementById('impresion').style.marginBottom = "-125px";
            window.print();
        }
    </script>
    <style>
        @page {
            size: A4;
            margin: 0;
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
    include "core/modules/index/model/ChoferData.php";
    include "core/modules/index/model/VehiculoData.php";
    include "core/modules/index/model/VentaData.php";
    include "core/modules/index/model/SuccursalData.php";
    include "core/modules/index/model/SucursalUusarioData.php";
    include "core/modules/index/model/UserData.php";
    include "core/modules/index/model/ProveedorData.php";
    include "core/modules/index/model/ClienteData.php";
    include "core/modules/index/model/AccionData.php";
    include "core/modules/index/model/MonedaData.php";
    include "core/modules/index/model/OperationData.php";
    include "core/modules/index/model/ConfigFacturaData.php";
    include "core/modules/index/model/ProductoData.php";
    include "core/modules/index/model/CreditoDetalleData.php";
    include "core/modules/index/model/CreditoData.php";
    ?>
    <div class="zona_impresion">


        <div id="impresion" style="
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  ">


            <div class="col-md-12">
                <?php
                $operations = array();
                $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

                if ($_GET["cliente"] == "todos") {
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
                if (count($operations) > 0) {
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
                }
                ?>

                <?php
                $sumatotal = 0;
                $suma = 0;
                $total = 0;
                $operations = array();

                if ($_GET["cliente"] == "todos") {
                    $operations = CreditoDetalleData::getAllByDateOp2($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
                } else {
                    $operations = CreditoDetalleData::getAllByDateBCOp2($_GET["cliente"], $_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
                }
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




                <?php





                endforeach;
                $sucur = SuccursalData::VerId($_GET["id_sucursal"]);

                ?>
                <div class="" style="text-align: end;">
                    <?php
                    $DateAndTime = date('d-m-Y h:i:s a', time());
                    echo " Fecha: $DateAndTime.";
                    ?>
                </div>
                <div class="" style="text-align: center;">
                    <img src="./<?php echo $sucur->logo ?>" height="150" alt="">
                </div>

                <table id="example1" class="table table-bordered table-hover table-responsive ">
                    <thead>
                        <th style="width: 50px !important;">Nº Crédito</th>
                        <th style="width: 50px;">Nº Factura</th>
                        <th style="width: 50px;">Cuota</th>
                        <th style="width: 50px;">Mon</th>
                        <th style="width: 50px;">Importe Crédito</th>
                        <th style="width: 50px;">Importe Cobro</th>
                        <th style="width: 50px;">Saldo</th>
                        <th style="width: 50px;">Fecha Crédito</th>
                        <th style="width: 50px;">Tipo Venta</th>
                    </thead>
                    <?php
                    $total1 = 0;
                    $total2 = 0;
                    $total3 = 0;


                    foreach ($operations as $credy) :
                        $venta = VentaData::getbyfactura($credy->nrofactura, $_GET['id_sucursal']);
                        $ventas2 = MonedaData::cboObtenerValorPorSucursal2($credy->sucursal_id, $credy->moneda_id);




                    ?>
                        <tr>

                            <td>
                                <?= $credy->credito_id; ?>
                            </td>

                            <td>
                                <?= $credy->nrofactura; ?>
                            </td>
                            <td> <?= $credy->cuota; ?></td>
                            <td><?= $simbolomon; ?></td>

                            <td> <?php $total1 += $credy->importe_credito ?><?= $credy->importe_credito; ?></td>
                            <td><?php $total2 += $credy->saldo_credito; ?><?php echo $credy->saldo_credito; ?></td>
                            <td><?php $total3 += ($credy->importe_credito - $credy->saldo_credito) ?><?php echo ($credy->importe_credito - $credy->saldo_credito); ?></td>
                            <td> <?= $credy->fecha; ?></td>
                            <td>VENTAS</td>
                        </tr>

                        <?php

                        ?>


                    <?php





                    endforeach; ?>
                    <tr>

                        <td>
                        </td>

                        <td>

                        </td>
                        <td></td>
                        <td></td>

                        <td> <?= $total1 ?></td>
                        <td><?= $total2 ?></td>
                        <td><?= $total3  ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <br>
                <hr>







            </div>
        </div>


    </div>
    <br>

    <span>
        Fecha:&nbsp;&nbsp; <?= date('d', time());
                            echo " de " . $meses[date('n') - 1];
                            echo " de " . date('Y', time()); ?>&nbsp;&nbsp;
    </span>
    <br>
    </div>
    <div style="margin-left:245px;"><a href="#" id="botonPrint" onClick="printPantalla();"><img src="printer.png" border="0" style="cursor:pointer" title="Imprimir"></a></div>

    <!-- <div style="margin-left:445px;" class=""><a href="/index.php?view=cobranza1&id_sucursal=<?php echo $detalle->SUCURSAL_ID ?>">Volver</a></div> -->


    <br>
</body>

</html>