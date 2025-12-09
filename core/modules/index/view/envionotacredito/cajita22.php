<?php
if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
    $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
    $sucursalDatos =  SuccursalData::VerId($_GET['id_sucursal']);
?>
    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
                NOTAS DE CREDITOS REALIZADAS
            </h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <br>
                        <button onclick="enviar()" class="btn btn-primary">Enviar a SIFEN por lotes</button>
                        <br>
                        <div class="box-body">
                            <?php
                            $products = VentaData::versucursaltipoventastotN($sucursales->id_sucursal);
                            require 'core/modules/index/components/consultalote.php';
                            require 'core/modules/index/components/kudes.php';
                            if (count($products) > 0) {

                            ?>
                                <br>
                                <table id="example1" class="table table-bordered table-hover  ">

                                    <thead>

                                        <th></th>
                                        <th>Nro.</th>
                                        <th>N° Factura</th>
                                        <th width="120px">Cliente</th>

                                        <th>Total</th>
                                        <th width="120px">Metodo Pago</th>
                                        <th>Fecha de Venta</th>
                                        <th>Cambio</th>
                                        <td>Tipo Moneda</td>
                                        <td>Envio a SIFEN</td>
                                        <td>Xml</td>
                                        <td>Kude</td>
                                        <th>Cancelar</th>
                                    </thead>
                                    <?php
                                    $int = 0;
                                    foreach ($products as $sell) : ?>
                                        <tr>
                                            <?php
                                            $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                                            count($operations);
                                            $int++;
                                            ?>




                                            <td style="width:30px;">
                                                <a href="index.php?view=detalleventaproducto&id_venta=<?php echo $sell->id_venta; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open" style="color: orange;"></i></a>
                                            </td>


                                            <td style="width:30px;">
                                                <?php echo $sell->id_venta; ?>
                                            </td>

                                            <td class="width:30px;">
                                                <?php if ($sell->tipo_venta == 15) : ?>

                                                    <?php echo $sell->factura; ?>
                                                <?php else : ?>
                                                    <?php echo count($operations) ?>
                                                <?php endif ?>
                                            </td>


                                            <td class="width:30px;">


                                                <?php if ($sell->getCliente()->tipo_doc == "SIN NOMBRE") {
                                                    $sell->getCliente()->tipo_doc;
                                                    $cliente = $sell->getCliente()->tipo_doc;
                                                    echo $cliente;
                                                } else {
                                                    $sell->getCliente()->nombre . " " . $sell->getCliente()->apellido;
                                                    $cliente = $sell->getCliente()->nombre . " " . $sell->getCliente()->apellido;

                                                    echo $cliente;
                                                }                                                ?>


                                            </td>



                                            <td>
                                                <?php
                                                $total = $sell->total - $sell->descuento;
                                                echo "<b> " . number_format($total, 2, ',', '.') . "</b>";
                                                ?>
                                            </td>
                                            <td><?php echo $sell->metodopago ?></td>


                                            <td><?php echo $sell->fecha; ?></td>

                                            <!-- <td><?php echo $sell->formapago ?></td> -->

                                            <td class="">
                                                <?php if ($sell->VerTipoModena()->simbolo == "US$") {
                                                    echo  $sell->cambio2;
                                                } else {
                                                    echo  1;
                                                } ?>

                                            </td>



                                            <td><?php echo $sell->VerTipoModena()->nombre; ?></td>
                                            <td>
                                                <?php

                                                // if ($sell->enviado == "Rechazado") {
                                                //     echo '<p class="bg-danger text-white text-center">Rechazado</p>';
                                                // } else 
                                                if ($sell->enviado == "Aprobado") {
                                                    echo
                                                    '<p class="bg-success text-white text-center">Aprobado</p>';
                                                } else if ($sell->enviado == "Cancelado") {
                                                    echo '<p class="bg-danger text-white text-center">Cancelado</p>';
                                                } else {
                                                    if ($sell->enviado == "Rechazado") {
                                                        echo '<p class="bg-danger text-white text-center">Rechazado</p>';
                                                    }

                                                    $venta = VentaData::getById($sell->id_venta);
                                                    $telefonoEmisor =  $venta->verSocursal()->telefono;
                                                    $rucEmisor = $venta->verSocursal()->ruc;
                                                    $fecha = $venta->fecha;
                                                    $direccionCliente = $venta->getCliente()->direccion;
                                                    $telefono = $venta->getCliente()->telefono;
                                                    if ($venta->getCliente()->tipo_doc == "SIN NOMBRE") {
                                                        $venta->getCliente()->tipo_doc;
                                                        $cliente = $venta->getCliente()->tipo_doc;
                                                    } else {
                                                        $venta->getCliente()->nombre . " " . $venta->getCliente()->apellido;
                                                        $cliente = $venta->getCliente()->nombre . " " . $venta->getCliente()->apellido;
                                                    }
                                                    if ($venta->VerTipoModena()->simbolo == "₲") {
                                                        $moneda = 'PYG';
                                                    } else {
                                                        $moneda = 'USD';
                                                    }
                                                    $productosItem  = array();
                                                    foreach ($operations as $operation) {
                                                        $product  = $operation->getProducto();
                                                        $precio =  floatval($operation->precio);

                                                        if ($product->impuesto === 10) {
                                                            $precioUnitario = $precio;
                                                            $ivaTipo = 1;
                                                            $ivaBase = "100";
                                                            $iva = "10";
                                                        } else if ($product->impuesto == 30) {
                                                            $precioUnitario = number_format(($precio - ((100 * $precio * 70) / (10000 + (5 * 30)))), 6, '.', '');
                                                            $ivaTipo = 1;
                                                            $ivaBase = "100";
                                                            $iva = "5";
                                                            $arrayIva5 = json_encode([
                                                                "precioUnitario" => number_format((((100 * $precio * 70) / (10000 + (5 * 30)))), 6, '.', ''),
                                                                "codigo" => $product->codigo,
                                                                "descripcion" => $product->nombre,
                                                                "observacion" => "",
                                                                "unidadMedida" => intval(UnidadesData::getById($product->presentacion)->codigo),
                                                                "cantidad" => $cant,
                                                                "cambio" => "0",
                                                                "ivaTipo" => 3,
                                                                "ivaBase" => "0",
                                                                "iva" => "0",
                                                                "lote" => "",
                                                                "vencimiento" => "",
                                                                "numeroSerie" => "",
                                                                "numeroPedido" => ""
                                                            ]);
                                                            array_push($productosItem, $arrayIva5);
                                                        } else if ($product->impuesto == 5) {
                                                            $precioUnitario = $precio;
                                                            $ivaTipo = 1;
                                                            $ivaBase = "100";
                                                            $iva = "5";
                                                        } else if ($product->impuesto == 0) {
                                                            $precioUnitario = $precio;
                                                            $ivaTipo = 3;
                                                            $ivaBase = "0";
                                                            $iva = "0";
                                                        } else {
                                                            $precioUnitario = $precio;
                                                            $ivaTipo = 1;
                                                            $ivaBase = "100";
                                                            $iva = "10";
                                                        }
                                                        $array = [
                                                            "precioUnitario" => $precioUnitario,
                                                            "codigo" => $product->codigo,
                                                            "descripcion" => $product->nombre,
                                                            "observacion" => "",
                                                            "unidadMedida" => intval(UnidadesData::getById($product->presentacion)->codigo),
                                                            "cantidad" => $operation->q,
                                                            "cambio" => "0",
                                                            "ivaTipo" => $ivaTipo,
                                                            "ivaBase" => $ivaBase,
                                                            "iva" => $iva,
                                                            "lote" => "",
                                                            "vencimiento" => "",
                                                            "numeroSerie" => "",
                                                            "numeroPedido" => ""
                                                        ];
                                                        array_push($productosItem, $array);
                                                    }
                                                    $pro = $productosItem;
                                                    $factura = substr($sell->factura, 8);
                                                    $fechaventa = date("Y-m-d-h-i", strtotime($venta->fecha));
                                                    $tipo = $sell->metodopago;
                                                    if ($sell->VerTipoModena()->simbolo == "US$") {
                                                        $cambio = $venta->cambio2;
                                                    } else {
                                                        $cambio = 1;
                                                    }
                                                    $client = $sell->getCliente();
                                                    $dptClient = $client->departamento_id;
                                                    $ciudadCliente = $client->ciudad;
                                                    $distClient = $client->distrito_id;
                                                    $cuotas = 0;
                                                    $cdc = $venta->cdc_fact;
                                                    $timbrado = $venta->timbrado_factura;
                                                    $vencimiento = "";
                                                    if ($sell->metodopago == "Credito") {
                                                        $credito = CreditoData::getByVentaId($sell->id_venta);
                                                        if ($credito != NULL) {
                                                            $cuotas = $credito->cuotas;
                                                            $vencimiento = $credito->vencimiento;
                                                        }
                                                    }
                                                    $tipoCliente = 1;
                                                    $tipoOperacion = 2;
                                                    $esContribuyente = 1;
                                                    if ($sell->tipo_remision == 3) {
                                                        $tipoOperacion = 4;
                                                        $esContribuyente = 0;
                                                    }
                                                    if ($client->tipo_doc == "RUC") {
                                                        $tipoCliente = 1;
                                                    } else if ($client->tipo_doc == "PASAPORTE") {
                                                        $tipoOperacion = 4;
                                                        $esContribuyente = 0;

                                                        $tipoCliente = 2;
                                                    } else if ($client->tipo_doc == "CEDULA DE EXTRANJERO") {
                                                        $tipoOperacion = 4;

                                                        $esContribuyente = 0;
                                                        $tipoCliente = 3;
                                                    } else if ($client->tipo_doc == "CLIENTE DEL EXTERIOR") {
                                                        $tipoOperacion = 4;

                                                        $esContribuyente = 0;
                                                        $tipoCliente = 3;
                                                    } else if ($client->tipo_doc == "SIN NOMBRE") {
                                                        $tipoCliente = 5;
                                                        $esContribuyente = 0;
                                                    } else if ($client->tipo_doc == "DIPLOMATICO") {
                                                        $tipoCliente = 4;
                                                    }
                                                    $pais = PaisData::get($client->pais_id);
                                                    $paisCod =  $pais->codigo;
                                                    $paisDes =  $pais->descripcion;
                                                    $rucCLiente = $client->dni;

                                                    $cod = 1;

                                                    if ($sell->id_venta) {
                                                        $caja = CajaDetalle::obtenerVenta($sell->id_venta);
                                                        if (isset($caja->CAJA)) {
                                                            $c = CajaTipo::vercaja($caja->CAJA);
                                                            $cod = $c->codigo;
                                                        }
                                                    }
                                                    if ($sell->id_venta && $tipo == "Contado") {
                                                        $caja = CajaDetalle::obtenerVenta($sell->id_venta);
                                                        if ($caja->CAJA) {
                                                            $cod = $caja->CAJA;
                                                            if ($cod == 1) {
                                                                $entregas = [
                                                                    [
                                                                        'tipo' => 1,
                                                                        'monto' => $total,
                                                                        'moneda' => $moneda,
                                                                        'cambio' => $cambio,
                                                                    ]
                                                                ];
                                                            }
                                                            if ($cod == 2) {
                                                                $cuenta = CuentaBancariaData::getByCajaId($caja->ID);
                                                                $entregas = [
                                                                    [
                                                                        'tipo' => 5,
                                                                        'monto' => $total,
                                                                        'moneda' => $moneda,
                                                                        'cambio' => $cambio,
                                                                    ]
                                                                ];
                                                            }
                                                            if ($cod == 3) {

                                                                $cuenta = ChequeData::getByCajaId($caja->ID);
                                                                if ($cuenta) {
                                                                    $banco = BancoData::getBanco($cuenta->id_banco);
                                                                    $entregas = [
                                                                        [
                                                                            'tipo' => 2,
                                                                            'monto' => $total,
                                                                            'moneda' => $moneda,
                                                                            'cambio' => $cambio,
                                                                            'infoCheque' => [
                                                                                "numeroCheque" => $cuenta->nro_cheque,
                                                                                "banco" => $banco->nombre_banco
                                                                            ],
                                                                        ]
                                                                    ];
                                                                }
                                                            }
                                                            if ($cod == 4) {
                                                                $cuenta = TarjetaDetalleData::getByCobro($caja->ID);
                                                                $entregas = [
                                                                    [
                                                                        'tipo' => $cuenta->procesadora_id == 1 ? 3 : 4,
                                                                        'monto' => $total,
                                                                        'moneda' => $moneda,
                                                                        'cambio' => $cambio,
                                                                        'infoTarjeta' => [
                                                                            "tipo" => intval($cuenta->tipo),
                                                                            "tipoDescripcion" => "",
                                                                            "titular" =>  $cliente,
                                                                            "ruc" => $rucCLiente,
                                                                            "razonSocial" =>  $cliente,
                                                                            "medioPago" => 1,
                                                                            "codigoAutorizacion" => 123456789
                                                                        ],
                                                                    ]
                                                                ];
                                                            }
                                                        }
                                                    }

                                                    // metodo pago
                                                    $condicionPagos = [
                                                        'tipo' => $tipo == "Contado" ? 1 : 2,
                                                    ];

                                                    if ($tipo == "Contado") {

                                                        $condicionPagos['entregas'] = $entregas;
                                                    } else {
                                                        $infoCuotas = [
                                                            [
                                                                'moneda' => $moneda,
                                                                'monto' => $total,
                                                                'vencimiento' => $vencimiento,
                                                            ],
                                                        ];

                                                        $credito = [
                                                            'tipo' => 2,
                                                            'plazo' => "30 días",
                                                            'cuotas' => $cuotas,
                                                            'montoEntrega' => $total,
                                                            'infoCuotas' => $infoCuotas,

                                                        ];

                                                        $condicionPagos['credito'] = $credito;
                                                    }
                                                    $data = [
                                                        "items" => $productosItem,
                                                        "tipoP" => $cod,
                                                        "condicionPagos" => $condicionPagos,
                                                        "telefonoCliente" => $client->telefono,
                                                        "emailCliente" => $client->email,
                                                        "id" => $int,
                                                        "descripcion" => "venta",
                                                        "cliente" => $cliente,
                                                        "telEmisor" => $telefonoEmisor,
                                                        "rucEmisor" => $rucEmisor,
                                                        "rucCliente" => $rucCLiente,
                                                        "dirCliente" =>  $direccionCliente,
                                                        "telCliente" => $telefono,
                                                        "factura" =>  $factura,
                                                        "total" =>   $total,
                                                        "moneda" =>  $moneda,
                                                        "fechaVenta" =>   $fechaventa,
                                                        "tipo" => $tipo,
                                                        "cambio" => $cambio,
                                                        "departamentoCliente" => $dptClient,
                                                        "distritoCliente" => $distClient,
                                                        "ciudadCliente" =>       $ciudadCliente,
                                                        "cuotas" =>    $cuotas,
                                                        "establecimiento" => substr($sell->factura, 0, -12),
                                                        "punto" =>   substr($sell->factura, 4, -8),
                                                        "vencimiento" =>  $vencimiento,
                                                        "notaCreditoDebito" => [
                                                            "motivo" => 1
                                                        ],
                                                        "documentoAsociado" => [
                                                            "cdc" => $cdc,
                                                            "formato" => 1,
                                                            "tipo" => 1,
                                                            "timbrado" => $timbrado,
                                                            "establecimiento" => substr($sell->factura, 0, -12),
                                                            "punto" => substr($sell->factura, 4, -8),
                                                            "numero" => 1,
                                                            "fecha" => $sell->fecha,
                                                            "numeroRetencion" => "",
                                                            "resolucionCreditoFiscal" => "",
                                                            "constanciaTipo" => 1,
                                                            "constanciaNumero" => 1,
                                                            "constanciaControl" => "1"

                                                        ],
                                                        "esContribuyente" => $esContribuyente,
                                                        "docCliente" => $tipoCliente
                                                    ];
                                                ?>
                                                    <input type="checkbox" id="<?php echo $sell->id_venta; ?>" onchange='agregarLote(<?php echo json_encode($data) ?>,<?php echo $sell->id_venta; ?>)'>

                                            </td>


                                            <td>

                                                <?php if ($sell->enviado == "Rechazado") { ?>
                                                    <a class="btn btn-primary" href="http://18.208.224.72:3000/download/<?php echo $sell->xml; ?>">Descargar XML</a>
                                                <?php } else if ($sell->enviado == "Aprobado") {
                                                ?>
                                                    <a class="btn btn-primary" href="http://18.208.224.72:3000/download/<?php echo $sell->xml; ?>">Descargar XML</a>
                                                <?php
                                                    } else {

                                                        echo "";
                                                    } ?>

                                            </td>



                                            <td>

                                                <?php if ($sell->enviado == "Rechazado" || $sell->enviado == "Aprobado") {
                                                        $venta = VentaData::getById($sell->id_venta);
                                                        $telefonoEmisor =  $venta->verSocursal()->telefono;
                                                        $rucEmisor = $venta->verSocursal()->ruc;
                                                        $direccionCliente = $venta->getCliente()->direccion;
                                                        $telefono = $venta->getCliente()->telefono;
                                                        if ($venta->getCliente()->tipo_doc == "SIN NOMBRE") {
                                                            $venta->getCliente()->tipo_doc;
                                                            $cliente = $venta->getCliente()->tipo_doc;
                                                        } else {
                                                            $venta->getCliente()->nombre . " " . $venta->getCliente()->apellido;
                                                            $cliente = $venta->getCliente()->nombre . " " . $venta->getCliente()->apellido;
                                                        }
                                                        if ($venta->VerTipoModena()->simbolo == "₲") {
                                                            $moneda = 'PYG';
                                                        } else {
                                                            $moneda = 'USD';
                                                        }
                                                        $productosItem  = array();
                                                        foreach ($operations as $operation) {
                                                            $product  = $operation->getProducto();

                                                            $tipo = TipoProductoData::VerId($operation->getProducto()->ID_TIPO_PROD);
                                                            $precio =  floatval($operation->precio);
                                                            $cant = $operation->q;

                                                            $array = [
                                                                "precioUnitario" => $precio,
                                                                "codigo" => $product->codigo,
                                                                "descripcion" => $product->nombre,
                                                                "observacion" => "",
                                                                "tipo" => $tipo->TIPO_PRODUCTO,
                                                                "unidadMedida" => UnidadesData::getById($product->presentacion)->nombre,
                                                                "cantidad" => $cant,
                                                                "cambio" => "0",
                                                                "ivaTipo" => 1,
                                                                "ivaBase" => "100",
                                                                "iva" => $product->impuesto,
                                                                "lote" => "",
                                                                "vencimiento" => "",
                                                                "numeroSerie" => "",
                                                                "numeroPedido" => ""
                                                            ];
                                                            $array2 = json_encode($array);
                                                            array_push($productosItem, $array2);
                                                        }
                                                        $pro = $productosItem;
                                                        $factura = substr($sell->factura, 8);
                                                        $fechaventa = date("Y-m-d-h-i", strtotime($venta->fecha));
                                                        $tipo = $sell->metodopago;
                                                        if ($sell->VerTipoModena()->simbolo == "US$") {
                                                            $cambio = $venta->cambio2;
                                                        } else {
                                                            $cambio = 1;
                                                        }
                                                        $client = $sell->getCliente();
                                                        $dptClient = $client->departamento_id;
                                                        $ciudadCliente = $client->ciudad;
                                                        $distClient = $client->distrito_id;
                                                        $cuotas = 0;
                                                        $vencimiento = "";
                                                        if ($sell->metodopago == "Credito") {
                                                            $credito = CreditoData::getByVentaId($sell->id_venta);
                                                            // $cuotas = $credito->cuotas;
                                                            // $vencimiento = $credito->vencimiento;
                                                        }

                                                        $rucCLiente = $client->dni;
                                                        $remi = VentaData::getId($sell->REMISION_ID);
                                                ?>
                                                    <?php if ($venta->email_enviado) {
                                                            echo 'Enviado';
                                                    ?>
                                                        <button class="btn btn-success" onclick='genKude(<?php echo json_encode($productosItem) ?>,
                                                                    {
                                                                        cdc:"<?php echo $venta->cdc ?>",
                                                                        factura:"<?php echo $venta->factura ?>",
                                                                        fechaEmision:"<?php echo $venta->fecha_envio ?>",
                                                                        condicion:"<?php echo $venta->metodopago ?>",
                                                                        rucCliente:"<?php echo $rucCLiente  ?>",
                                                                        cambio:<?php echo $cambio;  ?>,
                                                                        razonCliente:"<?php echo $cliente ?>",
                                                                        moneda:"<?php echo $moneda; ?>",
                                                                        dirCliente:"<?php echo $direccionCliente; ?>",
                                                                        telCliente:"<?php echo $telefono; ?>",
                                                                        iva10:<?php echo $venta->iva10; ?>,
                                                                        iva5:<?php echo $venta->iva5; ?>,
                                                                        email:"<?php echo $client->email; ?>",
                                                                        vipoVenta: 1,
                                                                        cdcAsociado:"<?php echo $venta->cdc_fact; ?>",
                                                                        venta:"<?php echo $remi->factura; ?>",
                                                                        tipoFactura: "Nota de crédito",
                                                                        operacion: "Nota de crédito",
                                                                        kudeQr:"<?php echo $venta->kude; ?>",
                                                                        docAsociado: "Venta de mercaderia",
                                                                        cel: "",
                                                                    })'>Descargar</button>
                                                <?php }
                                                    } else {

                                                        echo "No enviado";
                                                    } ?>

                                            </td>
                                            <td>

                                                <?php if ($sell->enviado == "Rechazado") { ?>

                                                    <!-- <a class="btn btn-primary" href="http://18.208.224.72:3000/downloadkude/<?php echo $sell->kude; ?>">Descargar Kude</a> -->
                                                    <!-- <a class="btn btn-primary" href="http://localhost:3000/downloadkude/<?php echo $sell->kude; ?>">Descargar Kude</a> -->
                                                <?php } else if ($sell->enviado == "Aprobado") {
                                                ?>
                                                    <button class="btn btn-warning" onclick="cancelar('<?php echo $sell->cdc ?>','<?php echo $sell->id_venta ?>')">Cancelar</button>

                                                <?php
                                                    } else {

                                                        echo "No enviado";
                                                    } ?>

                                            </td>

                                        </tr>

                                <?php }
                                            endforeach; ?>

                                </table>

                                <div class="clearfix"></div>

                            <?php
                            } else {
                            ?>
                                <div class="jumbotron">
                                    <h2>No hay NOTAS DE CREDITO</h2>
                                    <p>No se ha realizado ninguna NOTA DE CREDITO.</p>
                                </div>
                            <?php
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php endif ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var datos = [];
    var ventas = [];
    var lotesenviados = []
    var xmlsenviados = []
    var kudes = [];
    var fecha = "";

    function agregarLote(json, venta) {
        if (datos.some(item => item.id === json.id)) {

            let newVentas = ventas.filter((item) => item !== venta);
            ventas = newVentas;
            console.log(ventas);

            datos.splice(datos.findIndex(findByKey("id", json.id)), 1);

        } else if (datos.length == 10) {
            $("#" + venta).prop('checked', false);

            Swal.fire({
                title: "El limite de lotes es 10",
                icon: 'danger',
                confirmButtonText: 'Aceptar'
            });
        } else {
            ventas.push(venta);
            datos.push(json);
            console.log('j', json)
        }

    }

    function agregar(json, venta, items) {
        if (datos.some(item => item.id === json.id)) {

            let newVentas = ventas.filter((item) => item !== venta);
            ventas = newVentas;
            console.log(ventas);

            datos.splice(datos.findIndex(findByKey("id", json.id)), 1);

        } else if (datos.length == 10) {
            $("#" + venta).prop('checked', false);

            Swal.fire({
                title: "El limite de lotes es 10",
                icon: 'danger',
                confirmButtonText: 'Aceptar'
            });
        } else {
            console.log(items);
            let ite = []
            json['items'] = [];
            for (let i = 0; i < items.length; i++) {
                json['items'].push(JSON.parse(items[i]));
            }
            // console.log(JSON.parse(items))
            // json['items'] = JSON.parse(items);

            ventas.push(venta);
            datos.push(json);
            console.log('j', json)
        }

    }

    function findByKey(key, value) {
        return (item, i) => item[key] === value
    }

    function enviar() {
        datos2 = JSON.stringify(datos);
        Swal.fire({
            title: 'Enviando por lotes',
            icon: 'info',
        })
        tipo = 0;
        let logo = 'logo.png';
        if (<?php echo $sucursalDatos->id_sucursal == 19 ? 'true' :  'false'; ?>) {
            logo = 'logo3.png';
            tipo = 3;
        }
        if (<?php echo $sucursalDatos->id_sucursal == 18 ? 'true' :  'false'; ?>) {
            tipo = 1
        }
        let data1 = {
            version: 150,
            fechaFirmaDigital: '<?php echo $sucursalDatos->fecha_firma ?>T00:00:00',
            ruc: "<?php echo $sucursalDatos->ruc ?>",
            razonSocial: "<?php echo $sucursalDatos->razon_social ?>",
            nombreFantasia: "<?php echo $sucursalDatos->nombre_fantasia ?>",
            actividadesEconomicas: [{
                codigo: "<?php echo $sucursalDatos->codigo_act ?>",
                descripcion: "<?php echo $sucursalDatos->actividad ?>",
            }, ],
            timbradoNumero: "<?php echo $sucursalDatos->timbrado ?>",
            timbradoFecha: "<?php echo $sucursalDatos->fecha_tim ?>T00:00:00",
            tipoContribuyente: 2,
            tipoRegimen: 8,
            establecimientos: [{
                codigo: "00<?php echo $sucursalDatos->establecimiento ?>",
                direccion: "<?php echo $sucursalDatos->direccion ?>",
                numeroCasa: "<?php echo $sucursalDatos->numero_casa ?>",
                complementoDireccion1: "<?php echo $sucursalDatos->com_dir ?>",
                complementoDireccion2: "<?php echo $sucursalDatos->com_dir2 ?>",
                departamento: <?php echo $sucursalDatos->cod_depart ?>,
                departamentoDescripcion: "<?php echo $sucursalDatos->departamento_descripcion ?>",
                distrito: <?php echo $sucursalDatos->distrito_id ?>,
                distritoDescripcion: "<?php echo $sucursalDatos->distrito_descripcion ?>",
                ciudad: <?php echo $sucursalDatos->id_ciudad ?>,
                ciudadDescripcion: "<?php echo $sucursalDatos->ciudad_descripcion ?>",
                telefono: "<?php echo $sucursalDatos->telefono ?>",
                email: "<?php echo $sucursalDatos->email ?>",
                denominacion: "<?php echo $sucursalDatos->denominacion ?>",
            }, ],
        }
        let cert = '<?php echo $sucursalDatos->certificado_url ?>';
        console.log(cert);

        datosCert = JSON.stringify(data1)
        $.ajax({
            // url: "http://18.208.224.72:3000/enviarlote",
            url: "http://localhost:3000/enviarlote",
            type: "POST",
            data: {
                datos: datos2,
                env: '<?php echo $sucursalDatos->entorno ?>',
                cert: cert,
                logo: "./METASA_logo.png",
                pass: '<?php echo $sucursalDatos->clave ?>',
                data1: datosCert,
                tipo: 5,
                descripcion: 'nota de credito',
                ventaremision: false,
                qr: '<?php echo $sucursalDatos->qr_envio ?>',
                id: '<?php echo $sucursalDatos->id_envio ?>'
            },

            success: function(dataResult) {
                try {

                    // let data = JSON.parse(
                    let datos = dataResult['result'];
                    xmlsenviados = dataResult['xml'];
                    kude = dataResult['kude'];
                    fecha = dataResult['fecha'];
                    let data = JSON.parse(datos);
                    console.log(data)
                    // console.log('lote', data['result']['ns2:rResEnviLoteDe']['ns2:dProtConsLote'])
                    let lote = data['ns2:rResEnviLoteDe']['ns2:dProtConsLote'];
                    console.log('tlote', lote);
                    Swal.fire({
                        title: `Lote: ${lote} enviado, espere un momento estamos obteniendo resultados`,
                        icon: 'info',
                    })
                    setTimeout(function() {
                        consultaLote(lote);
                    }, 20000);

                } catch (e) {
                    // Swal.fire({
                    //     title: "Error",
                    //     icon: 'error',
                    //     confirmButtonText: 'Aceptar'
                    // });
                    Swal.fire({
                        title: 'Error en el formato del XML',
                        text: dataResult,
                        icon: 'error',
                        confirmButtonColor: '#ff0000',
                        confirmButtonText: 'Recargar pagina'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    })
                }

            },

        });
    }
</script>