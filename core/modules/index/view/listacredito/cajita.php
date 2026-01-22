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
                Lista de Créditos
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

                                    <th>Fecha</th>
                                    <th>Vencimiento</th>
                                    <th>Concepto</th>
                                    <th>Crédito</th>
                                    <th>Saldo</th>

                                    <th>Moneda</th>

                                    <th>Cliente</th>


                                    <th>Id venta</th>
                                    <th>Acción</th>

                                </thead>
                                <tbody id="tabla">
                                    <?php
                                    $credito = CreditoDetalleData::getBySucursal($_GET['id_sucursal']);
                                    ?>
                                    <?php foreach ($credito as $c): ?>
                                        <tr>
                                            <td><?= $c->id ?></td>
                                            <td><?= $c->fecha ?></td>
                                            <td><?php

                                            $cabecera = CreditoData::getById($c->credito_id);
                                            echo $cabecera->vencimiento ?></td>
                                            <td><?= $cabecera->concepto ?></td>
                                            <td><?= $cabecera->credito ?></td>



                                            <td>
                                                <?= number_format($c->saldo_credito, 2, ',', '.') ?>
                                            </td>
                                            <td><?php
                                            echo MonedaData::VerId($c->moneda_id, $_GET['id_sucursal'])->nombre;
                                            ?>
                                            </td>
                                            <td>
                                                <?= ClienteData::getById($c->cliente_id)->nombre ?>
                                            </td>
                                            <td>
                                                <?= $cabecera->venta_id ?>
                                            </td>
                                            <td>
                                                <abbr title="Anular cobro">
                                                    <button onclick="eliminar(<?= $c->credito_id ?>)"
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
            title: 'Desea eliminar credito?',
            showDenyButton: true,
            confirmButtonText: 'Eliminar',
            denyButtonText: `Cerrar`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href = `./index.php?action=eliminarcredito&id_sucursal=<?= $_GET['id_sucursal'] ?>&id=${venta}`;

            } else { }
        })
    }
</script>