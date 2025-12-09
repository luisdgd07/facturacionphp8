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
// $pdf = new FPDF();
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 18);
// $pdf->SetFillColor(0, 0, 255);
$pdf->SetFillColor(2, 157, 116);
$pdf->SetTextColor(46, 64, 83);
$pdf->Cell(40, 10, ' ', false, 'C');
$pdf->SetFont('Arial', 'B', 5.5);
$pdf->Ln();


$pdf->SetFillColor(2, 157, 116);
$pdf->SetTextColor(46, 64, 83);
$pdf->Cell(40, 10, ' ', false, 'C');
$pdf->SetFont('Arial', 'B', 5.5);
$pdf->Ln();
$pdf->SetFillColor(2, 157, 116);
$pdf->SetTextColor(46, 64, 83);
$pdf->Cell(40, 10, ' ', false, 'C');
$pdf->SetFont('Arial', 'B', 5.5);
$pdf->Ln();




$pdf->Cell(19, 7, "NUM", 1);

$pdf->Cell(14, 7, "FECHA", 1);


$pdf->Cell(45, 7, "RAZON SOCIAL", 1);

$pdf->Cell(14, 7, "RUC", 1);

$pdf->Cell(14, 7, "TIMBRADO", 1);

$pdf->Cell(14, 7, "GRAVADAS", 1);
$pdf->Cell(5, 7, "%", 1);

$pdf->Cell(14, 7, "IMPUESTOS", 1);
$pdf->Cell(14, 7, "EXCENTAS", 1);
$pdf->Cell(14, 7, "RET.IVA", 1);
$pdf->Cell(14, 7, "RET.RENTA", 1);

$pdf->Cell(14, 7, "TOTAL", 1);




$pdf->Ln();
$operations = VentaData::getAllByDateOfficialGs($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET["cliente"]);
$total = 0;
$totalg = 0;
$totali = 0;
$totalg5  = 0;
$totalii5  = 0;
$totalexent  = 0;

$porcentaje  = 10;
$cambio = 0;
$i = 0;
foreach ($operations as $operation) {
    if ($i == 35) {
        $pdf->AddPage();
        $i = 0;
    }

    if ($operation->simbolo2 == "US$") {
        $cambio = $operation->cambio;
    } else if (($operation->simbolo2 == "₲") and  ($operation->cambio == 1)) {
        $cambio = $operation->cambio2;
    } else if (($operation->simbolo2 == "₲") and  ($operation->cambio > 1)) {
        $cambio = 1;
    }


    $total = $total + ($operation->total * $cambio);
    $totalg = $totalg + ($operation->total10 * $cambio);
    $totali = $totali + ($operation->iva10 * $cambio);

    $totalg5 = $totalg5 + ($operation->total5 * $cambio);
    $totalii5 = $totalii5 + ($operation->iva5 * $cambio);
    $totalexent = $totalexent + ($operation->exenta * $cambio);





    $i++;


    $pdf->Cell(19, 7, $operation->factura, 1);
    $pdf->Cell(14, 7, $operation->fecha, 1);

    $pdf->Cell(45, 7, ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? $operation->getCliente()->tipo_doc
        : $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido), 1);


    $pdf->Cell(14, 7, ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? "X"
        : ($operation->getCliente()->tipo_doc == "CI" ? $operation->getCliente()->dni
            : $operation->getCliente()->dni)), 1);


    $pdf->Cell(14, 7, $operation->VerConfiFactura()->timbrado1, 1);

    $pdf->Cell(
        14,
        7,
        number_format(($operation->total10 * $cambio), 0, ',', '.'),
        1
    );

    $pdf->Cell(
        5,
        7,
        $porcentaje,
        1
    );


    $pdf->Cell(14, 7, number_format(($operation->iva10 * $cambio), 0, ',', '.'), 1);
    $pdf->Cell(
        14,
        7,
        number_format(($operation->total5 * $cambio), 0, ',', '.'),
        1
    );


    $pdf->Cell(
        14,
        7,
        number_format(($operation->iva5 * $cambio), 0, ',', '.'),
        1
    );


    $pdf->Cell(
        14,
        7,
        number_format(($operation->exenta * $cambio), 0, ',', '.'),
        1
    );
    $pdf->Cell(
        14,
        7,
        number_format(($operation->total * $cambio), 0, ',', '.'),
        1
    );


    $pdf->Ln();
}
$pdf->Cell(14, 7, "TOTAL", 1);
$pdf->Output();
