  <?php 
    $u=null;
    if (isset($_SESSION["admin_id"])&& $_SESSION["admin_id"]!=""):
      $u=UserData::getById($_SESSION["admin_id"]);
    ?>
  <?php if($u->is_admin):?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa fa-sliders' style="color: orange;"></i>
        REALIZAR COMPRA
       <!-- <marquee> Lista de Medicamentos</marquee> -->
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <div class="box box-info"></div>
              <h1>Para realizar la Compra</h1>
              <p><b>Buscar producto por nombre o por codigo:</b></p>
              <form>
                <div class="row">
                  <div class="col-md-6">
                    <input type="hidden" name="view" value="ajustarstock">
                    <input type="text" name="producto" class="form-control">
                  </div>
                  <div class="col-md-3">
                  <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                  </div>
                </div>
              </form>
              <?php if(isset($_GET["producto"])):?>
                <?php
              $products = ProductoData::getLike($_GET["producto"]);
              if(count($products)>0){
                ?>
              <h3>Resultados de la Busqueda</h3>
              <table class="table table-bordered table-hover">
                <thead>
                  <th>Codigo</th>
                  <th>Nombre</th>
                  <th>Estado</th>
                  <th>Precio unitario</th>
                  <th>En inventario</th>
                  <th>Cantidad</th>
                  <th style="width:100px;"></th>
                </thead>
                <?php
              $products_in_cero=0;
                 foreach($products as $product):
              $q= OperationData::getQYesFf($product->id_producto);
                ?>
                  <form method="post" action="index.php?action=agregarstock">
                <tr class="<?php if($q<=$product->inventario_minimo){ echo "danger"; }?>">
                  <td style="width:80px;"><?php echo $product->id_producto; ?></td>
                  <td><?php echo $product->nombre; ?></td>
                  <td><?php echo $product->estado; ?></td>
                  <td><b><?php echo number_format($product->precio_compra,0,'.','.'); ?></b></td>
                  <td>
                    <?php echo $q; ?>
                  </td>
                  <td>
                  <input type="hidden" name="producto_id" value="<?php echo $product->id_producto; ?>">
                  <input type="" class="form-control" required name="q" placeholder="Cantidad de producto ..."></td>
                  <td style="width:100px;">
                  <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-refresh"></i> Agregar</button>
                  </td>
                </tr>
                </form>
                <?php endforeach;?>
              </table>

                <?php
              }
              ?>
              <br><hr>
              <hr><br>
              <?php else:
              ?>

              <?php endif; ?>

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


              <!--- Carrito de compras :) -->
              <?php if(isset($_SESSION["reabastecer"])):
              $total = 0;
              ?>
              <h2>Lista de Reabastecimiento</h2>
              <table class="table table-bordered table-hover">
              <thead>
                <th style="width:30px;">Codigo</th>
                <th style="width:30px;">Cantidad</th>
                <th style="width:30px;">Estado</th>
                <th>Producto</th>
                <th style="width:120px;">Precio Unitario</th>
                <th style="width:120px;">Precio Total</th>
                <th ></th>
              </thead>
              <?php foreach($_SESSION["reabastecer"] as $p):
              $product = ProductoData::getById($p["producto_id"]);
              ?>
              <tr >
                <td><?php echo $product->id_producto; ?></td>
                <td ><?php echo $p["q"]; ?></td>
                <td><?php echo $product->estado; ?></td>
                <td><?php echo $product->nombre; ?></td>
                <td><b><?php echo number_format($product->precio_compra,0,'.','.'); ?></b></td>
                <td><b> <?php  $pt = $product->precio_compra*$p["q"]; $total +=$pt; echo number_format($pt,0,'.','.'); ?></b></td>
                <td style="width:30px;"><a href="index.php?action=borrarabastecerproducto&producto_id=<?php echo $product->id_producto; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
              </tr>

              <?php endforeach; ?>
              </table>
              <form method="post" class="form-horizontal" id="processsell" action="index.php?action=procesoajustestock">
              <h2>Resumen</h2>
              <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Proveedor</label>
                  <div class="col-lg-10">
                  <?php 
              $clients = ProveedorData::IsPoveedor();
                  ?>
                  <select name="cliente_id" class="form-control">
                  <option value="">-- NINGUNO --</option>
                  <?php foreach($clients as $client):?>
                    <option value="<?php echo $client->id_cliente;?>"><?php echo $client->nombre." ".$client->apellido;?></option>
                  <?php endforeach;?>
                    </select>
                  </div>
                </div>
              <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Efectivo</label>
                  <div class="col-lg-10">
                    <input type="text" name="money" required class="form-control" id="money" placeholder="Efectivo">
                  </div>
                </div>
                <div class="row">
              <div class="col-md-6 col-md-offset-6">
              <table class="table table-bordered">
              <tr>
                <td><p>Subtotal</p></td>
                <td><p><b> <?php echo number_format($total*.84,0,'.','.'); ?></b></p></td>
              </tr>
              <tr>
                <td><p>IVA</p></td>
                <td><p><b><?php echo number_format($total*.16,0,'.','.'); ?></b></p></td>
              </tr>
              <tr>
                <td><p>Total</p></td>
                <td><p><b><?php echo number_format($total,0,'.','.'); ?></b></p></td>
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
                  <a href="index.php?action=borrarabastecerproducto" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                      <button class="btn btn-lg btn-warning"><i class="fa fa-refresh"></i> Procesar Compra</button>
                      </label>
                    </div>
                  </div>
                </div>
              </form>
              <script>
                $("#processsell").submit(function(e){
                  money = $("#money").val();
                  if(money<<?php echo $total;?>){
                    alert("No se puede efectuar la operacion");
                    e.preventDefault();
                  }else{
                    go = confirm("Cambio: "+(money-<?php echo $total;?>));
                    if(go){}
                      else{e.preventDefault();}
                  }
                });
              </script>
              <?php endif; ?>
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
    $totaliva10=0;
    $totaliva5=0;
    $totasliva0=0;
    $totalgrabada10=0;
    $totalgrabada5=0;
    $totalgrabada0=0;
  ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa fa-sliders' style="color: orange;"></i>
        REALIZAR COMPRA
       <!-- <marquee> Lista de Medicamentos</marquee> -->
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <div class="box box-info"></div>
              <h1>Para realizar la Compra</h1>
              <p><b>Buscar producto por nombre o por codigo:</b></p>
              <form>
                <div class="row">
                  <div class="col-md-6">
                    <input type="hidden" name="view" value="ajustarstock">
                    <input type="text" name="producto" class="form-control">
                  </div>
                  <div class="col-md-3">
                    <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                  <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                  </div>
                </div>
              </form>
              <?php if(isset($_GET["producto"])):?>
                <?php
              $products = ProductoData::getLike($_GET["producto"]);
              if(count($products)>0){
                ?>
              <h3>Resultados de la Busqueda</h3>
              <table class="table table-bordered table-hover">
                <thead>
                  <th>Codigo</th>
                  <th>Nombre</th>
                  <th>Estado</th>
                  <th>Precio unitario</th>
                  <th>En inventario</th>
                  <th>Cantidad</th>
                  <th style="width:100px;"></th>
                </thead>
                <?php
              $products_in_cero=0;
                 foreach($products as $product):
              $q= OperationData::getQYesFf($product->id_producto);
                ?>
                  <form method="post" action="index.php?action=agregarstock1">
                <tr class="<?php if($q<=$product->inventario_minimo){ echo "danger"; }?>">
                  <?php if ($product->sucursal_id==$sucursales->id_sucursal): ?>
                    <td style="width:80px;"><?php echo $product->id_producto; ?></td>
                    <td><?php echo $product->nombre; ?></td>
                    <td><?php echo $product->estado; ?></td>
                    <td><b><?php echo number_format($product->precio_compra,0,'.','.'); ?></b></td>
                    <td>
                      <?php echo $q; ?>
                    </td>
                    <td>
                    <input type="hidden" name="producto_id" value="<?php echo $product->id_producto; ?>">
                    <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                    <input type="" class="form-control" required name="q" placeholder="Cantidad de producto ..."></td>
                    <td style="width:100px;">
                    <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-refresh"></i> Agregar</button>
                    </td>
                    <?php else: ?>
                  <?php endif ?>
                </tr>
                </form>
                <?php endforeach;?>
              </table>

                <?php
              }
              ?>
              <br><hr>
              <hr><br>
              <?php else:
              ?>

              <?php endif; ?>

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


              <!--- Carrito de compras :) -->
              <?php if(isset($_SESSION["reabastecer"])):
              $total = 0;
              ?>
              <h2>Lista de Reabastecimiento</h2>
              <table class="table table-bordered table-hover">
              <thead>
                <th style="width:30px;">Codigo</th>
                <th style="width:30px;">Cantidad</th>
                <th style="width:30px;">Estado</th>
                <th>Producto</th>
                <th>Impuesto</th>
                <th>Iva</th>
                <th>Gravada</th>
                <th style="width:120px;">Precio Unitario</th>
                <th style="width:120px;">Precio Total</th>
                <th ></th>
              </thead>
              <?php 
                            $total_registros = 0;
              foreach($_SESSION["reabastecer"] as $p):
              $product = ProductoData::getById($p["producto_id"]);
              ?>
              <tr >
                <td><?php echo $product->id_producto; ?></td>
                <td ><?php echo $p["q"]; ?></td>
                <td><?php echo $product->estado; ?></td>
                <td><?php echo $product->nombre; ?></td>
                <td><?php if ($product->impuesto==10): ?>
                  <b style="color: blue;"><?php echo $product->impuesto; ?> %</b>
                <?php else: ?>
                  <?php if ($product->impuesto==5): ?>
                  <b style="color: purple;"><?php echo $product->impuesto; ?> %</b>
                <?php else: ?>
                  <?php if ($product->impuesto==0): ?>
                  <b style="color: red;"><?php echo $product->impuesto; ?> %</b>
                <?php endif ?>
                <?php endif ?>
                <?php endif ?></td>
                <!-- $totaliva10=0;
                      $totaliva5=0;
                      $totasliva0=0;
                      $totalgrabada10=0;
                      $totalgrabada5=0; -->

                      <td>
                            <b id="iva_<?=$total_registros+1?>" style="
                            <?php 
                              $resultado = "";
                              switch($product->impuesto){
                                case 10:
                                  $resultado = "color: blue;";
                                  break;
                                case 5: 
                                  $resultado = "color: green;";
                                default:
                                $resultado = "color: red;";
                              }
                              echo $resultado;
                            ?>">
                            <?php
                              $resultado_valor = 0;
                              switch($product->impuesto){
                                case 10:
                                  $resultado_valor = round(($product->precio_compra* $p["q"])/11);$totaliva10+=round(($product->precio_compra* $p["q"])/11);
                                  break;
                                case 5:
                                  $resultado_valor = round(($product->precio_compra* $p["q"])/21);$totaliva5+= round(($product->precio_compra* $p["q"])/21);
                                  break;
                                default:
                                  $resultado_valor = round(($product->precio_compra* $p["q"]));$totasliva0+=round($product->precio_compra* $p["q"]);
                              }
                              echo $resultado_valor; 
                            ?>
                          </b>
                          <input type="hidden" id="iva_hidden_<?=$total_registros+1?>" value="<?php
                              $resultado_valor = 0;
                              switch($product->impuesto){
                                case 10:
                                  $resultado_valor = round(($product->precio_compra* $p["q"])/11);
                                  break;
                                case 5:
                                  $resultado_valor = round(($product->precio_compra* $p["q"])/21);
                                  break;
                                default:
                                  $resultado_valor = round(($product->precio_compra* $p["q"]));
                              }
                              echo $resultado_valor; 
                            ?>"/>
                      </td>

                          <td>
                            <b id="gravada_<?=$total_registros+1?>" style="
                            <?php 
                              $resultado = "";
                              switch($product->impuesto){
                                case 10:
                                  $resultado = "color: blue;";
                                  break;
                                case 5: 
                                  $resultado = "color: green;";
                                default:
                                  $resultado = "color: red;";
                              }
                              echo $resultado;
                            ?>">
                            <?php
                              $resultado_valor = 0;
                              switch($product->impuesto){
                                case 10:
                                  $resultado_valor = round(($product->precio_compra* $p["q"])/1.1);$totalgrabada10+=round(($product->precio_compra* $p["q"])/1.1);
                                  break;
                                case 5:
                                  $resultado_valor = round((($product->precio_compra*$p["q"])-$totaliva5)/1.05);$totalgrabada5+=round(($product->precio_compra*$p["q"])-$totaliva5)/1.05;
                                  break;
                                default:
                                  $resultado_valor = round($product->precio_compra* $p["q"]);$totalgrabada0+=round($product->precio_compra* $p["q"]);
                              }
                              echo $resultado_valor; 
                            ?>
                          </b>
                          <input type="hidden" id="gravada_hidden_<?=$total_registros+1?>" value="<?php
                              $resultado_valor = 0;
                              switch($product->impuesto){
                                case 10:
                                  $resultado_valor = round(($product->precio_compra* $p["q"])/1.1);
                                  break;
                                case 5:
                                  $resultado_valor = round((($product->precio_compra*$p["q"])-$totaliva5)/1.05);
                                  break;
                                default:
                                  $resultado_valor = round($product->precio_compra* $p["q"]);
                              }
                              echo $resultado_valor; 
                            ?>"/>
                          </td>

                <td><b id="precio_unitario_<?=$total_registros+1?>"> <?php echo $product->precio_compra?></b></td>
                <input type="hidden" id="precio_unitario_hidden_<?=$total_registros+1?>" value="<?php echo $product->precio_compra?>"/>
                <td><b id="precio_total_<?=$total_registros+1?>"> <?php  echo $product->precio_compra*$p["q"];$total+=$product->precio_compra*$p["q"];?></b></td>
                <input type="hidden" id="precio_total_hidden_<?=$total_registros+1?>" value="<?php  echo $product->precio_compra*$p["q"];?>"/>
                <td style="width:30px;"><a href="index.php?action=borrarabastecerproducto1&id_sucursal=<?php echo $sucursales->id_sucursal;?>&producto_id=<?php echo $product->id_producto; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
              </tr>

              <?php 
              $total_registros++;
              endforeach; ?>
              </table>
              <form method="post" class="form-horizontal" id="processsell" action="index.php?action=procesoajustestock1">
              <h2>Resumen</h2>
              <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Proveedor</label>
                  <div class="col-lg-6">
                  <?php 
              $clients = ProveedorData::IsPoveedor();
                  ?>
                  <select name="cliente_id" class="form-control" required>
                  <option value="">-- NINGUNO --</option>
                  <?php foreach($clients as $client):?>
                    <option value="<?php echo $client->id_cliente;?>"><?php echo $client->nombre." ".$client->apellido;?></option>
                  <?php endforeach;?>
                    </select>
                  </div>
                  <div id=ocultar>
                   <!-- <label for="inputEmail1" class="col-lg-1 control-label">Tip Pago</label> -->
                  <div class="col-lg-4">
                    <input type="radio"  name="formapago2" onclick="Ocultar1();" value="Efectivo"> Efectivo 

                    <input type="radio"  name="formapago2"  onclick="Mostrar1();" value="Targeta Debito"> T. Debito

                    <input type="radio"  name="formapago2" onclick="Mostrar1();" value="Targeta Credito"> T. Credito

                    <input type="radio"  name="formapago2" onclick="Mostrar1();" value="Giro"> Giro
                  </div>
                 </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">N° Comprobante</label>
                  <div class="col-lg-2"> 
                    <input type="text" name="comprobante2"  class="form-control" placeholder="Numero" id="comprobante2">
                  </div>
                  <label for="inputEmail1" class="col-lg-2 control-label">TIMBRADO</label>
                  <div class="col-lg-2">
                    <input type="text" name="timbrado2"  class="form-control" id="timbrado2">
                  </div>
                  <div id=ocultar1>
                  </div> 
                  <div id=mostrar1>
                    <label for="inputEmail1" class="col-lg-2 control-label">Codigo</label>
                    <div class="col-lg-2">
                      <input type="text" name="codigo2"  class="form-control" id="codigo2">
                    </div>
                 </div>
                 <div id=mostrar>
                   <label for="inputEmail1" class="col-lg-2 control-label">FECHA</label>
                  <div class="col-lg-2">
                    <input type="date" name="fecha2"  class="form-control" id="fecha2">
                  </div>
                 </div> 
                </div>
                 <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Condición Compra</label>
                  <div class="col-lg-2">
                    <input type="radio" name="condicioncompra2" value="Contado" onclick="Ocultar();"> Contado 
                    <input type="radio"  name="condicioncompra2" value="Credito" onclick="Mostrar();"> Credito
                  </div>
                <label for="inputEmail1" class="col-lg-2 control-label">Moneda</label>
                              <div class="col-lg-2">
                              <?php 
                                 $monedas = MonedaData::versucursalmoneda($sucursales->id_sucursal);
                              ?>
                              <select required="" name="tipomoneda_id" id="tipomoneda_id" id1="valor" class="form-control" oninput="tipocambio()">
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
                                        document.getElementById('cambio').value=json[0].valor;
                                          const cambio = json[0].valor;
                                          for(let i=0;i<total_registros_tabla;i++){
                                              $("#precio_unitario_"+(i+1)).html(format(cambio*$("#precio_unitario_hidden_"+(i+1)).val()));
                                              $("#precio_total_"+(i+1)).html(format(cambio*$("#precio_total_hidden_"+(i+1)).val()));
                                              $("#gravada_"+(i+1)).html(format(cambio*$("#gravada_hidden_"+(i+1)).val()));
                                              $("#iva_"+(i+1)).html(format(cambio*$("#iva_hidden_"+(i+1)).val()));
                                          }
                                            //convertir campos inferiores por el tipo de cambio
                                            $("#txtGravada10").val(format(txtGravada10*cambio));
                                            $("#txtIva10").val(format(txtIva10*cambio));
                                            $("#txtGravada5").val(format(txtGravada5*cambio));
                                            $("#txtIva5").val(format(txtIva5*cambio));
                                            $("#txtExenta").val(format(txtExenta*cambio));
                                            $("#txtTotalCompra").val(format(cambio*txtTotalCompra));
                                      }, error: function(xhr, status){
                                        console.log("Ha ocurrido un error.");
                                      }
                                    });

                                  }
                              </script>
                              <?php endforeach;?>
                                </select>
                              </div>
                              <label for="inputEmail1" class="col-lg-2 control-label">Cambio</label>
                  <div class="col-lg-2">
                      <input type="text" class="form-control" name="cambio2" id="cambio">
                      <!-- <select></select> -->
                  </div>
                </div>
               <hr> 
              <!-- <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Efectivo</label>
                  <div class="col-lg-10">
                    <input type="text" name="money" required class="form-control" id="money">
                  </div>
                </div> -->
                <div class="row">
              <div class="col-md-6 col-md-offset-6">
              <table class="table table-bordered">
              <tr>
                <td><p>Gravada 10%</p></td>
                <td><p><b> <input type="text" class="form-control" id="txtGravada10" name="grabada102" value="<?php echo ($totalgrabada10); ?>" readonly=""></b></p></td>
                <td><p>IVA 10%</p></td>
                <td><p><b> <input type="text" class="form-control" id="txtIva10" name="iva102" value="<?php echo ($totaliva10); ?>" readonly=""></b></p></td>
              </tr>
              <tr>
                <td><p>Gravada 5%</p></td>
                <td><p><b> <input type="text" class="form-control" id="txtGravada5" name="grabada52" value="<?php echo ($totalgrabada5); ?>" readonly=""></b></p></td>
                <td><p>IVA 5%</p></td>
                <td><p><b> <input type="text" class="form-control" id="txtIva5" name="iva52" value="<?php echo ($totaliva5); ?>" readonly=""></b></p></td>
              </tr>
              <tr>
                <td><p>Exenta</p></td>
                <td><p><b> <input type="text" class="form-control" id="txtExenta" name="excenta2" value="<?php echo ($totasliva0); ?>" readonly=""></b></p></td>
              </tr>
              <tr>
                <td><p>Total</p></td>
                <td><p><b> <input type="text" class="form-control" id="txtTotalCompra" name="money" value="<?php echo ($total); ?>" readonly=""></b></p></td>
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
                       <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                  <a href="index.php?action=borrarabastecerproducto1&id_sucursal=<?php echo $sucursales->id_sucursal;?>" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                      <button class="btn btn-lg btn-warning"><i class="fa fa-refresh"></i> Procesar Compra</button>
                      </label>
                    </div>
                  </div>
                </div>
              </form>
              <script>
                $("#processsell").submit(function(e){
                  money = $("#money").val();
                  if(money<<?php echo $total;?>){
                    alert("No se puede efectuar la operacion");
                    e.preventDefault();
                  }else{
                    go = confirm("Cambio: "+(money-<?php echo $total;?>));
                    if(go){}
                      else{e.preventDefault();}
                  }
                });
              </script>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
  <?php endif ?>
<?php endif ?>


<script type="text/javascript">

const total_registros_tabla = <?=$total_registros?>;
//valores de cuadro de totales
const txtGravada10 = $("#txtGravada10").val();
const txtIva10 = $("#txtIva10").val();
const txtGravada5 = $("#txtGravada5").val();
const txtIva5 = $("#txtIva5").val();
const txtExenta = $("#txtExenta").val();
const txtTotalCompra = $("#txtTotalCompra").val();


const format = num => 
      String(num).replace(/(?<!\..*)(\d)(?=(?:\d{3})+(?:\.|$))/g, '$1,')
    
  ;

  $.ajax({  
      url: 'index.php?action=consultamoneda',
      type: 'POST',
      data:{
      tipoMoneda: Number(document.getElementById("tipomoneda_id").value)
      },
      dataType: 'json',
      success: function(json){
        document.getElementById('cambio').value=json[0].valor;
        const cambio = json[0].valor;

        $("#cambio").val(json[0].valor);

        for(let i=0;i<total_registros_tabla;i++){
          $("#precio_unitario_"+(i+1)).html(format(cambio*$("#precio_unitario_hidden_"+(i+1)).val()));
          $("#precio_total_"+(i+1)).html(format(cambio*$("#precio_total_hidden_"+(i+1)).val()));
          $("#gravada_"+(i+1)).html(format(cambio*$("#gravada_hidden_"+(i+1)).val()));
          $("#iva_"+(i+1)).html(format(cambio*$("#iva_hidden_"+(i+1)).val()));
        }
        //convertir campos inferiores por el tipo de cambio
        $("#txtGravada10").val(format(txtGravada10*cambio));
        $("#txtIva10").val(format(txtIva10*cambio));
        $("#txtGravada5").val(format(txtGravada5*cambio));
        $("#txtIva5").val(format(txtIva5*cambio));
        $("#txtExenta").val(format(txtExenta*cambio));
        $("#txtTotalCompra").val(format(cambio*txtTotalCompra));

        
      }, error: function(xhr, status){
        console.log("Ha ocurrido un error.");
      }
    });











</script>