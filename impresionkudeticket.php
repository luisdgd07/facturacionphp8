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
        @media print {
            @page {
                margin: 2px;
                size: auto;
            }
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
    <div class="zona_impresion">
        <table border="0" align="center" width="315px" style="font-size:15pt;color:black;">
            <?php
            $total = 0;
            $ventas = VentaData::getById($_GET["id_venta"]);
            $procesos = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
            ?>
            <thead>

                <tr>
                    <td style="text-align: center; font-size: 20px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center">Kude de Factura Electronica </td>
                </tr>
            </thead>
        </table>
        <table border="0" align="center" width="315px" style="font-size:15pt;color:black;">
            <?php
            $total = 0;
            $ventas = VentaData::getById($_GET["id_venta"]);
            $procesos = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
            ?>
            <thead>

                <tr>

                    <td style=" font-size: 16px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center">
                        DE generado en ambiente de prueba - sin valor comercial ni fiscal
                    </td>

                </tr>
                <tr>
                    <td style="   font-family:  Arial, Helvetica, sans-serif;  " class="text-center">RUC: <?= $ventas->verSocursal()->ruc ?></td>

                </tr>
                <tr>
                    <td style="text-align: center;    font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><b> </b></td>
                    <!-- <td style="text-align: center; font-size: 20px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><b><?= $ventas->verSocursal()->nombre ?> </b></td> -->



                </tr>
                <tr>
                    <td style="    font-family:  Arial, Helvetica, sans-serif;  " class="text-center">
                        <p> DE generado en ambiente de prueba - sin valor comercial ni fiscal</p>
                    </td>
                </tr>
                <tr>
                    <td style="    font-family:  Arial, Helvetica, sans-serif;  " class="text-center">Timbrado Nº:12559590</td>
                </tr>
                <tr>
                    <td style="text-align: center;    font-family:  Arial, Helvetica, sans-serif;  " class="text-center"></td>



                </tr>
                <tr>
                    <td style="   font-family:  Arial, Helvetica, sans-serif;  " class="text-center">
                        Barrio Carolina
                    </td>
                </tr>
                <tr>
                    <td style="     font-family:  Arial, Helvetica, sans-serif;  " class="text-center">Fecha de Vigencia:21/06/2022</td>

                </tr>
                <tr>
                    <td style="text-align: center;    font-family:  Arial, Helvetica, sans-serif;  " class="text-center"></td>
                    <!-- <td style="text-align: center; font-size: 20px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><b><?= $ventas->verSocursal()->nombre ?> </b></td> -->


                </tr>
                <tr>

                    <td style="  font-family:  Arial, Helvetica, sans-serif;  " class="text-center">
                        CAPITAL
                    </td>
                </tr>
                <tr>
                    <td style="     font-family:  Arial, Helvetica, sans-serif;  " class="text-center">Factura electrónica</td>

                </tr>
                <tr>
                    <td style="text-align: center;    font-family:  Arial, Helvetica, sans-serif;  " class="text-center"></td>
                    <!-- <td style="text-align: center; font-size: 20px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><b><?= $ventas->verSocursal()->nombre ?> </b></td> -->



                </tr>
                <tr>
                    <td style=" font-family:  Arial, Helvetica, sans-serif;  " class="text-center">
                        ASUNCION (DISTRITO)
                    </td>
                </tr>
                <tr>
                    <td style="    font-family:  Arial, Helvetica, sans-serif;  " class="text-center">Nº: <?= $ventas->factura ?></td>

                </tr>
                <tr>
                    <td style="text-align: center;    font-family:  Arial, Helvetica, sans-serif;  " class="text-center"></td>
                    <!-- <td style="text-align: center; font-size: 20px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><b><?= $ventas->verSocursal()->nombre ?> </b></td> -->



                </tr>
                <tr>
                    <td style="      font-family:  Arial, Helvetica, sans-serif;  " class="text-center">
                        1234567

                    </td>
                </tr>
                <tr>
                    <td style="    font-family:  Arial, Helvetica, sans-serif;  " class="text-center"></td>

                </tr>
                <tr>
                    <td style="text-align: center;    font-family:  Arial, Helvetica, sans-serif;  " class="text-center"></td>
                    <!-- <td style="text-align: center; font-size: 20px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><b><?= $ventas->verSocursal()->nombre ?> </b></td> -->



                </tr>
                <tr>
                    <td style="    font-family:  Arial, Helvetica, sans-serif;  " class="text-center">
                        DIELOSI@GMAIL.COM

                    </td>
                </tr>
                <tr>
                    <td style="     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"></td>

                </tr>
            </thead>



            <table border="0" align="center" width="315px" style="font-size:15pt;color:black;">
                <thead>

                    <tr>

                        <td>
                            Fecha y hora de emision:<?= $ventas->fecha_envio ?>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            RUC: <?= $ventas->getCliente()->dni ?>

                        </td>
                    </tr>
                    <tr>

                        <td>
                            Condicion Venta : <?php echo  $ventas->metodopago; ?>

                        </td>

                    </tr>
                    <tr>
                        <td>
                            Razón Social: <?php echo $ventas->getCliente()->nombre . ' ' . $ventas->getCliente()->apellido ?>

                        </td>
                    </tr>
                    <tr>

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
                    </tr>
                    <tr>

                        <td>
                            Tipo Cambio: <?php if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                echo  $ventas->cambio2;
                                            } else {
                                                echo  1;
                                            } ?>

                        </td>

                    </tr>
                    <tr>
                        <td>
                            Código Cliente: <?= $ventas->getCliente()->id_cliente ?>


                        </td>
                    </tr>
                    <tr>

                        <td>
                            Tipo Operacion : Venta de mercadería

                        </td>

                    </tr>
                </thead>
            </table>
            <table border="0" align="center" width="315px" style="font-size:15pt;color:black;">
                <thead>
                    <tr>
                        <td style="padding-left: 10px;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                <font size="1.5">Cod&nbsp;&nbsp;</font>
                            </strong></td>
                        <p>
                            <td style="width:50%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                    <font size="1.5">Descripcion&nbsp;&nbsp;</font>
                                </strong></td>
                        </p>
                        <p>
                            <td align="right" style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                    <font size="1.5">Unidad de medida&nbsp;&nbsp;</font>
                                </strong></td>
                        </p>
                        <p>
                            <td align="right" style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                    <font size="1.5">Cantidad&nbsp;&nbsp;</font>
                                </strong></td>
                        </p>
                        <p>
                            <td align="right" style="font-family:  Arial, Helvetica, sans-serif;"><strong>
                                    <font size="1.5">Importe&nbsp;&nbsp;</font>
                                </strong></td>
                        </p>
                        <!-- <p>
                            <td align="right" style="font-family:  Arial, Helvetica, sans-serif;"><strong>
                                    <font size="1.5">Descuentos</font>
                                </strong></td>
                        </p> -->
                        <!-- <p>
                            <td align="right" style="width:30%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                    <font size="1.5">Exenta&nbsp;&nbsp;</font>
                                </strong></td>
                        </p> -->
                        <!-- <p>
                            <td align="right" style="width:30%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                    <font size="1.5">5%&nbsp;&nbsp;</font>
                                </strong></td>
                        </p> -->
                        <p>
                            <td align="right" style="width:30%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                    <font size="1.5">IVA&nbsp;&nbsp;</font>
                                </strong></td>
                        </p>
                    </tr>
                    <?php foreach ($procesos as $proceso) :
                        $ventas1  = $proceso->getProducto(); ?>
                        <tr>
                            <p>
                                <td style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"><?= $ventas1->codigo ?></td>
                            </p>
                            <p>
                                <td style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"><?= $ventas1->nombre ?></td>
                            </p>
                            <p>
                                <td style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;">Unidad</td>
                            </p>
                            <p>
                                <td style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"> <?= $proceso->q ?>&nbsp;&nbsp;</td>
                            </p>
                            <p>
                                <td align="right" style=" font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?= number_format(($proceso->precio), 2, ',', '.') ?>&nbsp;&nbsp;</td>
                            </p>

                            <p>
                                <td align="right" style="font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?php

                                                                                                                        if ($ventas1->impuesto == 5) {

                                                                                                                            echo number_format(($proceso->precio) / 21, 2, ',', '.');
                                                                                                                        } else if ($ventas1->impuesto == 10) {
                                                                                                                            echo number_format(($proceso->precio) / 11, 2, ',', '.');
                                                                                                                        } else {
                                                                                                                            echo "0,00";
                                                                                                                        }
                                                                                                                        ?></td>
                            </p>
                        </tr>
                    <?php endforeach ?>

                    <br />


                </thead>
            </table>
            <table border="0" align="center" width="315px" style="font-size:15pt;color:black;">
                <thead>
                    <tr>
                        <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                            SUBTOTAL:
                        </td>
                        <td></td>
                        <td></td>

                        <td></td>

                        <td></td>

                        <td></td>
                        <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                            <?= number_format($total, 2, ',', '.') ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                            TOTAL DE LA OPERACION:
                        </td>
                        <td></td>
                        <td></td>

                        <td></td>

                        <td></td>

                        <td></td>
                        <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                            <?= number_format($total, 2, ',', '.') ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                            TOTAL EN GUARANIES:
                        </td>
                        <td></td>
                        <td></td>

                        <td></td>

                        <td></td>

                        <td></td>

                        <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                            <?= number_format($total, 2, ',', '.') ?>
                        </td>
                    </tr>
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
            <table border="0" align="center" width="315px" style="font-size:15pt;color:black;">
                <thead>

                    <tr>

                        <td>
                            <?php

                            QRcode::png($ventas->kude, "./qr.png", QR_ECLEVEL_L, 2, 2);
                            echo "<div><img src='./qr.png'/></div>";
                            ?>
                        </td>
                        <td>
                            <h3>Consulte la validez de esta Factura Electrónica con el número de CDC
                                https://ekuatia.set.gov.py/consultas</h3>

                            <br>
                            <h4> CDC:
                                <?php
                                echo $ventas->cdc;
                                ?></h4>

                        </td>
                    </tr>

                </thead>
            </table>

            <!--  -->



    </div>
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
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>

    <div style="margin-left:245px;"><a href="#" id="botonPrint" onClick="printPantalla();"><img src="printer.png" border="0" style="cursor:pointer" title="Imprimir"></a></div>
</body>

</html>