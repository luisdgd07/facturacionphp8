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
      <h1><i class='fa fa-steam-square' style="color: orange;"></i>
        Lista de Categorias
       <!-- <marquee> Lista de Medicamentos</marquee> -->
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
               <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-plus"></i> Nuevo</a>
            </div>
            <div class="box-body">
              <div class="table-responsive">
             <?php
                $categorias = CategoriaData::getAll();
                if(count($categorias)>0){
                  // si hay categorias
                  ?>
              <table id="example1" class="table table-bordered table-dark" style="width:100%">
                <thead>
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th><center>Acción</center></th>
                </thead>
                <tbody>
                  <?php
                    foreach($categorias as $categoria){
                    ?>
                  <tr>
                  <td><?php echo $categoria->nombre; ?></td>
                  <td><?php echo $categoria->descripcion; ?></td>
                  <td style="width:150px;">
                    <a href="index.php?view=actualizarcategoria&id_categoria=<?php echo $categoria->id_categoria;?>" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cog"></i> Editar</a>
                    <a href="index.php?action=eliminarcategoria&id_categoria=<?php echo $categoria->id_categoria;?>" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> Eliminar</a>
                  </td>
                  </tr>
                  <?php
                }
                }else{
                  echo "<p class='alert alert-danger'>No hay Categorias Registrados</p>";
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
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><i class="fa fa-steam-square" style="color: orange;"></i><b style="color: black;"> Agregar Nueva Categoria</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" action="index.php?action=nuevocategoria" role="form" method="post" enctype="multipart/form-data">
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Nombre</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nombre" name="nombre" required onkeypress="return sololetras(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="500" placeholder="Nombre de la Categoria">
                      <span class="fa fa-steam form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Descripcion</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion de la Categoria"></textarea>
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
              <button type="submit" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
              </form>
            </div>
        </div>
    </div>
</div>
<?php endif ?>
  <?php if($u->is_empleado):?>
    <?php
    $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
  ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa fa-money' style="color: orange;"></i>
        Tipos de monedas Registradas
       <!-- <marquee> Lista de Medicamentos</marquee> -->
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
               <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-plus"></i> Nuevo</a>
            </div>
            <div class="box-body">
              <div class="table-responsive">
             <?php
                $monedas = MonedaData::versucursalmoneda($sucursales->id_sucursal);
                if(count($monedas)>0){
                  // si hay categorias
                  ?>
              <table id="example1" class="table table-bordered table-dark" style="width:100%">
                <thead>
                  <th>Nombre</th>
                  <th>Compra</th>
				  <th>Venta</th>
                  <th>Simbolo</th>
                  <th>Fecha cotización </th>
                  <th><center>Acción</center></th>
                </thead>
                <tbody>
                  <?php
                    foreach($monedas as $moneda){
                    ?>
                  <tr>
                  <td><?php echo $moneda->nombre; ?></td>
				   <td><?php echo $moneda->valor2; ?></td>
				      <td><?php echo $moneda->valor; ?></td>
                  <td><?php echo $moneda->simbolo; ?></td>
                  <td><?php echo $moneda->fecha_cotizacion; ?></td>
                  <td style="width:80px;">
                    <a href="index.php?view=actualizarmoneda&id_sucursal=<?php echo $sucursales->id_sucursal;?>&id_tipomoneda=<?php echo $moneda->id_tipomoneda;?>" data-toggle="modal" class="btn btn-primary btn-sm btn-flat" title="Actualizar"><i class="fa fa-cog"></i></a>
                    <a href="index.php?action=eliminarmoneda&id_sucursal=<?php echo $sucursales->id_sucursal;?>&id_tipomoneda=<?php echo $moneda->id_tipomoneda;?>" class="btn btn-danger btn-sm btn-flat" title="Eliminar"><i class='fa fa-trash'></i></a>
                  </td>
                  </tr>
                  <?php
                }
                }else{
                  echo "<p class='alert alert-danger'>No hay monedas Registradas</p>";
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
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><i class="fa fa-steam-square" style="color: orange;"></i><b style="color: black;"> Registrar Nueva Moneda</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" action="index.php?action=nuevomoneda" role="form" method="post" enctype="multipart/form-data">
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Nombre</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nombre" name="nombre" required onkeypress="return sololetras(event)" onpaste="return false">
                      <span class="fa fa-file-text-o form-control-feedback"></span>
                    </div>
                </div>
                <!-- <div class="dDoNo ikb4Bb gsrt"><span class="DFlfde SwHCTb" data-precision="2" data-value="6816.0650000000005">6,816.07</span></div> -->
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Valor en Dolar</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="valor" name="valor" value="6816.0650000000005">
                      <span class="fa fa-money form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Simbolo</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="simbolo">
                        <option>Seleccionar</option>
                        <option value="US$">USD - Dolar</option>
                        <option value="₲">GS - Guaraníes</option>
                        <!-- <option value="₲">PYG</option> -->
                        <option value="R$">BRL - Real brasileño</option>
                      </select> 
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Descripcion</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
              <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
              <input type="hidden" name="sucursal" id="sucursal" value="<?php echo $sucursales->nombre; ?>">
              <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
              <button type="submit" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
              </form>
            </div>
        </div>
    </div>
</div>
<?php endif ?>
<?php endif ?>