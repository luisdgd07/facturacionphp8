<div class="content-wrapper">
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
                                            $products = VentaData::versucursaltipoventas($_GET['id_sucursal']);
                                            $sucursal = new SuccursalData();
                                            require 'core/modules/index/components/consultalote.php';
                                            $sucursalDatos = $sucursal->VerId($_GET['id_sucursal']);
                                            if (count($products) > 0) {

                                            ?>
                                                <input type="text" name="" class="form-control" id="lote" placeholder="Consulta Lote">
                                                <br>
                                                <button onclick="consultadeLote()" class="btn btn-primary">Consultar lote</button>
                                                <br>
                                                <hr>
                                                <br>
                                                <button onclick="enviar()" class="btn btn-primary">Enviar ventas a SIFEN </button>
                                                <br>
                                                <table id="example1" class="table table-bordered table-hover  ">
                                                    <thead>
                                                        <th></th>
                                                        <th>Nro.</th>
                                                        <th width="120px">N° Factura</th>
                                                        <th width="120px">Cliente</th>
                                                        <th>Total</th>
                                                        <th width="120px">Metodo Pago</th>
                                                        <th>Fecha de Venta</th>
                                                        <th>Cambio</th>
                                                        <td>Tipo Moneda</td>
                                                        <td>Envio a SIFEN</td>
                                                        <td>Kude</td>
                                                        <th>xml</th>
                                                        <th>Cancelar</th>
                                                    </thead>

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
        // let cert = '../facturacionElectronica<?php echo $sucursalDatos->certificado_url ?>';
        //let cert = './facturacionElectronica<?php echo $sucursalDatos->certificado_url ?>';
        // let cert = '.<?php echo $sucursalDatos->certificado_url ?>';
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
                pass: '<?php echo $sucursalDatos->clave ?>',
                data1: datosCert,
                tipo: 1,
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




    function kude(items, cdc, factura, fecha, condicion, rucCliente, cambio, cliente, moneda, direccion, telefono, iva10, iva5, tipo, email, id) {
        console.log(items)
        Swal.fire({
            title: 'Enviando correo',
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
        let itemsVenta = JSON.stringify(items);
        $.ajax({
            url: "http://18.208.224.72:3100/enviarcorreo",
            //  url: "http://localhost:3100/enviarcorreo",
            type: "POST",
            data: {
                cdc: cdc,
                sucursal: '<?php echo $sucursalDatos->razon_social ?>',
                timbrado: '<?php echo $sucursalDatos->timbrado ?>',
                actividad: `<?php echo $sucursalDatos->actividad ?>`,
                telefonoSucursal: '<?php echo $sucursalDatos->telefono ?>',
                direccion: '<?php echo $sucursalDatos->direccion ?>',
                distrito: '<?php echo $sucursalDatos->distrito_descripcion ?>',
                rucSuc: '<?php echo $sucursalDatos->ruc ?>',
                tipoFactura: 'Factura',
                factura: factura,
                fechaEmision: fecha,
                condicion: condicion,
                rucCliente: rucCliente,
                cambio: cambio,
                razonCliente: cliente,
                moneda: moneda,
                dirCliente: direccion,
                operacion: 'Factura Electrónica',
                telCliente: telefono,
                docAsociado: '',
                cel: '',
                iva10,
                iva5,
                logo,
                host: '<?php echo $sucursalDatos->host ?>',
                port: <?php echo $sucursalDatos->port ?>,
                secure: false,
                user: '<?php echo $sucursalDatos->email ?>',
                pass: '<?php echo $sucursalDatos->pass ?>',
                from: '<?php echo $sucursalDatos->email ?>',
                to: email,
                cdcAsociado: '',
                tipo,
                timbradoVi: '<?php echo $sucursalDatos->fecha_tim ?>',
                vipoVenta: 1,
                itemsVenta
            },

            success: function(dataResult) {

                try {
                    console.log(dataResult)

                    if (dataResult.success) {

                        Swal.fire({
                            title: 'Kude enviado',
                            text: `El correo se envio correctamente a ${email}`,
                            icon: 'success',
                            confirmButtonColor: '#00c853',
                            showDenyButton: true,
                            confirmButtonText: 'Descargar Kude'
                        }).then((result) => {
                            $.ajax({
                                url: 'index.php?action=enviocorreo&id=' + id,
                                type: 'POST',
                                cache: false,
                                dataType: 'json',
                                success: function(json) {


                                },
                                error: function(xhr, status) {
                                    console.log("Ha ocurrido un error.");
                                }
                            });
                            window.location.open(`http://18.208.224.72:3100/kude/${dataResult.file}`)
                            // if (result.isConfirmed) {
                            //     $.ajax({
                            //         url: `http://localhost:3100/kude/${dataResult.file}`,
                            //         type: 'GET',
                            //         cache: false,
                            //         dataType: 'json',
                            //         success: function(json) {


                            //         },
                            //         error: function(xhr, status) {
                            //             console.log("Ha ocurrido un error.");
                            //         }
                            //     });
                            // }
                        })
                    } else {
                        console.log("error")
                        Swal.fire({
                            title: 'Error al enviar correo',
                            icon: 'error',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: `http://localhost:3100/kude/${dataResult.file}`,
                                    type: 'GET',
                                    cache: false,
                                    dataType: 'json',
                                    success: function(json) {


                                    },
                                    error: function(xhr, status) {
                                        console.log("Ha ocurrido un error.");
                                    }
                                });
                            }
                        })
                    }


                } catch (e) {
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