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
                TARJETA
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
                                    <th>Importe</th>
                                    <th>Moneda</th>

                                    <th>Fecha</th>


                                    <th>Cliente</th>

                                    <th>Acción</th>

                                </thead>
                                <tbody id="tabla">
                                    <?php
                                    $monedas =  MonedaData::versucursalmoneda($_GET['id_sucursal']);
                                    $cuentas = TarjetaCabecera::getByMonedas($monedas[0]->id_tipomoneda, $monedas[1]->id_tipomoneda);
                                    ?>
                                    <?php foreach ($cuentas as $cuenta): ?>
                                        <tr>
                                            <td><?php echo $cuenta->id_tarjeta ?></td>
                                            <td><?php echo number_format($cuenta->importetotal, 2, ',', '.') ?></td>
                                            <td><?php echo MonedaData::VerId($cuenta->moneda_id, $_GET['id_sucursal'])->nombre; ?></td>
                                            <td><?php echo  $cuenta->fecha ?></td>
                                            <td><?php

                                                $caja = CajaCabecera::obtenerById($cuenta->tarjeta_id);
                                                if($caja !=null){

                                                    echo ClienteData::getById($caja->ID_CLIENTE)->nombre;
                                                }
                                                ?></td>
                                            <td>
                                                <abbr title="Anular tarjeta">
                                                    <button onclick="eliminar(<?php echo $cuenta->id_tarjeta ?>)" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> </button></abbr>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function eliminar(venta) {
        Swal.fire({
            title: 'Desea eliminar tarjeta?',
            showDenyButton: true,
            confirmButtonText: 'Eliminar',
            denyButtonText: `Cerrar`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href = `./index.php?action=eliminartarjeta&id_sucursal=<?= $_GET['id_sucursal'] ?>&id=${venta}`;

            } else {}
        })
    }
</script>