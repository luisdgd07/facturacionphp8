<?php
$pais = PaisData::get($venta->getCliente()->pais_id);
$paisDes = $pais->descripcion;
$fleteraN = "";
if ($venta->fletera_id) {
    $fletera = FleteraData::ver($venta->fletera_id);
    $fleteraN = $fletera->nombre_empresa;
}
$agente = AgenteData::veragente($venta->agente_id);
$agenteNombre = "";
$agenteDirrecion = "";
$agenteCi = "";
if (isset($agente)) {
    $agenteNombre = $agente->nombre_agente;
    $agenteDirrecion = $agente->ruc;
    $agenteCi = $agente->direccion;
}
$embarque = "";
if (isset($venta->embarque)) {
    $embarque = $venta->embarque;
}
?>
</tbody>
</table>
<table width="100%" class="borde-r borde-l borde-t borde-b" style="margin-top:10px;">
    <thead>
        <tr style="border-bottom:1px">
            <td style="font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px"><b>Tipo de operación:</b> </p>
            </td>
            <td style="  font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px">Exportación </p>
            </td>
        </tr>

        <tr>
            <td style="  font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px"><b>Condición de Negociación:</b> </p>
            </td>
            <td style="  font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px">
                    <?php echo $venta->condiNego ?>
                </p>
            </td>
        </tr>
        <tr>
            <td style=" font-size:9px; font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px"><b>Pais Destino:</b> </p>
            </td>
            <td style=" font-size:9px; font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px">
                    <?php echo $paisDes ?>
                </p>
            </td>
        </tr>
        <tr>
            <td style="  font-size:9px;font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px"><b>Empresa Fletera o Exportador Nacional:</b> </p>
            </td>
            <td style=" font-size:9px; font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px">
                    <?php echo $fleteraN ?>
                </p>
            </td>
        </tr>
        <tr>
            <td style="font-size:9px;  font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px"><b>Agente de Transporte:</b> </p>
            </td>
            <td style="  font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px">
                    <?php echo $agenteNombre ?>
                </p>
            </td>
        </tr>
        <tr>
            <td style=" font-size:9px; width:40%; font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px"><b>Peso Neto: </b> </p>
            </td>
            <td style=" width:40%; font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px"> <?php echo $venta->peso_neto ?> KGS</p>
            </td>
        </tr>
        <tr>
            <td style="  font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px"><b>Peso Bruto: </b></p>
            </td>
            <td style="  font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px">
                    <?php echo $venta->peso_bruto ?> KGS
                </p>
            </td>
        </tr>
        <tr>
            <td style="  font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px"><b>N° de Conocimientos de Embarque:</b> </p>
            </td>
            <td style="  font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px">
                    <?php echo $embarque ?>
                </p>
            </td>
        </tr>
        <tr>
            <td style="  font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px"><b>N° de Manifiesto Internacional de Carga: </b> </p>
            </td>
            <td style="  font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px"> </p>
            </td>
        </tr>
        <tr>
            <td style="  font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px"><b>N° de Barcaza o Remolcador:</b> </p>
            </td>
            <td style="  font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px"> </p>
            </td>
        </tr>
        <tr>
            <td style="  font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px"><b>Instrucción del Pago:</b> </p>
            </td>
            <td style="  font-family:  Arial, Helvetica, sans-serif;">
                <p style="font-size:9px; margin:-2px 0px"> </p>
            </td>
        </tr>

    </thead>
</table>