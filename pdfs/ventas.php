<?php

include "./PDF.php";
$pdf = new PDF();
$sd = date("d-m-Y", strtotime($_GET['sd']));
$ed = date("d-m-Y", strtotime($_GET['ed']));
$title = 'Reporte de Ventas desde: ' . $sd . ' Hasta: ' . $ed;
$pdf->SetTitle($title);
$pdf->SetY(65);

$cols = [
    'Fecha',
    'Cliente',
    'Factura',

    'RUC',
    'Cambio',

    // 'Gravada 5',
    // 'Gravada 10',
    // 'Exentas',
    // 'IVA 5 Gs',
    // 'IVA 10 Gs',
    'Total Gs',
    'Total $',
    'Moneda',

    // 'Timbrado',
];
$width = [13, 75, 20, 14, 10, 25, 25, 12, 14, 15, 15, 30, 40, 25, 30, 30, 30, 40, 25, 30, 30];
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

$opr[0] = array(
    'Fecha',
    'Cliente',
    'Factura',

    'RUC',
    'Cambio',

    // 'Gravada 5',
    // 'Gravada 10',
    // 'Exentas',
    // 'IVA 5 Gs',
    // 'IVA 10 Gs',
    'Total Gs',
    'Total $',
    'Moneda',
    // 'Timbrado',
);
$k = 1;
$operations = VentaData::getAllPersonalizado($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['prod'], $_GET['venta'], $_GET['cliente']);
$adi = 0;
foreach ($operations as $operation) {



    $totalg5 = $totalg5 + $operation->total5 * $cambio;
    $totalii5 = $totalii5 + $operation->iva5 * $cambio;

    $totalgG = $totalg + $operation->total10;
    $totaliG = $totali + $operation->iva10;
    $totalg5G = $totalg5 + $operation->total5;
    $totalii5G = $totalii5 + $operation->iva5;
    $totalexentG = $totalexent + $operation->exenta;
    $textC = "0";
    if ($operation->VerTipoModena()->simbolo == "US$") {
        $cambio = $operation->cambio2;
        $textC = "Dolares";
        $totali = $totali + $operation->total;
    } else {
        $cambio = 1;
        $textC = "Guaranies";
        $totalg = $totalg + $operation->total * $cambio;
    }
    if ($operation->factura !== null) {
        // $cambio = $operation->cambio2;
        $total = $total + ($operation->total - $operation->descuento) * $cambio;
        $nombre = "";

        if ($operation->getCliente()->tipo_doc == "SIN NOMBRE") {
            $nombre = "X";
        } else {
            $nombre = substr($operation->getCliente()->dni, 0, 12);
        }
        if ($operation->VerTipoModena()->simbolo == "US$") {
            $totalusd = $totalusd + $operation->total;
            $opr[$k] = array(
                $operation->fecha,
                ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? $operation->getCliente()->tipo_doc
                    : $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido),
                $operation->factura,


                substr($operation->getCliente()->dni, 0, 12),
                $cambio,
                // number_format(($operation->iva5 * $cambio), 0, ',', '.'),
                // number_format(($operation->total10 * $cambio), 0, ',', '.'),
                // number_format($operation->descuento, 0, '.', '.'),
                '0,00',
                number_format(($operation->total), 0, ',', '.'),
                $textC
                // number_format(($operation->total5 * $cambio), 0, ',', '.'),
                // number_format(($operation->iva10 * $cambio), 0, ',', '.'),
                // $operation->VerConfiFactura()->timbrado1,
                // $k
            );
        } else {
            $opr[$k] = array(
                $operation->fecha,
                ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? $operation->getCliente()->tipo_doc
                    : $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido),
                $operation->factura,


                substr($operation->getCliente()->dni, 0, 12),
                $cambio,
                // number_format(($operation->iva5 * $cambio), 0, ',', '.'),
                // number_format(($operation->total10 * $cambio), 0, ',', '.'),
                // number_format($operation->descuento, 0, '.', '.'),
                number_format(($operation->total * $cambio), 0, ',', '.'),
                '0,00',
                $textC
                // number_format(($operation->total5 * $cambio), 0, ',', '.'),
                // number_format(($operation->iva10 * $cambio), 0, ',', '.'),
                // $operation->VerConfiFactura()->timbrado1,
                // $k
            );
        }


        // var_dump($opr[$k]);
        // echo '<br>';
        $k++;

        if ($k % 39  == $adi) {

            $opr[$k] = array(
                "Total pagina",
                '',
                '',
                '',
                '',
                // '',
                // '',
                number_format($totalg, 0, ',', '.'),
                number_format($totali, 0, ',', '.'),
                ''
                // number_format($totalii5G, 0, ',', '.'),
                // number_format($totalii5, 0, ',', '.'),
                // number_format($totali, 0, ',', '.'),
                // '',
                // ''
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
    }
}
$opr[$k] = array(
    "Total",
    '',
    '',
    '',
    '',
    // '',
    // '',
    // number_format($totalg5, 0, ',', '.'),
    // number_format($totalg, 0, ',', '.'),
    // number_format($totalii5G, 0, ',', '.'),
    number_format($totalg, 0, ',', '.'),
    number_format($totali, 0, ',', '.'),
    ''
);
// var_dump($opr);
$pdf->imprimirReporte($cols, $width, $opr, true);
$pdf->Output();
