<?php
$u = null;
if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != ""):
  $u = UserData::getById($_SESSION["admin_id"]);
  if ($u->is_admin): ?>
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1><i class='fa fa-steam-square' style="color: orange;"></i>
          Lista de precios
          <!-- <marquee> Lista de Medicamentos</marquee> -->
        </h1>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-plus"></i>
                  Nuevo</a>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <?php
                  $categorias = CategoriaData::getAll();
                  if (count($categorias) > 0) {
                    ?>
                    <table id="example1" class="table table-bordered table-dark" style="width:100%">
                      <thead>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>
                          <center>Acción</center>
                        </th>
                      </thead>
                      <tbody>
                        <?php
                        foreach ($categorias as $categoria) {
                          ?>
                          <tr>
                            <td><?php echo $categoria->nombre; ?></td>
                            <td><?php echo $categoria->descripcion; ?></td>
                            <td style="width:150px;">
                              <a href="index.php?view=actualizarcategoria&id_categoria=<?php echo $categoria->id_categoria; ?>"
                                data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cog"></i> Editar</a>
                              <a href="index.php?action=eliminarcategoria&id_categoria=<?php echo $categoria->id_categoria; ?>"
                                class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> Eliminar</a>
                            </td>
                          </tr>
                          <?php
                        }
                  } else {
                    echo "<p class='alert alert-danger'>No hay Marcas Registradas</p>";
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
            <h4 class="modal-title"><i class="fa fa-steam-square" style="color: orange;"></i><b style="color: black;">
                Agregar Nueva Marca</b></h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" action="index.php?action=nuevocategoria" role="form" method="post"
              enctype="multipart/form-data">
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Nombre</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="nombre" name="nombre" required
                    onkeypress="return sololetras(event)" onpaste="return false"
                    onKeyUP="this.value=this.value.toUpperCase();" maxlength="500" placeholder="Nombre de la Categoria">
                  <span class="fa fa-steam form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Descripcion</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="descripcion" name="descripcion"
                    placeholder="Descripcion de la Categoria"></textarea>
                  <span class="fa fa-file-text form-control-feedback"></span>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i>
              Cerrar</button>
            <button type="submit" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php endif ?>
  <?php if ($u->is_empleado): ?>
    <?php
    $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
    ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1><i class='fa fa-steam-square' style="color: orange;"></i>
          Lista Precios de productos
        </h1>
      </section>
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-plus"></i>
                  Nuevo</a>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <?php
                  $descrip_precio = "";
                  $descrip_moneda = "";
                  $codigo = "";
                  $descproducto = "";

                  $categorias = ProductoData::listar_precio_producto($sucursales->id_sucursal);
                  if (count($categorias) > 0) {
                    // si hay categorias
                    ?>
                    <table id="example1" class="table table-bordered table-dark" style="width:100%">
                      <thead>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Tipo precio</th>
                        <th> Importe</th>

                        <th>Moneda</th>
                        <th>
                          <center>Acción</center>
                        </th>
                      </thead>
                      <tbody>
                        <?php
                        foreach ($categorias as $preciopro) {


                          $descripcion = ProductoData::vertipomonedadescrip2($sucursales->id_sucursal, $preciopro->PRECIO_ID);


                          foreach ($descripcion as $descripcionnom) {

                            $descrip_precio = $descripcionnom->NOMBRE_PRECIO;
                            $descrip_moneda = $descripcionnom->NOMBRE_MONEDA;

                          }

                          $descripcion2 = ProductoData::vertipomonedadescrip3($sucursales->id_sucursal, $preciopro->PRODUCTO_ID);


                          foreach ($descripcion2 as $descripcionnom2) {

                            $codigo = $descripcionnom2->codigo;
                            $descproducto = $descripcionnom2->nombre;
                          }


                          ?>
                          <tr>
                            <td><?php echo $codigo ?></td>
                            <td><?php echo $descproducto ?></td>
                            <td><?php echo $descrip_precio ?></td>
                            <td><?php echo $preciopro->IMPORTE; ?></td>

                            <td><?php echo $descrip_moneda ?></td>
                            <td style="width:150px;">
                              <a href="index.php?view=actualizarprecio&id_sucursal=<?php echo $sucursales->id_sucursal; ?>&id_precio=<?php echo $preciopro->PRECIO_ID; ?>&id_producto=<?php echo $preciopro->PRODUCTO_ID; ?>"
                                data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cog"></i> Editar</a>

                            </td>
                          </tr>
                          <?php
                        }
                  } else {
                    echo "<p class='alert alert-danger'>No hay lista de precios de productos registrados</p>";
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
            <h4 class="modal-title"><i class="fa fa-steam-square" style="color: orange;"></i><b style="color: black;">
                Agregar Nuevo Precio de producto</b></h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" action="index.php?action=nuevolistaprecioproducto" role="form" method="post"
              enctype="multipart/form-data">






              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Producto:</label>
                <div class="col-sm-9">

                  <?php
                  $nombrem = "";
                  $product = ProductoData::verproductosucursal($sucursales->id_sucursal);
                  if (count($product) > 0): ?>
                    <select name="id_producto" id="id_producto" required class="form-control">
                      <option value="">SELECCIONAR PRODUCTO</option>
                      <?php foreach ($product as $products): ?>
                        <option value="<?php echo $products->id_producto; ?>" style="color: orange;"><i class="fa fa-gg"></i>
                          <?php echo $products->nombre; ?> </option>


                        <?php
                      endforeach; ?>


                    </select>
                  <?php endif; ?>
                  <span class="fa fa-file-text form-control-feedback"></span>
                </div>
              </div>


              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Tipo Precio:</label>
                <div class="col-sm-9">

                  <?php
                  $nombrem = "";
                  $listap = ProductoData::listar_precio($sucursales->id_sucursal);
                  if (count($listap) > 0): ?>
                    <select name="id_precio" id="id_precio" required class="form-control">
                      <option value="">SELECCIONAR PRECIO</option>
                      <?php foreach ($listap as $lista): ?>
                        <option value="<?php echo $lista->PRECIO_ID; ?>" style="color: orange;"><i class="fa fa-gg"></i>
                          <?php echo $lista->NOMBRE_PRECIO; ?> </option>


                        <?php
                      endforeach; ?>


                    </select>

                    <?php
                    // $NOMBRE_MONE= $lista->NOMBRE_MONEDA;
                    // $moneda_id= $lista->MONEDA_ID;							 ?>




                  <?php endif; ?>
                  <span class="fa fa-file-text form-control-feedback"></span>
                </div>
              </div>


              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Importe:</label>

                <div class="col-lg-4">
                  <input type="text" name="importe_precio" class="form-control" id="importe_precio"
                    onkeypress="return solonumeross(event);" placeholder="Precio de producto" maxlength="800" required="">
                  <span class="fa fa-laptop form-control-feedback"></span>
                </div>


                <span class="fa fa-file-text form-control-feedback"></span>

              </div>



              <div class="modal-footer">

                <input type="hidden" name="id_moneda" value="<?php echo $moneda_id; ?>">
                <input type="hidden" name="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
                <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                <input type="hidden" name="sucursal" id="sucursal" value="<?php echo $sucursales->nombre; ?>">
                <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i
                    class="fa fa-close"></i> Cerrar</button>
                <button type="submit" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i>
                  Guardar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php endif ?>
<?php endif ?>