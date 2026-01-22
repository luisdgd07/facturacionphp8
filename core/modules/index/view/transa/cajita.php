<?php

?>




<?php


$u = null;
if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != ""):
  $u = UserData::getById($_SESSION["admin_id"]);
  ?>
  <!-- Content Wrapper. Contains page content -->
  <?php if ($u->is_admin): ?>

  <?php endif ?>
  <?php if ($u->is_empleado): ?>
    <?php
    $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
    ?>
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1><i class='fa  fa-laptop' style="color: orange;"></i>
          REGISTRO DE TRANSACCIONES
        </h1>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-body">
                <div class="box box-warning"></div>
                <div class="table-responsive">
                  <?php
                  // $products = VentaData::versucursaltipotrans($sucursales->id_sucursal);
                  $products = VentaData::versucursaltipotrans2($sucursales->id_sucursal, '2022-12-29', '2099-12-29');
                  if (count($products) > 0) {

                    ?>
                    <br>
                    <table id="example1" class="table table-bordered table-hover  ">
                      <thead>
                        <th>Accion</th>
                        <th></th>
                        <th></th>
                        <th>Nro.</th>
                        <th>Producto.</th>
                        <th>Cantidad.</th>
                        <th>Tipo de transacción</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                      </thead>
                      <tbody>
                        <?php foreach ($products as $sell):
                          $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                          count($operations);
                          for ($p = 0; $p < count($operations); $p++) {
                            ?>
                            <tr>
                              <td style="width:30px;">
                                <a href="index.php?view=detalletransac&id_venta=<?php echo $sell->id_venta; ?>"
                                  class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"
                                    style="color: orange;"></i></a>

                              </td>
                              <td style="width:30px;"><?php
                              $opera = OperationData::getAllProductsBySellIddd($sell->id_venta);
                              foreach ($opera as $o) {
                                echo $o->observacion;
                              } ?></td>
                              <td style="width:30px;">
                                <?php if ($sell->accion_id != 3) { ?>
                                  <abbr> <button
                                      onclick="anular2(<?php echo $sucursales->id_sucursal; ?>,<?php echo $sell->id_venta; ?>,<?php echo $sell->accion_id ?>,<?php echo $operations[$p]->id_proceso ?>,<?php echo $operations[$p]->producto_id ?>,<?php echo $operations[$p]->deposito ?>,<?php echo $operations[$p]->q; ?>)"
                                      class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> </button></abbr>
                                <?php } ?>
                              </td>
                              <td style="width:30px;">
                                <?php echo $sell->id_venta; ?>
                              </td>


                              <td style="width:30px;">
                                <?php $prod = ProductoData::getProducto2($operations[$p]->producto_id); ?>


                                <?php foreach ($prod as $detalle): ?>


                                  <?php echo $detalle->nombre; ?>

                                <?php endforeach; ?>
                              </td>






                              <td style="width:30px;">
                                <?php echo $operations[$p]->q;
                                ?>
                              </td>




                              <td style="width:30px;">

                                <?php if ($sell->accion_id == 1) {
                                  echo "Entrada";
                                } else if ($sell->accion_id == 2) {
                                  echo "Salida";
                                } else if ($sell->accion_id == 3) {
                                  echo "Trasferencia";
                                } ?>
                              </td>







                              <td style="width:30px;">
                                <?php if ($sell->usuario_id != ""):
                                  $user = $sell->getUser();
                                  ?>
                                  <?php echo $user->nombre . " " . $user->apellido; ?>
                                <?php endif; ?>

                              </td>





                              <td style="width:30px;"><?php echo $sell->fecha; ?></td>

                            </tr>

                            <?php
                          }
                        endforeach; ?>
                      </tbody>
                    </table>
                    <!-- <table id="example1" class="table table-bordered table-hover  ">
                          <thead>
                            <th>Accion</th>
                            <th></th>
                            <th>Nro.</th>
                            <th>Producto.</th>
                            <th>Cantidad.</th>
                            <th>Tipo de transacción</th>
                            <th>Usuario</th>
                            <th>Fecha</th>
                          </thead>
                          <tbody>
                            <?php foreach ($products as $sell):
                              $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                              count($operations);
                              foreach ($operations as $selldetalle):
                                ?>
                                <tr>
                                  <td style="width:30px;">
                                    <a href="index.php?view=detalletransac&id_venta=<?php echo $sell->id_venta; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open" style="color: orange;"></i></a>

                                  </td>
                                  <td style="width:30px;">
                                    <?php if ($sell->accion_id != 3) { ?>
                                      <button onclick="anular2(<?php echo $sucursales->id_sucursal; ?>,<?php echo $sell->id_venta; ?>,<?php echo $sell->accion_id ?>,<?php echo $selldetalle->id_proceso ?>,<?php echo $selldetalle->producto_id ?>,<?php echo $selldetalle->deposito ?>,<?php echo $selldetalle->q; ?>)" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> </button></abbr>
                                    <?php } ?>
                                  </td>
                                  <td style="width:30px;">
                                    <?php echo $sell->id_venta; ?>
                                  </td>


                                  <td style="width:30px;">


                                    <?php $prod = ProductoData::getProducto2($selldetalle->producto_id); ?>


                                    <?php foreach ($prod as $detalle): ?>


                                      <?php echo $detalle->nombre; ?>

                                    <?php endforeach; ?>
                                  </td>






                                  <td style="width:30px;">
                                    <?php echo $selldetalle->q;
                                    ?>

                                  </td>




                                  <td style="width:30px;">

                                    <?php if ($sell->accion_id == 1) {
                                      echo "Entrada";
                                    } else if ($sell->accion_id == 2) {
                                      echo "Salida";
                                    } else if ($sell->accion_id == 3) {
                                      echo "Trasferencia";
                                    } ?></td>







                                  <td style="width:30px;">
                                    <?php if ($sell->usuario_id != ""):
                                      $user = $sell->getUser();
                                      ?>
                                      <?php echo $user->nombre . " " . $user->apellido; ?>
                                    <?php endif; ?>

                                  </td>





                                  <td style="width:30px;"><?php echo $sell->fecha; ?></td>

                                </tr>
                              <?php endforeach; ?>

                            <?php endforeach; ?>
                          </tbody>
                        </table> -->
                    <?php
                  } else {
                    ?>
                    <div class="jumbotron">
                      <h2>No hay transaccion</h2>
                      <p>No se ha realizado ninguna transacción.</p>
                    </div>
                    <?php
                  }

                  ?>

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <script>
      function anular2(sucursal, venta, accion, proceso, producto, deposito, q) {
        Swal.fire({
          title: 'Desea anular este registro',
          showDenyButton: true,
          confirmButtonText: 'Anular',
          denyButtonText: `Cerrar`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            window.location.href = `./index.php?action=actualizar_estado_transaccion&id_sucursal=${sucursal}&id_venta=${venta}&accion_id=${accion}&producto_id=${producto}&id_deposito=${deposito}&id_pro=${proceso}&q=${q}`;
          } else { }
        })

      }
    </script>
  <?php endif ?>
<?php endif ?>