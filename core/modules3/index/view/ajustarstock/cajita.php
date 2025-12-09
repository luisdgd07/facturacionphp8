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
              <h1></h1>
              
			  <?php
				  $cotizacion = CotizacionData::versucursalcotizacion($sucursales->id_sucursal);
                    $cajas = CajaData::vercajapersonal($u->id_usuario);
                    if(count($cotizacion)>0){ ?>
					<?php
                    foreach($cotizacion as $moneda){	
						$mon = MonedaData::cboObtenerValorPorSucursal2($sucursales->id_sucursal, $moneda->id_tipomoneda);
                    ?>
					  <?php foreach($mon as $mo):?>                  
				  <?php 
				  $nombre=$mo->nombre;
				  $fechacotiz=$mo->fecha_cotizacion;
				  ?>
				  
				   <?php endforeach;?>
                  <?php
                }
				 // INICIO CONDICION DE FECHA COTIZACION
				   $fecha_hoy=date('d-m-Y');
				   $fecha_cotizacion=strtotime($fechacotiz);
				    $fecha_cot=date('d-m-Y', ($fecha_cotizacion)); 
					
					
					
					
					if($fecha_cot >= $fecha_hoy) {
					
                    //Core::alert("Cotizacion del día actualizada...!");
					
					echo "<p class='alert alert-yelow'>Tiene la cotización  actualizada al dia:".$fecha_cot."</p>";
					//Core::redir("index.php?view=index&id_sucursal=".$sucursales->id_sucursal);
					  //echo $fecha_cot;
					}
					else if ($fecha_cot < $fecha_hoy ){
					
					Core::alert("Atención debe de actualizar la moneda a la cotización del día...en Configuraciones/Cotizacion/Nuevo!");
					Core::alert("Si su moneda principal es Dolares ingresar la equivalencia en guaranies  Seleccionar tipo moneda GS EJEMPLO: valor compra =6850; valor venta =6950");
					Core::alert("Y a la moneda Dolares ingresar la equivalencia 1 USD : Seleccionar tipo moneda USD EJEMPLO: valor compra =1; valor venta =1");
					
					Core::alert("Si su moneda principal es Guaranies ingresar la equivalencia en dólares  Seleccionar tipo moneda USD EJEMPLO:  valor compra=6850; valor venta =6950");
					Core::alert("Y a la moneda Guaranies ingresar la equivalencia 1 USD : Seleccionar tipo moneda Gs EJEMPLO: valor compra  =1; valor venta =1");
					
					Core::redir("index.php?view=cotizacion&id_sucursal=".$sucursales->id_sucursal);
					//echo "<p class='alert alert-danger'>Fecha de la última cotización:".$fecha_cot."</p>";
					
                    } ELSE  
					{
					Core::alert("Atención debe de actualizar la moneda a la cotización del día...en Configuraciones/Cotizacion/Nuevo!");
					 }
					?>
					
					
					
					
					
					
			  
			  <p><b>Ingrese el codigo o nombre del producto:</b></p>
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
			  
			  
			    <?php }else {
                    echo "<p class='alert alert-danger'>No hay Cotización registrada!</p>";
                  } ?>
				  
			  
			  
			  
			  
			  
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

                  <th>Precio unitario</th>
                  <th>En stock</th>
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
                    <td style="width:80px;"><?php echo $product->codigo; ?></td>
                    <td><?php echo $product->nombre; ?></td>
             
                    <td><b><?php echo number_format($product->precio_compra,4,',','.'); ?></b></td>
                    <td>
                      <?php echo   number_format($q,0,',','.'); ?>
                    </td>
                    <td>
                    <input type="hidden" name="producto_id" value="<?php echo $product->id_producto; ?>">
                    <input type="hidden" name="stock" value="<?= $q;?>">
                    <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
					<input type="hidden" name="precio" id="precio" value="<?php echo round(($product->precio_compra),4); ?>">
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
              <h2>Alerta</h2>
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
              <h2>Lista de productos</h2>
              <table class="table table-bordered table-hover">
              <thead>
                <th style="width:30px;">Codigo</th>
                <th style="width:30px;">Cantidad</th>
           
                <th>Producto</th>
                <th>Impuestjjjo</th>
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
				      <td><input type="text" name="id" value="<?php echo $product->id_producto;?>">
               <input type="hidden" name="precio1" value="<?php echo $p["precio"]; ?>">

          <input  style="width:60px;"readonly="" type="hidden"  name="codigo_" id="codigo_<?=$total_registros+1?>" value="<?php echo $product->codigo;?>"></td>



				 <td><span>
            <input style="width:90px;" 
             onblur="actualizarCantidad(<?=$total_registros+1?>, '<?php echo $product->nombre; ?>', <?php echo round(($p["precio"]),4); ?>, <?php echo $p['producto_id'];?>)"
             type="number" id="txtCantidadEditable_<?=$total_registros+1?>" 
              value="<?php echo round(($p["q"]),4); ?>"/>
              <input type="hidden" value="<?php echo $p["q"]; ?>" id="txtCantidadEditableHidden_<?=$total_registros+1?>"/>
              </span></td>
                <td><?php echo $product->nombre; ?></td>
                <td><?php if ($product->impuesto==10): ?>
                  <b style="color: blue;"><?php echo number_format($product->impuesto,0,'.','.'); ?> %</b>
                <?php else: ?>
                  <?php if ($product->impuesto==5): ?>
                  <b style="color: purple;"><?php echo number_format($product->impuesto,0,'.','.'); ?> %</b>
                <?php else: ?>
                  <?php if ($product->impuesto==0): ?>
                  <b style="color: red;"><?php echo number_format($product->impuesto,0,'.','.'); ?> %</b>
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
                                  $resultado_valor = round((($p["precio"]*$p["q"])/11),4);$totaliva10+=round((($p["precio"]* $p["q"])/11),4);
                                  break;
                                case 5:
                                  $resultado_valor = round((($p["precio"]*$p["q"])/21),4);$totaliva5+= round((($p["precio"]* $p["q"])/21),4);
                                  break;
                                default:
                                  $resultado_valor = round((($p["precio"]*$p["q"])),4);$totasliva0+=round(($p["precio"]* $p["q"]),4);
                              }
                              echo $resultado_valor; 
                            ?>
                          </b>
                          <input type="hidden" id="iva_hidden_<?=$total_registros+1?>" value="<?php
                              $resultado_valor = 0;
                              switch($product->impuesto){
                                case 10:
                                  $resultado_valor = round((($p["precio"]*$p["q"])/11),4);
                                  break;
                                case 5:
                                  $resultado_valor = round((($p["precio"]*$p["q"])/21),4);
                                  break;
                                default:
                                  $resultado_valor = round(((($p["precio"]*$p["q"]))*0),4);
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
                                  $resultado_valor = round((($p["precio"]* $p["q"])/1.1),4);$totalgrabada10+=round((($p["precio"]* $p["q"])/1.1),4);
                                  break;
                                case 5:
                                  $resultado_valor = round((($p["precio"]*$p["q"])/1.05),4);$totalgrabada5+=round((($p["precio"]*$p["q"])/1.05),4);
                                  break;
                                default:
                                  $resultado_valor = round(($p["precio"]* $p["q"]),4);$totalgrabada0+=round(($p["precio"]* $p["q"]),4);
                              }
                              echo $resultado_valor; 
                            ?>
                          </b>
                          <input type="hidden" id="gravada_hidden_<?=$total_registros+1?>" value="<?php
                              $resultado_valor = 0;
                              switch($product->impuesto){
                                case 10:
                                  $resultado_valor = round((($p["precio"]* $p["q"])/1.1),4);
                                  break;
                                case 5:
                                  $resultado_valor = round((($p["precio"]*$p["q"])/1.05),4);
                                  break;
                                default:
                                  $resultado_valor = round((($p["precio"]* $p["q"])*0),4);
                              }
                              echo $resultado_valor; 
                            ?>"/>
                          </td>

               
				
				
				   <td ><span>
                            <input style="width:110px;" 
                            onblur="actualizarCantidad2(<?=$total_registros+1?>, '<?php echo $p["q"] ?>', <?php echo round(($p["precio"]),4) ?>, <?php echo $p['producto_id'];?>)"
                             type="text" id="precio_unitario_<?=$total_registros+1?>" 
                          value="<?php echo round( $p["precio"],4); ?>"/>
                            <input type="hidden" value="<?php echo round(($p["precio"]),4); ?>" id="precio_unitario_hidden_<?=$total_registros+1?>"/>
                          </span></td>
				
				
				
				
				
				
                <td><b id="precio_total_<?=$total_registros+1?>"> <?php  echo $p["precio"]*$p["q"];$total+=round(($p["precio"]*$p["q"]),4);?></b></td>
                <input type="hidden" id="precio_total_hidden_<?=$total_registros+1?>" value="<?php  echo $p["precio"]*$p["q"];?>"/>
                <td style="width:30px;"><a href="index.php?action=borrarabastecerproducto1&id_sucursal=<?php echo $sucursales->id_sucursal;?>&producto_id=<?php echo $product->id_producto; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
              </tr>

              <?php 
              $total_registros++;
              endforeach; ?>
              </table>
              <form method="post" class="form-horizontal" id="processsell" action="index.php?action=procesoajustestock1">
              <h2></h2>
              <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Proveedor:</label>
                  <div class="col-lg-3">
                  <?php 
            
			   $q1=OperationData::getQYesFf($p["producto_id"]);
			
			   $clients = ProveedorData::verproveedorssucursal($sucursales->id_sucursal);
                  ?>
                  <select name="cliente_id" class="form-control" required>
                  <option value="">-- NINGUNO --</option>
                  <?php foreach($clients as $client):?>
                    <option value="<?php echo $client->id_cliente;?>"><?php echo $client->nombre." ".$client->apellido;?></option>
                  <?php endforeach;?>
                    </select>
                  </div>
                  <label for="inputEmail1" class="col-lg-1 control-label">Fecha:</label>
                  <div class="col-lg-2">
                    <input type="date" name="fecha" id="fecha" value="<?php echo date("Y-m-d"); ?>">
                  </div>
                  <div id=ocultar>
                   <!-- <label for="inputEmail1" class="col-lg-1 control-label">Tip Pago</label> -->
                  <div class="col-lg-4">
                    <input type="radio"  name="formapago2" checked onclick="Ocultar1();" value="Efectivo"> Efectivo 

                    <input type="radio"  name="formapago2"  onclick="Mostrar1();" value="Targeta Debito"> T. Debito

                    <input type="radio"  name="formapago2" onclick="Mostrar1();" value="Targeta Credito"> T. Credito

                    <input type="radio"  name="formapago2" onclick="Mostrar1();" value="Giro"> Giro
                  </div>
                 </div>
                </div>
                <div class="form-group">
                  <label for="comprobante2" class="col-lg-2 control-label">N° Comprobante:</label>
                  <div class="col-lg-2"> 
                    <input type="text" name="comprobante2" minlength="15"  class="form-control" placeholder="Numero de factura" id="comprobante2"required  onpaste="return true" maxlength="15">
                  </div>
                  <label for="timbrado2" class="col-lg-2 control-label">Timbrado:</label>
                  <div class="col-lg-2">
                    <input type="text" name="timbrado2" minlength="8"  class="form-control" id="timbrado2" placeholder="Timbrado"required  onpaste="return true" maxlength="8">
                  </div>
                  <div id=ocultar1>
                  </div> 
                  <div id=mostrar1>
                    <label for="inputEmail1" class="col-lg-2 control-label">Codigo:</label>
                    <div class="col-lg-2">
                      <input type="text" name="codigo2"  class="form-control" id="codigo2">
                    </div>
                 </div>
                 <div id=mostrar>
                   <label for="inputEmail1" class="col-lg-2 control-label">Fecha Pago:</label>
                  <div class="col-lg-2">
                    <input type="date" name="fecha2"  class="form-control" id="fecha2">
                  </div>
                 </div> 
                </div>
                 <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Tipo de Compra:</label>
                  <div class="col-lg-2">
                    <input type="radio" name="condicioncompra2" value="Contado" checked onclick="Ocultar();"> Contado 
                    <input type="radio"  name="condicioncompra2" value="Credito" onclick="Mostrar();"> Credito
                  </div>
                <label for="inputEmail1" class="col-lg-2 control-label">Moneda:</label>
                              <div class="col-lg-2">
                                <?php 
                                  $monedas = MonedaData::cboObtenerValorPorSucursal($sucursales->id_sucursal);
                                ?>
                                <select required="" name="tipomoneda_id" id="tipomoneda_id" id1="valor2" class="form-control" oninput="tipocambio()">
                                  <!-- <option value="0">Seleccionar</option> -->
                                <?php foreach($monedas as $moneda):?>
                                  <?php 
                                  $valocito=null;
                                  ?>
                                  <option value="<?php echo $moneda->simbolo;?>"><?php echo $moneda->nombre."-".$moneda->simbolo;?></option>

                                  <script type="text/javascript">
                                  function tipocambio()
                                    {
                                      ajaxConvertirValoresTotales($("#tipomoneda_id").val());

                                    }
                                </script>
                                <?php endforeach;?>
                                  </select>
                              </div>
                              <label for="inputEmail1" class="col-lg-2 control-label">Cambio</label>
                  <div class="col-lg-2">
                      <input readonly=""  type="text" class="form-control" name="cambio" id="cambio">
					  
					  			    <?php
				  $cotizacion = CotizacionData::versucursalcotizacion($sucursales->id_sucursal);
                    
                    if(count($cotizacion)>0){ ?>
					
					
					
				
              
				
                  <?php
				  
				  $valores=0;
                    foreach($cotizacion as $moneda){	
						$mon = MonedaData::cboObtenerValorPorSucursal3($sucursales->id_sucursal);
                    ?>
					  <?php foreach($mon as $mo):?>
					 
                  
				  <?php 
				  $nombre=$mo->nombre;
				  $fechacotiz=$mo->fecha_cotizacion;
				  $valores=$mo->valor2;
				  $simbolo2=$mo->simbolo;
				  
				  ?>
				  
				   <?php endforeach;?>
                
                 
                  <?php
				 
                } }
					
?>
					
							  <input type="hidden" name="cambio2" id="cambio2" value="<?php echo $valores; ?>"class="form-control">
							  <input type="hidden" name="simbolo2" id="simbolo2" value="<?php echo $simbolo2; ?>"class="form-control">
					  
					  
					  
                      <input type="hidden" name="idtipomoneda" id="idtipomoneda" class="form-control">
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
                <td><p><b> <input type="text" class="form-control" id="txtGravada5" name="grabada52" value="<?php echo ($totalgrabada5);  ?>" readonly=""></b></p></td>
                <td><p>IVA 5%</p></td>
                <td><p><b> <input type="text" class="form-control" id="txtIva5" name="iva52" value="<?php echo ($totaliva5);?>" readonly=""></b></p></td>
              </tr>
              <tr>
                <td><p>Exenta</p></td>
                <td><p><b> <input type="text" class="form-control" id="txtExenta" name="excenta2" value="<?php echo($totasliva0); ?>" readonly=""></b></p></td>
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
                        <input type="hidden" name="sucursal_id" id="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
						   <input type="hidden" value="<?php echo $q1; ?>" id="stock_trans" name="stock_trans" />
                       <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                  <a href="index.php?action=borrarabastecerproducto1&id_sucursal=<?php echo $sucursales->id_sucursal;?>" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                      <button class="btn btn-lg btn-warning"><i class="fa fa-refresh"></i> Finalizar Compra</button>
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
    </section>   
  </div>
  <?php endif ?>
<?php endif ?>

<link rel="stylesheet" href="plugins/css/toastr.min.css">
  <script src="plugins/toastr.min.js"></script>
  <script>

    const format = num => 
      String(num).replace(/(?<!\..*)(\d)(?=(?:\d{3})+(?:\.|$))/g, '$1,')
    ;
    const total_registros_tabla = <?=$total_registros?>;

    const total_compras = $("#txtTotalCompra").val();
    const total_iva10 = $("#txtIva10").val();
    const total_iva5 = $("#txtIva5").val();
    const total_gravada10 = $("#txtGravada10").val();
    const total_gravada5 = $("#txtGravada5").val();
    const total_exenta = $("#txtExenta").val();

    let valor_dolar_global = 0;
    let valor_guaranies_global = 0;

    let valor_cambio_global = 0;

    let resultado_valor_cambio = 0; //obtiene el resultado de la peticion ajax

    const moneda_principal_global = $("#tipomoneda_id").val();

    if(moneda_principal_global == "US$"){//dolar
      $.ajax({  
        url: 'index.php?action=consultamoneda',
        type: 'POST',
        data:{
          sucursal: <?=$_GET["id_sucursal"]?>,
          simbolo: moneda_principal_global,//simbolo
          accion: "obtenerCambioPorSimbolo"
        },
        dataType: 'json',
        success: function(json){
          $("#cambio").val(json[0].valor2);
          $("#idtipomoneda").val(json[0].id_tipomoneda);
          valor_dolar_global = json[0].valor2;
          valor_cambio_global = json[0].valor2;
        }, error: function(xhr, status){
          console.log("Ha ocurrido un error.");
        }
      });
    }else if(moneda_principal_global == "₲"){//guaranies
      $.ajax({  
        url: 'index.php?action=consultamoneda',
        type: 'POST',
        data:{
          sucursal: <?=$_GET["id_sucursal"]?>,
          simbolo: moneda_principal_global,//simbolo
          accion: "obtenerCambioPorSimbolo"
        },
        dataType: 'json',
        success: function(json){
          valor_guaranies_global = json[0].valor2;
          $("#idtipomoneda").val(json[0].id_tipomoneda);
          $("#cambio").val(json[0].valor);
          valor_cambio_global = json[0].valor2;
        }, error: function(xhr, status){
          console.log("Ha ocurrido un error.");
        }
      });
    }

    function ajaxOperacionTotales(simbolo$){
      $.ajax({  
        url: 'index.php?action=consultamoneda',
        type: 'POST',
        data:{
          sucursal: <?=$_GET["id_sucursal"]?>,
          simbolo: simbolo$,//simbolo
          accion: "obtenerCambioPorSimbolo"
        },
        dataType: 'json',
        success: function(json){
          const cambio = json[0].valor2;
          $("#cambio").val(json[0].valor2);
          $("#idtipomoneda").val(json[0].id_tipomoneda);
          if(moneda_principal_global == "US$"){//dolar
            if(simbolo$ == "₲"){
              for(let i=0;i<total_registros_tabla;i++){
               
				$("#precio_unitario_"+(i+1)).val(format(($("#precio_unitario_hidden_"+(i+1)).val()*cambio).toFixed(4)));
                $("#precio_total_"+(i+1)).html(format(($("#precio_total_hidden_"+(i+1)).val()*cambio).toFixed(4)));
                $("#iva_"+(i+1)).html(format(($("#iva_hidden_"+(i+1)).val()*cambio).toFixed(4)));
                $("#gravada_"+(i+1)).html(format(($("#gravada_hidden_"+(i+1)).val()*cambio).toFixed(4)));
              }
              $("#txtIva10").val(format((total_iva10*cambio).toFixed(4)));
              $("#txtIva5").val(format((total_iva5*cambio).toFixed(4)));
              $("#txtGravada10").val(format((total_gravada10*cambio).toFixed(4)));
              $("#txtGravada5").val(format((total_gravada5*cambio).toFixed(4)));
              $("#txtExenta").val(format((total_exenta*cambio).toFixed(4)));
              $("#txtTotalCompra").val(format((total_compras*cambio).toFixed(4)));
            }else{
              for(let i=0;i<total_registros_tabla;i++){
                $("#precio_unitario_"+(i+1)).val(format($("#precio_unitario_hidden_"+(i+1)).val()));
                $("#precio_total_"+(i+1)).html(format($("#precio_total_hidden_"+(i+1)).val()));
                $("#iva_"+(i+1)).html(format($("#iva_hidden_"+(i+1)).val()));
                $("#gravada_"+(i+1)).html(format($("#gravada_hidden_"+(i+1)).val()));
              }
              $("#txtIva10").val(format(total_iva10));
              $("#txtIva5").val(format(total_iva5));
              $("#txtGravada10").val(format(total_gravada10));
              $("#txtGravada5").val(format(total_gravada5));
              $("#txtExenta").val(format(total_exenta));
              $("#txtTotalCompra").val(format(total_compras));
            }
          }else if(moneda_principal_global == "₲"){//guaranies
            if(simbolo$ == "US$"){
              for(let i=0;i<total_registros_tabla;i++){
                $("#precio_unitario_"+(i+1)).val(format(($("#precio_unitario_hidden_"+(i+1)).val()/cambio).toFixed(4)));
                $("#precio_total_"+(i+1)).html(format(($("#precio_total_hidden_"+(i+1)).val()/cambio).toFixed(4)));
                $("#iva_"+(i+1)).html(format(($("#iva_hidden_"+(i+1)).val()/cambio).toFixed(4)));
                $("#gravada_"+(i+1)).html(format(($("#gravada_hidden_"+(i+1)).val()/cambio).toFixed(4)));
              }
              $("#txtIva10").val(format((total_iva10/cambio).toFixed(4)));
              $("#txtIva5").val(format((total_iva5/cambio).toFixed(4)));
              $("#txtGravada10").val(format((total_gravada10/cambio).toFixed(4)));
              $("#txtGravada5").val(format((total_gravada5/cambio).toFixed(4)));
              $("#txtExenta").val(format((total_exenta/cambio).toFixed(4)));
              $("#txtTotalCompra").val(format((total_compras/cambio).toFixed(4)));
            }else{
              for(let i=0;i<total_registros_tabla;i++){
                $("#precio_unitario_"+(i+1)).html(format($("#precio_unitario_hidden_"+(i+1)).val()));
                $("#precio_total_"+(i+1)).html(format($("#precio_total_hidden_"+(i+1)).val()));
                $("#iva_"+(i+1)).html(format($("#iva_hidden_"+(i+1)).val()));
                $("#gravada_"+(i+1)).html(format($("#gravada_hidden_"+(i+1)).val()));
              }
              $("#txtIva10").val(format(total_iva10));
              $("#txtIva5").val(format(total_iva5));
              $("#txtGravada10").val(format(total_gravada10));
              $("#txtGravada5").val(format(total_gravada5));
              $("#txtExenta").val(format(total_exenta));
              $("#txtTotalCompra").val(format(total_compras));
            }
          }
        }, error: function(xhr, status){
          console.log("Ha ocurrido un error.");
        }
      });
    }

    function ajaxConvertirValoresTotales(moneda_seleccionada){
      if(moneda_principal_global == "US$"){//dolar como moneda principal
        if(moneda_seleccionada == "₲"){
          ajaxOperacionTotales("₲");
        }else if(moneda_seleccionada == "US$"){
          ajaxOperacionTotales("US$");
        }
      }else if(moneda_principal_global == "₲"){//guaranies como moneda principal
        if(moneda_seleccionada == "US$"){
          ajaxOperacionTotales("US$");
        }else if(moneda_seleccionada == "₲"){
          ajaxOperacionTotales("₲");
        }
      }
    }

    //convetir en miles por defecto, cuando inicia la vista
    console.log("registros tabla: " + total_registros_tabla);
    for(let i=0;i<total_registros_tabla;i++){
      $("#precio_unitario_"+(i+1)).html(format($("#precio_unitario_hidden_"+(i+1)).val()));
      $("#precio_total_"+(i+1)).html(format($("#precio_total_hidden_"+(i+1)).val()));
      $("#iva_"+(i+1)).html(format($("#iva_hidden_"+(i+1)).val()));
      $("#gravada_"+(i+1)).html(format($("#gravada_hidden_"+(i+1)).val()));
    }

    $("#txtTotalCompra").val(format(total_compras));
    $("#txtIva10").val(format(total_iva10));
    $("#txtIva5").val(format(total_iva5));
    $("#txtGravada10").val(format(total_gravada10));
    $("#txtGravada5").val(format(total_gravada5));
    $("#txtExenta").val(format(total_exenta));






 function editarCantidadSessionAjax(productoId, cantidadNueva, precio){
      $.ajax({  
        url: 'index.php?action=agregarCantidadEditable3',
        type: 'POST',
        data:{
          producto_id: productoId,
          cantidad: cantidadNueva,
		  precio_compra: precio
        },
        success: function(json){
        }, error: function(xhr, status){
          toastr.error('No se ha podido actualizar la cantidad ingresada.', 'Error')
        }
      });
    }


 function actualizarCantidad(idIteracion, nombre, precio, idProducto){
      const cantidadAntigua = $("#txtCantidadEditableHidden_"+idIteracion).val();
      const cantidadNueva = $("#txtCantidadEditable_"+idIteracion).val();

      if(cantidadAntigua != cantidadNueva){
        editarCantidadSessionAjax(idProducto, cantidadNueva, precio);
        window.location.reload();
      }
    }







 function editarCantidadSessionAjax2(productoId, cantidadNueva, cant){
      $.ajax({  
        url: 'index.php?action=agregarCantidadEditable4',
        type: 'POST',
        data:{
          producto_id: productoId,
          precio_nuevo: cantidadNueva,
		  cantidad: cant
        },
        success: function(json){
        }, error: function(xhr, status){
          toastr.error('No se ha podido actualizar la cantidad ingresada.', 'Error')
        }
      });
    }


 function actualizarCantidad2(idIteracion, cant, precio, idProducto){
      const cantidadAntigua = $("#precio_unitario_hidden_"+idIteracion).val();
      const cantidadNueva = $("#precio_unitario_"+idIteracion).val();

      if(cantidadAntigua != cantidadNueva){
        editarCantidadSessionAjax2(idProducto, cantidadNueva, cant);
        window.location.reload();
      }
    }







</script>