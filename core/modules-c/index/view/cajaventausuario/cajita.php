<?php
    $usuarios = UserData::getById($_GET["id_usuario"]);
    $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
    $cajas = CajaData::getById($_GET["id_caja"]);
  ?>
  <?php 
    $u=null;
    if (isset($_SESSION["admin_id"])&& $_SESSION["admin_id"]!=""):
      $u=UserData::getById($_SESSION["admin_id"]);
      $total1=0;
      $total2=0;
    ?>
  <?php if($u->is_empleado):?>
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
            <a type="button" href="index.php?view=historialcajaventaporusuario&id_usuario=<?php echo $usuarios->id_usuario?>&id_sucursal=<?php echo $sucursales->id_sucursal?>" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-database"></i></a>
          </div>
          <div class="box-tools pull-hegiht">
            <a>Caja Inicial: <input type="text"  value="<?php echo $cajas->montoinicial?>"></a>
          </div>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
              <?php
              $products = VentaData::verventasporusuario($usuarios->id_usuario);
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
                  <th>Tipo Moneda</th>
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
                          echo "<b> ".number_format($total,0,'.','.')."</b>";$total1+=$total;
                      ?> </td>
                      <!-- <td><?php echo $sell->tipo_venta; ?></td> -->
                  <td><?php echo $sell->getUser()->nombre." ".$sell->getUser()->apellido; ?></td>
                  <td><?php echo $sell->VerTipoModena()->nombre; ?></td>
                  <td><?php echo $sell->fecha; ?></td>
                </tr>

              <?php endforeach; ?>

              </table>
              <h3>Total: <input type="text" name="total" value="<?php echo $total1; ?>"> <a  onclick="return btnCierredeCaja()" type="button" href="index.php?action=precosarcajaventa1porusuario&id_caja=<?php echo $cajas->id_caja; ?>&id_usuario=<?php echo $usuarios->id_usuario?>&id_sucursal=<?php echo $sucursales->id_sucursal?>&total=<?php echo $total1; ?>&accion=1" data-toggle="modal" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i>
              	Cerrar Caja</a></h3>  
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