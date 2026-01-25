<?php

?>

<div>
    <div style="position: absolute; top:81; right: 75; font-size: 12px;font-weight: bold;">
        <?php echo $venta->factura ?>
    </div>
    <div style="position: absolute; top:52; right: 50; font-size: 20px; font-weight: bold;">
        <?php echo $tipo ?>
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

            <!-- <td style="vertical-align: top; border: none; text-align: center; ">
                <div class="company-info" style="margin-left: 0; width: 100%; ">
                    <div class="logo" style="text-transform: uppercase">
                        <?php echo $sucursal->nombre ?>
                    </div>
                    <div>
                        ssssssss <?php echo $sucursal->razon_social; ?>
                    </div>
                    <div>
                        <?php echo $sucursal->actividad; ?>
                    </div>


                    <div>
                        <?php echo $sucursal->direccion; ?>
                    </div>
                    <div>
                        <?php echo $sucursal->ciudad_descripcion; ?>
                    </div>
                    <div>Cel:
                        <?php echo $sucursal->telefono; ?>
                    </div>
                </div>
            </td>
            <td width="180px" style="vertical-align: top; border: none;">

            </td> -->
        </tr>
    </table>
    <!-- <div class="border"></div>
    <div class="invoice-info">
        <div>Timbrado:
            <?php echo $sucursal->timbrado ?>
        </div>
        <div>Inicio Vigencia:
            <?php echo $sucursal->fecha_tim ?>
        </div>
        <div>RUC:
            <?php echo $sucursal->ruc ?>
        </div>
        <div class="invoice-title">
            <?php echo $tipo ?>
        </div>
        <div class="invoice-number">
            <?php echo $venta->factura ?>
        </div>
        <div>Electrónica</div>
    </div> -->
</div>