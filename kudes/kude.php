<?php
// Require Composer's autoloader
require '../vendor/autoload.php';
include "../core/autoload.php";
include "../core/modules/index/model/VentaData.php";
include "../core/modules/index/model/OperationData.php";
include "../core/modules/index/model/MonedaData.php";
include "../core/modules/index/model/ProductoData.php";
include "../core/modules/index/model/UserData.php";
include "../core/modules/index/model/FleteraData.php";
include "../core/modules/index/model/AgenteData.php";
include "../core/modules/index/model/ClienteData.php";
include "../core/modules/index/model/VehiculoData.php";
include "../core/modules/index/model/ChoferData.php";
include "../core/modules/index/model/PaisData.php";
session_start();

// Reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// Function to convert numbers to words in Spanish
function numeroALetras($numero)
{
    $unidades = ['', 'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
    $decenas = ['', 'DIEZ', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];
    $especiales = ['DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE'];
    $centenas = ['', 'CIENTO', 'DOSCIENTOS', 'TRESCIENTOS', 'CUATROCIENTOS', 'QUINIENTOS', 'SEISCIENTOS', 'SETECIENTOS', 'OCHOCIENTOS', 'NOVECIENTOS'];

    $numero = number_format($numero, 2, '.', '');
    $partes = explode('.', $numero);
    $entero = (int) $partes[0];
    $decimal = $partes[1];

    if ($entero == 0) {
        return 'CERO CON ' . $decimal . '/100';
    }

    $resultado = '';

    // Millones
    if ($entero >= 1000000) {
        $millones = floor($entero / 1000000);
        if ($millones == 1) {
            $resultado .= 'UN MILLON ';
        } else {
            $resultado .= convertirGrupo($millones, $unidades, $decenas, $especiales, $centenas) . ' MILLONES ';
        }
        $entero = $entero % 1000000;
    }

    // Miles
    if ($entero >= 1000) {
        $miles = floor($entero / 1000);
        if ($miles == 1) {
            $resultado .= 'MIL ';
        } else {
            $resultado .= convertirGrupo($miles, $unidades, $decenas, $especiales, $centenas) . ' MIL ';
        }
        $entero = $entero % 1000;
    }

    // Centenas, decenas y unidades
    if ($entero > 0) {
        $resultado .= convertirGrupo($entero, $unidades, $decenas, $especiales, $centenas);
    }

    return trim($resultado) . ' CON ' . $decimal . '/100';
}

function convertirGrupo($numero, $unidades, $decenas, $especiales, $centenas)
{
    $resultado = '';

    // Centenas
    if ($numero >= 100) {
        $c = floor($numero / 100);
        if ($numero == 100) {
            $resultado .= 'CIEN ';
        } else {
            $resultado .= $centenas[$c] . ' ';
        }
        $numero = $numero % 100;
    }

    // Decenas y unidades
    if ($numero >= 10 && $numero < 20) {
        $resultado .= $especiales[$numero - 10];
    } elseif ($numero >= 20) {
        $d = floor($numero / 10);
        $u = $numero % 10;
        if ($u == 0) {
            $resultado .= $decenas[$d];
        } else {
            if ($d == 2) {
                $resultado .= 'VEINTI' . $unidades[$u];
            } else {
                $resultado .= $decenas[$d] . ' Y ' . $unidades[$u];
            }
        }
    } elseif ($numero > 0) {
        $resultado .= $unidades[$numero];
    }

    return trim($resultado);
}

// Create an instance of the Options class
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'Arial');

// Create an instance of the Dompdf class
$dompdf = new Dompdf($options);

if (isset($_GET['venta'])) {
    $venta = VentaData::getByIdInTable($_GET['venta'], "venta");
} else if (isset($_GET['remision'])) {
    $venta = VentaData::getByIdInTable($_GET['remision'], "remision");
} else if (isset($_GET['notacredito'])) {
    $venta = VentaData::getByIdInTable($_GET['notacredito'], "nota_credito_venta");
} else {
    die("No se encontro la venta");
}
$cliente = ClienteData::getById($venta->cliente_id);

$moneda = MonedaData::vermonedaid($venta->tipomoneda_id);

// Generate QR Code
$qrImageData = null;
if (isset($venta->kude) && $venta->kude !== "") {
    $qrCode = new QrCode($venta->kude);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);
    $qrImageData = $result->getDataUri();
}

// HTML content for the PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page { margin: 0; }
        body { 
            font-family: Arial, sans-serif; 
            margin: 10px;
            padding: 10px;
            font-size: 10px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 15px;
            border: 1px solid #000;
        }
        .company-info {
            width: 40%;
            margin-left: 100px;
        }
        .logo-img{
           position: absolute;
           left: 35px;
           top: 40px;
        }
        .logo {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        .invoice-info {
            position: absolute;
            left:75%;
            border-left:1px solid #000;
            top: 20px;
            font-size: 9px;
            padding: 10px;
        }
        .invoice-title {
            font-size: 16px;
            font-weight: bold;
            margin: 3px 0;
        }
        .invoice-number {
            font-size: 12px;
            margin: 2px 0;
        }
   
  
        .section-title {
            font-weight: bold;
            margin: 5px 0 3px 0;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            font-size: 9px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
            font-size: 8px;
        }
        th, td {
            border: 1px solid #000;
            padding: 3px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .totals {
            margin-top: 10px;
            width: 45%;
            float: right;
            font-size: 9px;
        }

        .footer {
            margin-top: 15px;
            font-size: 8px;
            clear: both;
            padding: 15px;
            border: 1px solid #000;
        }
        .qr-code {
            margin-left:85%;
            width: 100px;
        }
        .qr-code img {
            width: 100%;
            height: auto;
        }
        .observation {
            margin-top: 10px;
            font-size: 9px;
        }
        .observation-box {
            border: 1px solid #000;
            min-height: 30px;
            padding: 3px;
            margin-top: 3px;
        }

    </style>
</head>
<body>
';
ob_start();
include 'cabecera.php';
$html = $html . ob_get_clean();
$tipo = "Factura Electrónica";
// $html = $html . var_dump($venta);
$html = $html . '<table style="margin-bottom: 10px; font-size: 9px; border: none;">
    <tr>
        <td style="width: 150px; border: none;"><strong>Fecha de Emisión:</strong></td>
        <td style="width: 25%; border: none;">' . date('d/m/Y', strtotime($venta->fecha)) . '</td>
        <td style="width: 80; border: none;"><strong>Condición Venta:</strong></td>
        <td style="width: 25%; border: none;">' . $venta->metodopago . '</td>
    </tr>
    <tr>
        <td style="width: 30px; border: none;"><strong>RUC:</strong></td>
        <td style="border: none;">' . $cliente->dni . '</td>
        <td style="border: none;"><strong>Tipo Cambio:</strong></td>
        <td style="border: none;">' . $venta->cambio . '</td>
    </tr>
    <tr>
        <td style="border: none;"><strong>Razón Social:</strong></td>
        <td style="border: none;">' . $cliente->nombre . ' ' . $cliente->apellido . '</td>
        <td style="border: none;"><strong>Moneda:</strong></td>
        <td style="border: none;">' . $moneda->simbolo . '</td>
    </tr>
    <tr>
        <td style="border: none;"><strong>Dirección:</strong></td>
        <td style="border: none;">' . $cliente->direccion . '</td>
        <td style="border: none;"><strong>Tipo Operación:</strong></td>
        <td style="border: none;">' . $tipo . '</td>
    </tr>
    <tr>
        <td style="border: none;"><strong>Tel:</strong></td>
        <td style="border: none;">' . $cliente->telefono . '</td>
        <td style="border: none;"><b>Cdc asociado:</b></td>
        <td style="border: none;">' . $venta->cdc_fact . '</td>
    </tr>';
if (isset($_GET['notacredito'])) {
    $html = $html . '<tr>
        <td style="border: none;"><strong>Tipo de Documento Asociado:</strong></td>
        <td style="width: 25%; border: none;">Venta de mercaderia</td>
        <td style="width: 25%; border: none;"></td>
        <td style="width: 25%; border: none;"></td>
    </tr>';
}
$html = $html . '</table>';
if (isset($_GET['remision'])) {
    ob_start();
    include 'tipo/remision.php';
    $html .= ob_get_clean();
}
$html = $html . '<table>
        <thead>
            <tr>
                <th style="width: 8%;">Código</th>
                <th style="width: 25%;">Descripción</th>
                <th style="width: 8%;">Unidad de medida</th>
                <th style="width: 6%;">Cantidad</th>
                <th style="width: 10%;">Precio Unitario</th>
                <th style="width: 8%;">Descuentos</th>
                <th style="width: 8%;">Exenta</th>
                <th style="width: 8%;">5%</th>
                <th style="width: 8%;">10%</th>
            </tr>
        </thead>
        <tbody>';

$table = "";
if (isset($_GET['remision'])) {
    $table = "remision_detalle";
} else if (isset($_GET['notacredito'])) {
    $table = "nota_de_credito_venta_detalle";
} else {
    $table = "operacion";
}
$operaciones = OperationData::getAllProductsBySellTable($venta->id_venta, $table);
$total = 0;
$totalIva5 = 0;
$totalIva10 = 0;
$totalExenta = 0;
foreach ($operaciones as $operacion) {
    $iva5 = 0;
    $iva10 = 0;
    $exenta = 0;

    $fila = $operacion->is_sqlserver ? "id_sqlserver" : "id_producto";
    $producto = ProductoData::getById($operacion->producto_id, $fila);
    $total += $operacion->precio * $operacion->q;

    if ($producto->impuesto == 0) {
        $exenta = $operacion->precio * $operacion->q;
        $totalexenta += $operacion->precio * $operacion->q;
    }
    if ($producto->impuesto == 5) {
        $iva5 = $operacion->precio * $operacion->q;
        $totalIva5 += $operacion->precio * $operacion->q;
    }
    if ($producto->impuesto == 10) {
        $totalIva10 += $operacion->precio * $operacion->q;

        $iva10 = $operacion->precio * $operacion->q;
    }
    $html = $html . '<tr>
                <td class="text-center">' . $producto->codigo . '</td>
                <td>' . $producto->descripcion . '</td>
                <td class="text-center">' . $producto->presentacion . '</td>
                <td class="text-center">' . $operacion->q . '</td>
                <td class="text-right"> ' . $operacion->precio . '</td>
                <td class="text-right">0</td>
                <td class="text-right">' . $exenta . '</td>
                <td class="text-right">' . $iva5 . '</td>
                <td class="text-right">' . $iva10 . '</td>
            </tr>';
}
if (isset($_GET['remision'])) {
    $html = $html . '</tbody>
    </table>';
} else if ($venta->tipo_venta == 20) {
    ob_start();
    include 'tipo/exportacion.php';
    $html .= ob_get_clean();
    $html = $html . '</tbody>
    </table>

        <table style="width: 100%; margin-top: 10px; font-size: 9px; border: none;">
            <tr>
                <td style="width: 30%; border: none;"><strong>SUBTOTAL:</strong></td>
                <td style="width: 70%; text-align: right; border: none;">' . $total . '</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>TOTAL OPERACIÓN MONEDA EXTRANJERA:</strong></td>
                <td style="text-align: right; border: none;">' . $total . '</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>TOTAL EN GUARANIES:</strong></td>
                <td style="text-align: right; border: none;">' . $total * $venta->cambio . '</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>LIQUIDACIÓN IVA:</strong></td>
                 <td style="text-align: right; border: none;"><strong>(5%) ' . $totalIva5 . ' &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;(10%) ' . $totalIva10 . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Total IVA : ' . $totalIva5 + $totalIva10 . '</strong></td>
            </tr>
            <tr>
                <td style="border: none;"><strong>TOTAL EN LETRAS:</strong></td>
                <td style="text-align: right; border: none;">SON ' . strtoupper($moneda->nombre) . ', ' . numeroALetras($total) . '</td>
            </tr>
        </table>
';
} else {
    $html = $html . '</tbody>
    </table>

        <table style="width: 100%; margin-top: 10px; font-size: 9px; border: none;">
            <tr>
                <td style="width: 30%; border: none;"><strong>SUBTOTAL:</strong></td>
                <td style="width: 70%; text-align: right; border: none;">' . $total . '</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>TOTAL OPERACIÓN MONEDA EXTRANJERA:</strong></td>
                <td style="text-align: right; border: none;">' . $total . '</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>TOTAL EN GUARANIES:</strong></td>
                <td style="text-align: right; border: none;">' . $total * $venta->cambio . '</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>LIQUIDACIÓN IVA:</strong></td>
                 <td style="text-align: right; border: none;"><strong>(5%) ' . $totalIva5 . ' &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;(10%) ' . $totalIva10 . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Total IVA : ' . $totalIva5 + $totalIva10 . '</strong></td>
            </tr>
            <tr>
                <td style="border: none;"><strong>TOTAL EN LETRAS:</strong></td>
                <td style="text-align: right; border: none;">SON ' . strtoupper($moneda->nombre) . ', ' . numeroALetras($total) . '</td>
            </tr>
        </table>
';
}
$html = $html . '<div style="margin-top: 10px;"><strong>Observación:</strong></div>


    <div class="footer">
        <div>Consulte la validez de esta Factura Electrónica con el número de CDC https://ekuatia.set.gov.py/consultas</div>
        <div>CDC: ' . $venta->cdc . '</div>
        <div class="qr-code">
            <img src="' . $qrImageData . '" alt="QR Code">
        </div>
    </div>
</body>
</html>';
// echo $html;
// Load HTML content
$dompdf->loadHtml($html, 'UTF-8');

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("factura_electronica.pdf", array("Attachment" => false));
