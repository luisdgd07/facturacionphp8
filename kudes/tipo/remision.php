<?php
$venta = VentaData::getByIdInTable($_GET['remision'], "remision");
$motivo = $venta->tipo_remision;
$tipoRemision = "";
if ($motivo == 1) {
    $tipoRemision = "Traslado por ventas";
} else if ($motivo == 2) {
    $tipoRemision = "Traslado por consignación";
} else if ($motivo == 3) {
    $tipoRemision = "Exportación";
} else if ($motivo == 4) {
    $tipoRemision = "Traslado por compra";
} else if ($motivo == 5) {
    $tipoRemision = "Importación";
} else if ($motivo == 6) {
    $tipoRemision = "Traslado por devolución";
} else if ($motivo == 7) {
    $tipoRemision = "Traslado entre locales de la empresa";
} else if ($motivo == 8) {
    $tipoRemision = "Traslado de bienes por transformación";
} else if ($motivo == 9) {
    $tipoRemision = "Traslado de bienes por reparación";
} else if ($motivo == 10) {
    $tipoRemision = "Traslado por emisor móvil";
} else if ($motivo == 11) {
    $tipoRemision = "Exhibición o demostración";
} else if ($motivo == 12) {
    $tipoRemision = "Participación en ferias";
} else if ($motivo == 13) {
    $tipoRemision = "Traslado de encomienda";
} else if ($motivo == 14) {
    $tipoRemision = "Decomiso";
} else if ($motivo == 99) {
    $tipoRemision = "Otro";
}
$cliente = ClienteData::getById($venta->cliente_id);
$u = UserData::getById($_SESSION["admin_id"]);
$sucursal = SuccursalData::VerId($venta->sucursal_id);
$chofer = ChoferData::getId($venta->id_chofer);


$tipoTrasporte = "Particular";
if ($venta->tipo_transporte && $venta->tipo_transporte == 2) {
    $tipoTrasporte = "Tercero";
}
if (!is_null($venta->fletera_id)) {
    $fletera = FleteraData::ver($venta->fletera_id);
    $fleteraN = $fletera->nombre_empresa;
}
$nombreFletera = is_null($venta->fletera_id) ? $sucursal->direccion : $fletera->nombre_empresa;
$direccionFlete = is_null($venta->fletera_id) ? $sucursal->direccion : $fletera->direccion;
$rucFlete = is_null($venta->fletera_id) ? $sucursal->ruc : $fletera->ruc;
$vehiculo = VehiculoData::getId($venta->id_vehiculo);

?>


<p style="font-size:9px;text-align:center; margin-top:-15px;">DATOS DEL TRASLADO</p>

<table class="borde-l borde-r borde-t borde-b" width="100%" style="padding: 5px 0px">
    <thead>

        <tr>
            <td style="width:50%;">
                <p style="font-size:7px;margin: -2px 0px"> <b> Motivo de Emisión: </b>
                    <?php echo $tipoRemision; ?>
                </p>
            </td>

            <td style="width:50%;">
                <p style="font-size:7px;margin: -2px 0px"> <b> Responsable de la Emisión: </b>
                    <?php echo $u->nombre . " " . $u->apellido; ?>
                </p>

            </td>
        </tr>
        <tr>
            <td style="width:50%;">
                <p style="font-size:7px;margin: -2px 0px"> <b> Fecha inicio del traslado: </b>
                    <?php echo date('d/m/Y', strtotime($venta->fecha_envio)); ?> </p>

            </td>
            <td style="width:50%;">
                <p style="font-size:7px;margin: -2px 0px"> <b> Fecha estimada de fin del traslado:</b>
                    <?php echo date('d/m/Y', strtotime($venta->fecha_envio)); ?>
                </p>

            </td>
        </tr>
        <tr>
            <td>
                <p style="font-size:7px;margin:-2px 0px"> <b> Dirección del punto de partida:</b>
                    <?php echo $sucursal->direccion; ?>
                </p>

            </td>
            <td>
                <p style="font-size:7px;margin: -2px 0px"> <b>Ciudad del punto de partida:</b>
                    <?php echo $sucursal->ciudad_descripcion; ?>
                </p>

            </td>

        </tr>


        <tr>
            <td>
                <p style="font-size:7px;margin:-2px 0px"> <b> Departamento del punto de partida:</b>
                    <?php echo $sucursal->departamento_descripcion; ?>
                </p>

            </td>

            <td>
                <p style="font-size:7px;margin: -2px 0px"> <b>Kilometros de recorrido:</b> 0</p>

            </td>
        </tr>



        <tr>
            <td>
                <p style="font-size:7px;margin: -2px 0px"> <b>N° de casa de salida: </b>
                </p>
            </td>

            <td>
                <p style="font-size:7px;margin: -2px 0px"> <b>N° de casa de entrega:</b> </p>
            </td>
        </tr>
        <tr>

            <td>
                <p style="font-size:7px;margin: -2px 0px"> <b> Cel :</b> </p>

            </td>
            <td>

            </td>

        </tr>
    </thead>
</table>
<p style="font-size:9px;text-align:center">DATOS DEL VEHICULO DE TRANSPORTE</p>
<table class="borde-l borde-r borde-t borde-b" width="100%" style="margin-top:10px; padding: 5px 0px">
    <thead>

        <tr>

            <td style="width:50%;">
                <p style="font-size:7px;margin: -2px 0px"><b> Tipo de transporte:</b>
                    <?php echo $tipoTrasporte; ?>
                </p>
            </td>

            <td style="width:50%;">
                <p style="font-size:7px;margin: -2px 0px"> <b>Modalidad de transporte:</b>
                    <?php echo $tipoTrasporte; ?>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="font-size:7px;margin: -2px 0px"> <b>Responsable del costo del flete:</b>
                    <?php echo $nombreFletera; ?>
                </p>

            </td>
            <td>
                <p style="font-size:7px;margin: -2px 0px"> <b>Condición de la negociación:</b>
                    <?php echo $tipoTrasporte; ?>
                </p>

            </td>
        </tr>

        <tr>
            <td>
                <p style="font-size:7px;margin:-2px 0px"> <b>Fecha estimada de inicio de traslado: </b>
                    <?php echo date('d/m/Y', strtotime($venta->fecha_envio)); ?>

                </p>

            </td>

            <td>
                <p style="font-size:7px;margin: -2px 0px"> <b>Fecha estimada de fin de traslado:</b>
                    <?php echo date('d/m/Y', strtotime($venta->fecha_envio)); ?>

                </p>

            </td>
        </tr>
        <tr>

            <td>
                <p style="font-size:7px;margin: -2px 0px"> <b>Marca del vehículo:</b>
                    <?php echo $vehiculo->marca ?>
                </p>


            </td>


            <td>
                <p style="font-size:7px;margin: -2px 0px"> <b> Tipo de vehiculo: </b>Camión</p>
            </td>

        </tr>

        <tr>
            <td>
                <p style="font-size:7px;margin: -2px 0px"> <b> N° de matrícula(Chapa) del vehiculo:</b>
                    <?php echo $vehiculo->chapa_nro ?>
                </p>
            </td>
            <td style="">
                <p style="font-size:7px;margin: -2px 0px"> <b> N° de matricula carreta (chapa) carreta:</b>
                    <?php echo $vehiculo->rua_nro ?>
                </p>

            </td>
        </tr>


    </thead>
</table>
<p style="font-size:9px;text-align:center;padding:0px">DATOS DEL CONDUCTOR DEL VEHICULO</p>
<table class="borde-l borde-r borde-t borde-b" width="100%" style="margin-top:10px; padding: 5px 0px">
    <thead>


        <tr>
            <td>
                <p style="font-size:7px;margin: -2px 0px"> <b> Número de documento de identidad del chofer:</b>
                    <?php
                    echo $chofer->cedula;
                    ?>
                </p>

            </td>
            <td>
                <p style="font-size:7px;margin: -2px 0px"> <b>Numero de teléfono:</b>
                    <?php
                    echo $chofer->telefono;
                    ?>
                </p>

            </td>
        </tr>

        <tr>
            <td>
                <p style="font-size:7px;margin:-2px 0px"> <b> Nombre o razón Social del chofer: </b>
                    <?php
                    echo $sucursal->razon_social;
                    ?>
                </p>

            </td>

            <td>
                <p style="font-size:7px;margin: -2px 0px"> <b> Dirección:</b>
                    <?php
                    echo $chofer->direccion;
                    ?>
                </p>


            </td>
        </tr>
        <tr>


            <td>
                <p style="font-size:7px;margin: -2px 0px"> <b>Naturaleza del transportista: </b>
                    <?php
                    echo $tipoTrasporte;
                    ?>
                </p>


            </td>
            <td>

            </td>
        </tr>




    </thead>
</table>