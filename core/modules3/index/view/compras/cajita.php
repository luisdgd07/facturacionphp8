
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa  fa-cart-arrow-down' style="color: orange;"></i>
        LISTA DE COMPRAS DE LOS PRODUCTOS
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
               <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-yelp"></i> Generar Nueva Compra</a>
            </div>
            <div class="box-body">
              <div class="table-responsive">
              <?php
                $users = CompraData::getAll();
                if(count($users)>0){
                  $totall=0;
                  // si hay usuarios
                  ?>
              <table id="example1" class="table table-bordered table-dark" style="width:100%">
                <thead>
                  <th>Nª Orden</th>
                  <th>Compra</th>
                  <th>Descripcion</th>
                  <th>Total</th>
                  <th>Estado</th>
                </thead>
                <tbody>
                   <?php
                    foreach($users as $user){
                    ?>
                  <tr>
                  <td><?php echo $user->id_compra; ?></td>
                  <td><?php echo $user->nombre; ?></td>
                  <td><?php echo $user->descripcion; ?></td>
                  <td> <?php echo $user->total;$totall+=$user->total;?></td>
                  <td style="width:100px;"><center><?php if($user->finalizado):?><a href="index.php?view=detallecompra&id_compra=<?php echo $user->id_compra;?>" data-toggle="modal" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-building-o"></i> Detalle Compra</a><?php else: ?><a href="index.php?view=micompra&id_compra=<?php echo $user->id_compra;?>" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="fa fa-shopping-cart"></i> Ir de Compra</a><?php endif; ?></center> </td>
                  </tr>
                <?php
                }
                }else{
                  echo "<p class='alert alert-danger'>Aun todavia no se ha realizado la Compra</p>";
                }
                ?>
                </tbody>
              </table>
              </div>
              <form class="form-horizontal" method="post" enctype="multipart/form-data"  action="#" role="form">
                <div class="form-group">
                    <label for="inputEmail1" class="col-sm-3 control-label">Gasto Total en la Compra Bs</label>
                    <div class="col-sm-5">
                      <!-- <input type="text" class="form-control" id="total" name="total" required maxlength="30" value="<?php echo number_format($totall,2,'.',','); ?>"> -->
                      <input type="text" class="form-control" id="total" name="total" required maxlength="30" value="<?php echo $totall; ?>">
                    </div>
                    <div class="col-sm-4">
                      <!-- <input type="hidden" name="id_compra" value="<?php echo $_GET["id_compra"];?>"> -->
                      <button type="submit" class="btn btn-block btn-flat" ><i class="fa fa-money"></i> Cuadrar Caja</button>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><i class="fa fa-cart-plus" style="color: orange;"></i><b> Datos de la  Compra</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="post" enctype="multipart/form-data"  action="index.php?action=nuevacompra" role="form">
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Nombre</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nombre" name="nombre" required onKeyUP="this.value=this.value.toLowerCase();" maxlength="200">
                      <span class="fa fa-cart-plus form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Descripcion</label>
                    <div class="col-sm-9">
                      <textarea name="descripcion" id="descripcion"class="form-control" rows="3"></textarea>
                      <span class="fa fa-file-text-o form-control-feedback"></span>
                    </div>
                </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
              <button type="submit" class="btn btn-warning btn-flat" ><i class="fa fa-save"></i> Guardar</button>
              </form>
            </div>
        </div>
    </div>
</div>