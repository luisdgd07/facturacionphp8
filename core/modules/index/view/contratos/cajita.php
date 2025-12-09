  <?php
  $u = null;
  if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
    $u = UserData::getById($_SESSION["admin_id"]);
  ?>
    <!-- Content Wrapper. Contains page content -->
    <?php if ($u->is_admin) : ?>
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1><i class='fa  fa-laptop' style="color: orange;"></i>
            LISTA DE CONTRATOS
          </h1>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <!-- <div class="box-header with-border">
               <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-cart-plus"></i> Nuevo Producto</a>
            </div> -->
                <div class="box-body">
                  <div class="table-responsive">
                    <?php
                    $productos = ProductoData::getAll();
                    if (count($productos) > 0) {
                      // si hay Productos
                    ?>
                      <table id="example1" class="table table-bordered table-dark" style="width:100%">
                        <thead>
                          <th>Nombre</th>
                          <th>Imagen</th>
                          <th>Estado</th>
                          <th>Prec. Compra</th>
                          <th>Prec. Venta</th>
                          <th>
                            <center>Acción</center>
                          </th>
                        </thead>
                        <tbody>
                          <?php
                          foreach ($productos as $producto) {
                            $url = "storage/producto/" . $producto->imagen;
                          ?>
                            <tr>
                              <td><?php if ($producto->sucursal_id == "") : ?>
                                  <?php echo $producto->nombre; ?>
                                <?php else : ?>
                                  <?php echo $producto->nombre . " " . $producto->verSocursal()->nombre; ?>
                                <?php endif ?></td>
                              <td>
                                <center><a class="fancybox" href="<?php echo $url; ?>" target="_blank" data-fancybox-group="gallery" title="Smartphone Samsung Galaxy"><img class="fancyResponsive img-circle" src="<?php echo $url; ?>" alt="" width="30" height="30" /></a></center>
                              </td>
                              <td><?php if ($producto->activo == 1) : ?>
                                  <i class="fa fa-check"></i>
                                <?php else : ?>
                                  <i class="fa fa-close"></i>
                                <?php endif ?>
                              </td>
                              <td width="80px"><b> <?php echo $producto->precio_compra; ?></b></td>
                              <td width="80px"><b> <?php echo $producto->precio_venta; ?></b></td>
                              <!-- <td><?php echo $producto->precio_venta; ?></td> -->
                              <td style="width:150px;">
                                <a href="index.php?view=actualizarproducto&id_producto=<?php echo $producto->id_producto; ?>" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cog"></i> Editar</a>
                                <a href="index.php?action=eliminarproducto&id_producto=<?php echo $user->id_producto; ?>" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> Eliminar</a>
                              </td>
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
      <div class="modal fade" id="addnew">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><i class="fa fa-cart-plus"></i><b> Registro de un Nuevo Producto</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="post" enctype="multipart/form-data" action="index.php?action=nuevoproducto" role="form">
                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-3 control-label">Imagen</label>
                  <div class="col-lg-9">
                    <input type="file" name="imagen">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Codigo</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="codigo" name="codigo" required maxlength="30" value="<?php $Random_code = rand();
                                                                                                                      echo $Random_code; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Nombre</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" required="" name="nombre" onpaste="return false" maxlength="500">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Categoria</label>
                  <div class="col-sm-9">
                    <select name="categoria_id" id="categoria_id" class="form-control">
                      <option value="">SELECCIONAR CATEGORIA</option>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Descripcion</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="descripcion" name="descripcion" onpaste="return false" maxlength="500">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Presentacion</label>
                  <div class="col-sm-9">
                    <select name="presentacion" id="presentacion" class="form-control">
                      <option value="CAJITA">SELECCIONAR PRESENTACION</option>
                      <option value="caja"><i class="fa fa-gg"></i>Caja</option>
                      <option value="litro"><i class="fa fa-gg"></i>Litro</option>
                      <option value="saco"><i class="fa fa-gg"></i>Saco</option>
                      <option value="tableta"><i class="fa fa-gg"></i>Tableta</option>
                      <option value="frasco"><i class="fa fa-gg"></i>Frasco</option>
                      <option value="sobre"><i class="fa fa-gg"></i>Sobre</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Unidad</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="unidades" name="unidades" onkeypress="return solonumeros(event);" onpaste="return false" maxlength="100">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Precio Compra</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="precio_compra" name="precio_compra" required onkeypress="return solonumeross(event);" onpaste="return false" maxlength="100">
                  </div>
                </div>
                <!-- <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Precio Venta</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="precio_venta" name="precio_venta" required onkeypress="return solonumeross(event);" onpaste="return false" maxlength="100">
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Minimo Inventario</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="inventario_minimo" name="inventario_minimo" required onkeypress="return solonumeros(event);" onpaste="return false" maxlength="10">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Stock Inicial</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="q" name="q" required onkeypress="return solonumeros(event);" onpaste="return false" maxlength="10000">
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
              <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Guardar</button>
              </form>
            </div>
          </div>
        </div>
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
            LISTA DE CONTRATOS
          </h1>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <!-- <div class="box-header with-border">
               <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-cart-plus"></i> Nuevo Producto</a>
            </div> -->
                <div class="box-body">
                  <div class="table-responsive">
                    <?php
                    $productos = ContratoData::buscarSucursal($sucursales->id_sucursal);
                    if (count($productos) > 0) {
                      // si hay Productos
                    ?>
                      <table id="example1" class="table table-bordered table-dark" style="text-align:center">
                        <thead>
                          <th>
                            <center>Cliente</center>
                          </th>
						  
						    <th>
                            <center>Nro Contrato</center>
                          </th>
                          <th>
                            <center>Cuotas</center>
                          </th>
						  
						   <th>
                            <center>Monto Cuota</center>
                          </th>
                          <th>
                            <center>Entrega</center>
                          </th>

                          <th>
                            <center>Zona</center>
                          </th>
                        
                          <th>
                            <center>Descripción</center>
                          </th>
                          <th>
                            <center>Total</center>
                          </th>
                          <th>
                            <center>Fecha</center>
                          </th>

                        </thead>
                        <tbody>
                          <?php
                          foreach ($productos as $producto) {
                            //$url = "storage/producto/" . $producto->imagen;
                          ?>
                            <tr>
                              <td width="80px"><?php echo ClienteData::getById($producto->id_cliente)->nombre; ?></td>
                              
							     <td width="100px"><?php echo $producto->datos; ?></td>
							  <td width="80px"><?php echo $producto->cuota; ?></td>
							  
							    <td width="80px"><?php echo $producto->monto; ?></td>
							  
                              <td width="100px"><?php echo $producto->entrega; ?></td>
                              <td width="100px"><?php echo $producto->zona; ?></td>
                           
                              <td width="100px"><?php echo $producto->descripcion; ?></td>
                              <td width="110px"> <b> <?php echo  number_format($producto->total, 2, ',', '.'); ?></b></td>



                              <td width="100px"><?php echo $producto->fecha; ?></td>



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
      <div class="modal fade" id="addnew">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><i class="fa fa-cart-plus"></i><b> Registro de un Nuevo Producto</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="post" enctype="multipart/form-data" action="index.php?action=nuevoproducto1" role="form">
                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-3 control-label">Imagen</label>
                  <div class="col-lg-9">
                    <input type="file" name="imagen">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Codigo</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="codigo" name="codigo" required maxlength="30" value="<?php $Random_code = rand();
                                                                                                                      echo $Random_code; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Nombre</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" required="" name="nombre" onpaste="return false" maxlength="500">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Categoria</label>
                  <div class="col-sm-9">
                    <select name="categoria_id" id="categoria_id" class="form-control">
                      <option value="">SELECCIONAR CATEGORIA</option>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Descripcion</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="descripcion" name="descripcion" onpaste="return false" maxlength="500">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Presentacion</label>
                  <div class="col-sm-9">
                    <select name="presentacion" id="presentacion" class="form-control">
                      <option value="CAJITA">SELECCIONAR PRESENTACION</option>
                      <option value="caja"><i class="fa fa-gg"></i>Caja</option>
                      <option value="litro"><i class="fa fa-gg"></i>Litro</option>
                      <option value="saco"><i class="fa fa-gg"></i>Saco</option>
                      <option value="tableta"><i class="fa fa-gg"></i>Tableta</option>
                      <option value="frasco"><i class="fa fa-gg"></i>Frasco</option>
                      <option value="sobre"><i class="fa fa-gg"></i>Sobre</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Unidad</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="unidades" name="unidades" onkeypress="return solonumeros(event);" onpaste="return false" maxlength="100">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Precio Compra</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="precio_compra" name="precio_compra" required onkeypress="return solonumeross(event);" onpaste="return false" maxlength="100">
                  </div>
                </div>
                <!-- <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Precio Venta</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="precio_venta" name="precio_venta" required onkeypress="return solonumeross(event);" onpaste="return false" maxlength="100">
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Minimo Inventario</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="inventario_minimo" name="inventario_minimo" required onkeypress="return solonumeros(event);" onpaste="return false" maxlength="10">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-3 control-label">Stock Inicial</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="q" name="q" required onkeypress="return solonumeros(event);" onpaste="return false" maxlength="10000">
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
              <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
              <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Guardar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php endif ?>
  <?php endif ?>