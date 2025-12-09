<?php
$u = null;

if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
    $u = UserData::getById($_SESSION["admin_id"]);
?>
    <?php if ($u->is_empleado) : ?>
        <?php
        $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
        ?>



        <div class="content-wrapper">
            <section class="content-header">
                <h1> <i class="fa fa-cubes"></i>
                    Reporte de productos
                    <small> </small>
                </h1>
            </section>
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <div class="panel-body">
                            <form>
                                <input type="hidden" name="view" value="estadodecuenta">
                                <div class="row">


                                    <div class="col-md-3">



                                        <select required="" name="categoria" class="form-control">

                                            <option value="todos">Todas la categorias</option>
                                            <?php $clientes = CategoriaData::vercategoriassucursal($sucursales->id_sucursal);
                                            if (count($clientes) > 0) {
                                                foreach ($clientes as $p) : ?>
                                                    <option value="<?php echo $p->id_categoria; ?>"><?php echo $p->nombre; ?></option>
                                            <?php endforeach;
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" name="sd" id="sd" value="<?php if (isset($_GET["sd"])) {
                                                                                        echo $_GET["sd"];
                                                                                    } ?>" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" name="ed" id="ed" value="<?php if (isset($_GET["ed"])) {
                                                                                        echo $_GET["ed"];
                                                                                    } ?>" class="form-control">
                                    </div>





                                    <script type="text/javascript">
                                        function obtenerFechaActual() {
                                            n = new Date();
                                            y = n.getFullYear();
                                            m = n.getMonth() + 1;
                                            d = n.getDate();
                                            return y + "-" + (m > 9 ? m : "0" + m) + "-" + (d > 9 ? d : "0" + d)
                                        }

                                        //inicializar las fechas del reporte
                                        $("#sd").val(obtenerFechaActual());
                                        $("#ed").val(obtenerFechaActual());
                                    </script>

                                    <div class="col-md-3">
                                        <input type="submit" class="btn btn-success btn-block" value="Procesar">
                                        <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">

                                    </div>
                                </div>
                            </form>
                            <?php if (isset($_GET["sd"]) && isset($_GET["ed"])) : ?>
                                <?php if ($_GET["sd"] != "" && $_GET["ed"] != "") : ?>
                                    <?php
                                    $operations = array();

                                    if ($_GET["product"] == "") {
                                        $operations = OperationData::verTransacciones3($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
                                    } else {
                                        $operations = OperationData::verTransacciones2($_GET["product"], $_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
                                    }
                                    $estados = array();

                                    $numero = 0;
                                    foreach ($operations as $sell) :


                                    ?>
                                        <br>
                                        <form class="form-horizontal" enctype="multipart/form-data" method="post" action="index.php?action=cobranzacredito" role="form">


                                            <input type="hidden" name="factura" id="num1">
                                            <input type="hidden" name="numeracion_inicial" id="numinicio">
                                            <input type="hidden" name="numeracion_final" id="numfin">
                                            <input type="hidden" name="serie1" id="serie">



                                            <div class="col-md-12">


                                                <?php

                                                ?>

                                                <table id="example1" class="table table-bordered table-hover table-responsive ">
                                                    <thead>
                                                        <th style="width: 50px !important;">Codigo</th>
                                                        <th style="width: 50px;">Producto</th>
                                                        <th style="width: 50px;">Stock Anterior</th>
                                                        <th style="width: 50px;">Cantidad</th>
                                                        <th style="width: 50px;">Stock Actual</th>
                                                        <th style="width: 50px;">Motivo</th>

                                                        <th style="width: 50px;">Tipo Transaccion</th>

                                                        <th style="width: 50px;">Deposito</th>

                                                        <th style="width: 50px;">Categoria</th>

                                                        <th style="width: 50px;">Fecha</th>

                                                    </thead>
                                                    <?php
                                                    $sumatotal = 0;
                                                    $suma = 0;



                                                    ?>
                                                    <tr>


                                                        <td>

                                                            <input style="width: 70px;" type="text" name="credito[]" value="<?= $sell->getProducto()->codigo;; ?>" class="form-control">
                                                        </td>

                                                        <td>

                                                            <input style="width: 70px;" type="text" name="credito[]" value="<?= $sell->getProducto()->nombre; ?>" class="form-control">
                                                        </td>
                                                        <td>

                                                            <input style="width: 70px;" type="text" name="credito[]" value="<?= $sell->stock_trans; ?>" class="form-control">
                                                        </td>

                                                        <input style="width: 70px;" type="text" name="credito[]" value="<?= $sell->q;  ?>" class="form-control">
                                                        </td>

                                                        <?php
                                                        if ($sell->getAccion()->nombre == 'entrada') {
                                                        ?>



                                                            <td>

                                                                <input style="width: 70px;" type="text" name="credito[]" value="<?php echo $sell->stock_trans + $sell->q; ?>" class="form-control">
                                                            </td>


                                                        <?php
                                                        } else {

                                                        ?>



                                                            <td>

                                                                <input style="width: 70px;" type="text" name="credito[]" value="<?php echo $sell->stock_trans - $sell->q; ?>" class="form-control">
                                                            </td>


                                                        <?php
                                                        }
                                                        ?>




                                                        <td>

                                                            <input style="width: 70px;" type="text" name="credito[]" value="<?= $sell->motivo; ?>" class="form-control">
                                                        </td>
                                                        <td>

                                                            <input style="width: 70px;" type="text" name="credito[]" value="<?= $sell->getAccion()->nombre; ?>" class="form-control">
                                                        </td>
                                                        <td>

                                                            <input style="width: 70px;" type="text" name="credito[]" value="<?= $sell->fecha; ?>" class="form-control">
                                                        </td>




                                                    </tr>

                                                    <!-- <tr>
                              <td> </td>

                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr> -->
                                                    <?php


                                                    ?>


                                                <?php





                                            endforeach; ?>

                                                </table>
                                                <br>
                                                <hr>


                                                <div class="row">
                                                    <div class="col-lg-2">


                                                        <h3>Total: <?php echo  number_format($total, 2, ',', ' '); ?></h3>



                                                    </div>


                                                </div>




                                                <div class="row">



                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail1" class="col-lg-2 control-label">De Fecha:</label>
                                                    <div class="col-lg-2">
                                                        <input type="date" class="form-control" name="direccion" id="direccion" value="<?php echo $_GET["sd"]; ?>">
                                                    </div>
                                                    <label for="inputEmail1" class="col-lg-2 control-label">A Fecha:</label>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $_GET["ed"]; ?>">
                                                    </div>

                                                </div>
                                            <?php else :
                                            // si no hay operaciones
                                            ?>
                                                <script>
                                                    $("#wellcome").hide();
                                                </script>
                                                <div class="jumbotron">
                                                    <h2>No hay registro de cuotas pendientes a cobrar</h2>
                                                    <p>El rango de fechas seleccionado no proporciono ningun resultado.</p>
                                                </div>

                                            <?php endif; ?>
                                        <?php else : ?>
                                            <script>
                                                $("#wellcome").hide();
                                            </script>
                                            <div class="jumbotron">
                                                <h2>Fecha Incorrectas</h2>
                                                <p>Puede ser que no selecciono un rango de fechas, o el rango seleccionado es incorrecto.</p>
                                            </div>
                                            </div>







                                        </form>
                                    <?php endif; ?>

                                <?php endif; ?>

                        </div>
                    </div>
                </div>
            </section>
        </div>

    <?php endif ?>