<?php
$response = [];
$ventas = VentaData::buscarVentas($_GET['sucursal'], $_GET['offset'], $_GET['busqueda'], $_GET['desde'], $_GET['hasta'], $_GET['cliente']);
$paginas = VentaData::buscarVentasPaginacion($_GET['sucursal'], $_GET['offset'], $_GET['busqueda'], $_GET['desde'], $_GET['hasta'], $_GET['cliente']);
$tipoInsumo = ProductoData::verinsumo($_GET['sucursal']);
$insumoId = $tipoInsumo->ID_TIPO_PROD;
$int = 0;
$sucursal = SuccursalData::VerId($_GET['sucursal']);
foreach ($ventas as $venta) {
    $int++;
    $cliente =  $venta->getCliente()->tipo_doc == "SIN NOMBRE" ?
        $venta->getCliente()->tipo_doc : $venta->getCliente()->nombre . " " .
        $venta->getCliente()->apellido;


    $moneda = $venta->VerTipoModena()->simbolo == "₲" ? 'PYG' :  'USD';

    $operations = OperationData::getAllProductsBySellIddd($venta->id_venta);
    $productos = array();
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
            array_push($productos, $arrayIva5);
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
        array_push($productos, $array);
    }

    $vencimiento = "";
    $cuotas = null;
    if ($venta->metodopago == "Credito") {
        $credito = CreditoData::getByVentaId($venta->id_venta);
        $cuotas = $credito->cuotas;
        $vencimiento = $credito->vencimiento;
    }
    $tipoop = 1;
    $tipoCliente = 1;
    $esContribuyente = 1;
    if ($venta->getCliente()->tipo_doc == "RUC") {
        $tipoCliente = 1;
    } else if ($venta->getCliente()->tipo_doc == "PASAPORTE") {
        $tipoCliente = 2;
    } else if ($venta->getCliente()->tipo_doc == "CEDULA DE EXTRANJERO") {
        $tipoCliente = 3;
    } else if ($venta->getCliente()->tipo_doc == "CEDULA DE EXTRANJERO") {
        $tipoCliente = 3;
    } else if ($venta->getCliente()->tipo_doc == "SIN NOMBRE") {
        $tipoCliente = 5;
        $esContribuyente = 0;
    } else if ($venta->getCliente()->tipo_doc == "DIPLOMATICO") {
        $tipoCliente = 4;
        $esContribuyente = 0;
    } else if ($venta->getCliente()->tipo_doc == "CI") {
        $tipoCliente = 4;
        $esContribuyente = 0;
        $tipoop = 2;
    }
    $credito = CreditoData::getByVentaId($venta->id_venta);
    $cambio = $venta->VerTipoModena()->simbolo == "US$" ? $venta->cambio2 : 1;
    $cdcAsociado = $venta->tipo_venta == 5 ? $venta->cdc_fact : '';
    // 
    $cod = 1;
    $entregas = array();
    $tipo = $venta->metodopago;
    if ($tipo == "Contado") {
        $cajas = CajaDetalle::obtenerVenta($venta->id_venta);
        if ($cajas) {
            foreach ($cajas  as $caja) {
                $cod = $caja->CAJA;
                if ($cod == 1) {
                    array_push(
                        $entregas,
                        [
                            'tipo' => 1,
                            'monto' =>  $caja->IMPORTE,
                            'moneda' => $moneda,
                            'cambio' => $cambio,
                        ]
                    );
                }
                if ($cod == 2) {
                    $cuenta = CuentaBancariaData::getByCajaId($caja->ID);
                    array_push(
                        $entregas,
                        [
                            'tipo' => 5,
                            'monto' =>  $caja->IMPORTE,
                            'moneda' => $moneda,
                            'cambio' => $cambio,
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
                                'tipo' => 2,
                                'monto' => $caja->IMPORTE,
                                'moneda' => $moneda,
                                'cambio' => $cambio,
                                'infoCheque' => [
                                    "numeroCheque" => $cuenta->nro_cheque,
                                    "banco" => $banco->nombre_banco
                                ],
                            ]
                        );
                    }
                }
                if ($cod == 4) {
                    $cuenta = TarjetaDetalleData::getByCobro($caja->ID);
                    array_push(
                        $entregas,
                        [
                            'tipo' => $cuenta->procesadora_id == 1 ? 3 : 4,
                            'monto' =>  $caja->IMPORTE,
                            'moneda' => $moneda,
                            'cambio' => $cambio,
                            'infoTarjeta' => [
                                "tipo" => intval($cuenta->tipo),
                                "tipoDescripcion" => "",
                                "titular" => str_replace(".", "", $cliente),
                                "ruc" => $venta->getCliente()->dni,
                                "razonSocial" =>  $cliente,
                                "medioPago" => 1,
                                "codigoAutorizacion" => 123456789
                            ],
                        ]
                    );
                }
            }
        } else {
            array_push(
                $entregas,
                [
                    'tipo' => 1,
                    'monto' =>  $venta->total - $venta->descuento,
                    'moneda' => $moneda,
                    'cambio' => $cambio,
                ]
            );
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
                'monto' =>  $venta->total - $venta->descuento,
                'vencimiento' => $vencimiento,
            ],
        ];

        $credito = [
            'tipo' => 2,
            'plazo' => "30 días",
            'cuotas' => $cuotas,
            'montoEntrega' => $venta->total - $venta->descuento,
            'infoCuotas' => $infoCuotas,

        ];

        $condicionPagos['credito'] = $credito;
    }
    // 
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



    // <?php if ($sell->numero_factura  == NULL) : 

    //     <?php echo 'SIN RELACION'; 
    // <?php else : 
    //     <?php echo $sell->numero_factura; 
    // <?php endif 

    $array =  array(
        "id" => $venta->id_venta,
        "emailEnviado" => $venta->email_enviado,
        "xml" => $venta->xml,
        "factura" => $venta->factura,
        "tipoOperacion" => $tipoop,
        "envio" => $venta->enviado == NULL ? 'No enviado' : $venta->enviado,
        "tipo" => $venta->tipo_venta,
        "fecha" => $venta->fecha,
        "emailEnviado" => $venta->email_enviado,
        "estado" => $venta->estado == 1 ? 'Activo' : 'Anulado',
        "cliente" => $venta->getCliente(),
        "total" => $venta->total - $venta->descuento,
        "metodoPago" => $venta->metodopago,
        "cambio" => $cambio,
        "moneda" => $venta->VerTipoModena(),
        "credito" => $credito,
        "facturaRemision" => $venta->numero_factura == NULL ? 'SIN RELACION' : $venta->numero_factura,
        "kude" => array(
            "cdc" => $venta->cdc,
            "factura" => $venta->factura,
            "fechaEmision" => $venta->fecha_envio,
            "condicion" => $venta->metodopago,
            "rucCliente" => $venta->getCliente()->dni,
            "cambio" => $cambio,
            "razonCliente" => $cliente,
            "moneda" => $moneda,
            "dirCliente" => $venta->getCliente()->direccion,
            "telCliente" => $venta->getCliente()->telefono,
            "cel" => $venta->getCliente()->celular,
            "iva10" => $venta->iva10,
            "iva5" => $venta->iva5,
            "email" => $venta->getCliente()->email,
            "vipoVenta" => 1,
            "cdcAsociado" =>  $cdcAsociado,
            "kudeQr" => $venta->kude,
            "itemsVenta" => json_encode($productos),
            "tipoFactura" => "Factura",
            "operacion" => "Factura Electrónica",
            "docAsociado" => ""
        ),
        "enviar" => array(
            "items" => $productosItem,
            "tipoP" => $cod,
            "condicionPagos" => $condicionPagos,
            "telefonoCliente" => $venta->getCliente()->telefono,
            "emailCliente" => $venta->getCliente()->email,
            "id" => $int,
            "descripcion" => "venta",
            "cliente" => $cliente,
            "telEmisor" => $sucursal->telefono,
            "rucEmisor" => $sucursal->ruc,
            "rucCliente" => $venta->getCliente()->dni,
            "dirCliente" =>  $venta->getCliente()->direccion,
            "telCliente" => $venta->getCliente()->telefono,
            "factura" =>  substr($venta->factura, 8),
            "total" => $venta->total - $venta->descuento,
            "moneda" =>  $moneda,
            "fechaVenta" => date("Y-m-d-h-i", strtotime($venta->fecha)),
            "tipo" => $venta->metodopago,
            "cambio" => $cambio,
            "departamentoCliente" => $venta->getCliente()->departamento_id,
            "distritoCliente" => $venta->getCliente()->distrito_id,
            "ciudadCliente" => $venta->getCliente()->ciudad,
            "cuotas" =>    $cuotas,
            "establecimiento" => substr($venta->factura, 0, -12),
            "punto" =>   substr($venta->factura, 4, -8),
            "vencimiento" =>  $vencimiento,
            "esContribuyente" => $esContribuyente,
            "docCliente" => $tipoCliente,
            "tipoTransaccion" => $venta->transaccion == 0 ? 1 : intval($venta->transaccion)
        )
    );
    array_push($response, $array);
}
header("Content-type:application/json");
$jsdata = json_decode(file_get_contents('php://input'), true);
header("HTTP/1.1 200 OK");
header('Content-Type: text/plain');
echo json_encode([
    "data" => [
        "venta" =>  $response,
        "insumoId" => $insumoId,
        "sucursal" => $sucursal,

    ],
    "pages" => ceil($paginas[0]->total_registros / 10)
]);
