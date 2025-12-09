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
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1><i class='fa fa-gift' style="color: orange;"></i>
            MOVIMIENTO DE STOCK (ENTRADA/SALIDA)
          </h1>
          <input name="id_depositopro" id="id_depositopro" value="<?php echo $id_dep; ?>222">

        </section>
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">

                  <div class="box box-warning">
                    <div class="box-header">
                      <!-- <h1>PRODUCTOS</h1> -->
                      <!-- <i class="fa fa-ticket"></i> Nuevo Cliente -->
                      <i class="fa fa-laptop" style="color: orange;"></i> INGRESE EL NOMBRE O CODIGO PARA PODER REALIZAR LA BUSQUEDA.
                    </div>
                    <form id="transaccioness">
                      <div class="row">
                        <div class="col-md-9">
                          <input type="hidden" name="view" value="transacciones">
                          <input type="text" id="nombre" name="producto" class="form-control">
                        </div>
                        <div class="col-md-3">
                          <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                          <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                        </div>
                      </div>
                    </form>

                  </div>

                  <div id="resultado_productos"></div>
                  <?php if (isset($_SESSION["cart"])) :
                    $total = 0;
                  ?>
                    <?php if (isset($_SESSION["errors"])) : ?>
                      <h2>Alerta</h2>
                      <p></p>
                      <table class="table table-bordered table-hover">
                        <tr class="danger">
                          <th>Codigo</th>
                          <th>Producto</th>
                          <th>Mensaje</th>
                        </tr>
                        <?php foreach ($_SESSION["errors"]  as $error) :
                          $product = ProductoData::getById($error["producto_id"]);
                        ?>
                          <tr class="danger">
                            <td><?php echo $product->id_producto; ?></td>
                            <td><?php echo $product->nombre; ?></td>
                            <td><b><?php echo $error["message"]; ?></b></td>
                          </tr>

                        <?php endforeach; ?>
                      </table>
                    <?php endif ?>

                    <form method="post" class="form-horizontal" id="processsell" action="index.php?action=procesartransaccion">
                      <div style="border-color: #FF0000;">
                        <div class="form-group">


                          <label for="inputEmail1" class="col-lg-2 control-label">Tipo Transacción:</label>
                          <div class="col-lg-2">
                            <?php
                            $acciones = AccionData::VerAccion();
                            if (count($acciones) > 0) {
                            ?>
                              <select class="form-control" name="accion_id">
                                <?php foreach ($acciones as $accion) : ?>
                                  <option value="<?php echo $accion->id_accion ?>"><?php echo $accion->nombre; ?></option>
                                <?php endforeach ?>
                              </select>
                            <?php } ?>
                          </div>





                          <label for="inputEmail1" class="col-lg-2 control-label">De Depósito:</label>
                          <div class="col-lg-2">
                            <?php
                            $deposito = ProductoData::verdeposito($sucursales->id_sucursal);
                            if (count($deposito) > 0) : ?>
                              <select name="id_deposito" id="id_deposito" required class="form-control">

                                <?php foreach ($deposito as $depositos) : ?>
                                  <option value="<?php echo $depositos->DEPOSITO_ID; ?>" style="color: orange;"><i class="fa fa-gg"></i><?php echo $depositos->NOMBRE_DEPOSITO; ?></option>
                                <?php endforeach; ?>
                              </select>
                            <?php endif; ?>
                          </div>


                          <label for="inputEmail1" class="col-lg-2 control-label">al Depósito:</label>
                          <div class="col-lg-2">
                            <?php
                            $deposito = ProductoData::verdeposito($sucursales->id_sucursal);
                            if (count($deposito) > 0) : ?>
                              <select name="id_deposito2" id="id_deposito2" required class="form-control">

                                <?php foreach ($deposito as $depositos) : ?>
                                  <option value="<?php echo $depositos->DEPOSITO_ID; ?>" style="color: orange;"><i class="fa fa-gg"></i><?php echo $depositos->NOMBRE_DEPOSITO; ?></option>
                                <?php endforeach; ?>
                              </select>
                            <?php endif; ?>
                          </div>


                          <label for="inputEmail1" class="col-lg-2 control-label">Motivo:</label>
                          <div class="col-lg-2">
                            <select name="motivo" id="motivo" required class="form-control">
                              <option value="">Selecionar </option>
                              <option value="Produccion">Produccion </option>
                              <option value="Control">Control de stock</option>
                              <option value="Remision">Ingreso por remision</option>


                            </select>
                          </div>

                          <label for="inputEmail1" class="col-lg-2 control-label">Fecha:</label>
                          <div class="col-lg-2">
                            <input type="date" name="sd" id="sd" class="form-control">
                          </div>

                        </div>

                      </div>

                      <table class="table table-bordered table-hover">
                        <thead>
                          <th style="width:30px;">Codigo</th>

                          <th style="width:30px;">Producto</th>
                          <th style="width:30px;">Stock</th>
                          <th style="width:30px;">Depósito</th>

                          <th style="width:30px;">Cant.</th>

                          <th style="width:30px;">Observación.</th>
                          <th></th>
                        </thead>
                        <?php

                        $q1 = 0;

                        $id_dep = 0;

                        $precio_com = 0;

                        $de = "";


                        foreach ($_SESSION["cart"] as $p) :
                          $product = ProductoData::getById($p["producto_id"]);

                          // $q1=OperationData::getQYesFf($p["producto_id"]);


                          $cant  = StockData::vercontenidos($product->id_producto);
                          foreach ($cant as $can) {
                            $q1 = $can->CANTIDAD_STOCK;
                            $id_dep = $can->DEPOSITO_ID;
                            $precio_com = $can->COSTO_COMPRA;
                          }

                          $deposit  = StockData::verdeposito($id_dep);
                          foreach ($deposit as $dep) {
                            $de = $dep->NOMBRE_DEPOSITO;
                          }


                        ?>
                          <tr>
                            <td><?php echo $product->codigo; ?></td>

                            <td><?php echo $product->nombre; ?></td>

                            <td><?php echo $q1; ?></td>

                            <td><?php echo $de; ?></td>

                            <td>
                              <input style="width:80px;" type="number" value="<?php echo $p["q"]; ?>" />
                            </td>
                            <td><textarea name="observacion" id="observacion" value=""> </textarea></td>

                            <!-- <td><?php echo $product->unidad; ?></td> -->

                            <td style="width:30px;"><a href="index.php?action=eliminarcompraproductos2&id_sucursal=<?php echo $sucursales->id_sucursal; ?>&producto_id=<?php echo $product->id_producto; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
                          </tr>

                        <?php endforeach; ?>
                      </table>
                      <div class="modal-footer">

                        <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                        <input type="hidden" name="precio_comp" id="precio_comp" value="<?php echo $precio_com; ?>">


                        <input type="hidden" value="<?php echo $q1; ?>" id="stock_trans" name="stock_trans" />
                        <button type="submit" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i> Registrar Transacción</button>

                      </div>
                    </form>
                  <?php endif ?>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    <?php endif ?>
  <?php endif ?>

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