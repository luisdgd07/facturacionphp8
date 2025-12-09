<?php
$response = [];
$ventas = VentaData::buscarVentaExportacion($_GET['sucursal'], $_GET['offset'], $_GET['busqueda'], $_GET['desde'], $_GET['hasta'], $_GET['cliente']);
$paginas = VentaData::buscarVentaExportacionPaginacion($_GET['sucursal'], $_GET['offset'], $_GET['busqueda'], $_GET['desde'], $_GET['hasta'], $_GET['cliente']);
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

    $operations = OperationData::getAllProductsByVenta($venta->id_venta);

    $productos = array();
    foreach ($operations as $operation) {
        $product  = $operation->getProducto();
        $precio =  floatval($operation->precio);
        $tipo = TipoProductoData::VerId($operation->getProducto()->ID_TIPO_PROD);

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
                "unidadMedida" => UnidadesData::getById($product->presentacion)->nombre,
                "cantidad" => $cant,
                "tipo" => $tipo->TIPO_PRODUCTO,
                "cambio" => "0",
                "ivaTipo" => 3,
                "ivaBase" => "0",
                "iva" => "0",
                "lote" => "",
                "vencimiento" => "",
                "numeroSerie" => "",
                "numeroPedido" => "",
                "ncm" => $venta->tipo_venta == 50 ? $product->ncm : null,
                "partidaArancelaria" => $venta->tipo_venta == 50 ?  $product->partida_arancelaria : null,
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
            "unidadMedida" => UnidadesData::getById($product->presentacion)->nombre,
            "cantidad" => $operation->q,
            "cambio" => "0",
            "ivaTipo" => $ivaTipo,
            "ivaBase" => "0",
            "iva" => "0",
            "lote" => "",
            "vencimiento" => "",
            "numeroSerie" => "",
            "tipo" => $tipo->TIPO_PRODUCTO,
            "numeroPedido" => "",
            "ncm" => $venta->tipo_venta == 50 ? $product->ncm : null,
            "partidaArancelaria" => $venta->tipo_venta == 50 ?  $product->partida_arancelaria : null,
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
    $tipoCliente = 3;
    $esContribuyente = 0;

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

        if ($product->impuesto == 30) {
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
                "numeroPedido" => "",
                "ncm" => $venta->tipo_venta == 50 ? $product->ncm : null,
                "partidaArancelaria" => $venta->tipo_venta == 50 ?  $product->partida_arancelaria : null,
            ]);
            array_push($productosItem, $arrayIva5);
        } else {
            $precioUnitario = $precio;
        }
        $array = [
            "precioUnitario" => $precioUnitario,
            "codigo" => $product->codigo,
            "descripcion" => $product->nombre,
            "observacion" => "",
            "unidadMedida" => intval(UnidadesData::getById($product->presentacion)->codigo),
            "cantidad" => $operation->q,
            "cambio" => "0",
            "ivaTipo" => 3,
            "ivaBase" => "0",
            "iva" => "0",
            "lote" => "",
            "vencimiento" => "",
            "numeroSerie" => "",
            "numeroPedido" => "",
            "ncm" => $venta->tipo_venta == 50 ? $product->ncm : null,
            "partidaArancelaria" => $venta->tipo_venta == 50 ?  $product->partida_arancelaria : null,
        ];
        array_push($productosItem, $array);
    }



    // <?php if ($sell->numero_factura  == NULL) : 

    //     <?php echo 'SIN RELACION'; 
    // <?php else : 
    //     <?php echo $sell->numero_factura; 
    // <?php endif 
    $fleteraN = "";
    if ($venta->fletera_id) {
        $fletera = FleteraData::ver($venta->fletera_id);
        $fleteraN = $fletera->nombre_empresa;
    }
    $embarque = "";
    if (isset($venta->embarque)) {
        $embarque = $venta->embarque;
    }
    $pais = PaisData::get($venta->getCliente()->pais_id);
    $paisDes =  $pais->descripcion;

    $agente = AgenteData::veragente($venta->agente_id);
    $agenteNombre = "";
    $agenteDirrecion = "";
    $agenteCi = "";
    if (isset($agente)) {
        $agenteNombre = $agente->nombre_agente;
        $agenteDirrecion = $agente->ruc;
        $agenteCi = $agente->direccion;
    }

    $chofer = ChoferData::getId($venta->id_chofer);
    $vehiculoMarca = "";
    $vehiculoChapa_nro = "";
    if (isset($venta->id_vehiculo)) {
        $vehiculo = VehiculoData::getId($venta->id_vehiculo);

        if (isset($vehiculo)) {
            $vehiculoMarca = $vehiculo->marca;
            $vehiculoChapa_nro = $vehiculo->chapa_nro;
        }
    }


    if (!is_null($venta->fletera_id)) {
        $fletera = FleteraData::ver($venta->fletera_id);
        $fleteraN = $fletera->nombre_empresa;
    }
    $direccionFlete = is_null($venta->fletera_id) ? $sucursal->direccion : $fletera->direccion;
    $rucFlete = is_null($venta->fletera_id) ? $sucursal->ruc : $fletera->ruc;
    $nombreFlete = is_null($venta->fletera_id) ? $sucursal->direccion : $fletera->nombre_empresa;


    $remision = VentaData::getRemisionId($venta->REMISION_ID);
    $array =  array(
        "id" => $venta->id_venta,
        "emailEnviado" => $venta->email_enviado,
        "xml" => $venta->xml,
        "factura" => $venta->factura,
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
        "remision" => $venta->REMISION_ID,

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
            "vipoVenta" => $venta->tipo_venta == 20 ? 4 : 5,
            "cdcAsociado" =>  $cdcAsociado,
            "kudeQr" => $venta->kude,
            "itemsVenta" => json_encode($productos),
            "tipoFactura" => "Factura (exportación)",
            "operacion" => "Factura Electrónica",
            "docAsociado" => "Venta de mercadería",
            "empresa" => $fleteraN,
            "peson" => $venta->peso_neto,
            "pesob" => $venta->peso_bruto,
            "cdcAsociado" => $venta->cdc_fact,
            "embarque" => $embarque,
            "pais" => $paisDes,
            "condicionExpor" => $venta->condiNego,
            "agente" => $agenteNombre,
            "remision" => $remision->factura,
            "vencimiento" =>  $vencimiento,
        ),
        "enviar" => array(
            "items" => $productosItem,
            "tipoP" => $cod,
            "tipoOperacion" => 4,
            "contriuyenteCliente" => 2,
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
            "paisCliente" => $pais->codigo,
            "departamentoCliente" => $venta->getCliente()->departamento_id,
            "distritoCliente" => $venta->getCliente()->distrito_id,
            "ciudadCliente" => $venta->getCliente()->ciudad,
            "cuotas" =>    $cuotas,
            "establecimiento" => substr($venta->factura, 0, -12),
            "punto" =>   substr($venta->factura, 4, -8),
            "vencimiento" =>  $vencimiento,
            "esContribuyente" => $esContribuyente,
            "docCliente" => $tipoCliente,
            "documentoAsociado" => array(
                "cdc" => $venta->cdc_fact,
                "formato" => 1,
                "tipo" => 1,
                "timbrado" =>  $sucursal->fecha_tim,
                "establecimiento" => substr($venta->factura, 0, -12),
                "punto" => substr($venta->factura, 4, -8),
                "numero" => 1,
                "fecha" => $venta->fecha,
                "numeroRetencion" => "",
                "resolucionCreditoFiscal" => "",
                "constanciaTipo" => 1,
                "constanciaNumero" => 1,
                "constanciaControl" => "1"
            ),
            "remision" => array(
                "motivo" => 3,
                "tipoResponsable" => 1,
                "kms" => 150,
                "fechaFactura" => $venta->fecha
            ),
            "transporte" => array(
                "tipo" => 2,
                "modalidad" => 1,
                "tipoResponsable" => 1,
                "condicionNegociacion" => $venta->condiNego,
                "numeroManifiesto" => $venta->manifiesto,
                "numeroDespachoImportacion" => "153223232332",
                "inicioEstimadoTranslado" => "2021-11-01",
                "finEstimadoTranslado" => "2021-11-01",
                "pais" => $pais->codigo,
                "paisDescripcion" => $pais->descripcion,
                "salida" => array(
                    "direccion" => $sucursal->direccion,
                    "numeroCasa" => $sucursal->numero_casa,
                    "complementoDireccion1" => $sucursal->com_dir,
                    "complementoDireccion2" => $sucursal->com_dir2,
                    "departamento" =>   $sucursal->cod_depart,
                    "departamentoDescripcion" => $sucursal->departamento_descripcion,
                    "distrito" =>  $sucursal->distrito_id,
                    "distritoDescripcion" => $sucursal->distrito_descripcion,
                    "ciudad" =>  $sucursal->id_ciudad,
                    "ciudadDescripcion" =>  $sucursal->ciudad_descripcion,
                    "pais:" => "PRY",
                    "paisDescripcion" => "Paraguay",
                    "telefonoContacto" =>  $sucursal->telefono
                ),
                "entrega" => array(
                    "direccion" => $pais->codigo,
                    "numeroCasa" => "1",
                    "complementoDireccion1" => "",
                    "complementoDireccion2" => "",
                    "departamento" => 0,
                    "departamentoDescripcion" => "",
                    "distrito" => 0,
                    "distritoDescripcion" => "",
                    "ciudad" => 1,
                    "ciudadDescripcion" => "",
                    "pais" =>  $pais->codigo,
                    "paisDescripcion" => $pais->descripcion,
                    "telefonoContacto" => ""
                ),
                "vehiculo" => array(
                    "tipo" => "12345",
                    "marca" => $vehiculoMarca,
                    "documentoTipo" => 1,
                    "documentoNumero" => $vehiculoChapa_nro,
                    "obs" => "",
                    "numeroMatricula" => $vehiculoChapa_nro,
                    "numeroVuelo" => 0
                ),
                "transportista" => array(
                    "contribuyente" => true,
                    "nombre" => $nombreFlete,
                    "ruc" => $rucFlete,
                    "documentoTipo" => 1,
                    "documentoNumero" => "",
                    "direccion" => $direccionFlete,
                    "obs" => 1,
                    "pais" => "PRY",
                    "paisDescripcion" => "Paraguay",
                    "chofer" => array(
                        "documentoNumero" =>  $chofer->cedula,
                        "nombre" => $chofer->nombre,
                        "direccion" => $chofer->direccion
                    ),
                    "agente" => array(
                        "nombre" => $agenteNombre,
                        "ruc" => $agenteCi,
                        "direccion" => $agenteDirrecion
                    ),
                ),
            ),

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
