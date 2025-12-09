  <?php 
    $u=null;
    if (isset($_SESSION["admin_id"])&& $_SESSION["admin_id"]!=""):
      $u=UserData::getById($_SESSION["admin_id"]);
    ?>
  <!-- Content Wrapper. Contains page content -->
  <?php if($u->is_admin):?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa fa-briefcase' style="color: orange;"></i>
        HISTORIAL DE CAJA PRODUCTOS
       <!-- <marquee> Lista de Medicamentos</marquee> -->
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <?php
              $boxes = CajaData::getAll();
              $products = VentaData::cierre_caja();
              if(count($boxes)>0){
              $total_total = 0;
              ?>
              <br>
              <table class="table table-bordered table-hover  ">
                <thead>
                  <th></th>
                  <th>Total</th>
                  <th>Fecha</th>
                </thead>
                <?php foreach($boxes as $box):
              $sells = VentaData::historial_caja($box->id_caja);

                ?>

                <tr>
                  <td style="width:30px;">
              <a href="./index.php?view=verhistorialcajaventa&id_caja=<?php echo $box->id_caja; ?>" class="btn btn-default btn-xs"><i class="fa fa-arrow-right"></i></a>      
                  </td>
                  <td>

              <?php
              $total=0;
              foreach($sells as $sell){
              $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                foreach($operations as $operation){
                  $product  = $operation->getProducto();
                  $plato  = $operation->getVenta();
                  $total += (($operation->q*$product->precio_venta)-$plato->descuento);
                  // $total += $operation->q*$product->precio_venta;
                }
              }
                  $total_total += $total;
                  echo "<b>Bs ".number_format($total,0,".",".")."</b>";

              ?>      

                  </td>
                  <td><?php echo $box->fecha; ?></td>
                </tr>

              <?php endforeach; ?>

              </table>
              <h1>Total: <?php echo "Bs ".number_format($total_total,0,".","."); ?></h1>
                <?php
              }else {

              ?>
                <div class="jumbotron">
                  <h2>No hay ventas</h2>
                  <p>No se ha realizado ninguna venta.</p>
                </div>

              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
  <?php endif ?>
  <?php if($u->is_empleado):?>
    <?php
      $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
    ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa fa-briefcase' style="color: orange;"></i>
        HISTORIAL DE CAJA PRODUCTOS
       <!-- <marquee> Lista de Medicamentos</marquee> -->
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <?php
              $boxes = CajaData::vercajasucursal($sucursales->id_sucursal);
              $products = VentaData::cierre_caja();
              if(count($boxes)>0){
              $total_total = 0;
              ?>
              <br>
              <table class="table table-bordered table-hover  ">
                <thead>
                  <th></th>
                  <th>Total</th>
                  <th>Fecha</th>
                </thead>
                <?php foreach($boxes as $box):
              $sells = VentaData::historial_caja($box->id_caja);

                ?>

                <tr>
                  <td style="width:30px;">
              <a href="./index.php?view=verhistorialcajaventa&id_caja=<?php echo $box->id_caja; ?>" class="btn btn-default btn-xs"><i class="fa fa-arrow-right"></i></a>      
                  </td>
                  <td>

              <?php
              $total=0;
              foreach($sells as $sell){
              $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                foreach($operations as $operation){
                  $product  = $operation->getProducto();
                  $plato  = $operation->getVenta();
                  $total += (($operation->q*$product->precio_venta)-$plato->descuento);
                  // $total += $operation->q*$product->precio_venta;
                }
              }
                  $total_total += $total;
                  echo "<b>Bs ".number_format($total,0,".",".")."</b>";

              ?>      

                  </td>
                  <td><?php echo $box->fecha; ?></td>
                </tr>

              <?php endforeach; ?>

              </table>
              <h1>Total: <?php echo "Bs ".number_format($total_total,0,".","."); ?></h1>
                <?php
              }else {

              ?>
                <div class="jumbotron">
                  <h2>No hay ventas</h2>
                  <p>No se ha realizado ninguna venta.</p>
                </div>

              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
  <?php endif ?>
<?php endif ?>