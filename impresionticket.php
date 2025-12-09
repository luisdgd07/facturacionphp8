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

                    <td>******************************************************************************</td>
                </tr>
                <tr>
                    <td style="text-align: center; font-size: 20px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $ventas->verSocursal()->nombre ?></b></td>
                </tr>

                <tr>
                    <td style="text-align: center; font-size: 13px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">De: <?= $ventas->verSocursal()->representante ?></td>
                </tr>

                <tr>

                    <td>******************************************************************************</td>
                </tr>
                <tr>
                    <td style="text-align: center; font-size: 13px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><?= $ventas->verSocursal()->direccion ?></td>

                </tr>

                <tr>
                    <td style="text-align: center; font-size: 13px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><?= $ventas->verSocursal()->descripcion ?></td>
                </tr>

                <tr>
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
                </tr>
                <!-- <tr>
                <td><strong>PRODUCTO</strong></td>
                <td ><strong><font>CANTIDAD</strong></td>
                <td ><strong>PRECIO</strong></td>
                <td ><strong>TOTAL</strong></td>
            </tr> -->
            </thead>
        </table>
        <table border="0" align="center" width="315px" style="font-size:15pt;color:black;">
            <thead>
                <tr>
                    <td style="padding-left: 10px;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            <font size="1.5">CANT&nbsp;&nbsp;</font>
                        </strong></td>
                    <p>
                        <td style="width:50%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                <font size="1.5">PRODUCTO&nbsp;&nbsp;</font>
                            </strong></td>
                    </p>
                    <p>
                        <td align="right" style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                <font size="1.5">PRECIO&nbsp;&nbsp;</font>
                            </strong></td>
                    </p>
                    <p>
                        <td align="right" style="width:30%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                                <font size="1.5">TOTAL&nbsp;&nbsp;</font>
                            </strong></td>
                    </p>
                </tr>
                <?php foreach ($procesos as $proceso) :
                    $ventas1  = $proceso->getProducto(); ?>
                    <tr>
                        <p>
                            <td style="width:10%; font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" align="center"><?= $proceso->q ?>&nbsp;&nbsp;</td>
                        </p>
                        <p>
                            <td style="width:50%; font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"><?= $ventas1->nombre ?>&nbsp;&nbsp;</td>
                        </p>
                        <p>
                            <td align="right" style="width:10%; font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?= number_format(($proceso->precio), 2, ',', '.') ?>&nbsp;&nbsp;</td>
                        </p>
                        <p>
                            <td align="right" style="width:30%; font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?php if ($ventas->VerTipoModena()->estado == 1) { ?><?= number_format((($proceso->precio * $proceso->q) * $ventas->VerTipoModena()->valor), 2, ',', '.');
                                                                                                                                                                                    $total += (($proceso->precio * $proceso->q) * 1) ?><?php } else {
                                                                                                                                                                                                                                    if ($ventas->VerTipoModena()->simbolo == "US$") { ?> <?= number_format((($proceso->precio * $proceso->q) / 1), 2, ',', '.');
                                                                                                                                                                                                                                                                                                                                                                                    $total += (($proceso->precio * $proceso->q) / 1) ?><?php } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                    if ($ventas->VerTipoModena()->simbolo == "₲") { ?><?= number_format((($proceso->precio * $proceso->q) * $ventas->VerTipoModena()->valor), 2, ',', '.');
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $total += (($proceso->precio * $proceso->q) * $ventas->VerTipoModena()->valor) ?><?php }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?>&nbsp;&nbsp;</td>
                        </p>
                    </tr>
                <?php endforeach ?>

                <br />


            </thead>
        </table>
        <table border="0" align="center" width="315px" style="font-size:15pt;color:black;">
            <thead>
                <tr>
                    <td style="padding-left: 50px;padding-top: 16px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"><strong>
                            <font size="3">Total <?php echo $ventas->VerTipoModena()->simbolo ?>:&nbsp;&nbsp;</font>
                        </strong></td>
                    <td style="padding-left: 50px;padding-top: 16px; font-size: 17px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"><strong>
                            <font size="3"><?= number_format($total, 2, ',', '.') ?></font>
                        </strong></td>
                </tr>
                <tr>
                    <td style="padding-left: 50px;padding-top: 15px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"><strong>
                            <font size="2">Forma de pago:&nbsp;&nbsp;</font>
                        </strong></td>
                    <td style="padding-left: 50px;padding-top: 14px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"><strong>
                            <font size="2">Efectivo</font>
                        </strong></td>
                </tr>

                <tr>
                    <td style="padding-left: 50px;padding-top: 14px; font-size: 15px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"><strong>
                            <font size="2">Vuelto:&nbsp;&nbsp; </font>
                        </strong>0</td>
                </tr>

                <tr>
                    <td style="padding-left: 50px;padding-top: 16px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"><strong>
                            <font size="2">Tipo Cambio: <?php if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                            echo  $ventas->cambio2;
                                                        } else {
                                                            echo  1;
                                                        } ?>&nbsp;&nbsp;</font>
                        </strong></td>

                </tr>

            </thead>
        </table>
        <table border="0" align="center" width="315px" style="font-size:15pt;color:black;">
            <thead>
                <tr>
                    <td>******************************************************************************</td>
                </tr>
                <tr>
                    <td align="center">DESGLOSE DE IVA:</td>
                </tr>
                <tr>
                    <td style="padding-left: 50px;font-size: 16px;font-family:  Arial, Helvetica, sans-serif;">Total Exenta:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?= number_format($ventas->exenta, 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="padding-left: 50px;font-size: 16px;font-family:  Arial, Helvetica, sans-serif;">Total Gravada 5%:&nbsp;&nbsp;&nbsp;
                        <?= number_format($ventas->total5, 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="padding-left: 50px;font-size: 16px;font-family:  Arial, Helvetica, sans-serif;">Total Gravada 10%:&nbsp;
                        <?= number_format($ventas->total10, 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="padding-left: 50px;font-size: 16px;font-family:  Arial, Helvetica, sans-serif;">Total IVA 5%:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?= number_format($ventas->iva5, 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="padding-left: 50px;font-size: 16px;font-family:  Arial, Helvetica, sans-serif;">Total IVA 10%:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?= number_format($ventas->iva10, 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="padding-left: 50px;font-size: 16px;font-family:  Arial, Helvetica, sans-serif;">Total IVA:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?= number_format($ventas->iva10 + $ventas->iva5, 2, ',', '.') ?></td>
                </tr>
                <tr>

                    <td>******************************************************************************
                        </br>

                <tr>
                    <td style="padding-left: 50px;padding-top: 15px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">¡Gracias por su compra!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>

                </tr>

                </br>

                <tr>
                    <td style="padding-left: 50px;padding-top: 11px; font-size: 13px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Original: Cliente.
                    </td>
                </tr>
                <tr>
                    <td style="padding-left: 50px;padding-top: 11px; font-size: 13px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Duplicado: Archivo tributario.
                    </td>
                </tr>

                </td>

                </tr>


            </thead>

        </table>

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


    <div style="margin-left:245px;"><a href="#" id="botonPrint" onClick="printPantalla();"><img src="printer.png" border="0" style="cursor:pointer" title="Imprimir"></a></div>
</body>

</html>