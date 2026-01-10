<?php
// Require Composer's autoloader
require '../vendor/autoload.php';

// Reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

// Create an instance of the Options class
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

// Create an instance of the Dompdf class
$dompdf = new Dompdf($options);

// HTML content for the PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #3498db; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Factura de Venta</h1>
    <p><strong>Fecha:</strong> ' . date('d/m/Y') . '</p>
    
    <h2>Datos del Cliente</h2>
    <p><strong>Nombre:</strong> Cliente Ejemplo S.A.<br>
    <strong>RUC:</strong> 80000000-1<br>
    <strong>Dirección:</strong> Av. Principal 1234</p>
    
    <h2>Productos</h2>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Producto 1</td>
                <td>2</td>
                <td>100,000</td>
                <td>200,000</td>
            </tr>
            <tr>
                <td>Producto 2</td>
                <td>1</td>
                <td>150,000</td>
                <td>150,000</td>
            </tr>
        </tbody>
    </table>
    
    <h3>Total: Gs. 350,000</h3>
</body>
</html>';

// Load HTML content
$dompdf->loadHtml($html, 'UTF-8');

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("factura.pdf", array("Attachment" => false));