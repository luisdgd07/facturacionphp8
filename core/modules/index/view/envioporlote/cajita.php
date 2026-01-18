<?php
$u = null;

if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != ""):
    $u = UserData::getById($_SESSION["admin_id"]);
    // require 'core/modules/index/components/kudes.php';
    $sucursal = new SuccursalData();

    $sucursalDatos = $sucursal->VerId($_GET['id_sucursal']);
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
                VENTAS REALIZADAS
            </h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <button onclick="enviar()" class="btn btn-primary">Enviar ventas a SIFEN </button>
                                </div>
                            </div>
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
                                    </select>
                                </div>
                                <div class="col-md-2">

                                    <span>
                                        DESDE:
                                    </span>
                                    <input type="date" name="sd" id="date1" class="form-control">



                                </div>
                                <div class="col-md-2">
                                    <span>
                                        HASTA:
                                    </span>


                                    <input type="date" name="ed" id="date2" class="form-control">

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
                                    <th width="120px">Metodo Pago</th>
                                    <th>Fecha de Venta</th>
                                    <th>Cambio</th>
                                    <th>Tipo Moneda</th>
                                    <th>Envio a SIFEN</th>

                                    <th>Correo</th>

                                    <th>Kude</th>
                                    <th>xml</th>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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


    function xml(xml) {
        window.open(`http://18.208.224.72:3000/downloadxml/${xml}`)

    }
    pagina = 0;
    totalPages = 0

    function buscar() {
        tablab = "";

        $.ajax({
            url: `./index.php?action=listarventas&cliente=${$("#cliente_id").val()}&desde=${$("#date1").val()}&hasta=${$("#date2").val()}&busqueda=${$("#buscar").val()}&sucursal=<?= $_GET["id_sucursal"] ?>&offset=${pagina * 10}`,
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
                                ${venta.metodoPago}
                            </td>
                            <td >
                                ${venta.fecha}
                            </td>
                            <td >
                                ${venta.cambio}
                            </td>
                            <td >
                                ${venta.moneda.nombre}
                            </td>
                        
                            <td>`;

                    tablab += `<p class="${venta.envio}">${venta.envio}</p>`

                    if (venta.envio != 'Aprobado') {
                        tablab += `<input type="checkbox" `
                        if (ventas.includes(parseInt(venta.id))) {
                            tablab += `checked`
                        }
                        tablab += ` id="${venta.id}" onchange='agregarLote(${JSON.stringify(venta.enviar)},${venta.id},${JSON.stringify(venta.kude)})'>`
                    }
                    tablab +=
                        `</td>
                            <td >`;



                    if (venta.envio != 'No enviado') {
                        let textoEnvio = venta.emailEnviado && venta.emailEnviado == 1 ? 'Reenviar' : 'Enviar';
                        tablab += `<button class="btn btn-primary" onclick='generarKude(${JSON.stringify(venta.kude)},true)'>${textoEnvio}</button>`
                    }



                    if (venta.emailEnviado != '0') {
                        tablab += `<p>Enviado</p>`
                    } else {
                        tablab += `<p>No Enviado</p>`
                    }
                    tablab +=
                        `</td>
                            <td >`;
                    if (venta.envio != 'No enviado') {
                        tablab += `<a class="btn btn-primary" href="./kudes/kude.php?venta=${venta.id}">Descargar</a>`
                    }
                    tablab +=
                        `</td>
                            <td >`;
                    if (venta.envio != 'No enviado') {
                        tablab += `<button class="btn btn-primary" onclick="xml('${venta.xml}')">Descargar</button>`
                    } else {
                        tablab += `<p>No Enviado</p>`
                    }
                    tablab +=
                        `</td>
                            <td >`;

                    if (venta.envio == 'Aprobado') {
                        tablab += `<button class="btn btn-warning" onclick="cancelar('${venta.kude.cdc}',${venta.id})">Cancelar</button>`
                    } else {
                        tablab += `<p>No Enviado</p>`
                    }
                    tablab +=
                        `</td>
                            <td >`;
                    tablab += `</td>
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
        // let cert = '../facturacionElectronica<?php echo $sucursalDatos->certificado_url ?>';
        //let cert = './facturacionElectronica<?php echo $sucursalDatos->certificado_url ?>';
        // let cert = '.<?php echo $sucursalDatos->certificado_url ?>';
        let cert = '<?php echo $sucursalDatos->certificado_url ?>';
        console.log(cert);

        datosCert = JSON.stringify(data1)
        $.ajax({
            url: "http://18.208.224.72:3000/enviarlote",

            //url: "http://localhost:3000/enviarlote",
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
                        consultaLote(lote, 'venta');
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
</script>