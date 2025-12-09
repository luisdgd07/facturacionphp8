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
      <h1><i class='fa fa-gift' style="color: orange;"></i>
        REALIZAR VENTA DE LOS PRODUCTOS
       <!-- <marquee> Las entregas de manea enmediata</marquee> -->
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
                <div class="box box-warning">
                      <div class="box-header">
                        <!-- <h1>PRODUCTOS</h1> -->
                        <!-- <i class="fa fa-ticket"></i> Nuevo Cliente -->
                        <i class="fa fa-laptop" style="color: orange;"></i> DEGITAR EL NOMBRE DEL <B>PRODUCTO</B> PARA PODER REALIZAR LA BUSQUEDA.
                      </div>
                      <form id="searchppp">
                      <div class="row">
                        <div class="col-md-9">
                          <input type="hidden" name="view" value="vender" >
                          <input type="text" id="nombre" name="producto" class="form-control">
                        </div>
                        <div class="col-md-3">
                          <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                        <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                        </div>
                      </div>
                      </form>
                  </div>
                  <div id="resultado_producto"></div>
                  <?php if(isset($_SESSION["errors"])):?>
                  <h2>Errores</h2>
                  <p></p>
                  <table class="table table-bordered table-hover">
                  <tr class="danger">
                    <th>Codigo</th>
                    <th>Producto</th>
                    <th>Mensaje</th>
                  </tr>
                  <?php foreach ($_SESSION["errors"]  as $error):
                  $product = ProductoData::getById($error["producto_id"]);
                  ?>
                  <tr class="danger">
                    <td><?php echo $product->id_producto; ?></td>
                    <td><?php echo $product->nombre; ?></td>
                    <td><b><?php echo $error["message"]; ?></b></td>
                  </tr>

                  <?php endforeach; ?>
                  </table>
                  <?php
                  unset($_SESSION["errors"]);
                   endif; ?>
            </div>
          </div>
          <div id="show_search_results"></div>
        </div>
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <div class="box box-warning">
                <?php if(isset($_SESSION["cart"])):
                  $total = 0;
                  ?>
                  <h2>Lista de Productos deseados</h2>
                  <table class="table table-bordered table-hover">
                  <thead>
                    <th style="width:30px;">Codigo</th>
                    <th style="width:30px;">Cantidad</th>
                    <!-- <th style="width:30px;">Disponible</th> -->
                    <th>Producto</th>
                    <th style="width:120px;">Precio Unitario</th>
                    <th style="width:120px;">Precio Total</th>
                    <th ></th>
                  </thead>
                  <?php foreach($_SESSION["cart"] as $p):
                  $product = ProductoData::getById($p["producto_id"]);
                  ?>
                  <tr >
                    <td><?php echo $product->id_producto; ?></td>
                    <td ><?php echo $p["q"]; ?></td>
                    <!-- <td><?php echo $product->unidad; ?></td> -->
                    <td><?php echo $product->nombre; ?></td>
                    <td><b>Bs <?php echo number_format($product->precio_venta,0,'.','.'); ?></b></td>
                    <td><b>Bs <?php  $pt = $product->precio_venta*$p["q"]; $total +=$pt; echo number_format($pt,0,'.','.'); ?></b></td>
                    <td style="width:30px;"><a href="index.php?action=eliminarcompraproductos&producto_id=<?php echo $product->id_producto; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
                  </tr>

                  <?php endforeach; ?>
                  </table>
                  <form method="post" class="form-horizontal" id="processsell" action="index.php?action=procesoventaproducto">
                  <h2>Detalle Venta</h2>
                  <div class="form-group">
                      <label for="inputEmail1" class="col-lg-2 control-label">Cliente</label>
                      <div class="col-lg-10">
                      <?php 
                  $clients = ClienteData::getAll();
                      ?>
                      <select required name="cliente_id" class="form-control">
                      <option value="">-- NINGUNO --</option>
                      <?php foreach($clients as $client):?>
                        <option value="<?php echo $client->id_cliente;?>"><?php echo $client->nombre." ".$client->apellido;?></option>
                      <?php endforeach;?>
                        </select>
                      </div>
                    </div>
                  <div class="form-group">
                      <label for="inputEmail1" class="col-lg-2 control-label">Descuento</label>
                      <div class="col-lg-10">
                        <input type="text" name="descuento" class="form-control" required value="0" id="descuento" placeholder="Descuento">
                      </div>
                    </div>
                   <div class="form-group">
                      <label for="inputEmail1" class="col-lg-2 control-label">Efectivo</label>
                      <div class="col-lg-10">
                        <input type="text" name="money" required class="form-control" id="money" placeholder="Efectivo">
                      </div>
                    </div>
                        <input type="hidden" name="total" value="<?php echo $total; ?>" class="form-control" placeholder="Total">

                    <div class="row">
                  <div class="col-md-6 col-md-offset-6">
                  <table class="table table-bordered">
                  <tr>
                    <td><p>Subtotal</p></td>
                    <td><p><b> <?php echo number_format($total*.84,0,'.','.'); ?></b></p></td>
                  </tr>
                  <tr>
                    <td><p>IVA</p></td>
                    <td><p><b> <?php echo number_format($total*.16,0,'.','.'); ?></b></p></td>
                  </tr>
                  <tr>
                    <td><p>Total</p></td>
                    <td><p><b> <?php echo number_format($total,0,'.','.'); ?></b></p></td>
                  </tr>

                  </table>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <div class="checkbox">
                          <label>
                            <input name="is_oficiall" type="hidden" value="1">
                          </label>
                        </div>
                      </div>
                    </div>
                  <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <div class="checkbox">
                          <label>
                      <a href="index.php?action=eliminarcompraproductos" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                          <button class="btn btn-lg btn-warning"><b>Bs</b> Finalizar Venta</button>
                          <script>
                              $("#processsell").submit(function(e){
                                descuento = $("#descuento").val();
                                money = $("#money").val();
                                if(money<(<?php echo $total;?>-descuento)){
                                  alert("No se puede Realizar la operacion");
                                  e.preventDefault();
                                }else{
                                  if(descuento==""){ descuento=0;}
                                  go = confirm("Su Cambio: Bs "+(money-(<?php echo $total;?>-descuento ) ) );
                                  if(go){}
                                    else{e.preventDefault();}
                                }
                              });
                            </script>
                          </label>
                        </div>
                      </div>
                    </div>
                  </form>
                  <?php endif; ?>
              </div>
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa fa-gift' style="color: orange;"></i>
        REALIZAR VENTA DE LOS PRODUCTOS
       <!-- <marquee> Las entregas de manea enmediata</marquee> -->
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
                <div class="box box-warning">
                      <div class="box-header">
                        <!-- <h1>PRODUCTOS</h1> -->
                        <!-- <i class="fa fa-ticket"></i> Nuevo Cliente -->
                        <i class="fa fa-laptop" style="color: orange;"></i> DEGITAR EL NOMBRE DEL <B>PRODUCTO</B> PARA PODER REALIZAR LA BUSQUEDA.
                      </div>
                      <form id="searchppp">
                      <div class="row">
                        <div class="col-md-9">
                          <input type="hidden" name="view" value="vender" >
                          <input type="text" id="nombre" name="producto" class="form-control">
                        </div>
                        <div class="col-md-3">
                          <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                        <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                        </div>
                      </div>
                      </form>
                  </div>
                  <div id="resultado_producto"></div>
                  <?php if(isset($_SESSION["errors"])):?>
                  <h2>Errores</h2>
                  <p></p>
                  <table class="table table-bordered table-hover">
                  <tr class="danger">
                    <th>Codigo</th>
                    <th>Producto</th>
                    <th>Mensaje</th>
                  </tr>
                  <?php foreach ($_SESSION["errors"]  as $error):
                  $product = ProductoData::getById($error["producto_id"]);
                  ?>
                  <tr class="danger">
                    <td><?php echo $product->id_producto; ?></td>
                    <td><?php echo $product->nombre; ?></td>
                    <td><b><?php echo $error["message"]; ?></b></td>
                  </tr>

                  <?php endforeach; ?>
                  </table>
                  <?php
                  unset($_SESSION["errors"]);
                   endif; ?>
            </div>
          </div>
          <div id="show_search_results"></div>
        </div>
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <div class="box box-warning">
                <?php if(isset($_SESSION["cart"])):
                  $total = 0;
                  ?>
                  <h2>Lista de Productos deseados</h2>
                  <table class="table table-bordered table-hover">
                  <thead>
                    <th style="width:30px;">Codigo</th>
                    <th style="width:30px;">Cantidad</th>
                    <!-- <th style="width:30px;">Disponible</th> -->
                    <th>Producto</th>
                    <th style="width:120px;">Precio Unitario</th>
                    <th style="width:120px;">Precio Total</th>
                    <th ></th>
                  </thead>
                  <?php foreach($_SESSION["cart"] as $p):
                  $product = ProductoData::getById($p["producto_id"]);
                  ?>
                  <tr >
                    <td><?php echo $product->id_producto; ?></td>
                    <td ><?php echo $p["q"]; ?></td>
                    <!-- <td><?php echo $product->unidad; ?></td> -->
                    <td><?php echo $product->nombre; ?></td>
                    <td><b>Bs <?php echo number_format($product->precio_venta,0,'.','.'); ?></b></td>
                    <td><b>Bs <?php  $pt = $product->precio_venta*$p["q"]; $total +=$pt; echo number_format($pt,0,'.','.'); ?></b></td>
                    <td style="width:30px;"><a href="index.php?action=eliminarcompraproductos1&id_sucursal=<?php echo $sucursales->id_sucursal;?>&producto_id=<?php echo $product->id_producto; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
                  </tr>

                  <?php endforeach; ?>
                  </table>
                  <form method="post" class="form-horizontal" id="processsell" action="index.php?action=procesoventaproducto1">
                  <h2>Detalle Venta</h2>
                  <div class="form-group">
                      <label for="inputEmail1" class="col-lg-2 control-label">Cliente</label>
                      <div class="col-lg-10">
                      <?php 
                  $clients = ClienteData::getAll();
                      ?>
                      <select required name="cliente_id" class="form-control">
                      <option value="">-- NINGUNO --</option>
                      <?php foreach($clients as $client):?>
                        <option value="<?php echo $client->id_cliente;?>"><?php echo $client->nombre." ".$client->apellido;?></option>
                      <?php endforeach;?>
                        </select>
                      </div>
                    </div>
                  <div class="form-group">
                      <label for="inputEmail1" class="col-lg-2 control-label">Descuento</label>
                      <div class="col-lg-10">
                        <input type="text" name="descuento" class="form-control" required value="0" id="descuento" placeholder="Descuento">
                      </div>
                    </div>
                   <div class="form-group">
                      <label for="inputEmail1" class="col-lg-2 control-label">Efectivo</label>
                      <div class="col-lg-10">
                        <input type="text" name="money" required class="form-control" id="money" placeholder="Efectivo">
                      </div>
                    </div>
                        <input type="hidden" name="total" value="<?php echo $total; ?>" class="form-control" placeholder="Total">

                    <div class="row">
                  <div class="col-md-6 col-md-offset-6">
                  <table class="table table-bordered">
                  <tr>
                    <td><p>Subtotal</p></td>
                    <td><p><b> <?php echo number_format($total*.84,0,'.','.'); ?></b></p></td>
                  </tr>
                  <tr>
                    <td><p>IVA</p></td>
                    <td><p><b> <?php echo number_format($total*.16,0,'.','.'); ?></b></p></td>
                  </tr>
                  <tr>
                    <td><p>Total</p></td>
                    <td><p><b> <?php echo number_format($total,0,'.','.'); ?></b></p></td>
                  </tr>

                  </table>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <div class="checkbox">
                          <label>
                            <input name="is_oficiall" type="hidden" value="1">
                          </label>
                        </div>
                      </div>
                    </div>
                  <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <div class="checkbox">
                          <label>
                          <input type="hidden" name="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
                          <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                      <a href="index.php?action=eliminarcompraproductos1&id_sucursal=<?php echo $sucursales->id_sucursal;?>" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                          <button class="btn btn-lg btn-warning"><b>Bs</b> Finalizar Venta</button>
                          <script>
                              $("#processsell").submit(function(e){
                                descuento = $("#descuento").val();
                                money = $("#money").val();
                                if(money<(<?php echo $total;?>-descuento)){
                                  alert("No se puede Realizar la operacion");
                                  e.preventDefault();
                                }else{
                                  if(descuento==""){ descuento=0;}
                                  go = confirm("Su Cambio: Bs "+(money-(<?php echo $total;?>-descuento ) ) );
                                  if(go){}
                                    else{e.preventDefault();}
                                }
                              });
                            </script>
                          </label>
                        </div>
                      </div>
                    </div>
                  </form>
                  <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
  <?php endif ?>
<?php endif ?>