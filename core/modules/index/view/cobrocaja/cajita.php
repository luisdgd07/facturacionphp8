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
                COBROS DE CAJA
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
                                    <th>Concepto</th>
                                    <th>Importe</th>
                                    <th>Cambio</th>
                                    <th>Moneda</th>
                                    <th>Caja</th>

                                    <th>Acción</th>

                                </thead>
                                <tbody id="tabla">
                                    <?php
                                    $cajas = CajaDetalle::obtenerSucursal($_GET['id_sucursal']);
                                    ?>
                                    <?php foreach ($cajas as $caja): ?>
                                        <tr>
                                            <td><?= $caja->ID ?></td>
                                            <td><?php

                                            $cabecera = CajaCabecera::obtenerCobroId($caja->COBRO_ID);
                                            if (isset($cabecera)) {
                                                echo ClienteData::getById($cabecera->ID_CLIENTE)->nombre;
                                            }
                                            // var_dump($cabecera);
                                            // ClienteData::getById($cabecera->ID_CLIENTE)->nombre 
                                            ?>
                                            </td>
                                            <td><?php

                                            if (isset($cabecera)) {
                                                echo $cabecera->FECHA;
                                            }
                                            ?></td>
                                            <td><?php
                                            if (isset($cabecera)) {
                                                echo $cabecera->concepto;
                                            }
                                            ?>
                                            </td>
                                            <td><?= number_format($caja->IMPORTE, 2, ',', '.') ?></td>
                                            <td><?= number_format($caja->CAMBIO, 2, ',', '.') ?></td>
                                            <td><?php
                                            if (isset($caja->id_venta)) {
                                                $venta = VentaData::getById($caja->id_venta);
                                                if (isset($venta->tipomoneda_id)) {
                                                    echo MonedaData::VerId($venta->tipomoneda_id, $_GET['id_sucursal'])->nombre;
                                                }
                                            }
                                            ?></td>

                                            <td><?php
                                            $cod = $caja->CAJA;
                                            if ($cod == 1) {
                                                echo "Efectivo";
                                            }
                                            if ($cod == 2) {
                                                echo "Tarjeta de credito";
                                            }
                                            if ($cod == 3) {

                                                echo "Tarjeta de debito";
                                            }
                                            if ($cod == 4) {
                                                echo "Transferencia";
                                            }
                                            if ($cod == 5) {
                                                echo "cheque";
                                            }
                                            if ($cod == 6) {
                                                echo "Otro";
                                            }
                                            ?></td>
                                            <td>
                                                <abbr title="Anular cobro">
                                                    <button onclick="eliminar(<?= $caja->COBRO_ID ?>)"
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
<script >
    function eliminar(venta) {
        Swal.fire({
            title: 'Desea eliminar caja?',
            showDenyButton: true,
            confirmButtonText: 'Eliminar',
            denyButtonText: `Cerrar`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href = `./index.php?action=eliminarcobro&id_sucursal=<?= $_GET['id_sucursal'] ?>&id=${venta}`;

            } else {}
        })
    }
</script>