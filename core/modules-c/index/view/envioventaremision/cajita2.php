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

        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <?php if (true) :
                        ?>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <?php
                                            $products = VentaData::versucursaltipoventasremi3($_GET['id_sucursal']);
                                            $sucursal = new SuccursalData();

                                            $sucursalDatos = $sucursal->VerId($_GET['id_sucursal']);
                                            if (count($products) > 0) {

                                            ?>
                                                <input type="text" name="" class="form-control" id="lote" placeholder="Consulta Lote">
                                                <br>
                                                <button onclick="consultadeLote()" class="btn btn-primary">Consultar lote</button>
                                                <br>
                                                <hr>
                                                <br>
                                                <button onclick="enviar()" class="btn btn-primary">Enviar Ventas a SIFEN </button>
                                                <br>
                                                <table id="example1" class="table table-bordered table-hover  ">
                                                    <thead>
                                                        <th></th>
                                                        <th>Nro.</th>
                                                        <th width="120px">N° Factura</th>
                                                        <th width="120px">Cliente</th>
                                                        <th>Total</th>
                                                        <th width="120px">Metodo Pago</th>
                                                        <!-- <th>Forma Pago</th> -->
                                                        <th>Fecha de Remision</th>
                                                        <th>Cambio</th>
                                                        <td>Tipo Moneda</td>
                                                        <td>Envio a SIFEN</td>
                                                        <td>Xml</td>
                                                        <td>Kude</td>
                                                        <th>Cancelar</th>
                                                        <!-- <th></th> -->
                                                    </thead>

                                                    <?php
                                                    $int = 0;
                                                    foreach ($products as $sell) :
                                                        $int++;
                                                    ?>
                                                        <tr>
                                                            <?php
                                                            $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                                                            count($operations);
                                                            ?>




                                                            <td style="width:30px;">
                                                                <a href="index.php?view=detalleventaproducto&id_venta=<?php echo $sell->id_venta; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open" style="color: orange;"></i></a>
                                                            </td>

                                                            <td style="width:30px;">
                                                                <?php echo $sell->id_venta; ?>
                                                            </td>

                                                            <td class="width:30px;">
                                                                <?php if ($sell->tipo_venta == "5") : ?>

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

                                                                if ($sell->enviado == "Aprobado") {
                                                                    echo
                                                                    '<p class="bg-success text-white text-center">Aprobado</p>';
                                                                } else {

                                                                    if ($sell->enviado == "Cancelado") {
                                                                        echo '<p class="bg-danger text-white text-center">Cancelado</p>';
                                                                    }
                                                                    if ($sell->enviado == "Rechazado") {
                                                                        echo '<p class="bg-danger text-white text-center">Rechazado</p>';
                                                                    }
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
                                                                // var_dump($operations);
                                                                foreach ($operations as $operation) {
                                                                    $product  = $operation->getProducto();
                                                                    // var_dump($operation);

                                                                    // if ($operation->q == 0) {
                                                                    //     $cant = $operation->precio3;
                                                                    // } else {
                                                                    //     $cant = $operation->q;
                                                                    // };
                                                                    $precio =  floatval($operation->precio);
                                                                    $cant = $operation->q;

                                                                    $array = [
                                                                        "precioUnitario" => $precio,
                                                                        "codigo" => $product->codigo,
                                                                        "descripcion" => $product->nombre,
                                                                        "observacion" => "",
                                                                        "unidadMedida" => UnidadesData::getById($product->presentacion)["nombre"],
                                                                        "cantidad" => $cant,
                                                                        "cambio" => "0",
                                                                        "ivaTipo" => 1,
                                                                        "ivaBase" => "100",
                                                                        "iva" => "10",
                                                                        "lote" => "",
                                                                        "vencimiento" => "",
                                                                        "numeroSerie" => "",
                                                                        "numeroPedido" => "",
                                                                        "tolerancia" => 1,
                                                                        "toleranciaCantidad" => 1,
                                                                        "toleranciaPorcentaje" => 1,
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
                                                                $vehiculo = VehiculoData::getId($venta->id_vehiculo);
                                                                $chofer = ChoferData::getId($venta->id_chofer);
                                                                $cdc = $venta->cdc_fact;
                                                                if ($sell->metodopago == "Credito") {
                                                                    $credito = CreditoData::getByVentaId($sell->id_venta);
                                                                    if ($credito != NULL) {
                                                                        $cuotas = $credito->cuotas;
                                                                        $vencimiento = $credito->vencimiento;
                                                                    }
                                                                }

                                                                $rucCLiente = $client->dni;
                                                                ?>
                                                                <script>

                                                                </script>

                                                                <input type="checkbox" id="<?php echo $sell->id_venta; ?>" onchange='agregar({
                                                                                        items:"",
                                                                                       
                                                                                       id: "<?= $int ?>",
                                                                                        telEmisor: "<?= $telefonoEmisor ?>",
                                                                                        rucEmisor: "<?= $rucEmisor ?>", 
                                                                                            rucCliente: "<?= $rucCLiente ?>", 
                                                                                        cliente: "<?php echo $cliente ?>" , 
                                                                                        dirCliente: "<?php echo $direccionCliente; ?>" ,
                                                                                         telCliente:"<?php echo $telefono; ?>",
                                                                                         factura: "<?php echo $factura; ?>" ,
                                                                                          total: "<?php echo $total; ?>" ,
                                                                                           moneda:"<?php echo $moneda; ?>", 
                                                                                           fechaVenta: "<?php echo $fechaventa;  ?>" , 
                                                                                           tipo: "<?php echo $tipo;  ?>" , 
                                                                                           cambio: <?php echo $cambio;  ?>, 
                                                                                           departamentoCliente: <?php echo $dptClient ?>,
                                                                                            distritoCliente:<?php echo $distClient ?>,
                                                                                             ciudadCliente:<?php echo $ciudadCliente ?>,
                                                                                             cuotas: <?php echo $cuotas ?>, 
                                                                                                   establecimiento:<?php echo substr($sell->factura, 0, -12) ?>,
                                                                                            punto: <?php echo substr($sell->factura, 4, -8) ?>,
                                                                                             documentoAsociado : {
                                                                                                    cdc : "<?php echo $cdc ?>",
                                                                                                    formato : 1,
                                                                                                    tipo : 1,
                                                                                                    timbrado :"<?php echo $sucursalDatos->fecha_tim ?>",
                                                                                                    establecimiento : <?php echo substr($sell->factura, 0, -12) ?>,
                                                                                                    punto : <?php echo substr($sell->factura, 4, -8) ?>,
                                                                                                    numero : "1",
                                                                                                    fecha : "<?php echo $sell->fecha ?>",
                                                                                                    numeroRetencion : "",
                                                                                                    resolucionCreditoFiscal : "",
                                                                                                    constanciaTipo : 1,
                                                                                                    constanciaNumero : 1,
                                                                                                    constanciaControl : "1",

                                                                                                },
                                                                                             vencimiento: "<?php echo $vencimiento ?>" } 
                                                                                             ,<?php echo $sell->id_venta; ?>, <?php echo json_encode($productosItem) ?>)'>
                                                                <!-- <button class="btn btn-primary" onclick="">Agregar</button> -->
                                                                <?php    ?>
                                                            </td>
                                                            <td>

                                                                <?php if ($sell->enviado == "Rechazado") { ?>
                                                                    <!-- <a class="btn btn-primary" href="http://localhost:3000/downloadxml/<?php echo $sell->xml; ?>">Descargar XMl</a> -->

                                                                    <a class="btn btn-primary" href="http://18.208.224.72:3000/downloadxml/<?php echo $sell->xml; ?>">Descargar XML</a>
                                                                <?php } else if ($sell->enviado == "Aprobado") {
                                                                ?>
                                                                    <a class="btn btn-primary" href="http://18.208.224.72:3000/downloadxml/<?php echo $sell->xml; ?>">Descargar XML</a>
                                                                    <!-- <a class="btn btn-primary" href="http://localhost:3000/downloadxml/<?php echo $sell->xml; ?>">Descargar XMl</a> -->


                                                                <?php
                                                                } else {

                                                                    echo "No enviado";
                                                                } ?>

                                                            </td>
                                                            <td>

                                                                <?php if ($sell->enviado == "Rechazado") { ?>
                                                                    <a class="btn btn-primary" href="./impresionkude.php?id_venta=<?php echo $sell->id_venta; ?>">Descargar Kude</a>
                                                                    <!-- <a class="btn btn-primary" href="http://localhost:3000/downloadkude/<?php echo $sell->kude; ?>">Descargar Kude</a> -->
                                                                <?php } else if ($sell->enviado == "Aprobado") {
                                                                ?>
                                                                    <!-- ./impresionkude.php?id_venta=<?php echo $sell->id_venta; ?> -->
                                                                    <!-- <a class="btn btn-primary" href="http://18.208.224.72:3000/downloadkude/<?php echo $sell->kude; ?>">Descargar Kude</a> -->
                                                                    <?php if ($sucursalDatos->tipo_recibo == 0) { ?> <a class="btn btn-primary" href="./impresionkude2.php?id_venta=<?php echo $sell->id_venta; ?>">Descargar Kude</a>
                                                                    <?php }
                                                                    if ($sucursalDatos->tipo_recibo == 1) { ?>
                                                                        <a class="btn btn-primary" href="./impresionkude.php?id_venta=<?php echo $sell->id_venta; ?>">Descargar Kude</a>

                                                                    <?php } ?>

                                                                <?php
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
                                                                    <button class="btn btn-warning" onclick="cancelar('<?php echo $sell->cdc ?>',<?php echo $sell->id_venta ?>)">Cancelar</button>

                                                                <?php
                                                                } else {

                                                                    echo "No enviado";
                                                                } ?>

                                                            </td>
                                                        </tr>

                                                    <?php
                                                    endforeach; ?>

                                                </table>
                                                <div class="clearfix"></div>

                                            <?php
                                            } else {
                                            ?>
                                                <div class="jumbotron">
                                                    <h2>No hay ventas</h2>
                                                    <p>No se ha realizado ninguna venta.</p>
                                                </div>
                                            <?php
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            501 Internal Error
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var datos = [];
    var ventas = [];
    var lotesenviados = []
    var xmlsenviados = []
    var kudes = [];
    var fecha = "";

    function cancelar(cdc, id) {
        console.log(id)
        Swal.fire({
            title: 'Desea cancelar este CDC',
            showDenyButton: true,
            confirmButtonText: 'Cancelar CDC',
            denyButtonText: `Cerrar`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                datos2 = JSON.stringify(datos);
                Swal.fire({
                    title: 'Enviando cancelacion',
                    icon: 'info',
                })
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
                let cert = './facturacionElectronica<?php echo $sucursalDatos->certificado_url ?>';
                // let cert = './facturacionElectronica<?php echo $sucursalDatos->certificado_url ?>';
                console.log(cert);
                console.log(cdc)
                datosCert = JSON.stringify(data1)
                $.ajax({
                    url: "http://18.208.224.72:3000/cancelar",
                    // url: "http://18.208.224.72:3000/consultaruc",
                    // url: "http://localhost:3000/cancelar",
                    type: "POST",
                    data: {
                        // datos: {
                        //     cdc: "01800266110001002000206122022121310008016716",
                        //     motivo: "Se cancela este CDC"
                        // },
                        datos: cdc,
                        env: '<?php echo $sucursalDatos->entorno ?>',
                        // cert: '../facturacionElectronica/3997053.pfx',
                        cert: cert,
                        id: '<?php echo $sucursalDatos->id_envio; ?>',
                        // cert: './3997053.pfx',
                        pass: '<?php echo $sucursalDatos->clave ?>',
                        data1: datosCert,

                    },

                    success: function(dataResult) {
                        try {

                            if (dataResult['ns2:rRetEnviEventoDe']['ns2:gResProcEVe']['ns2:dEstRes'] == "Aprobado") {
                                // Swal.fire({
                                //     title: `${dataResult['ns2:rRetEnviEventoDe']['ns2:gResProcEVe']['ns2:dEstRes']}`,
                                //     icon: 'success',
                                // })

                                Swal.fire({
                                    title: 'Aprobado',
                                    text: `el cdc ${cdc} ha sido cancelado`,
                                    icon: 'success',
                                    confirmButtonColor: '#ff0000',
                                    confirmButtonText: 'Recargar pagina'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload()
                                    }
                                })
                                $.ajax({
                                    url: 'index.php?action=cancelacioncdc&id=' + id,
                                    type: 'POST',
                                    cache: false,
                                    dataType: 'json',
                                    success: function(json) {


                                    },
                                    error: function(xhr, status) {
                                        console.log("Ha ocurrido un error.");
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: `${dataResult['ns2:rRetEnviEventoDe']['ns2:gResProcEVe']['ns2:dEstRes']} causa: ${dataResult['ns2:rRetEnviEventoDe']['ns2:gResProcEVe']['ns2:gResProc']['ns2:dMsgRes']}`,
                                    icon: 'error',
                                })
                            }

                        } catch (e) {}

                    },

                });
            } else if (result.isDenied) {
                // Swal.fire('Changes are not saved', '', 'info')
            }
        })

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
        // let cert = '.<?php echo $sucursalDatos->certificado_url ?>';
        let cert = './facturacionElectronica<?php echo $sucursalDatos->certificado_url ?>';
        console.log(cert);

        datosCert = JSON.stringify(data1)
        $.ajax({
            url: "http://18.208.224.72:3000/enviarlote",
            // url: "http://localhost:3000/enviarlote",
            type: "POST",
            data: {
                datos: datos2,
                env: '<?php echo $sucursalDatos->entorno ?>',
                cert: cert,
                logo: "./METASA_logo.png",
                pass: '<?php echo $sucursalDatos->clave ?>',
                data1: datosCert,
                tipo: 1,
                descripcion: 'venta de remision',
                ventaremision: true,
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


    function kude(venta) {
        Swal.fire({
            title: 'Formato de kude',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'A4',
            denyButtonText: `Ticket`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href = "./impresionkude.php?id_venta=" + venta
                // Swal.fire('Saved!', '', 'success')
            } else if (result.isDenied) {
                window.location.href = "./impresionkudeticket.php?id_venta=" + venta
                // Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }

    function consultaLote(lote) {
        // let cert = '../facturacionElectronica<?php echo $sucursalDatos->certificado_url ?>';
        let cert = './facturacionElectronica<?php echo $sucursalDatos->certificado_url ?>';
        $.ajax({
            url: "http://18.208.224.72:3000/consultalote",
            // url: "http://localhost:3000/consultalote",
            type: "POST",
            data: {
                lote: lote,
                env: '<?php echo $sucursalDatos->entorno ?>',
                // cert: '../facturacionElectronica/3997053.pfx',
                cert: cert,
                // cert: './3997053.pfx',
                pass: '<?php echo $sucursalDatos->clave ?>',

            },

            success: function(dataResult) {

                try {
                    let dataEnviada = [];
                    let lotes = JSON.parse(dataResult);
                    console.log('consulta', lotes['ns2:rResEnviConsLoteDe']['ns2:gResProcLote']);
                    let textoLote = "";
                    lotesenviados = lotes['ns2:rResEnviConsLoteDe']['ns2:gResProcLote'];
                    if (lotesenviados.length == undefined) {
                        console.log("aqui")
                        dataEnviada.push({
                            venta: ventas[0],
                            cdc: lotesenviados['ns2:id'],
                            estado: lotesenviados["ns2:dEstRes"],
                            xml: xmlsenviados[0],
                            kude: kude[0],

                        });
                        console.log("aqui2", dataEnviada);
                        textoLote += "Venta: " + ventas[0] + " " + lotesenviados["ns2:dEstRes"] + " causa:" + lotesenviados["ns2:gResProc"]["ns2:dMsgRes"];
                    } else {
                        console.log("aqui3");
                        for (let i = 0; i < lotesenviados.length; i++) {
                            console.log('ss ');
                            dataEnviada.push({
                                venta: ventas[i],
                                cdc: lotesenviados[i]['ns2:id'],
                                estado: lotesenviados[i]["ns2:dEstRes"],
                                xml: xmlsenviados[i],
                                kude: kude[i],

                            });
                            textoLote += "Venta: " + ventas[i] + " " + lotesenviados[i]["ns2:dEstRes"] + " " + lotesenviados[i]["ns2:gResProc"]["ns2:dMsgRes"] + "\n"
                        }
                    }

                    $.ajax({
                        url: 'index.php?action=agregarenviolote',
                        type: "POST",
                        cache: false,
                        data: {
                            data: dataEnviada,
                            fecha: fecha
                        },
                        dataType: 'json',
                        success: function(json) {
                            console.log(json)

                            // setTimeout(function() {
                            //     window.location.reload()

                            // }, 5000);

                        },
                        error: function(xhr, status) {
                            console.log("Ha ocurrido un error.", xhr);
                        }
                    });
                    // Swal.fire({
                    //     title: textoLote,
                    //     icon: 'info',
                    //     confirmButtonText: 'Aceptar'
                    // });
                    Swal.fire({
                        title: 'Resultados',
                        text: textoLote,
                        icon: 'info',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Recargar pagina'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    })
                } catch (e) {
                    // Swal.fire({
                    //     title: "Error",
                    //     icon: 'danger',
                    //     confirmButtonText: 'Aceptar'
                    // });
                    Swal.fire({
                        title: 'Error al recibir datos del lote',
                        text: `El lote ${$("#lote").val()} esta en procesamiento, espere en 30 segundos automaticamente se volvera a realizar la consulta`,
                        icon: 'error',
                        confirmButtonColor: '#ff0000',
                        confirmButtonText: 'Recargar pagina'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    })
                    setTimeout(function() {
                        consultaLote(lote);
                    }, 30000);
                }

            },

        });
    }
</script>