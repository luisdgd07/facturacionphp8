<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <form class="form-horizontal" role="form" method="post" hidden name="facturacion"
            action="index.php?action=agregarenvio" enctype="multipart/form-data">
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
                        <?php if (true):
                            ?>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <?php
                                            $products = VentaData::versucursaltipoventasremi2($_GET['id_sucursal']);
                                            $sucursal = new SuccursalData();

                                            $sucursalDatos = $sucursal->VerId($_GET['id_sucursal']);
                                            if (count($products) > 0) {

                                                ?>
                                                <table id="example1" class="table table-bordered table-hover  ">
                                                    <thead>
                                                        <th></th>
                                                        <th>Nro.</th>
                                                        <th width="120px">N° Factura</th>
                                                        <th>Total</th>
                                                        <th width="120px">Metodo Pago</th>
                                                        <!-- <th>Forma Pago</th> -->
                                                        <th>Fecha de Remision</th>
                                                        <th>Cambio</th>
                                                        <td>Tipo Moneda</td>
                                                        <td>Envio a SIFEN</td>
                                                        <td>Xml</td>
                                                        <td>Kude</td>
                                                        <!-- <th></th> -->
                                                    </thead>

                                                    <?php
                                                    $int = 0;
                                                    foreach ($products as $sell):
                                                        $int++;
                                                        ?>
                                                        <tr>
                                                            <?php
                                                            $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                                                            count($operations);
                                                            ?>




                                                            <td style="width:30px;">
                                                                <a href="index.php?view=detalleventaproducto&id_venta=<?php echo $sell->id_venta; ?>"
                                                                    class="btn btn-xs btn-default"><i
                                                                        class="glyphicon glyphicon-eye-open"
                                                                        style="color: orange;"></i></a>
                                                            </td>

                                                            <td style="width:30px;">
                                                                <?php echo $sell->id_venta; ?>
                                                            </td>

                                                            <td class="width:30px;">
                                                                <?php if ($sell->tipo_venta == "1" or $sell->tipo_venta == "0"): ?>

                                                                    <?php echo $sell->factura; ?>
                                                                <?php else: ?>
                                                                    <?php echo count($operations) ?>
                                                                <?php endif ?>
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
                                                                    echo $sell->cambio2;
                                                                } else {
                                                                    echo 1;
                                                                } ?>

                                                            </td>



                                                            <td><?php echo $sell->VerTipoModena()->nombre; ?></td>

                                                            <td>

                                                                <?php if ($sell->enviado == "Rechazado") { ?>
                                                                    <button class="btn btn-warning" onclick="enviar()">Cancelar</button>
                                                                    <!-- <a class="btn btn-primary" href="<?php echo $GLOBALS['URL'] ?>/downloadxml/<?php echo $sell->xml; ?>">Descargar XMl</a> -->

                                                                    <a class="btn btn-primary"
                                                                        href="http://18.208.224.72:3000/downloadxml/<?php echo $sell->xml; ?>">Descargar
                                                                        XML</a>
                                                                <?php } else if ($sell->enviado == "Aprobado") {
                                                                    ?>
                                                                        <button class="btn btn-warning" onclick="enviar()">Cancelar</button>
                                                                        <a class="btn btn-primary"
                                                                            href="http://18.208.224.72:3000/downloadxml/<?php echo $sell->xml; ?>">Descargar
                                                                            XML</a>
                                                                        <!-- <a class="btn btn-primary" href="<?php echo $GLOBALS['URL'] ?>/downloadxml/<?php echo $sell->xml; ?>">Descargar XMl</a> -->


                                                                    <?php
                                                                } else {

                                                                    echo "No enviado";
                                                                } ?>

                                                            </td>
                                                            <td>

                                                                <?php if ($sell->enviado == "Rechazado") { ?>
                                                                    <a class="btn btn-primary"
                                                                        href="./impresionkude.php?id_venta=<?php echo $sell->id_venta; ?>">Descargar
                                                                        Kude</a>
                                                                    <!-- <a class="btn btn-primary" href="http://18.208.224.72:3000/downloadkude/<?php echo $sell->kude; ?>">Descargar Kude</a> -->
                                                                    <!-- <a class="btn btn-primary" href="<?php echo $GLOBALS['URL'] ?>/downloadkude/<?php echo $sell->kude; ?>">Descargar Kude</a> -->
                                                                <?php } else if ($sell->enviado == "Aprobado") {
                                                                    ?>
                                                                        <button onclick="kude(<?php echo $sell->kude; ?>)"></button>
                                                                        <button class="btn btn-warning" onclick="enviar()">Cancelar</button>
                                                                        <!-- ./impresionkude.php?id_venta=<?php echo $sell->id_venta; ?> -->
                                                                        <!-- <a class="btn btn-primary" href="http://18.208.224.72:3000/downloadkude/<?php echo $sell->kude; ?>">Descargar Kude</a> -->
                                                                        <a class="btn btn-primary"
                                                                            href="./impresionkude.php?id_venta=<?php echo $sell->id_venta; ?>">Descargar
                                                                            Kude</a>

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
                        <?php else: ?>
                            501 Internal Error
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
    var datos = [];
    var ventas = [];
    var lotesenviados = []
    var xmlsenviados = []
    var kudes = [];
    var fecha = "";

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
            },],
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
            },],
        }
        // let cert = '<?php echo $GLOBALS['CERT'] ?><?php echo $sucursalDatos->certificado_url ?>';
        let cert = '.<?php echo $sucursalDatos->certificado_url ?>';
        console.log(cert);

        datosCert = JSON.stringify(data1)
        $.ajax({
            // url: "http://18.208.224.72:3000/enviarlote",
            // url: "http://18.208.224.72:3000/consultaruc",
            url: "<?php echo $GLOBALS['URL'] ?>/cancelar",
            type: "POST",
            data: {
                // datos: {
                //     cdc: "01800266110001002000206122022121310008016716",
                //     motivo: "Se cancela este CDC"
                // },
                datos: "01800266110001002000206122022121310008016716",
                env: 'test',
                // cert: '<?php echo $GLOBALS['CERT'] ?>/3997053.pfx',
                cert: cert,
                // cert: './3997053.pfx',
                logo: "./METASA_logo.png",
                pass: '<?php echo $sucursalDatos->clave ?>',
                data1: datosCert,
                tipo: 7,
                descripcion: 'remision'

            },

            success: function (dataResult) {
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
                    setTimeout(function () {
                        consultaLote(lote);
                    }, 20000);

                } catch (e) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error en el formato del XML',
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