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
                                        <select name="tipofactura" id="tipoventa" class="form-control">

                                            <option value="todos">Todos los documentos electronicos</option>
                                            <option value="4">Remision</option>
                                            <!-- <option value="0">Venta</option> -->
                                            <!-- <option value="5">Venta de una remision</option> -->
                                            <option value="ventas">Ventas</option>
                                            <option value="15">Nota de credito</option>
                                        </select>


                                    </div>
                                    <div class="col-md-3">

                                        <select name="cliente_id" id="cliente_id" class="form-control">


                                            <option value="todos">Todos los clientes</option>
                                            <?php $clientes = ClienteData::verclientessucursal($sucursales->id_sucursal);
                                            if (count($clientes) > 0) {
                                                foreach ($clientes as $p) : ?>
                                                    <option value="<?php echo $p->id_cliente; ?>"><?php echo $p->nombre . " " . $p->apellido; ?></option>
                                            <?php endforeach;
                                            } ?>
                                        </select>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <select name="tipofactura" id="tipofactura" class="form-control">

                                            <option value="todos">Todas las formas de pago</option>
                                            <option value="contado">contado</option>
                                            <option value="credito">credito</option>

                                        </select>


                                    </div> -->
                                    <!-- <div class="col-md-6">

                                        <select name="product" id="product" class="form-control">


                                            <option value="todos">Todos los productos</option>
                                            <?php $products = ProductoData::getAll($_GET['id_sucursal']);
                                            if (count($products) > 0) {
                                                foreach ($products as $p) : ?>
                                                    <option value="<?php echo $p->id_producto; ?>"><?php echo $p->nombre ?></option>
                                            <?php endforeach;
                                            } ?>

                                        </select>

                                    </div> -->
                                    <div class="col-md-6">

                                        <select name="product" id="product" class="form-control">


                                            <option value="todos">Todos los estados</option>
                                            <option value="Aprobado">Aprobados</option>
                                            <option value="Cancelado">Cancelados</option>

                                            <option value="Rechazado">Rechazados</option>
                                            <option value="no enviado">Sin enviar</option>


                                        </select>

                                    </div>
                                </div>





                                <div class="row" style="margin-top: 14px">

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

                                        <input type="hidden" style="display: none;" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
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
                                    $ops = VentaData::getAllPersonalizado($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['prod'], $_GET['venta'], $_GET['cliente']);
                                    // echo $ops;
                                    // if ($_GET["prod"] == "todos" && $_GET['venta'] == "todos") {
                                    //     $ops = VentaData::getAllByDateOfficialGs3($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"]);
                                    // } else if ($_GET['prod'] != "todos" && $_GET['venta'] == "todos") {
                                    //     $ops = VentaData::getAllByDateOfficialGs4($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['prod']);
                                    // } else if ($_GET['prod'] == "todos" && $_GET['venta'] != "todos") {
                                    //     $ops = VentaData::getAllByDateOfficialGs5($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['venta']);
                                    // } else if ($_GET['prod'] != "todos" && $_GET['venta'] == "todos") {
                                    //     $ops = VentaData::getAllByDateOfficialGs4($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['prod']);
                                    // } else if ($_GET['prod'] == "todos" && $_GET['venta'] != "todos") {
                                    //     $ops = VentaData::getAllByDateOfficialGs5($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['venta']);
                                    // } else if ($_GET['prod'] != "todos" && $_GET['venta'] == "todos") {
                                    //     $ops = VentaData::getAllByDateOfficialGs4($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['prod']);
                                    // } else if ($_GET['prod'] == "todos" && $_GET['venta'] != "todos") {
                                    //     $ops = VentaData::getAllByDateOfficialGs5($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['venta']);
                                    // } else {
                                    //     $ops = VentaData::getAllByDateOfficialGs6($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['prod'], $_GET['venta']);
                                    // }


                                    $total = 0;
                                    $totall = 0;
                                    $totalg = 0;
                                    $totali = 0;

                                    $totalg5 = 0;
                                    $totalii5 = 0;
                                    $totalexent = 0;
                                    $totalusd = 0;

                                    $cambio = 0;
                                    $totalcajas = 0;
                                    if (count($ops) > 0) {
                                    ?>
                                        <h1>Libro ventas del <?php echo $date1 ?> al <?php echo $date2 ?></h1>


                                        <table id="example1">
                                            <thead>
                                                <th>RUC</th>
                                                <th>Cliente</th>
                                                <th>Factura</th>
                                                <th>Cajas</th>
                                                <th>Producto</th>
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
                                                <th>Tipo</th>
                                                <th>Aprobado SIFEN</th>



                                            </thead>
                                            <tbody>
                                                <?php
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
                                                            <td><?php
                                                                if ($operation->getCliente()->tipo_doc == "SIN NOMBRE") {
                                                                    echo "X";
                                                                } else {
                                                                    echo substr($operation->getCliente()->dni, 0, 12);
                                                                }
                                                                ?></td>
                                                            <td><?php echo ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? $operation->getCliente()->tipo_doc
                                                                    : $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido) ?></td>
                                                            <td><?php echo $operation->factura ?></td>

                                                            <td><?php
                                                                $prods = OperationData::getAllProductsBySellIddd($operation->id_venta);
                                                                $q = 0;
                                                                foreach ($prods as $prod) {
                                                                    $q += $prod->q;
                                                                }
                                                                $totalcajas += $q;
                                                                echo $q;
                                                                ?></td>
                                                            <td><?php echo ProductoData::getById($prods[0]->producto_id)->nombre ?></td>

                                                            <td><?php echo $operation->fecha ?></td>

                                                            <td><?php echo number_format(($operation->total10 * $cambio), 0, ',', '.') ?></td>
                                                            <td><?php echo number_format(($operation->iva10 * $cambio), 0, ',', '.') ?></td>
                                                            <td><?= number_format(($totalg5 * $cambio), 0, ',', '.') ?></td>
                                                            <td><?= number_format(($totalii5 * $cambio), 0, ',', '.') ?></td>

                                                            <td><?php echo number_format(($operation->total5 * $cambio), 0, ',', '.') ?></td>
                                                            <td><?php echo number_format(($operation->iva5 * $cambio), 0, ',', '.') ?></td>

                                                            <td><?php

                                                                echo number_format(($operation->total), 2, ',', '.') ?></td>
                                                            <td><?php echo number_format(($cambio), 2, ',', '.') ?></td>
                                                            <td><?php echo $operation->metodopago ?></td>
                                                            <td><?php if ($operation->tipo_venta == 4) {
                                                                    echo "Remision";
                                                                } else if ($operation->tipo_venta == 0) {
                                                                    echo "Venta";
                                                                } else if ($operation->tipo_venta == 5) {
                                                                    echo "Venta de una remision";
                                                                } else {
                                                                    echo $operation->tipo_venta;
                                                                }
                                                                ?></td>
                                                            <td><?php echo $operation->enviado ?></td>
                                                        </tr>
                                                <?php }
                                                } ?>

                                            </tbody>
                                        </table>
                                        <p>Total Cajas: <?php echo $totalcajas ?></p>

                                        <p>Total Gravada 10: <?= number_format(($totalg * $cambio), 0, ',', '.') ?></p>
                                        <p>Total Iva 10: <?= number_format(($totali * $cambio), 0, ',', '.') ?></p>
                                        <p>Total Gravada 5: <?= number_format(($totalg5 * $cambio), 0, ',', '.') ?></p>

                                        <p>Total Iva 5:<?= number_format(($totalii5 * $cambio), 0, ',', '.') ?></p>
                                        <p>Total Exenta:<?= number_format(($totalexent * $cambio), 0, ',', '.') ?></p>

                                        <p>Total:<?php echo number_format(($total), 2, ',', '.') ?></p>
                                        <p>Total USD: <?php echo number_format(($totalusd), 2, ',', '.')  ?></p>
                                <?php }
                                } ?>

                            </div>
                        </div>
                </div>
                </section>
                <script>
                    function exportar() {
                        product = $('#product').val()
                        date1 = document.getElementById("date1").value;
                        date2 = document.getElementById("date2").value;
                        cliente = $('#cliente_id').val();

                        id_sucursal = document.getElementById("id_sucursal").value;
                        v = document.getElementById("tipoventa").value

                        window.location.href = `libroVentaSifen.php?&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&prod=${product}&venta=${v}&cliente=${cliente}`;



                    }


                    function exportar2() {
                        product = $('#product').val()
                        date1 = document.getElementById("date1").value;
                        date2 = document.getElementById("date2").value;
                        cliente = $('#cliente_id').val();

                        id_sucursal = document.getElementById("id_sucursal").value;
                        v = document.getElementById("tipoventa").value

                        window.location.href = `csvVentaSifen.php?&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&prod=${product}&venta=${v}&cliente=${cliente}`;

                    }

                    function exportar3() {
                        product = $('#product').val()
                        date1 = document.getElementById("date1").value;
                        date2 = document.getElementById("date2").value;
                        cliente = $('#cliente_id').val();
                        id_sucursal = document.getElementById("id_sucursal").value;
                        v = document.getElementById("tipoventa").value

                        window.location.href = `index.php?view=libroventag&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&prod=${product}&venta=${v}&cliente=${cliente}`;

                    }
                </script>
            </div>
        <?php endif ?>
    <?php endif ?>