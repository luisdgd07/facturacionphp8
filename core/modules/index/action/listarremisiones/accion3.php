<?php
$response = [];
// $ventas = VentaData::versucursaltipoventasremi4($sucursales->id_sucursal);
$ventas = VentaData::buscarRemisiones($_GET['sucursal'], $_GET['offset'], $_GET['busqueda'], $_GET['desde'], $_GET['hasta'], $_GET['cliente']);
$paginas = VentaData::buscarRemisionesPaginacion($_GET['sucursal'], $_GET['offset'], $_GET['busqueda'], $_GET['desde'], $_GET['hasta'], $_GET['cliente']);
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

    $tipoCliente = 1;
    $tipoOperacion = 2;
    $esContribuyente = 1;
    if ($venta->tipo_remision == 3) {
        $tipoOperacion = 4;
        $esContribuyente = 0;
    }
    if ($venta->getCliente()->tipo_doc == "RUC") {
        $tipoCliente = 1;
    } else if ($venta->getCliente()->tipo_doc == "PASAPORTE") {
        $tipoCliente = 2;
    } else if ($venta->getCliente()->tipo_doc == "CEDULA DE EXTRANJERO") {
        $tipoCliente = 3;
    } else if ($venta->getCliente()->tipo_doc == "CLIENTE DEL EXTERIOR") {
        $tipoCliente = 3;
    } else if ($venta->getCliente()->tipo_doc == "SIN NOMBRE") {
        $tipoCliente = 5;
        $esContribuyente = 0;
    } else if ($venta->getCliente()->tipo_doc == "DIPLOMATICO") {
        $tipoCliente = 4;
        $esContribuyente = 0;
    }

    $credito = CreditoData::getByVentaId($venta->id_venta);
    $cambio = $venta->VerTipoModena()->simbolo == "US$" ? $venta->cambio : 1;
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

    $data = OperationData::getAllProductsBySellIddd($venta->id_venta);
    $cajas = 0;
    foreach ($data as $d) {
        $cajas += $d->q;
    }
    $pais = PaisData::get($venta->getCliente()->pais_id);

    $chofer = ChoferData::getId($venta->id_chofer);
    $vehiculo = VehiculoData::getId($venta->id_vehiculo);

    if ($venta->tipo_transporte == 1) {
        $tipoResponsable = 1;
    } else {
        $tipoResponsable = 3;
    }

    if (!is_null($venta->fletera_id)) {
        $fletera = FleteraData::ver($venta->fletera_id);
        $fleteraN = $fletera->nombre_empresa;
    }
    $direccionFlete = is_null($venta->fletera_id) ? $sucursal->direccion : $fletera->direccion;
    $rucFlete = is_null($venta->fletera_id) ? $sucursal->ruc : $fletera->ruc;
    $nombreFlete = is_null($venta->fletera_id) ? $sucursal->direccion : $fletera->nombre_empresa;

    if ($sucursal->id_sucursal == 19) {
        $u = UserData::getById($venta->usuario_id);
        $responsable = $u->nombre . " " . $u->apellido;
    } else {
        $u = UserData::getById($_SESSION["admin_id"]);
        $responsable = $u->nombre . " " . $u->apellido;
    }
    $pais = PaisData::get($venta->getCliente()->pais_id);

    $array =  array(
        "id" => $venta->id_venta,
        "emailEnviado" => $venta->email_enviado,
        "xml" => $venta->xml,
        "factura" => $venta->factura,
        "envio" => $venta->enviado == NULL ? 'No enviado' : $venta->enviado,
        "tipo" => $venta->tipo_venta,
        "fecha" => $venta->fecha,
        "emailEnviado" => $venta->email_enviado,
        "estado" => $venta->estado == 1 || $venta->estado == 0  ? 'Activo' : 'Anulado',
        "cliente" => $venta->getCliente(),
        "total" => $venta->total - $venta->descuento,
        "metodoPago" => $venta->metodopago,
        "cambio" => $cambio,
        "moneda" => $venta->VerTipoModena(),
        "credito" => $credito,
        "cajas" => $cajas,
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
            "email" =>  $venta->getCliente()->email,
            "correo" =>  $venta->getCliente()->email,
            "vipoVenta" => 2,
            "cdcAsociado" =>  $cdcAsociado,
            "kudeQr" => $venta->kude,
            "venta" => $venta->factura,
            "itemsVenta" => json_encode($productos),
            "tipoFactura" => "Remisión",
            "operacion" => "Remisión Electrónica",
            "chofer" => $chofer->nombre,
            "razonchofer" => $chofer->nombre,
            "respon" => $responsable,
            "marca" => $vehiculo->marca,
            "flete" => $nombreFlete,
            "razonchofer" => $chofer->nombre,
            "dirchofer" => $chofer->direccion,
            "rucchofer" => $chofer->cedula,
            "inicio" => $venta->fecha_envio,
            "fin" => $venta->fecha_envio,
            "fintras" => $venta->fecha_envio,
            "iniciotras" => $venta->fecha_envio,
            "casasalida" => "",
            "casaentrega" => "",
            "chapa" => $vehiculo->chapa_nro,
            "kms" => "0",
            "rua" => $vehiculo->rua_nro,
            "tipo_transporte" => $venta->tipo_transporte,
            "motivo" => $venta->tipo_remision,
            "ident" => "",
            "transpor" => "",
            "idtrans" => "",
            "kudeQr" => $venta->kude,
            "numChofer" => $chofer->telefono,
            "puntoLlegada" => $sucursal->id_sucursal == 19 ? $venta->destino : null,
            "docAsociado" => "",
            "placas" => []
        ),
        "enviar" => array(
            "items" => $productosItem,
            "paisCliente" => $pais->codigo,
            "tipoOperacion" => $tipoOperacion,
            "telefonoCliente" => $venta->getCliente()->telefono,
            "emailCliente" => $venta->getCliente()->email,
            "id" => $int,
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
            "establecimiento" => substr($venta->factura, 0, -12),
            "punto" =>   substr($venta->factura, 4, -8),
            "esContribuyente" => $esContribuyente,
            "docCliente" => $tipoCliente,
            "remision" => array(
                "motivo" => $venta->tipo_remision,
                "tipoResponsable" => 1,
                "kms" => 150,
                "fechaFactura" => $venta->fecha
            ),
            "transporte" => array(
                "tipo" => 2,
                "modalidad" => 1,
                "tipoResponsable" => $tipoResponsable,
                "condicionNegociacion" => "CFR",
                "numeroManifiesto" => "AF-2541",
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
                    "marca" => $vehiculo->marca,
                    "documentoTipo" => 1,
                    "documentoNumero" => $vehiculo->chapa_nro,
                    "obs" => "",
                    "numeroMatricula" => $vehiculo->chapa_nro,
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

                ),
            )
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
