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
                  $total1 = 0;
                  $total10por =0;
                  $total5por =0;
                  $total0porc=0;
                  $exenta=0;
                  $iva10=0;
                  $iva5=0;
                  $iva0=0;
                  $grabada10=0;
                  $grabada5=0;
                  $grabada0=0;
                  ?>
                  <h2>Lista de Productos deseados</h2>
                  <table class="table table-bordered table-hover">
                  <thead>
                    <th style="width:30px;">Codigo</th>
                    <th style="width:30px;">Cantidad</th>
                    <th>Producto</th>
                    <th>Impuesto</th>
                    <th>Iva</th>
                    <th>Grabada</th>
                    <!-- <th>5%</th> -->
                    <th style="width:120px;">Precio Unitario</th>
                    <!-- <th style="width:120px;">Sub Total</th> -->
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
                    <td><?php echo $product->impuesto; ?> %</td>
                    <td><?php if ($product->impuesto==10): ?>
                      <b style="color: blue;"><?php echo (($product->precio_venta*$p["q"])/11);$iva10+=(($product->precio_venta*$p["q"])/11);?></b>
                      <?php else: ?>
                      <?php if ($product->impuesto==5): ?>
                      <b style="color: green;"><?php echo (($product->precio_venta*$p["q"])/21);$iva5+=(($product->precio_venta*$p["q"])/21);?></b>
                      <?php else: ?>
                      <b style="color: red;"><?php echo (($product->precio_venta*$p["q"]));$iva0+=(($product->precio_venta*$p["q"]));?></b>
                    <?php endif ?>
                    <?php endif ?></td>
                    <td><?php if ($product->impuesto==10): ?>
                      <b style="color: blue;"><?php echo (($product->precio_venta*$p["q"])/1.1);$grabada10+=(($product->precio_venta*$p["q"])/1.1);?></b>
                      <?php else: ?>
                      <?php if ($product->impuesto==5): ?>
                      <b style="color: green;"><?php echo (($product->precio_venta*$p["q"])/1.05);$grabada5+=(($product->precio_venta*$p["q"])/1.05);?></b>
                      <?php else: ?>
                      <b style="color: red;"><?php echo (($product->precio_venta*$p["q"]));$grabada0+=(($product->precio_venta*$p["q"]));?></b>
                    <?php endif ?>
                    <?php endif ?></td>
                    <!-- <td><?php echo (($product->precio_venta*$product->impuesto)/100); ?></td> -->
                    <td><b> <?php echo number_format($product->precio_venta,0,'.','.'); ?></b></td>
                    <!-- <td><?php if ($product->impuesto==10): ?>
                      <b style="color: blue;">  <?php echo $pt = ($product->precio_venta*$p["q"])-(($product->precio_venta*$product->impuesto)/100); $total10por +=($product->precio_venta*$p["q"])-(($product->precio_venta*$product->impuesto)/100); ?></b>
                      <?php else: ?>
                        <?php if ($product->impuesto==5): ?>
                      <b style="color: green;">  <?php echo $pt = ($product->precio_venta*$p["q"])-(($product->precio_venta*$product->impuesto)/100); $total5por +=($product->precio_venta*$p["q"])-(($product->precio_venta*$product->impuesto)/100); ?></b>
                      <?php else: ?>
                        <b style="color: red;">  <?php echo $pt = ($product->precio_venta*$p["q"])-(($product->precio_venta*$product->impuesto)/100); $total0porc +=($product->precio_venta*$p["q"])-(($product->precio_venta*$product->impuesto)/100); ?></b>
                    <?php endif ?>
                    <?php endif ?></td> -->
                    <td><b> <?php  $pt = $product->precio_venta*$p["q"]; $total1 +=$pt; echo $product->precio_venta*$p["q"]; ?></b></td>
                    <td style="width:30px;"><a href="index.php?action=eliminarcompraproductos1&id_sucursal=<?php echo $sucursales->id_sucursal;?>&producto_id=<?php echo $product->id_producto; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
                  </tr>

                  <?php endforeach; ?>
                  </table>
                  <form method="post" class="form-horizontal" id="processsell" action="index.php?action=procesoventaproducto1">
                    <div style="border-color: #FF0000;">
                      <div class="form-group">
                        <label for="inputEmail1" class="col-lg-1 control-label">Presupesto</label>
                        <div class="col-lg-2">
                          <input type="text" name="presupuesto"  class="form-control"  value="0" id="presupuesto">
                          <input type="hidden" name="factura" id="num1">
                          <input type="hidden" name="numeracion_inicial" id="numinicio">
                          <input type="hidden" name="numeracion_final" id="numfin">
                          <input type="hidden" name="serie1" id="serie">
                        </div>
                              <label for="inputEmail1" class="col-lg-1 control-label">Tipo Doc.</label>
                              <div class="col-lg-2">
                              <?php 
                          $clients = ConfigFacturaData::verfacturasucursal($sucursales->id_sucursal);
                              ?>
                              <select required="" name="configfactura_id" id="configfactura_id" class="form-control" oninput="configFactura()">
                                <option>Seleccionar</option>
                              <?php foreach($clients as $client):?>
                                <option <?php if ($client->diferencia==-1): ?>disabled=""<?php else: ?><?php endif ?> value="<?php echo $client->id_configfactura;?>"><?php echo $client->comprobante1;?></option>
                                <script type="text/javascript">
                                function configFactura()
                                  {
                                    $.ajax({
                                      url: 'index.php?action=consultafactura',
                                      type: 'POST',
                                      data:{
                                        confiFactura: Number(document.getElementById("configfactura_id").value)
                                      },
                                      dataType: 'json',
                                      success: function(json){
                                        
                                        // console.log(json[0].valor);
                                        document.getElementById('num1').value=json[0].numeroactual1;
                                        document.getElementById('numinicio').value=json[0].numeracion_inicial;
                                        document.getElementById('numfin').value=json[0].numeracion_final;
                                        document.getElementById('serie').value=json[0].serie1;
                                        document.getElementById('id_configfactura').value=json[0].id_configfactura;
                                        document.getElementById('diferencia').value=json[0].diferencia;
                                      }, error: function(xhr, status){
                                        console.log("Ha ocurrido un error.");
                                      }
                                    });

                                  }
                              </script>
                              <?php endforeach;?>
                                </select>
                              </div>
                              <div>
                                <input type="hidden" name="id_configfactura" id="id_configfactura">
                                <input type="hidden" name="diferencia" id="diferencia">
                              </div>








                              <label for="inputEmail1" class="col-lg-1 control-label">Moneda</label>
                              <div class="col-lg-2">
                              <?php 
                                 $monedas = MonedaData::versucursalmoneda($sucursales->id_sucursal);
                              ?>
                              <select required="" name="tipomoneda_id" id="tipomoneda_id" id1="valor" class="form-control" oninput="tipocambio()">
                                <option>Seleccionar</option>
                              <?php foreach($monedas as $moneda):?>
                                <?php 
                                $valocito=null;
                                 ?>
                                <option value="<?php echo $moneda->id_tipomoneda;?>"><?php echo $moneda->nombre."-".$moneda->simbolo;?></option>

                                <script type="text/javascript">
                                function tipocambio()
                                  {
                                    $.ajax({
                                      url: 'index.php?action=consultamoneda',
                                      type: 'POST',
                                      data:{
                                        tipoMoneda: Number(document.getElementById("tipomoneda_id").value)
                                      },
                                      dataType: 'json',
                                      success: function(json){
                                        
                                        // console.log(json[0].valor);
                                        document.getElementById('cambio').value=json[0].valor;
                                      }, error: function(xhr, status){
                                        console.log("Ha ocurrido un error.");
                                      }
                                    });

                                  }
                              </script>
                              <?php endforeach;?>
                                </select>
                              </div>
                              <label for="inputEmail1" class="col-lg-1 control-label">Cambio</label>
                              <div class="col-lg-2">
                                <input type="text" name="cambio" id="cambio" class="form-control">











                           <!--  <?php 
                          $monedas = MonedaData::versucursalmoneda($sucursales->id_sucursal);
                              ?>
                              <select  name="cambio" id="cambio" class="form-control">
                              <?php foreach($monedas as $moneda):?>
                                <option id="cambio" value="<?php echo $moneda->valor;?>"><?php echo $moneda->nombre."-".$moneda->valor;?></option>
                              <?php endforeach;?>
                                </select> -->
                    </div>
                  <div class="row">
                    <div class="col-md-6">
                      <h2>Detalle Venta</h2>
                          <div class="form-group">
                              <label for="inputEmail1" class="col-lg-2 control-label">Cliente</label>
                              <div class="col-lg-9">
                              <?php 
                          $clients = ClienteData::getAll();
                              ?>
                              <select  name="cliente_id" class="form-control">
                              <?php foreach($clients as $client):?>
                                <option value="<?php echo $client->id_cliente;?>"><?php echo $client->dni." - ".$client->nombre." ".$client->apellido." - ".$client->tipo_doc;?></option>
                              <?php endforeach;?>
                                </select>
                              </div>
                              <div class="col-lg-1">
                                <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-user-plus"></i></a>
                              </div>
                            </div>
                            <div id="ocultar">
                            <div class="form-group">
                              <label for="inputEmail1" class="col-lg-2 control-label">Forma de Pago</label>
                              <div class="col-lg-10">
                                <style>
                                .multiselectt{
                                  width: 200px:;
                                }
                                .selectBoxx{
                                  position: relative;
                                }
                                .selectBoxx select{
                                  width: auto;
                                  font-weight: bold;
                                }
                                .overSelectt{
                                  position: absolute;
                                  left: 0; right: 0; top: 0; bottom: 0;
                                }
                                #checkboxess{
                                  display: none;
                                  /*border: 1px #dadada solid;*/
                                }
                                #checkboxess label{
                                  display: block;
                                }
                                #checkboxess label:hover{
                                  /*background-color: #1e90ff;*/
                                }
                              </style>
                          <div class="form-group">
                              <div class="col-lg-8">
                                <div class="multiselectt">
                                      <div class="selectBoxx" onclick="showCheckboxess()">
                                        <select>
                                          <option>---------------MODALIDAD-----------</option>
                                        </select>
                                        <div class="overSelectt"></div>
                                      </div>
                                      <div id="checkboxess" requered="requered">
                                        <input name="formapago" autofocus="autofocus"  value="Efectivo" type="radio" name=""onclick="Ocultar1();"> Efectivo
                                        <br>
                                        <input name="formapago" value="Targeta de Debito"  type="radio" name=""onclick="Mostrar1();"> Targeta de Debito
                                         <br>
                                        <input name="formapago" value="Targeta de Credito"  type="radio" name=""onclick="Mostrar1();"> Targeta de Credito
                                        <br>
                                        <input name="formapago" value="Giro"  type="radio" name=""onclick="Ocultar1();"> Giro
                                      </div>
                                    </div>
                                    <script>
                                      var expanded = false;
                                      function showCheckboxess() {
                                        // body...
                                        var checkboxess = document.getElementById("checkboxess")
                                        if(!expanded){
                                          checkboxess.style.display="block"
                                          expanded= true;
                                        }else{
                                          checkboxess.style.display = "none";
                                          expanded=false;
                                        }
                                      }
                                    </script>
                              </div>
                            </div>
                              </div>
                            </div>
                           <div id="ocultar1"></div>
                           <div id="mostrar1">
                             <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 control-label">Codigo</label>
                                <div class="col-lg-9">
                                  <input type="number"  name="codigo" class="form-control"  value="0" id="codigo" placeholder="Descuento">
                                </div>
                              </div>
                           </div>  
                            </div>
                          <div id="mostrar">
                           <div class="form-group">
                              <label for="inputEmail1" class="col-lg-3 control-label">Fecha Pago</label>
                              <div class="col-lg-9">
                                <input type="date" name="fechapago"  class="form-control" id="fechapago" placeholder="Efectivo">
                              </div>
                            </div>
                          </div> 
                    </div>
                    <div class="col-md-6"><style>
                                .multiselect{
                                  width: 200px:;
                                }
                                .selectBox{
                                  position: relative;
                                }
                                .selectBox select{
                                  width: auto;
                                  font-weight: bold;
                                }
                                .overSelect{
                                  position: absolute;
                                  left: 0; right: 0; top: 0; bottom: 0;
                                }
                                #checkboxes{
                                  display: none;
                                  /*border: 1px #dadada solid;*/
                                }
                                #checkboxes label{
                                  display: block;
                                }
                                #checkboxes label:hover{
                                  /*background-color: #1e90ff;*/
                                }
                              </style>
                      <br>
                      <br>
                      <br>
                          <div class="form-group">
                              <label
                               for="inputEmail1" class="col-lg-4 control-label">Metodo del Pago</label>
                              <div class="col-lg-8">
                                <div class="multiselect">
                                      <div class="selectBox" onclick="showCheckboxes()">
                                        <select>
                                          <option>---------------MODALIDAD-----------</option>
                                        </select>
                                        <div class="overSelect"></div>
                                      </div>
                                      <div id="checkboxes" >
                                        <input name="metodopago" value="Credito" type="radio" name=""onclick="Mostrar();"> Credito
                                        <br>
                                        <input name="metodopago" value="Contado"  type="radio" name=""onclick="Ocultar();"> Contado
                                        <!-- <label for="Debito"><a type="button" onclick="Ocultar();"></a></label> -->
                                      </div>
                                    </div>
                                    <script>
                                      var expanded = false;
                                      function showCheckboxes() {
                                        // body...
                                        var checkboxes = document.getElementById("checkboxes")
                                        if(!expanded){
                                          checkboxes.style.display="block"
                                          expanded= true;
                                        }else{
                                          checkboxes.style.display = "none";
                                          expanded=false;
                                        }
                                      }
                                    </script>
                              </div>
                            </div>                            
                    </div>
                  </div>
                  <hr>
                    <div class="row">
                  <div class="col-md-6 col-md-offset-6">
                  <table class="table table-bordered">
                  <tr>
                    <td><p>Grabada 10%</p></td>
                    <td><p><b> <input type="text" readonly="" name="total10"  id="total10" placeholder="Efectivo" value="<?php echo ($grabada10); ?>"> 
                    </b></p></td>
                    <td>IVA. 10%</td>
                    <td><p><b> <input type="text" readonly="readonly" name="iva10" value="<?php echo ($iva10); ?>">  
                  </tr>
                  <tr>
                    <td><p>Grabada 5%</p></td>
                    <td><p><b><input type="text" readonly="" name="total5" value="<?php echo ($grabada5); ?>"> </b></p></td>
                    <td>IVA. 5%</td>
                    <td><p><b><input type="text" readonly="" name="iva5" value="<?php echo ($iva5); ?>">  
                  </tr>
                  <tr>
                    <td><p>Exenta</p></td>
                    <td><p><b><input type="text" readonly="" name="exenta" value="<?php echo ($grabada0); ?>"> </b></p></td>
                  </tr>
                  <tr>
                    <td><p>Total</p></td>
                    <td><p><b><input type="text" readonly="" name="total" value="<?php echo $total1; ?>"> </b></p></td>
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
  <div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><i class="fa fa-user-circle" style="color: orange;"></i><b> Agregar Nuevo Cliente</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" action="index.php?action=nuevocliente1" role="form" method="post" enctype="multipart/form-data">
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-lg-3 control-label">Imagen</label>
                    <div class="col-lg-9">
                      <input type="file" name="imagen" class="form-control">
                      <span class="fa fa-image form-control-feedback"></span>
                    </div>
                  </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Nombre</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nombre" name="nombre" required onkeypress="return sololetras(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="80" placeholder="Nombre del Cliente">
                      <span class="fa fa-user-secret form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Apellido</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="apellido" name="apellido" required onkeypress="return sololetras(event)" onpaste="return false" onKeyUP="this.value=this.value.toLowerCase();" maxlength="200" placeholder="Apellido del Cliente">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Tipo Doc.</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="tipo_doc">
                        <option value="RUC">RUC</option>
                        <option value="CI">C.I.</option>
                        <option value="PASAPORTE">PASAPORTE</option>
                        <option value="CEDULA DE EXTRANJERO">CEDULA DE EXTRANJERO</option>
                        <option value="SIN NOMBRE">SIN NOMBRE</option>
                        <option value="DIPLOMATICO">DIPLOMATICO</option>
                        <option value="IDENTIFICACION TRIBUTARIA">IDENTIFICACIÓN TRIBUTARIA</option>
                      </select>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">N° Documento</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="dni" name="dni" required  onpaste="return false" maxlength="8" placeholder="Cedula de Identidad del Cliente">
                      <span class="fa fa-credit-card form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Ciudad</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="ciudad" name="ciudad"   onpaste="return false"  placeholder="Ciudad del Cliente">
                      <span class="fa fa-map form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Dirección</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="direccion" name="direccion"   onpaste="return false"  placeholder="Dirección del Cliente">
                      <span class="fa fa-map-marker form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">E-mail</label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" id="email" name="email"  maxlength="100" placeholder="Correo Electronico del Cliente"> <span class="fa fa-google form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Telefono</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="telefono" name="telefono"  onkeypress="return solonumeros(event);" pattern=".{9,99}" onpaste="return false" maxlength="11" placeholder="Numero Telefonico del Cliente">
                      <span class="fa fa-tty form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Celular</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="celular" name="celular"  onkeypress="return solonumeros(event);" pattern=".{9,99}" onpaste="return false" maxlength="11" placeholder="Numero de Celular del Cliente">
                      <span class="fa fa-phone form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
              <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
              <button type="submit" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
              </form>
            </div>
        </div>
    </div>
</div>
  <?php endif ?>
<?php endif ?>

