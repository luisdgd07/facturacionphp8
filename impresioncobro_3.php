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

            window.print();
        }
    </script>
    <style>
        body {
            margin: 0px;

            margen: 0px;
            margin-left: 0px;
            margin-right: 0px;
            margin-top: 0px;

        }


        @media print {
            @page {
                margin: 0px;
                size: auto;
            }
        }
    </style>
</head>

<body>
    <?php
    include "core/autoload.php";
    include "core/modules/index/model/CajaCabecera.php";
    include "core/modules/index/model/CobroCabecera.php";
    include "core/modules/index/model/CobroDetalleData.php";
    include "core/modules/index/model/CreditoDetalleData.php";
    include "core/modules/index/model/ClienteData.php";
    include "core/modules/index/model/MonedaData.php";
    include "core/modules/index/model/CreditoData.php";
    include "core/modules/index/model/ConfigFacturaData.php";
    include "CifrasEnLetras.php";
    ?>

    <div class="" style="margin-left: 80px; width: 80%;">


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
        $d = new DateTime($detalle->FECHA);
        $dia = $d->format('d');
        $mes = $d->format('m');
        $agno = $d->format('Y');
        ?>
        <!-- <h4 style="margin-left: 70%;"><?= $mon->simbolo . "  " .  number_format(($detalle->TOTAL_COBRO), 2, ',', '.'); ?></h4> -->

        <h4 style="text-align: end"> <?=
                                        $dia;
                                        echo " " . $mes;
                                        echo " " . $agno; ?></h4>



        <br>
        <div class="" style="text-align: center;"><?= $dataCliente->nombre ?> <?= $dataCliente->apellido ?></div>
        <div class="" style="text-align: end;margin-top:-14px"> <?= $dataCliente->ruc ?> <?= $dataCliente->dni ?></div>
        <br>
        <!-- <?php
                $j = $dataCobro->RECIBO;
                echo $j;
                ?> -->

        <p style="text-transform: capitalize;text-align: center;">

            <?php
            $moneda = MonedaData::vermonedaid($dataCobro->MONEDA_ID);
            if ($moneda->simbolo === "US$") {
                echo "Dólares Americanos ";
            } else {
                echo "GUARANIES ";
            }
            echo  " " . $cifra->convertirNumeroEnLetras($detalle->TOTAL_COBRO);
            ?>
        </p>


        <br>
        <br>



        <?php
        $cobros = CobroDetalleData::cobranza_credito($_GET['cobro']);
        // var_dump($cobros);

        ?>
        <table style="width: 100%;margin-bottom: 50px;">
            <tbody> <?php
                    for ($i = 0; $i < 2; $i++) { ?>

                    <tr>
                        <td style="width: 40%;">
                            <p>________________________________</p>
                        </td>
                        <td style="width: 55%;">
                            <p>________________________________</p>
                        </td>

                        <td style="width: 25%;">
                            <p> <?php
                                if ($moneda->simbolo === "US$") {
                                    echo "$ ";
                                } else {
                                    echo "Gs ";
                                }
                                echo number_format($detalle->TOTAL_COBRO, 2, ',', '.'); ?></p>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>
        <table style="width: 100%;">
            <tbody> <?php
                    foreach ($cobros as $co) { ?>

                    <tr>
                        <td style="width: 25%;">
                            <p><?php echo $detalle->concepto ?></p>
                        <td style="width: 25%;">
                            <p><?php
                                $cred = CreditoData::getById($co->NUMERO_CREDITO);
                                $fechaFormateada = date("d/m/Y", strtotime($cred->fecha));
                                echo $fechaFormateada; // Salida: 07/10/2022
                                ?></p>
                        </td>
                        <td style="width: 40%;">
                            <p> Factura N: <?php echo $co->NUMERO_FACTURA ?></p>

                        </td>
                        <td style="width: 25%;">
                            <p> <?php
                                if ($moneda->simbolo === "US$") {
                                    echo "$ ";
                                } else {
                                    echo "Gs ";
                                }
                                echo number_format($co->IMPORTE_COBRO, 2, ',', '.'); ?></p>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>



        <br>



        </span>



    </div>







</body>

</html>