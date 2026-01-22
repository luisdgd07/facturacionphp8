<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<?php
$u = null;
if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != ""):
    $u = UserData::getById($_SESSION["admin_id"]);
    ?>
    <!-- Content Wrapper. Contains page content -->
    <?php if ($u->is_admin): ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
                    VENTAS REALIZADAS
                </h1>
            </section>
            <!-- Main content -->
            <section class="content">
            </section>
        </div>
    <?php endif ?>
    <?php if ($u->is_empleado): ?>
        <?php

        $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
        ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
                    REGISTRO DE VENTAS
                </h1>

            </section>

            <!-- Main content -->

            <div class="row">
                <section class="content">

                    <div class="col-xs-12">
                        <div class="box">
                            <div class="row">
                                <div class="col-md-6">
                                    <select name="tipofactura" id="tipofactura" class="form-control">

                                        <option value="todos">Todas las formas de pago</option>
                                        <option value="contado">contado</option>
                                        <option value="credito">credito</option>

                                    </select>


                                </div>
                                <div class="col-md-6">

                                    <select name="product" id="product" class="form-control">


                                        <option value="todos">Todos los productos</option>
                                        <?php $products = ProductoData::getAll($_GET['id_sucursal']);
                                        if (count($products) > 0) {
                                            foreach ($products as $p): ?>
                                                <option value="<?php echo $p->id_producto; ?>"><?php echo $p->nombre ?></option>
                                            <?php endforeach;
                                        } ?>

                                    </select>

                                </div>
                            </div>





                            <div class="row" style="margin-top: 14px">
                                <div class="col-md-3">

                                    <select name="cliente_id" id="cliente_id" class="form-control">


                                        <option value="todos">Todos los clientes</option>
                                        <?php $clientes = ClienteData::verclientessucursal($sucursales->id_sucursal);
                                        if (count($clientes) > 0) {
                                            foreach ($clientes as $p): ?>
                                                <option value="<?php echo $p->id_cliente; ?>">
                                                    <?php echo $p->nombre . " " . $p->apellido; ?></option>
                                            <?php endforeach;
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">

                                    <span>
                                        DESDE:
                                    </span>
                                    <input type="date" name="sd" id="date1" value="" class="form-control">



                                </div>
                                <div class="col-md-4">
                                    <span>
                                        HASTA:
                                    </span>


                                    <input type="date" name="ed" id="date2" value="" class="form-control">

                                    <input type="hidden" style="display: none;" name="id_sucursal" id="id_sucursal"
                                        value="<?php echo $sucursales->id_sucursal; ?>">
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
                                    $("#date1").val(obtenerFechaActual());
                                    $("#date2").val(obtenerFechaActual());
                                </script>





                            </div>



                            <div style="margin: 15px">
                                <button onclick="exportar3()" href="" class="mx-4 my-2 btn btn-success">Ver reportes</button>
                                <button onclick="exportar()" href="" class="mx-4 my-2 btn btn-success">Generar PDF</button>
                                <button onclick="exportar2()" href="" class="mx-4 my-2 btn btn-success">Generar Excel</button>

                            </div>

                            <?php if (isset($_GET["sd"])) {
                                ?>
                                <?php

                                $date1 = $_GET["sd"];
                                $date2 = $_GET["ed"];

                                $sucurs = $_GET["id_sucursal"];
                                if ($_GET["prod"] == "todos") {
                                    $ops = OperationData::getByProductoId2($_GET["id_sucursal"], $_GET["sd"], $_GET["ed"]);
                                } else {
                                    $ops = OperationData::getByProductoId($_GET["id_sucursal"], $_GET["prod"], $_GET["sd"], $_GET["ed"]);
                                }
                                // echo $ops;
                                //$sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
                                $operations = array();
                                $cantidad = array();
                                // var_dump($ops);
                                if (count($ops) > 0) {
                                    foreach ($ops as $op) {
                                        // var_dump()
                                        $d = VentaData::getId($op->venta_id);
                                        if ($_GET['cliente'] == 'todos') {
                                            if ($d->cliente_id !== NULL) {
                                                array_push($operations, VentaData::getId($op->venta_id));
                                                array_push($cantidad, $op->q);
                                            }
                                        } else if ($d->cliente_id == $_GET['cliente']) {
                                            array_push($operations, VentaData::getId($op->venta_id));
                                            array_push($cantidad, $op->q);
                                        }
                                        // $operations = VentaData::getId($op->venta_id);
                                    }
                                } else {
                                    echo "No hay Ventas";
                                }
                                $total = 0;
                                $totall = 0;
                                if (count($ops) > 0) {
                                    ?>
                                    <h1>Libro ventas del <?php echo $date1 ?> al <?php echo $date2 ?></h1>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>RUC</th>

                                                <th>Cliente</th>
                                                <th>Factura</th>
                                                <th>Timbrado</th>
                                                <th>Fecha</th>
                                                <th>Cajas</th>
                                                <th>Producto</th>
                                                <th>Gravada 10</th>
                                                <th>IVA 10</th>
                                                <th>Gravada 5</th>
                                                <th>IVA 5</th>
                                                <th>Exentas</th>
                                                <th>Total</th>
                                                <th>Total $USD</th>
                                                <th>Cambio</th>
                                                <th>Cond. de venta</th>
                                            </tr>
                                        </thead>


                                        <?php
                                        $total = 0;
                                        $totalg = 0;
                                        $totali = 0;

                                        $totalg5 = 0;
                                        $totalii5 = 0;
                                        $totalexent = 0;
                                        $totalusd = 0;
                                        $totalcajas = 0;
                                        $cambio = 0;
                                        $j = 0;
                                        foreach ($operations as $operation) {
                                            $totalg = $totalg + $operation->total10;
                                            $totali = $totali + $operation->iva10;

                                            $totalg5 = $totalg5 + $operation->total5;
                                            $totalii5 = $totalii5 + $operation->iva5;
                                            $totalexent = $totalexent + $operation->exenta;



                                            if ($operation->simbolo2 == "US$") {
                                                $cambio = $operation->cambio;
                                            } else if (($operation->simbolo2 == "₲") and ($operation->cambio == 1)) {
                                                $cambio = $operation->cambio2;
                                            } else if (($operation->simbolo2 == "₲") and ($operation->cambio > 1)) {
                                                $cambio = 1;
                                            }


                                            $cambio = $operation->cambio2;
                                            $total = $total + ($operation->total - $operation->descuento) * $cambio;

                                            $totalusd = $totalusd + $operation->total;
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    if ($operation->getCliente()->tipo_doc == "SIN NOMBRE") {
                                                        echo "X";
                                                    } else {
                                                        echo substr($operation->getCliente()->dni, 0, 12);
                                                    }
                                                    ?>
                                                </td>


                                                <td><?php echo ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? $operation->getCliente()->tipo_doc
                                                    : $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido) ?>
                                                </td>
                                                <td><?php echo $operation->factura ?></td>
                                                <td><?php echo $operation->VerConfiFactura()->timbrado1 ?></td>
                                                <td><?php echo $operation->fecha ?></td>
                                                <td><?php echo $cantidad[$j];
                                                $totalcajas += $cantidad[$j]; ?></td>
                                                <td>
                                                    <?php
                                                    $op = OperationData::getAllProductsBySellIddd($operation->id_venta);
                                                    ?>
                                                    <?php echo ProductoData::getById($op[0]->producto_id)->nombre ?>
                                                </td>
                                                <td><?php echo number_format(($operation->total10 * $cambio), 0, ',', '.') ?></td>
                                                <td><?php echo number_format(($operation->iva10 * $cambio), 0, ',', '.') ?></td>
                                                <td><?php echo number_format(($operation->total5 * $cambio), 0, ',', '.') ?></td>
                                                <td><?php echo number_format(($operation->iva5 * $cambio), 0, ',', '.') ?></td>
                                                <td><?php echo number_format($operation->descuento, 0, '.', '.') ?></td>
                                                <td><?php echo number_format(($operation->total * $cambio), 0, ',', '.') ?></td>
                                                <td><?php

                                                echo number_format(($operation->total), 2, ',', '.') ?></td>
                                                <td><?php echo number_format(($cambio), 2, ',', '.') ?></td>
                                                <td><?php echo $operation->metodopago ?></td>


                                            </tr>
                                            <?php $j += 1;
                                        } ?>
                                        <tr>
                                            <td></td>
                                            <td></td>

                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo $totalcajas ?></td>

                                            <td><?= number_format(($totalg * $cambio), 0, ',', '.') ?></td>
                                            <td><?= number_format(($totali * $cambio), 0, ',', '.') ?></td>
                                            <td><?= number_format(($totalg5 * $cambio), 0, ',', '.') ?></td>

                                            <td><?= number_format(($totalii5 * $cambio), 0, ',', '.') ?></td>
                                            <td><?= number_format(($totalexent * $cambio), 0, ',', '.') ?></td>

                                            <td><?php echo number_format(($total), 2, ',', '.') ?></td>
                                            <td><?php echo number_format(($totalusd), 2, ',', '.') ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>



                                    </table>

                                <?php }
                            } ?>

                        </div>
                    </div>
            </div>
            </section>
            <script>
                function exportar() {
                    product = $('#product').val()
                    tipofactura = $('#tipofactura').val()
                    date1 = document.getElementById("date1").value;
                    date2 = document.getElementById("date2").value;
                    cliente = $('#cliente_id').val();
                    id_sucursal = document.getElementById("id_sucursal").value;

                    window.location.href = `libroVenta1.php?&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&cliente=${cliente}&type=${tipofactura}&prod=${product}`;



                }


                function exportar2() {
                    product = $('#product').val()
                    tipofactura = $('#tipofactura').val()
                    date1 = document.getElementById("date1").value;
                    date2 = document.getElementById("date2").value;
                    cliente = $('#cliente_id').val();
                    id_sucursal = document.getElementById("id_sucursal").value;
                    console.log(cliente);


                    window.location.href = `excels/csvVenta.php?&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&cliente=${cliente}&type=${tipofactura}&prod=${product}`;

                }

                function exportar3() {
                    product = $('#product').val()
                    tipofactura = $('#tipofactura').val()
                    date1 = document.getElementById("date1").value;
                    date2 = document.getElementById("date2").value;
                    cliente = $('#cliente_id').val();
                    id_sucursal = document.getElementById("id_sucursal").value;
                    console.log(cliente);

                    window.location.href = `index.php?view=libroventa&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&cliente=${cliente}&type=${tipofactura}&prod=${product}`;
                }
            </script>
        </div>
    <?php endif ?>
<?php endif ?>