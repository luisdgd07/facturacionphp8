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
              VENTAS A CREDITOS
            </h1>
          </section>
          <!-- Main content -->
          <section class="content">
            <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <div class="box-body">
                    <?php
                    $products = VentaData::getVentas();
                    if (count($products) > 0) {

                    ?>
                      <br>
                      <table id="example2" class="table table-bordered table-hover  ">
                        <thead>
                          <th></th>
                          <th>Productos</th>
                          <th>Total</th>
                          <th>Fecha</th>
                          <!-- <th></th> -->
                        </thead>
                        <?php foreach ($products as $sell) : ?>

                          <tr>
                            <td style="width:30px;">
                              <a href="index.php?view=detalleventaproducto&id_venta=<?php echo $sell->id_venta; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open" style="color: orange;"></i></a>
                            </td>

                            <td>

                              <?php
                              $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                              echo count($operations);
                              ?>
                            <td>

                              <?php
                              $total = $sell->total - $sell->descuento;
                              echo "<b> " . number_format($total, 0, '.', '.') . "</b>";

                              ?>

                            </td>
                            <td><?php echo $sell->fecha; ?></td>
                            <!-- <td style="width:30px;"><a href="index.php?view=delsell&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></td> -->
                          </tr>

                        <?php endforeach; ?>

                      </table>

                      <div class="clearfix"></div>

                    <?php
                    } else {
                    ?>
                      <div class="jumbotron">
                        <h2>No hay ventas</h2>
                        <p>No se ha realizado ninguna venta.</p>
                      </div>
                    <?php
                    }

                    ?>
                  </div>
                </div>
              </div>
            </div>
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
              VENTAS A CREDITO
            </h1>
          </section>
          <!-- Main content -->
          <section class="content">
            <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <div class="box-body">
                    <?php
                    $products = CreditoData::cobranza($sucursales->id_sucursal);
                    if (count($products) > 0) {

                    ?>
                      <br>
                      <table id="example1" class="table table-bordered table-hover  ">
                        <thead>
                          <th>Cliente</th>
                          <th>Credito</th>
                          <th>Abonado</th>

                          <th>Vencimiento</th>
                          <td>Concepto</td>
                          <td>Cuotas</td>
                          <td>fecha venta</td>
                          <td>Accion</td>
                        </thead>
                        <tbody>
                          <?php foreach ($products as $sell) :
                            $venta = new VentaData();
                            $cliente = $venta->getById($sell->venta_id)->getCliente();
                          ?>
                            <tr>
                              <td><?php echo $cliente->nombre . ' ' . $cliente->apellido ?></td>
                              <td><?php echo $sell->credito ?></td>
                              <td><?php echo $sell->abonado ?></td>
                              <td><?php echo $sell->vencimiento ?></td>
                              <td><?php echo $sell->concepto ?></td>
                              <td><?php echo $sell->cuotas ?></td>
                              <td><?php echo $sell->fecha ?></td>
                              <td>
                                <a href="index.php?view=cobranzadetalle&id=<?php echo $sell->id ?>&id_venta=<?php echo $sell->venta_id ?>&cuotas=<?php echo $sell->cuotas ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open" style="color: orange;"></i></a>
                                <a href="impresioncobro.php?concepto=&cobro=276" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open" style="color: orange;"></i></a>
                              </td>

                            </tr>

                          <?php endforeach; ?>
                        </tbody>


                      </table>

                      <div class="clearfix"></div>

                    <?php
                    } else {
                    ?>
                      <div class="jumbotron">
                        <h2>No hay ventas</h2>
                        <p>No se ha realizado ninguna venta.</p>
                      </div>
                    <?php
                    }

                    ?>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      <?php endif ?>
    <?php endif ?>