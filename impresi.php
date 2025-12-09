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
            document.getElementById('botonPrint').style.display = "none";
            window.print();
        }
    </script>
    <style>
        hr {
            position: relative;
            top: 20px;
            border: none;
            height: 2px;
            background: black;
            margin-bottom: 50px;
        }

        td {
            /* white-space: nowrap; */
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
    include "core/modules/index/model/CreditoData.php";
    include "qr/qrlib.php";
    include "CifrasEnLetras.php";
    $cifra = new CifrasEnLetras();

    ?>
    <style>

    </style>
    <div class="zona_impresion" style="margin-top: 125px;">
        <table border="0" align="center" width="915px" style="font-size:15pt;">
            <?php
            $total = 0;
            $ventas = VentaData::getById($_GET["id_venta"]);
            $procesos = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
            ?>

            <?php
            $total = 0;
            $ventas = VentaData::getById($_GET["id_venta"]);
            $procesos = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
            ?>

            <div style="font-size:11pt; margin-left:198px">
                <?php if ($ventas->metodopago == "Contado") { ?>
                    <div class="" style="margin-top:22px; margin-left:675px">
                        x
                    </div>


                <?php } else { ?>

                    <div class="" style="margin-top: 22px; margin-left:783px">
                        x
                    </div>
                <?php } ?>

                <p style="font-size:11pt;margin-top: 1px; padding-bottom: 10px;margin-left:24px">
                    <?php
                    $fecha = $ventas->fecha;
                    $fecha_formateada = date("d/m/Y", strtotime($fecha));
                    echo $fecha_formateada;
                    $credito =  CreditoData::getByVentaId($ventas->id_venta);
                    // var_dump($credito->vencimiento);
                    ?>
                </p>


                <b>
                    <p style="font-size:12pt; margin-top: -7px; white-space: nowrap;padding-bottom: 0px;margin-left:60px">
                        <?php echo $ventas->getCliente()->nombre . ' ' . $ventas->getCliente()->apellido ?>

                    </p>
                </b>
                <p style="margin-top: -26px;margin-left: 700px; white-space: nowrap;">

                    <?php if ($ventas->metodopago == "Contado") {

                        echo "--";

                    ?>


                    <?php } else {


                        echo $fecha_formateada = date("d/m/Y", strtotime($credito->vencimiento));

                    ?>


                    <?php } ?>




                </p>
                <b>
                    <p style="font-size:12pt; padding-bottom: 0px; margin-left:86px;white-space: nowrap; margin-top: -2px">
                        <?= $ventas->getCliente()->dni ?>

                    </p>
                </b>





                <p style="margin-top: -28px; white-space: nowrap;padding-bottom: 1px; margin-left: 700px">


                    <?php

                    echo "--";

                    ?>
                </p>



                <b>
                    <p style="font-size:12pt; white-space: nowrap;padding-bottom: 0px;margin-top: 9px; margin-left:25px">
                        <?=
                        $ventas->getCliente()->direccion ?>


                    </p>
                </b>
                <p style="margin-top: -33px; white-space: nowrap;padding-bottom: 1px; margin-left: 700px">


                    <?php if ($ventas->getCliente()->telefono == "") {

                        echo "--";

                    ?>


                    <?php } else {


                        echo  $ventas->getCliente()->telefono;

                    ?>


                    <?php } ?>



                </p>


                <?php
                $cambio = 0;
                if ($ventas->VerTipoModena()->simbolo == "US$") {
                    $cambio = $ventas->cambio2;
                } else {
                    $cambio = 1;
                } ?>



                </thead>
            </div>
        </table>

        <table border="0" align="center" width="912px" style="font-size:14pt;margin-top: 6px; margin-left:80px">
            <thead>
                <tr>
                    <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                        </strong></td>
                    <p>
                        <td style="width:7.9%;   font-family:  Arial, Helvetica,  sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:35%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:14%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:13%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:51%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:15%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td align="right" style="width:30%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                </tr>
                <?php
                $lines = 0;
                $lines2 = 0;
                foreach ($procesos as $proceso) :
                    $lines++;
                    $ventas1  = $proceso->getProducto();
                    $total += $proceso->precio * $proceso->q;
                ?>
                    <div class="margen" style="<?php if (strlen($ventas1->nombre) > 30) {
                                                    $lines2++;
                                                }
                                                if (strlen($ventas1->nombre) > 50) {
                                                    $lines2++;
                                                }

                                                if (strlen($ventas1->nombre) > 70) {
                                                    $lines2++;
                                                }
                                                if (strlen($ventas1->nombre) > 90) {
                                                    $lines2++;
                                                }
                                                if (strlen($ventas1->nombre) > 120) {
                                                    $lines2++;
                                                }
                                                if (strlen($ventas1->nombre) > 140) {
                                                    $lines2++;
                                                }
                                                if (strlen($ventas1->nombre) > 160) {
                                                    $lines2++;
                                                }
                                                if (strlen($ventas1->nombre) > 180) {
                                                    $lines2++;
                                                }
                                                if (strlen($ventas1->nombre) > 190) {
                                                    $lines2 = 10;
                                                }
                                                ?>">
                        <tr>
                            <p>
                                <td style=" width:10%;font-size: 14px; font-family:  Arial, Helvetica, sans-serif; margin-left:25px;"><?= $ventas1->codigo ?></td>
                            </p>
                            <p>
                                <td style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"> <?= $proceso->q ?></td>
                            </p>
                            <p align="start">
                                <td style=" width:14%; font-size: 14px; font-family: Arial, Helvetica, sans-serif;"><?= $ventas1->nombre ?></td>
                            </p>

                            <p>
                                <td style=" font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?php if ($ventas->VerTipoModena()->simbolo == "₲") {
                                                                                                                if ($ventas1->impuesto == 30) {
                                                                                                                    echo number_format($ventas->exenta, 0, ',', '.') . " Gs";
                                                                                                                } else {
                                                                                                                    echo number_format(($ventas->total / $proceso->q), 0, ',', '.') . " Gs";
                                                                                                                }
                                                                                                            } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                                                                if ($ventas1->impuesto == 30) {
                                                                                                                    echo number_format($ventas->total, 2, ',', '.') . " USD";
                                                                                                                } else {
                                                                                                                    echo number_format(($ventas->total / $proceso->q), 2, ',', '.') . " USD";
                                                                                                                }
                                                                                                            } ?></td>
                            </p>

                            <p>
                                <td style="font-size: 14px;font-family:  Arial, Helvetica, sans-serif;   white-space: nowrap;"><?php


                                                                                                                                ?>
                                    <?php if ($ventas->VerTipoModena()->simbolo == "₲") {
                                        if ($ventas1->impuesto == 0) {

                                            echo number_format(($proceso->precio * $proceso->q), 0, ',', '.');
                                        } else if ($ventas1->impuesto == 30) {
                                            echo number_format($ventas->exenta, 2, ',', '.');
                                        } else {


                                            echo "0";
                                            echo " ";
                                        }
                                        echo "Gs";
                                    } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                        if ($ventas1->impuesto == 0) {

                                            echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                        } else if ($ventas1->impuesto == 30) {
                                            echo number_format($ventas->exenta, 2, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        echo " USD";
                                    } ?>
                                </td>
                            </p>
                            <p>
                                <td style="font-size: 14px;font-family:  Arial, Helvetica, sans-serif;white-space: nowrap;"><?php


                                                                                                                            ?>
                                    <?php if ($ventas->VerTipoModena()->simbolo == "₲") {
                                        if ($ventas1->impuesto == 5) {

                                            echo number_format(($proceso->precio * $proceso->q), 0, ',', '.');
                                        } else if ($ventas1->impuesto == 30) {

                                            echo number_format(($ventas->iva5 + $ventas->total5), 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        echo " Gs";
                                    } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                        if ($ventas1->impuesto == 5) {

                                            echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                        } else if ($ventas1->impuesto == 30) {

                                            echo number_format(($ventas->iva5 + $ventas->total5), 2, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        echo " USD";
                                    } ?>
                                </td>
                            </p>
                            <p>
                                <td align="center" style="font-size: 14px;white-space: nowrap; "><?php

                                                                                                    ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {
                                                                                                            if ($ventas1->impuesto == 10) {
                                                                                                                echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                                                                                            } else {
                                                                                                                echo "0";
                                                                                                            }
                                                                                                            echo " Gs";
                                                                                                        } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                                                            if ($ventas1->impuesto == 10) {
                                                                                                                echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                                                                                            } else {
                                                                                                                echo "0";
                                                                                                            }
                                                                                                            echo " USD";
                                                                                                        } ?></td>
                            </p>
                        </tr>
                    </div>

                <?php endforeach ?>

                <br />


            </thead>
        </table>

        <table border="0" class="margen-editar<?php echo $lines ?>" align="center" width="865px" style="font-size:15pt; margin-top: <?php
                                                                                                                                    if ($lines2 == 0 || $lines == 0) {
                                                                                                                                        echo (306);
                                                                                                                                    } else if ($lines2 == 5) {
                                                                                                                                        echo 210;
                                                                                                                                    } else if ($lines2 == 6) {
                                                                                                                                        echo 210;
                                                                                                                                    } else if ($lines2 == 7) {
                                                                                                                                        echo 210;
                                                                                                                                    } else if ($lines2 == 8) {
                                                                                                                                        echo 210;
                                                                                                                                    } else if ($lines2 == 9) {
                                                                                                                                        echo 210;
                                                                                                                                    } else if ($lines2 == 10) {
                                                                                                                                        echo 210;
                                                                                                                                    } else {
                                                                                                                                        echo (337 - ($lines * 20.5) - ($lines2 * 19));
                                                                                                                                    }
                                                                                                                                    ?>px; margin-left:190px">
            <thead>
                <tr>
                    <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    </td>
                    <td></td>
                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>

                </tr>
                <tr>
                    <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    </td>
                    <td></td>
                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>
                    <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                    </td>
                    <td style="width: 1%;"></td>
                    <td style="width: 1%;"></td>

                    <td style="width: 1%;"></td>

                    <td align="start">
                        <div style="text-transform:uppercase;white-space: nowrap"> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                                                                        echo "Son Guaranies";

                                                                                        $totalenletras = number_format($ventas->total, 0, ',', '.');
                                                                                        echo " ";
																			
                                                                                    } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                                        echo "Son Dólares americanos";

                                                                                        $totalenletras = number_format($ventas->total, 2, ',', '.');
                                                                                        echo " ";
                                                                                    } ?><?= $cifra->convertirNumeroEnLetras($totalenletras);
                                                                                        echo " ";
                                                                                        echo "-"; ?>
                        </div>
                    </td>

                    <td style="width: 1%;"></td>



                </tr>

            </thead>
        </table>
        <table border="0" align="center" width="875px" style="font-size:15pt; margin-top: -47px; margin-left:149px">
            <thead>
                <tr>
                    <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    </td>
                    <td></td>
                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>
                    <td align="start" style=" white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"> <b>
                            <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                echo number_format($ventas->total, 0, ',', '.') . " Gs";
                            } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                echo number_format($ventas->total, 2, ',', '.') . " USD";
                                // echo $ventas->total;
                            } ?>
                        </b></td>
                </tr>
                <tr>
                    <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    </td>
                    <td></td>
                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>
                    <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                    </td>
                    <td></td>
                    <td></td>

                    <td></td>

                    <td align="start">
                        <div class="" style="width:420px"></div>
                    </td>

                    <td style="width: 40%;"></td>

                    <td align="start" ; style=" white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"><b>
                            <?php ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                            echo number_format($ventas->total, 0, ',', '.') . " Gs";
                                        } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                            echo number_format($ventas->total, 2, ',', '.') . " USD";
                                        } ?>
                        </b></td>


                </tr>

            </thead>
        </table>
        <table style="margin-left: 310px;margin-top:25px">
            <tr style="display: unset;">

                <td style="white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"><b>
                        <?php
                        $iva5exe = 0;
                        foreach ($procesos as $proceso) {
                            $ventas1  = $proceso->getProducto();
                            if ($ventas1->impuesto == 30) {
                                $iva5exe += ($proceso->precio * $proceso->q) * 0.30 / 21;
                                //   echo number_format($iva5exe, 2, ',', '.') . " USD";
                                // echo number_format((($proceso->precio * $proceso->q) * 0.30) / 21, 2, ',', '.');
                            }
                        }

                        if ($ventas->VerTipoModena()->simbolo == "₲") {

                            echo number_format($ventas->iva5, 0, ',', '.') . " Gs";
                        } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                            echo number_format($ventas->iva5, 2, ',', '.') . " USD";
                        } ?>
                    </b></td>
                <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 1px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td style=" white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class=""><b>
                        <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                            echo number_format($ventas->iva10, 0, ',', '.') . " Gs";
                        } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                            echo number_format($ventas->iva10, 2, ',', '.') . " USD";
                        } ?>

                    </b></td>
                <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 1px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>


                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="start" style="white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class=""><b>
                        <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                            echo number_format($ventas->iva10 + $ventas->iva5, 0, ',', '.') . " Gs";
                        } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                            echo number_format($ventas->iva10 + $ventas->iva5, 2, ',', '.') . " USD";
                        } ?>

                    </b></td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="">
                </td>
                <td align="start" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
            </tr>

        </table>


        <?php
        ?>
        <?php
        ?>
        <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>


        <!-- segunda fsctura -->

        <table border="0" align="center" width="915px" style="font-size:15pt;">
            <?php
            $total = 0;
            $ventas = VentaData::getById($_GET["id_venta"]);
            $procesos = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
            ?>

            <?php
            $total = 0;
            $ventas = VentaData::getById($_GET["id_venta"]);
            $procesos = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
            ?>

            <div style="font-size:11pt; margin-left:198px">
                <?php if ($ventas->metodopago == "Contado") { ?>
                    <div class="" style="margin-top:32px; margin-left:675px">
                        x
                    </div>


                <?php } else { ?>

                    <div class="" style="margin-top: 32px; margin-left:783px">
                        x
                    </div>
                <?php } ?>

                <p style="font-size:11pt;margin-top: 1px; padding-bottom: 10px;margin-left:24px">
                    <?php
                    $fecha = $ventas->fecha;
                    $fecha_formateada = date("d/m/Y", strtotime($fecha));
                    echo $fecha_formateada;
                    $credito =  CreditoData::getByVentaId($ventas->id_venta);
                    // var_dump($credito->vencimiento);
                    ?>
                </p>


                <b>
                    <p style="font-size:12pt; margin-top: -7px; white-space: nowrap;padding-bottom: 0px;margin-left:60px">
                        <?php echo $ventas->getCliente()->nombre . ' ' . $ventas->getCliente()->apellido ?>

                    </p>
                </b>
                <p style="margin-top: -26px;margin-left: 700px; white-space: nowrap;">

                    <?php if ($ventas->metodopago == "Contado") {

                        echo "--";

                    ?>


                    <?php } else {


                        echo $fecha_formateada = date("d/m/Y", strtotime($credito->vencimiento));

                    ?>


                    <?php } ?>




                </p>
                <b>
                    <p style="font-size:12pt; padding-bottom: 1px; margin-left:86px;white-space: nowrap; margin-top: -2px">
                        <?= $ventas->getCliente()->dni ?>

                    </p>
                </b>


                <p style="margin-top: -28px; white-space: nowrap;padding-bottom: 1px; margin-left: 700px">


                    <?php

                    echo "--";

                    ?>
                </p>

                <b>
                    <p style="font-size:12pt; white-space: nowrap;padding-bottom: 1px;margin-top: 9px; margin-left:25px">
                        <?=
                        $ventas->getCliente()->direccion ?>


                    </p>
                </b>
                <p style="margin-top: -33px;  white-space: nowrap;padding-bottom: 1px; margin-left: 700px">


                    <?php if ($ventas->getCliente()->telefono == "") {

                        echo "--";

                    ?>


                    <?php } else {


                        echo  $ventas->getCliente()->telefono;

                    ?>


                    <?php } ?>



                </p>
                <?php
                $cambio = 0;
                if ($ventas->VerTipoModena()->simbolo == "US$") {
                    $cambio = $ventas->cambio2;
                } else {
                    $cambio = 1;
                } ?>



                </thead>
            </div>
        </table>

        <table border="0" align="center" width="912px" style="font-size:14pt;margin-top: 6px; margin-left:80px">
            <thead>
                <tr>
                    <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                        </strong></td>
                    <p>
                        <td style="width:6.9%;   font-family:  Arial, Helvetica,  sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:35%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:14%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:13%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:51%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:15%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td align="right" style="width:30%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                </tr>
                <?php
                $lines = 0;
                $lines2 = 0;
                foreach ($procesos as $proceso) :
                    $lines++;
                    $ventas1  = $proceso->getProducto();
                    $total += $proceso->precio * $proceso->q;
                ?>
                    <div class="margen" style="<?php if (strlen($ventas1->nombre) > 30) {
                                                    $lines2++;
                                                }
                                                if (strlen($ventas1->nombre) > 50) {
                                                    $lines2++;
                                                }

                                                if (strlen($ventas1->nombre) > 70) {
                                                    $lines2++;
                                                }
                                                if (strlen($ventas1->nombre) > 190) {
                                                    $lines2 = 10;
                                                }
                                                ?>?>">
                        <tr>
                            <p>
                                <td style=" width:10%;font-size: 14px; font-family:  Arial, Helvetica, sans-serif; margin-left:25px;"><?= $ventas1->codigo ?></td>
                            </p>
                            <p>
                                <td style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"> <?= $proceso->q ?></td>
                            </p>
                            <p align="start">
                                <td style=" width:14%; font-size: 14px; font-family: Arial, Helvetica, sans-serif;"><?= $ventas1->nombre ?></td>
                            </p>

                            <p>
                                <td style=" font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?php if ($ventas->VerTipoModena()->simbolo == "₲") {
                                                                                                                if ($ventas1->impuesto == 30) {
                                                                                                                    echo number_format($ventas->exenta, 0, ',', '.') . " Gs";
                                                                                                                } else {
                                                                                                                    echo number_format(($ventas->total / $proceso->q), 0, ',', '.') . " Gs";
                                                                                                                }
                                                                                                            } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                                                                if ($ventas1->impuesto == 30) {
                                                                                                                    echo number_format($ventas->total, 2, ',', '.') . " USD";
                                                                                                                } else {
                                                                                                                    echo number_format(($ventas->total / $proceso->q), 2, ',', '.') . " USD";
                                                                                                                }
                                                                                                            } ?></td>
                            </p>

                            <p>
                                <td style="font-size: 14px;font-family:  Arial, Helvetica, sans-serif;white-space: nowrap;"><?php


                                                                                                                            ?>
                                    <?php if ($ventas->VerTipoModena()->simbolo == "₲") {
                                        if ($ventas1->impuesto == 0) {

                                            echo number_format(($proceso->precio * $proceso->q), 0, ',', '.');
                                        } else if ($ventas1->impuesto == 30) {
                                            echo number_format($ventas->exenta, 2, ',', '.');
                                        } else {
                                            echo "0";
                                            echo " ";
                                        }
                                        echo "Gs";
                                    } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                        if ($ventas1->impuesto == 0) {

                                            echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                        } else if ($ventas1->impuesto == 30) {
                                            echo number_format($ventas->exenta, 2, ',', '.');
                                        } else {
                                            echo "0";
                                            echo " ";
                                        }
                                        echo " USD";
                                    } ?>
                                </td>
                            </p>
                            <p>
                                <td style="font-size: 14px;font-family:  Arial, Helvetica, sans-serif;white-space: nowrap;"><?php


                                                                                                                            ?>
                                    <?php if ($ventas->VerTipoModena()->simbolo == "₲") {
                                        if ($ventas1->impuesto == 5) {

                                            echo number_format(($proceso->precio * $proceso->q), 0, ',', '.');
                                        } else if ($ventas1->impuesto == 30) {

                                            echo number_format(($ventas->iva5), 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        echo " Gs";
                                    } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                        if ($ventas1->impuesto == 5) {

                                            echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                        } else if ($ventas1->impuesto == 30) {

                                            echo number_format(($ventas->iva5 + $ventas->total5), 2, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        echo " USD";
                                    } ?>
                                </td>
                            </p>
                            <p>
                                <td align="center" style="font-size: 14px;white-space: nowrap; "><?php

                                                                                                    ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {
                                                                                                            if ($ventas1->impuesto == 10) {
                                                                                                                echo number_format(($proceso->precio * $proceso->q), 0, ',', '.');
                                                                                                            } else {
                                                                                                                echo "0";
                                                                                                            }
                                                                                                            echo " Gs";
                                                                                                        } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                                                            if ($ventas1->impuesto == 10) {
                                                                                                                echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                                                                                            } else {
                                                                                                                echo "0";
                                                                                                            }
                                                                                                            echo " USD";
                                                                                                        } ?></td>
                            </p>
                        </tr>
                    </div>

                <?php endforeach ?>

                <br />


            </thead>
        </table>

        <table border="0" align="center" width="865px" style="font-size:15pt; margin-top:  <?php
                                                                                            if ($lines2 == 0 || $lines == 0) {
                                                                                                echo (306);
                                                                                            } else if ($lines2 == 5) {
                                                                                                echo 210;
                                                                                            } else if ($lines2 == 6) {
                                                                                                echo 210;
                                                                                            } else if ($lines2 == 7) {
                                                                                                echo 210;
                                                                                            } else if ($lines2 == 8) {
                                                                                                echo 210;
                                                                                            } else if ($lines2 == 9) {
                                                                                                echo 210;
                                                                                            } else if ($lines2 == 10) {
                                                                                                echo 210;
                                                                                            } else {
                                                                                                echo (337 - ($lines * 20.5) - ($lines2 * 19));
                                                                                            }
                                                                                            ?>px; margin-left:190px">
            <thead>
                <tr>
                    <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    </td>
                    <td></td>
                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>

                </tr>
                <tr>
                    <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    </td>
                    <td></td>
                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>
                    <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                    </td>
                    <td style="width: 1%;"></td>
                    <td style="width: 1%;"></td>

                    <td style="width: 1%;"></td>

                    <td align="start">
                        <div style="text-transform:uppercase;white-space: nowrap"> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                                                                        echo "Son Guaranies";

                                                                                        $totalenletras = number_format($ventas->total, 0, ',', '.');
                                                                                        echo " ";
                                                                                    } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                                        echo "Son Dólares americanos";

                                                                                        $totalenletras = number_format($ventas->total, 2, ',', '.');
                                                                                        echo " ";
                                                                                    } ?><?= $cifra->convertirNumeroEnLetras($totalenletras);
                                                                                        echo " ";
                                                                                        echo "-"; ?>
                        </div>
                    </td>

                    <td style="width: 1%;"></td>



                </tr>

            </thead>
        </table>
        <table border="0" align="center" width="875px" style="font-size:15pt; margin-top: -47px; margin-left:149px">
            <thead>
                <tr>
                    <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    </td>
                    <td></td>
                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>


                    <td align="start" style=" white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"><b>
                            <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                echo number_format($ventas->total, 0, ',', '.') . " Gs";
                            } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                echo number_format($ventas->total, 2, ',', '.') . " USD";
                            } ?>
                        </b> </td>


                </tr>
                <tr>
                    <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    </td>
                    <td></td>
                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>
                    <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                    </td>
                    <td></td>
                    <td></td>

                    <td></td>

                    <td align="start">
                        <div class="" style="width:420px"></div>
                    </td>

                    <td style="width: 40%;"></td>

                    <td align="start" ; style=" white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"> <b>
                            <?php ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                            echo number_format($ventas->total, 0, ',', '.') . " Gs";
                                        } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                            echo number_format($ventas->total, 2, ',', '.') . " USD";
                                        } ?>
                        </b> </td>



                </tr>

            </thead>
        </table>
        <table style="margin-left: 310px;margin-top:25px">
            <tr style="display: unset;">

                <td style="white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"><b>
                        <?php
                        $iva5exe = 0;
                        foreach ($procesos as $proceso) {
                            $ventas1  = $proceso->getProducto();
                            if ($ventas1->impuesto == 30) {
                                $iva5exe += ($proceso->precio * $proceso->q) * 0.30 / 21;
                                //   echo number_format($iva5exe, 2, ',', '.') . " USD";
                                // echo number_format((($proceso->precio * $proceso->q) * 0.30) / 21, 2, ',', '.');
                            }
                        }

                        if ($ventas->VerTipoModena()->simbolo == "₲") {

                            echo number_format($ventas->iva5, 0, ',', '.') . " Gs";
                        } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                            echo number_format($ventas->iva5, 2, ',', '.') . " USD";
                        } ?>
                    </b></td>
                <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 1px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td style=" white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class=""><b>
                        <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                            echo number_format($ventas->iva10, 0, ',', '.') . " Gs";
                        } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                            echo number_format($ventas->iva10, 2, ',', '.') . " USD";
                        } ?>

                    </b></td>
                <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 1px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>


                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
                <td align="start" style="white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class=""><b>
                        <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                            echo number_format($ventas->iva10 + $ventas->iva5, 0, ',', '.') . " Gs";
                        } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                            echo number_format($ventas->iva10 + $ventas->iva5, 2, ',', '.') . " USD";
                        } ?>

                    </b></td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="">
                </td>
                <td align="start" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
            </tr>

        </table>



    </div>
















    <!-- <div style="margin-left:245px;"><a href="#" id="botonPrint" onClick="printPantalla();"><img src="printer.png" border="0" style="margin-left: 700px;cursor:pointer" title="Imprimir"></a></div> -->
</body>
<style>

</style>
















</html>