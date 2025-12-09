    <?php
    $u = null;
    if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
      $u = UserData::getById($_SESSION["admin_id"]);
    ?>
      <!-- Content Wrapper. Contains page content -->
      <?php if ($u->is_admin) : ?>



      <?php endif ?>
      <?php if ($u->is_empleado) : ?>
        <?php
        $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
        ?>
        <div class="content-wrapper">
          <section class="content-header">
            <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
              REGISTRO DE VENTAS MASIVAS
            </h1>
          </section>
          <!-- Main content -->
          <section class="content">
            <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <div class="box-body">
                    <?php
                    $total10imp = 0;
                    $total5imp = 0;
                    $tota0imp = 0;
                    $totaliva10 = 0;
                    $totaliva5 = 0;
                    $totaliva0 = 0;
                    $products = OperationData::verproductmasivas($sucursales->id_sucursal);

                    if (count($products) > 0) {

                    ?>
                      <br>
                      <table id="example1" class="table table-bordered table-hover  ">
                        <thead>
                          <th># De Venta</th>
                          <th>Fecha</th>
                          <th>codigo</th>
                          <th>Cantidad</th>
                          <th>% imp</th>
                          <th>IVA</th>
                          <th>Gravada</th>
                          <th>Total</th>
                          <th>Cambio</th>
                          <th>Acciones</th>
                        </thead>
                        <?php foreach ($products as $sell) :
                        ?>
                          <tr <?php if ($sell->masiva == 0) : ?> class="alert alert-warning" <?php endif ?>>
                            <?php if (($sell->getVenta()->getCliente()->tipo_doc == "SIN NOMBRE" or $sell->getVenta()->getCliente()->tipo_doc == "CEDULA DE EXTRANJERO")  & (($sell->getVenta()->total)) > $sell->getventa()->cantidaconfigmasiva) {
                            } ?>
                            <td> <?php echo $sell->venta_id; ?></td>



                            <td><?php echo $sell->getVenta()->fecha ?></td>
                            <td><?php echo $sell->getProducto()->codigo ?></td>
                            <td><?php echo $sell->q ?></td>
                            <td><?php if ($sell->getProducto()->impuesto == "10") : ?>
                                <b style="color: blue;"><?php echo $sell->getProducto()->impuesto ?>% <?php (($sell->getVenta()->total) / 11);
                                                                                                      $total10imp = (($sell->getVenta()->total) / 11); ?></b>
                              <?php else : ?>
                                <?php if ($sell->getProducto()->impuesto == "5") : ?>
                                  <b style="color: green;"><?php echo $sell->getProducto()->impuesto ?>% <?php (($sell->getVenta()->total) / 21);
                                                                                                          $total5imp = (($sell->getVenta()->total) / 21); ?></b>
                                <?php else : ?>
                                  <?php if (


                                      $sell->getProducto()->impuesto == "0"
                                    ) : ?>
                                    <b style="color: red;"><?php echo $sell->getProducto()->impuesto ?>% <?php ($sell->getVenta()->total);
                                                                                                          $tota0imp = ($sell->getVenta()->total); ?></b>
                                  <?php endif ?>
                                <?php endif ?>
                              <?php endif ?>
                            </td>
                            <td><?php if ($sell->getProducto()->impuesto == "10") : ?>
                                <b style="color: blue;"><?php echo number_format($total10imp, 4, ',', '.') ?></b>
                              <?php else : ?>
                                <?php if ($sell->getProducto()->impuesto == "5") : ?>
                                  <b style="color: green;"><?php echo number_format($total5imp, 4, ',', '.') ?></b>
                                  <?php else : ?><?php if ($sell->getProducto()->impuesto == "0") : ?>
                                  <b style="color: blue;"><?php echo number_format($tota0imp, 4, ',', '.') ?></b>
                                <?php endif ?>
                              <?php endif ?>
                            <?php endif ?>
                            </td>
                            <td><?php if ($sell->getProducto()->impuesto == "10") : ?>
                                <b style="color: blue;"><?php echo number_format(((($sell->getVenta()->total / $sell->q) * $sell->q) / 1.1), 4, ',', '.');
                                                        $totaliva10 = ((($sell->getVenta()->total / $sell->q) * $sell->q) / 1.1) ?></b>
                              <?php else : ?>
                                <?php if ($sell->getProducto()->impuesto == "5") : ?>
                                  <b style="color: green;"><?php echo number_format(((($sell->getVenta()->total / $sell->q) * $sell->q) / 1.05), 4, ',', '.');
                                                            $totaliva5 = ((($sell->getVenta()->total / $sell->q) * $sell->q) / 1.05) ?></b>
                                <?php else : ?>
                                  <?php if ($sell->getProducto()->impuesto == "0") : ?>
                                    <b style="color: red;"><?php echo number_format((($sell->getVenta()->total / $sell->q) * $sell->q), 4, ',', '.');
                                                            $totaliva0 = (($sell->getVenta()->total / $sell->q) * $sell->q) ?></b>
                                  <?php endif ?>
                                <?php endif ?>
                              <?php endif ?>
                            </td>
                            <td><?php echo number_format($sell->getVenta()->total, 4, ',', '.') ?> <?php echo $sell->getVenta()->VerTipoModena()->simbolo ?></td>
                            <td> <?php echo $sell->getVenta()->cambio2;
                                  ?></td>
                            <td width="140">

                              <?php if ($sell->masiva == 0) { ?>
                                <a href="index.php?view=masiva1&id_sucursal=<?php echo $_GET["id_sucursal"]; ?>&id_proceso=<?php echo $sell->id_proceso; ?>" class="btn btn-success">Registrar masiva </a>

                              <?php } else { ?>
                                <a href="imprisionticketmasiva.php?id_venta=<?php echo $sell->getVenta()->id_venta; ?>" class="btn btn-warning" target="_BLANCK">Imprimir</a>
                              <?php
                              } ?>
                            </td>
                          </tr>
                        <?php
                        endforeach; ?>

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