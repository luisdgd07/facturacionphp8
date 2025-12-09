<!-- Content Wrapper. Contains page content -->

<body id="cuerpoPagina">
    <div class="zona_impresion">
        <?php
        $total = 0;
        $moneda = 'PYG';
        $ventas = VentaData::getById($_GET["id_venta"]);
        $procesos = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
        if ($ventas->VerTipoModena()->simbolo == "₲") {
            $moneda = 'PYG';
        } else {
            $moneda = 'USD';
        }
        ?>
        <?= $rucEmisor = $ventas->verSocursal()->ruc ?>
        <?= $telefonoEmisor =  $ventas->verSocursal()->telefono ?>
        <?= $ventas->VerConfiFactura()->timbrado1 ?>

        <?php if ($ventas->numerocorraltivo >= 1 & $ventas->numerocorraltivo < 10) : ?>
            <?= $facturaN =    "000000" . $ventas->numerocorraltivo ?>
        <?php else : ?>
            <?php if ($ventas->numerocorraltivo >= 10 & $ventas->numerocorraltivo < 100) : ?>
                <?= $facturaN = "00000" . $ventas->numerocorraltivo ?>
            <?php else : ?>
                <?php if ($ventas->numerocorraltivo >= 100 & $ventas->numerocorraltivo < 1000) : ?>
                    <?= $facturaN =  "0000" . $ventas->numerocorraltivo ?>
                <?php else : ?>
                    <?php if ($ventas->numerocorraltivo >= 1000 & $ventas->numerocorraltivo < 10000) : ?>
                        <?= $facturaN = "000" . $ventas->numerocorraltivo ?>
                    <?php else : ?>
                        <?php if ($ventas->numerocorraltivo >= 100000 & $ventas->numerocorraltivo < 1000000) : ?>
                            <?= $facturaN = "00" . $ventas->numerocorraltivo ?>
                        <?php else : ?>
                            <?php if ($ventas->numerocorraltivo >= 1000000 & $ventas->numerocorraltivo < 10000000) : ?>
                                <?= $facturaN = "0" . $ventas->numerocorraltivo ?>
                            <?php else : ?>
                                SIN ACCION
                            <?php endif ?>
                        <?php endif ?>
                    <?php endif ?>
                <?php endif ?>
            <?php endif ?>
        <?php endif ?>
        <?php if ($ventas->getCliente()->tipo_doc == "SIN NOMBRE") {
            $ventas->getCliente()->tipo_doc;
            $cliente = $ventas->getCliente()->tipo_doc;
        } else {
            $ventas->getCliente()->nombre . " " . $ventas->getCliente()->apellido;
            $cliente = $ventas->getCliente()->nombre . " " . $ventas->getCliente()->apellido;
        } ?>

        <?= $rucCliente = $ventas->getCliente()->dni ?>


        <?= $direccionCliente = $ventas->getCliente()->direccion ?>


        <?= $vendedor = $ventas->getUser()->nombre . " " . $ventas->getUser()->apellido ?>

    </div>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <form class="form-horizontal" role="form" method="post" hidden name="facturacion" action="index.php?action=agregarenvio" enctype="multipart/form-data">
            <input type="text" name="venta" id="venta" value="<?php echo $_GET['id_venta'] ?>">
            <input type="text" name="estado" id="estado" value="">
            <input type="text" name="cdc" id="cdc" value="">
            <input type="text" name="xml" id="xml" value="">
            <button type="submit">envio</button>
        </form>
        <h1><i class='fa fa-shopping-cart' style="color: orange;"></i>
            DETALLE FACTURA VENTA
            <!-- <marquee> Lista de Medicamentos</marquee> -->
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <input type="hidden" name="xml_string" id="xml_string">
                        <input type="hidden" name="certandkey" id="certandkey">
                        <?php if (isset($_GET["id_venta"]) && $_GET["id_venta"] != "") : ?>
                            <?php

                            $sell = VentaData::getById($_GET["id_venta"]);
                            $operations = OperationData::getAllProductsByVenta($_GET["id_venta"]);
                            $total = 0;
                            ?>

                            <?php if ($sell->numerocorraltivo == "") : ?>
                            <?php else : ?>
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="color: blue;">Factura N°:</th>

                                        <th><?php echo $sell->factura; ?></th>
                                        <th style="color: blue;">Tipo Venta:</th>

                                        <th><?php echo $sell->metodopago; ?></th>






                                        <th style="color: blue;">Tipo de Comprobante:</th>
                                        <th><?php echo $sell->VerConfiFactura()->comprobante1; ?></th>


                                        <th style="color: blue;">Fecha venta:</th>
                                        <th><?php echo $sell->fecha; ?></th>


                                        <th style="color: blue;">Moneda:</th>

                                        <th><?php echo $sell->VerTipoModena()->nombre; ?></th>


                                    </tr>
                                </table>
                            <?php endif ?>
                            <br>
                            <table class="table table-bordered">
                                <?php if ($sell->cliente_id != "") :
                                    $client = $sell->getCliente();
                                ?>

                                    <td class="alert alert-warning"><b>CLIENTE:</b></td>


                                    <td class="alert alert-warning">

                                        <?php
                                        $dptClient = $client->departamento_id;
                                        $distClient = $client->distrito_id;
                                        if ($client->tipo_doc == "SIN NOMBRE") {
                                            echo  $client->tipo_doc;
                                        } else {
                                            echo  $client->nombre . " " . $client->apellido;
                                        } ?>

                                        <?php


                                        ?>
                                    </td>

                                <?php endif; ?>
                                <?php if ($sell->usuario_id != "") :
                                    $user = $sell->getUser();
                                ?>

                                    <td class="alert alert-warning"><b>USUARIO:</b></td>
                                    <td class="alert alert-warning"><?php echo $user->nombre . " " . $user->apellido; ?></td>

                                <?php endif; ?>
                            </table>
                            <br>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <th>Codigo</th>
                                    <th>Cantidad</th>
                                    <th>Nombre del Producto</th>
                                    <th>Precio Unitario</th>
                                    <th>Total</th>

                                </thead>
                                <?php
                                $precio = 0;
                                $total3 = 0;
                                $total4 = 0;
                                $cant = 0;
                                $productosItem  = array();
                                $tipo = ProductoData::verinsumo($operations[0]->sucursal_id);
                                $insumo = $tipo->ID_TIPO_PROD;
                                foreach ($operations as $operation) {
                                    $product  = $operation->getProducto();
                                    if ($product->ID_TIPO_PROD == $insumo) {
                                    } else {

                                        if ($operation->q == 0) {
                                            $cant = $operation->precio3;
                                        } else {
                                            $cant = $operation->q;
                                        };

                                        array_push($productosItem, json_encode(array(
                                            "codigo" => $product->codigo,
                                            "descripcion" => $product->nombre,
                                            "observacion" => "",
                                            "unidadMedida" => UnidadesData::getById($product->presentacion)->nombre,
                                            "cantidad" => $cant,
                                            "precioUnitario" => $operation->precio,
                                            "cambio" => "0",
                                            "ivaTipo" => 1,
                                            "ivaBase" => "100",
                                            "iva" => $product->impuesto,
                                            "lote" => "",
                                            "vencimiento" => "",
                                            "numeroSerie" => "",
                                            "numeroPedido" => ""
                                        )));


                                ?>
                                        <tr>
                                            <td><?php echo $product->codigo; ?></td>
                                            <td><?php echo $cant; ?></td>
                                            <td><?php echo $product->nombre; ?></td>





                                            <td><?php echo number_format(($operation->precio), 2, ",", "."); ?></td>



                                            <td><?php echo number_format(($operation->precio * $cant), 2, ",", "."); ?></td>
                                            </b></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </table>
                            <br><br>
                            <div class="row">
                                <div class="col-md-4">
                                    <table class="table table-bordered">

                                        <tr>
                                            <td>
                                                <h4>SUBTOTAL: </h4>
                                            </td>
                                            <td>
                                                <h4><?php echo number_format($sell->total, 2, ",", "."); ?></h4>
                                            </td>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4>TOTAL: </h4>
                                            </td>
                                            <td>
                                                <h4><?php echo number_format($sell->total, 2, ",", ".");
                                                    ?></h4>
                                            </td>

                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <h4>METODO DE PAGO: </h4>
                            <?php
                            $cotizacion = CotizacionData::versucursalcotizacion($_GET['id_sucursal']);
                            $mon = MonedaData::cboObtenerValorPorSucursal3($_GET['id_sucursal']);
                            if (count($cotizacion) > 0) {
                                $valores = 0;
                                foreach ($cotizacion as $moneda) {
                                    $mon = MonedaData::cboObtenerValorPorSucursal3($_GET['id_sucursal']);
                                    foreach ($mon as $mo) :
                                        $nombre = $mo->nombre;
                                        $fechacotiz = $mo->fecha_cotizacion;
                                        $valores = $mo->valor;
                                        $simbolo2 = $mo->simbolo;
                                    endforeach;
                                }
                            }

                            ?>
                            <input type="hidden" name="cambio2" id="cambio2" value="<?php echo $valores; ?>" class="form-control">
                            <div class="box">

                                <div class="box-body">
                                    <div class="row">

                                        <div class="col-md-2">Tipo:</div>
                                        <div class="col-md-2">
                                            <?php
                                            $tipos = CajaTipo::vercajatipo2();
                                            ?>
                                            <select required="" onselect="tipo()" onchange="tipo()" name="tipopago_id" id="tipopago_id" id1="valor" class="form-control">
                                                <?php foreach ($tipos as $tipo) :
                                                ?>

                                                    <option value="<?php echo $tipo->id_tipo ?>"><?= $tipo->nombre ?></option>
                                                <?php
                                                endforeach; ?>
                                            </select>
                                            <div id="tarjeta">
                                                <select required="" id="tipopago" class="form-control">
                                                </select>
                                                <input type="text" name="" class="form-control" placeholder="Vaucher" id="vaucher">
                                                <label for="tarjeta">Tipo:</label>
                                                <select id="tarjeta_id" class="form-control" name="tarjeta">
                                                    <option value="1">Visa</option>
                                                    <option value="2">Mastercard</option>
                                                    <option value="3">American Express</option>
                                                    <option value="4">Maestro</option>
                                                    <option value="5">Panal</option>
                                                    <option value="6">Cabal</option>
                                                    <option value="99">Otro</option>
                                                </select>
                                            </div>

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
                                                <select required="" name="tipomoneda_id2" id="tipomoneda_id2" id1="valor" class="form-control" oninput="tipocambio()">
                                                    <?php
                                                    $i = 0;
                                                    foreach ($monedas as $moneda) : ?>
                                                        <?php
                                                        $valocito = null;
                                                        $i++;
                                                        if ($i == 1) {
                                                        ?>
                                                            <option selected value="<?php echo $moneda->id_tipomoneda; ?>"><?php echo $moneda->nombre . "-" . $moneda->simbolo; ?></option>
                                                        <?php } else {

                                                        ?>
                                                            <option value="<?php echo $moneda->id_tipomoneda; ?>"><?php echo $moneda->nombre . "-" . $moneda->simbolo; ?></option>
                                                    <?php
                                                        }

                                                    endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">Monto:</div>
                                        <div class="col-md-2"><input type="number" name="" value="0" class="form-control" id="monto"></div>
                                        <div class="" id="cheque">
                                            <div class="col-md-2">Banco:</div>
                                            <div class="col-md-2">

                                                <?php
                                                $bancos = BancoData::getBancos();

                                                ?>
                                                <select id="banco_cheque" name="banco_cheque" class="form-control">
                                                    <?php foreach ($bancos as $banco) { ?>
                                                        <?php echo $banco->nombre_banco ?>
                                                        <option value="<?php echo $banco->id_banco ?>" selected><?php echo $banco->nombre_banco ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">Cheque Nro:</div>
                                            <div class="col-md-2"><input type="text" name="" class="form-control" id="nroCheque"></div>
                                        </div>
                                        <div class="" id="transferencia">
                                            <div class="col-md-2">Banco:</div>
                                            <div class="col-md-2">
                                                <?php
                                                $bancos = BancoData::getBancos();
                                                ?>
                                                <select id="banco_trans" name="banco_trans" class="form-control">
                                                    <?php foreach ($bancos as $banco) { ?>
                                                        <?php echo $banco->nombre_banco ?>
                                                        <option value="<?php echo $banco->id_banco ?>" selected><?php echo $banco->nombre_banco ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-2">Recibo:</div>
                                            <div class="col-md-2"><input type="text" name="" class="form-control" id="recibo"></div>

                                        </div>
                                        <?php
                                        $tipo = $sell->metodopago;
                                        $entregas = array();

                                        if ($sell->id_venta && $tipo == "Contado") {
                                            $cajas = CajaDetalle::obtenerVenta($sell->id_venta);

                                            $cobroId = (!empty($cajas) && isset($cajas[0]->COBRO_ID)) ? $cajas[0]->COBRO_ID : null;
                                            if ($cajas && !empty($cajas)) {
                                                foreach ($cajas  as $caja) {
                                                    if ($sell->VerTipoModena()->simbolo == "₲") {
                                                        $moneda = 'GUARANIES-₲';
                                                    } else {
                                                        $moneda = 'DOLARES-US$';
                                                    }
                                                    $cod = $caja->CAJA;
                                                    if ($cod == 1) {
                                                        array_push(
                                                            $entregas,
                                                            [
                                                                'tipo_id' => "1",
                                                                'bancoText' => "",
                                                                'cambio' => $caja->CAMBIO,
                                                                "moneda_id" => $caja->ID_MONEDA,
                                                                "tipo" => "EFECTIVO",
                                                                "moneda" => $moneda,
                                                                "monto2" => $caja->IMPORTE * $caja->CAMBIO,
                                                                "monto" => $caja->IMPORTE,
                                                                "tipo_tar" => 0,
                                                                "tipo_tar2" => "",
                                                                "vaucher" => "",
                                                                "banco" => "",
                                                                "recibo" => "",
                                                                "bancoText" => "",
                                                                "tarjeta_text" => ""
                                                            ]
                                                        );
                                                    }
                                                    if ($cod == 2) {
                                                        $cuenta = CuentaBancariaData::getByCajaId($caja->ID);
                                                        $banco = BancoData::getBanco($cuenta->id_banco);
                                                        array_push(
                                                            $entregas,
                                                            [
                                                                // 'tipo' => 5,
                                                                // 'monto' => $total,
                                                                // 'moneda' => $moneda,
                                                                // 'cambio' => $cambio,
                                                                // 
                                                                'tipo_id' => "2",
                                                                'bancoText' => "",
                                                                'cambio' => $caja->CAMBIO,
                                                                "moneda_id" => $caja->ID_MONEDA,
                                                                "tipo" => "TRASFERENCIA BANCARIA",
                                                                "moneda" => $moneda,
                                                                "monto2" => $caja->IMPORTE * $caja->CAMBIO,
                                                                "monto" => $caja->IMPORTE,
                                                                "tipo_tar" => 0,
                                                                "tipo_tar2" => "",
                                                                "vaucher" => "",
                                                                "banco" => $banco->id_banco,
                                                                "recibo" => "",
                                                                "bancoText" => $banco->nombre_banco,
                                                                "tarjeta_text" => ""
                                                            ]
                                                        );
                                                    }
                                                    if ($cod == 3) {

                                                        $cuenta = ChequeData::getByCajaId($caja->ID);
                                                        if ($cuenta) {
                                                            $banco = BancoData::getBanco($cuenta->id_banco);
                                                            array_push(
                                                                $entregas,
                                                                [
                                                                    // 'tipo' => 2,
                                                                    // 'monto' => $total,
                                                                    // 'moneda' => $moneda,
                                                                    // 'cambio' => $cambio,
                                                                    // 'infoCheque' => [
                                                                    //     "numeroCheque" => $cuenta->nro_cheque,
                                                                    //     "banco" => $banco->nombre_banco
                                                                    // ],
                                                                    // 
                                                                    'tipo_id' => "3",
                                                                    'bancoText' => "",
                                                                    'cambio' => $caja->CAMBIO,
                                                                    "moneda_id" => $caja->ID_MONEDA,
                                                                    "tipo" => "CHEQUE",
                                                                    "moneda" => $moneda,
                                                                    "monto2" => $caja->IMPORTE * $caja->CAMBIO,
                                                                    "monto" => $caja->IMPORTE,
                                                                    "tipo_tar" => 0,
                                                                    "tipo_tar2" => "",
                                                                    "vaucher" => $cuenta->nro_cheque,
                                                                    "banco" => $banco->id_banco,
                                                                    "recibo" => "",
                                                                    "bancoText" => $banco->nombre_banco,
                                                                    "tarjeta_text" => ""
                                                                ]
                                                            );
                                                        }
                                                    }
                                                    if ($cod == 4) {
                                                        $cuenta = TarjetaDetalleData::getByCobro($caja->ID);
                                                        $tarjeta = "";
                                                        if ($cuenta->tipo == 1) {
                                                            $tarjeta = "Visa";
                                                        } else if ($cuenta->tipo == 2) {
                                                            $tarjeta = "Mastercard";
                                                        }
                                                        if ($cuenta->tipo == 3) {
                                                            $tarjeta = "American Express";
                                                        }
                                                        if ($cuenta->tipo == 4) {
                                                            $tarjeta = "Maestro";
                                                        }
                                                        if ($cuenta->tipo == 5) {
                                                            $tarjeta = "Panal";
                                                        }
                                                        if ($cuenta->tipo == 6) {
                                                            $tarjeta = "Cabal";
                                                        }
                                                        if ($cuenta->tipo == 99) {
                                                            $tarjeta = "Otro";
                                                        }
                                                        //                                                         Visa</option>
                                                        // Mastercard</opti
                                                        // American Express
                                                        // Maestro</option>
                                                        // Panal</option>
                                                        // Cabal</option>
                                                        // >Otro</option>
                                                        array_push(
                                                            $entregas,
                                                            [
                                                                // 'tipo' => $cuenta->procesadora_id == 1 ? 3 : 4,
                                                                // 'monto' => $total,
                                                                // 'moneda' => $moneda,
                                                                // 'cambio' => $cambio,
                                                                // 'infoTarjeta' => [
                                                                //     "tipo" => intval($cuenta->tipo),
                                                                //     "tipoDescripcion" => "",
                                                                //     "titular" =>  $cliente,
                                                                //     "ruc" => $rucCLiente,
                                                                //     "razonSocial" =>  $cliente,
                                                                //     "medioPago" => 1,
                                                                //     "codigoAutorizacion" => 123456789
                                                                // ],
                                                                // 
                                                                'tipo_id' => "4",
                                                                'bancoText' => "",
                                                                'cambio' => $caja->CAMBIO,
                                                                "moneda_id" => $caja->ID_MONEDA,
                                                                "tipo" => "TARJETA",
                                                                "moneda" => $moneda,
                                                                "monto2" => $caja->IMPORTE * $caja->CAMBIO,
                                                                "monto" => $caja->IMPORTE,
                                                                "tipo_tar" => $cuenta->procesadora_id == 1 ? 1 : 2,
                                                                "tipo_tar2" => "",
                                                                "vaucher" => "",
                                                                "banco" => "",
                                                                "recibo" => "",
                                                                "bancoText" => "",
                                                                "tarjeta_text" => $tarjeta,
                                                                "tarjeta" => $cuenta->tipo
                                                            ]
                                                        );
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="col-md-2"><button class="btn btn-info" onclick="agregarPago()">Agregar</button></div>

                                        <div class="row">
                                            <?php
                                            $isventa = false;

                                            ?>
                                            <table class="table table-bordered table-hover" id="datatable">
                                                <thead>
                                                    <th>Metodo de pago</th>

                                                    <th>Tipo</th>
                                                    <th>Vaucher</th>
                                                    <th>Importe</th>
                                                    <th>Importe Convertido</th>

                                                    <th>Moneda</th>
                                                    <th>Cambio Moneda</th>
                                                    <th>Banco</th>
                                                    <th>Recibo</th>
                                                    <th>Acción</th>
                                                </thead>
                                                <tbody id="tbody">

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">Total Guaranies</div>
                                            <div class="col-md-4" id="total"></div>
                                            <div class="col-md-2">Total a cobrar</div>
                                            <div class="col-md-2" id="cobror"></div>

                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-md-2"><button class="btn btn-success" onclick="pagar()">Guardar</button></div>
                            </div>
                        <?php
                        else : ?>
                            501 Internal Error
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



<script>
    var tabla = "";
    var totalCobrar = 0;
    var cambio = parseFloat($("#cambio2").val());
    var pagosAnteriores = JSON.parse('<?php echo json_encode($entregas) ?>');
    var pagos = [...pagosAnteriores];

    var totalACobrar = parseFloat(<?php echo $sell->total ?>)
    var moneda = '<?php echo $sell->VerTipoModena()->nombre; ?>';
    var totalCobro = $("#cobror").html();
    var total = parseFloat(<?php echo $sell->total ?>)
    if (moneda === 'DOLARES') {
        $("#cobror").html(parseFloat(<?php echo $sell->total ?>).toLocaleString("es-ES"));

    } else {
        $("#cobror").html(parseFloat(<?php echo $sell->total ?> * $("#cambio2").val()).toLocaleString("es-ES"));

    }
    $("#total").html(totalCobro);

    function actualizarTablacobro() {
        tabla = "";
        totalCobrar = 0;
        for (const [id, pago] of Object.entries(pagos)) {
            totalCobrar += pago.monto
            tabla += `<tr><td> ${pago.tipo}  ${pago.tarjeta_text}</td><td> ${pago.tipo_tar2}</td><td> ${pago.vaucher}</td><td> ${pago.monto}</td><td> ${pago.monto2}</td>
                        <td> ${pago.moneda}</td><td> ${pago.cambio}</td><td> ${pago.bancoText}</td><td> ${pago.recibo}</td><td> <button class="btn btn-danger" onclick="eliminarcobro(${id})">Eliminar</button></td></tr>`;
        }
        $("#tbody").html(tabla);


        if (totalCobrar > totalACobrar) {
            $("#pagar").show();
            $("#total").html(totalCobrar + " Vuelto: " + parseInt(totalCobrar - totalACobrar).toLocaleString("es-ES"));
            $("#monto").val(0);
        } else {

            $("#total").html(totalCobrar + " Restante: " + parseInt(totalACobrar - totalCobrar).toLocaleString("es-ES"));
            $("#pagar").hide();
        }
    }
    tipo()
    actualizarTablacobro()

    function eliminarcobro(id) {
        var resta = parseInt(pagos[id]['monto2']);
        totalCobrar = totalCobrar - resta;
        pagos.splice(id, 1);
        actualizarTablacobro()
    }

    function tipo() {

        // Agrega datos dinámicamente

        console.log('$("#tipopago_id").val() ', $("#tipopago_id").val())
        if ($("#tipopago_id").val() == 4) {
            $("#tipopago").show();
            $("#vaucher").show();
            $('#cheque').hide()
            $("#tarjeta").show();
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
        } else if ($("#tipopago_id").val() == 5 || $("#tipopago_id").val() == 4) {
            $("#tipopago").hide();
            $('#cheque').hide()
            $('#transferencia').hide()
            $("#vaucher").hide();
            $("#tarjeta").hide();
        } else if ($("#tipopago_id").val() == 1) {
            $('#cheque').hide()
            $("#tipopago").hide();
            $("#vaucher").hide();
            $('#transferencia').hide();
            $("#tarjeta").hide();
        } else if ($("#tipopago_id").val() == 2) {
            $('#cheque').hide()
            $("#tipopago").hide();
            $("#vaucher").hide();
            $('#transferencia').show()
            $("#tarjeta").hide();
        } else if ($("#tipopago_id").val() == 3) {
            $('#transferencia').hide()
            $("#tipopago").hide();
            $("#vaucher").hide();
            $("#tarjeta").hide();
            $('#cheque').show()

        } else {
            tipopago = ""
            $('#cheque').hide()
            $("#tipopago").hide();
            $("#vaucher").hide();

        }
    }

    function agregarPago() {
        tabla = "";
        let validaTotalCobro = 0
        if ($('select[name="tipomoneda_id2"] option:selected').text().includes('$')) {
            validaTotalCobro = totalCobrar + parseFloat($('#monto').val()) * cambio;
            if (moneda === 'DOLARES') {
                validaTotalCobro = totalCobrar + parseFloat($('#monto').val());
            } else {
                validaTotalCobro = totalCobrar + parseFloat($('#monto').val()) / cambio;
            }
        } else {
            validaTotalCobro = parseFloat($('#monto').val());
            if (moneda === 'DOLARES') {
                validaTotalCobro = totalCobrar + parseFloat($('#monto').val()) * cambio;
            } else {
                validaTotalCobro = totalCobrar + parseFloat($('#monto').val());
            }
        }
        if (moneda === 'DOLARES') {
            totalVenta = total;

        } else {
            totalVenta = total * $("#cambio2").val();
        }
        console.log(validaTotalCobro, totalVenta)

        if (validaTotalCobro > totalVenta) {
            Swal.fire({
                title: "Monto superior a la venta",
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            return
        }
        if ($("#tipopago_id").val() == 4) {
            if ($('select[name="tipomoneda_id2"] option:selected').text().includes('$')) {
                if (moneda === 'DOLARES') {
                    totalCobrar += parseFloat($('#monto').val());
                } else {
                    totalCobrar += parseFloat($('#monto').val()) / cambio;
                }
                pagos.push({
                    "tipo_id": $('#tipopago_id').val(),
                    "cambio": cambio,
                    "moneda_id": $('#tipomoneda_id2').val(),
                    "tipo": $('select[name="tipopago_id"] option:selected').text(),
                    "moneda": $('select[name="tipomoneda_id2"] option:selected').text(),
                    "monto2": parseFloat($('#monto').val()) * cambio,
                    "monto": parseFloat($('#monto').val()),
                    "cambio": cambio,
                    "tipo_tar": $('#tipopago').val(),
                    "tipo_tar2": $('select[name="tipopago"] option:selected').text(),
                    "vaucher": $("#vaucher").val(),
                    "banco": "",
                    "recibo": "",
                    "bancoText": "",
                    "tarjeta": $('#tarjeta_id').val(),
                    "tarjeta_text": $('select[id="tarjeta_id"] option:selected').text()
                });
            } else {
                if (moneda === 'DOLARES') {
                    totalCobrar += parseFloat($('#monto').val()) * cambio;
                } else {
                    totalCobrar += parseFloat($('#monto').val());
                }

                pagos.push({
                    "tipo_id": $('#tipopago_id').val(),
                    "cambio": '1',
                    "moneda_id": $('#tipomoneda_id2').val(),
                    "tipo": $('select[name="tipopago_id"] option:selected').text(),
                    "moneda": $('select[name="tipomoneda_id2"] option:selected').text(),
                    "monto": $('#monto').val(),
                    "monto2": $('#monto').val(),
                    "cambio": '1',
                    "tipo_tar": $('#tipopago').val(),
                    "tipo_tar2": $('select[name="tipopago"] option:selected').text(),
                    "vaucher": $("#vaucher").val(),
                    "banco": "",
                    "recibo": "",
                    "bancoText": "",
                    "tarjeta": $('#tarjeta_id').val(),
                    "tarjeta_text": $('select[id="tarjeta_id"] option:selected').text()
                });
            }
        } else {
            let getBanco = "";
            let getRecibo = "";
            let getBancoText = "";
            if ($("#tipopago_id").val() == 2) {
                getBanco = $("#banco_trans").val();
                getRecibo = $("#recibo").val();

                getBancoText = $('select[name="banco_trans"] option:selected').text()
            } else if ($("#tipopago_id").val() == 3) {
                getBanco = $("#banco_cheque").val();
                getRecibo = $("#nroCheque").val();
                getBancoText = $('select[name="banco_cheque"] option:selected').text()
            }

            if ($('select[name="tipomoneda_id2"] option:selected').text().includes('$')) {
                if (moneda === 'DOLARES') {
                    totalCobrar += parseFloat($('#monto').val());
                } else {
                    totalCobrar += parseFloat($('#monto').val()) / cambio;
                }
                pagos.push({
                    "tipo_id": $('#tipopago_id').val(),
                    "cambio": cambio,
                    "moneda_id": $('#tipomoneda_id2').val(),
                    "tipo": $('select[name="tipopago_id"] option:selected').text(),
                    "moneda": $('select[name="tipomoneda_id2"] option:selected').text(),
                    "monto2": parseFloat($('#monto').val()) * cambio,
                    "monto": parseFloat($('#monto').val()),
                    "cambio": cambio,
                    "tipo_tar": 0,
                    "tipo_tar2": "",
                    "vaucher": "",
                    "banco": getBanco,
                    "recibo": getRecibo,
                    "bancoText": getBancoText,
                    "tarjeta_text": ''
                });
            } else {
                if (moneda === 'DOLARES') {
                    totalCobrar += parseFloat($('#monto').val()) * cambio;
                } else {
                    totalCobrar += parseFloat($('#monto').val());
                }
                pagos.push({
                    "tipo_id": $('#tipopago_id').val(),
                    "cambio": '1',
                    "moneda_id": $('#tipomoneda_id2').val(),
                    "tipo": $('select[name="tipopago_id"] option:selected').text(),
                    "moneda": $('select[name="tipomoneda_id2"] option:selected').text(),
                    "monto": $('#monto').val(),
                    "monto2": $('#monto').val(),
                    "cambio": '1',
                    "tipo_tar": 0,
                    "tipo_tar2": "",
                    "vaucher": "",
                    "banco": getBanco,
                    "recibo": getRecibo,
                    "bancoText": getBancoText,
                    "tarjeta_text": ''
                });
            }
        }


        actualizarTablacobro()
        $('#monto').val("0");
    }

    function pagar() {
        console.log('sssssss', venta)
        $.ajax({
            url: 'index.php?action=actualizarcobrocaja',
            type: 'POST',
            data: {
                pagos: pagos,
                total: totalCobrar,
                sucursal: '<?= $_GET['id_sucursal'] ?>',
                cliente: <?php echo $ventas->getCliente()->id_cliente ?>,
                venta: <?php echo $_GET["id_venta"] ?>,
                fecha: '<?php echo $sell->fecha; ?>',
                factura: '<?php echo $sell->factura; ?>',
                cobro: <?php echo $cobroId; ?>

            },
            success: function(json) {
                alert('pago editado')
                window.location.reload()
            },
            error: function(xhr, status) {
                alert('pago editado')
                window.location.reload()
            }
        });


    }
</script>