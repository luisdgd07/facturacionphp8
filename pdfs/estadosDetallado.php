<?php

include "./PDF.php";
$pdf = new PDF();
$sd = date("d-m-Y", strtotime($_GET['sd']));
$ed = date("d-m-Y", strtotime($_GET['ed']));
$title = 'Reporte de Estado Detallado desde: ' . $sd . ' Hasta: ' . $ed;
$pdf->SetTitle($title);
$pdf->SetY(65);

$cols = [
    'NRO CREDITO',
    'RECIBO',
    'CLIENTE',
    'FACTURA',
    'IMPORTE COBRADO',
    'IMPORTE A COBRAR',
    'SALDO',
    'FECHA'
];
$nuevafecha =  date($_GET["sd"]);
$n = date("Y-m-d", strtotime($nuevafecha . "- 1 days"));
$width = [18, 18, 45, 25, 25, 25, 18, 18, 20, 15, 25, 30, 40, 25, 30, 30, 30, 40, 25, 30, 30];
$usersAnterior = CobroCabecera::totalcobros($_GET['id_sucursal'], $_GET['cliente'], '1988-01-09', $n);
$VentasAnte = CobroCabecera::totalestadocobros($_GET['id_sucursal'], $_GET['cliente'], '1988-01-09', $n);
$Ventas = CobroCabecera::totalestadocobros($_GET['id_sucursal'], $_GET['cliente'], $_GET['sd'], $_GET['ed']);
$totalAnte1 = 0;
$totalAnte2 = 0;
$totalAnte3 = 0;
foreach ($VentasAnte as $v) {
    $totalAnte2 += $v->credito;
}
foreach ($usersAnterior as $sell) {
    $operations = CobroDetalleData::cobranza_credito($sell->COBRO_ID);
    $cred = $operations[0]->IMPORTE_CREDITO;
    $totalAnte1 += $sell->TOTAL_COBRO;
    foreach ($operations as $op) {
        // $totalAnte2 += $op->IMPORTE_CREDITO;
        // $totalAnte3 += ($sell->TOTAL_COBRO - $op->IMPORTE_CREDITO);
    }
    $totalAnte3 += ($totalAnte2 - $totalAnte1);
}
$adi = 0;

$opr[0] = array(
    'NRO CREDITO',
    'RECIBO',
    'CLIENTE',
    'FACTURA',
    'IMPORTE COBRADO',
    'IMPORTE A COBRAR',
    'SALDO',
    'FECHA'
);
$opr[$k] = array(
    'Anterior',
    '',
    '',
    '',
    number_format($totalAnte1, 2, ',', '.'),
    number_format($totalAnte2, 2, ',', '.'),
    number_format($totalAnte2 -
        $totalAnte1, 2, ',', '.'),
    '',

);

// var_dump($opr[$k]);
// echo '<br>';
$k++;

$totalcobro = 0;
$totalHaber = 0;
$totalSaldo = 0;
$sumatotal = 0;
$suma = 0;
$totalDebe = 0;

$adi = 0;
$totalAnte3 = $totalAnte2 -
    $totalAnte1;
$totalAnte2 = 0;
foreach ($Ventas as $v) {
    $totalAnte3 += $v->credito;
    $totalAnte2 += $v->credito;
    $cliente = ClienteData::getById($v->cliente_id);
    $k++;
    $opr[$k] = array(
        $v->id,
        '',
        $cliente->nombre,
        $v->factura,
        '0,00',

        number_format($v->credito, 2, ',', '.'),
        number_format($totalAnte3, 2, ',', '.'),
        $v->fecha,

    );
}

$users = CobroCabecera::totalcobros($_GET['id_sucursal'], $_GET['cliente'], $_GET['sd'], $_GET['ed']);

foreach ($users as $sell) {

    // if ($sell) {
    $operations = CobroDetalleData::cobranza_credito($sell->COBRO_ID);
    $cred = $operations[0]->IMPORTE_CREDITO;
    foreach ($operations as $op) {
        // $opr[$k] = array(
        //     'NRO CREDITO',
        //     'RECIBO',
        //     'CLIENTE',
        //     'FACTURA',
        //     'IMPORTE COBRADO',
        //     'IMPORTE A COBRAR',
        //     'SALDO',
        //     'FECHA'
        // );
        $concepto = CajaCabecera::cajacabeceraconcepto($sell->COBRO_ID);

        if (isset($concepto[0]->FECHA) && ($concepto[0]->FECHA <= $_GET['ed'] && $concepto[0]->FECHA >= $_GET['sd'])) {
            $k++;
            $totalAnte1 += $sell->TOTAL_COBRO;
            $totalcobro += $sell->TOTAL_COBRO;
            $concepto2 = CajaDetalle::cajadetllecambio($sell->COBRO_ID);
            $totalcred += $op->IMPORTE_CREDITO;
            if ($sell->getCliente()->tipo_doc == "SIN NOMBRE") {
                $sell->getCliente()->tipo_doc;
                $cliente = $sell->getCliente()->tipo_doc;
            } else {
                $sell->getCliente()->nombre . " " . $sell->getCliente()->apellido;
                $cliente = $sell->getCliente()->nombre . " " . $sell->getCliente()->apellido;
            }
            $totalAnte3 -= $sell->TOTAL_COBRO;
            $opr[$k] = array(
                $op->NUMERO_CREDITO,
                $sell->RECIBO,
                $cliente,
                $op->NUMERO_FACTURA,
                number_format($sell->TOTAL_COBRO, 2, ',', '.'),

                number_format(0, 2, ',', '.'),
                number_format($totalAnte3, 2, ',', '.'),
                $sell->FECHA_COBRO,

            );
        }
        // }
    }
    $k++;
}
$opr[$k] = array(
    '',
    '',
    '',
    '',
    number_format($totalcobro, 2, ',', '.'),

    number_format($totalAnte2, 2, ',', '.'),
    number_format($totalAnte3, 2, ',', '.'),
    '',

);
// foreach ($operations as $credy) :

//     $opr[$k] = array(number_format('0', 2, ',', '.'));

//     $k++;


//     if ($k % 39  == $adi) {

//         $opr[$k] = array(
//             'Total Pagina',
//             '',
//             '',
//             '', '',
//             number_format($totalDebe, 2, ',', '.'),
//             number_format($totalHaber, 2, ',', '.'),
//             number_format($totalSaldo, 2, ',', '.'),
//             '',    '',
//         );
//         $k++;
//         $adi++;
//     }




// endforeach;
// $opr[$k] = array(
//     'Total',
//     '',
//     '',
//     '', '',
//     number_format($anterior + $totalcobro, 2, ',', '.'),
//     number_format($anterior2 + $totalHaber, 2, ',', '.'),
//     number_format($anterior3 + $totalSaldo, 2, ',', '.'),
//     '',    '',
// );
$pdf->imprimirReporte($cols, $width, $opr, true);
$pdf->Output();
