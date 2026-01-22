<?php
$u = null;

if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != ""):
    $u = UserData::getById($_SESSION["admin_id"]);
    require 'core/modules/index/components/kudes.php';

    ?>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
                VENTAS DE EXPORTACIÓN REALIZADAS
            </h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">

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
                                        value="<?php echo isset($_GET['sd']) ? $_GET['sd'] : date('Y-m-d'); ?>"
                                        class="form-control">



                                </div>
                                <div class="col-md-2">
                                    <span>
                                        HASTA:
                                    </span>


                                    <input type="date" name="ed" id="date2" class="form-control"
                                        value="<?php echo isset($_GET['ed']) ? $_GET['ed'] : date('Y-m-d'); ?>">

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
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Nro.</th>
                                    <th width="120px">N° Venta.</th>
                                    <th width="120px">Cliente</th>

                                    <th>Total</th>
                                    <th width="120px">Metodo Pago</th>
                                    <th>Fecha</th>
                                    <th>Cambio</th>
                                    <th>Tipo Moneda</th>
                                    <th>N° de Factura</th>
                                    <th>SIFEN</th>
                                    <th>Xml</th>
                                    <th>Kude</th>
                                    <th>Estado</th>
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
    pagina = 0;
    totalPages = 0

    function buscar() {
        tablab = "";

        $.ajax({
            url: `./index.php?action=listarventasexportacion&cliente=${$("#cliente_id").val()}&desde=${$("#date1").val()}&hasta=${$("#date2").val()}&busqueda=${$("#buscar").val()}&sucursal=<?= $_GET["id_sucursal"] ?>&offset=${pagina * 10}`,
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
                            <td>
                                <abbr title="Enviar a Nota de credito">
                                <a class="btn btn-primary"
                                style="margin-right:2px" 
                                href="index.php?view=nota_credito&id_sucursal=${result.data.sucursal.id_sucursal}&id=${venta.id}">
                                <i class="glyphicon glyphicon-plus-sign"></i></a>
                                </abbr>
                            </td>
                            <td>    
                                <abbr title="Anular registro de venta">
                                <button onclick="anular2(${venta.id})" 
                                class="btn btn-warning btn-sm btn-flat" style="margin-right:2px" ><i class='fa fa-trash'></i> 
                                </button>
                                </abbr>
                            </td>
                            <td>
                                <abbr title="Anular registro de venta con resta de stock">
                                <button onclick="anular(${venta.id})" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> </button></abbr>
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
                            <td >
                                ${venta.facturaRemision}
                            </td>
                            <td >
                                <p class="${venta.envio}">${venta.envio}</p>
                            </td>
                            <td>`;
                    if (venta.envio != 'No enviado') {
                        tablab += `<button class="btn btn-primary" onclick="xml('${venta.xml}')">Descargar</button>`
                    }
                    tablab +=
                        `</td>`
                    tablab +=
                        `<td >`
                    if (venta.envio != 'No enviado') {
                        tablab += `<button class="btn btn-primary" onclick='generarKude(${JSON.stringify(venta.kude)},true)'>Enviar</button>`
                    }
                    if (venta.emailEnviado != '0') {
                        tablab += `<p>Enviado</p>`
                    }
                    tablab += `</td>
                            <td >
                                <p class="${venta.estado}">${venta.estado}</p>
                            </td>
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

    function xml(xml) {
        window.open(`http://18.208.224.72:3000/downloadxml/${xml}`)

    }

    buscar()
</script>