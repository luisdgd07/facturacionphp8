    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    $u = null;
    if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
        $u = UserData::getById($_SESSION["admin_id"]);
    ?>
        <?php
        if ($u->is_empleado) : ?>
            <?php

            $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
            ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
                        Reporte Facturación Electrónica
                    </h1>

                </section>
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
                                            <option value="20">Venta de exportacion</option>
                                            <option value="15">Nota de credito</option>

                                            <option value="todos">Todos los documentos electronicos</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select name="tipofactura" id="moneda" class="form-control">
                                            <option value="todos">Todas las monedas</option>
                                            <option value="dolar">Dolares</option>
                                            <option value="guaranies">Guaranies</option>
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
                                    <div class="col-md-3">

                                        <select name="vendedor" id="vendedor" class="form-control">


                                            <option value="todos">Todos los Vendedores</option>
                                            <?php $clientes = VendedorData::getAll($sucursales->id_sucursal);
                                            if (count($clientes) > 0) {
                                                foreach ($clientes as $p) : ?>
                                                    <option value="<?php echo $p->id; ?>"><?php echo $p->nombre ?></option>
                                            <?php endforeach;
                                            } ?>
                                        </select>
                                    </div>

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
                                    <div class="col-md-6">

                                        <select name="iva" id="iva" class="form-control">

                                            <option value="todos">Todos los IVA</option>
                                            <option value="5">5</option>

                                            <option value="10">10</option>

                                            <option value="0">0</option>
                                            <option value="30">30</option>
                                            <option value="menos30">todos menos 30</option>

                                        </select>

                                    </div>
                                </div>


                                <div class="row" style="margin-top: 14px">

                                    <div class="col-md-4">

                                        <span>
                                            DESDE:
                                        </span>
                                        <input type="date" name="sd" id="date1" value="<?php echo $_GET['sd'] ?>" class="form-control">



                                    </div>
                                    <div class="col-md-4">
                                        <span>
                                            HASTA:
                                        </span>


                                        <input type="date" name="ed" id="date2" class="form-control" value="<?php echo $_GET['ed'] ?>">

                                        <input type="hidden" style="display: none;" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                                    </div>


                                    <script type="text/javascript">
                                        var datos = <?php echo isset($_GET['sd']) ? 'true' :  'false'; ?>;

                                        if (datos) {
                                            $("#product").val("<?php echo $_GET['prod'] ?>");
                                            $("#vendedor").val("<?php echo $_GET['vendedor'] ?>");
                                            $("#producto").val("<?php echo $_GET['producto'] ?>");
                                            $("#tipoventa").val("<?php echo $_GET['venta'] ?>");
                                            $("#cliente_id").val("<?php echo $_GET['cliente'] ?>");
                                            $("#moneda").val("<?php echo $_GET['moneda'] ?>");
                                        } else {
                                            function obtenerFechaActual() {
                                                var n = new Date();
                                                var y = n.getFullYear();
                                                var m = n.getMonth() + 1;
                                                var d = n.getDate();
                                                return y + "-" + (m > 9 ? m : "0" + m) + "-" + (d > 9 ? d : "0" + d);
                                            }
                                            $("#date1").val(obtenerFechaActual());
                                            $("#date2").val(obtenerFechaActual());
                                        }
                                    </script>


                                </div>

                                <div style="margin: 15px">
                                    <button onclick="exportar3()" href="" class="mx-4 my-2 btn btn-success">Ver reportes</button>

                                </div>

                                <?php if (isset($_GET["sd"])) {
                                ?>

                                    <button onclick="exportar5()" href="" class="mx-4 my-2 btn btn-success">Generar PDF </button>

                                    <button onclick="exportar2()" href="" class="mx-4 my-2 btn btn-success">Generar Excel a importar</button>
                                    <?php

                                    $date1 = $_GET["sd"];
                                    $date2 = $_GET["ed"];
                                    $sucurs = $_GET["id_sucursal"];
                                    $ops = VentaData::getAllPersonalizado($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['prod'], $_GET['venta'], $_GET['cliente'], $_GET['vendedor']);


                                    $totalGCajas = 0;
                                    $total = 0;
                                    $totall = 0;
                                    if (count($ops) > 0) {
                                    ?>
                                        <h3>Desde:<?php echo $date1 ?>Hasta:<?php echo $date2 ?></h3>

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
                                        $totalgeneralGS = 0;
                                        $totalgeneralUSD = 0;
                                        $num = 0;
                                        $totalUnidades = 0;
                                        $totalUsd = [
                                            "efectivo" => 0,
                                            "tarjeta" => 0,
                                            "transferencia" => 0,
                                            "cheque" => 0,
                                        ];
                                        $totalGs = [
                                            "efectivo" => 0,
                                            "tarjeta" => 0,
                                            "transferencia" => 0,
                                            "cheque" => 0,
                                        ];
                                        $creditoGs = 0;
                                        $contadoGs = 0;
                                        $creditoUsd = 0;
                                        $contadoUsd = 0;

                                        foreach ($ops as $operation) {
                                            $metodoPago = "";
                                            $caja = CajaDetalle::obtenerVenta($operation->id_venta);

                                            if ($operation->VerTipoModena()->simbolo == "US$" && ($_GET['moneda'] === "dolar" || $_GET['moneda'] === "todos")) {
                                                if ($operation->metodopago == "Contado") {
                                                    $creditoUsd += $operation->total;
                                                } else {
                                                    $contadoUsd += $operation->total;
                                                }
                                                if (isset($caja->CAJA)) {
                                                    switch ($caja->CAJA) {
                                                        case 1:
                                                            $totalUsd["efectivo"] += $caja->IMPORTE;
                                                            $metodoPago = "Efectivo";
                                                            break;
                                                        case 2:
                                                            $totalUsd["transferencia"] += $caja->IMPORTE;
                                                            $metodoPago  = "transferencia";
                                                            break;
                                                        case 3:
                                                            $totalUsd["cheque"] += $caja->IMPORTE;
                                                            $metodoPago = "cheque";
                                                            break;
                                                        case 4:
                                                            $totalUsd["tarjeta"] += $caja->IMPORTE;
                                                            $metodoPago = "Tarjeta";
                                                            break;
                                                        case 5:
                                                            $totalUsd["Retencion"] += $caja->IMPORTE;
                                                            break;
                                                        default:
                                                    }
                                                }

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
                                                $total = $total + ($operation->total - $operation->descuento) * $cambio;

                                                $totalusd = $totalusd + $operation->total;
                                                if ($operation->cliente_id !== NULL) {
                                                    if ($_GET['producto'] == "todos" && $_GET['iva'] == "todos") {
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

                                                                if ($operation->getCliente()->tipo_doc == "SIN NOMBRE") {
                                                                    echo "X";
                                                                } else {
                                                                    echo substr($operation->getCliente()->dni, 0, 12);
                                                                }
                                                                echo '--' . ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? $operation->getCliente()->tipo_doc
                                                                    : $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido);
                                                                echo '-- ' . $operation->factura;
                                                                echo '-- ' .  $operation->metodopago . '-- ';
                                                                if ($operation->tipo_venta == 4) {
                                                                    echo "Remision";
                                                                } else if ($operation->tipo_venta == 0) {
                                                                    echo "Venta";
                                                                } else if ($operation->tipo_venta == 5) {
                                                                    echo "Venta de una remision";
                                                                } else {
                                                                    echo $operation->tipo_venta;
                                                                }
                                                                echo '--' . $metodoPago;
                                                                echo '--' . $operation->fecha ?>

                                                            </h4>
                                                            <p>
                                                                Cambio: <?php echo number_format(($cambio), 2, ',', '.') ?>
                                                            </p>
                                                            <table>
                                                                <thead>
                                                                    <th style="width: 300px;">Producto</th>
                                                                    <th style="width: 300px;">Unidades</th>
                                                                    <th style="width: 300px;">Precio</th>
                                                                    <th style="width: 300px;">Total</th>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $prods = OperationData::getAllProductsBySellIddd($operation->id_venta);
                                                                    $t = 0;
                                                                    $totalcajas = 0;

                                                                    if ($operation->tipo_venta == 15) {
                                                                        foreach ($prods as $prod) {
                                                                            $t += $prod->q * $prod->precio;
                                                                            $totalgeneralUSD -= $prod->q * $prod->precio;
                                                                            $totalcajas += $prod->q;
                                                                            $precioGS = $prod->q * $prod->precio * $cambio;
                                                                            $totalgeneralGS -= $precioGS;
                                                                    ?>
                                                                            <tr>
                                                                                <td><?php echo ProductoData::getById($prod->producto_id)->nombre; ?></td>
                                                                                <td><?php echo number_format($prod->q, 0, ',', '.') ?></td>
                                                                                <td><?php echo number_format($prod->precio, 0, ',', '.') ?></td>
                                                                                <td><?php echo number_format($prod->q * $prod->precio, 0, ',', '.') ?></td>
                                                                            </tr>
                                                                        <?php   }
                                                                    } else {
                                                                        foreach ($prods as $prod) {
                                                                            $t += $prod->q * $prod->precio;
                                                                            $totalgeneralUSD  += $prod->q * $prod->precio;
                                                                            $totalcajas += $prod->q;
                                                                            $precioGS = $prod->q * $prod->precio * $cambio;
                                                                            $totalgeneralGS += $precioGS;
                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo ProductoData::getById($prod->producto_id)->nombre; ?></td>
                                                                                <td><?php echo number_format($prod->q, 0, ',', '.') ?></td>
                                                                                <td><?php echo number_format($prod->precio, 0, ',', '.') ?></td>
                                                                                <td><?php echo number_format($prod->q * $prod->precio, 0, ',', '.') ?></td>
                                                                            </tr>
                                                                    <?php   }
                                                                    }
                                                                    ?>

                                                                </tbody>
                                                            </table>
                                                            <p><?php
                                                                if ($operation->tipo_venta == 15) {
                                                                    $totalGCajas -= $totalcajas;
                                                                } else {
                                                                    $totalGCajas += $totalcajas;
                                                                }
                                                                ?></p>

                                                            <p><b>TOTAL GENERAL: </b><?php echo number_format($t, 0, ',', '.') ?></p>
                                                            <p><b>UNIDADES:</b><?php echo $totalcajas ?></p>

                                                        </div>
                                                        <?php } else {
                                                        $prods = OperationData::getAllProductsBySellIddd($operation->id_venta);
                                                        $t = 0;
                                                        $totalcajas = 0;
                                                        $existe = false;
                                                        foreach ($prods as $prod) {


                                                            if ($_GET['iva'] == "todos") {
                                                                if ($_GET['producto'] == $prod->producto_id) {
                                                                    $existe = true;
                                                                }
                                                            } else {
                                                                $getProducto = ProductoData::getById($prod->producto_id);
                                                                if ($_GET['iva'] == 'menos30') {
                                                                    if ($_GET['producto'] == "todos") {
                                                                        if ($getProducto->impuesto != "30") {

                                                                            $existe = true;
                                                                        }
                                                                    } else {
                                                                        if ($_GET['producto'] == $prod->producto_id && $getProducto->impuesto != "30") {

                                                                            $existe = true;
                                                                        }
                                                                    }
                                                                } else {
                                                                    if ($_GET['producto'] == "todos") {
                                                                        if ($getProducto->impuesto == $_GET['iva']) {
                                                                            $existe = true;
                                                                        }
                                                                    } else {
                                                                        if ($_GET['producto'] == $prod->producto_id && $getProducto->impuesto == $_GET['iva']) {

                                                                            $existe = true;
                                                                        }
                                                                    }
                                                                }
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

                                                                    if ($operation->getCliente()->tipo_doc == "SIN NOMBRE") {
                                                                        echo "X";
                                                                    } else {
                                                                        echo substr($operation->getCliente()->dni, 0, 12);
                                                                    }
                                                                    echo '--' . ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? $operation->getCliente()->tipo_doc
                                                                        : $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido);
                                                                    echo '-- ' . $operation->factura;
                                                                    echo '-- ' .  $operation->metodopago . '-- ';
                                                                    if ($operation->tipo_venta == 4) {
                                                                        echo "Remision";
                                                                    } else if ($operation->tipo_venta == 0) {
                                                                        echo "Venta";
                                                                    } else if ($operation->tipo_venta == 5) {
                                                                        echo "Venta de una remision";
                                                                    } else {
                                                                        echo $operation->tipo_venta;
                                                                    }
                                                                    echo '--' . $metodoPago;
                                                                    echo '--' . $operation->fecha ?>

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
                                                                        if ($operation->tipo_venta == 15) {
                                                                            foreach ($prods as $prod) {
                                                                                $t += $prod->q * $prod->precio;
                                                                                $totalgeneralUSD -= $prod->q * $prod->precio;
                                                                                $totalcajas += $prod->q;
                                                                                $precioGS = $prod->q * $prod->precio * $cambio;
                                                                                $totalgeneralGS -= $precioGS;
                                                                        ?>
                                                                                <tr>
                                                                                    <td><?php echo ProductoData::getById($prod->producto_id)->nombre; ?></td>
                                                                                    <td><?php echo number_format($prod->q, 0, ',', '.') ?></td>
                                                                                    <td><?php echo number_format($prod->precio, 0, ',', '.') ?></td>
                                                                                    <td><?php echo number_format($prod->q * $prod->precio, 0, ',', '.') ?></td>
                                                                                </tr>
                                                                            <?php   }
                                                                        } else {
                                                                            foreach ($prods as $prod) {
                                                                                $t += $prod->q * $prod->precio;
                                                                                $totalgeneralUSD += $prod->q * $prod->precio;

                                                                                $totalcajas += $prod->q;
                                                                                $precioGS = $prod->q * $prod->precio * $cambio;
                                                                                $totalgeneralGS += $precioGS;
                                                                            ?>
                                                                                <tr>
                                                                                    <td><?php echo ProductoData::getById($prod->producto_id)->nombre; ?></td>
                                                                                    <td><?php echo number_format($prod->q, 0, ',', '.') ?></td>
                                                                                    <td><?php echo number_format($prod->precio, 0, ',', '.') ?></td>
                                                                                    <td><?php echo number_format($prod->q * $prod->precio, 0, ',', '.') ?></td>
                                                                                </tr>
                                                                        <?php   }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>
                                                                <p><?php
                                                                    if ($operation->tipo_venta == 15) {
                                                                        $totalGCajas -= $totalcajas;
                                                                    } else {
                                                                        $totalGCajas += $totalcajas;
                                                                    }
                                                                    ?></p>

                                                                <p><b>Total de la operación: <?php echo number_format($t, 0, ',', '.') ?></b></p>
                                                                <p>Cajas:<?php echo $totalcajas ?></p>

                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            }
                                            if ($operation->VerTipoModena()->simbolo != "US$" && ($_GET['moneda'] === "guaranies" || $_GET['moneda'] === "todos")) {
                                                if ($operation->metodopago == "Contado") {
                                                    $creditoGs += $operation->total;
                                                } else {
                                                    $contadoGs += $operation->total;
                                                }
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
                                                switch ($caja->CAJA) {
                                                    case 1:
                                                        $totalGs["efectivo"] += $caja->IMPORTE;
                                                        $metodoPago = "Efectivo";
                                                        break;
                                                    case 2:
                                                        $totalGs["transferencia"] += $caja->IMPORTE;
                                                        $metodoPago = "transferencia";
                                                        break;
                                                    case 3:
                                                        $totalGs["cheque"] += $caja->IMPORTE;
                                                        $metodoPago = "cheque";
                                                        break;
                                                    case 4:
                                                        $totalGs["tarjeta"] += $caja->IMPORTE;
                                                        $metodoPago = "Tarjeta";
                                                        break;
                                                    case 5:
                                                        $totalGs["Retencion"] += $caja->IMPORTE;
                                                        $metodoPago = "Retencion";
                                                        break;
                                                    default:
                                                }
                                                $cambioUsd = $operation->cambio2;
                                                $total = $total + ($operation->total - $operation->descuento) * $cambio;

                                                $totalusd = $totalusd + $operation->total;
                                                if ($operation->cliente_id !== NULL) {
                                                    if ($_GET['producto'] == "todos" && $_GET['iva'] == "todos") {
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

                                                                if ($operation->getCliente()->tipo_doc == "SIN NOMBRE") {
                                                                    echo "X";
                                                                } else {
                                                                    echo substr($operation->getCliente()->dni, 0, 12);
                                                                }
                                                                echo '--' . ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? $operation->getCliente()->tipo_doc
                                                                    : $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido);
                                                                echo '-- ' . $operation->factura;
                                                                echo '-- ' .  $operation->metodopago . '-- ';
                                                                if ($operation->tipo_venta == 4) {
                                                                    echo "Remision";
                                                                } else if ($operation->tipo_venta == 0) {
                                                                    echo "Venta";
                                                                } else if ($operation->tipo_venta == 5) {
                                                                    echo "Venta de una remision";
                                                                } else {
                                                                    echo $operation->tipo_venta;
                                                                }
                                                                echo '--' . $metodoPago;
                                                                echo '--' . $operation->fecha; ?>

                                                            </h4>
                                                            <p>
                                                                Cambio: <?php echo number_format(($cambio), 2, ',', '.') ?>
                                                            </p>
                                                            <table>
                                                                <thead>
                                                                    <th style="width: 300px;">Producto</th>
                                                                    <th style="width: 300px;">Unidades</th>
                                                                    <th style="width: 300px;">Precio</th>
                                                                    <th style="width: 300px;">Total</th>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $prods = OperationData::getAllProductsBySellIddd($operation->id_venta);
                                                                    $t = 0;
                                                                    $totalcajas = 0;
                                                                    if ($operation->tipo_venta == 15) {
                                                                        foreach ($prods as $prod) {
                                                                            $t += $prod->q * $prod->precio;
                                                                            $totalgeneralGS -= $prod->q * $prod->precio;
                                                                            $precioUsd = $prod->q * $prod->precio / $cambioUsd;
                                                                            $totalgeneralUSD -= $precioUsd;
                                                                            // $totalgeneralUSD -= ($prod->q * $prod->precio / $cambio);
                                                                            $totalcajas += $prod->q;

                                                                    ?>
                                                                            <tr>
                                                                                <td><?php echo ProductoData::getById($prod->producto_id)->nombre; ?></td>
                                                                                <td><?php echo number_format($prod->q, 0, ',', '.') ?></td>
                                                                                <td><?php echo number_format($prod->precio, 0, ',', '.') ?></td>
                                                                                <td><?php echo number_format($prod->q * $prod->precio, 0, ',', '.') ?></td>
                                                                            </tr>
                                                                        <?php   }
                                                                    } else {
                                                                        foreach ($prods as $prod) {
                                                                            $t += $prod->q * $prod->precio;
                                                                            $totalgeneralGS += $prod->q * $prod->precio;
                                                                            $totalcajas += $prod->q;
                                                                            $precioUsd = $prod->q * $prod->precio / $cambioUsd;
                                                                            $totalgeneralUSD += $precioUsd;
                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo ProductoData::getById($prod->producto_id)->nombre; ?></td>
                                                                                <td><?php echo number_format($prod->q, 0, ',', '.') ?></td>
                                                                                <td><?php echo number_format($prod->precio, 0, ',', '.') ?></td>
                                                                                <td><?php echo number_format($prod->q * $prod->precio, 0, ',', '.') ?></td>
                                                                            </tr>
                                                                    <?php   }
                                                                    }
                                                                    ?>

                                                                </tbody>
                                                            </table>
                                                            <p><?php
                                                                if ($operation->tipo_venta == 15) {
                                                                    $totalGCajas -= $totalcajas;
                                                                } else {
                                                                    $totalGCajas += $totalcajas;
                                                                }
                                                                ?></p>

                                                            <p><b>TOTAL GENERAL: </b><?php echo number_format($t, 0, ',', '.') ?></p>
                                                            <p><b>UNIDADES:</b><?php echo $totalcajas ?></p>

                                                        </div>
                                                        <?php } else {
                                                        $prods = OperationData::getAllProductsBySellIddd($operation->id_venta);
                                                        $t = 0;
                                                        $totalcajas = 0;
                                                        $existe = false;
                                                        foreach ($prods as $prod) {


                                                            if ($_GET['iva'] == "todos") {
                                                                if ($_GET['producto'] == $prod->producto_id) {
                                                                    $existe = true;
                                                                }
                                                            } else {
                                                                $getProducto = ProductoData::getById($prod->producto_id);
                                                                if ($_GET['iva'] == 'menos30') {
                                                                    if ($_GET['producto'] == "todos") {
                                                                        if ($getProducto->impuesto != "30") {

                                                                            $existe = true;
                                                                        }
                                                                    } else {
                                                                        if ($_GET['producto'] == $prod->producto_id && $getProducto->impuesto != "30") {

                                                                            $existe = true;
                                                                        }
                                                                    }
                                                                } else {
                                                                    if ($_GET['producto'] == "todos") {
                                                                        if ($getProducto->impuesto == $_GET['iva']) {
                                                                            $existe = true;
                                                                        }
                                                                    } else {
                                                                        if ($_GET['producto'] == $prod->producto_id && $getProducto->impuesto == $_GET['iva']) {

                                                                            $existe = true;
                                                                        }
                                                                    }
                                                                }
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

                                                                    if ($operation->getCliente()->tipo_doc == "SIN NOMBRE") {
                                                                        echo "X";
                                                                    } else {
                                                                        echo substr($operation->getCliente()->dni, 0, 12);
                                                                    }
                                                                    echo '--' . ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? $operation->getCliente()->tipo_doc
                                                                        : $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido);
                                                                    echo '-- ' . $operation->factura;
                                                                    echo '-- ' .  $operation->metodopago . '-- ';
                                                                    if ($operation->tipo_venta == 4) {
                                                                        echo "Remision";
                                                                    } else if ($operation->tipo_venta == 0) {
                                                                        echo "Venta";
                                                                    } else if ($operation->tipo_venta == 5) {
                                                                        echo "Venta de una remision";
                                                                    } else {
                                                                        echo $operation->tipo_venta;
                                                                    }
                                                                    echo '--' . $metodoPago;
                                                                    echo '--' . $operation->fecha ?>

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
                                                                        if ($operation->tipo_venta == 15) {
                                                                            foreach ($prods as $prod) {
                                                                                $t += $prod->q * $prod->precio;
                                                                                $totalgeneralGS -= $prod->q * $prod->precio;

                                                                                $totalcajas += $prod->q;
                                                                                $precioUsd = $prod->q * $prod->precio / $cambioUsd;

                                                                                $totalgeneralUSD -= $precioUsd;

                                                                        ?>
                                                                                <tr>
                                                                                    <td><?php echo ProductoData::getById($prod->producto_id)->nombre; ?></td>
                                                                                    <td><?php echo number_format($prod->q, 0, ',', '.') ?></td>
                                                                                    <td><?php echo number_format($prod->precio, 0, ',', '.') ?></td>
                                                                                    <td><?php echo number_format($prod->q * $prod->precio, 0, ',', '.') ?></td>
                                                                                </tr>
                                                                            <?php   }
                                                                        } else {
                                                                            foreach ($prods as $prod) {
                                                                                $t += $prod->q * $prod->precio;
                                                                                $precioUsd = $prod->q * $prod->precio / $cambioUsd;
                                                                                $totalgeneralUSD += $precioUsd;
                                                                                $totalgeneralGS += $prod->q * $prod->precio;
                                                                                $totalcajas += $prod->q;

                                                                            ?>
                                                                                <tr>
                                                                                    <td><?php echo ProductoData::getById($prod->producto_id)->nombre; ?></td>
                                                                                    <td><?php echo number_format($prod->q, 0, ',', '.') ?></td>
                                                                                    <td><?php echo number_format($prod->precio, 0, ',', '.') ?></td>
                                                                                    <td><?php echo number_format($prod->q * $prod->precio, 0, ',', '.') ?></td>
                                                                                </tr>
                                                                        <?php   }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>
                                                                <p><?php
                                                                    if ($operation->tipo_venta == 15) {
                                                                        $totalGCajas -= $totalcajas;
                                                                    } else {
                                                                        $totalGCajas += $totalcajas;
                                                                    }
                                                                    ?></p>

                                                                <p><b>Total de la operación: <?php echo number_format($t, 0, ',', '.') ?></b></p>
                                                                <p>Cajas:<?php echo $totalcajas ?></p>

                                                            </div><?php
                                                                }
                                                            }
                                                        }
                                                    }
                                                } ?>


                                        <h3 style="margin-left: 150px;"><b>Total USD: <?php echo number_format(($totalgeneralUSD), 2, ',', '.') ?></b> <b style="margin-left: 50px;">Total GS: <?php echo number_format(($totalgeneralGS), 2, ',', '.') ?></b></h3>
                                        <p style="margin-left: 400px;"><b>Total unidades:<?php echo $totalGCajas ?><b></p>
                                        <?php
                                        foreach ($totalUsd as $key => $value) {
                                            if ($value > 0) {
                                                echo "<p style='text-transform: capitalize;margin-left: 400px;'>$key (USD): " . number_format($value, 0, '.', '.') . "</p>";
                                            }
                                        }

                                        foreach ($totalGs as $key => $value) {
                                            if ($value > 0) {
                                                echo "<p style='text-transform: capitalize;margin-left: 400px;'>$key (GS): " . number_format($value, 0, '.', '.') . "</p>";
                                            }
                                        }
                                        ?>
                                        <br>
                                    <?php } else {
                                    ?>
                                        <div class="jumbotron " style="background: #fff; margin-left: 100px;">
                                            <h2>No hay ventas</h2>
                                            <p>No se ha realizado ninguna venta.</p>
                                        </div>
                                <?php
                                    }
                                } ?>

                            </div>
                        </div>
                </div>
                </section>
                <script>
                    <?php if (isset($_GET['ed'])) { ?>

                        function exportar() {
                            window.open(`pdfs/ventas.php?&uso_id=&sd=<?php echo $_GET['sd'] ?>&ed=<?php echo $_GET['ed'] ?>&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&prod=<?php echo $_GET['prod'] ?>&venta=<?php echo $_GET['venta'] ?>&cliente=<?php echo $_GET['cliente'] ?>`);

                        }

                        function exportar5() {
                            window.open(`pdfs/cajaventas.php?&uso_id=&sd=<?php echo $_GET['sd'] ?>&ed=<?php echo $_GET['ed'] ?>&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&prod=<?php echo $_GET['prod'] ?>&venta=<?php echo $_GET['venta'] ?>&cliente=<?php echo $_GET['cliente'] ?>&vendedor=<?php echo $_GET['vendedor'] ?>&moneda=<?php echo $_GET['moneda'] ?>&iva=<?php echo $_GET['iva'] ?>`);
                        }

                        function exportar2() {
                            window.location.href = `excels/csvVenta.php?&uso_id=&sd=<?php echo $_GET['sd'] ?>&ed=<?php echo $_GET['ed'] ?>&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&prod=<?php echo $_GET['prod'] ?>&venta=<?php echo $_GET['venta'] ?>&cliente=<?php echo $_GET['cliente'] ?>`;

                        }

                        function exportar4() {
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
                        vendedor = $('#vendedor').val();
                        iva = $('#iva').val();

                        window.location.href = `index.php?view=librocajaventa&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&prod=${product}&producto=${producto}&venta=${v}&cliente=${cliente}&vendedor=${vendedor}&moneda=${$('#moneda').val()}&iva=${iva}`;

                    }
                </script>
            </div>
        <?php endif ?>
    <?php endif ?>