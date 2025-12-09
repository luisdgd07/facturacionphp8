  <?php 
    $u=null;
    if (isset($_SESSION["admin_id"])&& $_SESSION["admin_id"]!=""):
      $u=UserData::getById($_SESSION["admin_id"]);
    ?>
    <?php if($u->is_empleado):?>
    <?php
        $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
      ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1><i class='fa fa-gift' style="color: orange;"></i>
            REALIZAR VENTA:
          </h1>
        </section>
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
                  <?php
                    $cajas = CajaData::vercajapersonal($u->id_usuario);
                    if(count($cajas)>0){ ?>
                    <?php foreach ($cajas as $caja): ?>
                      <div class="box box-warning">
                        <div class="box-header">
                          <i class="fa fa-laptop" style="color: orange;"></i> INGRESAR EL CODIGO O NOMBRE DEL <B>PRODUCTO</B>.
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
                     <?php endforeach ?>
                     <?php }else {
                    echo "<p class='alert alert-danger'>Es IMPORTATE  Aperturar la Caja, para poder realizar las Ventas.....!</p>";
                  } ?>
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
                   <hr>
                   <form method="post" class="form-horizontal" id="processsell" action="index.php?action=procesoventaproducto1">
                    <div class="form-group">
                      <label for="inputEmail1" class="col-lg-1 control-label">Presupuesto:</label>
                        <div class="col-lg-2">
                          <input type="text" name="presupuesto"  class="form-control"  value="0" id="presupuesto">
                          <input type="hidden" name="factura" id="num1">
                          <input type="hidden" name="numeracion_inicial" id="numinicio">
                          <input type="hidden" name="numeracion_final" id="numfin">
                          <input type="hidden" name="serie1" id="serie">
                        </div>
                        <label for="inputEmail1" class="col-lg-1 control-label">Tipo Doc.:</label>
                          <div class="col-lg-2">
                              <?php 
                          $clients = ConfigFacturaData::verfacturasucursal($sucursales->id_sucursal);
                              ?>
                              <select required="" name="configfactura_id" id="configfactura_id" class="form-control" oninput="configFactura()">
							   <option value="">Seleccionar</option>
                              
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
                          <label for="inputEmail1" class="col-lg-1 control-label">Moneda:</label>
                          <div class="col-lg-2">
                              <?php 
                                 $monedas = MonedaData::cboObtenerValorPorSucursal($sucursales->id_sucursal);
                              ?>
                              <select required="" name="tipomoneda_id" id="tipomoneda_id" id1="valor" class="form-control" oninput="tipocambio()">
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
                          <label for="inputEmail1" class="col-lg-1 control-label">Cambio:</label>
                            <div class="col-lg-2">
                              <input  readonly=""  type="text" name="cambio" id="cambio"   class="form-control">
                              <input type="hidden" name="idtipomoneda" id="idtipomoneda" class="form-control">
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">Cliente:</label>
                             <div class="col-lg-9">
                              <?php 
                         
						   $clients = ClienteData::verclientessucursal($sucursales->id_sucursal);
						  
						  
                              ?>
                            <select  name="cliente_id" class="form-control">:
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
                              <label for="inputEmail1" class="col-lg-3 control-label">Forma de Pago:</label>
                              <div class="col-lg-9">
                                 <input name="formapago" autofocus="autofocus"  value="Efectivo" checked type="radio" name=""onclick="Ocultar1();"> Efectivo
                                  <input name="formapago" value="Targeta de Debito"  type="radio" name=""onclick="Mostrar1();"> Targeta de Debito
                                  <input name="formapago" value="Targeta de Credito"  type="radio" name=""onclick="Mostrar1();"> Targeta de Credito
                                  <input name="formapago" value="Giro"  type="radio" name=""onclick="Ocultar1();"> Giro
                              </div>
                            </div> 
                          </div>
                          <div id="mostrar">
                           <div class="form-group">
                              <label for="inputEmail1" class="col-lg-3 control-label">Fecha Cobro:</label>
                              <div class="col-lg-9">
                                <input type="date" name="fechapago"  class="form-control" id="fechapago" placeholder="Efectivo">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label
                               for="inputEmail1" class="col-lg-2 control-label">Tipo de venta:</label>
                              <div class="col-lg-4">
							    <input name="metodopago" value="Contado" checked type="radio" name=""onclick="Ocultar();"> Contado
                                <input name="metodopago" value="Credito" type="radio" name=""onclick="Mostrar();"> Credito
                              
                              <?php $configmasiva = ConfiguracionMasivaData::vercamasivaactivosucursal($sucursales->id_sucursal);?>
                              <?php if(count($configmasiva)>0):?>
                              <?php foreach($configmasiva as $masivas):?>
                                <input type="hidden" name="cantidaconfigmasiva" id="cantidaconfigmasiva" value="<?php echo $masivas->cantidad; ?>">
                              <?php endforeach; ?>
                              <?php endif ?>
                            </div>
                             <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 control-label">Fecha Venta:</label>
                                <div class="col-lg-4">
                                  <input type="date" name="fecha"  class="form-control" value="<?php echo date("Y-m-d"); ?>" id="fecha" placeholder="Efectivo">
                                </div>
                              </div>  
                          <div class="form-group">
                            <div id="ocultar1"></div>
                                <div id="mostrar1">
                                  <label for="inputEmail1" class="col-lg-3 control-label">Codigo:</label>
                                  <div class="col-lg-4">
                                    <input type="number"  name="codigo" class="form-control"  value="0" id="codigo" placeholder="Descuento">
                                  </div>
                                </div>
                             </div>                
                          </div>
                        </div>
                      </div>
                      <hr>
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
                        <h2>Detalle de la venta:</h2>
                        <table class="table table-bordered table-hover">
                        <thead>
                          <th style="width:30px;">Código</th>
                          <th style="width:30px;">Cantidad</th>
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
                        foreach($_SESSION["cart"] as $p):
                        
                        $product = ProductoData::getById($p["producto_id"]);
                        ?>
                        <tr >
                          <td><?php echo $product->codigo; ?></td>
                          <td ><span id="cantidad_<?=$total_registros+1?>"><?php echo $p["q"]; ?></span></td>
                          <td><?php echo $product->nombre; ?></td>
                          <td><?php echo $product->impuesto; ?> %</td>
                          
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
                                  $resultado_valor = round((($product->precio_venta*$p["q"])/11),2);$iva10+=round((($product->precio_venta*$p["q"])/11),2);
                                  break;
                                case 5:
                                  $resultado_valor = round((($product->precio_venta*$p["q"])/21),2);$iva5+=round((($product->precio_venta*$p["q"])/21),2);
                                  break;
                                default:
                                  $resultado_valor = round((($product->precio_venta*$p["q"])),2);$iva0+=round((($product->precio_venta*$p["q"])),2);
                              }
                              echo $resultado_valor; 
                            ?>
                            </b>
                            <input type="hidden" id="iva_hidden_<?=$total_registros+1?>" value="                            <?php
                              $resultado_valor = 0;
                              switch($product->impuesto){
                                case 10:
                                  $resultado_valor = round((($product->precio_venta*$p["q"])/11),2);
                                  break;
                                case 5:
                                  $resultado_valor = round((($product->precio_venta*$p["q"])/21),2);
                                  break;
                                default:
                                  $resultado_valor = round((($product->precio_venta*$p["q"])),2)*0;
                              }
                              echo $resultado_valor; 
                            ?>">
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
                                  $resultado_valor = round((($product->precio_venta*$p["q"])/1.1),2);$grabada10+=round((($product->precio_venta*$p["q"])/1.1),2);
                                  break;
                                case 5:
                                  $resultado_valor = round((($product->precio_venta*$p["q"])/1.05),2);$grabada5+=round((($product->precio_venta*$p["q"])/1.05),2);
                                  break;
                                default:
                                  $resultado_valor = round((($product->precio_venta*$p["q"])),2);$grabada0+=round((($product->precio_venta*$p["q"])),2);
                              }
                              echo $resultado_valor; 
                            ?>
                          </b>
                          <input type="hidden" id="gravada_hidden_<?=$total_registros+1?>" value="                            <?php
                              $resultado_valor = 0;
                              switch($product->impuesto){
                                case 10:
                                  $resultado_valor = round((($product->precio_venta*$p["q"])/1.1),2);
                                  break;
                                case 5:
                                  $resultado_valor = round((($product->precio_venta*$p["q"])/1.05),2);
                                  break;
                                default:
                                  $resultado_valor = round((($product->precio_venta*$p["q"])),2)*0;
                              }
                              echo $resultado_valor; 
                            ?>">
                          </td>
  <!--*********** -->     <td>
                            <input readonly="" type="text"  name="" id="precio_venta_<?=$total_registros+1?>" value="<?php echo $product->precio_venta ?>">
                            <input readonly=""  type="hidden" name="" id="precio_venta_hidden_<?=$total_registros+1?>" value="<?php echo $product->precio_venta ?>">
                          </td>
                          <td>
                            <input  type="text" name="precio_total_"  id="precio_total_<?=$total_registros+1?>" value="<?php  $pt = $product->precio_venta*$p["q"]; $total1 +=$pt; echo $product->precio_venta*$p["q"]; ?>">
                            <input  readonly="" type="hidden" name="" id="precio_total_hidden_<?=$total_registros+1?>" value="<?php  $pt = $product->precio_venta*$p["q"]; echo $product->precio_venta*$p["q"]; ?>">
                          </td>
                          <td style="width:30px;"><a href="index.php?action=eliminarcompraproductos1&id_sucursal=<?php echo $sucursales->id_sucursal;?>&producto_id=<?php echo $product->id_producto; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
                        </tr>

                        <?php 
                        $total_registros++;
                        endforeach; ?>
                        </table>
                     
                      <hr>
                      <div class="row">
                        <div class="col-md-6 col-md-offset-6">
                          <table class="table table-bordered">
                            <tr>
                              <td><p>Gravada 10%</p></td>
                              <td><p><b> <input type="text" readonly="" name="total10"  id="total10" placeholder="Efectivo" value="<?php echo $grabada10; ?>"> 
                              </b></p></td>
                              <td>IVA. 10%</td>
                              <td><p><b> <input type="text" readonly="readonly" name="iva10" id="iva10" value="<?php echo $iva10; ?>">  
                            </tr>
                            <tr>
                              <td><p>Gravada 5%</p></td>
                              <td><p><b><input type="text" readonly="" name="total5" id="total5" value="<?php echo $grabada5; ?>"> </b></p></td>
                              <td>IVA. 5%</td>
                              <td><p><b><input type="text" readonly="" name="iva5" id="iva5" value="<?php echo $iva5; ?>">  
                            </tr>
                            <tr>
                              <td><p>Exenta</p></td>
                              <td><p><b><input type="text" readonly="" name="exenta" id="exenta" value="<?php echo $grabada0; ?>"> </b></p></td>
                            </tr>
                            <tr>
                              <td><p>Total</p></td>
                              <td><p><b><input type="text" readonly="" name="total" id="txtTotalVentas" value="<?php echo $total1; ?>"> </b></p></td>
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
                        </div>
                      </div>
                      <hr>
                      <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                          <div class="checkbox">
                          <label>
                          <input type="hidden" name="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
                          <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                           <a href="index.php?action=eliminarcompraproductos1&id_sucursal=<?php echo $sucursales->id_sucursal;?>" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                            <button class="btn btn-lg btn-warning"><b></b> Finalizar Venta</button></label>
                        </div>
                      </div>
                    </div>
                     <?php endif ?>
                   </form>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    <?php endif ?>
  <?php endif ?>

  <script>

    const format = num => 
      String(num).replace(/(?<!\..*)(\d)(?=(?:\d{3})+(?:\.|$))/g, '$1,')
    ;

    const total_registros_tabla = <?=$total_registros?>;

    const total_ventas = $("#txtTotalVentas").val();
    const total_iva10 = $("#iva10").val();
    const total_iva5 = $("#iva5").val();
    const total_gravada10 = $("#total10").val();
    const total_gravada5 = $("#total5").val();
    const total_exenta = $("#exenta").val();

    let valor_dolar_global = 0;
    let valor_guaranies_global = 0;

    let valor_cambio_global = 0;
    let valor_configmasiva_global = $("#cantidaconfigmasiva").val();

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
          $("#cambio").val(json[0].valor);
          $("#idtipomoneda").val(json[0].id_tipomoneda);
          valor_dolar_global = json[0].valor;
          ajaxConfigMasiva("₲");
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
          valor_guaranies_global = json[0].valor;
          $("#idtipomoneda").val(json[0].id_tipomoneda);
          $("#cambio").val(json[0].valor);
          ajaxConfigMasiva("US$");
        }, error: function(xhr, status){
          console.log("Ha ocurrido un error.");
        }
      });
    }


    function ajaxConfigMasiva(simbolo$){
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
          const cambio_valor = json[0].valor;
          if(moneda_principal_global == "US$"){
            $("#cantidaconfigmasiva").val(valor_configmasiva_global/cambio_valor);
          }else if(moneda_principal_global == "₲"){
            $("#cantidaconfigmasiva").val(valor_configmasiva_global);
          }
        }, error: function(xhr, status){
          console.log("Ha ocurrido un error.");
        }
      });
    }

    function setearTipoCambioChange(simbolo$){
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
          const cambio_valor = json[0].valor;
            $("#cambio").val(cambio_valor);
          const valor_inical = json[0].id_tipomoneda;
            $("#idtipomoneda").val(valor_inical);
        }, error: function(xhr, status){
          console.log("Ha ocurrido un error.");
        }
      });
    }

    function ajaxConfigMasivaChange(simbolo$, moneda_seleccionada){
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
          const cambio_valor = json[0].valor;
          if(moneda_principal_global == "US$"){//dolar como moneda principal
            if(moneda_seleccionada == "₲"){
              setearTipoCambioChange("₲");
              $("#cantidaconfigmasiva").val(valor_configmasiva_global);
            }else if(moneda_seleccionada == "US$"){
              setearTipoCambioChange("US$");
              $("#cantidaconfigmasiva").val(valor_configmasiva_global/cambio_valor);
            }
          }else if(moneda_principal_global == "₲"){//guaranies como moneda principal
            if(moneda_seleccionada == "US$"){
              setearTipoCambioChange("US$");
              $("#cantidaconfigmasiva").val(valor_configmasiva_global/cambio_valor);
            }else if(moneda_seleccionada == "₲"){
              setearTipoCambioChange("₲");
              $("#cantidaconfigmasiva").val(valor_configmasiva_global);
            }
          }
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
          const cambio = json[0].valor;
          if(moneda_principal_global == "US$"){//dolar
            if(simbolo$ == "₲"){
              for(let i=0;i<total_registros_tabla;i++){
                $("#precio_venta_"+(i+1)).val(format($("#precio_venta_hidden_"+(i+1)).val()*cambio));
                $("#precio_total_"+(i+1)).val(format($("#precio_total_hidden_"+(i+1)).val()*cambio));
                $("#iva_"+(i+1)).html(format($("#iva_hidden_"+(i+1)).val()*cambio));
                $("#gravada_"+(i+1)).html(format($("#gravada_hidden_"+(i+1)).val()*cambio));
              }
              $("#iva10").val(format(total_iva10*cambio));
              $("#iva5").val(format(total_iva5*cambio));
              $("#total10").val(format(total_gravada10*cambio));
              $("#total5").val(format(total_gravada5*cambio));
              $("#exenta").val(format(total_exenta*cambio));
              $("#txtTotalVentas").val(format(total_ventas*cambio));
            }else{
              for(let i=0;i<total_registros_tabla;i++){
                $("#precio_venta_"+(i+1)).val(format($("#precio_venta_hidden_"+(i+1)).val()));
                $("#precio_total_"+(i+1)).val(format($("#precio_total_hidden_"+(i+1)).val()));
                $("#iva_"+(i+1)).html(format($("#iva_hidden_"+(i+1)).val()));
                $("#gravada_"+(i+1)).html(format($("#gravada_hidden_"+(i+1)).val()));
              }
              $("#iva10").val(format(total_iva10));
              $("#iva5").val(format(total_iva5));
              $("#total10").val(format(total_gravada10));
              $("#total5").val(format(total_gravada5));
              $("#exenta").val(format(total_exenta));
              $("#txtTotalVentas").val(format(total_ventas));
            }
          }else if(moneda_principal_global == "₲"){//guaranies
            if(simbolo$ == "US$"){
              for(let i=0;i<total_registros_tabla;i++){
                $("#precio_venta_"+(i+1)).val(format(($("#precio_venta_hidden_"+(i+1)).val()/cambio).toFixed(2)));
                $("#precio_total_"+(i+1)).val(format(($("#precio_total_hidden_"+(i+1)).val()/cambio).toFixed(2)));
                $("#iva_"+(i+1)).html(format(($("#iva_hidden_"+(i+1)).val()/cambio).toFixed(2)));
                $("#gravada_"+(i+1)).html(format(($("#gravada_hidden_"+(i+1)).val()/cambio).toFixed(2)));
              }
              $("#iva10").val(format((total_iva10/cambio).toFixed(2)));
              $("#iva5").val(format((total_iva5/cambio).toFixed(2)));
              $("#total10").val(format((total_gravada10/cambio).toFixed(2)));
              $("#total5").val(format((total_gravada5/cambio).toFixed(2)));
              $("#exenta").val(format((total_exenta/cambio).toFixed(2)));
              $("#txtTotalVentas").val(format((total_ventas/cambio).toFixed(2)));
            }else{
              for(let i=0;i<total_registros_tabla;i++){
                $("#precio_venta_"+(i+1)).val(format($("#precio_venta_hidden_"+(i+1)).val()));
                $("#precio_total_"+(i+1)).val(format($("#precio_total_hidden_"+(i+1)).val()));
                $("#iva_"+(i+1)).html(format($("#iva_hidden_"+(i+1)).val()));
                $("#gravada_"+(i+1)).html(format($("#gravada_hidden_"+(i+1)).val()));
              }
              $("#iva10").val(format(total_iva10));
              $("#iva5").val(format(total_iva5));
              $("#total10").val(format(total_gravada10));
              $("#total5").val(format(total_gravada5));
              $("#exenta").val(format(total_exenta));
              $("#txtTotalVentas").val(format(total_ventas));
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
          ajaxConfigMasivaChange("₲", moneda_seleccionada)
        }else if(moneda_seleccionada == "US$"){
          ajaxOperacionTotales("US$");
          ajaxConfigMasivaChange("₲", moneda_seleccionada)
        }
      }else if(moneda_principal_global == "₲"){//guaranies como moneda principal
        if(moneda_seleccionada == "US$"){
          ajaxOperacionTotales("US$");
          ajaxConfigMasivaChange("US$", moneda_seleccionada)
        }else if(moneda_seleccionada == "₲"){
          ajaxOperacionTotales("₲");
          ajaxConfigMasivaChange("₲", moneda_seleccionada)
        }
      }
    }


    //convetir en miles por defecto, cuando inicia la vista
    for(let i=0;i<total_registros_tabla;i++){
      $("#precio_venta_"+(i+1)).val(format($("#precio_venta_hidden_"+(i+1)).val()));
      $("#precio_total_"+(i+1)).val(format($("#precio_total_hidden_"+(i+1)).val()));
      $("#iva_"+(i+1)).html(format($("#iva_hidden_"+(i+1)).val()));
      $("#gravada_"+(i+1)).html(format($("#gravada_hidden_"+(i+1)).val()));
    }
    $("#iva10").val(format(total_iva10));
    $("#iva5").val(format(total_iva5));
    $("#total10").val(format(total_gravada10));
    $("#total5").val(format(total_gravada5));
    $("#exenta").val(format(total_exenta));
    $("#txtTotalVentas").val(format(total_ventas));


  </script>