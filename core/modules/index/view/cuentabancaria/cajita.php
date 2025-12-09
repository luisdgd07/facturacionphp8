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
                CUENTA BANCARIA
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

                                    <th>Nro. de Cuenta</th>
                                    <th>Moneda</th>

                                    <th>Importe</th>

                                    <th>Cliente</th>

                                    <th>Acción</th>

                                </thead>
                                <tbody id="tabla">
                                    <?php
                                    $monedas =  MonedaData::versucursalmoneda($_GET['id_sucursal']);
                                    $cuentas = CuentaBancariaData::getByMonedas($monedas[0]->id_tipomoneda, $monedas[1]->id_tipomoneda);
                                    ?>
                                    <?php foreach ($cuentas as $cuenta): ?>
                                        <tr>
                                            <td><?php echo $cuenta->id_cuenta_bancaria ?></td>
                                            <td><?php echo $cuenta->nro_cuenta ?></td>
                                            <td><?php echo MonedaData::VerId($cuenta->id_moneda, $_GET['id_sucursal'])->nombre; ?></td>
                                            <td><?php echo number_format($cuenta->importe, 2, ',', '.') ?></td>
                                            <td><?php
                                          
                                                $detalle = CajaDetalle::obtenerById($cuenta->caja_id);
                                                if($detalle  !=null){
                                                $venta = VentaData::getById($detalle->id_venta);
                                                echo ClienteData::getById($venta->cliente_id)->nombre;
                                                }
                                                ?></td>
                                            <td>
                                                <abbr title="Anular cobro">
                                                    <button onclick="eliminar(<?php echo $cuenta->id_cuenta_bancaria ?>)" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> </button></abbr>
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
            title: 'Desea eliminar cobro?',
            showDenyButton: true,
            confirmButtonText: 'Eliminar',
            denyButtonText: `Cerrar`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href = `./index.php?action=eliminarcuentabancaria&id_sucursal=<?= $_GET['id_sucursal'] ?>&id=${venta}`;

            } else {}
        })
    }
</script>