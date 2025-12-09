 <?php
  $u = null;
  if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
    $u = UserData::getById($_SESSION["admin_id"]);
  ?>
   <!-- Content Wrapper. Contains page content -->
   <?php if ($u->is_admin) : ?>

     <?php
      $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
      ?>
     <div class="content-wrapper">
       <!-- Content Header (Page header) -->
       <section class="content-header">
         <h1><i class='fa  fa-laptop' style="color: orange;"></i>
           STOCK DE PRODUCTOS
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
                    $users = ProductoData::getAll();
                    if (count($users) > 0) {
                      // si hay usuarios
                    ?>
                     <table id="example1" class="table table-bordered table-dark" style="width:100%">
                       <thead>
                         <th>Nombre</th>

                         <th>Presentacion</th>
                         <th>Precio Compra</th>
                         <th>Precio Venta</th>
                         <th>Cantidad Stock</th>
                         <!-- <th><center>Acción</center></th> -->
                       </thead>
                       <tbody>
                         <?php
                          foreach ($users as $user) {
                            $q = OperationData::getQYesFf($user->id_producto);
                            $url = "storage/producto/" . $user->imagen;
                          ?>
                           <tr>
                             <td><?php echo $user->nombre; ?></td>
                             <td>
                               <center><a class="fancybox" href="<?php echo $url; ?>" target="_blank" data-fancybox-group="gallery" title="Imagen"><img class="fancyResponsive img-circle" src="<?php echo $url; ?>" alt="" width="30" height="30" /></a></center>
                             </td>
                             <td><?php echo UnidadesData::getById($op->presentacion)->nombre; ?></td>
                             <td><?php echo number_format($user->precio_compra, 2, ',', '.'); ?></td>
                             <td> <?php echo number_format($user->precio_venta, 2, ',', '.'); ?></td>
                             <td><?php echo $q; ?></td>
                             <!--  <td style="width:70px;">
                    <a href="index.php?view=history&product_id=<?php echo $product->id; ?>" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="fa fa-clock-o"></i> VER HISTORIA</a>
                  </td> -->
                           </tr>
                       <?php
                          }
                        } else {
                          echo "<p class='alert alert-danger'>No hay Ningun Producto Registrado</p>";
                        }
                        ?>
                       </tbody>
                     </table>
                 </div>
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
       <!-- Content Header (Page header) -->
       <section class="content-header">
         <h1><i class='fa  fa-laptop' style="color: orange;"></i>
           MOVIMIENTO DE PRODUCTOS
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
                    $products = OperationData::verTransacciones($_GET["id_sucursal"]);
                    if (count($products) > 0) {
                      // si hay usuarios
                    ?>
                     <table id="example1" class="table table-bordered table-dark" style="width:100%">
                       <thead>
                         <th>Codigo</th>
                         <th>Producto</th>
                         <th>Precio Compra</th>
                         <th>Precio Venta</th>
                         <th>Stock Anterior</th>
                         <th>Cantidad</th>
                         <th>Stock Actual</th>
                         <th>Motivo</th>
                         <th>Tipo Transaccion</th>
                         <th>Fecha</th>
                         <!-- <th><center>Acción</center></th> -->
                       </thead>
                       <tbody>
                         <?php
                          foreach ($products as $sell) {
                            $q1 = OperationData::getQYesFf($sell->getProducto()->id_producto);

                          ?>

                           <tr>
                             <td><?php echo $sell->getProducto()->codigo; ?></td>
                             <td><?php echo $sell->getProducto()->nombre; ?></td>
                             <td><?php echo $sell->getProducto()->precio_compra; ?></td>
                             <td><?php echo $sell->getProducto()->precio_venta; ?></td>
                             <td><?php echo $sell->stock_trans; ?></td>


                             <td><?php echo $sell->q; ?></td>
                             <?php
                              if ($sell->getAccion()->nombre == 'entrada') {
                              ?>
                               <td><?php echo $sell->stock_trans + $sell->q; ?></td>
                             <?php
                              } else {

                              ?>
                               <td><?php echo $sell->stock_trans - $sell->q; ?></td>
                             <?php
                              }
                              ?>
                             <td><?php echo $sell->motivo; ?></td>
                             <td><?php echo $sell->getAccion()->nombre; ?></td>
                             <td><?php echo $sell->fecha; ?></td>
                           </tr>
                       <?php
                          }
                        } else {
                          echo "<p class='alert alert-danger'>No hay Ningun Producto Registrados</p>";
                        }
                        ?>
                       </tbody>
                     </table>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </section>
     </div>
   <?php endif ?>
 <?php endif ?>