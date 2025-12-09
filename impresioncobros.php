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

            // for (var i = 0; i < elms.length; i++) {

            //     elms[i].style.marginBottom = "-125px";

            // }
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
    include "core/modules/index/model/CobroCabecera.php";
    include "core/modules/index/model/CobroDetalleData.php";
    include "core/modules/index/model/CajaDetalle.php";
    include "core/modules/index/model/CajaCabecera.php";
    include "core/modules/index/model/RetencionDetalleData.php";
    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    ?>
    <div class="zona_impresion">


        <div id="impresion" style="
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  ">


            <div class="col-md-12">
                <?php
                $sumatotal = 0;
                $suma = 0;
                $total1 = 0;
                $total2 = 0;
                $totalDebe = 0;
                $total3 = 0;

                $operations = array();
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
                </div><?php
                        if ($_GET["cliente"] == "todos") {
                            $operations = CreditoDetalleData::getAllByDateOp2($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
                        } else {
                            $operations = CreditoDetalleData::getAllByDateBCOp2($_GET["cliente"], $_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
                        }
                        foreach ($operations as $credy) :

                            // aca obtenfo el simbolo de la mondeda
                            $ventas2 = MonedaData::cboObtenerValorPorSucursal2($_GET["id_sucursal"], $credy->moneda_id);
                            if (count($ventas2) > 0) {

                                $simbolomon = 0;
                                foreach ($ventas2 as $simbolos) {
                                    $simbolomon = $simbolos->simbolo;
                                }
                            }


                        ?>




                <?php





                        endforeach; ?>
                <?php
                $users = CobroCabecera::totalcobros($_GET['id_sucursal'], $_GET['cliente'], $_GET['sd'], $_GET['ed']);
                // var_dump($users);

                //if(count($users)>0){


                ?>
                <table class="table table-bordered table-dark" style="width:100%">
                    <thead>
                        <th>NRO CREDITO</th>

                        <th>RECIBO</th>

                        <th>CLIENTE</th>

                        <th>IMPORTE COBRO</th>
                        <th>IMPORTE CREDITO</th>

                        <th>SALDO</th>

                        <th>FECHA</th>
                        <th>FACTURA</th>
                        <th>RETENCION</th>


                    </thead>
                    <tbody>
                        <?php
                        $totalcobro = 0;
                        $totalcred = 0;
                        $totalsaldo = 0;
                        $totalret = 0;

                        $j = 0;
                        foreach ($users as $sell) {

                            if ($sell) {
                                $operations = CobroDetalleData::cobranza_credito($sell->COBRO_ID);
                                $cred = $operations[0]->IMPORTE_CREDITO;
                                foreach ($operations as $op) {
                                    $concepto = CajaCabecera::cajacabeceraconcepto($sell->COBRO_ID);
                                    if ($concepto[0]->FECHA <= $_GET['ed'] && $concepto[0]->FECHA >= $_GET['sd']) {
                        ?>
                                        <tr>
                                            <?php
                                            // $operations = CobroDetalleData::totalcobrosdet($sell->COBRO_ID );
                                            //count($operations);

                                            ?>


                                            <td><?php
                                                $j++;
                                                // var_dump($op);
                                                echo $op->NUMERO_CREDITO;

                                                ?></td>
                                            <td class="width:30px;">

                                                <?php echo $sell->RECIBO; ?>

                                            </td>





                                            <td class="width:30px;">


                                                <?php if ($sell->getCliente()->tipo_doc == "SIN NOMBRE") {
                                                    $sell->getCliente()->tipo_doc;
                                                    $cliente = $sell->getCliente()->tipo_doc;
                                                    echo $cliente;
                                                } else {
                                                    $sell->getCliente()->nombre . " " . $sell->getCliente()->apellido;
                                                    $cliente = $sell->getCliente()->nombre . " " . $sell->getCliente()->apellido;

                                                    echo $cliente;
                                                }                                                ?>


                                            </td>






                                            <td><?php
                                                $totalcobro += $sell->TOTAL_COBRO;
                                                echo $sell->TOTAL_COBRO
                                                ?></td>


                                            <?php $concepto = CajaDetalle::cajadetllecambio($sell->COBRO_ID); ?>



                                            <td><?php echo $op->IMPORTE_CREDITO;
                                                $totalcred += $op->IMPORTE_CREDITO;
                                                ?></td>


                                            <td><?php
                                                $cred -= $sell->TOTAL_COBRO;
                                                $totalsaldo += $cred;

                                                echo $cred; ?></td>









                                            <td><?php
                                                $concepto = CajaCabecera::cajacabeceraconcepto($sell->COBRO_ID);
                                                echo $concepto[0]->FECHA ?></td>

                                            <?php $concepto = CajaCabecera::cajacabeceraconcepto($sell->COBRO_ID); ?>
                                            <?php

                                            foreach ($concepto as $cobrosdet) {
                                                if ($cobrosdet) {


                                                    $conceptos = $cobrosdet->concepto;
                                                }
                                            }

                                            ?>
                                            <td><?php echo $op->NUMERO_FACTURA; ?></td>

                                            <td>
                                                <?php
                                                $totalRetencion = 0;
                                                $facturas = RetencionDetalleData::retencionfactura($op->NUMERO_FACTURA);
                                                // var_dump($facturas);
                                                foreach ($facturas as $fact) {
                                                    $totalRetencion += (float) $fact->importe;
                                                }
                                                $totalret += $totalRetencion;
                                                echo $totalRetencion;
                                                ?>
                                            </td>



                                        </tr>
                        <?php
                                    }
                                }
                            }
                        }
                        // }else{
                        // echo "<p class='alert alert-danger'>No hay cobro realizado</p>";
                        //}
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo $totalcobro ?></td>
                            <td><?php echo $totalcred ?></td>
                            <td><?php echo $totalsaldo ?></td>
                            <td></td>
                            <td></td>

                            <td><?php echo $totalret ?></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <hr>







            </div>
        </div>


    </div>
    <br>


    <br>
    </div>
    <div style="margin-left:245px;"><a href="#" id="botonPrint" onClick="printPantalla();"><img src="printer.png" border="0" style="cursor:pointer" title="Imprimir"></a></div>

    <!-- <div style="margin-left:445px;" class=""><a href="/index.php?view=cobranza1&id_sucursal=<?php echo $detalle->SUCURSAL_ID ?>">Volver</a></div> -->


    <br>
</body>

</html>