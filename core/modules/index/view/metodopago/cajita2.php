<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1><i class='fa fa-shopping-cart' style="color: orange;"></i>
            COBRANZA
            <!-- <marquee> Lista de Medicamentos</marquee> -->
        </h1>
    </section>
    <!-- Main content -->

    <section class="content">
        <?php if ((isset($_GET["id_cobro"]) && $_GET["id_cobro"] != "") || isset($_GET["id_venta"]) && $_GET["id_venta"] != "") : ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">

                                <div class="col-md-2">Tipo:</div>
                                <div class="col-md-2">
                                    <?php
                                    $tipos = CajaTipo::vercajatipo2();


                                    ?>
                                    <select required="" onselect="tipo()" onchange="tipo()" name="tipopago_id" id="tipopago_id" id1="valor" class="form-control">
                                        <!-- <option value="0">Seleccionar</option> -->
                                        <?php foreach ($tipos as $tipo) : ?>

                                            <option value="<?php echo $tipo->id_tipo ?>"><?= $tipo->nombre ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <select required="" name="tipopago" id="tipopago" class="form-control">
                                    </select>
                                    <input type="text" name="" class="form-control" placeholder="Vaucher" id="vaucher">
                                </div>
                                <div class="col-md-2">Moneda:</div>

                                <div class="col-md-2">
                                    <div>
                                        <?php
                                        $monedas = MonedaData::cboObtenerValorPorSucursal($_GET['id_sucursal']);
                                        $cambios = MonedaData::obtenerCambioMonedaPorSimbolo($_GET['id_sucursal'], "US$");
                                        $cambio1 = $cambios[0]->valor2;

                                        $cambios2 = MonedaData::obtenerCambioMonedaPorSimbolo($_GET['id_sucursal'], "₲");

                                        $cambio2 = $cambios2[0]->valor2;

                                        $cambio = $cambio2;

                                        ?>
                                        <select required="" name="tipomoneda_id" id="tipomoneda_id" id1="valor" class="form-control" oninput="tipocambio()">
                                            <!-- <option value="0">Seleccionar</option> -->
                                            <?php foreach ($monedas as $moneda) : ?>
                                                <?php
                                                $valocito = null;
                                                ?>
                                                <option value="<?php echo $moneda->id_tipomoneda; ?>"><?php echo $moneda->nombre . "-" . $moneda->simbolo; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                                $cotizacion = CotizacionData::versucursalcotizacion($_GET['id_sucursal']);
                                // var_dump($cotizacion);
                                $mon = MonedaData::cboObtenerValorPorSucursal3($_GET['id_sucursal']);
                                if (count($cotizacion) > 0) { ?>
                                    <?php
                                    $valores = 0;
                                    foreach ($cotizacion as $moneda) {
                                        $mon = MonedaData::cboObtenerValorPorSucursal3($_GET['id_sucursal']);
                                    ?>
                                        <?php foreach ($mon as $mo) : ?>
                                            <?php
                                            $nombre = $mo->nombre;
                                            $fechacotiz = $mo->fecha_cotizacion;
                                            $valores = $mo->valor;
                                            $simbolo2 = $mo->simbolo;
                                            ?>
                                        <?php endforeach; ?>
                                <?php
                                    }
                                }

                                ?>

                                <div class="col-md-2">Monto:</div>
                                <div class="col-md-2"><input type="number" name="" value="0" class="form-control" id="monto"></div>
                                <div class="col-md-2" style="margin-top: 20px;">Cambio:</div>
                                <div class="col-md-2" style="margin-top: 20px;">
                                    <input type="number" onchange="tipocambio()" name="cambio2" id="cambio2" class="form-control">

                                </div>
                                <div class="col-md-12" style="margin-top: 20px;"><button class="btn btn-info" onclick="agregar()">Agregar</button></div>


                            </div>
                            <div class="row">
                                <?php
                                $isventa = false;

                                $cobros = new CobroCabecera();
                                $cobro = $cobros->getCobro($_GET['id_cobro']);
                                $cobror = $cobro->TOTAL_COBRO;

                                $FECHA_REC = $cobro->FECHA_COBRO;

                                $cliente = $cobro->CLIENTE_ID;
                                $moneda = $cobro->MONEDA_ID;
                                $mon = $cobros->getMoneda($moneda);
                                // var_dump($cobro);
                                if ($mon->simbolo !== "US$") {
                                    $cobror =  $cobror * $mon->valor2;
                                }

                                ?>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <th>Metodo de pago</th>

                                        <th>Tipo</th>
                                        <th>Vaucher</th>
                                        <th>Importe</th>
                                        <th>Importe Convertido</th>

                                        <th>Moneda</th>
                                        <th>Cambio Moneda</th>
                                        <th>Acción</th>
                                    </thead>
                                    <tbody id="tbody">

                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2">Concepto:</div>
                                <div class="col-md-2"><input type="text" name="" value="" class="form-control" id="concepto"></div>
                                <div class="col-md-2">Fecha:</div>
                                <div class="col-md-2"><input type="text" name="" value="<?= $FECHA_REC ?>" class="form-control" id="fecha"></div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2">Total </div>
                                <div class="col-md-4" id="total"></div>
                                <div class="col-md-2" id="monedacambio">Total a cobrar</div>
                                <div class="col-md-2"><?= $cobror ?></div>
                                <div class="col-md-2">
                                    <button id="pagar" onclick="pagar()" class="btn btn-info">Pagar</button>
                                </div>

                            </div>
                            <br>

                            <form action="" method="post"></form>
                        </div>
                    </div>

                </div>
            <?php
        else : ?>
                501 Internal Error
            <?php endif; ?>
            </div>
            <script>
                var pagos = [];
                var total = 0;
                var tabla = [];
                $("#tipopago").hide();
                var totalCobro = '<?= $cobror; ?>';
                var cambio = parseFloat($("#cambio2").val());
                $("#total").html(total);
                $("#pagar").hide();
                $("#vaucher").hide();
                // $("#total2").html(totalCobro);
                var select = "";
                var monto = 0;

                function tipo() {

                    if ($("#tipopago_id").val() == 4) {
                        $("#tipopago").show();
                        $("#vaucher").show();

                        select = "";
                        $.ajax({
                            url: 'index.php?action=tipocaja',
                            type: 'GET',
                            data: {},
                            dataType: 'json',
                            success: function(json) {
                                console.log(json)
                                for (var i = 0; i < json.length; i++) {
                                    select += `<option value="${json[i].id_procesadora}">${json[i].nombre}</option> `


                                }
                                $("#tipopago").html(select);
                            },
                            error: function(xhr, status) {
                                console.log("Ha ocurrido un error.");
                            }
                        });
                    } else {
                        tipopago = ""
                        $("#tipopago").hide();
                        $("#vaucher").hide();

                    }
                }

                function agregar() {
                    tabla = "";
                    cambio = parseFloat($("#cambio2").val());
                    console.log($('#tipopago').val())
                    if ($("#tipopago_id").val() == 4) {
                        if ($('select[name="tipomoneda_id"] option:selected').text().includes('$')) {
                            total += parseFloat($('#monto').val() * cambio);
                            pagos.push({
                                "tipo_id": $('#tipopago_id').val(),
                                "cambio": '1',

                                "moneda_id": $('#tipomoneda_id').val(),
                                "tipo": $('select[name="tipopago_id"] option:selected').text(),
                                "moneda": $('select[name="tipomoneda_id"] option:selected').text(),
                                "monto2": parseFloat($('#monto').val()),
                                "monto": parseFloat($('#monto').val()),
                                "tipo_tar": $('#tipopago').val(),
                                "tipo_tar2": $('select[name="tipopago"] option:selected').text(),
                                "vaucher": $("#vaucher").val()

                            });
                        } else {
                            total += parseFloat($('#monto').val() / cambio);
                            pagos.push({
                                "tipo_id": $('#tipopago_id').val(),
                                "cambio": cambio,

                                "moneda_id": $('#tipomoneda_id').val(),
                                "tipo": $('select[name="tipopago_id"] option:selected').text(),
                                "moneda": $('select[name="tipomoneda_id"] option:selected').text(),
                                "monto": $('#monto').val(),
                                "monto2": $('#monto').val() / cambio,
                                "tipo_tar": $('#tipopago').val(),
                                "tipo_tar2": $('select[name="tipopago"] option:selected').text(),
                                "vaucher": $("#vaucher").val()
                            });
                        }
                    } else {
                        if ($('select[name="tipomoneda_id"] option:selected').text().includes('$')) {
                            total += parseFloat($('#monto').val() * cambio);
                            pagos.push({
                                "tipo_id": $('#tipopago_id').val(),
                                "cambio": '1',
                                "moneda_id": $('#tipomoneda_id').val(),
                                "tipo": $('select[name="tipopago_id"] option:selected').text(),
                                "moneda": $('select[name="tipomoneda_id"] option:selected').text(),
                                "monto2": parseFloat($('#monto').val()),
                                "monto": parseFloat($('#monto').val()),
                                "tipo_tar": 0,
                                "tipo_tar2": "",
                                "vaucher": ""
                            });
                        } else {
                            total += parseFloat($('#monto').val() / cambio);
                            pagos.push({
                                "tipo_id": $('#tipopago_id').val(),
                                "cambio": cambio,

                                "moneda_id": $('#tipomoneda_id').val(),
                                "tipo": $('select[name="tipopago_id"] option:selected').text(),
                                "moneda": $('select[name="tipomoneda_id"] option:selected').text(),
                                "monto": $('#monto').val(),
                                "monto2": $('#monto').val() / cambio,
                                "tipo_tar": 0,
                                "tipo_tar2": "",
                                "vaucher": ""

                            });
                        }
                    }


                    actualizarTabla()
                    $('#monto').val("0");
                }

                function eliminar(id) {
                    var resta = parseInt(pagos[id]['monto2']);
                    console.log(resta)
                    total = total - resta;
                    console.log(total)
                    pagos.splice(id, 1);
                    actualizarTabla()
                }

                function actualizarTabla() {
                    tabla = "";
                    for (const [id, pago] of Object.entries(pagos)) {
                        tabla += `<tr><td> ${pago.tipo}</td><td> ${pago.tipo_tar2}</td><td> ${pago.vaucher}</td><td> ${pago.monto}</td><td> ${pago.monto2}</td>
                        <td> ${pago.moneda}</td><td> ${pago.cambio}</td><td> <button class="btn btn-danger" onclick="eliminar(${id})">Eliminar</button></td></tr>`;
                    }
                    $("#tbody").html(tabla);


                    if (total >= totalCobro) {
                        $("#pagar").show();
                        $("#total").html(total + " Vuelto: " + (total - totalCobro));
                    } else {
                        console.log(totalCobro);
                        console.log(total);

                        $("#total").html(total + " Restante: " + (totalCobro - total));
                        $("#pagar").hide();
                    }
                }

                function tipocambio() {
                    $.ajax({
                        url: 'index.php?action=vermoneda',
                        type: 'GET',
                        data: {
                            id: '<?php echo $cobro->MONEDA_ID ?>',

                        },
                        dataType: 'json',
                        success: function(json) {
                            if (json.simbolo.includes("US$")) {
                                $('#cambio2').val('1');
                                if ($('select[name="tipomoneda_id"] option:selected').text().includes("US$")) {

                                    $("#monto").val(totalCobro * $("#cambio2").val());
                                } else {
                                    $("#monto").val(parseFloat(totalCobro * $("#cambio2").val()));
                                }

                            } else {
                                $('#cambio2').val(<?php echo $valores ?>);
                                if ($('select[name="tipomoneda_id"] option:selected').text().includes("US$")) {
                                    $("#monto").val(parseFloat(totalCobro * $("#cambio2").val()));
                                } else {
                                    $("#monto").val(parseFloat(totalCobro * $("#cambio2").val()));
                                }
                            }
                            console.log(json)

                        },
                        error: function(xhr, status) {
                            console.log("Ha ocurrido un error." + JSON.stringify(xhr));
                        }
                    });
                }
                tipocambio()

                function pagar() {

                    $.ajax({
                        url: 'index.php?action=cobrocaja',
                        type: 'POST',
                        data: {
                            pagos: pagos,
                            total: totalCobro,

                            sucursal: '<?= $_GET['id_sucursal'] ?>',
                            concepto: $("#concepto").val(),
                            fecha: $("#fecha").val(),
                            cliente: '<?= $cliente ?>',
                            cobro: '<?php
                                    echo $_GET['id_cobro'];
                                    ?>',

                        },
                        dataType: 'json',
                        success: function(json) {
                            window.open(`impresioncobro.php?concepto=${$('#concepto').val()}&fecha=${$('#fecha').val()}&cobro=<?php echo $_GET['id_cobro']; ?>`, '_blank');

                        },
                        error: function(xhr, status) {
                            console.log("Ha ocurrido un error." + JSON.stringify(xhr));
                        }
                    });


                }
            </script>
</div>
</div>
</div>
</section>
</div>