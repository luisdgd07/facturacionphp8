<?php
$team =  CompraData::getById($_GET["id_compra"]);
$carpetas = DetalleCompra::getAllByTeamId($_GET["id_compra"]);
$totall = 0;
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa  fa-cart-arrow-down' style="color: orange;"></i>
        REGISTRAR COMPRAS <b>Orden de la Compra # <?php echo $team->id_compra; ?></b>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
               <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-shopping-cart"></i> Ir de Compras</a>
               <a href="index.php?view=compras" data-toggle="modal" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-arrow-left"></i> Atras</a>
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
                  <th class="alert alert-warning" style="color: red;">Gasto</th>
                  <!-- <th>Fecha</th> -->
                  <!-- <th>Cantidad Stock</th> -->
                <!--   <th>Precio V.</th>
                  <th>Categoria</th>
                  <th>Stock Min.</th>
                  <th>Activo</th> -->
                  <th><center>Acción</center></th>
                </thead>
                <tbody>
                   <?php
                    foreach($carpetas as $ver){
                    $car = $ver->getCompras();
                    ?>
                  <tr>
                  <td><?php echo $car->nombre; ?></td>
                  <td><?php echo $car->descripcion; ?></td>
                  <td>Bs <?php echo number_format($car->precio_compra,0,'.','.'); ?></td>
                  <td><?php echo $car->cantidad; ?></td>
                  <td class="alert alert-warning" style="color: red;">Bs <?php echo ($car->cantidad*$car->precio_compra);$totall+=$car->cantidad*$car->precio_compra;?></td>
                  <td><?php echo $car->fecha;?></td>
                  <!-- <td style="width:170px;">
                    <a href="index.php?view=actualizarcliente&id_cliente=<?php echo $user->id_cliente;?>" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="fa fa-cog"></i> Configurar</a>
                    <a href="index.php?action=eliminarcliente&id_cliente=<?php echo $user->id_cliente;?>" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> Eliminar</a>
                  </td> -->
                  </tr>
                </tbody>
                 <?php
                }
                }else{
                  echo "<p class='alert alert-danger'>Aun no se a realizado la Compra</p>";
                }
                ?>
              </table>
              <h3>
               Gasto Total de Esta Compra <b> # <?php echo $team->id_compra; ?></b>: <b> Bs <?php echo number_format($totall,0,'.','.'); ?></b> 
              </h3>
              </div>
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
              <h4 class="modal-title"><i class="fa fa-cart-plus" style="color: orange;"></i><b> REGISTRAR COMPRA</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="post" enctype="multipart/form-data"  action="index.php?action=nuevacompras" role="form">
                <div class="form-group has-feedback has-error">
                          <label for="inputEmail1" class="col-lg-2 control-label">Imagen</label>
                          <div class="col-lg-10">
                            <input type="file" name="imagen" class="form-control" id="imagen">
                            <span class="fa fa-image form-control-feedback"></span>
                          </div>
                        </div>
                        <div class="form-group has-feedback has-error">
                          <label for="inputEmail1" class="col-lg-2 control-label">Codigo Fabricante</label>
                          <div class="col-lg-10">
                            <input type="text"  name="codigofabricante" class="form-control" id="codigofabricante" placeholder="Codigo del Fabriante"  maxlength="200">
                            <span class="fa fa-barcode form-control-feedback"></span>
                          </div>
                        </div>
                        <div class="form-group has-feedback has-error">
                          <label for="inputEmail1" class="col-lg-2 control-label">Codigo Importador</label>
                          <div class="col-lg-10">
                            <input type="text" name="codigoimportador" class="form-control" id="codigoimportador" placeholder="Codigo del Importador">
                            <span class="fa fa-barcode form-control-feedback"></span>
                          </div>
                        </div>
                        <div class="form-group has-feedback has-warning">
                          <label for="inputEmail1" class="col-lg-2 control-label">Codigo</label>
                          <div class="col-lg-4">
                            <input type="text" name="codigo" class="form-control" id="codigo" placeholder="Codigo del Producto">
                            <span class="fa fa-barcode form-control-feedback"></span>
                          </div>
                          <label  class="col-lg-2 control-label">nombre</label>
                          <div class="col-lg-4">
                            <input type="text" name="nombre" class="form-control" id="nombre"  placeholder="Nombre del Producto" maxlength="800" required="" >
                            <span class="fa fa-laptop form-control-feedback"></span>
                          </div>
                        </div>
                        <div class="form-group has-feedback has-warning">
                          <label for="inputEmail1" class="col-lg-2 control-label">Serie</label>
                          <div class="col-lg-4">
                            <input type="text" name="serie" class="form-control" id="serie" placeholder="Serie del Producto" >
                            <span class="fa fa-cc-amex form-control-feedback"></span>
                          </div>
                          <label  class="col-lg-2 control-label">Modelo</label>
                          <div class="col-lg-4">
                            <input type="text" name="modelo" class="form-control" id="modelo" placeholder="Modelo del Producto" maxlength="800">
                            <span class="fa fa-gg form-control-feedback"></span>
                          </div>
                        </div>
                        <div class="form-group has-feedback has-warning">
                          <label for="inputEmail1" class="col-lg-2 control-label">Marca</label>
                          <div class="col-lg-4">
                            <input type="text" name="marca" class="form-control" id="marca" placeholder="Marca del Producto" >
                            <span class="fa fa-apple form-control-feedback"></span>
                          </div>
                          <label  class="col-lg-2 control-label">Estado</label>
                          <div class="col-lg-4">
                            <select name="estado" id="estado" class="form-control">
                              <option value="">Seleccionar</option>
                              <option value="NUEVO">Nuevo</option>
                              <option value="SEMI NUEVO">Semi Nuevo</option>
                              <option value="OTROS">Otros</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group has-feedback has-warning">
                          <label for="inputEmail1" class="col-lg-2 control-label">Presentacion</label>
                          <div class="col-lg-4">
                           <textarea name="presentacion" id="presentacion" class="form-control" placeholder="Presentacion del Producto"></textarea>
                            <span class="fa fa-cube form-control-feedback"></span>
                          </div>
                          <label  class="col-lg-2 control-label">Descripcion</label>
                          <div class="col-lg-4">
                           <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion del Producto"></textarea>
                            <span class="fa fa-file-text form-control-feedback"></span>
                          </div>
                        </div>
                        <div class="form-group has-feedback has-warning">
                          <label for="inputEmail1" class="col-lg-2 control-label">Cantidad</label>
                          <div class="col-lg-4">
                            <input type="text" name="cantidad" class="form-control" id="cantidad" placeholder="Cantidad del Producto" onkeypress="return solonumeross(event)" required="">
                            <span class="fa fa-sort-amount-desc form-control-feedback"></span>
                          </div>
                          <label  class="col-lg-2 control-label">Precio Compra</label>
                          <div class="col-lg-4">
                            <input type="text" name="precio_compra" class="form-control" id="precio_compra" onkeypress="return solonumeross(event);" placeholder="Precio de Compra" maxlength="800">
                            <span class="fa fa-dollar form-control-feedback"></span>
                          </div>
                        </div>
                        <div class="form-group has-feedback has-warning">
                          <label for="inputEmail1" class="col-sm-2 control-label">No Robot</label>
                        <div class="col-sm-2">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" required="required" name="finalizado" id="finalizado">
                            </label>
                          </div>
                      </div>
                        </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
              <input type="hidden" name="compra_id" value="<?php echo $_GET["id_compra"];?>">
              <button type="submit" class="btn btn-warning btn-flat" ><i class="fa fa-save"></i> Guardar</button>
              </form>
            </div>
        </div>
    </div>
</div>