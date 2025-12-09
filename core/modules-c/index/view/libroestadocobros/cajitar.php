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
                                    <button onclick="exportar3()" href="" class="mx-4 my-2 btn btn-success">Listar Cobros</button>
                                    <button onclick="exportar()" href="" class="mx-4 my-2 btn btn-success">Generar PDF</button>
                                    <button onclick="exportar2()" href="" class="mx-4 my-2 btn btn-success">Generar Excel</button>

                                </div>
                                <div class="row">
                                    <?php if (isset($_GET["sd"])) {
                                    ?>
                                        <?php

                                        $date1 = $_GET["sd"];
                                        $date2 = $_GET["ed"];
                                        $sucurs = $_GET["id_sucursal"];
                                        $total = 0;
                                        $totall = 0;
                                        ?>
                                        <h1>Cobranzas desde <?php echo $date1 ?> al <?php echo $date2 ?></h1>
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

                                                if ($_GET["cliente"] == "todos") {
                                                    $operations = CreditoDetalleData::getAllByDateOp2($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
                                                } else {
                                                    $operations = CreditoDetalleData::getAllByDateBCOp2($_GET["cliente"], $_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
                                                }
                                                foreach ($operations as $credy) :

                                                    // aca obtenfo el simbolo de la mondeda
                                                    $ventas2 = MonedaData::cboObtenerValorPorSucursal2($credy->sucursal_id, $credy->moneda_id);
                                                    if (count($ventas2) > 0) {

                                                        $simbolomon = 0;
                                                        foreach ($ventas2 as $simbolos) {
                                                            $simbolomon = $simbolos->simbolo;
                                                        }
                                                    }


                                                ?>




                                                <?php





                                                endforeach; ?>
                                                <?php
                                                $users = CobroCabecera::totalcobros($_GET['id_sucursal'], $_GET['cliente'], $_GET['sd'], $_GET['ed']);
                                                // var_dump($users);

                                                //if(count($users)>0){


                                                ?>
                                                <table id="example1" class="table table-bordered table-dark" style="width:100%">
                                                    <thead>
                                                        <th>Nro credito</th>

                                                        <th>Recibo</th>

                                                        <th>Cliente</th>

                                                        <th>Importe cobro</th>
                                                        <th>Importe Credito</th>

                                                        <th>Saldo</th>

                                                        <th>Fecha Cobro</th>
                                                        <th>Factura</th>
                                                    



                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($users as $sell) {
                                                            if ($sell) {
                                                                $operations = CobroDetalleData::cobranza_credito($sell->COBRO_ID);
                                                                $cred = $operations[0]->IMPORTE_CREDITO;
                                                                foreach ($operations as $op) {

                                                        ?>
                                                                    <tr>
                                                                        <?php
                                                                        // $operations = CobroDetalleData::totalcobrosdet($sell->COBRO_ID );
                                                                        //count($operations);

                                                                        ?>


                                                                        <td><?php

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






                                                                        <td><?php
                                                                            echo $sell->TOTAL_COBRO
                                                                            ?></td>


                                                                        <?php $concepto = CajaDetalle::cajadetllecambio($sell->COBRO_ID); ?>



                                                                        <td><?php echo $op->IMPORTE_CREDITO; ?></td>


                                                                        <td><?php
                                                                            $cred -= $sell->TOTAL_COBRO;
                                                                            echo $cred; ?></td>









                                                                        <td><?php echo $sell->FECHA_COBRO; ?></td>

                                                                        <?php $concepto = CajaCabecera::cajacabeceraconcepto($sell->COBRO_ID); ?>
                                                                        <?php

                                                                        foreach ($concepto as $cobrosdet) {
                                                                            if ($cobrosdet) {


                                                                                $conceptos = $cobrosdet->concepto;
                                                                            }
                                                                        }

                                                                        ?>
                                                                        <td><?php echo $op->NUMERO_FACTURA; ?></td>

                                                                      



                                                                    </tr>
                                                        <?php
                                                                }
                                                            }
                                                        }
                                                        // }else{
                                                        // echo "<p class='alert alert-danger'>No hay cobro realizado</p>";
                                                        //}
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <!-- <table id="example1" class="table table-bordered table-hover table-responsive ">
                                                <thead>
                                                    <th style="width: 50px !important;">Nº Crédito</th>
                                                    <th style="width: 50px;">Nº Factura</th>
                                                    <th style="width: 50px;">Cuota</th>
                                                    <th style="width: 50px;">Mon</th>

                                                    <th style="width: 50px;">Importe Crédito</th>
                                                    <th style="width: 50px;">Importe Cobro</th>
                                                    <th style="width: 50px;">Saldo</th>
                                                    <th style="width: 50px;">Fecha Crédito</th>
                                                    <th style="width: 50px;">Tipo Venta</th>
                                                </thead>
                                                

                                            </table> -->







                                            </div>







                                        </form>


                                    <?php }
                                    ?>
                                </div>


                            </div>
                        </div>
                </div>
                </section>
                <script>
                    function exportar() {
                        date1 = document.getElementById("date1").value;
                        date2 = document.getElementById("date2").value;
                        cliente = $('#cliente_id').val();
                        id_sucursal = document.getElementById("id_sucursal").value;
                        window.open( `impresioncobros.php?sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&cliente=${cliente}`);
				

                    }


                    function exportar2() {
                        date1 = document.getElementById("date1").value;
                        date2 = document.getElementById("date2").value;
                        cliente = $('#cliente_id').val();
                        id_sucursal = document.getElementById("id_sucursal").value;

                        window.location.href = `csvestado.php?sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&cliente=${cliente}`;

                    }

                    function exportar3() {
                        date1 = document.getElementById("date1").value;
                        date2 = document.getElementById("date2").value;
                        cliente = $('#cliente_id').val();
                        id_sucursal = document.getElementById("id_sucursal").value;

                        window.location.href = `index.php?view=libroestadocobros&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&cliente=${cliente}`;

                    }
                </script>
            </div>
        <?php endif ?>
    <?php endif ?>