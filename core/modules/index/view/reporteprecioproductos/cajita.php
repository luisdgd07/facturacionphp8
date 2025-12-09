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



                                    <select name="product" id="categoria" onchange=" getcategoria()" class="form-control">


                                        <option value="todos">Todos las categorias</option>
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
                                <!-- <div class="col-md-2">
                                    <div>
                                        <?php
                                        $monedas = MonedaData::cboObtenerValorPorSucursal($_GET['id_sucursal']);
                                        $cambios = MonedaData::obtenerCambioMonedaPorSimbolo($_GET['id_sucursal'], "US$");
                                        $cambio1 = $cambios[0]->valor2;

                                        $cambios2 = MonedaData::obtenerCambioMonedaPorSimbolo($_GET['id_sucursal'], "₲");

                                        $cambio2 = $cambios2[0]->valor2;

                                        $cambio = $cambio2;

                                        ?>
                                        <select required="" name="tipomoneda_id2" id="tipomoneda_id2" id1="valor" class="form-control" oninput="tipocambio()">
                                            <?php
                                            $i = 0;
                                            foreach ($monedas as $moneda) : ?>
                                                <?php
                                                $valocito = null;
                                                $i++;
                                                if ($i == 1) {
                                                ?>
                                                    <option selected value="<?php echo $moneda->id_tipomoneda; ?>"><?php echo $moneda->nombre . "-" . $moneda->simbolo; ?></option>
                                                <?php } else {

                                                ?> 
                                                    <option value="<?php echo $moneda->id_tipomoneda; ?>"><?php echo $moneda->nombre . "-" . $moneda->simbolo; ?></option>
                                            <?php
                                                }

                                            endforeach; ?>
                                        </select>
                                    </div>
                                </div> -->
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
                                ?>
                                    <h3> Reporte de precio de productos </h3>
                                    <button onclick="exportar()" href="" style="margin-left: -20px;" class="mx-4 my-2 btn btn-success">Generar PDF</button>
                                    <button onclick="exportar2()" href="" class="mx-4 my-2 btn btn-success">Generar Excel</button>
                                    <br>
                                    <br>
                                    <table>
                                        <thead>
                                            <th style="width: 10%;">Codigo</th>

                                            <th style="width: 30%;">Nombre</th>
                                            <th style="width: 10% ;">Stock Actual</th>
                                            <th style="width: 10% ;">Precio</th>
                                            <th style="width: 10% ;">Total</th>

                                        </thead>
                                        <tbody>
                                            <?php
                                            $operationData = ProductoData::getproductos($_GET['id_sucursal'], $_GET['producto'], $_GET['categoria'], $_GET['tipo'], $_GET['iva']);
                                            $total = 0;
                                            $products = VentaData::versucursaltipotrans($_GET['id_sucursal']);
                                            foreach ($operationData as $op) {
                                                $precio = 0;
                                                $q = 0;
                                                // $extraerdata  = ProductoData::listar_precio_productos_moneda($op->id_producto, $_GET['moneda']);
                                                // if (count($extraerdata) > 0) {
                                                //     foreach ($extraerdata as $data) {
                                                //         $precio = $data->IMPORTE;
                                                //     }
                                                // }

                                            ?>
                                                <tr>
                                                    <td> <?php echo $op->codigo;
                                                            ?> </td>

                                                    <td> <?php echo $op->nombre ?></td>

                                                    <td><?php
                                                        $stock = StockData::vercontenidos2($op->id_producto);
                                                        echo $stock->CANTIDAD_STOCK;
                                                        ?>
                                                    </td>
                                                    <td><?php
                                                        echo number_format(($op->precio_compra), 2, ',', '.');
                                                        ?>
                                                    </td>
                                                    <td><?php
                                                        echo number_format(($op->precio_compra * $stock->CANTIDAD_STOCK), 2, ',', '.');
                                                        ?>
                                                    </td>



                                                </tr>
                                            <?php
                                                $t = ($op->precio_compra * $stock->CANTIDAD_STOCK);
                                                $total += $t;
                                            } ?>



                                            <tr>
                                                <td style="width: 30%;">Total</td>
                                                <td style="width: 10% ;"></td>
                                                <td style="width: 10% ;"></td>
                                                <td style="width: 10% ;"></td>
                                                <td style="width: 10% ;"><?php echo number_format($total, 2, ',', '.'); ?></td>

                                            </tr>
                                        </tbody>
                                    <?php } ?>
                                    </table>
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
        function exportar() {
            window.open(`pdfs/precios.php?&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&categoria=<?php echo $_GET['categoria'] ?>&producto=<?php echo $_GET['producto'] ?>&tipo=<?php echo $_GET['tipo'] ?>&iva=<?php echo $_GET['iva'] ?>`);
        }


        function exportar2() {
            date1 = document.getElementById("date1").value;
            date2 = document.getElementById("date2").value;
            cliente = $('#cliente_id').val();
            id_sucursal = document.getElementById("id_sucursal").value;

            window.open(`excels/csvproductos.php?sd=<?php echo $_GET['sd'] ?>&ed=<?php echo $_GET['ed'] ?>&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&categoria=<?php echo $_GET['categoria'] ?>&producto=<?php echo $_GET['producto'] ?>`);

        }

        function ver() {
            window.location.href = `index.php?view=reporteprecioproductos&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&categoria=${$('#categoria').val()}&producto=${$('#products').val()}&tipo=${$('#tipo').val()}&iva=${$('#iva').val()}`

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