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
    function decimalAFraccion($numero)
    {
        $denominador = 100; // El denominador es 100 en este caso
        $numerador = $numero * $denominador;

        // Simplificar la fracción si es necesario
        $maximoComunDivisor = gcd($numerador, $denominador);
        $numerador /= $maximoComunDivisor;
        $denominador /= $maximoComunDivisor;

        return "$numerador/$denominador";
    }

    function gcd($a, $b)
    {
        return ($b == 0) ? $a : gcd($b, $a % $b);
    }


    ?>

    <div class="zona_impresion" style="margin-left: 80px; width: 80%;">


        <br>
        <h1 style="margin:0px 80px" hidden></h1>

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
        ?> <br><br>
        <h4 style="margin-left: 70%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $mon->simbolo . '  &nbsp;    ' . '  &nbsp;    ' . '   &nbsp;   ' .  number_format(($detalle->TOTAL_COBRO), 0, ',', '.'); ?></h4>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $j = $dataCobro->RECIBO;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo $j;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ?>






        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <br>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $dataCliente->nombre ?> <?= $dataCliente->apellido ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<?= $dataCliente->ruc ?> <?= $dataCliente->dni ?></td>

        <p>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <?php
                $moneda = MonedaData::vermonedaid($dataCobro->MONEDA_ID);
                // var_dump($moneda);
                // echo $moneda->simbolo;
                if ($moneda->simbolo === "US$") {
                    echo "Dólares Americanos";
                }
                ?>
                <?= $cifra->convertirNumeroEnLetras(intval($detalle->TOTAL_COBRO)); ?> <?php
                                                                                        // $numero = 74784.7;
                                                                                        // $numero = fmod($numero, 1); // El número del que deseas obtener los decimales
                                                                                        // $formatoFraccion = decimalAFraccion($numero);
                                                                                        // // echo $formatoFraccion;
                                                                                        // $numero = 74784.7;

                                                                                        $decimales = fmod($detalle->TOTAL_COBRO, 1);

                                                                                        // Convertir los decimales en una fracción en el formato "70/100"
                                                                                        $decimales = round($decimales, 2);
                                                                                        $fraccion = $decimales * 100 . '/100';

                                                                                       // echo $fraccion; // Esto imprimirá "70/100"
                                                                                        ?></td>
        </p>


        <tr>



        </tr>

        <tr>

        </tr>
        </thead>


        <br>

        <br>
        <br>
        <span>
		
		<h4 style="position: absolute;left: 85px; top: 295px;">
		
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $detalle->concepto ?>
        
       </h4>
        </span>
        <br>
        <br>



        <!-- $_GET['fecha'] -->
        <?php
        // $fechan = $_GET['fecha'];
        $d = new DateTime($detalle->FECHA);
        $dia = $d->format('d');
        $mes = $d->format('m');
        $agno = $d->format('Y');
        ?>
        <br>

        <span>
                 <h4 style="position: absolute;left: 80px; top: 333px;">
    
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; <?=
                                                                                                                                                $dia;
                                                                                                                                                echo " de " . $meses[$mes - 1];
                                                                                                                                                echo " de " . $agno; ?>&nbsp;&nbsp;




           </h4>
        </span>
        <br>
        <br>
        
		

       


    </div>










    <div class="zona_impresion" style="margin-left: 80px; width: 80%;">


        <br>

        <h1 style="margin:0px 80px" hidden></h1>

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
        ?> <br><br>
        <h4 style="margin-left: 70%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $mon->simbolo . '  &nbsp;    ' . '  &nbsp;    ' . '   &nbsp;   ' .    number_format(($detalle->TOTAL_COBRO), 0, ',', '.'); ?></h4>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $j = $dataCobro->RECIBO;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo $j;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ?>






        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>



        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $dataCliente->nombre ?> <?= $dataCliente->apellido ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<?= $dataCliente->ruc ?> <?= $dataCliente->dni ?></td>



        <p>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <?php
                $moneda = MonedaData::vermonedaid($dataCobro->MONEDA_ID);
                // var_dump($moneda);
                // echo $moneda->simbolo;
                if ($moneda->simbolo === "US$") {
                    echo "Dólares Americanos";
                }
                ?>
                <?= $cifra->convertirNumeroEnLetras(intval($detalle->TOTAL_COBRO)); ?> <?php
                                                                                        // $numero = 74784.7;
                                                                                        // $numero = fmod($numero, 1); // El número del que deseas obtener los decimales
                                                                                        // $formatoFraccion = decimalAFraccion($numero);
                                                                                        // // echo $formatoFraccion;
                                                                                        // $numero = 74784.7;

                                                                                        $decimales = fmod($detalle->TOTAL_COBRO, 1);

                                                                                        // Convertir los decimales en una fracción en el formato "70/100"
                                                                                        $decimales = round($decimales, 2);
                                                                                        $fraccion = $decimales * 100 . '/100';

                                                                                       // echo $fraccion; // Esto imprimirá "70/100"
                                                                                        ?></td>
        </p>


        <tr>



        </tr>

        <tr>

        </tr>
        </thead>


        <br>

        <br>
        <br>
        <span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $detalle->concepto ?>


        </span>
        <br>
        <br>



        <!-- $_GET['fecha'] -->
        <?php
        // $fechan = $_GET['fecha'];
        $d = new DateTime($detalle->FECHA);
        $dia = $d->format('d');
        $mes = $d->format('m');
        $agno = $d->format('Y');
        ?>
        <br>

        <span>


            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; <?=
                                                                                                                                                $dia;
                                                                                                                                                echo " de " . $meses[$mes - 1];
                                                                                                                                                echo " de " . $agno; ?>&nbsp;&nbsp;





        </span>
        <br>
        <br>
        <br>
        





    </div>












    







    <div class="zona_impresion" style="margin-left: 80px; width: 80%;">


        <br>
        <h1 style="margin:0px 80px" hidden></h1>

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
        ?> <br><br>
        <h4 style="margin-left: 70%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $mon->simbolo . '  &nbsp;    ' . '  &nbsp;    ' . '   &nbsp;   ' .    number_format(($detalle->TOTAL_COBRO), 0, ',', '.'); ?></h4>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $j = $dataCobro->RECIBO;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo $j;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ?>






        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $dataCliente->nombre ?> <?= $dataCliente->apellido ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<?= $dataCliente->ruc ?> <?= $dataCliente->dni ?></td>



        <p>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <?php
                $moneda = MonedaData::vermonedaid($dataCobro->MONEDA_ID);
                // var_dump($moneda);
                // echo $moneda->simbolo;
                if ($moneda->simbolo === "US$") {
                    echo "Dólares Americanos";
                }
                ?>
                <?= $cifra->convertirNumeroEnLetras(intval($detalle->TOTAL_COBRO)); ?> <?php
                                                                                        // $numero = 74784.7;
                                                                                        // $numero = fmod($numero, 1); // El número del que deseas obtener los decimales
                                                                                        // $formatoFraccion = decimalAFraccion($numero);
                                                                                        // // echo $formatoFraccion;
                                                                                        // $numero = 74784.7;

                                                                                        $decimales = fmod($detalle->TOTAL_COBRO, 1);

                                                                                        // Convertir los decimales en una fracción en el formato "70/100"
                                                                                        $decimales = round($decimales, 2);
                                                                                        $fraccion = $decimales * 100 . '/100';

                                                                                       // echo $fraccion; // Esto imprimirá "70/100"
                                                                                        ?></td>
        </p>


        <tr>



        </tr>

        <tr>

        </tr>
        </thead>


        <br>

        <br>
        <br>
        <span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $detalle->concepto ?>


        </span>
        <br>
        <br>



        <!-- $_GET['fecha'] -->
        <?php
        // $fechan = $_GET['fecha'];
        $d = new DateTime($detalle->FECHA);
        $dia = $d->format('d');
        $mes = $d->format('m');
        $agno = $d->format('Y');
        ?>
        <br>

        <span>


            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; <?=
                                                                                                                                                $dia;
                                                                                                                                                echo " de " . $meses[$mes - 1];
                                                                                                                                                echo " de " . $agno; ?>&nbsp;&nbsp;





        </span>
        <br>
        <br>
        <br>
        <br>

        <br>
        <br>


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

    <br>
</body>

</html>