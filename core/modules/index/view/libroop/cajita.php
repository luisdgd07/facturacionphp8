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
                        REGISTRO DE OPERACIONES
                    </h1>

                </section>

                <!-- Main content -->

                <div class="row">
                    <section class="content">

                        <div class="col-xs-12">
                            <div class="box">
                                <div class="row">
                                    <div class="col-md-6">

                                        <select name="product" id="product" class="form-control">


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
                                        <input type="date" name="sd" id="date1" value="" min="2023-01-01" class="form-control">



                                    </div>
                                    <div class="col-md-4">
                                        <span>
                                            HASTA:
                                        </span>


                                        <input type="date" name="ed" id="date2" value="" min="2023-01-01" class="form-control">

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
                                    $operations  = VentaData::versucursaltipotrans2($_GET["id_sucursal"], $_GET["sd"], $_GET["ed"]);
                                    // $operations = OperationData::getByProductoId2($_GET["id_sucursal"], $_GET["sd"], $_GET["ed"]);
                                    // echo $ops;
                                    //$sucursales = SuccursalData::VerId($_GET["id_sucursal"]);

                                    $total = 0;
                                    $totall = 0;
                                    if (count($operations) > 0) {
                                    ?>
                                        <h1>Operaciones del <?php echo $date1 ?> al <?php echo $date2 ?></h1>
                                        <table class="table table-bordered table-dark">
                                            <thead>
                                                <tr>
                                                    <th>Nro.</th>
                                                    <th>Producto.</th>
                                                    <th>Cajas</th>
                                                    <th>Tipo de transacción</th>
                                                    <th>Usuario</th>
                                                    <th>Observación</th>
                                                    <th>Fecha</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                $totalcajas = 0;

                                                $total = 0;
                                                $totalg = 0;
                                                $totali = 0;

                                                $totalg5 = 0;
                                                $totalii5 = 0;
                                                $totalexent = 0;
                                                $totalusd = 0;

                                                $cambio = 0;
                                                $j = 0;
                                                foreach ($operations as $sell) {
                                                    $totalproducts = 0;
                                                    // $totalg = $totalg + $operation->total10;
                                                    // $totali = $totali + $operation->iva10;

                                                    // $totalg5 = $totalg5 + $operation->total5;
                                                    // $totalii5 = $totalii5 + $operation->iva5;
                                                    // $totalexent = $totalexent + $operation->exenta;



                                                    // if ($operation->simbolo2 == "US$") {
                                                    //     $cambio = $operation->cambio;
                                                    // } else if (($operation->simbolo2 == "₲") and  ($operation->cambio == 1)) {
                                                    //     $cambio = $operation->cambio2;
                                                    // } else if (($operation->simbolo2 == "₲") and  ($operation->cambio > 1)) {
                                                    //     $cambio = 1;
                                                    // }


                                                    // $cambio = $operation->cambio2;
                                                    // $total = $total + ($operation->total - $operation->descuento) * $cambio;

                                                    // $totalusd = $totalusd + $operation->total;
                                                ?>
                                                    <?php
                                                    $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                                                    count($operations);
                                                    foreach ($operations as $selldetalle) {

                                                        if ($_GET['prod'] == "todos") {
                                                            $totalcajas
                                                                += $selldetalle->q;
                                                    ?>
                                                            <tr>

                                                                <td><?php echo $sell->id_venta; ?>
                                                                </td>


                                                                <td>
                                                                    <?php $prod = ProductoData::getProducto2($selldetalle->producto_id);  ?>


                                                                    <?php foreach ($prod as $detalle) : ?>


                                                                        <?php echo $detalle->nombre; ?>

                                                                    <?php endforeach; ?></td>
                                                                <td> <?php echo   number_format($selldetalle->q, 2, ',', '.');; ?></td>
                                                                <td> <?php if ($sell->accion_id == 1) {
                                                                            echo  "Entrada";
                                                                        } else if ($sell->accion_id == 2) {
                                                                            echo  "Salida";
                                                                        } else if ($sell->accion_id == 3) {
                                                                            echo  "Trasferencia";
                                                                        } ?></td>
                                                                <td><?php if ($sell->usuario_id != "") {
                                                                        $user = $sell->getUser();
                                                                    ?>
                                                                    <?php echo $user->nombre . " " . $user->apellido;
                                                                    } ?></td>
                                                                <td><?php echo $selldetalle->observacion; ?></td>

                                                                <td><?php echo $sell->fecha; ?></td>

                                                                <?php } else {
                                                                if ($selldetalle->producto_id == $_GET['prod']) {
                                                                    $totalcajas
                                                                        += $selldetalle->q;
                                                                ?>

                                                                    <td><?php echo $sell->id_venta; ?>
                                                                    </td>


                                                                    <td>
                                                                        <?php $prod = ProductoData::getProducto2($selldetalle->producto_id);  ?>


                                                                        <?php foreach ($prod as $detalle) : ?>


                                                                            <?php echo $detalle->nombre; ?>

                                                                        <?php endforeach; ?></td>
                                                                    <td> <?php echo   number_format($selldetalle->q, 2, ',', '.');; ?></td>
                                                                    <td> <?php if ($sell->accion_id == 1) {
                                                                                echo  "Entrada";
                                                                            } else if ($sell->accion_id == 2) {
                                                                                echo  "Salida";
                                                                            } else if ($sell->accion_id == 3) {
                                                                                echo  "Trasferencia";
                                                                            } ?></td>
                                                                    <td><?php if ($sell->usuario_id != "") {
                                                                            $user = $sell->getUser();
                                                                        ?>
                                                                        <?php echo $user->nombre . " " . $user->apellido;
                                                                        } ?></td>
                                                                    <td><?php echo $selldetalle->observacion; ?></td>

                                                                    <td><?php echo $sell->fecha; ?></td>
                                                            </tr>

                                            <?php
                                                                }
                                                            }
                                                        }
                                                        $j += 1;
                                                    } ?>



                                            <tr>
                                                <td>
                                                </td>


                                                <td>
                                                </td>
                                                <td><?php echo

                                                    number_format($totalcajas, 2, ',', '.');
                                                    ?></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>

                                            </tr>
                                            </tbody>
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
                        date1 = document.getElementById("date1").value;
                        date2 = document.getElementById("date2").value;
                        cliente = $('#cliente_id').val();
                        id_sucursal = document.getElementById("id_sucursal").value;
                        const fechaLimite = new Date("2022-12-31");
                        if (new Date(date1) < fechaLimite || new Date(date2) < fechaLimite) {
                            alert("Seleccione una fecha valida");
                        } else {
                            window.open(`pdfs/entradasalida.php?&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&cliente=${cliente}&prod=${product}`)

                        }
                        // window.location.href = `libroop.php?&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&cliente=${cliente}&prod=${product}`;


                    }


                    function exportar2() {
                        product = $('#product').val()

                        date1 = document.getElementById("date1").value;
                        date2 = document.getElementById("date2").value;
                        cliente = $('#cliente_id').val();
                        id_sucursal = document.getElementById("id_sucursal").value;
                        console.log(cliente);
                        const fechaLimite = new Date("2022-12-31");
                        if (new Date(date1) < fechaLimite || new Date(date2) < fechaLimite) {
                            alert("Seleccione una fecha valida");
                        } else {
                            window.location.href = `excels/csvoop.php?&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&cliente=${cliente}&prod=${product}`;


                        }

                    }

                    function exportar3() {
                        // product = $('#product').val()
                        date1 = document.getElementById("date1").value;
                        date2 = document.getElementById("date2").value;
                        cliente = $('#cliente_id').val();
                        prod = $('#product').val()
                        id_sucursal = document.getElementById("id_sucursal").value;
                        console.log(cliente);
                        const fechaLimite = new Date("2024-01-20");
                        if (new Date(date1) < fechaLimite || new Date(date2) < fechaLimite) {
                            alert("Seleccione una fecha valida");
                        } else {
                            window.location.href = `index.php?view=libroop&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&prod=${prod}`;


                        }

                    }
                </script>
            </div>
        <?php endif ?>
    <?php endif ?>