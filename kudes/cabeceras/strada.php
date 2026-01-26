<?php

?>

<div>

    <div style="position: absolute; top:18; left: 415; font-size: 10px; ">
        <strong>Timbrado:</strong>
        <?php echo $sucursal->timbrado ?>
    </div>
    <div style="position: absolute; top:38; left: 415;font-size: 10px; ">
        <strong>RUC:</strong>
        <?php echo $sucursal->ruc ?>
    </div>
    <div style="position: absolute; top:81; right: 75; font-size: 12px;font-weight: bold;">
        <?php echo $venta->factura ?>
    </div>
    <div style="position: absolute; top:52; left: 405; font-size: 20px; font-weight: bold;">
        <?php echo $tipo ?>
    </div>
    <div style="position: absolute; top:27; left: 415; font-size: 10px; ">
        <strong>Inicio Vigencia:</strong> <?php echo $sucursal->fecha_tim ?>
    </div>
    <table width="80%" style="border: none; margin: 0;" cellspacing="0" cellpadding="0">
        <tr>
            <td style="vertical-align: top; border: none;">
                <?php
                $logoPath = '../' . $sucursal->logo;
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
                <img src="<?php echo $logoSrc ?>" width="100%" alt="Logo" />
            </td>


        </tr>
    </table>

</div>