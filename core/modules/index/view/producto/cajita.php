<?php
$u = null;

if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
    $u = UserData::getById($_SESSION["admin_id"]);
    require 'core/modules/index/components/kudes.php';

?>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
                PRODUCTOS
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

                                <div class="col-md-2" style="margin-top: 20px;">
                                    <button class="btn btn-success" onclick="buscar()">Buscar</button>

                                </div>


                                <br>
                            </div>
                            <table class="table table-bordered table-hover  " style="margin-top: 30px;">

                                <thead>
                                    <th>
                                        Codigo
                                    </th>
                                    <th>
                                        Descripción
                                    </th>

                                    <th>
                                        Prec. Compra
                                    </th>

                                    <th>
                                        Estado
                                    </th>
                                    <th>
                                        Acción
                                    </th>
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

            } else {}
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
            } else {}
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
            } else {}
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
            url: "index.php?action=buscartodosproducto",
            type: "GET",
            data: {
                buscar: $('#buscar').val(),
                sucursal: <?= $_GET["id_sucursal"] ?>,
                offset: pagina * 5
            },
            cache: false,
            success: function(dataResult) {
                console.log(dataResult);
                var result = JSON.parse(dataResult);
                totalPages = result.pages
                pagination()

                for (const [key, producto] of Object.entries(result.result)) {
                    tablab +=
                        `<tr>
                            <td >
                                ${producto.codigo}
                            </td>
                            <td >
                                ${producto.nombre}
                            </td>
                            <td >
                                ${producto.precio_compra}
                            </td>
                            <td width="40px">
                            `;
                    if (producto.activo == 1) {
                        tablab += `<i class="fa fa-check"></i>`
                    } else {
                        tablab += `<i class="fa fa-close"></i>`
                    }

                    tablab += `
                        </td>
                        <td style="width:150px;">
                                <a href="index.php?view=actualizarproducto1&id_sucursal=<?= $_GET["id_sucursal"] ?>&id_producto=${producto.id_producto}" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cog"></i> Editar</a>
                                <a href="index.php?action=eliminarproducto1&id_sucursal=<?= $_GET["id_sucursal"] ?>&id_producto=${producto.id_producto}" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> Eliminar</a>
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
    buscar()
</script>