  <?php
  $u = null;
  if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
    $u = UserData::getById($_SESSION["admin_id"]);
  ?>
    <?php if ($u->is_empleado) : ?>
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
                  $cotizacion = ClienteData::versucursalcotizacion($sucursales->id_sucursal);
                  $cajas = CajaData::vercajapersonal($u->id_usuario);
                  if (count($cajas) > 0 and  count($cotizacion) > 0) { ?>
                    <?php
                    foreach ($cotizacion as $moneda) {
                      $mon = MonedaData::cboObtenerValorPorSucursal2($sucursales->id_sucursal, $moneda->id_tipomoneda);
                    ?>
                      <?php foreach ($mon as $mo) : ?>
                        <?php
                        $nombre = $mo->nombre;
                        $fechacotiz = $mo->fecha_cotizacion;
                        ?>
                      <?php endforeach; ?>
                    <?php
                    }
                    // INICIO CONDICION DE FECHA COTIZACION
                    $fecha_hoy = date('d-m-Y');
                    $fecha_cotizacion = strtotime($fechacotiz);
                    $fecha_cot = date('d-m-Y', ($fecha_cotizacion));
                    if ($fecha_cot >= $fecha_hoy) {

                      //Core::alert("Cotizacion del día actualizada...!");

                      echo "<p class='alert alert-yelow'>Tiene la cotización  actualizada al dia:" . $fecha_cot . "</p>";
                      //Core::redir("index.php?view=index&id_sucursal=".$sucursales->id_sucursal);
                      //echo $fecha_cot;
                    } else if ($fecha_cot < $fecha_hoy) {

                      Core::alert("Atención debe de actualizar la moneda a la cotización del día...en Configuraciones/Cotizacion/Nuevo!");
                      Core::alert("Si su moneda principal es Dolares ingresar la equivalencia en guaranies  Seleccionar tipo moneda GS EJEMPLO: valor compra =6850; valor venta =6950");
                      Core::alert("Y a la moneda Dolares ingresar la equivalencia 1 USD : Seleccionar tipo moneda USD EJEMPLO: valor compra =1; valor venta =1");

                      Core::alert("Si su moneda principal es Guaranies ingresar la equivalencia en dólares  Seleccionar tipo moneda USD EJEMPLO:  valor compra=6850; valor venta =6950");
                      Core::alert("Y a la moneda Guaranies ingresar la equivalencia 1 USD : Seleccionar tipo moneda Gs EJEMPLO: valor compra  =1; valor venta =1");

                      Core::redir("index.php?view=cotizacion&id_sucursal=" . $sucursales->id_sucursal);
                      //echo "<p class='alert alert-danger'>Fecha de la última cotización:".$fecha_cot."</p>";

                    } else {
                      Core::alert("Atención debe de actualizar la moneda a la cotización del día...en Configuraciones/Cotizacion/Nuevo!");
                    }
                    ?>
                      <div class="box box-warning">
                        <div class="box-header">
                          <i class="fa fa-laptop" style="color: orange;"></i> INGRESAR EL CODIGO O NOMBRE DEL <B>PRODUCTO</B>.
                        </div>
                        <?php 
                        $codigod=0;
                        if (isset($_GET['tid'])) {
                          $codigod=$_GET['tid'];
                        }
                        else {
                          $codigod=0;
                        } ?>
                        <form id="searchppp">
                          <div class="row">
                            <div class="col-md-9">
                              <input type="hidden" name="view" value="vender">
                              <?php if ($codigod==0) { ?>
                                <input type="text" id="nombre" name="producto" class="form-control">
                              <?php } else { ?>
                                <input type="text" id="nombre" name="producto" class="form-control" value="<?= $codigod; ?>">
                              <?php } ?>
                            </div>
                            <div class="col-md-3">
                              <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                              <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                              <a href="index.php?view=remision1&id_sucursal=<?php echo $_GET["id_sucursal"]; ?>" class="btn btn-info"><i class="fa fa-reply"></i> Remisión</a>
                            </div>
                          </div>
                        </form>
                      </div>
                  <?php } else {
                    echo "<p class='alert alert-danger'>Debe iniciar Caja, o No hay Cotización registrada!</p>";
                  } ?>
                  <div id="resultado_producto"></div>
                  <?php if (isset($_SESSION["errors"])) : ?>
                    <h2>Errores</h2>
                    <p></p>
                    <table class="table table-bordered table-hover">
                      <tr class="danger">
                        <th>Codigo</th>
                        <th>Producto</th>
                        <th>Mensaje</th>
                      </tr>
                      <?php foreach ($_SESSION["errors"]  as $error) :
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
                      <div class="col-lg-2">
                        <?php  $dad=0; 
                        $by=isset($_SESSION["cart"]);
                        if ($by=="") {
                          } else {
                        foreach ($_SESSION["cart"] as $p) :
                          $clientito = OperationData::getById($p["producto_id"]);
                          $dad=$p["cli"];
                        endforeach;

                        }
                         ?>
                        <input type="text" name="remision_id" class="form-control" placeholder="REMISIÓN...." value="<?php echo $dad; ?>">
                      </div>
                      
                        <input type="hidden" name="factura" id="num1">
                        <input type="hidden" name="numeracion_inicial" id="numinicio">
                        <input type="hidden" name="numeracion_final" id="numfin">
                        <input type="hidden" name="serie1" id="serie">
                        <div class="form-group">
                      <label for="inputEmail1" class="col-lg-1 control-label">Tipo Doc.:</label>
                      <div class="col-lg-2">
                        <?php
                        $clients = ConfigFacturaData::verfacturasucursal($sucursales->id_sucursal);
                        ?>
                        <select required="" name="configfactura_id" id="configfactura_id" class="form-control" oninput="configFactura()">
                          <option value="">Seleccionar</option>

                          <?php foreach ($clients as $client) : ?>
                            <option <?php if ($client->diferencia == -1) : ?>disabled="" <?php else : ?><?php endif ?> value="<?php echo $client->id_configfactura; ?>"><?php echo $client->comprobante1; ?></option>
                            <script type="text/javascript">
                              function configFactura() {
                                $.ajax({
                                  url: 'index.php?action=consultafactura',
                                  type: 'POST',
                                  data: {
                                    confiFactura: Number(document.getElementById("configfactura_id").value)
                                  },
                                  dataType: 'json',
                                  success: function(json) {
                                    document.getElementById('num1').value = json[0].numeroactual1;
                                    document.getElementById('numinicio').value = json[0].numeracion_inicial;
                                    document.getElementById('numfin').value = json[0].numeracion_final;
                                    document.getElementById('serie').value = json[0].serie1;
                                    document.getElementById('id_configfactura').value = json[0].id_configfactura;
                                    document.getElementById('diferencia').value = json[0].diferencia;
                                  },
                                  error: function(xhr, status) {
                                    console.log("Ha ocurrido un error.");
                                  }
                                });

                              }
                            </script>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div>
                        <input type="hidden" name="presupuesto" class="form-control" id="presupuesto" value="0">
                        <input type="hidden" name="id_configfactura" id="id_configfactura">
                        <input type="text" name="diferencia" id="diferencia">
                      </div>
                      <label for="inputEmail1" class="col-lg-1 control-label">Moneda:</label>
                      <div class="col-lg-2">
                        <?php
                        $monedas = MonedaData::cboObtenerValorPorSucursal($sucursales->id_sucursal);
                        ?>
                        <select required="" name="tipomoneda_id" id="tipomoneda_id" id1="valor" class="form-control" oninput="tipocambio()">
                          <!-- <option value="0">Seleccionar</option> -->
                          <?php foreach ($monedas as $moneda) : ?>
                            <?php
                            $valocito = null;
                            ?>
                            <option value="<?php echo $moneda->simbolo; ?>"><?php echo $moneda->nombre . "-" . $moneda->simbolo; ?></option>

                            <script type="text/javascript">
                              function tipocambio() {
                                ajaxConvertirValoresTotales($("#tipomoneda_id").val());

                              }
                            </script>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <label for="inputEmail1" class="col-lg-1 control-label">Cambio:</label>
                      <div class="col-lg-2">
                        <input readonly="" type="text" name="cambio" id="cambio" class="form-control">
                        <?php
                        $cotizacion = CotizacionData::versucursalcotizacion($sucursales->id_sucursal);
                        if (count($cotizacion) > 0) { ?>
                          <?php
                          $valores = 0;
                          foreach ($cotizacion as $moneda) {
                            $mon = MonedaData::cboObtenerValorPorSucursal3($sucursales->id_sucursal);
                          ?>
                            <?php foreach ($mon as $mo) : ?>
                              <?php
                              $nombre = $mo->nombre;
                              $fechacotiz = $mo->fecha_cotizacion;
                              $valores = $mo->valor;
                              $simbolo2 = $mo->simbolo;
                              ?>
                            <?php endforeach; ?>
                        <?php
                          }
                        }

                        ?>
                        <input type="hidden" name="cambio2" id="cambio2" value="<?php echo $valores; ?>" class="form-control">
                        <input type="hidden" name="simbolo2" id="simbolo2" value="<?php echo $simbolo2; ?>" class="form-control">
                        <input type="hidden" name="idtipomoneda" id="idtipomoneda" class="form-control">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="inputEmail1" class="col-lg-2 control-label">Cliente:</label>
                          <div class="col-lg-9">
                            <select name="cliente_id" class="form-control">
                              <?php  $dd=0; ?>
                              <?php
                        foreach ($_SESSION["cart"] as $p) :
                          $clientito = OperationData::getById($p["producto_id"]);
                          $dd=$p["cli"];
                          ?>
                          <?php
                        endforeach; ?>
                              <?php if ($dd==0) { 
                                $clients = ClienteData::verclientessucursal($sucursales->id_sucursal);
                                ?>
                                <?php foreach ($clients as $client) : ?>
                                <option value="<?php echo $client->id_cliente; ?>"><?php echo $client->dni . " - " . $client->nombre . " " . $client->apellido . " - " . $client->tipo_doc; ?></option>
                              <?php endforeach; ?>
                              <?php  } else{ 
                                $ventas = VentaData1::vercontenidos($dd);
                                if (count($ventas)>0) {
                                  foreach ($ventas as $venta) { ?>
                                    <option value="<?php echo $venta->getCliente()->id_cliente; ?>"><?php echo $venta->getCliente()->nombre." ".$venta->getCliente()->apellido; ?></option>
                                  <?php }
                                }                             
                                
                             } ?>                              
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
                              <input name="formapago" autofocus="autofocus" value="Efectivo" checked type="radio" name="" onclick="Ocultar1();"> Efectivo
                              <input name="formapago" value="Targeta de Debito" type="radio" name="" onclick="Mostrar1();"> Targeta de Debito
                              <input name="formapago" value="Targeta de Credito" type="radio" name="" onclick="Mostrar1();"> Targeta de Credito
                              <input name="formapago" value="Giro" type="radio" name="" onclick="Ocultar1();"> Giro
                            </div>
                          </div>
                        </div>
                        <div id="mostrar">
                          <div class="form-group">
                            <label for="inputEmail1" class="col-lg-3 control-label">Cuotas</label>
                            <div class="col-lg-9">
                              <input type="number" name="cuotas" class="form-control" id="fechapago">
                            </div>
                            <label for="inputEmail1" class="col-lg-3 control-label">Plazo</label>
                            <div class="col-lg-9">
                              <input type="number" name="vencimiento" class="form-control" id="fechapago">
                            </div>

                            <div class="col-lg-9">
                              <label for="inputEmail1" class="col-lg-3 control-label">Concepto</label>

                              <input type="text" name="concepto" class="form-control" id="fechapago">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="inputEmail1" class="col-lg-2 control-label">Tipo de venta:</label>
                          <div class="col-lg-4">
                            <input name="metodopago" value="Contado" checked type="radio" name="" onclick="Ocultar();"> Contado
                            <input name="metodopago" value="Credito" type="radio" name="" onclick="Mostrar();"> Credito

                            <?php $configmasiva = ConfiguracionMasivaData::vercamasivaactivosucursal($sucursales->id_sucursal); ?>
                            <?php if (count($configmasiva) > 0) : ?>
                              <?php foreach ($configmasiva as $masivas) : ?>
                                <input type="hidden" name="cantidaconfigmasiva" id="cantidaconfigmasiva" value="<?php echo $masivas->cantidad; ?>">
                              <?php endforeach; ?>
                            <?php endif ?>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">Fecha Venta:</label>
                            <div class="col-lg-4">
                              <input type="date" name="fecha" class="form-control" value="<?php echo date("Y-m-d"); ?>" id="fecha" placeholder="Efectivo">
                            </div>
                          </div>
                          <div class="form-group">
                            <div id="ocultar1"></div>
                            <div id="mostrar1">
                              <label for="inputEmail1" class="col-lg-3 control-label">Codigo:</label>
                              <div class="col-lg-4">
                                <input type="number" name="codigo" class="form-control" value="0" id="codigo" placeholder="Descuento">
                              </div>
                            </div>
                          </div>
                          <div class="form-group"> 
                            <label for="inputEmail1" class="col-lg-3 control-label">TIPO VENTA:</label>
                            <div class="col-lg-4">
                              <select class="form-control" name="tipoventa">
                                <option value="1">VENTA</option>
                                <option value="2">REMISIÓN</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <?php if (isset($_SESSION["cart"])) :
                      $total1 = 0;
                      $total10por = 0;
                      $total5por = 0;
                      $total0porc = 0;
                      $exenta = 0;
                      $iva10 = 0;
                      $iva5 = 0;
                      $iva0 = 0;
                      $grabada10 = 0;
                      $grabada5 = 0;
                      $grabada0 = 0;
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
                          <th></th>
                        </thead>
                        <?php

                        $total_registros = 0;
                        foreach ($_SESSION["cart"] as $p) :
                          $q1 = OperationData::getQYesFf($p["producto_id"]);
                          $product = ProductoData::getById($p["producto_id"]); ?>
                          <tr>
                            <td><input style="width:110px;" readonly="" type="text" name="codigo_" id="codigo_<?= $total_registros + 1 ?>" value="<?php echo $product->codigo; ?>">
                              <input type="hidden" name="stock" value="<?php echo $p["stock"]; ?>">
                              <input type="hidden" name="tipoproducto" value="<?= $p["tipoproducto"]; ?>">
                              <input type="hidden" name="precios" value="<?= $p["precios"]; ?>">
                            </td>
                            <td><span>
                                <input style="width:90px;" onblur="actualizarCantidad(<?= $total_registros + 1 ?>, '<?php echo $product->nombre; ?>', <?php echo $p["precio"] ?>, <?php echo $p['producto_id']; ?>)" type="number" id="txtCantidadEditable_<?= $total_registros + 1 ?>" value="<?php echo $p["q"]; ?>" />
                                <input type="hidden" value="<?php echo $p["q"]; ?>" id="txtCantidadEditableHidden_<?= $total_registros + 1 ?>" />
                              </span>
                            </td>
                            <td><?php echo $product->nombre; ?></td>
                            <td><?php echo $product->impuesto; ?> %</td>
                            <td>
                              <b id="iva_<?= $total_registros + 1 ?>" style="
                            <?php
                            $resultado = "";
                            switch ($product->impuesto) {
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
                                switch ($product->impuesto) {
                                  case 10:
                                    $resultado_valor = round((($p["precio"] * $p["q"]) / 11), 4);
                                    $iva10 += round((($p["precio"] * $p["q"]) / 11), 4);
                                    break;
                                  case 5:
                                    $resultado_valor = round((($p["precio"] * $p["q"]) / 21), 4);
                                    $iva5 += round((($p["precio"] * $p["q"]) / 21), 4);
                                    break;
                                  default:
                                    $resultado_valor = round((($p["precio"] * $p["q"])), 4);
                                    $iva0 += round((($p["precio"] * $p["q"])), 4);
                                }
                                echo $resultado_valor;
                                ?>
                              </b>
                              <input type="hidden" id="iva_hidden_<?= $total_registros + 1 ?>" value="                      <?php
                                                                                                                                  $resultado_valor = 0;
                                                                                                                                  switch ($product->impuesto) {
                                                                                                                                    case 10:
                                                                                                                                      $resultado_valor = round((($p["precio"] * $p["q"]) / 11), 4);
                                                                                                                                      break;
                                                                                                                                    case 5:
                                                                                                                                      $resultado_valor = round((($p["precio"] * $p["q"]) / 21), 4);
                                                                                                                                      break;
                                                                                                                                    default:
                                                                                                                                      $resultado_valor = round((($p["precio"] * $p["q"])), 4) * 0;
                                                                                                                                  }
                                                                                                                                  echo $resultado_valor;
                                                                                                                                  ?>">
                            </td>
                            <td>
                              <b id="gravada_<?= $total_registros + 1 ?>" style="
                            <?php
                            $resultado = "";
                            switch ($product->impuesto) {
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
                                switch ($product->impuesto) {
                                  case 10:
                                    $resultado_valor = round((($p["precio"] * $p["q"]) / 1.1), 4);
                                    $grabada10 += round((($p["precio"] * $p["q"]) / 1.1), 4);
                                    break;
                                  case 5:
                                    $resultado_valor = round((($p["precio"] * $p["q"]) / 1.05), 4);
                                    $grabada5 += round((($p["precio"] * $p["q"]) / 1.05), 4);
                                    break;
                                  default:
                                    $resultado_valor = round((($p["precio"] * $p["q"])), 4);
                                    $grabada0 += round((($p["precio"] * $p["q"])), 4);
                                }
                                echo $resultado_valor;
                                ?>
                              </b>
                              <input type="hidden" id="gravada_hidden_<?= $total_registros + 1 ?>" value="                            <?php
                                                                                                                                      $resultado_valor = 0;
                                                                                                                                      switch ($product->impuesto) {
                                                                                                                                        case 10:
                                                                                                                                          $resultado_valor = round((($p["precio"] * $p["q"]) / 1.1), 4);
                                                                                                                                          break;
                                                                                                                                        case 5:
                                                                                                                                          $resultado_valor = round((($p["precio"] * $p["q"]) / 1.05), 4);
                                                                                                                                          break;
                                                                                                                                        default:
                                                                                                                                          $resultado_valor = round((($p["precio"] * $p["q"])), 4) * 0;
                                                                                                                                      }
                                                                                                                                      echo $resultado_valor;
                                                                                                                                      ?>">
                            </td>
                            <!--*********** -->


                            <td><span>
                                <input style="width:110px;" onblur="actualizarCantidad2(<?= $total_registros + 1 ?>, '<?php echo $p["q"] ?>', <?php echo round(($p["precio"]), 4) ?>, <?php echo $p['producto_id']; ?>)" type="text" id="precio_venta_<?= $total_registros + 1 ?>" value="<?php echo round(($p["precio"]), 4); ?>" />
                                <input type="hidden" value="<?php echo round(($p["precio"]), 4); ?>" id="precio_venta_hidden_<?= $total_registros + 1 ?>" />
                              </span></td>



                            <td>
                              <input style="width:110px;" readonly="" type="text" name="" id="precio_total_<?= $total_registros + 1 ?>" value="<?php $pt = round(($p["precio"] * $p["q"]), 4);
                                                                                                                                                $total1 += $pt;
                                                                                                                                                echo round(($p["precio"] * $p["q"]), 4); ?>">
                              <input readonly="" type="hidden" name="" id="precio_total_hidden_<?= $total_registros + 1 ?>" value="<?php $pt = round(($p["precio"] * $p["q"]), 4);
                                                                                                                                    echo  round(($p["precio"] * $p["q"]), 4); ?>">
                            </td>
                            <td style="width:30px;"><a href="index.php?action=eliminarcompraproductos1&id_sucursal=<?php echo $sucursales->id_sucursal; ?>&producto_id=<?php echo $product->id_producto; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
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
                              <td>
                                <p>Gravada 10%</p>
                              </td>
                              <td>
                                <p><b> <input type="text" readonly="" name="total10" id="total10" placeholder="Efectivo" value="<?php echo $grabada10; ?>">
                                  </b></p>
                              </td>
                              <td>IVA. 10%</td>
                              <td>
                                <p><b> <input type="text" readonly="readonly" name="iva10" id="iva10" value="<?php echo $iva10; ?>">
                            </tr>
                            <tr>
                              <td>
                                <p>Gravada 5%</p>
                              </td>
                              <td>
                                <p><b><input type="text" readonly="" name="total5" id="total5" value="<?php echo $grabada5; ?>"> </b></p>
                              </td>
                              <td>IVA. 5%</td>
                              <td>
                                <p><b><input type="text" readonly="" name="iva5" id="iva5" value="<?php echo $iva5; ?>"></b>
                                </p>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <p>Exenta</p>
                              </td>
                              <td>
                                <p><b><input type="text" readonly="" name="exenta" id="exenta" value="<?php echo $grabada0; ?>"> </b></p>
                              </td>
                              <!-- <td>TIPO V.</td>
                             <td>
                              <select class="form-control" name="tipoventa">
                                <option value="1">VENTA</option>
                                <option value="2">REMISIÓN</option>
                                </select>
                              </td> --> 
                            </tr>
                            <tr>
                              <td>
                                <p>Total</p>
                              </td>
                              <td>
                                <p><b><input type="text" readonly="" name="total" id="txtTotalVentas" value="<?php echo $total1; ?>"> </b></p>
                              </td>
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
                              <input type="hidden" value="<?php echo $q1; ?>" id="stock_trans" name="stock_trans" />
                              <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                              <a href="index.php?action=eliminarcompraproductos1&id_sucursal=<?php echo $sucursales->id_sucursal; ?>" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
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
  <link rel="stylesheet" href="plugins/css/toastr.min.css">
  <script src="plugins/toastr.min.js"></script>
  <script>
    const format = num =>
      String(num).replace(/(?<!\..*)(\d)(?=(?:\d{3})+(?:\.|$))/g, '$1,');

    const total_registros_tabla = <?= $total_registros ?>;

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

    if (moneda_principal_global == "US$") { //dolar
      $.ajax({
        url: 'index.php?action=consultamoneda',
        type: 'POST',
        data: {
          sucursal: <?= $_GET["id_sucursal"] ?>,
          simbolo: moneda_principal_global, //simbolo
          accion: "obtenerCambioPorSimbolo"
        },
        dataType: 'json',
        success: function(json) {
          $("#cambio").val(json[0].valor);
          $("#idtipomoneda").val(json[0].id_tipomoneda);
          valor_dolar_global = json[0].valor;
          ajaxConfigMasiva("₲");
        },
        error: function(xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });
    } else if (moneda_principal_global == "₲") { //guaranies
      $.ajax({
        url: 'index.php?action=consultamoneda',
        type: 'POST',
        data: {
          sucursal: <?= $_GET["id_sucursal"] ?>,
          simbolo: moneda_principal_global, //simbolo
          accion: "obtenerCambioPorSimbolo"
        },
        dataType: 'json',
        success: function(json) {
          valor_guaranies_global = json[0].valor;
          $("#idtipomoneda").val(json[0].id_tipomoneda);
          $("#cambio").val(json[0].valor);
          ajaxConfigMasiva("US$");
        },
        error: function(xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });
    }


    function ajaxConfigMasiva(simbolo$) {
      $.ajax({
        url: 'index.php?action=consultamoneda',
        type: 'POST',
        data: {
          sucursal: <?= $_GET["id_sucursal"] ?>,
          simbolo: simbolo$, //simbolo
          accion: "obtenerCambioPorSimbolo"
        },
        dataType: 'json',
        success: function(json) {
          const cambio_valor = json[0].valor;
          if (moneda_principal_global == "US$") {
            $("#cantidaconfigmasiva").val(valor_configmasiva_global / cambio_valor);
          } else if (moneda_principal_global == "₲") {
            $("#cantidaconfigmasiva").val(valor_configmasiva_global);
          }
        },
        error: function(xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });
    }

    function setearTipoCambioChange(simbolo$) {
      $.ajax({
        url: 'index.php?action=consultamoneda',
        type: 'POST',
        data: {
          sucursal: <?= $_GET["id_sucursal"] ?>,
          simbolo: simbolo$, //simbolo
          accion: "obtenerCambioPorSimbolo"
        },
        dataType: 'json',
        success: function(json) {
          const cambio_valor = json[0].valor;
          $("#cambio").val(cambio_valor);
          const valor_inical = json[0].id_tipomoneda;
          $("#idtipomoneda").val(valor_inical);
        },
        error: function(xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });
    }

    function ajaxConfigMasivaChange(simbolo$, moneda_seleccionada) {
      $.ajax({
        url: 'index.php?action=consultamoneda',
        type: 'POST',
        data: {
          sucursal: <?= $_GET["id_sucursal"] ?>,
          simbolo: simbolo$, //simbolo
          accion: "obtenerCambioPorSimbolo"
        },
        dataType: 'json',
        success: function(json) {
          const cambio_valor = json[0].valor;
          if (moneda_principal_global == "US$") { //dolar como moneda principal
            if (moneda_seleccionada == "₲") {
              setearTipoCambioChange("₲");
              $("#cantidaconfigmasiva").val(valor_configmasiva_global);
            } else if (moneda_seleccionada == "US$") {
              setearTipoCambioChange("US$");
              $("#cantidaconfigmasiva").val(valor_configmasiva_global / cambio_valor);
            }
          } else if (moneda_principal_global == "₲") { //guaranies como moneda principal
            if (moneda_seleccionada == "US$") {
              setearTipoCambioChange("US$");
              $("#cantidaconfigmasiva").val(valor_configmasiva_global / cambio_valor);
            } else if (moneda_seleccionada == "₲") {
              setearTipoCambioChange("₲");
              $("#cantidaconfigmasiva").val(valor_configmasiva_global);
            }
          }
        },
        error: function(xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });
    }

    function ajaxOperacionTotales(simbolo$) {
      $.ajax({
        url: 'index.php?action=consultamoneda',
        type: 'POST',
        data: {
          sucursal: <?= $_GET["id_sucursal"] ?>,
          simbolo: simbolo$, //simbolo
          accion: "obtenerCambioPorSimbolo"
        },
        dataType: 'json',
        success: function(json) {
          const cambio = json[0].valor;
          if (moneda_principal_global == "US$") { //dolar
            if (simbolo$ == "₲") {
              for (let i = 0; i < total_registros_tabla; i++) {
                $("#precio_venta_" + (i + 1)).val(format(($("#precio_venta_hidden_" + (i + 1)).val() * cambio).toFixed(4)));




                $("#precio_total_" + (i + 1)).val(format(($("#precio_total_hidden_" + (i + 1)).val() * cambio).toFixed(4)));
                $("#iva_" + (i + 1)).html(format(($("#iva_hidden_" + (i + 1)).val() * cambio).toFixed(4)));
                $("#gravada_" + (i + 1)).html(format(($("#gravada_hidden_" + (i + 1)).val() * cambio).toFixed(4)));
              }
              $("#iva10").val(format((total_iva10 * cambio).toFixed(4)));
              $("#iva5").val(format((total_iva5 * cambio).toFixed(4)));
              $("#total10").val(format((total_gravada10 * cambio).toFixed(4)));
              $("#total5").val(format((total_gravada5 * cambio).toFixed(4)));
              $("#exenta").val(format((total_exenta * cambio).toFixed(4)));
              $("#txtTotalVentas").val(format((total_ventas * cambio).toFixed(4)));
            } else {
              for (let i = 0; i < total_registros_tabla; i++) {
                $("#precio_venta_" + (i + 1)).val(format($("#precio_venta_hidden_" + (i + 1)).val()));



                $("#precio_total_" + (i + 1)).val(format($("#precio_total_hidden_" + (i + 1)).val()));
                $("#iva_" + (i + 1)).html(format($("#iva_hidden_" + (i + 1)).val()));
                $("#gravada_" + (i + 1)).html(format($("#gravada_hidden_" + (i + 1)).val()));
              }
              $("#iva10").val(format(total_iva10));
              $("#iva5").val(format(total_iva5));
              $("#total10").val(format(total_gravada10));
              $("#total5").val(format(total_gravada5));
              $("#exenta").val(format(total_exenta));
              $("#txtTotalVentas").val(format(total_ventas));
            }
          } else if (moneda_principal_global == "₲") { //guaranies
            if (simbolo$ == "US$") {
              for (let i = 0; i < total_registros_tabla; i++) {
                $("#precio_venta_" + (i + 1)).val(format(($("#precio_venta_hidden_" + (i + 1)).val() / cambio).toFixed(4)));



                $("#precio_total_" + (i + 1)).val(format(($("#precio_total_hidden_" + (i + 1)).val() / cambio).toFixed(4)));
                $("#iva_" + (i + 1)).html(format(($("#iva_hidden_" + (i + 1)).val() / cambio).toFixed(4)));
                $("#gravada_" + (i + 1)).html(format(($("#gravada_hidden_" + (i + 1)).val() / cambio).toFixed(4)));
              }
              $("#iva10").val(format((total_iva10 / cambio).toFixed(4)));
              $("#iva5").val(format((total_iva5 / cambio).toFixed(4)));
              $("#total10").val(format((total_gravada10 / cambio).toFixed(4)));
              $("#total5").val(format((total_gravada5 / cambio).toFixed(4)));
              $("#exenta").val(format((total_exenta / cambio).toFixed(4)));
              $("#txtTotalVentas").val(format((total_ventas / cambio).toFixed(4)));
            } else {
              for (let i = 0; i < total_registros_tabla; i++) {
                $("#precio_venta_" + (i + 1)).val(format($("#precio_venta_hidden_" + (i + 1)).val()));



                $("#precio_total_" + (i + 1)).val(format($("#precio_total_hidden_" + (i + 1)).val()));
                $("#iva_" + (i + 1)).html(format($("#iva_hidden_" + (i + 1)).val()));
                $("#gravada_" + (i + 1)).html(format($("#gravada_hidden_" + (i + 1)).val()));
              }
              $("#iva10").val(format(total_iva10));
              $("#iva5").val(format(total_iva5));
              $("#total10").val(format(total_gravada10));
              $("#total5").val(format(total_gravada5));
              $("#exenta").val(format(total_exenta));
              $("#txtTotalVentas").val(format(total_ventas));
            }
          }
        },
        error: function(xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });
    }

    function ajaxConvertirValoresTotales(moneda_seleccionada) {
      if (moneda_principal_global == "US$") { //dolar como moneda principal
        if (moneda_seleccionada == "₲") {
         // ajaxOperacionTotales("₲");
          ajaxConfigMasivaChange("₲", moneda_seleccionada)
        } else if (moneda_seleccionada == "US$") {
          //ajaxOperacionTotales("US$");
          ajaxConfigMasivaChange("₲", moneda_seleccionada)
        }
      } else if (moneda_principal_global == "₲") { //guaranies como moneda principal
        if (moneda_seleccionada == "US$") {
          //ajaxOperacionTotales("US$");
          ajaxConfigMasivaChange("US$", moneda_seleccionada)
        } else if (moneda_seleccionada == "₲") {
          //ajaxOperacionTotales("₲");
          ajaxConfigMasivaChange("₲", moneda_seleccionada)
        }
      }
    }


    //convetir en miles por defecto, cuando inicia la vista
    for (let i = 0; i < total_registros_tabla; i++) {
      $("#precio_venta_" + (i + 1)).val(format($("#precio_venta_hidden_" + (i + 1)).val()));
      $("#precio_total_" + (i + 1)).val(format($("#precio_total_hidden_" + (i + 1)).val()));
      $("#iva_" + (i + 1)).html(format($("#iva_hidden_" + (i + 1)).val()));
      $("#gravada_" + (i + 1)).html(format($("#gravada_hidden_" + (i + 1)).val()));
    }
    $("#iva10").val(format(total_iva10));
    $("#iva5").val(format(total_iva5));
    $("#total10").val(format(total_gravada10));
    $("#total5").val(format(total_gravada5));
    $("#exenta").val(format(total_exenta));
    $("#txtTotalVentas").val(format(total_ventas));


    function editarCantidadSessionAjax(productoId, cantidadNueva, precio) {
      $.ajax({
        url: 'index.php?action=agregarCantidadEditable',
        type: 'POST',
        data: {
          producto_id: productoId,
          cantidad: cantidadNueva,
          precio_venta: precio
        },
        success: function(json) {},
        error: function(xhr, status) {
          toastr.error('No se ha podido actualizar la cantidad ingresada.', 'Error')
        }
      });
    }


    function actualizarCantidad(idIteracion, nombre, precio, idProducto) {
      const cantidadAntigua = $("#txtCantidadEditableHidden_" + idIteracion).val();
      const cantidadNueva = $("#txtCantidadEditable_" + idIteracion).val();

      if (cantidadAntigua != cantidadNueva) {
        editarCantidadSessionAjax(idProducto, cantidadNueva, precio);
        window.location.reload();
      }
    }

    function editarCantidadSessionAjax2(productoId, cantidadNueva, cant) {
      $.ajax({
        url: 'index.php?action=agregarCantidadEditable2',
        type: 'POST',
        data: {
          producto_id: productoId,
          precio_nuevo: cantidadNueva,
          cantidad: cant
        },
        success: function(json) {},
        error: function(xhr, status) {
          toastr.error('No se ha podido actualizar la cantidad ingresada.', 'Error')
        }
      });
    }


    function actualizarCantidad2(idIteracion, cant, precio, idProducto) {
      const cantidadAntigua = $("#precio_venta_hidden_" + idIteracion).val();
      const cantidadNueva = $("#precio_venta_" + idIteracion).val();

      if (cantidadAntigua != cantidadNueva) {
        editarCantidadSessionAjax2(idProducto, cantidadNueva, cant);
        window.location.reload();
      }
    }
  </script>