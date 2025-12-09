<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" type="text/css" href="ticket.css">
    <script>
        document.getElementById('cuerpoPagina').style.marginRight = "0";
        document.getElementById('cuerpoPagina').style.marginTop = "1";
        document.getElementById('cuerpoPagina').style.marginLeft = "1";
        document.getElementById('cuerpoPagina').style.marginBottom = "0";
        // document.getElementById('botonPrint').style.display = "none";

        function printPantalla() {
            // document.getElementById('cuerpoPagina').style.marginRight = "0";
            // document.getElementById('cuerpoPagina').style.marginTop = "1";
            // document.getElementById('cuerpoPagina').style.marginLeft = "1";
            // document.getElementById('cuerpoPagina').style.marginBottom = "0";
            document.getElementById('botonPrint').style.display = "none";
            window.print();
        }
    </script>
    <style>
        body {
            margin: 30px;
        }

        ;



        @media print {
            @page {
                margin: 2px;
                size: auto;
            }
        }

        hr {
            position: relative;
            border: none;
            height: 2px;
            background: black;
        }


        .borde-l {
            border-left: 1px solid black;
        }

        .borde-r {
            border-right: 1px solid black;
        }

        .borde-t {
            border-top: 1px solid black;
        }

        .borde-b {
            border-bottom: 1px solid black;
        }


        .table:has(th,
            td) {

            border-color: #000;
            border-style: solid;
        }
    </style>
</head>

<body id="cuerpoPagina">




    <?php
    include "core/autoload.php";
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
    include "qr/qrlib.php";
    ?>
    <div>
        <h3 class="borde-l borde-r borde-b borde-t" style="text-align: center; font-size: 25px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><b>Kude de Remisión Electrónica </b></h3>
        <?php
        $total = 0;
        $ventas = VentaData::getById($_GET["id_venta"]);
        $procesos = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
        ?>




        <div id=" impresion" style="
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  " ">
     <div style=" margin:5px 0px ;">
            <img height=" 100" width="100" style="margin-right:10px" src="./<?php echo $ventas->verSocursal()->logo ?>" alt="">
            <p>

                <b style="font-size: 22px; "> <?php echo $ventas->verSocursal()->razon_social ?></b>

            </p>
            <!-- <p>

                            <b style="font-size: 13px; ">Sociedad de Responsabilidad Limitada</b>

                        </p> -->


            <p>
                <?php echo $ventas->verSocursal()->direccion . ' - ' . $ventas->verSocursal()->descripcion  ?> - Paraguay
                <!-- Boquerón C/E. Ayala Ciudad del Este - Paraguay -->
            </p>
            <p>
                Tel: <?php echo $ventas->verSocursal()->telefono ?>
                <!-- Tel: (061) 518848 - 501- 650 -->
            </p>

        </div>
        <!-- <img  height=" 150" width="150" style="margin-right:100px" src="./<?php echo $ventas->verSocursal()->logo ?>" alt=""> -->
        <table style="font-size:15pt;     width: 5%; ">
            <?php
            $total = 0;
            $ventas = VentaData::getById($_GET["id_venta"]);
            $procesos = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
            ?>
            <!-- <thead>
                <div style="margin:5px 0px ;">
                    <p>

                        <b style="font-size: 22px; "> <?php echo $ventas->verSocursal()->razon_social ?></b>

                    </p>
                 


                    <p>
                        <?php echo $ventas->verSocursal()->direccion . ' - ' . $ventas->verSocursal()->descripcion  ?> - Paraguay
                        Boquerón C/E. Ayala Ciudad del Este - Paraguay
            </p>
            <p>
                Tel: <?php echo $ventas->verSocursal()->telefono ?>
                Tel: (061) 518848 - 501- 650
            </p>

    </div>



    </thead> -->

        </table>
        <table style="font-size:15pt; ">
            <?php
            $total = 0;
            $ventas = VentaData::getById($_GET["id_venta"]);
            $procesos = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
            ?>
            <thead align="center">

                <tr>

                    <td style="   font-family:  Arial, Helvetica, sans-serif;  " class="text-center">RUC:<?php echo $ventas->verSocursal()->ruc ?></td>

                </tr>
                <tr>

                    <td style="    font-family:  Arial, Helvetica, sans-serif;  " class="text-center">Timbrado Nº:<?= $ventas->verSocursal()->timbrado ?> </td>

                </tr>

                <tr>

                    <td style="     font-family:  Arial, Helvetica, sans-serif;  " class="text-center">
                        <h3> <b>Factura electrónica</b></h3>
                    </td>

                </tr>
                <tr>

                    <td style="    font-family:  Arial, Helvetica, sans-serif;  " class="text-center">
                        <h3><b>Nº: <?= $ventas->factura ?></b> </h3>
                    </td>

                </tr>
                <tr>

                    <td style="    font-family:  Arial, Helvetica, sans-serif;  " class="text-center"></td>

                </tr>
                <tr>

                    <td style="     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"></td>

                </tr>
            </thead>

        </table>
    </div>


    </div>
    <table align="center" class="borde-t " width="100%" style="font-size:15pt; padding: 15px 0px">
        <thead>

            <tr>

                <td>
                    Fecha de Emisión:<?php $ventas->fecha_envio;
                                        // echo substr($ventas->fecha_envio, 0, -9);
                                        echo substr($ventas->fecha_envio, 8, -9);

                                        echo '-' . substr($ventas->fecha_envio, 5, -12);
                                        echo '-' . substr($ventas->fecha_envio, 0, -15);

                                        ?>
                </td>




                <td>
                    Condición Venta : <?php echo  $ventas->metodopago; ?>

                </td>






            </tr>
            <tr>
                <td>
                    RUC: <?= $ventas->getCliente()->dni ?>

                </td>
                <td>
                    Tipo Cambio: <?php
                                    $cambio = 0;
                                    if ($ventas->VerTipoModena()->simbolo == "US$") {
                                        echo  $ventas->cambio2;
                                        $cambio = $ventas->cambio2;
                                    } else {
                                        $cambio = 1;
                                        echo  1;
                                    } ?>

                </td>
            </tr>

            <tr>
                <td>
                    Razón Social: <?php echo $ventas->getCliente()->nombre . ' ' . $ventas->getCliente()->apellido ?>

                </td>

                <td>
                    Moneda:<?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                echo "Guaranies";
                            } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                echo "Dolares";
                            } ?>

                </td>
            </tr>
            <tr>

                <td>
                    Dirección: <?= $ventas->getCliente()->direccion ?>


                </td>


                <td>
                    Tipo Operación :
                    <?php if (!$ventas->cdc_fact == null) { ?>

                        Venta de mercadería
                    <?php } else { ?>
                        Nota de Remisión
                    <?php } ?>
                </td>
            </tr>


            <tr>
                <td>
                    Tel : <?php echo $ventas->getCliente()->telefono ?>

                </td>

                <?php if ($ventas->cdc_fact == null) { ?>

                <?php } else { ?>
                    <td>Tipo de Documento Asociado: Electrónico</td>
                <?php } ?>
            </tr>
            <tr>

                <td>
                    Cel : <?php echo $ventas->getCliente()->celular ?>

                </td>
                <td>
                    Cdc asociado : <?php echo $ventas->cdc_fact ?>

                </td>

            </tr>
        </thead>
    </table>
    <table border="1" width="100%" style="font-size:15pt;margin-top: -26px;  border-collapse: collapse;" class="table">
        <thead>
            <tr>
                <td align="center" style="width:10%;font-family:  Arial, Helvetica, sans-serif; color:black;"><strong>
                        Cod
                    </strong></td>
                <p>
                    <td align="center" style="width:23%;font-family:  Arial, Helvetica, sans-serif; "><strong>
                            Descripción
                        </strong></td>
                </p>
                <p>
                    <td align="center" style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            Unidad de medida
                        </strong></td>
                </p>
                <p>
                    <td align="center" style="width:6%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            Cant
                        </strong></td>
                </p>
                <p>
                    <td align="center" style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            Precio Unitario
                        </strong></td>
                </p>
                <p>
                    <td align="center" style="width:8%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            Descuentos
                        </strong></td>
                </p>
                <p>
                    <td align="center" style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            Exenta
                        </strong></td>
                </p>
                <p>
                    <td align="center" style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            5%
                        </strong></td>
                </p>
                <p>
                    <td align="center" style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            10%
                        </strong></td>
                </p>
            </tr>
            <?php foreach ($procesos as $proceso) :
                $ventas1  = $proceso->getProducto();
                $total += $proceso->precio * $proceso->q;
            ?>
        </thead>
        <tbody>
            <tr>
                <p>
                    <td align="center" style=" width:10%;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"><?= $ventas1->codigo ?></td>
                </p>
                <p>
                    <td align="center" style="width:22%; font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"><?= $ventas1->nombre ?></td>
                </p>
                <p>
                    <td align="center" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;">CAJAS</td>
                </p>
                <p>
                    <td align="center" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"> <?= $proceso->q ?></td>
                </p>
                <p>
                    <td align="center" style=" font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?= number_format(($proceso->precio), 2, ',', '.') ?></td>
                </p>
                <p>
                    <td align="center" style="font-size: 14px;font-family:  Arial, Helvetica, sans-serif;">0,00</td>
                </p>
                <p>
                    <td align="center" style="font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?php

                                                                                                            if ($ventas1->impuesto == 0) {

                                                                                                                echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                                                                                            } else {
                                                                                                                echo "0,00";
                                                                                                            }
                                                                                                            ?></td>
                </p>
                <p>
                    <td align="center" style="font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?php

                                                                                                            if ($ventas1->impuesto == 5) {

                                                                                                                echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                                                                                            } else {
                                                                                                                echo "0,00";
                                                                                                            }
                                                                                                            ?></td>
                </p>
                <p>
                    <td align="center" align="right" style="width:12%; font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?php
                                                                                                                                    if ($ventas1->impuesto == 10) {
                                                                                                                                        echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                                                                                                                    } else {
                                                                                                                                        echo "0,00";
                                                                                                                                    }
                                                                                                                                    ?></td>
                </p>
            </tr>
        <?php endforeach ?>

        <br />
        </tbody>



    </table>

    <table width="100%" style="font-size:15pt;" class="borde-b borde-r borde-l">
        <thead>
            <tr>
                <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    SUBTOTAL:
                </td>

                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    <?= number_format($total, 2, ',', '.') ?>
                </td>
            </tr>





        </thead>
    </table>
    <table width="100%" style="font-size:15pt;" class="borde-b borde-r borde-l">
        <thead>

            <tr>
                <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    TOTAL DE LA OPERACION:
                </td>

                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    <?= number_format($total, 2, ',', '.') ?>
                </td>
            </tr>



        </thead>
    </table>
    <table width="100%" style="font-size:15pt;" class="borde-b borde-r borde-l ">
        <thead>


            <tr>
                <td style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    TOTAL EN GUARANIES:
                </td>


                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    <?= number_format($total * $cambio, 2, ',', '.') ?>
                </td>
            </tr>





        </thead>
    </table>
    <table class="borde-b borde-r borde-l" width="100%">
        <thead>
            <tr>
                <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                    LIQUIDACIÓN IVA:
                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    (5%)
                </td>
                <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    <?= number_format($ventas->iva5, 2, ',', '.') ?>
                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    (10%)
                </td>
                <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    <?= number_format($ventas->iva10, 2, ',', '.') ?>
                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    Total IVA :
                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    <?= number_format($ventas->iva5 + $ventas->iva10, 2, ',', '.') ?>
                </td>
            </tr>

        </thead>
    </table>
    <table width="100%" style="font-size:15pt;" class="borde-b borde-r borde-l ">
        <thead>


            <tr>
                <td style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    Observacion:
                </td>


                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
            </tr>


            <tr>
                <td style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>


                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
            </tr>


        </thead>
    </table>


    <br>

    <table width="100%" style="font-size:15pt;">
        <thead>

            <tr>

                <td class="borde-r borde-l borde-t borde-b">
                    <h3>Consulte la validez de esta Factura Electrónica con el número de CDC
                        https://ekuatia.set.gov.py/consultas</h3>

                    <br>
                    <h4> CDC:
                        <?php
                        echo $ventas->cdc;
                        ?></h4>

                </td>

                <td>
                    <?php

                    QRcode::png($ventas->kude, "./qr.png", QR_ECLEVEL_L, 2, 2);
                    echo "<div><img src='./qr.png'/></div>";
                    ?>
                </td>
            </tr>

        </thead>
    </table>




    </div>


</body>

</html>