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
                    Reporte de productos general
                    <small> </small>
                </h1>
            </section>
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <div class="panel-body">
                            <input type="hidden" name="view" value="reporteproductoss">
                            <div class="row">
                                <div class="col-md-3">



                                    <select name="tipo" id="tipo" class="form-control">

                                        <?php $Tipoprod = ProductoData::verPRODTIPOSUC($sucursales->id_sucursal);
                                        if (count($Tipoprod) > 0) { ?>
                                            <option value="todos">Todos los tipos</option>
                                            <?php foreach ($Tipoprod as $Tipoprods) : ?>
                                                <option value="<?php echo $Tipoprods->ID_TIPO_PROD; ?>"><i class="fa fa-gg"></i><?php echo $Tipoprods->TIPO_PRODUCTO; ?></option>
                                        <?php endforeach;
                                        } ?>

                                    </select>
                                </div>
                                <div class="col-md-3">



                                    <select name="marca" id="marca" class="form-control">

                                        <?php $Tipoprod = MarcaData::vermarcasucursal($sucursales->id_sucursal);
                                        if (count($Tipoprod) > 0) { ?>
                                            <option value="todos">Todas las tipologías</option>
                                            <?php foreach ($Tipoprod as $Tipoprods) : ?>
                                                <option value="<?php echo $Tipoprods->id_marca; ?>"><i class="fa fa-gg"></i><?php echo $Tipoprods->nombre; ?></option>
                                        <?php endforeach;
                                        } ?>

                                    </select>
                                </div>
                                <div class="col-md-3">



                                    <select name="categoria" id="categoria" onchange=" getcategoria()" class="form-control">


                                        <option value="todos">Todas las categorias</option>
                                        <?php $products = CategoriaData::vercategoriassucursal($_GET['id_sucursal']);
                                        if (count($products) > 0) {
                                            foreach ($products as $p) : ?>
                                                <option value=" <?php echo $p->id_categoria; ?>"><?php echo $p->nombre ?></option>
                                        <?php endforeach;
                                        } ?>

                                    </select>
                                </div>
                                <div class="col-md-3">



                                    <select name="product" id="products" class="form-control">

                                    </select>
                                </div>
                                <div class="col-md-3">



                                    <select name="product" id="estado" class="form-control">
                                        <option value="1">Disponible</option>
                                        <option value="2">Deshabilitado</option>
                                        <option value="3">En Construcción</option>
                                        <option value="4">Reservado</option>
                                    </select>
                                </div>
                                <!-- <div class="col-md-3">



                    <select required="" name="categoria" class="form-control">

                      <option value="todos">Todas la categorias</option>
                      <?php $clientes = CategoriaData::vercategoriassucursal($sucursales->id_sucursal);
                        if (count($clientes) > 0) {
                            foreach ($clientes as $p) : ?>
                          <option value="<?php echo $p->id_categoria; ?>"><?php echo $p->nombre; ?></option>
                      <?php endforeach;
                        } ?>
                    </select>
                  </div> -->





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


                            </div>
                            <div class="row" style="margin-top: 14px">

                                <div class="col-md-4">

                                    <span>
                                        DESDE:
                                    </span>
                                    <input type="date" min="2023-01-01" name="sd" id="date1" value="<?php echo $_GET['sd'] ?>" class="form-control">


                                </div>
                                <div class="col-md-4">
                                    <span>
                                        HASTA:
                                    </span>


                                    <input type="date" min="2023-01-01" name="ed" id="date2" value="<?php echo $_GET['ed'] ?>" class="form-control">

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
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="submit" class="btn btn-success btn-block" onclick="ver()" value="Ver listado">
                                    <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">

                                </div>
                            </div>

                            <br>


                            <input type="hidden" name="factura" id="num1">
                            <input type="hidden" name="numeracion_inicial" id="numinicio">
                            <input type="hidden" name="numeracion_final" id="numfin">
                            <input type="hidden" name="serie1" id="serie">



                            <div class="col-md-12">


                                <?php if (isset($_GET['categoria'])) {
                                    $sd = date("d-m-Y", strtotime($_GET['sd']));
                                    $ed = date("d-m-Y", strtotime($_GET['ed']));
                                    echo '<h3> Reporte de productos desde: ' . $sd . ' Hasta: ' . $ed . '</h3>';
                                ?>

                                    <button onclick="exportar()" href="" style="margin-left: -20px;" class="mx-4 my-2 btn btn-success">Generar PDF</button>
                                    <br>
                                    <br>
                                    <?php
                                    $operationData = ProductoData::getproductos($_GET['id_sucursal'], $_GET['producto'], $_GET['categoria'], $_GET['tipo'], 'todos', $_GET['marca'], $_GET['estado']);
                                    // if ($_GET['categoria'] == 'todos' && $_GET['producto'] == 'todos') {

                                    //     $operationData = ProductoData::verproductosucursal($_GET['id_sucursal']);
                                    // } else if ($_GET['categoria'] != 'todos' && $_GET['producto'] == 'todos') {
                                    //     $operationData = ProductoData::verproductoscate($_GET['categoria']);
                                    // } else if ($_GET['producto'] != 'todos') {
                                    //     $operationData = ProductoData::getProducto2($_GET['producto']);
                                    // }
                                    $products = VentaData::versucursaltipotrans($_GET['id_sucursal']);
                                    foreach ($operationData as $op) {
                                        $stocks2 = StockData::vercontenidos($op->id_producto);
                                    ?>
                                        <?php
                                        // $concepto = ProductoData::categorian($op->categoria_id);
                                        $concepto = [];
                                        ?>
                                        <?php
                                        $opert = OperationData::getByProductoId4($_GET['id_sucursal'], $op->id_producto, $_GET['sd'], $_GET['ed']);
                                        // var_dump($opert);
                                        foreach ($concepto as $cambios) {
                                            if ($cambios) {


                                                $categ = $cambios->nombre;
                                            }
                                        }

                                        ?>
                                        <b> <?php echo $op->codigo;
                                            ?> </b>

                                        <b>-- <?php echo $op->nombre ?></b>

                                        <b> -- Stock Actual: <?php
                                                                $stock = StockData::vercontenidos2($op->id_producto);
                                                                echo $stock->CANTIDAD_STOCK;
                                                                ?></b>


                                        <?php $concepto = ProductoData::deposito($stock->DEPOSITO_ID);

                                        foreach ($concepto as $cambios) {
                                            if ($cambios) {


                                                $camnbio = $cambios->NOMBRE_DEPOSITO;
                                            }
                                        }

                                        ?>

                                        <b>-- Almacen: <?php echo $camnbio; ?></b>


                                        <?php

                                        $nuevafecha =  date($_GET["sd"]);
                                        $n = date("Y-m-d", strtotime($nuevafecha . "- 1 days"));
                                        $opertAnte = OperationData::getByProductoId4($_GET['id_sucursal'], $op->id_producto, '2022-12-29', $n);

                                        $anterior = $stock->CANTIDAD_STOCK; ?>
                                        <table class="table table-bordered table-hover table-responsive ">
                                            <thead>
                                                <th style="width: 50px;">FECHA</th>

                                                <th style="width: 50px;">ENTRADA</th>
                                                <th style="width: 50px ;">SALIDA</th>
                                                <th style="width: 50px;">STOCK</th>

                                            </thead>
                                            <?php
                                            if ($opert > 0) {
                                                foreach ($opert as $op) {
                                            ?>
                                                    <tr style="display:none">
                                                        <td><?php echo $op->fecha ?> </td>

                                                        <?php if ($op->accion_id == 1) {
                                                            $anterior -= $op->q;
                                                        ?>
                                                            <td>
                                                                <?php
                                                                echo  $op->q; ?></td>
                                                            <td>0,00</td>
                                                        <?php
                                                        } else if ($op->accion_id == 2) {
                                                            $anterior += $op->q;
                                                        ?>
                                                            <td>0,00</td>
                                                            <td>
                                                                <?php
                                                                echo  $op->q; ?></td>

                                                        <?php
                                                        }  ?>


                                                        <td><?php echo $anterior; ?></td>

                                                    </tr>
                                                <?php } ?>
                                            <?php
                                            } ?>
                                            <?php
                                            $ante1 = 0;
                                            $ante2 = 0;
                                            $ante3 = 0;
                                            $total1 = 0;
                                            $total2 = 0;

                                            if (isset($opertAnte[0])) {
                                            ?>
                                                <tr>
                                                    <td>
                                                        <b>Anterior</b>
                                                    </td>
                                                    <?php if ($opertAnte[0]->accion_id == 1) {
                                                        $anterior -= $opertAnte[0]->q;
                                                    ?>
                                                        <td> <b>
                                                                <?php
                                                                echo  $opertAnte[0]->q; ?></b></td>
                                                        <td><b>0,00</b></td>
                                                    <?php
                                                    } else if ($opertAnte[0]->accion_id == 2) {
                                                        $anterior += $opertAnte[0]->q;
                                                    ?>
                                                        <td><b>0,00</b> </td>
                                                        <td> <b>
                                                                <?php
                                                                echo  $opertAnte[0]->q; ?></b></td>

                                                    <?php
                                                    }  ?>

                                                    <td>
                                                        <b><?php
                                                            if ($opertAnte[0]->accion_id == 1) {
                                                                $anterior += $opertAnte[0]->q;
                                                            } else if ($opertAnte[0]->accion_id == 2) {
                                                                $anterior -= $opertAnte[0]->q;
                                                            }
                                                            echo $anterior ?></b>
                                                    </td>
                                                </tr>




                                            <?php } else {
                                                $anterior = 0;
                                            ?>
                                                <tr>
                                                    <td>
                                                        <b>Anterior</b>
                                                    </td>

                                                    <td>
                                                        0,00
                                                    </td>
                                                    <td>
                                                        0,00
                                                    </td>
                                                    <td>
                                                        0,00
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            if ($opert > 0) {
                                                $opert = array_reverse($opert);
                                                foreach ($opert as $op) {
                                                ?>
                                                    <tr style="">
                                                        <td><?php echo $op->fecha ?> </td>

                                                        <?php if ($op->accion_id == 1) {
                                                            $total1 += $op->q;
                                                            $anterior += $op->q;
                                                        ?>
                                                            <td>
                                                                <?php
                                                                echo  $op->q; ?></td>
                                                            <td>0,00</td>
                                                        <?php
                                                        } else if ($op->accion_id == 2) {
                                                            $total2 += $op->q;
                                                            $anterior -= $op->q;
                                                        ?>
                                                            <td>0,00</td>
                                                            <td>
                                                                <?php
                                                                echo  $op->q; ?></td>

                                                        <?php
                                                        }  ?>


                                                        <td><?php echo $anterior; ?></td>

                                                    </tr>
                                            <?php
                                                }
                                            } ?>
                                            <tr>
                                                <td><b>Total: </b></td>
                                                <td><b><?php echo $total1 ?></b></td>
                                                <td><b><?php echo $total2 ?></b></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>


                                        </table>
                                    <?php  } ?>


                                    <br>
                                    <hr>


                                    <div class="row">
                                        <div class="col-lg-2">


                                            <!-- <h3>Total: <?php echo  number_format($total, 2, ',', ' '); ?></h3> -->



                                        </div>


                                    </div>




                                    <div class="row">



                                    </div>
                                    <div class="form-group">

                                    <?php } ?>

                                    </div>
                                <?php else :
                                // si no hay operaciones
                                ?>
                                    <script>
                                        $("#wellcome").hide();
                                    </script>
                                    <div class="jumbotron">
                                        <h2>No hay registro de productos</h2>
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









                        </div>
                    </div>
                </div>

            </section>
        </div>


    <?php endif ?>
    <script>
        <?php if (isset($_GET['sd'])) { ?>

            function exportar() {
                date1 = document.getElementById("date1").value;
                date2 = document.getElementById("date2").value;
                cliente = $('#cliente_id').val();
                id_sucursal = document.getElementById("id_sucursal").value;
                // window.open(`pdfproductos.php?sd=<?php echo $_GET['sd'] ?>&ed=<?php echo $_GET['ed'] ?>&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&categoria=<?php echo $_GET['categoria'] ?>&producto=<?php echo $_GET['producto'] ?>`);
                window.open(`pdfs/stock.php?sd=<?php echo $_GET['sd'] ?>&ed=<?php echo $_GET['ed'] ?>&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&categoria=<?php echo $_GET['categoria'] ?>&producto=<?php echo $_GET['producto'] ?>&tipo=<?php echo $_GET['tipo'] ?>&marca=<?php echo $_GET['marca'] ?>&estado=<?php echo $_GET['estado'] ?>`);
                // /pdfs/operaciones.php

            }


            function exportar2() {
                date1 = document.getElementById("date1").value;
                date2 = document.getElementById("date2").value;
                cliente = $('#cliente_id').val();
                id_sucursal = document.getElementById("id_sucursal").value;

                window.open(`excels/csvproductos.php?sd=<?php echo $_GET['sd'] ?>&ed=<?php echo $_GET['ed'] ?>&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&categoria=<?php echo $_GET['categoria'] ?>&producto=<?php echo $_GET['producto'] ?>`);

            }
        <?php } ?>

        function ver() {
            date1 = document.getElementById("date1").value;
            date2 = document.getElementById("date2").value;
            const fechaLimite = new Date("2022-12-31");
            if (new Date(date1) < fechaLimite || new Date(date2) < fechaLimite) {

                alert("Seleccione una fecha valida");

            } else {
                window.location.href = `index.php?view=reportestockproductos&sd=${date1}&ed=${date2}&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&categoria=${$('#categoria').val()}&producto=${$('#products').val()}&tipo=${$('#tipo').val()}&marca=${$('#marca').val()}&estado=${$('#estado').val()}`
            }
        }

        function getcategoria() {
            // getAllByCategoriaId(
            console.log('22');
            $.ajax({

                url: "index.php?action=vercategorias",
                type: "GET",
                data: {
                    categoria: $('#categoria').val(),
                    sucursal: <?php echo $_GET['id_sucursal'] ?>
                },

                success: function(json) {
                    // ` < option value = "todos" > Todos los productos < /option>`
                    json = JSON.parse(json);
                    try {
                        var select = `<option value="todos">Todos los productos</option>`;

                        for (var i = 0; i < json.length; i++) {
                            console.log(json[i]);
                            select += `<option value="${json[i].id_producto}">${json[i].nombre}</option> `
                        }
                        $("#products").html(select);
                    } catch (e) {
                        console.log(e)
                        // Swal.fire({

                    }

                },

            })
        }
        console.log('213123')
        getcategoria()
    </script>