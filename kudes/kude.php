<?php
// Require Composer's autoloader
require __DIR__ . '/../vendor/autoload.php';
include __DIR__ . "/../core/autoload.php";
include __DIR__ . "/../core/modules/index/model/VentaData.php";
include __DIR__ . "/../core/modules/index/model/OperationData.php";
include __DIR__ . "/../core/modules/index/model/MonedaData.php";
include __DIR__ . "/../core/modules/index/model/ProductoData.php";
include __DIR__ . "/../core/modules/index/model/UserData.php";
include __DIR__ . "/../core/modules/index/model/FleteraData.php";
include __DIR__ . "/../core/modules/index/model/AgenteData.php";
include __DIR__ . "/../core/modules/index/model/ClienteData.php";
include __DIR__ . "/../core/modules/index/model/VehiculoData.php";
include __DIR__ . "/../core/modules/index/model/ChoferData.php";
include __DIR__ . "/../core/modules/index/model/PaisData.php";
include __DIR__ . "/../core/modules/index/model/UnidadesData.php";
include __DIR__ . "/../core/modules/index/model/SuccursalData.php";
session_start();

include "kude_formato.php";

// Load HTML content
$dompdf->loadHtml($html, 'UTF-8');

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("factura_electronica.pdf", array("Attachment" => false));
