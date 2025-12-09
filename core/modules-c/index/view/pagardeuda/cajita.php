    <?php 
    $u=null;
    if (isset($_SESSION["admin_id"])&& $_SESSION["admin_id"]!=""):
      $u=UserData::getById($_SESSION["admin_id"]);
    ?>
  <!-- Content Wrapper. Contains page content -->
  <?php if($u->is_admin):?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
        VENTAS REALIZADAS
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

                if(count($products)>0){

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
                  <?php foreach($products as $sell):?>

                  <tr>
                    <td style="width:30px;">
                    <a href="index.php?view=detalleventaproducto&id_venta=<?php echo $sell->id_venta; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open" style="color: orange;"></i></a></td>

                    <td>

                <?php
                $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                echo count($operations);
                ?>
                    <td>

                <?php
                $total= $sell->total-$sell->descuento;
                    echo "<b> ".number_format($total,0,'.','.')."</b>";

                ?>      

                    </td>
                    <td><?php echo $sell->fecha; ?></td>
                    <!-- <td style="width:30px;"><a href="index.php?view=delsell&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></td> -->
                  </tr>

                <?php endforeach; ?>

                </table>

                <div class="clearfix"></div>

                  <?php
                }else{
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
  <?php if($u->is_empleado):?>
    <?php
    $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
  ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
        REGISTRO DE PAGOS 
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <?php
                $products = VentaData::Pagos($sucursales->id_sucursal);

                if(count($products)>0){

                  ?>
                <br>
                <table id="example1" class="table table-bordered table-hover  ">
                  <thead>
                    <th></th>
                    <th width="160px">Cantidad de Productos</th>
                    <th>Total</th>
                    <th>Metodo Pago</th>
                    <th>Fecha de pago</th>
                    <td>Tipo Moneda</td>
                    <td>Saldo</td>
                    <td>fecha venta</td>
                    <th></th>
                  </thead>
                  <?php foreach($products as $sell):?>
                  <tr>    
                   <?php
                      $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                       count($operations);
                      ?> 
                     <?php if ($sell->condicioncompra2=="Credito"): ?>                  
                    <td style="width:30px;">
                        <a href="index.php?view=detalleventaproducto&id_venta=<?php echo $sell->id_venta; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open" style="color: orange;"></i></a>
                    </td>
                    <td class="text-center">
                      <?php if ($sell->tipo_venta=="1"): ?>
                      <?php echo $sell->cantidad; ?>
                      <?php else: ?>
                     <?php echo count($operations) ?>
                    <?php endif ?>  
                  </td>
                  <td>
                        <?php
                      $total= $sell->total-$sell->descuento;
                          echo "<b> ".number_format($total,0,'.','.')."</b>";
                      ?>      
                    </td>
                    <td><?php echo $sell->condicioncompra2 ?></td>
                    <td><b style="color: black;"><?php echo $sell->fecha2; ?></b></td>
                    <td><?php echo $sell->VerTipoModena()->nombre; ?></td>
                    <td><?php echo $sell->total-$sell->cash; ?></td>
                    <td><?php echo $sell->fecha; ?></td>
                    <td>
                      <?php if ($sell->pagado==1): ?>
                        El Cliente ya Pago
                        <?php else: ?>
                        <a href="index.php?view=pagardeudas&id_venta=<?php echo $sell->id_venta ?>" class="btn btn-success">Pagar</a>
                      <?php endif ?>
                    </td>
                     <?php endif ?>
                  </tr>

                <?php endforeach; ?>

                </table>

                <div class="clearfix"></div>

                  <?php
                }else{
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