<?php
$sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
            Lista de Retenciones realizadas
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <?php
                            $users = RetencionData::totalretenciones($sucursales->id_sucursal);
                            var_dump($users);
                            //if(count($users)>0){


                            ?>
                            <table id="example1" class="table table-bordered table-dark" style="width:100%">
                                <thead>
                                    <th></th>
                                    <th>Nro.</th>
                                    <th width="120px">Factura</th>
                                    <th>Total Factura</th>
                                    <th>Tipo de Retencion</th>
                                    <th>Nro de Retencion</th>
                                    <th>Timbrado</th>
                                    <th>Fecha de Edición</th>
                                    <th>Fecha de Retención</th>
                                    <th>Estado</th>
                                    <th>Editar</th>


                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($users as $sell) {
                                        if ($sell) {
                                    ?>
                                            <tr>
                                                <?php
                                                // $operations = CobroDetalleData::totalcobrosdet($sell->COBRO_ID );
                                                //count($operations);

                                                ?>

                                                <td style="width:30px;">
                                                    <a href="index.php?view=detalleretencion&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open" style="color: orange;"></i></a>
                                                </td>
                                                <td><?php
                                                    echo $sell->id;

                                                    ?></td>
                                                <td class="width:30px;">

                                                    <?php echo $sell->factura; ?>

                                                </td>
                                                <td><?php
                                                    echo $sell->importe
                                                    ?></td>
                                                <td><?php
                                                    echo $sell->tipo
                                                    ?></td>
                                                <td><?php echo $sell->retencion; ?></td>
                                                <td>
                                                    <?php echo $sell->numero_timbrado; ?>
                                                </td>
                                                <td>
                                                    <?php echo $sell->fecha; ?>
                                                </td>
                                                <td><?php echo $sell->fecha_auditoria; ?></td>
                                                <td>

                                                    <?php if ($sell->anulado == 1) {
                                                        echo '<p class="bg-danger text-white text-center">Anulado</p>';
                                                    } else if ($sell->anulado == 0) {
                                                        echo
                                                        '<p class="bg-success text-white text-center">Activo</p>';
                                                    } ?>
                                                </td>
                                                <td>
                                                    <a href="index.php?view=editaretenciones&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&id=<?php echo $sell->id ?>" class="btn btn-warning">Editar</a>
                                                </td>






                                            </tr>
                                    <?php
                                        }
                                    }
                                    // }else{
                                    // echo "<p class='alert alert-danger'>No hay cobro realizado</p>";
                                    //}
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>