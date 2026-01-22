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
                RETENCION
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

                                    <th>Factura</th>
                                    <th>Importe</th>

                                    <th>Fecha</th>



                                    <th>Acción</th>

                                </thead>
                                <tbody id="tabla">
                                    <?php
                                    $retenciones = RetencionDetalleData::getRetencionSucursal($_GET['id_sucursal']);
                                    ?>
                                    <?php foreach ($retenciones as $retencion): ?>
                                        <tr>
                                            <td><?php
                                            echo $retencion->id ?></td>
                                            <td><?php

                                            echo ClienteData::getById($retencion->cliente_id)->nombre;
                                            ?></td>
                                            <td><?php
                                            echo $retencion->factura ?></td>
                                            <td><?php echo number_format($retencion->importe, 2, ',', '.') ?></td>
                                            <td><?php echo $retencion->fecha_auditoria ?></td>
                                            <td>
                                                <abbr title="Anular retencion">
                                                    <button onclick="eliminar(<?php echo $retencion->id ?>)"
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
            title: 'Desea eliminar retencion?',
            showDenyButton: true,
            confirmButtonText: 'Eliminar',
            denyButtonText: `Cerrar`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href = `./index.php?action=eliminarretencion&id_sucursal=<?= $_GET['id_sucursal'] ?>&id=${venta}`;

            } else { }
        })
    }
</script>