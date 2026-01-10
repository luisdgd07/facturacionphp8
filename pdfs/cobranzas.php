<?php

include "./PDF.php";
$pdf = new PDF();
$sd = date("d-m-Y", strtotime($_GET['sd']));
$ed = date("d-m-Y", strtotime($_GET['ed']));
$title = 'Reporte de Cobranzas desde: ' . $sd . ' Hasta: ' . $ed;
$pdf->SetTitle($title);
$pdf->SetY(65);

$cols = [
    'NRO CREDITO',
    'RECIBO',
    'CLIENTE',
    'IMPORTE COBRO',
    'IMPORTE CREDITO',
    'SALDO',
    'FECHA',
    'FACTURA',
    'RETENCION'
];
$width = [20, 15, 34, 25, 25, 18, 15, 20, 20, 15];
$date1 = $_GET["sd"];
$date2 = $_GET["ed"];
$sucurs = $_GET["id_sucursal"];
$total = 0;
$totall = 0;
$sumatotal = 0;
$suma = 0;
$total1 = 0;
$total2 = 0;

$total3 = 0;

$operations = array();
$k = 1;
$users = CobroCabecera::totalcobros($_GET['id_sucursal'], $_GET['cliente'], $_GET['sd'], $_GET['ed']);
$totalcobro = 0;
$totalcred = 0;
$totalsaldo = 0;
$totalret = 0;
$j = 0;
$opr[0] = array(
    'NRO CREDITO',
    'RECIBO',
    'CLIENTE',
    'IMPORTE COBRO',
    'IMPORTE CREDITO',
    'SALDO',
    'FECHA',
    'FACTURA',
    'RETENCION'
);
$adi = 0;
foreach ($users as $sell) {
    if ($sell) {
        $operations = CobroDetalleData::cobranza_credito($sell->COBRO_ID);
        $cred = $operations[0]->IMPORTE_CREDITO;
        foreach ($operations as $op) {
            $concepto = CajaCabecera::cajacabeceraconcepto($sell->COBRO_ID);
            if ($concepto[0]->FECHA <= $_GET['ed'] && $concepto[0]->FECHA >= $_GET['sd']) {
                $j++;

                if ($sell->getCliente()->tipo_doc == "SIN NOMBRE") {
                    $sell->getCliente()->tipo_doc;
                    $cliente = $sell->getCliente()->tipo_doc;
                } else {
                    $sell->getCliente()->nombre . " " . $sell->getCliente()->apellido;
                    $cliente = $sell->getCliente()->nombre . " " . $sell->getCliente()->apellido;
                }
                $totalcobro += $sell->TOTAL_COBRO;
                // echo ;
                $concepto = CajaDetalle::cajadetllecambio($sell->COBRO_ID);
                $totalcred += $op->IMPORTE_CREDITO;

                $cred -= $sell->TOTAL_COBRO;
                $totalsaldo += $cred;

                $concepto = CajaCabecera::cajacabeceraconcepto($sell->COBRO_ID);
                $concepto = CajaCabecera::cajacabeceraconcepto($sell->COBRO_ID);
                foreach ($concepto as $cobrosdet) {
                    if ($cobrosdet) {


                        $conceptos = $cobrosdet->concepto;
                    }
                }
                // echo ;
                $totalRetencion = 0;
                $facturas = RetencionDetalleData::retencionfactura($op->NUMERO_FACTURA);
                foreach ($facturas as $fact) {
                    $totalRetencion += (float) $fact->importe;
                }
                $totalret += $totalRetencion;
                // echo ;
                $opr[$k] = array(
                    // $k,
                    $op->NUMERO_CREDITO,
                    $sell->RECIBO, $cliente, $sell->TOTAL_COBRO, $op->IMPORTE_CREDITO, $cred, $concepto[0]->FECHA, $op->NUMERO_FACTURA, $totalRetencion
                );
            }
        }
        $k++;
    }
    if ($k % 39  == $adi) {

        $opr[$k] = array(
            "Total Pagina",
            '',
            '',
            $totalcobro,
            $totalcred,
            $totalsaldo,
            '',

            '',

            $totalret,
        );
        $k++;
        // $opr[$k] = array(
        //     'NRO CREDITO',
        //     'RECIBO',
        //     'CLIENTE',
        //     'IMPORTE COBRO',
        //     'IMPORTE CREDITO',
        //     'SALDO',
        //     'FECHA',
        //     'FACTURA',
        //     'RETENCION'
        // );
        // $k++;
        $adi++;
    }
}
// $users = CobroCabecera::totalcobros($_GET['id_sucursal'], $_GET['cliente'], $_GET['sd'], $_GET['ed']);
// $operations = VentaData::getAllPersonalizado($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['prod'], $_GET['venta'], $_GET['cliente']);

// foreach ($operations as $operation) {
//     $totalg = $totalg + $operation->total10 * $cambio;
//     $totali = $totali + $operation->iva10 * $cambio;

//     $totalg5 = $totalg5 + $operation->total5 * $cambio;
//     $totalii5 = $totalii5 + $operation->iva5 * $cambio;
//     $totalexent = $totalexent + $operation->exenta * $cambio;

//     if ($operation->simbolo2 == "US$") {
//         $cambio = $operation->cambio;
//     } else if (($operation->simbolo2 == "₲") and  ($operation->cambio == 1)) {
//         $cambio = $operation->cambio2;
//     } else if (($operation->simbolo2 == "₲") and  ($operation->cambio > 1)) {
//         $cambio = 1;
//     }


//     $cambio = $operation->cambio2;
//     $total = $total + ($operation->total - $operation->descuento) * $cambio;

//     $totalusd = $totalusd + $operation->total;


//     $opr[$k] = array(
//         $operation->fecha,
//         ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? $operation->getCliente()->tipo_doc
//             : $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido),
//         $operation->factura,


//         substr($operation->getCliente()->dni, 0, 12),
//         number_format(($operation->iva5 * $cambio), 0, ',', '.'),
//         number_format(($operation->total10 * $cambio), 0, ',', '.'),
//         number_format($operation->descuento, 0, '.', '.'),
//         number_format(($operation->total5 * $cambio), 0, ',', '.'),
//         number_format(($operation->iva10 * $cambio), 0, ',', '.'),
//         $operation->VerConfiFactura()->timbrado1,
//         // $k
//     );

//     // var_dump($opr[$k]);
//     // echo '<br>';
//     $k++;
//     if ($k % 29 == 0) {

//         $opr[$k] = array(
//             "Total pagina",
//             '',
//             '',
//             '',
//             number_format($totalg5, 0, ',', '.'),
//             number_format($totalg, 0, ',', '.'),
//             number_format($totalexent, 0, ',', '.'),
//             number_format($totalii5, 0, ',', '.'),
//             number_format($totali, 0, ',', '.'),
//             ''
//         );
//         $k++;
//     }
//     if ($k % 30 == 0) {

//         $opr[$k] = array(
//             'Fecha',
//             'Cliente',
//             'Factura',
//             'RUC',
//             'Gravada 5',
//             'Gravada 10',
//             'Exentas',
//             'IVA 5',
//             'IVA 10',
//             'Timbrado',
//         );
//         $k++;
//     }
// }
$opr[$k] = array(
    "Total",
    '',
    '',
    $totalcobro,
    $totalcred,
    $totalsaldo,
    '',
    '',

    $totalret,
);
// var_dump($opr);
$pdf->imprimirReporte($cols, $width, $opr, true);
$pdf->Output();
