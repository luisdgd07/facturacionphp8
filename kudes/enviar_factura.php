<?php
// Require Composer's autoloader
require '../vendor/autoload.php';
include "../core/autoload.php";
include "../core/modules/index/model/VentaData.php";
include "../core/modules/index/model/OperationData.php";
include "../core/modules/index/model/MonedaData.php";
include "../core/modules/index/model/ProductoData.php";
include "../core/modules/index/model/ClienteData.php";

// Reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Verificar que se haya enviado el ID de venta y el email
if (!isset($_GET['venta']) || !isset($_GET['email'])) {
    die(json_encode(['success' => false, 'message' => 'Faltan parámetros requeridos']));
}

$ventaId = $_GET['venta'];
$emailDestino = $_GET['email'];

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

try {
    // Obtener datos de la venta
    $venta = VentaData::getById($ventaId);
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

    // Create an instance of the Options class
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $options->set('defaultFont', 'Arial');

    // Create an instance of the Dompdf class
    $dompdf = new Dompdf($options);

    // HTML content for the PDF (mismo contenido que kude.php)
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
    $html .= ob_get_clean();

    $tipo = "Factura Electrónica";

    $html .= '<table style="margin-bottom: 10px; font-size: 9px; border: none;">
    <tr>
        <td style="width: 80px; border: none;"><strong>Fecha de Emisión:</strong></td>
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
        <td style="border: none;"></td>
        <td style="border: none;"></td>
    </tr>
</table>

    <table>
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

    $operaciones = OperationData::getAllProductsBySellIddd($venta->id_venta);
    $total = 0;
    $totalIva5 = 0;
    $totalIva10 = 0;
    $totalExenta = 0;

    foreach ($operaciones as $operacion) {
        $iva5 = 0;
        $iva10 = 0;
        $exenta = 0;
        $producto = ProductoData::getById($operacion->producto_id);
        $total += $operacion->precio * $operacion->q;

        if ($producto->impuesto == 0) {
            $exenta = $operacion->precio * $operacion->q;
            $totalExenta += $operacion->precio * $operacion->q;
        }
        if ($producto->impuesto == 5) {
            $iva5 = $operacion->precio * $operacion->q;
            $totalIva5 += $operacion->precio * $operacion->q;
        }
        if ($producto->impuesto == 10) {
            $totalIva10 += $operacion->precio * $operacion->q;
            $iva10 = $operacion->precio * $operacion->q;
        }

        $html .= '<tr>
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

    $html .= '</tbody>
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
                 <td style="text-align: right; border: none;"><strong>(5%) ' . $totalIva5 . ' &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;(10%) ' . $totalIva10 . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Total IVA : ' . ($totalIva5 + $totalIva10) . '</strong></td>
            </tr>
            <tr>
                <td style="border: none;"><strong>TOTAL EN LETRAS:</strong></td>
                <td style="text-align: right; border: none;">SON ' . strtoupper($moneda->nombre) . ', ' . numeroALetras($total) . '</td>
            </tr>
        </table>

        <div style="margin-top: 10px;"><strong>Observación:</strong></div>


    <div class="footer">
        <div>Consulte la validez de esta Factura Electrónica con el número de CDC https://ekuatia.set.gov.py/consultas</div>
        <div>CDC: ' . $venta->cdc . '</div>
        <div class="qr-code">
            <img src="' . $qrImageData . '" alt="QR Code">
        </div>
    </div>
</body>
</html>';

    // Load HTML content
    $dompdf->loadHtml($html, 'UTF-8');

    // Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Obtener el PDF como string en lugar de mostrarlo
    $pdfOutput = $dompdf->output();

    // Cargar configuración de correo
    $emailConfig = require 'email_config.php';

    // Configurar PHPMailer
    $mail = new PHPMailer(true);

    // CONFIGURACIÓN DEL SERVIDOR DE CORREO
    $mail->isSMTP();
    $mail->Host = $emailConfig['smtp_host'];
    $mail->SMTPAuth = true;
    $mail->Username = $emailConfig['smtp_username'];
    $mail->Password = $emailConfig['smtp_password'];
    $mail->SMTPSecure = $emailConfig['smtp_secure'] === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = $emailConfig['smtp_port'];
    $mail->CharSet = $emailConfig['charset'];

    // Habilitar debug si está configurado
    if ($emailConfig['debug']) {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    }

    // Configurar el correo
    $mail->setFrom($emailConfig['from_email'], $emailConfig['from_name']);
    $mail->addAddress($emailDestino, $cliente->nombre . ' ' . $cliente->apellido);

    // Adjuntar el PDF
    $mail->addStringAttachment($pdfOutput, 'factura_' . $venta->id_venta . '.pdf');

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Factura Electrónica #' . $venta->id_venta;
    $mail->Body = '
        <html>
        <body>
            <h2>Estimado/a ' . $cliente->nombre . ' ' . $cliente->apellido . ',</h2>
            <p>Adjunto encontrará su factura electrónica.</p>
            <p><strong>Detalles de la factura:</strong></p>
            <ul>
                <li>Número: ' . $venta->id_venta . '</li>
                <li>Fecha: ' . date('d/m/Y', strtotime($venta->fecha)) . '</li>
                <li>Total: ' . $moneda->simbolo . ' ' . number_format($total, 2) . '</li>
            </ul>
            <p>Gracias por su preferencia.</p>
            <br>
            <p>Saludos cordiales,<br>' . $emailConfig['from_name'] . '</p>
        </body>
        </html>
    ';
    $mail->AltBody = 'Estimado/a ' . $cliente->nombre . ', adjunto encontrará su factura electrónica.';

    // Enviar el correo
    $mail->send();

    echo json_encode([
        'success' => true,
        'message' => 'Factura enviada exitosamente a ' . $emailDestino
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al enviar el correo: ' . $mail->ErrorInfo
    ]);
} catch (\Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
