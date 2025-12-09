    <?php 
    $u=null;
    if (isset($_SESSION["admin_id"])&& $_SESSION["admin_id"]!=""):
      $u=UserData::getById($_SESSION["admin_id"]);
    ?>
  <?php if($u->is_empleado):?>
    <?php
    $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
  ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
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
                $products = OperationData::verTransacciones();

                if(count($products)>0){

                  ?>
                <br>
                <table id="example2" class="table table-bordered table-hover  ">
                  <thead>
				  <th>Codigo</th>
                    <th>Producto</th>
					<th>stock</th>
                    <th>Cantidad</th>
                    <th>Motivo</th>
                    <th>Tipo Transaccion</th>
                    <th>Fecha</th>
                    <!-- <th></th> -->
                  </thead>
                  <?php foreach($products as $sell):
				  
				  $q1=OperationData::getQYesFf($sell->getProducto()->id_producto);
				  
				  ?>
 
                  <tr>
				  <td><?php echo $sell->getProducto()->codigo; ?></td>
                    <td><?php echo $sell->getProducto()->nombre; ?></td>
					 <td><?php echo $sell->stock_trans; ?></td>
					 
					
                    <td><?php echo $sell->q; ?></td>
                    <td><?php echo $sell->motivo; ?></td>
                    <td><?php echo $sell->getAccion()->nombre; ?></td>
                    <td><?php echo $sell->fecha; ?></td>
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