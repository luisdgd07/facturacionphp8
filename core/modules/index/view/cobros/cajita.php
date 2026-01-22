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
                COBROS
            </h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">

                            <br>

                            <table id="example1" class="table table-bordered table-dark" style="width:100%">

                                <thead>

                                    <th>Nro.</th>

                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Cuota</th>
                                    <th>Factura</th>
                                    <th>Moneda</th>
                                    <th>Importe</th>


                                    <th>Acción</th>

                                </thead>
                                <tbody id="tabla">
                                    <?php
                                    $cobros = CobroDetalleData::cobranza($_GET['id_sucursal']);
                                    ?>
                                    <?php foreach ($cobros as $cobro): ?>
                                        <tr>
                                            <td><?php echo $cobro->id ?></td>
                                            <td><?php
                                            echo ClienteData::getById($cobro->CLIENTE_ID)->nombre;
                                            ?></td>

                                            <td><?php
                                            $cabecera = CobroCabecera::getCobro($cobro->COBRO_ID);
                                            echo $cabecera->FECHA_COBRO ?></td>
                                            <td><?php echo $cobro->CUOTA ?></td>
                                            <td><?php echo $cobro->NUMERO_FACTURA ?></td>
                                            <td><?php echo MonedaData::VerId($cabecera->MONEDA_ID, $_GET['id_sucursal'])->nombre; ?>
                                            </td>
                                            <td><?php echo

                                                number_format($cobro->IMPORTE_COBRO, 2, ',', '.')
                                                ?></td>
                                            <td>
                                                <abbr title="Anular cobro">
                                                    <button onclick="eliminar(<?php echo $cobro->id ?>)"
                                                        class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i>
                                                    </button></abbr>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>



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
            title: 'Desea eliminar cobro?',
            showDenyButton: true,
            confirmButtonText: 'Eliminar',
            denyButtonText: `Cerrar`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href = `./index.php?action=eliminarcobrodetalle&id_sucursal=<?= $_GET['id_sucursal'] ?>&id=${venta}`;

            } else { }
        })
    }
</script>