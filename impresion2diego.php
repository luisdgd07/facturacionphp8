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
                    <div class="" style="margin-top:10px; margin-left:675px">
                        x
                    </div>


                <?php } else { ?>

                    <div class="" style="margin-top: 16px; margin-left:783px">
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


                <p style="font-size:10pt; margin-top: -7px; white-space: nowrap;padding-bottom: 0px;margin-left:60px">
                    <?php echo $ventas->getCliente()->nombre . ' ' . $ventas->getCliente()->apellido ?>

                </p>
                <p style="margin-top: -26px;margin-left: 700px; white-space: nowrap;">
                    
					 <?php if ($ventas->metodopago == "Contado") {

					 echo "-";

						 ?>
                 

                <?php } else { 
				
				
				echo $fecha_formateada = date("d/m/Y", strtotime($credito->vencimiento));
				
				?>

                   
                <?php } ?>
					
					
					
					
                </p>
                <p style="font-size:11pt; padding-bottom: 0px; margin-left:86px;white-space: nowrap; margin-top: -2px">
                    <?= $ventas->getCliente()->dni ?>

                </p>

                <p style="font-size:10pt; white-space: nowrap;padding-bottom: 2px;margin-top: 10px; margin-left:25px">
                    <?=
                    $ventas->getCliente()->direccion ?>


                </p>
                <p style="margin-top: -25px;margin-left: 700px">
                    
					
					<?php if ($ventas->getCliente()->telefono == "") {

					 echo "-";

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

        <table border="0" align="center" width="912px" style="font-size:14pt;margin-top: 6px; margin-left:85px">
            <thead>
                <tr>
                    <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                        </strong></td>
                    <p>
                        <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:40%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:15%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:50%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td align="right" style="width:30%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                </tr>
                <?php foreach ($procesos as $proceso) :
                    $ventas1  = $proceso->getProducto();
                    $total += $proceso->precio * $proceso->q;
                ?>
                    <tr>
                        <p>
                            <td style=" width:10%;font-size: 14px; font-family:  Arial, Helvetica, sans-serif; margin-left:25px;"><?= $ventas1->codigo ?></td>
                        </p>
                        <p>
                            <td style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"> <?= $proceso->q ?></td>
                        </p>
                        <p align="start">
                            <td style=" width:30%; font-size: 14px; font-family: Arial, Helvetica, sans-serif;"><?= $ventas1->nombre ?></td>
                        </p>

                        <p>
                            <td style=" font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?= number_format(($proceso->precio), 2, ',', '.') ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                                                                                                                                                echo "Gs";
                                                                                                                                                            } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                                                                                                                echo "USD";
                                                                                                                                                            } ?></td>
                        </p>

                        <p>
                            <td style="font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?php

                                                                                                    if ($ventas1->impuesto == 0) {

                                                                                                        echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                                                                                    } else {
                                                                                                        echo "0";
                                                                                                    }
                                                                                                    ?>
                                <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                    echo "Gs";
                                } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                    echo "USD";
                                } ?>
                            </td>
                        </p>
                        <p>
                            <td style="font-size: 14px;font-family:  Arial, Helvetica, sans-serif;white-space: nowrap;"><?php

                                                                                                                        if ($ventas1->impuesto == 5) {

                                                                                                                            echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                                                                                                        } else {
                                                                                                                            echo "0";
                                                                                                                        }
                                                                                                                        ?>
                                <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                    echo "Gs";
                                } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                    echo "USD";
                                } ?>
                            </td>
                        </p>
                        <p>
                            <td align="center" style="font-size: 14px;white-space: nowrap; "><?php
                                                                                            if ($ventas1->impuesto == 10) {
                                                                                                echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                                                                            } else {
                                                                                                echo "0";
                                                                                            }
                                                                                            ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                                                                                    echo "Gs";
                                                                                                } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                                                    echo "USD";
                                                                                                } ?></td>
                        </p>
                    </tr>
                <?php endforeach ?>

                <br />


            </thead>
        </table>

        <table border="0" align="center" width="865px" style="font-size:15pt; margin-top: 320px; margin-left:190px">
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
                    <td></td>
                    <td></td>

                    <td></td>

                    <td align="start">
                        <div style="text-transform:uppercase"> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                echo "Guaranies"; echo " ";
                            } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                echo "Dolares"; echo " ";
                            } ?><?= $cifra->convertirNumeroEnLetras($total);echo " "; echo "CON"; echo " ";  echo "00/100"; ?>
                             </div>
                    </td>

                    <td style="width: 41%;"></td>



                </tr>

            </thead>
        </table>
        <table border="0" align="center" width="875px" style="font-size:15pt; margin-top: -47px; margin-left:143px">
            <thead>
                <tr>
                    <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    </td>
                    <td></td>
                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>
                    <td align="start" style=" white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;">
                        <?= number_format($total, 2, ',', '.') ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                                                        echo "Gs";
                                                                    } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                        echo "USD";
                                                                    } ?>
                    </td>
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

                    <td align="start" ; style=" white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                        <?= number_format($total, 2, ',', '.') ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                                                        echo "Gs";
                                                                    } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                        echo "USD";
                                                                    } ?>
                    </td>


                </tr>

            </thead>
        </table>
        <table style="margin-left: 310px;margin-top:25px">
            <tr style="display: unset;">

                <td style="white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    <?= number_format($ventas->iva5, 2, ',', '.') ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                                                            echo "Gs";
                                                                        } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                            echo "USD";
                                                                        } ?>
                </td>
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
                <td style=" white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="">
                    <?= number_format($ventas->iva10, 2, ',', '.') ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                                                            echo "Gs";
                                                                        } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                            echo "USD";
                                                                        } ?>

                </td>
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
                <td align="start" style="white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="">
                    <?= number_format($ventas->iva10 + $ventas->iva5, 2, ',', '.') ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                                                                            echo "Gs";
                                                                                        } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                                            echo "USD";
                                                                                        } ?>

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="">
                </td>
                <td align="start" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
            </tr>

        </table>



        <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 


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
                    <div class="" style="margin-top:10px; margin-left:675px">
                        x
                    </div>


                <?php } else { ?>

                    <div class="" style="margin-top: 39px; margin-left:783px">
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


                <p style="font-size:10pt; margin-top: -7px; white-space: nowrap;padding-bottom: 0px;margin-left:60px">
                    <?php echo $ventas->getCliente()->nombre . ' ' . $ventas->getCliente()->apellido ?>

                </p>
                <p style="margin-top: -26px;margin-left: 700px; white-space: nowrap;">
                    
					 <?php if ($ventas->metodopago == "Contado") {

					 echo "-";

						 ?>
                 

                <?php } else { 
				
				
				echo $fecha_formateada = date("d/m/Y", strtotime($credito->vencimiento));
				
				?>

                   
                <?php } ?>
					
					
					
					
                </p>
                <p style="font-size:11pt; padding-bottom: 0px; margin-left:86px;white-space: nowrap; margin-top: -2px">
                    <?= $ventas->getCliente()->dni ?>

                </p>

                <p style="font-size:10pt; white-space: nowrap;padding-bottom: 2px;margin-top: 10px; margin-left:25px">
                    <?=
                    $ventas->getCliente()->direccion ?>


                </p>
                <p style="margin-top: -25px;margin-left: 700px">
                    
					
					<?php if ($ventas->getCliente()->telefono == "") {

					 echo "-";

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

        <table border="0" align="center" width="912px" style="font-size:14pt;margin-top: 6px; margin-left:85px">
            <thead>
                <tr>
                    <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                        </strong></td>
                    <p>
                        <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:40%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:15%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:50%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                    <p>
                        <td align="right" style="width:30%;font-family:  Arial, Helvetica, sans-serif;"><strong>
                            </strong></td>
                    </p>
                </tr>
                <?php foreach ($procesos as $proceso) :
                    $ventas1  = $proceso->getProducto();
                    $total += $proceso->precio * $proceso->q;
                ?>
                    <tr>
                        <p>
                            <td style=" width:10%;font-size: 14px; font-family:  Arial, Helvetica, sans-serif; margin-left:25px;"><?= $ventas1->codigo ?></td>
                        </p>
                        <p>
                            <td style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"> <?= $proceso->q ?></td>
                        </p>
                        <p align="start">
                            <td style=" width:30%; font-size: 14px; font-family: Arial, Helvetica, sans-serif;"><?= $ventas1->nombre ?></td>
                        </p>

                        <p>
                            <td style=" font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?= number_format(($proceso->precio), 2, ',', '.') ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                                                                                                                                                echo "Gs";
                                                                                                                                                            } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                                                                                                                echo "USD";
                                                                                                                                                            } ?></td>
                        </p>

                        <p>
                            <td style="font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?php

                                                                                                    if ($ventas1->impuesto == 0) {

                                                                                                        echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                                                                                    } else {
                                                                                                        echo "0";
                                                                                                    }
                                                                                                    ?>
                                <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                    echo "Gs";
                                } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                    echo "USD";
                                } ?>
                            </td>
                        </p>
                        <p>
                            <td style="font-size: 14px;font-family:  Arial, Helvetica, sans-serif;white-space: nowrap;"><?php

                                                                                                                        if ($ventas1->impuesto == 5) {

                                                                                                                            echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                                                                                                        } else {
                                                                                                                            echo "0";
                                                                                                                        }
                                                                                                                        ?>
                                <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                    echo "Gs";
                                } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                    echo "USD";
                                } ?>
                            </td>
                        </p>
                        <p>
                            <td align="center" style="font-size: 14px;white-space: nowrap;"><?php
                                                                                            if ($ventas1->impuesto == 10) {
                                                                                                echo number_format(($proceso->precio * $proceso->q), 2, ',', '.');
                                                                                            } else {
                                                                                                echo "0";
                                                                                            }
                                                                                            ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                                                                                    echo "Gs";
                                                                                                } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                                                    echo "USD";
                                                                                                } ?></td>
                        </p>
                    </tr>
                <?php endforeach ?>

                <br />


            </thead>
        </table>

        <table border="0" align="center" width="865px" style="font-size:15pt; margin-top: 320px; margin-left:190px">
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
                    <td></td>
                    <td></td>

                    <td></td>

                    <td align="start">
                        <div style="text-transform:uppercase"> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                echo "Guaranies"; echo " ";
                            } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                echo "Dolares"; echo " ";
                            } ?><?= $cifra->convertirNumeroEnLetras($total);echo " ";echo "CON"; echo " "; echo "00/100"; ?>
                             </div>
                    </td>

                    <td style="width: 41%;"></td>



                </tr>

            </thead>
        </table>
        <table border="0" align="center" width="875px" style="font-size:15pt; margin-top: -47px; margin-left:143px">
            <thead>
                <tr>
                    <td style="font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    </td>
                    <td></td>
                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>
                    <td align="start" style=" white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;">
                        <?= number_format($total, 2, ',', '.') ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                                                        echo "Gs";
                                                                    } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                        echo "USD";
                                                                    } ?>
                    </td>
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

                    <td align="start" ; style=" white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                        <?= number_format($total, 2, ',', '.') ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                                                        echo "Gs";
                                                                    } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                        echo "USD";
                                                                    } ?>
                    </td>


                </tr>

            </thead>
        </table>
        <table style="margin-left: 310px;margin-top:25px">
            <tr style="display: unset;">

                <td style="white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">
                    <?= number_format($ventas->iva5, 2, ',', '.') ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                                                            echo "Gs";
                                                                        } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                            echo "USD";
                                                                        } ?>
                </td>
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
                <td style=" white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="">
                    <?= number_format($ventas->iva10, 2, ',', '.') ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                                                            echo "Gs";
                                                                        } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                            echo "USD";
                                                                        } ?>

                </td>
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
                <td align="start" style="white-space: nowrap;font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="">
                    <?= number_format($ventas->iva10 + $ventas->iva5, 2, ',', '.') ?> <?php if ($ventas->VerTipoModena()->simbolo == "₲") {

                                                                                            echo "Gs";
                                                                                        } else if ($ventas->VerTipoModena()->simbolo == "US$") {
                                                                                            echo "USD";
                                                                                        } ?>

                </td>
                <td align="end" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="">
                </td>
                <td align="start" style=" font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">

                </td>
            </tr>

        </table>




    </div>
















    <!-- <div style="margin-left:245px;"><a href="#" id="botonPrint" onClick="printPantalla();"><img src="printer.png" border="0" style="margin-left: 700px;cursor:pointer" title="Imprimir"></a></div> -->
</body>

















</html>