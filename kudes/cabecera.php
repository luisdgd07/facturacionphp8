<?php
if (isset($_GET['venta'])) {
    $venta = VentaData::getByIdInTable($_GET['venta'], "venta");
} else if (isset($_GET['remision'])) {
    $venta = VentaData::getByIdInTable($_GET['remision'], "remision");
} else if (isset($_GET['notacredito'])) {
    $venta = VentaData::getByIdInTable($_GET['notacredito'], "nota_credito_venta");
} else {
    die("No se encontro la venta");
}
$sucursal = SuccursalData::VerId($venta->sucursal_id);
if (isset($_GET['remision'])) {
    $tipo = "Remision";
} else if (isset($_GET['notacredito'])) {
    $tipo = "Nota de Credito";
} else {
    $tipo = "Factura";
}
?>

<div class="header">
    <div class="logo-img">
        <?php
        $logoPath = dirname(__DIR__) . '/logos/' . $sucursal->logo;
        $logoSrc = '';

        // Verificar si el archivo existe y convertirlo a base64
        if (file_exists($logoPath)) {
            $imageData = base64_encode(file_get_contents($logoPath));
            $imageInfo = getimagesize($logoPath);
            $mimeType = $imageInfo['mime'];
            $logoSrc = 'data:' . $mimeType . ';base64,' . $imageData;
        } else {
            // Si no existe, usar un logo por defecto (URL externa)
            $logoSrc = 'https://upload.wikimedia.org/wikipedia/commons/7/7e/Falanster_logo_300x300.png';
        }
        ?>
        <img height="70" width="70" src="<?php echo $logoSrc ?>" alt="Logo" />
    </div>

    <div class="company-info">

        <div class="logo"><?php echo $sucursal->nombre ?></div>
        <div><?php echo $sucursal->razon_social; ?></div>
        <div><?php echo $sucursal->direccion; ?></div>
        <div><?php echo $sucursal->ciudad_descripcion; ?></div>
        <div>Cel:<?php echo $sucursal->telefono; ?></div>
    </div>
    <div class="invoice-info">
        <div>Timbrado: <?php echo $sucursal->timbrado ?></div>
        <div>Inicio Vigencia: <?php echo $sucursal->fecha_tim ?></div>
        <div>RUC: <?php echo $sucursal->ruc ?></div>
        <div class="invoice-title"><?php echo $tipo ?></div>
        <div class="invoice-number"><?php echo $venta->factura ?></div>
        <div>Electrónica</div>
    </div>
</div>