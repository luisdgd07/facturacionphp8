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
              <form>
                <input type="hidden" name="view" value="reporteproductos">
                <div class="row">

                  <div class="col-md-3">



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
                  <div class="col-md-3">
                    <input type="date" name="sd" id="sd" value="<?php if (isset($_GET["sd"])) {
                                                                  echo $_GET["sd"];
                                                                } ?>" class="form-control">
                  </div>
                  <div class="col-md-3">
                    <input type="date" name="ed" id="ed" value="<?php if (isset($_GET["ed"])) {
                                                                  echo $_GET["ed"];
                                                                } ?>" class="form-control">
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

                  <div class="col-md-3">
                    <input type="submit" class="btn btn-success btn-block" value="Procesar">
                    <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">

                  </div>
                </div>
              </form>

              <br>
              <form class="form-horizontal" enctype="multipart/form-data" method="post" action="index.php?action=cobranzacredito" role="form">


                <input type="hidden" name="factura" id="num1">
                <input type="hidden" name="numeracion_inicial" id="numinicio">
                <input type="hidden" name="numeracion_final" id="numfin">
                <input type="hidden" name="serie1" id="serie">



                <div class="col-md-12">


                  <?php if (isset($_GET['product'])) { ?>
                    <table id="example1" class="table table-bordered table-hover table-responsive ">
                      <thead>
                        <th style="width: 50px !important;">Codigo</th>
                        <th style="width: 50px;">Producto</th>
                        <!-- <th style="width: 50px;">Stock</th> -->
                        <th style="width: 50px;">Cantidad</th>
                        <th style="width: 50px;">Stock Actual</th>
                        <th style="width: 50px;">Motivo</th>

                        <th style="width: 50px;">Tipo Transaccion</th>

                        <th style="width: 50px;">Deposito</th>

                        <th style="width: 50px;">Categoria</th>

                        <th style="width: 50px;">Fecha</th>
                      </thead>
                      <?php

                      if ($_GET['product'] == 'todos') {
                        $operationData = OperationData::verTransacciones3($_GET['id_sucursal'], $_GET['sd'], $_GET['ed']);
                      } else {
                        $operationData = OperationData::verTransacciones2($_GET['id_sucursal'], $_GET['product'], $_GET['sd'], $_GET['ed']);
                      }
                      foreach ($operationData as $op) {
                      ?>

                        <tr>
                          <td><?php echo $op->id_proceso ?> </td>

                          <td><?php echo $op->getProducto()->nombre ?></td>
                          <!-- <td><?php echo $op->getProducto()->nombre ?></td> -->
                          <td><?php echo $op->stock_trans ?></td>
                          <td><?php
                              $stock = StockData::vercontenidos3($op->producto_id, $op->deposito);
                              echo $stock->CANTIDAD_STOCK;  ?></td>
                          <td><?php echo $op->motivo ?></td>
                          <td><?php echo $op->getProducto()->nombre ?></td>
                          <td><?php echo $op->deposito ?></td>
                          <td><?php echo $op->getProducto()->categoria_id ?></td>
                          <td><?php echo $op->fecha ?></td>
                        </tr>




                    </table>
                  <?php } ?>
                  <br>
                  <hr>


                  <div class="row">
                    <div class="col-lg-2">


                      <!-- <h3>Total: <?php echo  number_format($total, 2, ',', ' '); ?></h3> -->



                    </div>


                  </div>




                  <div class="row">


                    <div class="col-lg-2 ">
                      <a class="btn btn-success mt-4" href="impresionestado.php?cliente_id=<?= $_GET['cliente_id'] ?>&sd=<?= $_GET['sd'] ?>&ed=<?= $_GET['ed'] ?>&id_sucursal=<?= $_GET['id_sucursal'] ?>"> Imprimir</a>

                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">De Fecha:</label>
                    <div class="col-lg-2">
                      <input type="date" class="form-control" name="direccion" id="direccion" value="<?php echo $_GET["sd"]; ?>">
                    </div>
                    <label for="inputEmail1" class="col-lg-2 control-label">A Fecha:</label>
                    <div class="col-lg-2">
                      <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $_GET["ed"]; ?>">
                    </div>
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







              </form>


            </div>
          </div>
        </div>
      </section>
    </div>

  <?php endif ?>