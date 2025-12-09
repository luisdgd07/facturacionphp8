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
        <table border="0" align="center" width="915px" style="font-size:15pt;border-right: #000 1px solid;color:black;border-left: #000 1px solid;">
            <?php
            $total = 0;
            $ventas = VentaData::getById($_GET["id_venta"]);
            $procesos = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
            ?>
            <thead>
                <tr>

                    <td>
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; font-size: 20px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><b>Kude de Nota de crédito </b></td>
                </tr>
                <!-- <?= $ventas->verSocursal()->nombre ?> -->
                <tr>

                    <td>
                        <hr>
                    </td>
                </tr>
                <!-- <tr>
                    <td style="text-align: center; font-size: 13px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><?= $ventas->verSocursal()->direccion ?></td>

                </tr> -->

                <!-- <tr>
                    <td style="text-align: center; font-size: 13px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><?= $ventas->verSocursal()->descripcion ?></td>
                </tr> -->

                <!-- <tr>
                    <td style="padding-left: 50px;padding-top: 14px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Ruc: <?= $ventas->verSocursal()->ruc ?></td>
                </tr>
                <tr>
                    <td style="padding-left: 50px;padding-top: 14px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"> Telef.: <?= $ventas->verSocursal()->telefono ?></td>
                </tr>
                <tr>
                    <td style="padding-left: 50px;padding-top: 14px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Timbrado: <?= $ventas->VerConfiFactura()->timbrado1 ?></td>
                </tr>
                <tr>
                    <td style="padding-left: 50px;padding-top: 14px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;;" class="text-center">Vigencia desde: <?= date("d/m/Y", strtotime($ventas->VerConfiFactura()->inicio_timbrado)) ?></td>
                </tr>
                <tr>
                    <td style="padding-left: 50px;padding-top: 14px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;;" class="text-center">Vigencia hasta: <?= date("d/m/Y", strtotime($ventas->VerConfiFactura()->fin_timbrado)) ?></td>
                </tr>
                <tr>
                    <td style="padding-left: 45px;padding-top: 14px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"><strong>
                            <?php if ($ventas->numerocorraltivo >= 1 & $ventas->numerocorraltivo < 10) : ?>
                                <?= $ventas->VerConfiFactura()->comprobante1 . " " . $ventas->metodopago . " Nro: " . $ventas->VerConfiFactura()->serie1 . "-" . "000000" . $ventas->numerocorraltivo ?>
                            <?php else : ?>
                                <?php if ($ventas->numerocorraltivo >= 10 & $ventas->numerocorraltivo < 100) : ?>
                                    <?= $ventas->VerConfiFactura()->comprobante1 . " " . $ventas->metodopago . " Nro: " . $ventas->VerConfiFactura()->serie1 . "-" . "00000" . $ventas->numerocorraltivo ?>
                                <?php else : ?>
                                    <?php if ($ventas->numerocorraltivo >= 100 & $ventas->numerocorraltivo < 1000) : ?>
                                        <?= $ventas->VerConfiFactura()->comprobante1 . " " . $ventas->metodopago . " Nro: " . $ventas->VerConfiFactura()->serie1 . "-" . "0000" . $ventas->numerocorraltivo ?>
                                    <?php else : ?>
                                        <?php if ($ventas->numerocorraltivo >= 1000 & $ventas->numerocorraltivo < 10000) : ?>
                                            <?= $ventas->VerConfiFactura()->comprobante1 . " " . $ventas->metodopago . " Nro: " . $ventas->VerConfiFactura()->serie1 . "-" . "000" . $ventas->numerocorraltivo ?>
                                        <?php else : ?>
                                            <?php if ($ventas->numerocorraltivo >= 100000 & $ventas->numerocorraltivo < 1000000) : ?>
                                                <?= $ventas->VerConfiFactura()->comprobante1 . " " . $ventas->metodopago . " Nro: " . $ventas->VerConfiFactura()->serie1 . "-" . "00" . $ventas->numerocorraltivo ?>
                                            <?php else : ?>
                                                <?php if ($ventas->numerocorraltivo >= 1000000 & $ventas->numerocorraltivo < 10000000) : ?>
                                                    <?= $ventas->VerConfiFactura()->comprobante1 . " " . $ventas->metodopago . " Nro: " . $ventas->VerConfiFactura()->serie1 . "-" . "0" . $ventas->numerocorraltivo ?>
                                                <?php else : ?>
                                                    SIN ACCION
                                                <?php endif ?>
                                            <?php endif ?>
                                        <?php endif ?>
                                    <?php endif ?>
                                <?php endif ?>
                            <?php endif ?>
                            <strong></td>
                </tr>

                <tr>
                    <td style="padding-left: 50px;padding-top: 15px; font-size: 15px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Cliente: <?php if ($ventas->getCliente()->tipo_doc == "SIN NOMBRE") {
                                                                                                                                                                    echo  $ventas->getCliente()->tipo_doc;
                                                                                                                                                                } else {
                                                                                                                                                                    echo  $ventas->getCliente()->nombre . " " . $ventas->getCliente()->apellido;
                                                                                                                                                                } ?>

                        <?php


                        ?></td>
                </tr>
                <tr>
                    <td style="padding-left: 50px;padding-top: 15px; font-size: 15px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Ruc: <?= $ventas->getCliente()->dni ?></td>

                </tr>

                <tr>

                    <td style="padding-left: 50px;padding-top: 15px; font-size: 15px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Direc: <?= $ventas->getCliente()->direccion ?></td>
                </tr>

                <tr>
                    <td style="padding-left: 50px;padding-top: 15px; font-size: 15px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Telef.: <?= $ventas->getCliente()->telefono ?></td>
                </tr>

                <tr>
                    <td style="padding-left: 50px;padding-top: 15px; font-size: 15px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Fecha: <?= date("d/m/Y", strtotime($ventas->fecha)) ?></td>
                </tr>

                <tr>
                    <td style="padding-left: 50px;padding-top: 15px; font-size: 15px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Atendido por: <?= $ventas->getUser()->nombre . " " . $ventas->getUser()->apellido ?></td>
                </tr>
                <tr>


                    <td>******************************************************************************</td>
                </tr> -->

            </thead>
        </table>
        <table border="0" align="center" width="915px" style="font-size:15pt;border-right: #000 1px solid;color:black;border-left: #000 1px solid;">
            <thead>

                <tr>

                    <td>
                        <hr>
                    </td>
                </tr>

            </thead>
        </table>
        <table border="0" align="center" width="915px" style="font-size:15pt;border-right: #000 1px solid;color:black;border-left: #000 1px solid;">
            <?php
            $total = 0;
            $ventas = VentaData::getById($_GET["id_venta"]);
            $procesos = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
            ?>
            <thead>

                <tr>
                    <td style="text-align: center; font-size: 16px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><img height="100" src="./<?php echo $ventas->verSocursal()->logo ?>" alt=""></td>

                    <td style=" font-size: 16px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center">
                        <h5><b><?php echo $ventas->verSocursal()->razon_social ?></b></h5>
                    </td>
                    <td style="   font-family:  Arial, Helvetica, sans-serif;  " class="text-center">RUC:<?php echo $ventas->verSocursal()->ruc ?></td>

                </tr>
                <tr>
                    <td style="text-align: center;    font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><b> </b></td>

                    <td style="    font-family:  Arial, Helvetica, sans-serif;  " class="text-center">
                        <p><?php echo $ventas->verSocursal()->nombre_fantasia ?></p>
                    </td>
                    <td style="    font-family:  Arial, Helvetica, sans-serif;  " class="text-center">Timbrado Nº:<?= $ventas->verSocursal()->timbrado ?> </td>

                </tr>
                <tr>
                    <td style="text-align: center;    font-family:  Arial, Helvetica, sans-serif;  " class="text-center"></td>

                    <td style="   font-family:  Arial, Helvetica, sans-serif;  " class="text-center">
                        <?= $ventas->verSocursal()->ciudad_descripcion ?>
                    </td>
                    <td style="     font-family:  Arial, Helvetica, sans-serif;  " class="text-center">Fecha de Vigencia:21/06/2022</td>

                </tr>
                <tr>
                    <td style="text-align: center;    font-family:  Arial, Helvetica, sans-serif;  " class="text-center"></td>

                    <td style="  font-family:  Arial, Helvetica, sans-serif;  " class="text-center">
                        <?= $ventas->verSocursal()->distrito_descripcion ?>
                    </td>
                    <td style="     font-family:  Arial, Helvetica, sans-serif;  " class="text-center">Nota de credito electrónica</td>

                </tr>
                <tr>
                    <td style="text-align: center;    font-family:  Arial, Helvetica, sans-serif;  " class="text-center"></td>

                    <td style=" font-family:  Arial, Helvetica, sans-serif;  " class="text-center">
                        <?= $ventas->verSocursal()->departamento_descripcion ?>
                    </td>
                    <td style="    font-family:  Arial, Helvetica, sans-serif;  " class="text-center">Nº: <?= $ventas->factura ?></td>

                </tr>
                <tr>
                    <td style="text-align: center;    font-family:  Arial, Helvetica, sans-serif;  " class="text-center"></td>

                    <td style="      font-family:  Arial, Helvetica, sans-serif;  " class="text-center">
                        <?= $ventas->verSocursal()->telefono ?>

                    </td>
                    <td style="    font-family:  Arial, Helvetica, sans-serif;  " class="text-center"></td>

                </tr>
                <tr>
                    <td style="text-align: center;    font-family:  Arial, Helvetica, sans-serif;  " class="text-center"></td>

                    <td style="    font-family:  Arial, Helvetica, sans-serif;  " class="text-center">
                        <?= $ventas->verSocursal()->email ?>

                    </td>
                    <td style="     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"></td>

                </tr>
            </thead>

        </table>
        <table border="0" align="center" width="915px" style="font-size:15pt;border-right: #000 1px solid;color:black;border-left: #000 1px solid;">
            <thead>

                <tr>

                    <td>
                        <hr>
                    </td>
                </tr>

            </thead>
        </table>
        <table border="0" align="center" width="915px" style="font-size:15pt;border-right: #000 1px solid;color:black;border-left: #000 1px solid;">
            <thead>

                <tr>

                    <td>
                        <hr>
                    </td>
                </tr>

            </thead>
        </table>
        <table border="0" align="center" width="915px" style="font-size:15pt;border-right: #000 1px solid;color:black;border-left: #000 1px solid;">
            <thead>

                <tr>

                    <td>
                        Fecha y hora de emision:<?= $ventas->fecha_envio ?>
                    </td>
                    <td>
                        RUC: <?= $ventas->getCliente()->dni ?>

                    </td>
                </tr>

                <tr>

                    <td>
                        Condicion Venta : <?php echo  $ventas->metodopago; ?>

                    </td>
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
                    <td>
                        Dirección: <?= $ventas->getCliente()->direccion ?>


                    </td>
                </tr>
                <tr>

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
                    <td>
                        Código Cliente: <?= $ventas->getCliente()->id_cliente ?>


                    </td>
                </tr>
                <tr>

                    <td>
                        Tipo Operacion : Venta de mercadería

                    </td>
                    <td>


                    </td>
                </tr>
            </thead>
        </table>
        <table border="0" align="center" width="915px" style="font-size:15pt;border-right: #000 1px solid;color:black;border-left: #000 1px solid;">
            <thead>

                <tr>

                    <td>
                        <hr>
                    </td>
                </tr>

            </thead>
        </table>
        <table border="0" align="center" width="915px" style="font-size:15pt;margin-top: -26px;border-right: #000 1px solid;color:black;border-left: #000 1px solid;">
            <thead>
                <tr>
                    <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            <font size="1.5">Cod</font>
                        </strong></td>
                    <p>
                        <td style="width:30%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                <font size="1.5">Descripcion</font>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:20%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                <font size="1.5">Unidad de medida</font>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                <font size="1.5">Cantidad</font>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                <font size="1.5">Precio Unitario</font>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                <font size="1.5">Descuentos</font>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:50%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                <font size="1.5">Exenta</font>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                <font size="1.5">5%</font>
                            </strong></td>
                    </p>
                    <p>
                        <td align="right" style="width:30%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                <font size="1.5">10%</font>
                            </strong></td>
                    </p>
                </tr>
                <?php foreach ($procesos as $proceso) :
                    $ventas1  = $proceso->getProducto();
                    $total += $proceso->precio * $proceso->q;
                ?>
                    <tr>
                        <p>
                            <td style=" width:10%;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"><?= $ventas1->codigo ?></td>
                        </p>
                        <p>
                            <td style="width:30%; font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"><?= $ventas1->nombre ?></td>
                        </p>
                        <p>
                            <td style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;">Unidad</td>
                        </p>
                        <p>
                            <td style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"> <?= $proceso->q ?></td>
                        </p>
                        <p>
                            <td style=" font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?= number_format(($proceso->precio), 2, ',', '.') ?></td>
                        </p>
                        <p>
                            <td style="font-size: 14px;font-family:  Arial, Helvetica, sans-serif;">0,00</td>
                        </p>
                        <p>
                            <td style="font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?php

                                                                                                    if ($ventas1->impuesto == 0) {

                                                                                                        echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                                                                                    } else {
                                                                                                        echo "0,00";
                                                                                                    }
                                                                                                    ?></td>
                        </p>
                        <p>
                            <td style="font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?php

                                                                                                    if ($ventas1->impuesto == 5) {

                                                                                                        echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                                                                                    } else {
                                                                                                        echo "0,00";
                                                                                                    }
                                                                                                    ?></td>
                        </p>
                        <p>
                            <td align="right" style="font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?php
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


            </thead>
        </table>
        <table border="0" align="center" width="915px" style="font-size:15pt;border-right: #000 1px solid;color:black;border-left: #000 1px solid;">
            <thead>

                <tr>

                    <td>
                        <hr>
                    </td>
                </tr>

            </thead>
        </table>
        <table border="0" align="center" width="915px" style="font-size:15pt;border-right: #000 1px solid;color:black;border-left: #000 1px solid;">
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
                        <?= number_format($total * $cambio, 2, ',', '.') ?>
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
        <table border="0" align="center" width="915px" style="font-size:15pt;border-right: #000 1px solid;color:black;border-left: #000 1px solid;">
            <thead>

                <tr>

                    <td>
                        <hr>
                    </td>
                </tr>

            </thead>
        </table>
        <table border="0" align="center" width="915px" style="font-size:15pt;border-right: #000 1px solid;color:black;border-left: #000 1px solid;">
            <thead>

                <tr>

                    <td>
                        <hr>
                    </td>
                </tr>

            </thead>
        </table>
        <table border="0" align="center" width="915px" style="font-size:15pt;border-right: #000 1px solid;color:black;border-left: #000 1px solid;">
            <thead>

                <tr>

                    <td>
                        <?php

                        QRcode::png($ventas->kude, "./qr.png", QR_ECLEVEL_L, 2, 2);
                        echo "<div><img src='./qr.png'/></div>";
                        ?>
                    </td>
                    <td>
                        <h3>Consulte la validez de esta Nota de Credito Electronica con el número de CDC
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
        <table border="0" align="center" width="915px" style="font-size:15pt;border-right: #000 1px solid;color:black;border-left: #000 1px solid;">
            <thead>

                <tr>

                    <td>
                        <hr>
                    </td>
                </tr>

            </thead>
        </table>
        <!--  -->



    </div>

    <div style="margin-left:245px;"><a href="#" id="botonPrint" onClick="printPantalla();"><img src="printer.png" border="0" style="margin-left: 700px;cursor:pointer" title="Imprimir"></a></div>
</body>

</html>