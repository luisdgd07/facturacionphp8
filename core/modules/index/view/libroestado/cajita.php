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
                        ESTADO DE CUENTAS
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
                        REGISTRO DE COBROS
                    </h1>

                </section>

                <!-- Main content -->

                <div class="row">
                    <section class="content">

                        <div class="col-xs-12">
                            <div class="box">
                                <div class="row">
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


                                        <input type="date" name="ed" id="date2" value="<?php echo $_GET['ed'] ?>" class="form-control">

                                        <input type="hidden" style="display: none;" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                                    </div>


                                    <div class="col-lg-2">
                                        <label for="inputEmail1" class="col-lg-1 control-label">Moneda:</label>
                                        <?php
                                        $monedas = MonedaData::cboObtenerValorPorSucursal($_GET['id_sucursal']);
                                        ?>
                                        <select name="tipomoneda_id" id="tipomoneda_id" id1="valor" class="form-control" onchange="tipocambio()">
                                            <option value="todos">Todos</option>
                                            <?php

                                            foreach ($monedas as $moneda) :
                                            ?>
                                                <option selected value="<?php echo $moneda->id_tipomoneda; ?>"><?php echo $moneda->nombre . "-" . $moneda->simbolo; ?></option>
                                            <?php

                                            endforeach; ?>
                                        </select>
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
                                    <button onclick="exportar3()" href="" class="mx-4 my-2 btn btn-success">VER LISTADO</button>


                                </div>
                                <div class="row">
                                    <?php if (isset($_GET["sd"])) {
                                    ?>
                                        <button style="margin-left: 30px;" onclick="exportar2()" href="" class="mx-4 my-2 btn btn-success">EXCEL</button>
                                        <button onclick="exportar()" href="" class="mx-4 my-2 btn btn-success">PDF</button>
                                        <?php

                                        $date1 = $_GET["sd"];
                                        $date2 = $_GET["ed"];
                                        $sucurs = $_GET["id_sucursal"];
                                        $total = 0;
                                        $totall = 0;
                                        ?>
                                        <!-- <button onclick="exportar()" href="" style="margin-left: 30px;" class="mx-4 my-2 btn btn-success">Generar PDF</button>
                                        <button onclick="exportar2()" href="" class="mx-4 my-2 btn btn-success">Generar Excel</button> -->
                                        <h1 style="margin-left: 30px;">Estadode cuentas desde <?php echo $date1 ?> al <?php echo $date2 ?></h1>
                                        <form class="form-horizontal" enctype="multipart/form-data" method="post" action="index.php?action=cobranzacredito" role="form">


                                            <input type="hidden" name="factura" id="num1">
                                            <input type="hidden" name="numeracion_inicial" id="numinicio">
                                            <input type="hidden" name="numeracion_final" id="numfin">
                                            <input type="hidden" name="serie1" id="serie">



                                            <div class="col-md-12">


                                                <?php
                                                $sumatotal = 0;
                                                $suma = 0;
                                                $total1 = 0;
                                                $total2 = 0;

                                                $total3 = 0;

                                                $operations = array();

                                                // if ($_GET["cliente"] == "todos") {
                                                //     $operations = CreditoDetalleData::getAllByDateOp2($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
                                                // } else {
                                                //     $operations = CreditoDetalleData::getAllByDateBCOp2($_GET["cliente"], $_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
                                                // }


                                                ?>




                                                <?php
                                                $nuevafecha =  date($_GET["sd"]);
                                                $n = date("Y-m-d", strtotime($nuevafecha . "- 1 days"));
                                                $usersAnterior = CobroCabecera::totalcobros($_GET['id_sucursal'], $_GET['cliente'], '1988-01-09', $n);
                                                $VentasAnte = CobroCabecera::totalestadocobros($_GET['id_sucursal'], $_GET['cliente'], '1988-01-09', $n);
                                                $totalAnte1 = 0;
                                                $totalAnte2 = 0;
                                                $totalAnte3 = 0;
                                                foreach ($VentasAnte as $v) {
                                                    if ($v->moneda_id == $_GET['moneda'] ||  $_GET['moneda'] == 'todos') {
                                                        $totalAnte2 += $v->credito;
                                                    }
                                                }
                                                foreach ($usersAnterior as $sell) {
                                                    if ($sell->MONEDA_ID == $_GET['moneda'] ||  $_GET['moneda'] == 'todos') {
                                                        $operations = CobroDetalleData::cobranza_credito($sell->COBRO_ID);
                                                        $cred = $operations[0]->IMPORTE_CREDITO;
                                                        $totalAnte1 += $sell->TOTAL_COBRO;
                                                        foreach ($operations as $op) {
                                                            // $totalAnte2 += $op->IMPORTE_CREDITO;
                                                            // $totalAnte3 += ($sell->TOTAL_COBRO - $op->IMPORTE_CREDITO);
                                                        }
                                                    }
                                                }
                                                $totalAnte3 += ($totalAnte2 - $totalAnte1);
                                                // $users = CobroCabecera::totalcobros($_GET['id_sucursal'], $_GET['cliente'], $_GET['sd'], $_GET['ed']);

                                                $users = CobroCabecera::totalcobros($_GET['id_sucursal'], $_GET['cliente'], $_GET['sd'], $_GET['ed']);
                                                // $ret = RetencionData::totalretenciones($sucursales->id_sucursal);


                                                $Ventas = CobroCabecera::totalestadocobros($_GET['id_sucursal'], $_GET['cliente'], $_GET['sd'], $_GET['ed']);
                                                //if(count($users)>0){
                                                // $to = count($Ventas);
                                                // echo $to;
                                                ?>
                                                <table id="example4" class="table table-bordered table-dark" style="width:100%">
                                                    <thead>
                                                        <th>NRO CREDITO</th>

                                                        <th>RECIBO</th>

                                                        <th>CLIENTE</th>
                                                        <th>FACTURA</th>
                                                        <th>IMPORTE COBRADO</th>
                                                        <th>IMPORTE A COBRAR</th>

                                                        <th>SALDO</th>

                                                        <th>FECHA</th>


                                                    </thead>
                                                    <thead>
                                                        <th>Anterior</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th><?php echo  number_format($totalAnte1, 2, ',', '.') ?></th>
                                                        <th><?php echo  number_format($totalAnte2, 2, ',', '.') ?></th>
                                                        <th><?php echo  number_format($totalAnte3, 2, ',', '.') ?></th>
                                                        <th>
                                                            <p style="display: none;">0000-00-00</p>
                                                        </th>


                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>

                                                            </td>

                                                        </tr>
                                                        <?php
                                                        $totalcobro = 0;
                                                        $totalcred = 0;
                                                        $totalsaldo = 0;
                                                        $totalret = 0;
                                                        $totalAnte2 = 0;
                                                        $j = 0;
                                                        foreach ($Ventas as $v) {
                                                            if ($v->moneda_id == $_GET['moneda'] ||  $_GET['moneda'] == 'todos') {
                                                                $totalAnte3 += $v->credito;
                                                                $totalAnte2 += $v->credito;
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $v->id ?></td>
                                                                    <td></td>
                                                                    <td><?php
                                                                        $cliente = ClienteData::getById($v->cliente_id);
                                                                        echo $cliente->nombre ?> </td>
                                                                    <td><?php echo $v->factura ?></td>
                                                                    <td>0,00</td>
                                                                    <td><?php echo  number_format($v->credito, 2, ',', '.') ?></td>
                                                                    <td><?php echo  number_format($totalAnte3, 2, ',', '.') ?></td>
                                                                    <td><?php echo $v->fecha ?></td>
                                                                    <td></td>

                                                                </tr>
                                                            <?php
                                                            }
                                                        }
                                                        $totalcobro = 0;
                                                        $k = 0;
                                                        foreach ($users as $sell) {
                                                            if ($sell->MONEDA_ID == $_GET['moneda'] ||  $_GET['moneda'] == 'todos') {
                                                            ?>
                                                                <?php
                                                                if ($sell) {
                                                                    $operations = CobroDetalleData::cobranza_credito($sell->COBRO_ID);
                                                                    $cred = $operations[0]->IMPORTE_CREDITO;
                                                                    foreach ($operations as $op) {
                                                                        $concepto = CajaCabecera::cajacabeceraconcepto($sell->COBRO_ID);
                                                                        if (isset($concepto[0]->FECHA) && ($concepto[0]->FECHA <= $_GET['ed'] && $concepto[0]->FECHA >= $_GET['sd'])) {
                                                                ?>
                                                                            <tr>
                                                                                <?php
                                                                                // $operations = CobroDetalleData::totalcobrosdet($sell->COBRO_ID );
                                                                                //count($operations);

                                                                                ?>


                                                                                <td><?php
                                                                                    $j++;
                                                                                    // var_dump($op);
                                                                                    echo $op->NUMERO_CREDITO;

                                                                                    ?></td>
                                                                                <td class="width:30px;">

                                                                                    <?php echo $sell->RECIBO; ?>

                                                                                </td>





                                                                                <td class="width:30px;">


                                                                                    <?php if ($sell->getCliente()->tipo_doc == "SIN NOMBRE") {
                                                                                        $sell->getCliente()->tipo_doc;
                                                                                        $cliente = $sell->getCliente()->tipo_doc;
                                                                                        echo $cliente;
                                                                                    } else {
                                                                                        $sell->getCliente()->nombre . " " . $sell->getCliente()->apellido;
                                                                                        $cliente = $sell->getCliente()->nombre . " " . $sell->getCliente()->apellido;

                                                                                        echo $cliente;
                                                                                    }                                                ?>


                                                                                </td>

                                                                                <td><?php echo $op->NUMERO_FACTURA; ?></td>

                                                                                <td><?php
                                                                                    $totalAnte1 += $sell->TOTAL_COBRO;
                                                                                    $totalcobro += $sell->TOTAL_COBRO;
                                                                                    echo
                                                                                    number_format($sell->TOTAL_COBRO, 2, ',', '.');
                                                                                    ?></td>


                                                                                <?php $concepto = CajaDetalle::cajadetllecambio($sell->COBRO_ID); ?>



                                                                                <td><?php echo
                                                                                    '0';
                                                                                    // number_format($op->IMPORTE_CREDITO - $sell->TOTAL_COBRO, 2, ',', '.');
                                                                                    $totalcred += $op->IMPORTE_CREDITO;
                                                                                    ?></td>


                                                                                <td><?php
                                                                                    $totalAnte3 -= $sell->TOTAL_COBRO;
                                                                                    // $cred = $totalAnte3;
                                                                                    // $cred -= $totalAnte3 + $sell->TOTAL_COBRO;
                                                                                    // $totalsaldo += $cred;
                                                                                    echo
                                                                                    number_format($totalAnte3, 2, ',', '.'); ?></td>









                                                                                <td><?php
                                                                                    echo $sell->FECHA_COBRO;
                                                                                    // echo $operations
                                                                                    // $concepto = CajaCabecera::cajacabeceraconcepto($sell->COBRO_ID);
                                                                                    // var_dump($concepto);
                                                                                    // echo $concepto[0]->FECHA;
                                                                                    ?>
                                                                                </td>

                                                                                <?php $concepto = CajaCabecera::cajacabeceraconcepto($sell->COBRO_ID); ?>
                                                                                <?php

                                                                                foreach ($concepto as $cobrosdet) {
                                                                                    if ($cobrosdet) {


                                                                                        $conceptos = $cobrosdet->concepto;
                                                                                    }
                                                                                }

                                                                                ?>

                                                                                <!-- <td>
                                                                                <?php
                                                                                $totalRetencion = 0;
                                                                                $facturas = RetencionDetalleData::retencionfactura($op->NUMERO_FACTURA);
                                                                                // var_dump($facturas);
                                                                                foreach ($facturas as $fact) {
                                                                                    $totalRetencion += (float) $fact->importe;
                                                                                }
                                                                                $totalret += $totalRetencion;
                                                                                echo
                                                                                number_format($totalRetencion, 2, ',', '.');
                                                                                ?>
                                                                            </td> -->



                                                                            </tr>

                                                        <?php
                                                                        }
                                                                    }
                                                                }
                                                                $k++;
                                                            }
                                                        }
                                                        // }else{
                                                        // echo "<p class='alert alert-danger'>No hay cobro realizado</p>";
                                                        //}
                                                        ?>
                                                        <tr>
                                                            <td><b>Total</b></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><b><?php echo       number_format($totalcobro, 2, ',', '.'); ?></b></td>
                                                            <td><b><?php echo
                                                                    number_format($totalAnte2, 2, ',', '.');
                                                                    ?></b></td>
                                                            <td><b><?php echo
                                                                    number_format($totalAnte3, 2, ',', '.');
                                                                    ?></b></td>
                                                            <td>
                                                                <p style="display: none;">9999-12-12</p>
                                                            </td>

                                                        </tr>
                                                    </tbody>
                                                </table>







                                            </div>







                                        </form>


                                    <?php
                                    }
                                    ?>
                                </div>


                            </div>
                        </div>
                </div>
                </section>
                <script>
                    <?php if (isset($_GET['sd'])) { ?>

                        function exportar() {
                            date1 = document.getElementById("date1").value;
                            date2 = document.getElementById("date2").value;
                            cliente = $('#cliente_id').val();
                            id_sucursal = document.getElementById("id_sucursal").value;
                            window.open(`pdfs/estadosDetallado.php?sd=<?php echo $_GET['sd'] ?>&ed=<?php echo $_GET['ed'] ?>&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&cliente=<?php echo $_GET['cliente'] ?>`);



                        }


                        function exportar2() {
                            date1 = document.getElementById("date1").value;
                            date2 = document.getElementById("date2").value;
                            cliente = $('#cliente_id').val();
                            id_sucursal = document.getElementById("id_sucursal").value;

                            window.location.href = `excels/csvestadodetalle.php?sd=<?php echo $_GET['sd'] ?>&ed=<?php echo $_GET['ed'] ?>&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&cliente=<?php echo $_GET['cliente'] ?>`;

                        }
                    <?php } ?>

                    function exportar3() {
                        date1 = document.getElementById("date1").value;
                        date2 = document.getElementById("date2").value;
                        cliente = $('#cliente_id').val();
                        id_sucursal = document.getElementById("id_sucursal").value;

                        window.location.href = `index.php?view=libroestado&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&cliente=${cliente}&moneda=${$('#tipomoneda_id').val()}`;

                    }
                </script>
                <script>
                    $(function() {

                        $('#example3').DataTable({
                            'paging': true,
                            'lengthChange': true,
                            'searching': true,
                            'ordering': true,
                            'info': false,
                            'autoWidth': true
                        })
                    })
                </script>
            </div>
        <?php endif ?>
    <?php endif ?>