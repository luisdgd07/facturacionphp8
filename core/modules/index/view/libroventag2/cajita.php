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
                        Reporte Facturación Electrónica
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
                                            <option value="ventas">Ventas</option>

                                            <option value="4">Remision</option>
                                            <!-- <option value="0">Venta</option> -->
                                            <!-- <option value="5">Venta de una remision</option> -->

                                            <option value="15">Nota de credito</option>

                                            <option value="todos">Todos los documentos electronicos</option>
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

                                            <option value="Aprobado">Aprobados</option>
                                            <option value="todos">Todos los estados</option>

                                            <option value="Cancelado">Cancelados</option>

                                            <option value="Rechazado">Rechazados</option>
                                            <option value="no enviado">Sin enviar</option>


                                        </select>

                                    </div>
                                    <div class="col-md-6">

                                        <select name="product" id="producto" class="form-control">


                                            <option value="todos">Todos los productos</option>
                                            <?php $products = ProductoData::getAll($_GET['id_sucursal']);
                                            if (count($products) > 0) {
                                                foreach ($products as $p) : ?>
                                                    <option value="<?php echo $p->id_producto; ?>"><?php echo $p->nombre ?></option>
                                            <?php endforeach;
                                            } ?>

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


                                </div>

                                <?php if (isset($_GET["sd"])) {
                                ?>
                                    <button onclick="exportar()" href="" class="mx-4 my-2 btn btn-success">Generar PDF</button>
                                    <button onclick="exportar2()" href="" class="mx-4 my-2 btn btn-success">Generar Excel</button>
                                    <?php

                                    $date1 = $_GET["sd"];
                                    $date2 = $_GET["ed"];
                                    $sucurs = $_GET["id_sucursal"];
                                    $ops = VentaData::getAllPersonalizado($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['prod'], $_GET['venta'], $_GET['cliente']);


                                    $totalGCajas = 0;
                                    $total = 0;
                                    $totall = 0;
                                    if (count($ops) > 0) {
                                    ?>
                                        <h3>Desde:<?php echo $date1 ?>Hasta:<?php echo $date2 ?></h3>
                                        <div class="row">

                                        </div>

                                        <?php
                                        $total = 0;
                                        $totalg = 0;
                                        $totali = 0;

                                        $totalg5 = 0;
                                        $totalii5 = 0;
                                        $totalexent = 0;
                                        $totalusd = 0;

                                        $cambio = 0;
                                        $totalcajas = 0;
                                        $totalgeneral = 0;
                                        $num = 0;
                                        foreach ($ops as $operation) {
                                            $num++;

                                            $totalg = $totalg + $operation->total10;
                                            $totali = $totali + $operation->iva10;

                                            $totalg5 = $totalg5 + $operation->total5;
                                            $totalii5 = $totalii5 + $operation->iva5;
                                            $totalexent = $totalexent + $operation->exenta;

                                            if ($operation->VerTipoModena()->simbolo == "US$") {
                                                $cambio = $operation->cambio2;
                                            } else {
                                                $cambio = 1;
                                            }


                                            // $cambio = $operation->cambio2;
                                            $total = $total + ($operation->total - $operation->descuento) * $cambio;

                                            $totalusd = $totalusd + $operation->total;
                                            if ($operation->cliente_id !== NULL) {
                                                if ($_GET['producto'] == "todos") {
                                        ?>
                                                    <div class="box" style="padding: 0 120px;">
                                                        <h4 style="margin-top: 40px;">

                                                            <?php
                                                            echo "No: " . $num . " ";
                                                            if ($operation->enviado == '') {
                                                                echo 'No enviado --';
                                                            } else {
                                                                echo $operation->enviado . ' -- ';
                                                            }
                                                            ?>
                                                            <?php
                                                            if ($operation->getCliente()->tipo_doc == "SIN NOMBRE") {
                                                                echo "X";
                                                            } else {
                                                                echo substr($operation->getCliente()->dni, 0, 12);
                                                            }
                                                            ?>
                                                            <?php echo '--' . ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? $operation->getCliente()->tipo_doc
                                                                : $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido) ?>
                                                            <?php echo '-- ' . $operation->factura ?>

                                                            <?php echo '-- ' .  $operation->metodopago . '-- ' ?>
                                                            <?php if ($operation->tipo_venta == 4) {
                                                                echo "Remision";
                                                            } else if ($operation->tipo_venta == 0) {
                                                                echo "Venta";
                                                            } else if ($operation->tipo_venta == 5) {
                                                                echo "Venta de una remision";
                                                            } else {
                                                                echo $operation->tipo_venta;
                                                            }
                                                            ?>

                                                            <?php echo '--' . $operation->fecha ?>

                                                        </h4>
                                                        <p>
                                                            Cambio: <?php echo number_format(($cambio), 2, ',', '.') ?>
                                                        </p>
                                                        <table>
                                                            <thead>
                                                                <th style="width: 300px;">Producto</th>
                                                                <th style="width: 300px;">Cajas</th>
                                                                <th style="width: 300px;">Precio</th>
                                                                <th style="width: 300px;">Total</th>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $prods = OperationData::getAllProductsBySellIddd($operation->id_venta);
                                                                $t = 0;
                                                                $totalcajas = 0;
                                                                foreach ($prods as $prod) {
                                                                    $t += $prod->q * $prod->precio;
                                                                    $totalgeneral += $prod->q * $prod->precio;
                                                                    $totalcajas += $prod->q;

                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo ProductoData::getById($prod->producto_id)->nombre; ?></td>
                                                                        <td><?php echo number_format($prod->q, 0, ',', '.') ?></td>
                                                                        <td><?php echo number_format($prod->precio, 0, ',', '.') ?></td>
                                                                        <td><?php echo number_format($prod->q * $prod->precio, 0, ',', '.') ?></td>
                                                                    </tr>
                                                                <?php   }
                                                                ?>

                                                            </tbody>
                                                        </table>
                                                        <p><?php
                                                            $totalGCajas += $totalcajas;
                                                            ?></p>

                                                        <p><b>Total de la operación: <?php echo number_format($t, 0, ',', '.') ?></b></p>
                                                        <p>Cajas:<?php echo $totalcajas ?></p>

                                                    </div>
                                                <?php } else { ?>
                                                    <?php
                                                    $prods = OperationData::getAllProductsBySellIddd($operation->id_venta);
                                                    $t = 0;
                                                    $totalcajas = 0;
                                                    $existe = false;
                                                    foreach ($prods as $prod) {

                                                        if ($_GET['producto'] == $prod->producto_id) {
                                                            $existe = true;
                                                        }
                                                    }
                                                    if ($existe) {
                                                    ?>
                                                        <div class="box" style="padding: 0 120px;">
                                                            <h4 style="margin-top: 40px;">

                                                                <?php
                                                                echo "No: " . $num . " ";
                                                                if ($operation->enviado == '') {
                                                                    echo 'No enviado --';
                                                                } else {
                                                                    echo $operation->enviado . ' -- ';
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($operation->getCliente()->tipo_doc == "SIN NOMBRE") {
                                                                    echo "X";
                                                                } else {
                                                                    echo substr($operation->getCliente()->dni, 0, 12);
                                                                }
                                                                ?>
                                                                <?php echo '--' . ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? $operation->getCliente()->tipo_doc
                                                                    : $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido) ?>
                                                                <?php echo '-- ' . $operation->factura ?>

                                                                <?php echo '-- ' .  $operation->metodopago . '-- ' ?>
                                                                <?php if ($operation->tipo_venta == 4) {
                                                                    echo "Remision";
                                                                } else if ($operation->tipo_venta == 0) {
                                                                    echo "Venta";
                                                                } else if ($operation->tipo_venta == 5) {
                                                                    echo "Venta de una remision";
                                                                } else {
                                                                    echo $operation->tipo_venta;
                                                                }
                                                                ?>

                                                                <?php echo '--' . $operation->fecha ?>

                                                            </h4>
                                                            <p>
                                                                Cambio: <?php echo number_format(($cambio), 2, ',', '.') ?>
                                                            </p>
                                                            <table>
                                                                <thead>
                                                                    <th style="width: 300px;">Producto</th>
                                                                    <th style="width: 300px;">Cajas</th>
                                                                    <th style="width: 300px;">Precio</th>
                                                                    <th style="width: 300px;">Total</th>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $prods = OperationData::getAllProductsBySellIddd($operation->id_venta);
                                                                    $t = 0;
                                                                    $totalcajas = 0;
                                                                    foreach ($prods as $prod) {
                                                                        $t += $prod->q * $prod->precio;
                                                                        $totalgeneral += $prod->q * $prod->precio;
                                                                        $totalcajas += $prod->q;

                                                                    ?>
                                                                        <tr>
                                                                            <td><?php echo ProductoData::getById($prod->producto_id)->nombre; ?></td>
                                                                            <td><?php echo number_format($prod->q, 0, ',', '.') ?></td>
                                                                            <td><?php echo number_format($prod->precio, 0, ',', '.') ?></td>
                                                                            <td><?php echo number_format($prod->q * $prod->precio, 0, ',', '.') ?></td>
                                                                        </tr>
                                                                    <?php   }
                                                                    ?>

                                                                </tbody>
                                                            </table>
                                                            <p><?php
                                                                $totalGCajas += $totalcajas;
                                                                ?></p>

                                                            <p><b>Total de la operación: <?php echo number_format($t, 0, ',', '.') ?></b></p>
                                                            <p>Cajas:<?php echo $totalcajas ?></p>

                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                        <?php
                                                }
                                            }
                                        } ?>


                                        <h3 style="margin-left:980px;"><b>Total: <?php echo number_format(($totalgeneral), 2, ',', '.') ?></b></h3>
                                        <p style="margin-left: 400px;"><b>Total de cajas:<?php echo $totalGCajas ?><b></p>
                                        <br>
                                <?php }
                                } ?>

                            </div>
                        </div>
                </div>
                </section>
                <script>
                    <?php if (isset($_GET['ed'])) { ?>

                        function exportar() {
                            product = $('#product').val()
                            date1 = document.getElementById("date1").value;
                            date2 = document.getElementById("date2").value;
                            id_sucursal = document.getElementById("id_sucursal").value;
                            v = document.getElementById("tipoventa").value
                            cliente = $('#cliente_id').val();
                            // window.open(`libroVentaSifen.php?&uso_id=&sd=<?php echo $_GET['sd'] ?>&ed=<?php echo $_GET['ed'] ?>&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&prod=<?php echo $_GET['prod'] ?>&venta=<?php echo $_GET['venta'] ?>&cliente=<?php echo $_GET['cliente'] ?>`);
                            window.open(`pdfs/ventas2.php?&uso_id=&sd=<?php echo $_GET['sd'] ?>&ed=<?php echo $_GET['ed'] ?>&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&prod=<?php echo $_GET['prod'] ?>&venta=<?php echo $_GET['venta'] ?>&cliente=<?php echo $_GET['cliente'] ?>`);

                            // /pdfs/ventas.php ?

                        }


                        function exportar2() {
                            product = $('#product').val()
                            date1 = document.getElementById("date1").value;
                            date2 = document.getElementById("date2").value;
                            id_sucursal = document.getElementById("id_sucursal").value;
                            v = document.getElementById("tipoventa").value
                            cliente = $('#cliente_id').val();
                            window.location.href = `excels/csvVentaSifen2.php?&uso_id=&sd=<?php echo $_GET['sd'] ?>&ed=<?php echo $_GET['ed'] ?>&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&prod=<?php echo $_GET['prod'] ?>&venta=<?php echo $_GET['venta'] ?>&cliente=<?php echo $_GET['cliente'] ?>`;

                        }
                    <?php } ?>

                    function exportar3() {
                        product = $('#product').val()
                        producto = $('#producto').val()
                        date1 = document.getElementById("date1").value;
                        date2 = document.getElementById("date2").value;
                        cliente = $('#cliente_id').val();
                        id_sucursal = document.getElementById("id_sucursal").value;
                        v = document.getElementById("tipoventa").value

                        window.location.href = `index.php?view=libroventag2&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&prod=${product}&producto=${producto}&venta=${v}&cliente=${cliente}`;

                    }
                </script>
            </div>
        <?php endif ?>
    <?php endif ?>