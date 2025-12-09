  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
  <?php
  $u = null;
  $tipo = 0;
  if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
    $u = UserData::getById($_SESSION["admin_id"]);
    if ($u->is_empleado) :
      $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
  ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1><i class='fa fa-gift' style="color: orange;"></i>
            REALIZAR VENTA EXPORTACION:
          </h1>
        </section>
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">

                <!-- <div class="" id="paso1"> -->
                <div class="box-body">
                  <?php
                  if (isset($_GET['tid'])) {
                    $venta = VentaData::getById($_GET['tid']);
                  }
                  $cotizacion = CotizacionData::versucursalcotizacion($sucursales->id_sucursal);
                  $cajas = CajaData::vercajapersonal($u->id_usuario);
                  if (count($cajas) > 0 and  count($cotizacion) > 0) {
                    foreach ($cotizacion as $moneda) {
                      $mon = MonedaData::cboObtenerValorPorSucursal2($sucursales->id_sucursal, $moneda->id_tipomoneda);
                      foreach ($mon as $mo) :
                        $nombre = $mo->nombre;
                        $fechacotiz = $mo->fecha_cotizacion;
                      endforeach;
                    }
                    $fecha_hoy = date('d-m-Y');
                    $fecha_cotizacion = strtotime($fechacotiz);
                    $fecha_cot = date('d-m-Y', ($fecha_cotizacion));
                    if ($fecha_cot >= $fecha_hoy) {
                      echo "<p class='alert alert-success'>Tiene la cotización  actualizada al dia:" . $fecha_cot . "</p>";
                    } else if ($fecha_cot < $fecha_hoy) {

                      Core::alert("Atención debe de actualizar la moneda a la cotización del día...en Configuraciones/Cotizacion/Nuevo!");
                    } else {
                      Core::alert("Atención debe de actualizar la moneda a la cotización del día...en Configuraciones/Cotizacion/Nuevo!");
                    }
                  ?>

                  <?php } else {
                    echo "<p class='alert alert-danger'>Debe iniciar Caja, o No hay Cotización registrada!</p>";
                  } ?>
                  <div id="resultado_producto"></div>
                  <!-- <form method="post" class="form-horizontal" id="processsell" action="index.php?action=procesoventaproducto1"> -->

                  <?php $configmasiva = ConfiguracionMasivaData::vercamasivaactivosucursal($sucursales->id_sucursal);
                  if (count($configmasiva) > 0) :
                    foreach ($configmasiva as $masivas) : ?>
                      <input type="hidden" name="cantidaconfigmasiva" id="cantidaconfigmasiva" value="<?php echo $masivas->cantidad; ?>">
                  <?php endforeach;
                  endif ?>
                  <div class="form-group">
                    <label for="inputEmail1" class="col-lg-1 control-label">Tipo Doc.:</label>
                    <div class="col-lg-2">
                      <?php
                      $clients = ConfigFacturaData::verfacturasucursal($sucursales->id_sucursal);
                      ?>
                      <select name="configfactura_id" id="configfactura_id" class="form-control" oninput="configFactura()">
                        <option value="">Seleccionar</option>

                        <?php
                        $i = 0;
                        foreach ($clients as $client) : ?>
                          <option <?php if ($client->comprobante1 == "Factura") {
                                    echo "selected";
                                  } ?> <?php if ($client->diferencia == -1) : ?>disabled="" <?php else : ?><?php endif ?> value="<?php echo $client->id_configfactura; ?>"><?php echo $client->comprobante1; ?><?php echo " " ?><?php echo $client->serie1; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div>
                      <div class="col-md-2">
                        <input type="text" disabled="" class="form-control" name="facturan" id="facturan">
                      </div>

                      <div class="col-md-2">
                        <input type="hidden" class="form-control" name="diferencia" id="diferencia">
                      </div>

                      <?php if (isset($_GET['tid'])) { ?>

                        <div class="col-lg-2">
                          <label for="inputEmail1" class="col-lg-1 control-label">Moneda:</label>
                          <?php
                          $monedas = MonedaData::cboObtenerValorPorSucursal($sucursales->id_sucursal);
                          $mon = MonedaData::VerId($venta->tipomoneda_id, $_GET['id_sucursal']);

                          ?>
                          <select name="tipomoneda_id" id="tipomoneda_id" id1="valor" class="form-control" onchange="tipocambio()">
                            <!-- <option value="0">Seleccionar</option> -->
                            <?php

                            foreach ($monedas as $moneda) :
                              if ($mon->simbolo == $moneda->simbolo) { ?>
                                <option selected value="<?php echo $moneda->simbolo; ?>"><?php echo $moneda->nombre . "-" . $moneda->simbolo; ?></option>
                              <?php
                              } else {
                              ?>
                                <option value="<?php echo $moneda->simbolo; ?>"><?php echo $moneda->nombre . "-" . $moneda->simbolo; ?></option>
                            <?php }
                            endforeach; ?>
                          </select>
                        </div>
                      <?php } else { ?>
                        <div class="col-lg-2">
                          <label for="inputEmail1" class="col-lg-1 control-label">Moneda:</label>

                          <?php
                          $monedas = MonedaData::cboObtenerValorPorSucursal($sucursales->id_sucursal);
                          ?>
                          <select name="tipomoneda_id" id="tipomoneda_id" id1="valor" class="form-control" onchange="tipocambio()">
                            <!-- <option value="0">Seleccionar</option> -->
                            <?php foreach ($monedas as $moneda) : ?>
                              <option value="<?php echo $moneda->simbolo; ?>"><?php echo $moneda->nombre . "-" . $moneda->simbolo; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      <?php } ?>
                      <div class="col-lg-2">
                        <label for="inputEmail1" class="col-lg-1 control-label">Cambio:</label>

                        <input readonly="" type="hidden" name="cambio" id="cambio" class="form-control">
                        <?php
                        $cotizacion = CotizacionData::versucursalcotizacion($sucursales->id_sucursal);
                        // var_dump($cotizacion);
                        $mon = MonedaData::cboObtenerValorPorSucursal3($sucursales->id_sucursal);
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
                        <input type="text" disabled="" name="cambio2" id="cambio2" value="<?php echo $valores; ?>" class="form-control">
                        <input type="hidden" name="simbolo2" id="simbolo2" value="<?php echo $simbolo2; ?>" class="form-control">
                        <input type="hidden" name="idtipomoneda" id="idtipomoneda" class="form-control">
                      </div>
                    </div>

                    <div class="col-lg-2">
                      <?php $dad = 0;
                      // $by = isset($_SESSION["cart"]);
                      // if ($by == "") {
                      // } else {
                      //   foreach ($_SESSION["cart"] as $p) :
                      //     $clientito = OperationData::getById($p["producto_id"]);
                      //     $dad = $p["cli"];
                      //   endforeach;
                      // }
                      ?>
                      Remision <input placeholder="Remision" value="0" disabled id="remision_id" class="form-control">
                    </div>
                    <div class="row ">
                      <div class="col-md-4 " style="margin-top: 15px;">
                        <label for="inputEmail1" class="col-lg-2 control-label">Cliente:</label>

                        <div class="col-lg-9">
                          <?php if (isset($_GET['tid'])) { ?>
                            <select name="cliente_id" onchange="clienteTipo()" class="selectpicker show-menu-arrow" data-style="form-control" data-live-search="true" id="cliente_id" class="form-control">
                              <option value="">SELECCIONAR CLIENTE</option>

                              <?php
                              $clients = ClienteData::verclientessucursal($sucursales->id_sucursal);
                              foreach ($clients as $client) :
                                // $tipocliente = ProductoData::listar_tipo_precio($client->id_precio);
                                if ($client->id_cliente == $venta->cliente_id) { ?>
                                  <option selected value="<?php echo $client->id_cliente; ?>"><?php echo $client->dni . " - " . $client->nombre . " " . $client->apellido . " - " . $client->tipo_doc; ?></option>
                                <?php
                                } else {
                                ?>
                                  <option value="<?php echo $client->id_cliente; ?>"><?php echo $client->dni . " - " . $client->nombre . " " . $client->apellido . " - " . $client->tipo_doc; ?></option>
                              <?php }
                              endforeach;

                              ?>
                            </select>
                          <?php } else { ?>
                            <select name="cliente_id" onchange="clienteTipo()" class="selectpicker show-menu-arrow" data-style="form-control" data-live-search="true" id="cliente_id" class="form-control">
                              <option value="">SELECCIONAR CLIENTE</option>

                              <?php
                              $clients = ClienteData::verclientessucursal($sucursales->id_sucursal);
                              foreach ($clients as $client) :
                                // $tipocliente = ProductoData::listar_tipo_precio($client->id_precio);

                              ?>
                                <option value="<?php echo $client->id_cliente; ?>"><?php echo $client->dni . " - " . $client->nombre . " " . $client->apellido . " - " . $client->tipo_doc; ?></option>
                              <?php endforeach;

                              ?>
                            </select>
                          <?php } ?>
                        </div>

                        <?php
                        // var_dump($clients);
                        ?>
                      </div>
                      <div class="col-md-6" style="margin-top: 15px;">
                        <div id="ocultar" hidden>
                          <div class="row" hidden>
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
                        </div>
                        <div id="mostrar">
                          <div class="form-group">
                            <label for="inputEmail1" class="col-lg-3 control-label">Cuotas</label>
                            <div class="col-lg-9">
                              <input type="number" name="cuotas" class="form-control" id="cuotas">
                            </div>
                            <label for="inputEmail1" class="col-lg-3 control-label">Plazo</label>
                            <div class="col-lg-9">
                              <input type="number" id="vencimiento" name="vencimiento" class="form-control" id="vencimiento">
                            </div>

                            <div class="col-lg-9">
                              <label for="inputEmail1" class="col-lg-3 control-label">Concepto</label>

                              <input type="text" name="concepto" class="form-control" id="concepto">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-2">
                      <label for="inputEmail1" class="col-lg-1 control-label">Agente:</label>

                      <?php
                      $agentes = AgenteData::veragentes($sucursales->id_sucursal);
                      ?>
                      <select name="agente" id="agente" id1="valor" class="form-control">
                        <!-- <option value="0">Seleccionar</option> -->
                        <?php foreach ($agentes as $agente) : ?>
                          <option value="<?php echo $agente->id_agente; ?>"><?php echo $agente->nombre_agente ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-lg-4" style="display: none;">
                      <label for="inputEmail1" class="col-lg-5 control-label">Empresa Fletera:</label>
                      <?php
                      $agentes = FleteraData::verfletera($sucursales->id_sucursal);
                      ?>
                      <input type="text" name="fletera" id="fletera" value="<?php echo $venta->fletera_id ?>" id="">

                    </div>
                    <div class="row" style="display: none;">
                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="form-group">
                            <label for="inputEmail1" class="col-lg-4 control-label">Chofer:</label>
                            <div class="col-lg-6">
                              <select name="cliente_id" id="chofer_id" class="form-control">
                                <?php
                                $choferes = ChoferData::listar($_GET['id_sucursal']);
                                foreach ($choferes as $chofer) : ?>
                                  <option value="<?php echo $chofer->id_chofer; ?>"><?php echo  $chofer->cedula . " - " . $chofer->nombre  ?></option>
                                <?php endforeach;
                                ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="inputEmail1" class="col-lg-2 control-label">Tipo de venta:</label>
                          <div class="col-lg-4">
                            <input name="metodopago" value="Contado" checked type="radio" name="" onclick="Ocultar3();"> Contado
                            <input name="metodopago" value="Credito" type="radio" name="" onclick="Mostrar3();"> Credito
                          </div>
                          <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">Fecha Venta:</label>
                            <div class="col-lg-4">
                              <input type="date" name="fecha" class="form-control" value="<?php echo date("Y-m-d"); ?>" id="fecha" placeholder="Efectivo">
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="inputEmail1" class="col-lg-2 control-label">Deposito:</label>
                          <select onchange="" class="selectpicker show-menu-arrow" data-style="form-control" data-live-search="true" id="deposito" name="deposito" class="form-control">
                            <?php
                            $deps = ProductoData::verdeposito($sucursales->id_sucursal);
                            foreach ($deps as $dep) :
                              // $tipocliente = ProductoData::listar_tipo_precio($client->id_precio);

                            ?>
                              <option value="<?php echo $dep->DEPOSITO_ID; ?>"><?php echo $dep->NOMBRE_DEPOSITO; ?></option>
                            <?php endforeach;

                            ?>
                          </select>

                        </div>
                      </div>
                    </div>
                    <div class="col-md-3" style="">
                      <div class="form-group">
                        <div class="form-group">
                          <label for="inputEmail1" class="col-lg-2 control-label">Peso neto:</label>
                          <div class="col-lg-8">
                            <input type="number" class="form-control" id="peson" value="<?php echo $venta->peso_neto ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3" style=" ">
                      <div class="form-group">
                        <div class="form-group">
                          <label for="inputEmail1" class="col-lg-2 control-label">Peso bruto:</label>
                          <div class="col-lg-8">
                            <input type="number" class="form-control" id="pesob" value="<?php echo $venta->peso_bruto ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="inputEmail1" class="col-lg-2 control-label">Codición de negociación:</label>
                        <select class="form-control" id="tipoNegociacion">
						<option value="FOB">Franco a bordo(FOB)</option>
                          <option value="CFR">Costo y flete (CFR)</option>
                          <option value="CIF">Costo, seguro y flete(CIF)</option>
                          <option value="CIP">Transporte y seguro pagados hasta(CIP)</option>
                          <option value="CPT">Transporte pagado hasta(CPT)</option>
                          <option value="DAP">Entregada en lugar convenido(DAP)</option>
                          <option value="DAT">Entregada en terminal(DAT)</option>
                          <option value="DDP">Entregada derechos pagados(DDP)</option>
                          <option value="EXW">En fábrica(EXW)</option>
                          <option value="FAS">Franco al costado del buque(FAS)</option>
                          <option value="FCA">Franco transportista(FCA)</option>
                          
                        </select>
                      </div>

                      <div class="col-md-6">
                        <label for="inputEmail1" class="col-lg-2 control-label">Numero de manifiesto:</label>
                        <input type="text" id="manifiesto" class="form-control ">
                      </div>
                    </div>

                    <?php if (isset($_GET['tid'])) { ?>
                      <div class="row">
                        <div class="col-md-6">
                          <?php $venta = VentaData::getById($_GET['tid']);
                          ?>
                          <label for="inputEmail1" class="col-lg-2 control-label">Cdc:</label>
                          <input type="text" id="cdc_fact" value="<?php echo $venta->cdc ?>" class="form-control col-lg-2">
                        </div>
                        <div class="col-md-6">
                          <label for="inputEmail1" class="col-lg-2 control-label">Remisión:</label>
                          <input type="text" id="fact" value="<?php echo $venta->factura ?>" class="form-control col-lg-2">
                        </div>
                      </div>
                    <?php } ?>
                    <!-- <div class="row" onclick="siguiente()" style="margin-top:10px">
                    <div class="form-group">
                      <div class="col-lg-4">
                        <button class="btn btn-primary">Agregar Productos </button>
                      </div>
                    </div>
                  </div> -->
                    <input type="hidden" name="simbolo2" id="simbolo2" value="<?php echo $simbolo2; ?>" class="form-control">
                    <input type="hidden" name="factura" id="num1">
                    <input type="hidden" name="numeracion_inicial" id="numinicio">
                    <input type="hidden" name="numeracion_final" id="numeracion_final">
                    <input type="hidden" name="serie1" id="serie1">
                    <input type="hidden" name="presupuesto" class="form-control" id="presupuesto" value="0">
                    <input type="hidden" name="id_configfactura" id="id_configfactura">
                    <input type="hidden" name="cambio2" id="cambio2" value="<?php echo $valores; ?>" class="form-control">
                    <input type="hidden" name="idtipomoneda" id="idtipomoneda" class="form-control">
                  </div>
                  <!-- </div> -->
                  <!-- <div id="paso2"> -->
                  <div class="">
                    <!-- <div class="box-header">
                    <i class="fa fa-laptop" style="color: orange;"></i> DATOS DE LA VENTA

                  </div>
                  <div class="col-lg-12">
                    <div id="cliente_select"></div>
                  </div>
                  <br> -->

                  </div>
                  <br>
                  <div class="box-header">
                    <i class="fa fa-laptop" style="color: orange;"></i> INGRESAR PRODUCTOS.
                    <input type="text" class="form-control" placeholder="Buscar" onchange="buscar()" onclick="buscar()" id="buscarProducto">
                  </div>
                  <table class="table table-bordered table-hover">
                    <thead>
                      <th>Codigo</th>
                      <th>Nombre</th>
                      <th>Precio unitario</th>
                      <th>Monto Cuota</th>
                      <th>Cobro</th>
                    </thead>
                    <tbody id="tablaProductos">
                    </tbody>
                  </table>
                  <h2 class="text-center">Detalle de la venta:</h2>
                  <table class="table table-bordered table-hover">
                    <thead>
                      <th>Cantidad</th>
                      <th>Codigo</th>

                      <th>Producto</th>
                      <th>Impuesto</th>
                      <th>Iva</th>
                      <th>Gravada</th>
                      <th>Deposito</th>
                      <th>Precio unitario</th>
                      <th>Precio Total</th>
                      <th>Accion</th>
                    </thead>
                    <tbody id="tablaCarrito">

                    </tbody>
                  </table>
                  <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                      <table class="table table-bordered">
                        <tr>
                          <td>
                            <p>Gravada 10%</p>
                          </td>
                          <td>
                            <p><b> <input type="text" readonly="" name="total10" id="total10" placeholder="Efectivo" value="0">
                              </b></p>
                          </td>
                          <td>IVA. 10%</td>
                          <td>
                            <p><b> <input type="text" readonly="readonly" name="iva10" id="iva10" value="0">
                        </tr>
                        <tr>
                          <td>
                            <p>Gravada 5%</p>
                          </td>
                          <td>
                            <p><b><input type="text" readonly="" name="total5" id="total5" value="0"> </b></p>
                          </td>
                          <td>IVA. 5%</td>
                          <td>
                            <p><b><input type="text" readonly="" name="iva5" id="iva5" value="0"></b>
                            </p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Exenta</p>
                          </td>
                          <td>
                            <p><b><input type="text" readonly="" name="exenta" id="exenta" value="0"> </b></p>
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
                            <p><b><input type="text" readonly="" name="total" id="txtTotalVentas" value="0"> </b></p>
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
                  <h3 id="error" class="text-center "></h3>
                  <div class="row" id="cobrardiv">
                    <div class="col-xs-12">
                      <div class="box">
                        <div class="box-body">
                          <div class="row">

                            <div class="col-md-2">Tipo:</div>
                            <div class="col-md-2">
                              <?php
                              $tipos = CajaTipo::vercajatipo2();


                              ?>
                              <select required="" onselect="tipo()" onchange="tipo()" name="tipopago_id" id="tipopago_id" id1="valor" class="form-control">
                                <!-- <option value="0">Seleccionar</option> -->
                                <?php foreach ($tipos as $tipo) :
                                  if ($tipo->id_tipo != 5) {
                                ?>

                                    <option value="<?php echo $tipo->id_tipo ?>"><?= $tipo->nombre ?></option>
                                <?php
                                  }
                                endforeach; ?>
                              </select>
                              <select required="" id="tipopago" class="form-control">
                              </select>
                              <input type="text" name="" class="form-control" placeholder="Vaucher" id="vaucher">
                            </div>
                            <div class="col-md-2">Moneda:</div>

                            <div class="col-md-2">
                              <div>
                                <?php
                                $monedas = MonedaData::cboObtenerValorPorSucursal($_GET['id_sucursal']);
                                $cambios = MonedaData::obtenerCambioMonedaPorSimbolo($_GET['id_sucursal'], "US$");
                                $cambio1 = $cambios[0]->valor2;

                                $cambios2 = MonedaData::obtenerCambioMonedaPorSimbolo($_GET['id_sucursal'], "₲");

                                $cambio2 = $cambios2[0]->valor2;

                                $cambio = $cambio2;

                                ?>
                                <select required="" name="tipomoneda_id2" id="tipomoneda_id2" id1="valor" class="form-control" oninput="tipocambio()">
                                  <?php
                                  $i = 0;
                                  foreach ($monedas as $moneda) : ?>
                                    <?php
                                    $valocito = null;
                                    $i++;
                                    if ($i == 1) {
                                    ?>
                                      <option selected value="<?php echo $moneda->id_tipomoneda; ?>"><?php echo $moneda->nombre . "-" . $moneda->simbolo; ?></option>
                                    <?php } else {

                                    ?>
                                      <option value="<?php echo $moneda->id_tipomoneda; ?>"><?php echo $moneda->nombre . "-" . $moneda->simbolo; ?></option>
                                  <?php
                                    }

                                  endforeach; ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-2">Monto:</div>
                            <div class="col-md-2"><input type="number" name="" value="0" class="form-control" id="monto"></div>
                            <div class="col-md-2"><button class="btn btn-info" onclick="agregarPago()">Agregar</button></div>
                          </div>
                          <div class="row">
                            <?php
                            $isventa = false;

                            // $cobros = new CobroCabecera();
                            // $cobro = $cobros->getCobro($_GET['id_cobro']);
                            // $cobror = $cobro->TOTAL_COBRO;
                            // $cliente = $cobro->CLIENTE_ID;

                            // var_dump($cobro);
                            ?>
                            <table class="table table-bordered table-hover">
                              <thead>
                                <th>Metodo de pago</th>

                                <th>Tipo</th>
                                <th>Vaucher</th>
                                <th>Importe</th>
                                <th>Importe Convertido</th>

                                <th>Moneda</th>
                                <th>Cambio Moneda</th>
                                <th>Acción</th>
                              </thead>
                              <tbody id="tbody">

                              </tbody>
                            </table>
                          </div>
                          <div class="row">
                          </div>
                          <div class="row">
                            <div class="col-md-2">Total Guaranies</div>
                            <div class="col-md-4" id="total"></div>
                            <div class="col-md-2">Total a cobrar</div>
                            <div class="col-md-2" id="cobror"></div>
                            <!-- <div class="col-md-2">
                        <button id="pagar" onclick="pagar()" class="btn btn-info">Pagar</button>
                      </div> -->

                          </div>
                          <form action="" method="post"></form>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-offset-2">
                      <div class="checkbox">
                        <label>
                          <input type="hidden" name="sucursal_id" id="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
                          <!-- <input type="hidden" value="<?php echo $q1; ?>" id="stock_trans" name="stock_trans" /> -->
                          <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                          <a href="index.php?action=eliminarcompraproductos1&id_sucursal=<?php echo $sucursales->id_sucursal; ?>" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                          <button id="accion" class="btn btn-lg btn-warning" onclick="accion()"><b></b> Finalizar Venta</button></label>
                      </div>
                    </div>
                  </div>
                  <!-- </div> -->



                </div>
              </div>
            </div>
            <section class="content">



            </section>
        </section>
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <label for="">Cantidad</label>
                <input type="number" id="canEdit" placeholder="Cantidad">
                <label for="">Precio</label>
                <input type="number" id="preEdit" placeholder="Precio">

              </div>
              <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-danger" onclick="dismiss()">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="edita()">Guardar cambios</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php endif;
  endif;

  if (isset($_GET['tid'])) { ?>
    <script type="text/javascript">
      console.log("222222222222222222");
      var idr = "<?php echo $_GET['tid'] ?>";
      $.ajax({
        url: 'index.php?action=obtenercarrito&tid=',
        type: 'GET',
        data: {
          tid: idr,
          sucursal: "<?php echo $_GET['id_sucursal']; ?>"
        },
        dataType: 'json',
        success: function(json) {
          console.log("222", json);
          // $("#cliente_id").val(json[0]["cliente"]);

          // setmoneda(json[0]["moneda"]);
          // $("#tipomoneda_id").val(json[0]["moneda"]);
          $("#remision_id").val(idr);
          for (var i = 0; i < json.length; i++) {
            console.log(',prod', json[i]);
            agregaTabla(json[i]["producto"]["id_producto"],
              json[i]["producto"]["codigo"], json[i]["producto"]["impuesto"], json[i]["precio"],
              json[i]["producto"]["nombre"], json[i]["cantidadc"], json[i]["tipo"], json[i]["cantidad"], json[i]["producto"]["precio_compra"], json[i]["deposito"], json[i]["depositotext"])

          }
        },
        error: function(xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });
      $.ajax({
        url: 'index.php?action=obtenercarrito&tid=',
        type: 'GET',
        data: {
          tid: idr,
          sucursal: "<?php $_GET['id_sucursal']; ?>"
        },
        dataType: 'json',
        success: function(json) {
          console.log("222", json);

        },
        error: function(xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });
    </script>
  <?php
  } else { ?>
    <script type="text/javascript">
      $("#remision_id").val(0);
    </script>
  <?php
  };
  ?>

  <script>

  </script>
  <script>
    var pagos = [];
    var totalCobrar = 0;
    var tablaCobro = [];
    $("#tipopago").hide();
    var totalCobro = $("#cobror").html();
    var cambio = parseFloat($("#cambio2").val());
    $("#total").html(totalCobro);
    $("#pagar").hide();
    $("#vaucher").hide();
    var totalACobrar = 0;
    // $("#total2").html(totalCobro);
    var select = "";

    var carrito = [];
    var total = 0;
    var grabada10 = 0;
    var grabada5 = 0;
    var exenta = 0;
    var iva10 = 0;
    var iva5 = 0;
    var idPro = 0;
    var id = "";
    var tablab = "";
    var diferencia = 0;
    var numeracion_final = 0;
    var serie1 = 0;
    var tipomoneda = 0;
    var id_configfactura = 0;
    var idtipomoneda = 0;
    var simbolo = "";
    var tipocliente = 0;
    var cobroId = 0;
    var moneda_principal_global = $("#tipomoneda_id").val();
    var valor_configmasiva_global = $("#cantidaconfigmasiva").val();
    // if ("<?php echo isset($_GET['tid']) ?>") {
    $("#paso2").hide();
    var tipoe = "";
    // moneda();
    clienteTipo()


    function pagar() {

      $.ajax({
        url: 'index.php?action=cobrocaja',
        type: 'POST',
        data: {
          pagos: pagos,
          total: totalACobrar,
          sucursal: '<?= $_GET['id_sucursal'] ?>',
          cliente: $("#cliente_id").val(),
          cobro: cobroId

        },
        dataType: 'json',
        success: function(json) {

          // window.location.href = "impresioncobro.php?cobro=" + cobroId;

        },
        error: function(xhr, status) {
          console.log("Ha ocurrido un error." + JSON.stringify(xhr));
        }
      });


    }

    function actualizarTablacobro() {
      tabla = "";
      for (const [id, pago] of Object.entries(pagos)) {
        tabla += `<tr><td> ${pago.tipo}</td><td> ${pago.tipo_tar2}</td><td> ${pago.vaucher}</td><td> ${pago.monto}</td><td> ${pago.monto2}</td>
                        <td> ${pago.moneda}</td><td> ${pago.cambio}</td><td> <button class="btn btn-danger" onclick="eliminarcobro(${id})">Eliminar</button></td></tr>`;
      }
      $("#tbody").html(tabla);


      if (totalCobrar > totalACobrar) {
        $("#pagar").show();
        $("#total").html(totalCobrar + " Vuelto: " + parseInt(totalCobrar - totalACobrar).toLocaleString("es-ES"));
        $("#monto").val(0);
      } else {

        $("#total").html(totalCobrar + " Restante: " + parseInt(totalACobrar - totalCobrar).toLocaleString("es-ES"));
        $("#pagar").hide();
      }
    }
    actualizarTablacobro()

    function agregarPago() {
      tabla = "";
      console.log($('select[name="tipomoneda_id"] option:selected').text(), 'aa');
      if ($("#tipopago_id").val() == 4) {
        if ($('select[name="tipomoneda_id2"] option:selected').text().includes('$')) {
          totalCobrar += parseFloat($('#monto').val()) * cambio;
          pagos.push({
            "tipo_id": $('#tipopago_id').val(),
            "cambio": cambio,
            "moneda_id": $('#tipomoneda_id2').val(),
            "tipo": $('select[name="tipopago_id"] option:selected').text(),
            "moneda": $('select[name="tipomoneda_id2"] option:selected').text(),
            "monto2": parseFloat($('#monto').val()) * cambio,
            "monto": parseFloat($('#monto').val()),
            "cambio": cambio,
            "tipo_tar": $('#tipopago').val(),
            "tipo_tar2": $('select[name="tipopago"] option:selected').text(),
            "vaucher": $("#vaucher").val()

          });
        } else {
          totalCobrar += parseFloat($('#monto').val());
          pagos.push({
            "tipo_id": $('#tipopago_id').val(),
            "cambio": '1',
            "moneda_id": $('#tipomoneda_id2').val(),
            "tipo": $('select[name="tipopago_id"] option:selected').text(),
            "moneda": $('select[name="tipomoneda_id2"] option:selected').text(),
            "monto": $('#monto').val(),
            "monto2": $('#monto').val(),
            "cambio": '1',
            "tipo_tar": $('#tipopago').val(),
            "tipo_tar2": $('select[name="tipopago"] option:selected').text(),
            "vaucher": $("#vaucher").val()
          });
        }
      } else {
        if ($('select[name="tipomoneda_id2"] option:selected').text().includes('$')) {
          totalCobrar += parseFloat($('#monto').val()) * cambio;
          pagos.push({
            "tipo_id": $('#tipopago_id').val(),
            "cambio": cambio,
            "moneda_id": $('#tipomoneda_id2').val(),
            "tipo": $('select[name="tipopago_id"] option:selected').text(),
            "moneda": $('select[name="tipomoneda_id2"] option:selected').text(),
            "monto2": parseFloat($('#monto').val()) * cambio,
            "monto": parseFloat($('#monto').val()),
            "cambio": cambio,
            "tipo_tar": 0,
            "tipo_tar2": "",
            "vaucher": ""
          });
        } else {
          totalCobrar += parseFloat($('#monto').val());
          pagos.push({
            "tipo_id": $('#tipopago_id').val(),
            "cambio": '1',
            "moneda_id": $('#tipomoneda_id2').val(),
            "tipo": $('select[name="tipopago_id"] option:selected').text(),
            "moneda": $('select[name="tipomoneda_id2"] option:selected').text(),
            "monto": $('#monto').val(),
            "monto2": $('#monto').val(),
            "cambio": '1',
            "tipo_tar": 0,
            "tipo_tar2": "",
            "vaucher": ""

          });
        }
      }


      actualizarTablacobro()
      $('#monto').val("0");
    }

    function eliminarcobro(id) {
      var resta = parseInt(pagos[id]['monto2']);
      totalCobrar = totalCobrar - resta;
      pagos.splice(id, 1);
      actualizarTablacobro()
    }

    function tipometodo() {

      if ($("#tipopago_id").val() == 4) {
        $("#tipopago").show();
        $("#vaucher").show();

        select = "";
        $.ajax({
          url: 'index.php?action=tipocaja',
          type: 'GET',
          data: {},
          dataType: 'json',
          success: function(json) {
            console.log(json)
            for (var i = 0; i < json.length; i++) {
              select += `<option value="${json[i].id_procesadora}">${json[i].nombre}</option> `


            }
            $("#tipopago").html(select);
          },
          error: function(xhr, status) {
            console.log("Ha ocurrido un error.");
          }
        });
      } else {
        tipopago = ""
        $("#tipopago").hide();
        $("#vaucher").hide();

      }
    }

    function Ocultar3() {
      document.getElementById('mostrar').style.display = 'none';
      document.getElementById('cobrardiv').style.display = 'block';
      document.getElementById('ocultar').style.display = 'block';
      $("#cuotas").val(0);
      $("#vencimiento").val(0);
    }
    Ocultar3();

    function Mostrar3() {
      $("#cuotas").val(1);
      $("#vencimiento").val(30);
      document.getElementById('mostrar').style.display = 'block';
      document.getElementById('ocultar').style.display = 'none';
      document.getElementById('cobrardiv').style.display = 'none';
    }

    function id_cobro() {
      $.ajax({
        url: 'index.php?action=obtenercobroid',
        type: 'GET',
        data: {},
        dataType: 'json',
        success: function(json) {
          cobroId = json

        },
        error: function(xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });
    }

    function tipo() {

      if ($("#tipopago_id").val() == 4) {
        $("#tipopago").show();
        $("#vaucher").show();

        select = "";
        $.ajax({
          url: 'index.php?action=tipocaja',
          type: 'GET',
          data: {},
          dataType: 'json',
          success: function(json) {
            console.log(json)
            for (var i = 0; i < json.length; i++) {
              select += `<option value="${json[i].id_procesadora}">${json[i].nombre}</option> `


            }
            $("#tipopago").html(select);
          },
          error: function(xhr, status) {
            console.log("Ha ocurrido un error.");
          }
        });
      } else if ($("#tipopago_id").val() == 5) {
        $("#tipopago").hide();
        $("#vaucher").hide();
      } else {
        tipopago = ""
        $("#tipopago").hide();
        $("#vaucher").hide();

      }
    }


    function siguiente() {
      if ($("#configfactura_id").val()) {
        $("#paso2").show();

        $("#paso1").hide();
        console.log($('select[name="cliente_id"] option:selected').text())
        var isRemision = "";
        if ($("#remision_id").val() != 0) {
          isRemision = ", Remision # " + $("#remision_id").val();
        } else {}
        $("#cliente_select").html(`<h4>Cliente: ${$('select[name="cliente_id"] option:selected').text()} </h4><h4>Moneda: ${$('select[name="tipomoneda_id"] option:selected').text()} </h4><h4>tipo de venta: ${$('input[name="metodopago"]:checked').val()} </h4><h4> ${$('select[name="configfactura_id"] option:selected').text()} ${isRemision}</h4>`)
      }
      clienteTipo()
    }

    function moneda() {
      if (moneda_principal_global == "US$") { //dolar
        document.ready = document.getElementById("tipomoneda_id2").value = '0';
        console.log("$")
        $.ajax({
          url: 'index.php?action=consultamoneda',
          type: 'POST',
          cache: false,
          data: {
            sucursal: $("#sucursal_id").val(),
            simbolo: moneda_principal_global, //simbolo
            accion: "obtenerCambioPorSimbolo"
          },
          dataType: 'json',
          success: function(json) {
            $("#cambio").val(json[0].valor);
            valor_dolar_global = json[0].valor;
            ajaxConfigMasiva("₲");
            $("#tipomoneda_id2").val(parseInt(json[0].id_tipomoneda));

          },
          error: function(xhr, status) {
            console.log("Ha ocurrido un error.");
          }
        });
      } else if (moneda_principal_global == "₲") { //guaranies
        console.log("$22")

        $.ajax({
          url: 'index.php?action=consultamoneda',
          type: 'POST',
          cache: false,

          data: {
            sucursal: $("#sucursal_id").val(),
            simbolo: moneda_principal_global, //simbolo
            accion: "obtenerCambioPorSimbolo"
          },
          dataType: 'json',
          success: function(json) {
            valor_guaranies_global = json[0].valor;
            // idtipomoneda = json[0].id_tipomoneda;
            $("#cambio").val(json[0].valor);
            ajaxConfigMasiva("US$");
            $("#tipomoneda_id2").val(parseInt(json[0].id_tipomoneda));

          },
          error: function(xhr, status) {
            console.log("Ha ocurrido un error.");
          }
        });
      }
    }


    id_cobro();

    function actualizarTabla() {
      tabla = "";
      total = 0;
      grabada10 = 0;
      grabada5 = 0;
      exenta = 0;
      iva10 = 0;
      iva5 = 0;

      for (const [id, cart] of Object.entries(carrito)) {
        tabla += `<tr><td hidden > ${cart.tipo}</td><td> ${cart.cantidad}</td><td id="${id}1"> ${cart.codigo}</td><td id="${id}3"> ${cart.producto}</td><td id="${id}2"> ${cart.impuesto}</td><td > ${cart.iva}</td><td > ${cart.grabada}</td><td > ${cart.depositotext}</td><td> ${cart.precio}</td><td> ${cart.preciot}</td><td> <button class="btn btn-danger"  onclick="eliminar(${id})">Eliminar</button><button class="btn btn-warning" onclick="editar('${cart.id}',${cart.cantidad},${cart.precio},'${cart.tipo}',${cart.stock},${cart.precioc},'${cart.impuesto}','${cart.producto}','${cart.codigo}',${id},'${cart.deposito}','${cart.depositotext}')">Editar</button></td></tr>`;
        if (cart.impuesto == 10) {
          iva10 += parseFloat(cart.iva);
          grabada10 += parseFloat(cart.grabada);
        } else if (cart.impuesto == 5) {
          iva5 += parseFloat(cart.iva);
          grabada5 += parseFloat(cart.grabada);
        } else if (cart.impuesto == 30 || cart.impuesto == "Iva 30 Exenta 70") {
          iva5 += parseFloat(cart.iva);
          exenta += parseFloat(cart.exenta);
          grabada5 += parseFloat(cart.grabada);
        } else if (cart.impuesto == 0) {
          exenta = cart.preciot;
        }
        console.log('sssssssd', cart.impuesto)
        console.log('sss', total);
        total += parseFloat(cart.preciot);
      }
      // grabada10 = grabada10.toFixed(4);
      // grabada5 = grabada5.toFixed(4);
      // iva10 = iva10.toFixed(4);
      // iva5 = iva5.toFixed(4);
      $("#tablaCarrito").html(tabla);
      $("#txtTotalVentas").val(parseFloat(total).toFixed(2));
      if ($("#tipomoneda_id").val() == "US$") {
        $("#cobror").html(parseFloat(total * $("#cambio2").val()).toLocaleString("es-ES"));
        totalACobrar = parseFloat(total * $("#cambio2").val())
        // US$
      } else {

        $("#cobror").html(parseFloat(total).toLocaleString("es-ES"));
        totalACobrar = parseFloat(total)

      }
      $("#total10").val(parseFloat(grabada10).toFixed(2));
      $("#total5").val(parseFloat(grabada5).toFixed(2));
      $("#iva5").val(parseFloat(iva5).toFixed(2));
      $("#iva10").val(parseFloat(iva10).toFixed(2));

      $("#exenta").val(parseFloat(exenta).toFixed(2));
      if ($('select[name="tipomoneda_id"] option:selected').text().includes("US$")) {
        $("#monto").val(parseFloat(total));
      } else {
        $("#monto").val(parseFloat(total));
      }
      actualizarTablacobro()
    }


    function clienteTipo() {
      $.ajax({
        url: 'index.php?action=buscarcliente',
        type: 'GET',
        data: {
          id: $("#cliente_id").val()
        },
        dataType: 'json',
        success: function(json) {
          console.log(json)
          tipocliente = json.id_precio;
          console.log(tipocliente)
          // carrito = []
          actualizarTabla()
        },
        error: function(xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });

    }

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
          numeracion_final = json[0].numeracion_final;
          serie1 = json[0].serie1;
          id_configfactura = json[0].id_configfactura;
          diferencia = json[0].diferencia;
          factura_no = numeracion_final - diferencia;
          if (factura_no >= 1 && factura_no < 10) {
            factura_no = "000000" + factura_no;
          } else if (factura_no >= 10 && factura_no < 100) {
            factura_no = "00000" + factura_no;
          } else if (factura_no >= 100 && factura_no < 1000) {
            factura_no = "0000" + factura_no;
          } else if (factura_no >= 1000 && factura_no < 10000) {
            factura_no = "000" + factura_no;
          } else if (factura_no >= 10000 && factura_no < 100000) {
            factura_no = "00" + factura_no;
          } else if (factura_no >= 100000 && factura_no < 1000000) {
            factura_no = "0" + factura_no;
          }
          $("#facturan").val(serie1 + '-' + factura_no);
        },
        error: function(xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });

    }
    configFactura()

    function accion() {
      $("#accion").prop('disabled', true);
      if ($("#cliente_id").val() == 0) {
        $("#accion").prop('disabled', false);

        // $("#error").text("Agregue productos al carrito")
        Swal.fire({
          title: "Seleccione un cliente valido",
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
        return;
      }
      if (carrito.length == 0) {
        $("#accion").prop('disabled', false);

        // $("#error").text("Agregue productos al carrito")
        Swal.fire({
          title: "Agregue productos al carrito",
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
        return;
      }

      console.log(simbolo)
      if ($('input[name="metodopago"]:checked').val() == "Contado") {
        if (pagos.length == 0) {
          $("#accion").prop('disabled', false);

          Swal.fire({
            title: "Agregue metodo de pago",
            icon: 'error',
            confirmButtonText: 'Aceptar'
          });
          // $("#error").text("Agregue Metodo de pago")
          return;
        }
        pagar();
      }

      console.log($("#cambio").val())
      if (simbolo == "US$") {
        if ($("#cambio").val() == "1") {
          $("#cantidaconfigmasiva").val(valor_configmasiva_global / $("#cambio2").val());
        } else {
          $("#cantidaconfigmasiva").val(valor_configmasiva_global / $("#cambio").val());
        }


      } else if (simbolo == "₲") {
        $("#cantidaconfigmasiva").val(valor_configmasiva_global);

      }
      console.log($("#cantidaconfigmasiva").val())

      // moneda();
      // console.log(carrito);
      // setTimeout(function() {




      $.ajax({
        url: "index.php?action=procesoventaproductoexportacion",
        type: "POST",
        data: {
          cart: carrito,
          tablaCobro: pagos,
          tipoventa: $("#tipoventa").val(),
          numeracion_final: numeracion_final,
          diferencia: diferencia,
          configfactura_id: $("#configfactura_id").val(),
          presupuesto: $("#presupuesto").val(),
          serie1: serie1,
          iva10: iva10,
          iva5: iva5,
          exenta: exenta,
          total: parseFloat(total).toFixed(2),
          cambio: $("#cambio").val(),
          cambio2: $("#cambio2").val(),
          fecha: $("#fecha").val(),
          id_configfactura: id_configfactura,
          total5: $("#total5").val(),
          total10: $("#total10").val(),
          sucursal_id: $("#sucursal_id").val(),
          total10: grabada10,
          total5: grabada5,
          simbolo2: $("#simbolo2").val(),
          codigo: 0,
          stock_trans: 0,
          idtipomoneda: idtipomoneda,
          cantidaconfigmasiva: $("#cantidaconfigmasiva").val(),
          metodopago: $('input[name="metodopago"]:checked').val(),
          formapago: $('input[name="formapago"]:checked').val(),
          remision_id: $("#remision_id").val(),
          vencimiento: $("#vencimiento").val(),
          cliente_id: $("#cliente_id").val(),
          concepto: $("#concepto").val(),
          vencimiento: $("#vencimiento").val(),
          cuotas: $("#cuotas").val(),
          is_oficiall: 1,
          vaucher: $("#vaucher").val(),
          tipo_id: $('#tipopago_id').val(),
          tipo_tar: $('#tipopago').val(),
          facturan: $('#facturan').val(),
          num_fact: $('#fact').val(),
          cdc_fact: $("#cdc_fact").val(),
          agente: $("#agente").val(),
          fletera: $("#fletera").val(),
          chofer_id: $("#chofer_id").val(),
          condiNego: $("#tipoNegociacion").val(),
          manifiesto: $("#manifiesto").val(),
          pesob: $("#pesob").val(),
          peson: $("#peson").val(),
        },
        success: function(dataResult) {
          console.log(dataResult[0]);
          console.log(dataResult[0].success);
          if (dataResult.includes("<")) {
            $("#accion").prop('disabled', false);
            alert("Error al hacer venta");
          } else {
            if ($("#remision_id").val() == 0) {

              if (dataResult == -1) {
                $("#accion").prop('disabled', false);

                alert("Error, producto insuficiente");
              } else {
                alert("Venta realizada con exito");
                // if ($('input[name="metodopago"]:checked').val() == "Contado") {
                //   window.location.href = "index.php?view=metodopago&id_sucursal=" + $("#sucursal_id").val() + "&id_cobro=" + dataResult
                // } else {

                // a detalle
                // window.location.href = "index.php?view=detalleventaproducto&success=venta&id_venta=" + dataResult
                window.location.href = "index.php?view=envioporlote&id_sucursal=<?php echo $_GET['id_sucursal'] ?>";
                // }
              }

            } else {
              //if (dataResult == -1) {
              //alert("Error, producto insuficiente");
              // } else {
              alert("Venta de remision realizada con exito");
              window.location.href = "index.php?view=envioexportacion&id_sucursal=<?php echo $_GET['id_sucursal'] ?>";
              // window.location.href = "index.php?view=detalleventaproducto&success=venta&id_venta=" + dataResult
              // window.location.href = "index.php?view=remision2&id_sucursal=" + $("#sucursal_id").val()
              // window.location.href = "index.php?view=metodopago&id_sucursal=" + $("#sucursal_id").val() + "&id_cobro=" + dataResult
              //}
            }
          }

          try {


          } catch (e) {

          }
        }
      });






      // }, 1000);
      $("#accion").prop('disabled', false);
    }
    var stockE = 0;
    tipocambio()
    var precioE = 0;
    var idE = 0;
    var impuE = 0;
    var proE = "";
    var codE = "";
    var depE = "";
    var depositoE = "";

    function eliminar(ide) {
      carrito.splice(ide, 1);
      actualizarTabla()
    }

    function dismiss() {
      $('#editModal').modal("hide");
    }

    function edita() {
      console.log("a", depE);
      agregaTabla(idE, codE,
        impuE, $(`#preEdit`).val(),
        proE, $(`#canEdit`).val(), tipoe, stockE, depositoE, depE, depositoE);
      eliminar(idElimina)
      $('#editModal').modal("hide");
    }
    var idElimina = 0;

    function editar(idp, cant, pre, tipo, stock, precio, impuesto, producto, codigo, id, dep, deposito) {
      idE = idp;
      codE = codigo;
      impuE = impuesto
      stockE = stock;
      tipoe = tipo;
      precioE = precio
      proE = producto
      idElimina = id;
      depE = dep;
      depositoE = deposito;
      console.log('', depositoE);
      $("#canEdit").val(cant);
      $("#preEdit").val(pre);
      $('#editModal').modal({
        show: true
      });
    }



    function agregar(id, codigo, impuesto, precio, producto, tipo, stock, precioc) {
      if (carrito.some(item => item.id === id)) {
        Swal.fire({
          title: "Ya posee este producto agregado",
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
      } else {
        console.log($('#a' + id).val());
        agregaTabla(id, codigo, impuesto, $('#a' + id).val(), producto, 1, tipo, stock, precioc, $("#deposito").val(), $('select[name="deposito"] option:selected').text());
        tablab = "";
        $('#buscarProducto').val("");
        $("#tablaProductos").html(tablab);
      }
    }


    function agregaTabla(id, codigo, impuesto, precio, producto, cant, tipo, stock, precioc, dep, deposito) {
      var iva = 0;
      var grabada = 0;
      var input = parseFloat(cant);
      console.log(id + " " + codigo + " " + impuesto + " " + precio + " " + producto + " " + cant + " " + tipo + " " + stock + " " + precioc)

      var totalcart = input * parseFloat(precio);
      if (impuesto == 30 || impuesto == "Iva 30 Exenta 70") {
        var prec = (input * parseFloat(precio));
        iva = (prec * 0.3);
        exenta = (prec / 101.5 * 70);
        iva = (input * parseFloat(precio) / 101.5) * 1.5;
        grabada = (input * parseFloat(precio) / 101.5) * 30;

        carrito.push({
          cantidad: parseFloat(cant),
          codigo: codigo,
          impuesto: "Iva 30 Exenta 70",
          iva: parseFloat(iva).toFixed(4),
          grabada: parseFloat(grabada).toFixed(4),
          precio: parseFloat(precio).toFixed(2),
          producto: producto,
          preciot: parseFloat(totalcart).toFixed(2),
          id: id,
          tipo: tipo,
          stock: parseFloat(stock).toFixed(2),
          precioc: parseFloat(precioE).toFixed(2),
          deposito: dep,
          depositotext: deposito,
          exenta: exenta
        })
      } else {
        var impu = parseInt(impuesto);
        if (impu == 10) {

          iva = (input * parseFloat(precio)) / 11;
          grabada = (input * parseFloat(precio)) / 1.1;
        } else if (impu == 5) {
          iva = (input * parseFloat(precio)) / 21;
          grabada = (input * parseFloat(precio)) / 1.05;
        }
        carrito.push({
          cantidad: parseFloat(cant),
          codigo: codigo,
          impuesto: parseFloat(impuesto),
          iva: parseFloat(iva).toFixed(4),
          grabada: parseFloat(grabada).toFixed(4),
          precio: parseFloat(precio).toFixed(2),
          producto: producto,
          preciot: parseFloat(totalcart).toFixed(2),
          id: id,
          tipo: tipo,
          stock: parseFloat(stock).toFixed(2),
          precioc: parseFloat(precioE).toFixed(2),
          deposito: dep,
          depositotext: deposito
        })
      }
      total += totalcart;
      console.log('cart', carrito)
      actualizarTabla();
    }

    function buscar() {
      tablab = "";

      $.ajax({
        url: "index.php?action=buscarproducto",
        type: "GET",
        data: {
          buscar: $('#buscarProducto').val(),
          sucursal: $("#sucursal_id").val(),
          deposito: $("#deposito").val(),
          tipocliente: tipocliente,
          cliente: $("#cliente_id").val(),
          moneda: idtipomoneda,
        },
        cache: false,
        success: function(dataResult) {
          var result = JSON.parse(dataResult);
          for (const [id, data_1] of Object.entries(result)) {
            if (data_1["producto"]['activo'] == 1) {
              tablab += `<tr>
        <td> ${data_1["producto"]['codigo']}</td>
        <td> ${data_1["producto"]['nombre']}</td>
        <td>${data_1["producto"]['saldo']} </td>
        <td>${data_1["producto"]["precio_venta"]}</td> 
    `;
              if (data_1['tipo'] != 'Servicio') {
                tablab += `    <td><input value="0" max="${parseInt(data_1["cantidad"])}" type="number" id="a${data_1["producto"]["id_producto"]}" class="form-control"> <button 
                onclick="agregar(${data_1["producto"]["id_producto"]},'${data_1["producto"]['codigo']}','${data_1["producto"]['impuesto']}','${data_1["producto"]["precio_venta"]}',' ${data_1["producto"]['nombre']}','${data_1["tipo"]}',1,${parseInt(data_1["producto"]["precio_compra"])})" class="btn btn-info">Agregar</button></td>
        </tr>`;
              } else if (
                data_1['tipo'] == 'Servicio') {
                tablab += `    <td><input value="0" type="number" id="a${data_1["producto"]["id_producto"]}" class="form-control"> <button 
                onclick="agregar(${data_1["producto"]["id_producto"]},'${data_1["producto"]['codigo']}','${data_1["producto"]['impuesto']}','${data_1["precio"]}',' ${data_1["producto"]['nombre']}','${data_1["tipo"]}',${parseInt(data_1["cantidad"])},${parseInt(data_1["producto"]["precio_compra"])})" class="btn btn-info">Agregar</button></td>
        </tr>`;
              } else {
                tablab += `    <td></td>
        </tr>`;
              }
            }
          }
          $("#tablaProductos").html(tablab);
        }
      });
    }

    function tipocambio() {
      ajaxConvertirValoresTotales($("#tipomoneda_id").val());
      if ($('select[name="tipomoneda_id2"] option:selected').text().includes("US$") && $('select[name="tipomoneda_id"] option:selected').text().includes("US$")) {
        $("#monto").val(parseFloat(total));
      } else if ($('select[name="tipomoneda_id2"] option:selected').text().includes("₲") && $('select[name="tipomoneda_id"] option:selected').text().includes("₲")) {
        $("#monto").val(parseFloat(total));
        // $("#tipomoneda_id2").val('"₲');
      } else if ($('select[name="tipomoneda_id2"] option:selected').text().includes("US$") && $('select[name="tipomoneda_id"] option:selected').text().includes("₲")) {
        $("#monto").val(parseFloat(total / $("#cambio2").val()));
        // $("#tipomoneda_id2").val("₲");

      } else {
        $("#monto").val(parseFloat(total * $("#cambio2").val()));
      }
      moneda();

    }

    function ajaxOperacionTotales(simbolo$) {
      // $.ajax({
      //   url: 'index.php?action=consultamoneda',
      //   type: 'POST',
      //   cache: false,

      //   data: {
      //     sucursal: $("#sucursal_id").val(),
      //     simbolo: simbolo$, //simbolo
      //     accion: "obtenerCambioPorSimbolo"
      //   },
      //   dataType: 'json',
      //   success: function(json) {
      //     const cambio = json[0].valor;
      //     if (moneda_principal_global == "US$") { //dolar
      //       if (simbolo$ == "₲") {
      //         for (let i = 0; i < total_registros_tabla; i++) {
      //           $("#precio_venta_" + (i + 1)).val(format(($("#precio_venta_hidden_" + (i + 1)).val() * cambio).toFixed(4)));




      //           $("#precio_total_" + (i + 1)).val(format(($("#precio_total_hidden_" + (i + 1)).val() * cambio).toFixed(4)));
      //           $("#iva_" + (i + 1)).html(format(($("#iva_hidden_" + (i + 1)).val() * cambio).toFixed(4)));
      //           $("#gravada_" + (i + 1)).html(format(($("#gravada_hidden_" + (i + 1)).val() * cambio).toFixed(4)));
      //         }
      //         $("#iva10").val(format((total_iva10 * cambio).toFixed(4)));
      //         $("#iva5").val(format((total_iva5 * cambio).toFixed(4)));
      //         $("#total10").val(format((total_gravada10 * cambio).toFixed(4)));
      //         $("#total5").val(format((total_gravada5 * cambio).toFixed(4)));
      //         $("#exenta").val(format((total_exenta * cambio).toFixed(4)));
      //         $("#txtTotalVentas").val(format((total_ventas * cambio).toFixed(4)));
      //       } else {
      //         for (let i = 0; i < total_registros_tabla; i++) {
      //           $("#precio_venta_" + (i + 1)).val(format($("#precio_venta_hidden_" + (i + 1)).val()));



      //           $("#precio_total_" + (i + 1)).val(format($("#precio_total_hidden_" + (i + 1)).val()));
      //           $("#iva_" + (i + 1)).html(format($("#iva_hidden_" + (i + 1)).val()));
      //           $("#gravada_" + (i + 1)).html(format($("#gravada_hidden_" + (i + 1)).val()));
      //         }
      //         $("#iva10").val(format(total_iva10));
      //         $("#iva5").val(format(total_iva5));
      //         $("#total10").val(format(total_gravada10));
      //         $("#total5").val(format(total_gravada5));
      //         $("#exenta").val(format(total_exenta));
      //         $("#txtTotalVentas").val(format(total_ventas));
      //       }
      //     } else if (moneda_principal_global == "₲") { //guaranies
      //       if (simbolo$ == "US$") {
      //         for (let i = 0; i < total_registros_tabla; i++) {
      //           $("#precio_venta_" + (i + 1)).val(format(($("#precio_venta_hidden_" + (i + 1)).val() / cambio).toFixed(4)));



      //           $("#precio_total_" + (i + 1)).val(format(($("#precio_total_hidden_" + (i + 1)).val() / cambio).toFixed(4)));
      //           $("#iva_" + (i + 1)).html(format(($("#iva_hidden_" + (i + 1)).val() / cambio).toFixed(4)));
      //           $("#gravada_" + (i + 1)).html(format(($("#gravada_hidden_" + (i + 1)).val() / cambio).toFixed(4)));
      //         }
      //         $("#iva10").val(format((total_iva10 / cambio).toFixed(4)));
      //         $("#iva5").val(format((total_iva5 / cambio).toFixed(4)));
      //         $("#total10").val(format((total_gravada10 / cambio).toFixed(4)));
      //         $("#total5").val(format((total_gravada5 / cambio).toFixed(4)));
      //         $("#exenta").val(format((total_exenta / cambio).toFixed(4)));
      //         $("#txtTotalVentas").val(format((total_ventas / cambio).toFixed(4)));
      //       } else {
      //         for (let i = 0; i <script total_registros_tabla; i++) {
      //           $("#precio_venta_" + (i + 1)).val(format($("#precio_venta_hidden_" + (i + 1)).val()));



      //           $("#precio_total_" + (i + 1)).val(format($("#precio_total_hidden_" + (i + 1)).val()));
      //           $("#iva_" + (i + 1)).html(format($("#iva_hidden_" + (i + 1)).val()));
      //           $("#gravada_" + (i + 1)).html(format($("#gravada_hidden_" + (i + 1)).val()));
      //         }
      //         $("#iva10").val(format(total_iva10));
      //         $("#iva5").val(format(total_iva5));
      //         $("#total10").val(format(total_gravada10));
      //         $("#total5").val(format(total_gravada5));
      //         $("#exenta").val(format(total_exenta));
      //         $("#txtTotalVentas").val(format(total_ventas));
      //       }
      //     }
      //   },
      //   error: function(xhr, status) {
      //     console.log("Ha ocurrido un error.");
      //   }
      // });
    }

    function ajaxConfigMasiva(simbolo$) {
      // console.log("masiva")
      // $.ajax({
      //   url: 'index.php?action=consultamoneda',
      //   type: 'POST',
      //   cache: false,

      //   data: {
      //     sucursal: $("#sucursal_id").val(),
      //     simbolo: simbolo$, //simbolo
      //     accion: "obtenerCambioPorSimbolo"
      //   },
      //   dataType: 'json',
      //   success: function(json) {
      //     const cambio_valor = json[0].valor;

      //     console.log(json)
      //     if (moneda_principal_global == "US$") {
      //       $("#cantidaconfigmasiva").val(valor_configmasiva_global / cambio_valor);
      //     } else if (moneda_principal_global == "₲") {
      //       $("#cantidaconfigmasiva").val(valor_configmasiva_global);
      //     }
      //   },
      //   error: function(xhr, status) {
      //     console.log("Ha ocurrido un error.");
      //   }
      // });
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

    function setmoneda(id) {
      console.log("sadsadasdasd", id)
      $.ajax({
        url: 'index.php?action=consultamonedaid',
        type: 'POST',
        cache: false,

        data: {
          sucursal: $("#sucursal_id").val(),
          id: id, //simbolo
        },
        dataType: 'json',
        success: function(json) {
          console.log("212121212", json['simbolo']);
          $("#tipomoneda_id2").val(parseInt(json[0].id_tipomoneda));
          $("#tipomoneda_id").val(json['simbolo'])

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
        cache: false,

        data: {
          sucursal: $("#sucursal_id").val(),
          simbolo: simbolo$, //simbolo
          accion: "obtenerCambioPorSimbolo"
        },
        dataType: 'json',
        success: function(json) {
          const cambio_valor = json[0].valor;
          idtipomoneda = json[0].id_tipomoneda;
          simbolo = simbolo$;
          $("#cambio").val(cambio_valor);
          const valor_inical = json[0].id_tipomoneda;
          $("#idtipomoneda").val(valor_inical);
          $("#tipomoneda_id2").val(parseInt(json[0].id_tipomoneda));


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
        cache: false,

        data: {
          sucursal: $("#sucursal_id").val(),
          simbolo: simbolo$, //simbolo
          accion: "obtenerCambioPorSimbolo"
        },
        dataType: 'json',
        success: function(json) {
          const cambio_valor = json[0].valor2;
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
  </script>