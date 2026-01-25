<?php
$u = null;

if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != ""):
    $u = UserData::getById($_SESSION["admin_id"]);
    $sucursal = new SuccursalData();
    $sucursalDatos = $sucursal->VerId($_GET['id_sucursal']);
    ?>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
                ENVIO REMISIÓN
            </h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <button onclick="enviar()" class="btn btn-primary">Enviar Nota de Remision a SIFEN</button>

                            <br>
                            <div class="row" style="margin-top: 14px">

                                <div class="col-md-3">
                                    <span>
                                        BUSCAR:
                                    </span>
                                    <input type="text" class="form-control" placeholder="Buscar" id="buscar">

                                </div>
                                <div class="col-md-3">
                                    <span>
                                        CLIENTE:
                                    </span>

                                    <select id="cliente_id" class="form-control">
                                        <option value="todos">Todos</option>
                                        <?php
                                        $clients = ClienteData::verclientessucursal($_GET['id_sucursal']);
                                        foreach ($clients as $client):
                                            if ($client->id_cliente == $venta->cliente_id) { ?>
                                                <option selected value="<?php echo $client->id_cliente; ?>">
                                                    <?php echo $client->dni . " - " . $client->nombre . " " . $client->apellido . " - " . $client->tipo_doc; ?>
                                                </option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?php echo $client->id_cliente; ?>">
                                                    <?php echo $client->dni . " - " . $client->nombre . " " . $client->apellido . " - " . $client->tipo_doc; ?>
                                                </option>
                                            <?php }
                                        endforeach;

                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2">

                                    <span>
                                        DESDE:
                                    </span>
                                    <input type="date" name="sd" id="date1"
                                        value="<?php echo isset($_GET['sd']) ? $_GET['sd'] : date('Y-m-d') ?>"
                                        class="form-control">



                                </div>
                                <div class="col-md-2">
                                    <span>
                                        HASTA:
                                    </span>


                                    <input type="date" name="ed" id="date2" class="form-control"
                                        value="<?php echo isset($_GET['ed']) ? $_GET['ed'] : date('Y-m-d') ?>">

                                </div>
                                <div class="col-md-2" style="margin-top: 20px;">
                                    <button class="btn btn-success" onclick="buscar()">Buscar</button>

                                </div>

                                <script type="text/javascript">
                                    function obtenerFechaActual() {
                                        var n = new Date();
                                        var y = n.getFullYear();
                                        var m = n.getMonth() + 1;
                                        var d = n.getDate();
                                        return y + "-" + (m > 9 ? m : "0" + m) + "-" + (d > 9 ? d : "0" + d);
                                    }


                                    $("#date1").val(obtenerFechaActual());
                                    $("#date2").val(obtenerFechaActual());
                                </script>


                                <br>
                            </div>
                            <table class="table table-bordered table-hover  " style="margin-top: 30px;">

                                <thead>
                                    <th></th>
                                    <th>Nro.</th>
                                    <th width="120px">N° Factura</th>
                                    <th width="120px">Cliente</th>
                                    <th>Total</th>
                                    <th>Fecha de Remision</th>
                                    <th>Cajas</th>
                                    <th>Tipo Moneda</th>
                                    <th>Envio a SIFEN</th>
                                    <th>Xml</th>
                                    <th>Kude</th>
                                    <th>Kude</th>
                                    <th>Cancelar</th>
                                </thead>
                                <tbody id="tabla">
                                </tbody>
                            </table>
                            <div id="paginacion"></div>


                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php endif ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<?php
require 'core/modules/index/components/kudes.php';

?>
<script>
    function eliminar(venta) {
        Swal.fire({
            title: 'Desea eliminar esta venta?',
            showDenyButton: true,
            confirmButtonText: 'Eliminar',
            denyButtonText: `Cerrar`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href = `./index.php?action=eliminarcompra&id_sucursal=<?= $_GET['id_sucursal'] ?>&id_venta=${venta}`;

            } else { }
        })
    }

    function anular(venta) {
        Swal.fire({
            title: 'Desea anular este registro',
            showDenyButton: true,
            confirmButtonText: 'Anular',
            denyButtonText: `Cerrar`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href = `./index.php?action=actualizar_estado_venta&id_sucursal=<?= $_GET['id_sucursal'] ?>&id_venta=${venta}`;
            } else { }
        })

    }


    function anular2(venta) {
        Swal.fire({
            title: 'Desea anular este registro',
            showDenyButton: true,
            confirmButtonText: 'Anular',
            denyButtonText: `Cerrar`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href = `./index.php?action=actualizar_estado_venta2&id_sucursal=<?= $_GET['id_sucursal'] ?>&id_venta=${venta}`;
            } else { }
        })

    }

    function impresion(venta, sucursal) {
        if (sucursal == 20) {
            window.open(`./impresion2.php?id_venta=${venta}`)
        }
        if (sucursal == 21) {
            window.open(`./impresion2_2.php?id_venta=${venta}`)
        } else {
            window.open(`./impresion.php?id_venta=${venta}`)

        }
    }

    function editarPlacas(remision) {
        window.location.href = `index.php?view=editarplacas&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&id=${remision}`

    }
    pagina = 0;
    totalPages = 0

    function buscar() {
        tablab = "";

        $.ajax({
            url: `./index.php?action=listarremisiones&cliente=${$("#cliente_id").val()}&desde=${$("#date1").val()}&hasta=${$("#date2").val()}&busqueda=${$("#buscar").val()}&sucursal=<?= $_GET["id_sucursal"] ?>&offset=${pagina * 10}`,
            type: "GET",
            data: {},
            cache: false,
            success: function (dataResult) {
                var result = JSON.parse(dataResult);
                totalPages = result.pages
                pagination()

                for (const [key, venta] of Object.entries(result.data.venta)) {
                    tablab +=
                        `<tr>
                            <td>
                                <abbr title="ver detalles">
                                <a 
                                href="index.php?view=detalleventaproducto&id_venta=${venta.id}" 
                                class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open" 
                                style="color: orange;margin-right:2px">
                                </i>
                                </a>
                                </abbr>
                            </td>
                            <td >
                                ${venta.id}
                            </td>
                            <td >
                                ${venta.factura}
                            </td>
                            <td >
                                ${venta.cliente.nombre} ${venta.cliente.apellido}
                            </td>
                            <td >
                                ${venta.total}
                            </td>
                            <td >
                                ${venta.fecha}
                            </td>
                            <td >
                                ${venta.cajas}
                            </td>
                            <td >
                                ${venta.moneda.nombre}
                            </td>
                            <td >
                                <p class="${venta.envio}">${venta.envio}</p>
                            `;
                    if (venta.envio != 'Aprobado') {
                        tablab += `<input type="checkbox" `
                        if (ventas.includes(parseInt(venta.id))) {
                            tablab += `checked`
                        }
                        tablab += ` id="${venta.id}" onchange='agregarLote(${JSON.stringify(venta.enviar)},${venta.id},${JSON.stringify(venta.kude)})'>`
                    }
                    `
                            </td>
                            
                            <td >
                                <p class="${venta.envio}">${venta.envio}</p>
                            </td>
                        
                            <td>`;
                    // if (venta.envio != 'No enviado') {
                    //     tablab += `<button class="btn btn-primary" onclick='generarKude(${JSON.stringify(venta.kude)},true)'>Enviar</button>`
                    // }
                    tablab +=
                        `</td>
                            <td >`
                    if (venta.envio != 'No enviado') {
                        tablab += `<button class="btn btn-primary" onclick="xml('${venta.xml}')">Descargar</button>`
                    }
                    tablab +=
                        `</td>
                            <td >`
                    if (venta.envio != 'No enviado') {
                        tablab += `<a class="btn btn-primary" href="./kudes/kude.php?remision=${venta.id}" target="_blank">Descargar</a>`
                    }
                    tablab +=
                        `</td>
                        <td >`
                    let textoEnvio = venta.emailEnviado && venta.emailEnviado == 1 ? 'Reenviar' : 'Enviar';
                    tablab += `<button class="btn btn-primary" onclick='enviarCorreoPHP(${venta.id})'>${textoEnvio}</button>`
                    tablab += `</td>
                        <td>`
                    if (venta.envio == 'Aprobado') {
                        tablab += `<button class="btn btn-warning" onclick="cancelar('${venta.kude.cdc}',${venta.id})">Cancelar</button>`
                    }
                    tablab += `
                            <td>
                        <tr>    
                        `;
                }

                $("#tabla").html(tablab);
            }
        });
    }

    function getPage(newPage) {
        pagina = newPage
        buscar()
    }


    function pagination() {
        const limit = 25;
        const currentPage = pagina;

        paginacion = `<nav aria-label="...">
                  <ul class="pagination">
                  `;

        const startPage = Math.floor(currentPage / limit) * limit;
        const endPage = Math.min(startPage + limit, totalPages);

        if (currentPage > 0) {
            paginacion += `<li class="page-item"><a class="page-link" onclick="getPage(${currentPage - 1})">&laquo;</a></li>`;
        }

        for (let i = startPage; i < endPage; i++) {
            paginacion += `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" onclick="getPage(${i})">${i + 1}</a></li>`;
        }

        if (currentPage < totalPages - 1) {
            paginacion += `<li class="page-item"><a class="page-link" onclick="getPage(${currentPage + 1})">&raquo;</a></li>`;
        }

        paginacion += `
                  </ul>
                </nav>`;
        $("#paginacion").html(paginacion);
    }
    buscar()



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
        let cert = '<?php echo $sucursalDatos->certificado_url ?>';
        console.log(cert);

        datosCert = JSON.stringify(data1)
        $.ajax({

            url: "http://18.208.224.72:3000/enviarlote",
            //  url: "http://localhost:3000/enviarlote",
            type: "POST",
            data: {
                datos: datos2,
                env: '<?php echo $sucursalDatos->entorno ?>',
                cert: cert,
                logo: "./METASA_logo.png",
                pass: '<?php echo $sucursalDatos->clave ?>',
                data1: datosCert,
                tipo: 7,
                descripcion: 'remision',
                qr: '<?php echo $sucursalDatos->qr_envio ?>',
                id: '<?php echo $sucursalDatos->id_envio ?>'
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
                        consultaLote(lote, 'remision');
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
    function enviarCorreoPHP(id_venta) {
        Swal.fire({
            title: 'Enviando correo...',
            didOpen: () => {
                Swal.showLoading()
            }
        });

        $.ajax({
            url: `index.php?action=send_email_php&remision=${id_venta}&sucursal=<?php echo $_GET['id_sucursal'] ?>`,
            type: "POST",
            data: {},
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Correo Enviado',
                        text: response.message,
                        icon: 'success'
                    }).then(() => {
                        buscar(); // Recargar la tabla
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: 'Error de servidor',
                    text: 'No se pudo enviar el correo. Verifique la consola para detalles.',
                    icon: 'error'
                });
            }
        });
    }
    function xml(xml) {
        window.open(`http://18.208.224.72:3000/downloadxml/${xml}`)

    }
</script>