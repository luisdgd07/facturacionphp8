  <?php 
    $u=null;
    if (isset($_SESSION["admin_id"])&& $_SESSION["admin_id"]!=""):
      $u=UserData::getById($_SESSION["admin_id"]);
    ?>
  <!-- Content Wrapper. Contains page content -->
  <?php if($u->is_admin):?>
<div class="content-wrapper">
    <section class="content-header">
      <h1> <i class="fa fa-support" style="color: orange"></i> 
        CAJA PRODUCTOS
        <!-- <small> </small> -->
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <div class="box-tools pull-left">
            <a href="index.php?view=cajaventa" data-toggle="modal" class="btn btn-success btn-sm"><i class="fa fa-refresh"></i></a>
          </div>
          <div class="box-tools pull-left">
            <a type="button" href="index.php?view=historialcajaventa" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-database"></i></a>
          </div>
          <div class="box-tools pull-left">
            <a type="button" href="index.php?action=precosarcajaventa" data-toggle="modal" class="btn btn-warning btn-sm"><i class="fa fa-refresh">Cerrar Caja</i></a>
          </div>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
              <?php
              $products = VentaData::cierre_caja();
              if(count($products)>0){
              $total_total = 0;
              ?>
              <br>
              <table class="table table-bordered table-hover" id="example2">
                <thead>
                  <!-- <th></th> -->
                  <th># Producto Vendidos</th>
                  <th>Total</th>
                  <th>Fecha y Hora</th>
                </thead>

                <?php 
                // $total=0;
                foreach($products as $sell):?>

                <tr>
                  <td style="width:160px;">
                    <?php
                    $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                    echo count($operations);
                    ?>
                  </td> 
                    <td style="width:80px;">
                    <?php
                    $totall=0;
                      foreach($operations as $operation){
                        $product  = $operation->getProducto();
                        $plato  = $operation->getVenta();
                        $totall += (($operation->q*$product->precio_venta)-$plato->descuento);
                        // $totall += $operation->q*$product->precio_venta;
                      }
                        $total_total += $totall;
                        echo "<b> Bs ".number_format($totall,0,".","0")."</b>";

                    ?>  
                  </td> 
                  <td> 
                    <?php echo $sell->fecha; ?>
                  </td>
                </tr>

              <?php endforeach; ?>

              </table>
              <h1>Total: <?php echo "Bs ".number_format($total_total,0,".","0"); ?></h1>
                <?php
              }else {

              ?>
                <div class="jumbotron">
                  <h2>No hay Registros</h2>
                  <p>No se ha realizado ninguna Venta.</p>
                </div>

              <?php } ?>
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
    <section class="content-header">
      <h1> <i class="fa fa-support" style="color: orange"></i> 
        CAJA PRODUCTOS
        <!-- <small> </small> -->
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <div class="box-tools pull-left">
            <a href="index.php?view=cajaventa" data-toggle="modal" class="btn btn-success btn-sm"><i class="fa fa-refresh"></i></a>
          </div>
          <div class="box-tools pull-left">
            <a type="button" href="index.php?view=historialcajaventa&id_sucursal=<?php echo $sucursales->id_sucursal?>" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-database"></i></a>
          </div>
          <div class="box-tools pull-left">
            <a type="button" href="index.php?action=precosarcajaventa1&id_sucursal=<?php echo $sucursales->id_sucursal?>" data-toggle="modal" class="btn btn-warning btn-sm"><i class="fa fa-refresh">Cerrar Caja</i>
              <input type="hidden" name="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
            </a>
          </div>
          <!-- <div class="box-tools pull-right">
            <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-danger btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button> -->
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
              <?php
              $products = VentaData::versucursaltipoventas($sucursales->id_sucursal);
              if(count($products)>0){
              $total_total = 0;
              ?>
              <br>
              <table class="table table-bordered table-hover" id="example2">
                <thead>
                  <!-- <th></th> -->
                  <th># Producto Vendidos</th>
                  <th>Total</th>
                  <th>Vendido por</th>
                  <th>Fecha y Hora</th>
                </thead>

                <?php 
                // $total=0;
                foreach($products as $sell):?>
                <tr>
                  <?php
                  $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                    count($operations);
                  ?> 
                  <td>
                    <?php if ($sell->tipo_venta=="1"): ?>
                      <?php echo $sell->cantidad; ?>
                      <?php else: ?>
                     <?php echo count($operations) ?>
                    <?php endif ?> 
                  </td>
                  <td><?php
                      $total= $sell->total-$sell->descuento;
                          echo "<b> ".number_format($total,0,'.','.')."</b>";
                      ?> </td>
                  <td><?php echo $sell->fecha; ?></td>
                </tr>

              <?php endforeach; ?>

              </table>
              <h1>Total: <?php echo "Bs ".number_format($total_total,0,".","0"); ?></h1>
                <?php
              }else {

              ?>
                <div class="jumbotron">
                  <h2>No hay Registros</h2>
                  <p>No se ha realizado ninguna Venta.</p>
                </div>

              <?php } ?>
              </div>
        </div>
      </div>
    </section>
  </div>
  <?php endif ?>
<?php endif ?>