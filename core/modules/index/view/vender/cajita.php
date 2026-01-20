<link rel='stylesheet prefetch'
  href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
<?php
$u = null;
$fechaActual = date('Y-m-d');
$tipo = 0;
if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != ""):
  $u = UserData::getById($_SESSION["admin_id"]);
  if ($u->is_empleado):
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

              <!-- <div class="" id="paso1"> -->
              <div class="box-body">
                <?php
                if (isset($_GET['tid'])) {
                  $venta = VentaData::getByIdRemision($_GET['tid']);
                }
                $cotizacion = CotizacionData::versucursalcotizacion($sucursales->id_sucursal);
                $cajas = CajaData::vercajapersonal($u->id_usuario);
                if (count($cajas) > 0 and count($cotizacion) > 0) {
                  foreach ($cotizacion as $moneda) {
                    $mon = MonedaData::cboObtenerValorPorSucursal2($sucursales->id_sucursal, $moneda->id_tipomoneda);
                    foreach ($mon as $mo):
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

                    //  Core::alert("Atención debe de actualizar la moneda a la cotización del día...en Configuraciones/Cotizacion/Nuevo!");
                  } else {
                    //  Core::alert("Atención debe de actualizar la moneda a la cotización del día...en Configuraciones/Cotizacion/Nuevo!");
                  }
                  ?>

                <?php } else {
                  echo "<p class='alert alert-danger'>Debe iniciar Caja, o No hay Cotización registrada!</p>";
                } ?>
                <div id="resultado_producto"></div>
                <!-- <form method="post" class="form-horizontal" id="processsell" action="index.php?action=procesoventaproducto1"> -->

                <?php $configmasiva = ConfiguracionMasivaData::vercamasivaactivosucursal($sucursales->id_sucursal);
                if (count($configmasiva) > 0):
                  foreach ($configmasiva as $masivas): ?>
                    <input type="hidden" name="cantidaconfigmasiva" id="cantidaconfigmasiva"
                      value="<?php echo $masivas->cantidad; ?>">
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
                      foreach ($clients as $client): ?>
                        <option <?php if ($client->comprobante1 == "Factura") {
                          echo "selected";
                        } ?>                   <?php if ($client->diferencia == -1): ?>disabled="" <?php else: ?><?php endif ?>
                          value="<?php echo $client->id_configfactura; ?>">
                          <?php echo $client->comprobante1; ?>       <?php echo " " ?>       <?php echo $client->serie1; ?>
                        </option>
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

                  </div>
                  <?php if (isset($_GET['tid'])) { ?>

                    <div class="col-lg-2">
                      <label for="inputEmail1" class="col-lg-1 control-label">Moneda:</label>
                      <?php
                      $monedas = MonedaData::cboObtenerValorPorSucursal($sucursales->id_sucursal);
                      $mon = MonedaData::VerId($venta->tipomoneda_id, $_GET['id_sucursal']);

                      ?>
                      <select name="tipomoneda_id" id="tipomoneda_id" id1="valor" class="form-control"
                        onchange="tipocambio()">
                        <!-- <option value="0">Seleccionar</option> -->
                        <?php

                        foreach ($monedas as $moneda):
                          if ($mon->simbolo == $moneda->simbolo) { ?>
                            <option selected value="<?php echo $moneda->simbolo; ?>">
                              <?php echo $moneda->nombre . "-" . $moneda->simbolo; ?>
                            </option>
                            <?php
                          } else {
                            ?>
                            <option value="<?php echo $moneda->simbolo; ?>">
                              <?php echo $moneda->nombre . "-" . $moneda->simbolo; ?>
                            </option>
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
                      <select name="tipomoneda_id" id="tipomoneda_id" id1="valor" class="form-control"
                        onchange="tipocambio()">
                        <?php foreach ($monedas as $moneda): ?>
                          <option value="<?php echo $moneda->simbolo; ?>">
                            <?php echo $moneda->nombre . "-" . $moneda->simbolo; ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  <?php } ?>
                  <div class="col-lg-2">
                    <label for="inputEmail1" class="col-lg-1 control-label">Cambio:</label>

                    <input readonly="" type="hidden" name="cambio" id="cambio" class="form-control">
                    <?php
                    $cotizacion = CotizacionData::versucursalcotizacion($sucursales->id_sucursal);

                    $mon = MonedaData::cboObtenerValorPorSucursal3($sucursales->id_sucursal);
                    $valores = 0;
                    if (count($cotizacion) > 0) { ?>
                      <?php
                      foreach ($cotizacion as $moneda) {
                        $mon = MonedaData::cboObtenerValorPorSucursal3($sucursales->id_sucursal);
                        ?>
                        <?php foreach ($mon as $mo): ?>
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
                    <input type="text" disabled="" name="cambio2" id="cambio2" value="<?php echo $valores; ?>"
                      class="form-control">
                    <input type="hidden" name="simbolo2" id="simbolo2" value="<?php echo $simbolo2; ?>"
                      class="form-control">
                    <input type="hidden" name="idtipomoneda" id="idtipomoneda" class="form-control">
                  </div>
                </div>
                <div class="col-lg-2">
                  Remision <input placeholder="Remision" value="0" disabled id="remision_id" class="form-control">
                </div>
                <div class="row ">
                  <div class="col-md-4 " style="margin-top: 15px;">
                    <label for="inputEmail1" class="col-lg-2 control-label">Cliente:</label>

                    <div class="col-lg-9">
                      <input type="test" name="busqueda" id="busqueda" class="form-control" onkeypress="clientes()">

                      <select name="cliente_id" onchange="clienteTipo()" data-style="form-control" id="cliente_id"
                        class="form-control">
                      </select>
                    </div>

                    <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i
                        class="fa fa-user-plus"></i> Nuevo</a>

                  </div>


                  <div class="col-md-4 " style="margin-top: 15px;">


                    <label for="inputEmail1" class="col-lg-2 control-label">Vendedor:</label>

                    <div class="col-lg-9">
                      <?php if (isset($_GET['tid'])) { ?>
                        <select name="vendedor" onchange="" class="selectpicker show-menu-arrow" data-style="form-control"
                          data-live-search="true" id="vendedor_id" class="form-control">
                          <option value="">SELECCIONAR VENDEDOR</option>

                          <?php
                          $clients = VendedorData::getAll($sucursales->id_sucursal);
                          foreach ($clients as $client):
                            // $tipocliente = ProductoData::listar_tipo_precio($client->id_precio);
                            if ($client->id == $venta->vendedor) { ?>
                              <option selected value="<?php echo $client->id; ?>">
                                <?php echo $client->nombre . " - " . $client->cedula; ?>
                              </option>
                              <?php
                            } else {
                              ?>
                              <option value="<?php echo $client->id; ?>"><?php echo $client->nombre . " - " . $client->cedula; ?>
                              </option>
                            <?php }
                          endforeach;

                          ?>
                        </select>
                      <?php } else { ?>
                        <select name="vendedor" onchange="" class="selectpicker show-menu-arrow" data-style="form-control"
                          data-live-search="true" id="vendedor_id" class="form-control">
                          <option value="">SELECCIONAR VENDEDOR</option>

                          <?php
                          $clients = VendedorData::getAll($sucursales->id_sucursal);
                          foreach ($clients as $client):
                            // $tipocliente = ProductoData::listar_tipo_precio($client->id_precio);
                    
                            ?>
                            <option value="<?php echo $client->id; ?>"><?php echo $client->nombre . " - " . $client->cedula; ?>
                            </option>
                          <?php endforeach;

                          ?>
                        </select>
                      <?php } ?>
                    </div>

                  </div>
                  <div id="dncp" class="col-md-4 " style="margin-top: 15px;">


                    <label for="inputEmail1" class="col-lg-2 control-label">DNCP:</label>

                    <div class="col-lg-9">
                      <?php if (isset($_GET['tid'])) { ?>
                        <select name="vendedor" onchange="" data-style="form-control" data-live-search="true" id="dncp-select"
                          class="form-control">

                        </select>
                      <?php } else { ?>
                        <select name="vendedor" onchange="" data-style="form-control" data-live-search="true" id="dncp-select"
                          class="form-control">
                        </select>
                      <?php } ?>
                    </div>

                  </div>
                  <div class="col-md-6" style="margin-top: 15px;">
                    <div id="ocultar" hidden>
                      <div class="row" hidden>
                        <div class="form-group">
                          <label for="inputEmail1" class="col-lg-3 control-label">Forma de Pago:</label>
                          <div class="col-lg-9">
                            <input name="formapago" autofocus="autofocus" value="Efectivo" checked type="radio" name=""
                              onclick="Ocultar1();"> Efectivo
                            <input name="formapago" value="Targeta de Debito" type="radio" name="" onclick="Mostrar1();">
                            Targeta de Debito
                            <input name="formapago" value="Targeta de Credito" type="radio" name="" onclick="Mostrar1();">
                            Targeta de Credito
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
                          <input type="date" name="fecha" class="form-control" value="<?php echo $fechaActual; ?>"
                            id="fecha" placeholder="Efectivo">
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="inputEmail1" class="col-lg-2 control-label">Deposito:</label>
                      <select onchange="" class="selectpicker show-menu-arrow" data-style="form-control"
                        data-live-search="true" id="deposito" name="deposito" class="form-control">
                        <?php
                        $deps = ProductoData::verdeposito($sucursales->id_sucursal);
                        foreach ($deps as $dep):

                          ?>
                          <option value="<?php echo $dep->DEPOSITO_ID; ?>"><?php echo $dep->NOMBRE_DEPOSITO; ?></option>
                        <?php endforeach;

                        ?>
                      </select>

                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail1" class="col-lg-2 control-label">Tipo transacción:</label>
                      <div class="col-lg-4">
                        <select class="selectpicker show-menu-arrow" data-style="form-control" data-live-search="true"
                          id="transaccion" class="form-control">
                          <option value="1">Venta de mercadería</option>
                          <option value="2">Prestación de servicios</option>
                          <option value="3">Mixto (Venta de mercadería y servicios)</option>
                          <option value="4">Venta de activo fijo</option>
                          <option value="5">Venta de divisas</option>
                          <option value="6">Compra de divisas</option>
                          <option value="7">Promoción o entrega de muestras</option>
                          <option value="8">Donación</option>
                          <option value="9">Anticipo</option>
                          <option value="10">Compra de productos</option>
                          <option value="11">Compra de servicios</option>
                          <option value="12">Venta de crédito fiscal</option>
                          <option value="13">Muestras médicas (Art. 3 RG 24/2014)</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <?php if (isset($_GET['tid'])) { ?>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="inputEmail1" class="col-lg-2 control-label">Cdc:</label>
                      <input type="text" id="cdc_fact" value="<?php echo $venta->cdc ?>" class="form-control col-lg-2">
                    </div>
                    <div class="col-md-6">
                      <label for="inputEmail1" class="col-lg-2 control-label">Remisión:</label>
                      <input type="text" id="fact" value="<?php echo $venta->factura ?>" class="form-control col-lg-2">
                    </div>
                  </div>
                <?php } ?>

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
              <div class="">


              </div>
              <br>
              <div class="box-header">
                <i class="fa fa-laptop" style="color: orange;"></i> INGRESAR PRODUCTOS.
                <input type="text" class="form-control" placeholder="Buscar" onchange="buscar()" onclick="buscar()"
                  id="buscarProducto">
              </div>
              <table class="table table-bordered table-hover">
                <thead>
                  <th>Codigo</th>
                  <th>Nombre</th>
                  <th>Precio unitario</th>
                  <th>En inventario</th>
                  <th>Cantidad</th>
                </thead>
                <tbody id="tablaProductos">
                </tbody>

              </table>
              <div id="paginacion"></div>
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

              <div class="form-group">
                <div class="col-lg-offset-2">
                  <div class="checkbox">
                    <label>
                      <input type="hidden" name="sucursal_id" id="sucursal_id"
                        value="<?php echo $sucursales->id_sucursal; ?>">
                      <input type="hidden" name="id_sucursal" id="id_sucursal"
                        value="<?php echo $sucursales->id_sucursal; ?>">
                      <a href="index.php?action=eliminarcompraproductos1&id_sucursal=<?php echo $sucursales->id_sucursal; ?>"
                        class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                      <button id="accion" class="btn btn-lg btn-warning" onclick="accionVenta()"><b></b> Finalizar
                        Venta</button></label>
                  </div>
                </div>
              </div>

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

    <div class="modal fade" id="cobroModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="padding: 30px;">
          <div class="row" id="cobrardiv">
            <div class="col-xs-12">
              <h3> Metodo de pago</h3>
              <div class="box">

                <div class="box-body">
                  <div class="row">

                    <div class="col-md-2">Tipo:</div>
                    <div class="col-md-2">
                      <?php
                      $tipos = CajaTipo::vercajatipo2();
                      ?>
                      <select required="" onselect="tipo()" onchange="tipo()" name="tipopago_id" id="tipopago_id"
                        id1="valor" class="form-control">
                        <?php foreach ($tipos as $tipo):
                          ?>

                          <option value="<?php echo $tipo->id_tipo ?>"><?= $tipo->nombre ?></option>
                          <?php
                        endforeach; ?>
                      </select>
                      <div id="tarjeta">
                        <select required="" id="tipopago" class="form-control">
                        </select>
                        <input type="text" name="" class="form-control" placeholder="Vaucher" id="vaucher">
                        <label for="tarjeta">Tipo:</label>
                        <select id="tarjeta_id" class="form-control" name="tarjeta">
                          <option value="1">Visa</option>
                          <option value="2">Mastercard</option>
                          <option value="3">American Express</option>
                          <option value="4">Maestro</option>
                          <option value="5">Panal</option>
                          <option value="6">Cabal</option>
                          <option value="99">Otro</option>
                        </select>
                      </div>

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
                        <select required="" name="tipomoneda_id2" id="tipomoneda_id2" id1="valor" class="form-control"
                          oninput="tipocambio()">
                          <?php
                          $i = 0;
                          foreach ($monedas as $moneda): ?>
                            <?php
                            $valocito = null;
                            $i++;
                            if ($i == 1) {
                              ?>
                              <option selected value="<?php echo $moneda->id_tipomoneda; ?>">
                                <?php echo $moneda->nombre . "-" . $moneda->simbolo; ?>
                              </option>
                            <?php } else {

                              ?>
                              <option value="<?php echo $moneda->id_tipomoneda; ?>">
                                <?php echo $moneda->nombre . "-" . $moneda->simbolo; ?>
                              </option>
                              <?php
                            }

                          endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">Monto:</div>
                    <div class="col-md-2"><input type="number" name="" value="0" class="form-control" id="monto"></div>
                    <div class="" id="cheque">
                      <div class="col-md-2">Banco:</div>
                      <div class="col-md-2">

                        <?php
                        $bancos = BancoData::getBancos();

                        ?>
                        <select id="banco_cheque" name="banco_cheque" class="form-control">
                          <?php foreach ($bancos as $banco) { ?>
                            <?php echo $banco->nombre_banco ?>
                            <option value="<?php echo $banco->id_banco ?>" selected><?php echo $banco->nombre_banco ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-2">Cheque Nro:</div>
                      <div class="col-md-2"><input type="text" name="" class="form-control" id="nroCheque"></div>
                    </div>
                    <div class="" id="transferencia">
                      <div class="col-md-2">Banco:</div>
                      <div class="col-md-2">
                        <?php
                        $bancos = BancoData::getBancos();
                        ?>
                        <select id="banco_trans" name="banco_trans" class="form-control">
                          <?php foreach ($bancos as $banco) { ?>
                            <?php echo $banco->nombre_banco ?>
                            <option value="<?php echo $banco->id_banco ?>" selected><?php echo $banco->nombre_banco ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="col-md-2">N° transacción:</div>
                      <div class="col-md-2"><input type="text" name="" class="form-control" id="recibo"></div>

                    </div>
                    <div class="col-md-2"><button class="btn btn-info" onclick="agregarPago()">Agregar</button></div>

                    <div class="row">
                      <?php
                      $isventa = false;

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
                          <th>Banco</th>
                          <th>Recibo</th>
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

                    </div>
                    <form action="" method="post"></form>
                  </div>
                </div>

              </div>
            </div>

            <div class="modal-footer">
              <button type="button" data-bs-dismiss="modal" class="btn btn-danger"
                onclick="$('#cobroModal').modal('hide')">Cerrar</button>
              <button type="button" class="btn btn-primary" onclick="accion()">Finalizar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="addnew">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-user-circle" style="color: orange;"></i><b> Agregar Nuevo Cliente</b>
            </h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" id="formNuevoCliente" role="form" enctype="multipart/form-data">
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
                  <input type="text" class="form-control" id="nombre" name="nombre"
                    onKeyUP="this.value=this.value.toUpperCase();" maxlength="80" placeholder="Nombre del Cliente">
                  <span class="fa fa-user-secret form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Apellido</label>

                <div class="col-sm-9">
                  <input type="text" class="form-control" id="apellido" name="apellido"
                    onKeyUP="this.value=this.value.toUpperCase();" maxlength="200" placeholder="Apellido del Cliente">
                  <span class="fa fa-file-text form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Tipo Doc.</label>
                <div class="col-sm-9">
                  <select class="form-control" name="tipo_doc">
                    <option value="RUC">RUC</option>
                    <option value="CI">C.I.</option>
                    <option value="CLIENTE DEL EXTERIOR">CLIENTE DEL EXTERIOR</option>
                    <option value="PASAPORTE">PASAPORTE</option>
                    <option value="CEDULA EXTRANJERO">CEDULA DE EXTRANJERO</option>
                    <option value="SIN NOMBRE">SIN NOMBRE</option>
                    <option value="DIPLOMATICO">DIPLOMATICO</option>
                    <option value="IDENTIFICACION TRIBUTARIA">IDENTIFICACIÓN TRIBUTARIA</option>
                  </select>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">N° Documento</label>

                <div class="col-sm-9">
                  <input type="text" class="form-control" id="dni" name="dni" maxlength="15" placeholder="Sin Nombre: X">
                  <span class="fa fa-credit-card form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Departamento:</label>
                <div class="col-sm-9">
                  <select name="dpt_id" id="dpt_id" onchange="buscard()" class="form-control">
                    <?php
                    $dpts = DptData::getAll();
                    foreach ($dpts as $dpt):
                      ?>
                      <option value="<?php echo $dpt->codigo;
                      ?>"><?php echo $dpt->name
                        ?></option>
                    <?php endforeach;
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Distrito:</label>
                <div class="col-sm-9">
                  <select onchange="buscaCiudad()" name="distrito" id="ciudades" class="form-control">
                  </select>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Ciudad:</label>
                <div class="col-sm-9">
                  <select id="ciudad" name="ciudad" class="form-control">
                  </select>
                </div>
              </div>


              <div class="form-group has-feedback has-warning">
                <label for="pais_id" class="col-sm-3 control-label">Pais:</label>
                <div class="col-sm-9">
                  <select name="pais_id" id="pais_id" class="form-control">
                    <?php
                    $pais_t = PaisData::getAll();
                    foreach ($pais_t as $pais):
                      ?>
                      <option value="<?php echo $pais->id;
                      ?>"><?php echo $pais->descripcion
                        ?></option>
                    <?php endforeach;
                    ?>
                  </select>
                </div>
              </div>


              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Dirección</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="direccion" name="direccion"
                    placeholder="Dirección del Cliente">
                  <span class="fa fa-map-marker form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">E-mail</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="email" name="email" maxlength="100"
                    placeholder="Correo Electronico del Cliente"> <span class="fa fa-google form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Telefono</label>

                <div class="col-sm-9">
                  <input type="text" class="form-control" id="telefono" name="telefono" maxlength="15"
                    placeholder="Número de  teléfono">
                  <span class="fa fa-tty form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Celular</label>

                <div class="col-sm-9">
                  <input type="text" class="form-control" id="celular" name="celular" maxlength="15"
                    placeholder="Numero de Celular del Cliente">
                  <span class="fa fa-phone form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Tipo cliente</label>

                <div class="col-sm-9">
                  <div class="col-lg-10">
                    <?php
                    $clients = ProductoData::listar_precio($_GET['id_sucursal']);
                    ?>
                    <select name="id_precio" id="id_precio" class="form-control">
                      <?php
                      $clients = ProductoData::listar_precio($_GET['id_sucursal']);

                      if (count($clients) > 0) {

                        foreach ($clients as $client):

                          ?>

                          <option value="<?php echo $client->PRECIO_ID; ?>"><?php echo $client->NOMBRE_PRECIO ?></option>
                          <?php
                        endforeach;
                      } else {
                        echo 'Debe de crear un tipo de cliente';
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">

            <input type="hidden" name="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
            <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
            <input type="hidden" name="sucursal" id="sucursal" value="<?php echo $sucursales->nombre; ?>">
            <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i>
              Cerrar</button>
            <button type="button" class="btn btn-warning btn-flat" onclick="if(validarFormulario()) guardarCliente()"><i
                class="fa fa-save"></i> Guardar</button>
          </div>
          </form>
        </div>
      </div>


      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      

      <script>
        var ClienteRemision = ''

        function guardarCliente() {
          // Mostrar indicador de carga
          Swal.fire({
            title: 'Guardando...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });

          // Crear FormData para manejar archivos
          var formData = new FormData();

          // Agregar todos los campos del formulario
          formData.append('nombre', $('#nombre').val());
          formData.append('apellido', $('#apellido').val());
          formData.append('tipo_doc', $('select[name="tipo_doc"]').val());
          formData.append('dni', $('#dni').val());
          formData.append('dpt_id', $('#dpt_id').val());
          formData.append('distrito', $('#ciudades').val());
          formData.append('ciudad', $('#ciudad').val());
          formData.append('pais_id', $('#pais_id').val());
          formData.append('direccion', $('#direccion').val());
          formData.append('email', $('#email').val());
          formData.append('telefono', $('#telefono').val());
          formData.append('celular', $('#celular').val());
          formData.append('id_precio', $('#id_precio').val());
          formData.append('sucursal_id', $('#id_sucursal').val());
          formData.append('id_sucursal', $('#id_sucursal').val());
          formData.append('sucursal', $('#sucursal').val());

          // Agregar imagen si existe
          var imagenFile = $('input[name="imagen"]')[0].files[0];
          if (imagenFile) {
            formData.append('imagen', imagenFile);
          }

          // Enviar datos via AJAX
          $.ajax({
            url: 'index.php?action=nuevocliente',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
              if (response.success) {
                clientes();
                Swal.fire({
                  icon: 'success',
                  title: '¡Éxito!',
                  text: response.message || 'Cliente guardado correctamente',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  // Cerrar modal
                  $('#addnew').modal('hide');

                  // Limpiar formulario
                  $('#formNuevoCliente')[0].reset();

                  // Recargar página o actualizar lista de clientes si es necesario
                  // location.reload();
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: response.message || 'Error al guardar el cliente',
                  confirmButtonText: 'OK'
                });
              }
            },
            error: function (xhr, status, error) {
              console.error('Error AJAX:', error);
              Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'Ha ocurrido un error al conectar con el servidor',
                confirmButtonText: 'OK'
              });
            }
          });
        }

        // Función para validar formulario antes de enviar
        function validarFormulario() {
          var nombre = $('#nombre').val().trim();
          var apellido = $('#apellido').val().trim();
          var dni = $('#dni').val().trim();

          if (!nombre) {
            Swal.fire('Error', 'El nombre es obligatorio', 'error');
            $('#nombre').focus();
            return false;
          }

          if (!apellido) {
            Swal.fire('Error', 'El apellido es obligatorio', 'error');
            $('#apellido').focus();
            return false;
          }

          if (!dni) {
            Swal.fire('Error', 'El número de documento es obligatorio', 'error');
            $('#dni').focus();
            return false;
          }

          return true;
        }

        // Limpiar formulario cuando se cierre el modal
        $('#addnew').on('hidden.bs.modal', function () {
          $('#formNuevoCliente')[0].reset();
          // Limpiar mensajes de error si existen
          $('.has-error').removeClass('has-error');
          $('.help-block').remove();
        });

        // Agregar validación en tiempo real
        $('#nombre, #apellido, #dni').on('blur', function () {
          var field = $(this);
          var value = field.val().trim();

          if (!value) {
            field.closest('.form-group').addClass('has-error');
            if (!field.next('.help-block').length) {
              field.after('<span class="help-block">Este campo es obligatorio</span>');
            }
          } else {
            field.closest('.form-group').removeClass('has-error');
            field.next('.help-block').remove();
          }
        });
      </script>
    <?php endif;
endif;

if (isset($_GET['tid'])) { ?>
    <script type="text/javascript">

      var idr = "<?php echo $_GET['tid'] ?>";
      $.ajax({
        url: 'index.php?action=obtenercarritoremision&tid=',
        type: 'GET',
        data: {
          tid: idr,
          sucursal: "<?php echo $_GET['id_sucursal']; ?>"
        },
        dataType: 'json',
        success: function (json) {
          console.log("222", json);

          $("#remision_id").val(idr);
          for (var i = 0; i < json.length; i++) {
            console.log(',prod', json[i]);
            agregaTabla(json[i]["producto"]["id_producto"],
              json[i]["producto"]["codigo"], json[i]["producto"]["impuesto"], json[i]["precio"],
              json[i]["producto"]["nombre"], json[i]["cantidadc"], json[i]["tipo"], json[i]["cantidad"], json[i]["producto"]["precio_compra"], json[i]["deposito"], json[i]["depositotext"])

          }
        },
        error: function (xhr, status) {
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
        success: function (json) {
          console.log("222", json);

        },
        error: function (xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });
      $.ajax({
        url: 'index.php?action=buscarcliente',
        type: 'GET',
        data: {
          id: <?php echo $venta->cliente_id ?>,

        },
        dataType: 'json',
        success: function (json) {
          ClienteRemision = `<option value="${json.id_cliente}">${json.dni} - ${json.nombre} ${json.apellido} - ${json.tipo_doc}</option>`;

        },
        error: function (xhr, status) {
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
}
;
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


    function pagar(venta) {
      $.ajax({
        url: 'index.php?action=cobrocaja',
        type: 'POST',
        data: {
          pagos: pagos,
          total: totalCobrar,
          sucursal: '<?= $_GET['id_sucursal'] ?>',
          cliente: $("#cliente_id").val(),
          venta,
          fecha: $("#fecha").val()

        },
        dataType: 'json',
        success: function (json) {
          if ($("#remision_id").val() == 0) {
            window.location.href = "index.php?view=envioporlote&id_sucursal=<?php echo $_GET['id_sucursal'] ?>";


          } else {
            window.location.href = "index.php?view=envioventaremision&id_sucursal=<?php echo $_GET['id_sucursal'] ?>";


          }

          // window.location.href = "impresioncobro.php?cobro=" + cobroId;
          // window.location.href = "index.php?view=ventas&id_sucursal=<?php echo $_GET['id_sucursal'] ?>";
        },
        error: function (xhr, status) {
          console.log("Ha ocurrido un error." + JSON.stringify(xhr));
          if ($("#remision_id").val() == 0) {
            window.location.href = "index.php?view=envioporlote&id_sucursal=<?php echo $_GET['id_sucursal'] ?>";
          } else {
            window.location.href = "index.php?view=envioventaremision&id_sucursal=<?php echo $_GET['id_sucursal'] ?>";


          }
        }
      });


    }

    function actualizarTablacobro() {
      tabla = "";
      for (const [id, pago] of Object.entries(pagos)) {
        tabla += `<tr><td> ${pago.tipo}  ${pago.tarjeta_text}</td><td> ${pago.tipo_tar2}</td><td> ${pago.vaucher}</td><td> ${pago.monto}</td><td> ${pago.monto2}</td>
                        <td> ${pago.moneda}</td><td> ${pago.cambio}</td><td> ${pago.bancoText}</td><td> ${pago.recibo}</td><td> <button class="btn btn-danger" onclick="eliminarcobro(${id})">Eliminar</button></td></tr>`;
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
      let validaTotalCobro = 0
      if ($('select[name="tipomoneda_id2"] option:selected').text().includes('$')) {
        validaTotalCobro = totalCobrar + parseFloat($('#monto').val()) * cambio;
      } else {
        validaTotalCobro = parseFloat($('#monto').val());
      }
      totalVenta = total * $("#cambio2").val();
      if (validaTotalCobro > totalVenta) {
        Swal.fire({
          title: "Monto superior a la venta",
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
        return
      }
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
            "vaucher": $("#vaucher").val(),
            "banco": "",
            "recibo": "",
            "bancoText": "",
            "tarjeta": $('#tarjeta_id').val(),
            "tarjeta_text": $('select[id="tarjeta_id"] option:selected').text()
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
            "vaucher": $("#vaucher").val(),
            "banco": "",
            "recibo": "",
            "bancoText": "",
            "tarjeta": $('#tarjeta_id').val(),
            "tarjeta_text": $('select[id="tarjeta_id"] option:selected').text()
          });
        }
      } else {
        let getBanco = "";
        let getRecibo = "";
        let getBancoText = "";
        if ($("#tipopago_id").val() == 2) {
          getBanco = $("#banco_trans").val();
          getRecibo = $("#recibo").val();

          getBancoText = $('select[name="banco_trans"] option:selected').text()
        } else if ($("#tipopago_id").val() == 3) {
          getBanco = $("#banco_cheque").val();
          getRecibo = $("#nroCheque").val();
          getBancoText = $('select[name="banco_cheque"] option:selected').text()
        }

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
            "vaucher": "",
            "banco": getBanco,
            "recibo": getRecibo,
            "bancoText": getBancoText,
            "tarjeta_text": ''
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
            "vaucher": "",
            "banco": getBanco,
            "recibo": getRecibo,
            "bancoText": getBancoText,
            "tarjeta_text": ''
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
          success: function (json) {
            console.log(json)
            for (var i = 0; i < json.length; i++) {
              select += `<option value="${json[i].id_procesadora}">${json[i].nombre}</option> `


            }
            $("#tipopago").html(select);
          },
          error: function (xhr, status) {
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


    function tipo() {

      if ($("#tipopago_id").val() == 4) {
        $("#tipopago").show();
        $("#vaucher").show();
        $('#cheque').hide()
        $("#tarjeta").show();
        select = "";
        $.ajax({
          url: 'index.php?action=tipocaja',
          type: 'GET',
          data: {},
          dataType: 'json',
          success: function (json) {
            console.log(json)
            for (var i = 0; i < json.length; i++) {
              select += `<option value="${json[i].id_procesadora}">${json[i].nombre}</option> `


            }
            $("#tipopago").html(select);
          },
          error: function (xhr, status) {
            console.log("Ha ocurrido un error.");
          }
        });
      } else if ($("#tipopago_id").val() == 5 || $("#tipopago_id").val() == 4) {
        $("#tipopago").hide();
        $('#cheque').hide()
        $('#transferencia').hide()
        $("#vaucher").hide();
        $("#tarjeta").hide();
      } else if ($("#tipopago_id").val() == 1) {
        $('#cheque').hide()
        $("#tipopago").hide();
        $("#vaucher").hide();
        $('#transferencia').hide();
        $("#tarjeta").hide();
      } else if ($("#tipopago_id").val() == 2) {
        $('#cheque').hide()
        $("#tipopago").hide();
        $("#vaucher").hide();
        $('#transferencia').show()
        $("#tarjeta").hide();
      } else if ($("#tipopago_id").val() == 3) {
        $('#transferencia').hide()
        $("#tipopago").hide();
        $("#vaucher").hide();
        $("#tarjeta").hide();
        $('#cheque').show()

      } else {
        tipopago = ""
        $('#cheque').hide()
        $("#tipopago").hide();
        $("#vaucher").hide();

      }
    }
    tipo()

    function siguiente() {
      if ($("#configfactura_id").val()) {
        $("#paso2").show();

        $("#paso1").hide();
        console.log($('select[name="cliente_id"] option:selected').text())
        var isRemision = "";
        if ($("#remision_id").val() != 0) {
          isRemision = ", Remision # " + $("#remision_id").val();
        } else { }
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
          success: function (json) {
            $("#cambio").val(json[0].valor);
            valor_dolar_global = json[0].valor;
            ajaxConfigMasiva("₲");
            $("#tipomoneda_id2").val(parseInt(json[0].id_tipomoneda));

          },
          error: function (xhr, status) {
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
          success: function (json) {
            valor_guaranies_global = json[0].valor;
            // idtipomoneda = json[0].id_tipomoneda;
            $("#cambio").val(json[0].valor);
            ajaxConfigMasiva("US$");
            $("#tipomoneda_id2").val(parseInt(json[0].id_tipomoneda));

          },
          error: function (xhr, status) {
            console.log("Ha ocurrido un error.");
          }
        });
      }
    }



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
        } else if (cart.impuesto == 40 || cart.impuesto == "Iva 40") {
          iva10 += parseFloat(cart.iva);
          exenta += parseFloat(cart.exenta);
          grabada10 += parseFloat(cart.grabada);
        }
        console.log('sssssssd', cart.impuesto)
        console.log('sss', total);
        total += parseFloat(cart.preciot);
      }

      $("#tablaCarrito").html(tabla);
      $("#txtTotalVentas").val(parseFloat(total).toFixed(2));
      if ($("#tipomoneda_id").val() == "US$") {
        $("#cobror").html(parseFloat(total * $("#cambio2").val()).toLocaleString("es-ES"));
        totalACobrar = parseFloat(total * $("#cambio2").val())
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

    $('#dncp').hide();

    function clientes() {
      $.ajax({
        url: 'index.php?action=clientes',
        type: 'GET',
        data: {
          id_sucursal: $("#id_sucursal").val(),
          busqueda: $('#busqueda').val()
        },
        dataType: 'json',
        success: function (json) {
          console.log("Clientes recibidos:", json);

          // Build the options HTML
          let select = '' + ClienteRemision;
          for (var i = 0; i < json.length; i++) {
            select += `<option value="${json[i].id_cliente}">${json[i].dni} - ${json[i].nombre} ${json[i].apellido} - ${json[i].tipo_doc}</option>`;
          }


          // Update the select element
          $("#cliente_id").html(select);

          // Destroy and reinitialize bootstrap-select to ensure proper refresh
          try {
            $("#cliente_id").selectpicker('destroy');
            $("#cliente_id").selectpicker({
              style: 'form-control',
              liveSearch: true,
              showMenuArrow: true
            });
            console.log("Bootstrap-select reinicializado correctamente");
          } catch (e) {
            console.error("Error al reinicializar bootstrap-select:", e);
            // Fallback: try simple refresh
            $("#cliente_id").selectpicker('refresh');
          }
        },
        error: function (xhr, status) {
          console.log("Ha ocurrido un error al cargar clientes:", xhr.responseText);
        }
      });
    }
    clientes()

    function clienteTipo() {
      $.ajax({
        url: 'index.php?action=buscarcliente',
        type: 'GET',
        data: {
          id: $("#cliente_id").val()
        },
        dataType: 'json',
        success: function (json) {
          tipocliente = json.id_precio;
          console.log(tipocliente)
          actualizarTabla()
          if (json.tipo_operacion == 3) {
            clienteDncp()
            $('#dncp').show();
          } else {
            $("#dncp-select").html(`<option value="null"></option>`);
            $('#dncp').hide();
          }
        },
        error: function (xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });

    }

    function clienteDncp() {
      $.ajax({
        url: 'index.php?action=listardncp',
        type: 'GET',
        data: {
          id_cliente: $("#cliente_id").val()
        },
        dataType: 'json',
        success: function (json) {
          console.log(json)
          let select = ""
          for (var i = 0; i < json.length; i++) {
            select += `<option value="${json[i].id}">${json[i].modalidad} secuencia: ${json[i].secuencia}</option> `


          }
          $("#dncp-select").html(select);
        },
        error: function (xhr, status) {
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
        success: function (json) {
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
        error: function (xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });

    }
    configFactura()

    function accion() {
      $("#accion").prop('disabled', true);
      if ($("#cliente_id").val() == 0) {
        $("#accion").prop('disabled', false);

        Swal.fire({
          title: "Seleccione un cliente valido",
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
        return;
      }

      if ($("#vendedor_id").val() == 0) {
        $("#accion").prop('disabled', false);

        Swal.fire({
          title: "Seleccione un Vendedor valido",
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
        return;
      }


      if (carrito.length == 0) {
        $("#accion").prop('disabled', false);

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
          return;
        }
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


      $.ajax({
        url: "index.php?action=procesoventaproducto1",
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
          vendedor_id: $("#vendedor_id").val(),
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
          transaccion: $("#transaccion").val(),
          dncp: $("#dncp-select").val() ? $("#dncp-select").val() : null,
        },
        success: function (dataResult) {
          console.log(dataResult[0]);
          console.log(dataResult[0].success);
          if (dataResult.includes("<")) {
            $("#accion").prop('disabled', false);
            alert("Error al hacer venta");
          } else {

            if ($("#remision_id").val() == 0) {
              alert("Venta realizada con exito");
              if ($('input[name="metodopago"]:checked').val() == "Contado") {
                pagar(dataResult.trim());
              } else {
                window.location.href = "index.php?view=envioporlote&id_sucursal=<?php echo $_GET['id_sucursal'] ?>";
              }

            } else {
              alert("Venta de remision realizada con exito");

              if ($('input[name="metodopago"]:checked').val() == "Contado") {
                pagar(dataResult.trim());
              } else {
                window.location.href = "index.php?view=envioventaremision&id_sucursal=<?php echo $_GET['id_sucursal'] ?>";
              }

            }
          }

          try {


          } catch (e) {

          }
        }
      });

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



    function obtenerBoton(id) {
      const boton = document.getElementById(id);

      const data = boton.getAttribute('data-json');
      let cadenaSinComillas = data.trim().slice(1, -1);
      const data_1 = JSON.parse(cadenaSinComillas);
      agregar({
        id: data_1.producto.id_producto,
        codigo: data_1.producto.codigo,
        impuesto: data_1.producto.impuesto,
        tipo: data_1.tipo,
        stock: data_1.cantidad,
        precio: data_1.precio,
        precioc: data_1.producto.precio_compra,
        currentStock: data_1.cantidad,
        insumos: data_1.insumos,
        producto: data_1.producto.nombre
      })
    }

    function agregar({
      id,
      codigo,
      impuesto,
      precio,
      producto,
      tipo,
      stock,
      precioc,
      currentStock,
      insumos
    }) {
      console.log('aaa', tipo)
      console.log('a', insumos)
      if (insumos.length > 0) {
        for (let i = 0; i < insumos.length; i = insumos.length) {
          if (insumos[0].cantidad * parseInt($('#a' + id).val()) > insumos[0].disponible) {
            Swal.fire({
              title: "Insumos insuficientes",
              icon: 'error',
              confirmButtonText: 'Aceptar'
            });
            return;
          }
        }
      }
      if (carrito.some(item => item.id === id)) {
        Swal.fire({
          title: "Ya posee este producto agregado",
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
      } else if (currentStock < parseInt($('#a' + id).val()) && tipo !== 'Servicio') {

        Swal.fire({
          title: "Stock insuficiente",
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
      } else {
        console.log('precio', {
          id,
          codigo,
          impuesto,
          precio,
          producto,
          tipo,
          stock,
          precioc,
          currentStock
        });
        agregaTabla(id, codigo, impuesto, precio, producto, $('#a' + id).val(), tipo, stock, precioc, $("#deposito").val(), $('select[name="deposito"] option:selected').text());
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
          precio: parseFloat(precio).toFixed(4),
          producto: producto,
          preciot: parseFloat(totalcart).toFixed(4),
          id: id,
          tipo: tipo,
          stock: parseFloat(stock).toFixed(2),
          precioc: parseFloat(precioE).toFixed(4),
          deposito: dep,
          depositotext: deposito,
          exenta: exenta
        })
      } else if (impuesto == 40 || impuesto == "Iva 40") {
        var prec = (input * parseFloat(precio));

        let precioIva40 = input * parseFloat(precio);
        grabada = (precioIva40 - ((100 * precioIva40 * 70) / (10000 + (10 * 30))))
        exenta = (((100 * precioIva40 * 70) / (10000 + (10 * 30))));
        iva = (grabada / 1.1) / 10;

        carrito.push({
          cantidad: parseFloat(cant),
          codigo: codigo,
          impuesto: "Iva 40",
          iva: parseFloat(iva).toFixed(4),
          grabada: parseFloat(grabada).toFixed(4),
          precio: parseFloat(precio).toFixed(4),
          producto: producto,
          preciot: parseFloat(totalcart).toFixed(4),
          id: id,
          tipo: tipo,
          stock: parseFloat(stock).toFixed(2),
          precioc: parseFloat(precioE).toFixed(4),
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
          precio: parseFloat(precio).toFixed(4),
          producto: producto,
          preciot: parseFloat(totalcart).toFixed(4),
          id: id,
          tipo: tipo,
          stock: parseFloat(stock).toFixed(2),
          precioc: parseFloat(precioE).toFixed(4),
          deposito: dep,
          depositotext: deposito
        })
      }
      total += totalcart;
      console.log('cart', carrito)
      actualizarTabla();
    }
    pagina = 0;
    totalPages = 0

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
          offset: pagina * 5
        },
        cache: false,
        success: function (dataResult) {
          var result = JSON.parse(dataResult);
          totalPages = result.pages
          pagination()
tablab="";
          for (const [key, data] of Object.entries(result.result)) {
            const jsonString = JSON.stringify(data);
     console.log('dataAAA', data.producto.activo);
            if (data.producto.activo== 1) {
          console.log('dataAAA');

              tablab += `<tr>
                    <td> ${data.producto.codigo}</td>
                    <td> ${data.producto.nombre}</td>
                    <td>${data.precio} </td>
                    <td>${data.cantidad}</td> 
                    `;
              if (data['tipo'] != 'Servicio') {
                tablab += `<td><input value="0"  type="number"  id="a${data.producto.id_producto}" class="form-control"> <button 
                    class="btn btn-info btn-venta" data-json='\"${jsonString}\"'  id="b${data.producto.id_producto}" onclick="obtenerBoton('b${data["producto"]["id_producto"]}')">Agregar</button></td>
            </tr>`;
              } else if (
                data['tipo'] == 'Servicio') {
                tablab += `    <td><input value="0" type="number"  id="a${data["producto"]["id_producto"]}" class="form-control"> <button 
                   class="btn btn-info btn-venta" data-json='\"${jsonString}\"'  id="b${data.producto.id_producto}" onclick="obtenerBoton('b${data["producto"]["id_producto"]}')">Agregar</button></td>
            </tr>`;
              } else {
                tablab += `    <td></td>
            </tr>`;
              }
            }
          }
console.log('bb',tablab)
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

    }

    function ajaxConfigMasiva(simbolo$) {

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
        success: function (json) {
          console.log("212121212", json['simbolo']);
          $("#tipomoneda_id2").val(parseInt(json[0].id_tipomoneda));
          $("#tipomoneda_id").val(json['simbolo'])

        },
        error: function (xhr, status) {
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
        success: function (json) {
          const cambio_valor = json[0].valor;
          idtipomoneda = json[0].id_tipomoneda;
          simbolo = simbolo$;
          $("#cambio").val(cambio_valor);
          const valor_inical = json[0].id_tipomoneda;
          $("#idtipomoneda").val(valor_inical);
          $("#tipomoneda_id2").val(parseInt(json[0].id_tipomoneda));


        },
        error: function (xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });
    }

    function accionVenta() {
      if ($('input[name="metodopago"]:checked').val() == "Contado") {
        $('#cobroModal').modal({
          show: true
        });
      } else {
        accion()
      }

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
        success: function (json) {
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
        error: function (xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });
    }

    function getPage(newPage) {
      pagina = newPage
      console.log(pagina)
      buscar()
    }

    function buscard() {
      buscarCiudad($("#dpt_id").val());
    }

    function buscaCiudad() {
      console.log('12313123', $("#ciudades").val());
      //  ciudades(595);
      $.ajax({
        url: "index.php?action=buscarciudades",
        type: "GET",
        data: {
          dist: $("#ciudades").val(),
        },
        cache: false,
        success: function (dataResult) {
          console.log(dataResult)
          ciudades = "";

          var result = JSON.parse(dataResult);
          //  ciudades = `<option selected value="${result[0].id_distrito}">${result[0].descripcion}</option>`;
          for (const [id, data_1] of Object.entries(result)) {
            ciudades += `<option selected value="${data_1.codigo}">${data_1.descripcion}</option>`;
          }
          $("#ciudad").html(ciudades);
        }
      });
    }

    function buscarCiudad(distrito) {
      $.ajax({
        url: "index.php?action=buscarendistrito",
        type: "GET",
        data: {
          dpt: distrito,
        },
        cache: false,
        success: function (dataResult) {
          console.log('sasa', dataResult)
          ciudades = "";

          var result = JSON.parse(dataResult);
          //  ciudades = `<option selected value="${result[0].id_distrito}">${result[0].descripcion}</option>`;
          for (const [id, data_1] of Object.entries(result)) {
            ciudades += `<option selected value="${data_1.codigo}">${data_1.descripcion}</option>`;
          }
          $("#ciudades").html(ciudades);
        }
      });
    }

    function pagination() {
      const limit = 20;
      const currentPage = pagina;

      paginacion = `<nav aria-label="...">
                  <ul class="pagination">
                  `;

      const startPage = Math.floor(currentPage / limit) * limit;
      const endPage = Math.min(startPage + limit, totalPages);
      console.log('a', currentPage)

      if (currentPage > 0) {
        console.log('a0', currentPage)

        paginacion += `<li class="page-item"><a class="page-link" onclick="getPage(${currentPage - 1})">&laquo;</a></li>`;
      }

      for (let i = startPage; i < endPage; i++) {
        console.log('a2', currentPage)
        paginacion += `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" onclick="getPage(${i})">${i + 1}</a></li>`;
      }

      if (currentPage < totalPages - 1) {
        console.log('a3', currentPage)
        paginacion += `<li class="page-item"><a class="page-link" onclick="getPage(${currentPage + 1})">&raquo;</a></li>`;
      }
      paginacion += `
                  </ul>
                </nav>`;
      $("#paginacion").html(paginacion);
    }
  </script>