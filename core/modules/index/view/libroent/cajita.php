    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    $u = null;
    if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
        $u = UserData::getById($_SESSION["admin_id"]);
    ?>
        <!-- Content Wrapper. Contains page content -->
        <?php if ($u->is_admin) : ?>
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
        <?php if ($u->is_empleado) : ?>
            <?php

            $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
            ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
                        REGISTRO ENTRADA / SALIDA
                    </h1>

                </section>

                <!-- Main content -->

                <div class="row">
                    <section class="content">

                        <div class="col-xs-12">
                            <div class="box">










                                <?php


                                $sucurs = $_GET["id_sucursal"];


                                $ops = VentaData::getbysucursal($_GET["id_sucursal"]);

                                $total = 0;
                                $totall = 0;
                                if (count($ops) > 0) {
                                ?>
                                    <h1>Libro ventas </h1>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>RUC</th>

                                                <th>Cliente</th>
                                                <th>Factura</th>
                                                <th>Cajas</th>
                                                <th>Fecha</th>
                                                <th>Gravada 10</th>
                                                <th>IVA 10</th>
                                                <th>Gravada 5</th>
                                                <th>IVA 5</th>
                                                <th>Exentas</th>
                                                <th>Total</th>
                                                <th>Total $USD</th>
                                                <th>Cambio</th>
                                                <th>Cond. de venta</th>
                                                <th>Aprobado SIFEN</th>
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

                                        $cambio = 0;

                                        foreach ($ops as $operation) {


                                            $totalg = $totalg + $operation->total10;
                                            $totali = $totali + $operation->iva10;

                                            $totalg5 = $totalg5 + $operation->total5;
                                            $totalii5 = $totalii5 + $operation->iva5;
                                            $totalexent = $totalexent + $operation->exenta;



                                            if ($operation->simbolo2 == "US$") {
                                                $cambio = $operation->cambio;
                                            } else if (($operation->simbolo2 == "₲") and  ($operation->cambio == 1)) {
                                                $cambio = $operation->cambio2;
                                            } else if (($operation->simbolo2 == "₲") and  ($operation->cambio > 1)) {
                                                $cambio = 1;
                                            }


                                            $cambio = $operation->cambio2;
                                            $total = $total + ($operation->total - $operation->descuento) * $cambio;

                                            $totalusd = $totalusd + $operation->total;
                                            if ($operation->cliente_id !== NULL) {
                                        ?>

                                                <tr>

                                                    <td>
                                                        <?php
                                                        if ($operation->getCliente()->tipo_doc == "SIN NOMBRE") {
                                                            echo "X";
                                                        } else {
                                                            echo substr($operation->getCliente()->dni, 0, 12);
                                                        }
                                                        ?> </td>

                                                    <td><?php


                                                        echo ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? $operation->getCliente()->tipo_doc
                                                            : $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido) ?></td>
                                                    <td><?php echo $operation->factura ?></td>
                                                    <td><?php
                                                        $prods = OperationData::getAllProductsBySellIddd($operation->id_venta);
                                                        $q = 0;
                                                        // var_dump($prods);
                                                        foreach ($prods as $prod) {
                                                            // echo $prod->q;
                                                            $q += $prod->q;
                                                        }
                                                        echo $q;
                                                        // var_dump($prods);
                                                        ?></td>
                                                    <td><?php echo $operation->fecha ?></td>
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

                                                    <td><?php echo $operation->enviado ?></td>
                                                </tr>
                                        <?php }
                                        } ?>
                                        <tr>
                                            <td></td>
                                            <td></td>

                                            <td></td>
                                            <td></td>
                                            <td></td>


                                            <td><?= number_format(($totalg * $cambio), 0, ',', '.') ?></td>
                                            <td><?= number_format(($totali * $cambio), 0, ',', '.') ?></td>
                                            <td><?= number_format(($totalg5 * $cambio), 0, ',', '.') ?></td>

                                            <td><?= number_format(($totalii5 * $cambio), 0, ',', '.') ?></td>
                                            <td><?= number_format(($totalexent * $cambio), 0, ',', '.') ?></td>

                                            <td><?php echo number_format(($total), 2, ',', '.') ?></td>
                                            <td><?php echo number_format(($totalusd), 2, ',', '.')  ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>



                                    </table>


                                <?php }
                                ?>

                            </div>
                        </div>
                </div>
                </section>
                <script>
                    function exportar() {
                        product = $('#product').val()
                        date1 = document.getElementById("date1").value;
                        date2 = document.getElementById("date2").value;
                        id_sucursal = document.getElementById("id_sucursal").value;
                        v = document.getElementById("tipoventa").value

                        window.location.href = `libroVentaSifen.php?&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&prod=${product}&venta=${v}`;



                    }


                    function exportar2() {
                        product = $('#product').val()
                        date1 = document.getElementById("date1").value;
                        date2 = document.getElementById("date2").value;
                        id_sucursal = document.getElementById("id_sucursal").value;
                        v = document.getElementById("tipoventa").value

                        window.location.href = `excels/csvVentaSifen.php?&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&prod=${product}&venta=${v}`;

                    }

                    function exportar3() {
                        product = $('#product').val()
                        date1 = document.getElementById("date1").value;
                        date2 = document.getElementById("date2").value;
                        id_sucursal = document.getElementById("id_sucursal").value;
                        v = document.getElementById("tipoventa").value

                        window.location.href = `index.php?view=libroventag&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&prod=${product}&venta=${v}`;

                    }
                </script>
            </div>
        <?php endif ?>
    <?php endif ?>