<?php
$team =  CompraData::getById($_GET["id_compra"]);
$carpetas = DetalleCompra::getAllByTeamId($_GET["id_compra"]);
$totall = 0;
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa  fa-cart-arrow-down'></i>
        LISTA DE COMPRA NUMERO: #<?php echo $team->id_compra ?>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
               <a href="index.php?view=compras" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-left"></i> Atras</a>
            </div>
            <div class="box-body">
              <div class="table-responsive">
              <?php
              if(count($carpetas)>0){
              ?>
              <table id="example1" class="table table-bordered table-dark" style="width:100%">
                <thead>
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th>Precio Unit.</th>
                  <th>Cantidad</th>
                  <th>Gasto</th>
                  <th>Fecha</th>
                <!--   <th>Precio V.</th>
                  <th>Categoria</th>
                  <th>Stock Min.</th>
                  <th>Activo</th> -->
                  <!-- <th><center>Acción</center></th> -->
                </thead>
                <tbody>
                   <?php
                    foreach($carpetas as $ver){
                    $car = $ver->getCompras();
                    ?>
                  <tr>
                  <td><?php echo $car->nombre; ?></td>
                  <td><?php echo $car->descripcion; ?></td>
                  <td>Bs <?php echo number_format($car->precio_compra,2,'.','.'); ?></td>
                  <td><?php echo $car->cantidad; ?></td>
                  <td>Bs <?php echo ($car->cantidad*number_format($car->precio_compra,2,'.','.'));$totall+=$car->cantidad*number_format($car->precio_compra,2,'.','.');?></td>
                  <td><?php echo $car->fecha;?></td>
                  <!-- <td style="width:170px;">
                    <a href="index.php?view=actualizarcliente&id_cliente=<?php echo $user->id_cliente;?>" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="fa fa-cog"></i> Configurar</a>
                    <a href="index.php?action=eliminarcliente&id_cliente=<?php echo $user->id_cliente;?>" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> Eliminar</a>
                  </td> -->
                  </tr>
                <?php
                }
                }else{
                  echo "<p class='alert alert-danger'>No hay Ningun Producto Registrados</p>";
                }
                ?>
                </tbody>
              </table>
              </div>
              <form class="form-horizontal" method="post" enctype="multipart/form-data"  action="index.php?action=cuadrarcompras" role="form">
                <div class="form-group">
                    <label for="inputEmail1" class="col-sm-3 control-label">Gasto Total Bs</label>
                    <div class="col-sm-5">
                      <!-- <input type="text" class="form-control" id="total" name="total" required maxlength="30" value="<?php echo number_format($totall,2,'.','.'); ?>"> -->
                      <input type="text" class="form-control" id="total" name="total" required maxlength="30" value="<?php echo $totall; ?>">
                    </div>
                    <div class="col-sm-4">
                      <input type="hidden" name="id_compra" value="<?php echo $_GET["id_compra"];?>">
                      <button type="submit" class="btn btn-primary btn-flat" ><i class="fa fa-money"></i> Cuadrar</button>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>