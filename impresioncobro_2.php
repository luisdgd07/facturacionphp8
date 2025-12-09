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
            document.getElementById('botonPrint2').style.display = "none";
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
    include "core/modules/index/model/CajaCabecera.php";
    include "core/modules/index/model/CobroCabecera.php";
    include "core/modules/index/model/CobroDetalleData.php";
    include "core/modules/index/model/ClienteData.php";
    include "core/modules/index/model/MonedaData.php";
    include "core/modules/index/model/ConfigFacturaData.php";
    include "CifrasEnLetras.php";
    ?>
    <div class="zona_impresion" style="margin-left: 80px; width: 70%;">

        <?php for ($i = 0; $i < 3; $i++) { ?>
            <br>
            <h1 style="margin:0px 80px" hidden>Recibo de dinero</h1>
            <br>
            <?php
            $caja = new CajaCabecera();
            $cobro = new CobroCabecera();
            $cobrod = new CobroDetalleData();
            $cifra = new CifrasEnLetras();

            $dataCobro = $cobro->getCobro($_GET['cobro']);
            $cliente = new ClienteData();

            $dataCliente = $cliente->getById($dataCobro->CLIENTE_ID);
            $detalle = $caja->obtener($_GET['cobro']);
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $mon = $cobro->getMoneda($dataCobro->MONEDA_ID);
            ?>
            <h4 style="margin-left: 74%;margin-top: 5px;"> <?= $mon->simbolo . ' ' . number_format($detalle->TOTAL_COBRO, 2) ?></h4>

            <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $j = $dataCobro->RECIBO;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo $j;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ?></h4>
            </td>
            <?php
            // $fechan = $_GET['fecha'];
            $d = new DateTime($detalle->FECHA);
            $dia = $d->format('d');
            $mes = $d->format('m');
            $agno = $d->format('y');
            ?>
            <p style="margin-left: 500px;">
                <?=
                $dia;
                echo " &nbsp;&nbsp" . $meses[$mes - 1];
                echo " &nbsp;&nbsp " . $agno; ?>&nbsp;&nbsp;
            </p>
            <br>
            <h4 style="margin-left: 74%;margin-top: 0px;"><?= $dataCliente->ruc ?> <?= $dataCliente->dni ?></h4>

            <br>

            <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<?= $dataCliente->nombre ?> <?= $dataCliente->apellido ?> </h4>
            <table border="0" align="center" width="315px" style="font-size:15pt;color:black;">

                <tr>

                    <p>
                        <td style="width:10%; font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" align="center">
                            <?php
                            $moneda = MonedaData::vermonedaid($dataCobro->MONEDA_ID);
                            // var_dump($moneda);
                            // echo $moneda->simbolo;
                            if ($moneda->simbolo === "US$") {
                                echo "(Dolares Americanos)";
                            }
                            ?>
                            <?= $cifra->convertirNumeroEnLetras($detalle->TOTAL_COBRO); ?>&nbsp;&nbsp;</td>
                    </p>
                </tr>

                <tr>

                    <p>
                        <td style="width:10%; font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" align="center"><?= $dataCobro->COMENTARIO ?>&nbsp;&nbsp;</td>
                    </p>
                </tr>

                <tr>

                </tr>
                </thead>
            </table>
            <br>
            <p style="margin-top: -60px;">
                &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $detalle->concepto ?>


            </p>
            <br>
            <br>
            <br>
            <!-- $_GET['fecha'] -->

            <br>
        <?php } ?>
    </div>
    <div style="margin-left:245px;"><a href="#" id="botonPrint" onClick="printPantalla();"><img src="printer.png" border="0" style="cursor:pointer" title="Imprimir"></a></div>

    <div style="margin-left:445px;" class="" id="botonPrint2"><a href="http://localhost/facturacionek11/index.php?view=cobranza1&id_sucursal=<?php echo $detalle->SUCURSAL_ID ?>">Volver</a></div>
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

    <br>
</body>

</html>