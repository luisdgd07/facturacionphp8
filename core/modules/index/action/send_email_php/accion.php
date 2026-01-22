<?php
// Require Composer's autoloader
// Adjust path to vendor/autoload.php based on location: core/modules/index/action/send_email_php/
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Verificar que se haya enviado el ID de venta
if (!isset($_GET['venta'])) {
    die(json_encode(['success' => false, 'message' => 'Faltan parámetros requeridos (venta)']));
}

$ventaId = $_GET['venta'];
$venta = VentaData::getByIdInTable($ventaId, "venta");
$cliente = ClienteData::getById($venta->cliente_id);
$emailDestino = $cliente->email;


try {
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $options->set('defaultFont', 'Arial');

    // Create an instance of the Dompdf class
    $dompdf = new Dompdf($options);
    // Include kude_formato.php which generates the $html variable
    include __DIR__ . '/../../../../../kudes/kude_formato.php';
    // Load HTML content
    $dompdf->loadHtml($html, 'UTF-8');

    // Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();
    // Obtener el PDF como string en lugar de mostrarlo
    $pdfOutput = $dompdf->output();
    $sucursal = SuccursalData::VerId($_GET['sucursal']);

    // Configurar PHPMailer
    $mail = new PHPMailer(true);

    // CONFIGURACIÓN DEL SERVIDOR DE CORREO DESDE BASE DE DATOS
    $mail->isSMTP();
    $mail->Host = $sucursal->host;
    $mail->SMTPAuth = true;
    $mail->Username = $sucursal->email;
    $mail->Password = $sucursal->pass; // Usamos el campo pass
    if (!$mail->Password || $mail->Password == "") {
        // Fallback to clave if pass is empty
        $mail->Password = $sucursal->clave;
    }

    // Asumimos puerto 587 y TLS si no está especificado, o usar configuración
    $mail->Port = $sucursal->port;
    if ($mail->Port == 465) {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    } else {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    }

    $mail->CharSet = 'UTF-8';

    // Configurar el correo
    $mail->setFrom($sucursal->email, $sucursal->nombre);
    $mail->addAddress($emailDestino, $cliente->nombre . ' ' . $cliente->apellido);

    // Adjuntar el PDF
    $mail->addStringAttachment($pdfOutput, 'Factura_' . $venta->factura . '.pdf');

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Factura Electrónica #' . $venta->factura;
    $mail->Body = '
        <html>
        <body>
            <h2>Estimado/a ' . $cliente->nombre . ' ' . $cliente->apellido . ',</h2>
            <p>Adjunto encontrará su factura electrónica.</p>
            <p><strong>Detalles de la factura:</strong></p>
            <ul>
                <li>Número: ' . $venta->factura . '</li>
                <li>Fecha: ' . date('d/m/Y', strtotime($venta->fecha)) . '</li>
            </ul>
            <p>Gracias por su preferencia.</p>
            <br>
            <p>Saludos cordiales,<br>' . $sucursal->nombre . '</p>
        </body>
        </html>
    ';
    $mail->AltBody = 'Estimado/a ' . $cliente->nombre . ', adjunto encontrará su factura electrónica.';

    // Enviar el correo
    $mail->send();

    // Actualizar estado enviado en BD
    // $venta->id = $venta->id_venta;
    $venta->enviocorreo();

    echo json_encode([
        'success' => true,
        'message' => 'Factura enviada exitosamente a ' . $emailDestino
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al enviar el correo: ' . $e->getMessage()
    ]);
} catch (\Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
