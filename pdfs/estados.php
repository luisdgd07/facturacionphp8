<?php

include "./PDF.php";
$pdf = new PDF();
$sd = date("d-m-Y", strtotime($_GET['sd']));
$ed = date("d-m-Y", strtotime($_GET['ed']));
$title = 'Reporte de Ventas desde: ' . $sd . ' Hasta: ' . $ed;
$pdf->SetTitle($title);
$pdf->SetY(65);

$cols = [
    'Nº Crédito',
    'Cliente',
    'Nº Factura',
    'Cuota',
    'Mon',
    'Debe',
    'Haber',
    'Saldo',
    'Fecha Crédito',
    'Fecha Venc'
];
$width = [14, 35, 20, 15, 18, 18, 18, 18, 20, 15, 25, 30, 40, 25, 30, 30, 30, 40, 25, 30, 30];
$rows = [];
$total = 0;
$totall = 0;
$total = 0;
$totall = 0;
$sucur = SuccursalData::VerId($_GET["id_sucursal"]);
$total = 0;
$totalg = 0;
$totali = 0;
$totalg5 = 0;
$totalii5 = 0;
$totalexent = 0;
$totalusd = 0;
$totalcajas = 0;
$cambio = 0;
$j = 0;

$k = 1;
// 
$saldoanterior = 0;
$anterior = 0;
$anterior2 = 0;

$anterior3 = 0;
// echo 'ssssss';
$totalSaldo = 0;
$totalHaber = 0;
$nuevafecha =  date($_GET["sd"]);
$n = date("Y-m-d", strtotime($nuevafecha . "- 1 days"));
$operationsante = CreditoDetalleData::getAllByDateBCOp($_GET["cliente_id"], '1988-01-09', $n, $_GET["id_sucursal"]);
$saldoanterior = 0;

$anterior2 = 0;

$anterior3 = 0;
// echo 'ssssss';
$totalSaldo = 0;
$nuevafecha =  date($_GET["sd"]);
$n = date("Y-m-d", strtotime($nuevafecha . "- 1 days"));
$operationsante = CreditoDetalleData::getAllByDateBCOp($_GET["cliente_id"], '1988-01-09', $n, $_GET["id_sucursal"]);
// var_dump($operationsante);

// foreach ($operationsante as $credy2) {
//     $anterior = 0;
//     $operations2 = CobroDetalleData::cobranza_creditosum($credy2->credito_id, $credy2->cuota);
//     //$cred = $operations[0]->IMPORTE_CREDITO;
//     $totalHaber += $credy2->importe_credito;
//     // $totalcobro = 0;
//     if (count($operations2) > 0) {

//         foreach ($operations2 as $op) {
//             $COBRO_ID = $op->COBRO_ID;

//             $operations3 = CreditoDetalleData::busq_estado($COBRO_ID, $_GET["cliente_id"], '1988-01-09', $_GET["ed"], $_GET["id_sucursal"]);
//             //$cred = $operations[0]->IMPORTE_CREDITO;

//             if (count($operations3) > 0) {

//                 foreach ($operations3 as $op2) {
//                     // if ($op2->FECHA <= $_GET['ed'] && $op2->FECHA >= $_GET['sd']) {
//                     $totalcobro += $op2->TOTAL_COBRO;
//                     $totalSaldo += $credy2->importe_credito - $totalcobro;
//                     // }

//                 }
//             }
//         }
//     }
// nuevo
foreach ($operationsante as $credy2) {
    $totalHaber += $credy2->importe_credito;

    $totalcobro = 0;

    $users = CobroCabecera::totalcobrosG($_GET['id_sucursal'], $_GET['cliente_id'], '1988-01-09', $_GET["sd"], $credy2->credito_id);
    foreach ($users as $Co) {
        $totalcobro += $Co->TOTAL_COBRO;
        $anterior += $Co->TOTAL_COBRO;
    }
}
$anterior += $totalcobro;
$anterior2 = $totalHaber;
$anterior3 = $totalSaldo;
// echo number_format($totalcobro, 2, ',', '.');
// echo '<br>';

//
$operations = array();

if ($_GET["cliente_id"] == "") {
    $operations = CreditoDetalleData::getAllByDateOp($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
} else {
    $operations = CreditoDetalleData::getAllByDateBCOp($_GET["cliente_id"], $_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
}

$adi = 0;

$opr[0] = array(
    'Nº Crédito',
    'Cliente',
    'Nº Factura',
    'Cuota',
    'Mon',
    'Debe',
    'Haber',
    'Saldo',
    'Fecha Crédito',
    'Fecha Venc'
);
$opr[$k] = array(
    'Anterior',
    '',
    '',
    '', '',
    number_format($anterior, 2, ',', '.'),
    number_format($anterior2, 2, ',', '.'),
    number_format($anterior2 - $anterior, 2, ',', '.'),
    '',    '',
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
foreach ($operations as $credy) :
    // $totalcobro = 0;
    $venta = VentaData::getbyfactura($credy->nrofactura, $_GET['id_sucursal']);
    $ventas2 = MonedaData::cboObtenerValorPorSucursal2($credy->sucursal_id, $credy->moneda_id);
    if (count($ventas2) > 0) {
        $simbolomon = 0;
        foreach ($ventas2 as $simbolos) {
            $simbolomon = $simbolos->simbolo;
        }
    }
    if ($credy->getCliente($_GET['cliente_id']) == "SIN NOMBRE") {
        $credy->getCliente($_GET['cliente_id'])->tipo_doc;
        $cliente = $credy->getCliente($_GET['cliente_id'])->tipo_doc;
    } else {
        $credy->getCliente($_GET['cliente_id'])->nombre . " " . $credy->getCliente($_GET['cliente_id'])->apellido;
        $cliente = $credy->getCliente($_GET['cliente_id'])->nombre . " " . $credy->getCliente($_GET['cliente_id'])->apellido;
    }
    // anterior
    // $operations2 = CobroDetalleData::cobranza_creditosum($credy->credito_id, $credy->cuota);
    // //$cred = $operations[0]->IMPORTE_CREDITO;
    // $cobr = 0;
    // if (count($operations2) > 0) {

    //     foreach ($operations2 as $op) {

    //         $COBRO_ID = $op->COBRO_ID;

    //         $operations3 = CreditoDetalleData::busq_estado($COBRO_ID, $_GET["cliente_id"], $_GET["sd"], $_GET["ed"], $_GET["id_sucursal"]);
    //         //$cred = $operations[0]->IMPORTE_CREDITO;

    //         if (count($operations3) > 0) {

    //             foreach ($operations3 as $op2) {
    //                 // if ($op2->FECHA <= $_GET['ed'] && $op2->FECHA >= $_GET['sd']) {
    //                 $cobr += $op2->TOTAL_COBRO;
    //                 $totalcobro += $op2->TOTAL_COBRO;
    //                 // }


    //             }
    //         }
    //     } 
    // }
    $cobr = 0;
    $users = CobroCabecera::totalcobrosG($_GET['id_sucursal'], $_GET['cliente_id'], $_GET['sd'], $_GET['ed'], $credy->credito_id);
    foreach ($users as $Co) {
        $cobr += $Co->TOTAL_COBRO;
        $totalDebe += $Co->TOTAL_COBRO;
    }

    $ventaData = VentaData::buscarFactura($_GET['id_sucursal'], $credy->nrofactura);
    // var_dump($ventaData);
    $cobr += $ventaData->total;
    $totalDebe  += $ventaData->total;
    $opr[$k] = array($credy->credito_id, $cliente, $credy->nrofactura, $credy->cuota, $simbolomon, number_format($cobr, 2, ',', '.'), number_format($credy->importe_credito, 2, ',', '.'), number_format($credy->importe_credito, 2, ',', '.'), $credy->fecha, $credy->fecha_detalle);

    $k++;
    $totalHaber += $credy->importe_credito;
    $totalSaldo += $credy->importe_credito - $cobr;

    if ($k % 39  == $adi) {

        $opr[$k] = array(
            'Total Pagina',
            '',
            '',
            '', '',
            number_format($totalDebe, 2, ',', '.'),
            number_format($totalHaber, 2, ',', '.'),
            number_format($totalSaldo, 2, ',', '.'),
            '',    '',
        );
        $k++;
        $adi++;
        // $opr[$k] = array(
        //     'Fecha',
        //     'Cliente',
        //     'Factura',
        //     'RUC',
        //     'Gravada 5',
        //     'Gravada 10',
        //     'Exentas',
        //     'IVA 5',
        //     'IVA 10',
        //     'Timbrado',
        // );
        // $k++;
    }




endforeach;
$opr[$k] = array(
    'Total',
    '',
    '',
    '', '',
    number_format($totalDebe, 2, ',', '.'),
    number_format($totalHaber, 2, ',', '.'),
    number_format($anterior3 + $totalSaldo, 2, ',', '.'),
    '',    '',
);
// foreach ($operations as $operation) {


// $opr[$k] = array();

// // var_dump($opr[$k]);
// // echo '<br>';
// $k++;

// if ($k % 39 == $adi) {

// $opr[$k] = array(
// "Total pagina",
// '',
// '',
// '',
// number_format($totalg5, 0, ',', '.'),
// number_format($totalg, 0, ',', '.'),
// number_format($totalexent, 0, ',', '.'),
// number_format($totalii5, 0, ',', '.'),
// number_format($totali, 0, ',', '.'),
// ''
// );
// $k++;
// $adi++;
// // $opr[$k] = array(
// // 'Fecha',
// // 'Cliente',
// // 'Factura',
// // 'RUC',
// // 'Gravada 5',
// // 'Gravada 10',
// // 'Exentas',
// // 'IVA 5',
// // 'IVA 10',
// // 'Timbrado',
// // );
// // $k++;
// }
// }
// $opr[$k] = array(
// "Total",
// '',
// '',
// '',
// number_format($totalg5, 0, ',', '.'),
// number_format($totalg, 0, ',', '.'),
// number_format($totalexent, 0, ',', '.'),
// number_format($totalii5, 0, ',', '.'),
// number_format($totali, 0, ',', '.'),
// ''
// );
// var_dump($opr);
$pdf->imprimirReporte($cols, $width, $opr, true);
$pdf->Output();
