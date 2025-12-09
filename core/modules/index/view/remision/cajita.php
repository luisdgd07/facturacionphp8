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
            REALIZAR REMISION:
          </h1>
        </section>
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <!-- <div id="paso1"> -->
                <div class="box-body">
                  <?php

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
                      $clients = ConfigFacturaData::verfacturasucursal2($sucursales->id_sucursal);
                      ?>
                      <select name="configfactura_id" id="configfactura_id" class="form-control" oninput="configFactura()">
                        <option value="">Seleccionar</option>

                        <?php foreach ($clients as $client) : ?>
                          <option selected <?php if ($client->diferencia == -1) : ?>disabled="" <?php else : ?><?php endif ?> value="<?php echo $client->id_configfactura; ?>"><?php echo $client->comprobante1; ?><?php echo " " ?><?php echo $client->serie1; ?></option>
                          <script type="text/javascript">

                          </script>
                        <?php endforeach; ?>
                      </select>



                      <label for="inputEmail1" class="col-lg-1 control-label">Tipo remisión:</label>

                      <select class="form-control" name="tipo_doc" id="tipo_doc">
                        <option value="1">Traslado por ventas</option>
                        <option value="2">Traslado por consignación</option>
                        <option value="3">Exportación</option>
                        <option value="4">Traslado por compra</option>
                        <option value="5">Importación</option>
                        <option value="6">Traslado por devolución</option>
                        <option value="7">Traslado entre locales de la empresa</option>
                        <option value="8">Traslado de bienes por transformación</option>
                        <option value="9">Traslado de bienes por reparación</option>
                        <option value="10">Traslado por emisor móvil</option>
                        <option value="11">Exhibición o demostración</option>
                        <option value="12">Participación en ferias</option>
                        <option value="13">Traslado de encomienda</option>
                        <option value="14">Decomiso</option>
                        <option value="99">Otro</option>


                      </select>


                    </div>
                    <div class="col-md-2">
                      <input type="text" class="form-control" disabled name="facturan" id="facturan">
                    </div>
                    <div>

                      <div class="col-md-2">
                        <input type="hidden" class="form-control" name="diferencia" id="diferencia">
                      </div>

                    </div>

                    <div class="col-lg-2">
                      <label for="inputEmail1" class="col-lg-1 control-label">Moneda:</label>

                      <?php
                      $monedas = MonedaData::cboObtenerValorPorSucursal($sucursales->id_sucursal);
                      ?>
                      <select name="tipomoneda_id" id="tipomoneda_id" id1="valor" class="form-control" oninput="tipocambio()">
                        <!-- <option value="0">Seleccionar</option> -->
                        <?php foreach ($monedas as $moneda) : ?>
                          <option value="<?php echo $moneda->simbolo; ?>"><?php echo $moneda->nombre . "-" . $moneda->simbolo; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-lg-2">

                      <label for="inputEmail1" class="col-lg-1 control-label">Cambio:</label>

                      <input type="hidden" name="cambio" id="cambio" class="form-control">
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
                      <input readonly="" type="text" name="cambio2" id="cambio2" value="<?php echo $valores; ?>" class="form-control">
                      <input type="hidden" name="simbolo2" id="simbolo2" value="<?php echo $simbolo2; ?>" class="form-control">
                      <input type="hidden" name="idtipomoneda" id="idtipomoneda" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-2" style="display: none;">
                    <?php $dad = 0;
                    $by = isset($_SESSION["cart"]);
                    if ($by == "") {
                    } else {
                      foreach ($_SESSION["cart"] as $p) :
                        $clientito = OperationData::getById($p["producto_id"]);
                        $dad = $p["cli"];
                      endforeach;
                    }
                    ?>
                    <input type="hidden" name="remision_id" class="form-control">
                  </div>
                  <div class="col-lg-12" style="margin-top: 10px;">
                    <label for="inputEmail1" class="col-lg-1 control-label">Cliente:</label>
                    <div class="col-lg-11">
                      <select name="cliente_id" onchange="clienteTipo()" class="selectpicker show-menu-arrow" data-style="form-control" data-live-search="true" id="cliente_id" class="form-control">
                        <option value="">SELECCIONAR CLIENTE</option>

                        <?php
                        $clients = ClienteData::verclientessucursal($sucursales->id_sucursal);
                        foreach ($clients as $client) : ?>
                          <option value="<?php echo $client->id_cliente; ?>"><?php echo $client->dni . " - " . $client->nombre . " " . $client->apellido . " - " . $client->tipo_doc; ?></option>
                        <?php endforeach;
                        ?>
                      </select>
                    </div>




                    <div id="dncp" class="col-md-4 " style="margin-top: 15px;">


                      <label for="inputEmail1" class="col-lg-2 control-label">DNCP:</label>

                      <div class="col-lg-9">
                        <?php if (isset($_GET['tid'])) { ?>
                          <select name="vendedor" onchange="" data-style="form-control" data-live-search="true" id="dncp-select" class="form-control">

                          </select>
                        <?php } else { ?>
                          <select name="vendedor" onchange="" data-style="form-control" data-live-search="true" id="dncp-select" class="form-control">
                          </select>
                        <?php } ?>
                      </div>

                    </div>


                    <div class="col-md-6" style="margin-top: 15px;">
                      <div id="ocultar">
                        <div class="form-group">
                          <label for="inputEmail1" class="col-lg-3 control-label">Forma de Pago:</label>
                          <div class="col-lg-9">
                            <input name="formapago" value="Targeta de Credito" type="radio" name="" onclick="Mostrar1();"> Ninguno

                            <input name="formapago" autofocus="autofocus" value="ninguno" checked type="radio" name="" onclick="Ocultar1();"> Efectivo
                            <input name="formapago" value="Targeta de Debito" type="radio" name="" onclick="Mostrar1();"> Targeta de Debito
                            <input name="formapago" value="Targeta de Credito" type="radio" name="" onclick="Mostrar1();"> Targeta de Credito
                            <input name="formapago" value="Giro" type="radio" name="" onclick="Ocultar1();"> Giro
                          </div>
                        </div>
                      </div>
                      <div id="mostrar">
                        <div class="form-group" hidden>
                          <label for="inputEmail1" class="col-lg-3 control-label">Cuotas</label>
                          <div class="col-lg-9">
                            <input type="number" name="cuotas" value="1" class="form-control" id="cuotas">
                          </div>
                          <label for="inputEmail1" class="col-lg-3 control-label">Plazo</label>
                          <div class="col-lg-9">
                            <input type="number" id="vencimiento" value="30" name="vencimiento" class="form-control" id="plazo">
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
                      <div class="form-group" hidden>
                        <label for="inputEmail1" class="col-lg-2 control-label">Tipo de venta:</label>
                        <div class="col-lg-4">
                          <input name="metodopago" value="Ninguno" type="radio" name="" onclick="Ocultar();"> Ninguno
                          <input name="metodopago" value="Contado" type="radio" name="" onclick="Ocultar();"> Contado
                          <input name="metodopago" value="Credito" checked type="radio" name="" onclick="Mostrar();"> Credito
                        </div>
                      </div>
                    </div>





                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="form-group">
                          <label for="inputEmail1" class="col-lg-2 control-label">Fecha Remisión:</label>
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
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="inputEmail1" class="col-lg-4 control-label">Departamento:</label>
                        <div class="col-sm-9">
                          <select name="cliente_id" id="dpt_id" disabled onchange="buscard()" class="form-control">
                            <?php
                            $dpts = DptData::getAll();
                            foreach ($dpts as $dpt) :
                            ?>
                              <option value="<?php echo $dpt->codigo;
                                              ?>"><?php echo $dpt->name
                                                  ?></option>
                            <?php endforeach;
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Distrito:</label>
                        <div class="col-sm-9">
                          <select onchange="buscaCiudad()" disabled id="ciudades" class="form-control">
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
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
                    <div class="col-lg-4">
                      <label for="inputEmail1" class="col-lg-5 control-label">Empresa Fletera:</label>
                      <?php
                      $agentes = FleteraData::verfletera($sucursales->id_sucursal);
                      ?>
                      <select name="fletera" id="fletera" id1="valor" class="form-control">
                        <!-- <option value="0">Seleccionar</option> -->
                        <?php foreach ($agentes as $agente) : ?>
                          <option value="<?php echo $agente->id_empresa_flete; ?>"><?php echo $agente->nombre_empresa ?></option>
                        <?php endforeach; ?>
                      </select>





                    </div>

                    <div class="col-md-6">
                      <label for="inputEmail1" class="col-lg-2 control-label">Vendedor:</label>
                      <div class="col-lg-6">



                        <select name="cliente_id" onchange="" class="selectpicker show-menu-arrow" data-style="form-control" data-live-search="true" id="vendedor_id" class="form-control">
                          <option value="">SELECCIONAR VENDEDOR</option>


                          <?php
                          $ves = VendedorData::getAll($_GET['id_sucursal']);
                          foreach ($ves as $ve) : ?>
                            <option value="<?php echo $ve->id; ?>"><?php echo  $ve->nombre . " - " . $ve->cedula  ?></option>
                          <?php endforeach;
                          ?>
                        </select>


                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="form-group">
                          <label for="inputEmail1" class="col-lg-2 control-label">Vehiculo:</label>
                          <div class="col-lg-6">
                            <select name="cliente_id" id="vehiculo_id" class="form-control">
                              <?php
                              $ves = VehiculoData::listar($_GET['id_sucursal']);
                              foreach ($ves as $ve) : ?>
                                <option value="<?php echo $ve->id_vehiculo; ?>"><?php echo  $ve->chapa_nro . " - " . $ve->marca  ?></option>
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
                        <div class="form-group">
                          <label for="inputEmail1" class="col-lg-2 control-label">Punto de llegada:</label>
                          <div class="col-lg-8">
                            <input type="text" class="form-control" id="destino" placeholder="Destino">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="form-group">
                          <label for="inputEmail1" class="col-lg-2 control-label">Tipo Transporte:</label>
                          <div class="col-lg-8">
                            <select class="form-control" name="tipo_transporte" id="tipo_transporte">
                              <option value="1">Particular</option>
                              <option value="2">Tercero</option>



                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <div class="form-group">
                          <label for="inputEmail1" class="col-lg-2 control-label">Peso neto:</label>
                          <div class="col-lg-8">
                            <input type="number" class="form-control" id="peson">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <div class="form-group">
                          <label for="inputEmail1" class="col-lg-2 control-label">Peso bruto:</label>
                          <div class="col-lg-8">
                            <input type="number" class="form-control" id="pesob">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">

                    <!-- <div class="col-md-6">
                      <div class="form-group">
                        <div class="form-group">
                          <label for="inputEmail1" class="col-lg-2 control-label">N° serie placa:</label>
                          <div class="col-lg-8">
                            <input type="number" class="form-control" id="serie_placa" placeholder="N placa:">
                          </div>
                        </div>
                      </div>
                    </div> -->

                  </div>
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
                    <div id="cliente_select">
                    </div>
                    <br>

                  </div> -->
                  <br>
                  <div class="box-header">
                    <br>
                    <i class="fa fa-laptop" style="color: orange;"></i> INGRESAR PRODUCTOS.
                    <input type="text" class="form-control" placeholder="Buscar" onchange="buscar()" onclick="buscar()" id="buscarProducto">
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
                  <h2 class="text-center">Detalle de la remisión:</h2>
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
                  <!-- <div class="col-md-6">
                    <div class="form-group">
                      <div class="form-group">
                        <?php
                        $ves = PlacaData::listar($_GET['id_sucursal']);
                        // var_dump($ves); 
                        ?>
                        <label for="inputEmail1" class="col-lg-2 control-label">Placas: </label>
                        <div class="col-lg-6">
                          <select name="cliente_id" id="vehiculo_id" class="form-control">
                            <?php
                            $ves = PlacaData::listar($_GET['id_sucursal']);
                            foreach ($ves as $ve) : ?>
                              <option value="<?php echo $ve->id_placa; ?>"><?php echo $ve->placa_fin;   ?></option>
                            <?php endforeach;
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div> -->


                  <div class="col-lg-2 ">
                    <select name="cliente_id" id="serie" class="form-control">
                      <?php
                      $ves = PlacaData::listar($_GET['id_sucursal']);
                      foreach ($ves as $ve) : ?>
                        <option value='["<?php echo $ve->registro; ?>","<?php echo $ve->placa_inicio  ?>","<?php echo $ve->placa_fin ?>","<?php echo $ve->id_placa ?>"]'><?php echo $ve->registro . ' inicio: ' . $ve->placa_inicio . ' fin: ' . $ve->placa_fin . " cantidad:" . ($ve->total_placas - $ve->diferencia) ?></option>
                      <?php endforeach;
                      ?>
                    </select>

                  </div>
                  <!-- <h2 class="text-center">Detalle de las placas:</h2>
                  <label for="inputEmail1" class="col-lg-2 control-label">N° placa Inicio:</label>
                  <div class="col-lg-2 ">
                    <input type="number" class="form-control" id="iniciop" placeholder="N Inicio:">

                  </div>
                  <label for="inputEmail1" class="col-lg-2 control-label">N° placa Fin:</label>
                  <div class="col-lg-2">
                    <input type="number" class="form-control" id="finp" placeholder="N Fin:">
                  </div> -->
                  <label for="inputEmail1" class="col-lg-2 control-label">Cantidad:</label>
                  <div class="col-lg-2">
                    <input type="number" class="form-control" value="0" id="cantidadPl">

                  </div>


                  <div class="col-lg-2">

                    <button class="btn btn-info" onclick="agregarPlaca()"> Agregar</button>

                  </div>
                </div>
                <table class="table table-bordered table-hover">
                  <thead>
                    <th>Nro serie</th>

                    <th>Nro Inicial</th>
                    <th>Nro Final</th>
                    <th>Cantidad</th>
                    <th>Acción</th>
                  </thead>
                  <tbody id="tbody">

                  </tbody>
                </table>
                <h3 id="error" class="text-center "></h3>

                <div class="form-group">
                  <div class="col-lg-offset-2">
                    <div class="checkbox">
                      <label>
                        <input type="hidden" name="sucursal_id" id="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
                        <!-- <input type="hidden" value="<?php echo $q1; ?>" id="stock_trans" name="stock_trans" /> -->
                        <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                        <a href="index.php?action=eliminarcompraproductos3&id_sucursal=<?php echo $sucursales->id_sucursal; ?>" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                        <button id="accion" class="btn btn-lg btn-warning" onclick="accion()"><b></b> Finalizar Remision</button></label>

                    </div>
                  </div>
                </div>
              </div>
              <!-- </div> -->
            </div>
          </div>
      </div>
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
    <?php endif ?>
  <?php endif ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
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
    const moneda_principal_global = $("#tipomoneda_id").val();
    let valor_configmasiva_global = $("#cantidaconfigmasiva").val();
    $("#paso2").hide();
    var tipoe = "";
    var tipocliente = 0;
    moneda();
    direccion();
    var placas = [];

    function siguiente() {
      if ($("#configfactura_id").val()) {
        $("#paso2").show();

        $("#paso1").hide();
        console.log($('select[name="cliente_id"] option:selected').text())
        var isRemision = "";
        $("#cliente_select").html(`<h4> Cliente: ${$('select[name="cliente_id"] option:selected').text()} </h4> <h4> Moneda: ${$('select[name="tipomoneda_id"] option:selected').text()} </h4> <h4> tipo de venta: ${$('input[name="metodopago"]:checked').val()} </h4> <h4>  ${$('select[name="configfactura_id"] option:selected').text()} ${isRemision}</h4> `)
      }
      clienteTipo()
    }

    function agregarPlaca() {
      // var pl = $("#serie").val().split(',');
      var pl = JSON.parse($("#serie").val());
      placas.push({
        ini: pl[1],
        fin: pl[2],
        cantidad: $("#cantidadPl").val(),
        serie: pl[0],
        id: pl[3]
      })
      $("#iniciop").val('');
      $("#finp").val('')
      $("#cantidadPl").val('')
      actualizarTablaPlacas()
    }

    function eliminarplaca(id) {

      placas.splice(id, 1);
      actualizarTablaPlacas()
    }

    function actualizarTablaPlacas() {
      tabla = "";
      for (const [id, pago] of Object.entries(placas)) {
        tabla += `<tr><td> ${pago.serie}</td><td> ${pago.ini}</td><td> ${pago.fin}</td><td> ${pago.cantidad}</td> <td> <button class="btn btn-danger" onclick="eliminarplaca(${id})">Eliminar</button></td></tr>`;
      }
      $("#tbody").html(tabla);

    }

    function moneda() {
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
            idtipomoneda = json[0].id_tipomoneda;
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
            idtipomoneda = json[0].id_tipomoneda;
            $("#cambio").val(json[0].valor);
            ajaxConfigMasiva("US$");
          },
          error: function(xhr, status) {
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
        tabla += `<tr><td hidden > ${cart.tipo}</td><td> ${cart.cantidad}</td><td id="${id}1"> ${cart.codigo}</td><td id="${id}3"> ${cart.producto}</td><td id="${id}2"> ${cart.impuesto}</td><td > ${cart.iva}</td><td > ${cart.grabada}</td><td > ${cart.depositotext}</td><td> ${cart.precio}</td><td> ${cart.preciot}</td><td> <button class="btn btn-danger"  onclick="eliminar(${id})">Eliminar</button><button class="btn btn-warning" onclick="editar('${cart.id}',${cart.cantidad},${cart.precio},'${cart.tipo}',${cart.stock},${cart.precioc},${cart.impuesto},'${cart.producto}','${cart.codigo}',${id},'${cart.deposito}','${cart.depositotext}')">Editar</button></td></tr>`;
        if (cart.impuesto == 10) {
          iva10 += parseFloat(cart.iva);
          grabada10 += parseFloat(cart.grabada);
        } else if (cart.impuesto == 5) {
          iva5 += parseFloat(cart.iva);
          grabada5 += parseFloat(cart.grabada);
        } else if (cart.impuesto == 0) {
          exenta = cart.preciot;
        }
        total += parseFloat(cart.preciot);
      }
      // grabada10 = grabada10.toFixed(2);
      // grabada5 = grabada5.toFixed(2);
      // iva10 = iva10.toFixed(2);
      // iva5 = iva5.toFixed(2);
      $("#tablaCarrito").html(tabla);
      $("#txtTotalVentas").val(parseFloat(total).toFixed(2));
      $("#total10").val(parseFloat(grabada10).toFixed(2));
      $("#total5").val(parseFloat(grabada5).toFixed(2));
      $("#iva5").val(parseFloat(iva5).toFixed(2));
      $("#iva10").val(parseFloat(iva10).toFixed(2));
      $("#exenta").val(parseFloat(exenta).toFixed(2));
    }
    $('#dncp').hide();

    function clienteTipo() {
      $.ajax({
        url: 'index.php?action=buscarcliente',
        type: 'GET',
        data: {
          id: $("#cliente_id").val()
        },
        dataType: 'json',
        success: function(json) {
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
        error: function(xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });

    }

    function clienteDncp() {
      console.log('aaaaaaaa')
      $.ajax({
        url: 'index.php?action=listardncp',
        type: 'GET',
        data: {
          id_cliente: $("#cliente_id").val()
        },
        dataType: 'json',
        success: function(json) {
          console.log(json)
          let select = ""
          for (var i = 0; i < json.length; i++) {
            select += `<option value="${json[i].id}">${json[i].modalidad } secuencia: ${json[i].secuencia }</option> `


          }
          $("#dncp-select").html(select);
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
        // $("#error").text("Agregue productos al carrito")
        $("#accion").prop('disabled', false);
        Swal.fire({
          title: "Seleccione un cliente valido",
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
        $("#accion").prop('disabled', false);
        return;
      }
      if (carrito.length == 0) {
        // $("#error").text("Agregue productos al carrito")
        Swal.fire({
          title: "Agregue productos al carrito",
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
        $("#accion").prop('disabled', false);
        return;
      }


      if ($("#vendedor_id").val() == 0) {
        // $("#error").text("Agregue productos al carrito")
        $("#accion").prop('disabled', false);
        Swal.fire({
          title: "Seleccione un Vendedor valido",
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
        $("#accion").prop('disabled', false);
        return;
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
      console.log(idtipomoneda);
      setTimeout(function() {
        $.ajax({
          url: "index.php?action=procesoventaproducto2",
          type: "POST",
          data: {
            cart: carrito,
            tipoventa: $("#tipoventa").val(),
            numeracion_final: numeracion_final,
            diferencia: diferencia,
            configfactura_id: $("#configfactura_id").val(),
            presupuesto: $("#presupuesto").val(),
            serie1: serie1,
            iva10: iva10,
            iva5: iva5,
            exenta: exenta,
            total: total,
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
            remision_id: 0,
            vencimiento: $("#vencimiento").val(),
            cliente_id: $("#cliente_id").val(),
            chofer_id: $("#chofer_id").val(),
            vehiculo_id: $("#vehiculo_id").val(),
            vendedor_id: $("#vendedor_id").val(),
            ciudad_id: $("#ciudades").val(),
            dep_id: $("#dpt_id").val(),
            concepto: $("#concepto").val(),
            vencimiento: $("#vencimiento").val(),
            cuotas: $("#cuotas").val(),
            destino: $("#destino").val(),
            fletera: $('#fletera').val(),
            // inicio: $("#inicio").val(),
            // serie_placa: $("#serie_placa").val(),

            tipo_transporte: $("#tipo_transporte").val(),

            tipo_doc: $("#tipo_doc").val(),
            facturan: $('#facturan').val(),
            placas: placas,
            pesob: $("#pesob").val(),
            peson: $("#peson").val(),
            dncp: $("#dncp-select").val() ? $("#dncp-select").val() : null,

            // fin: $("#fin").val()
          },
          success: function(dataResult) {
            // console.log(dataResult[0]);
            // console.log(dataResult[0].success);

            try {
              if (dataResult.includes("<")) {
                alert("Error al hacer venta");
              } else if (dataResult == -1) {
                alert("Error, producto insuficiente");
              } else {
                alert("Remisión " + dataResult + " realizada con exito ");
                window.location.href = "index.php?view=envioremision&id_sucursal=" + $("#sucursal_id").val();
              }
            } catch (e) {

            }
          }
        });

      }, 500);
      $("#accion").prop('disabled', false);
    }

    function Mostrar() {
      document.getElementById('mostrar').style.display = 'block';
      document.getElementById('ocultar').style.display = 'none';
    }
    Mostrar();
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
      console.log("222aa", id)
      idElimina = id
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
      } else if (stock < parseInt($('#a' + id).val()) && tipo !== 'Servicio') {

        Swal.fire({
          title: "Stock insuficiente",
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
      } else {
        console.log($('#a' + id).val());
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
      var impu = parseInt(impuesto);
      if (impu == 10) {
        iva = (input * parseFloat(precio)) / 11;
        grabada = (input * parseFloat(precio)) / 1.1;
      } else if (impu == 5) {
        iva = (input * parseFloat(precio)) / 21;
        grabada = (input * parseFloat(precio)) / 1.05;
      }
      var totalcart = input * parseFloat(precio);
      carrito.push({
        cantidad: parseFloat(cant),
        codigo: codigo,
        impuesto: parseFloat(impuesto),
        iva: parseFloat(iva).toFixed(2),
        grabada: parseFloat(grabada).toFixed(2),
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
      total += totalcart;
      console.log(carrito)
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
          tipocliente: tipocliente,
          deposito: $("#deposito").val(),
          moneda: idtipomoneda,
          offset: pagina * 5
        },
        cache: false,
        success: function(dataResult) {
          var result = JSON.parse(dataResult);
          totalPages = result.pages
          pagination()
          for (const [id, data_1] of Object.entries(result.result)) {
            if (data_1["producto"]['activo'] == 1) {
              tablab += `<tr>
        <td> ${data_1["producto"]['codigo']}</td>
        <td> ${data_1["producto"]['nombre']}</td>
        <td>${data_1['precio']} </td>
        <td>${data_1["cantidad"]}</td> 
    `;
              if (true) {
                tablab += `    <td><input value="0" max="${parseInt(data_1["cantidad"])}" type="number" id="a${data_1["producto"]["id_producto"]}" class="form-control"> <button 
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
      moneda();
      ajaxConvertirValoresTotales($("#tipomoneda_id").val());

    }
    var ciudades = "";


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
        success: function(dataResult) {
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

    function ciudades(distrito) {
      console.log('222222222', distrito)

    }

    function buscarCiudad(distrito) {
      $.ajax({
        url: "index.php?action=buscarciudad",
        type: "GET",
        data: {
          dpt: distrito,
        },
        cache: false,
        success: function(dataResult) {
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


    function direccion() {
      $.ajax({
        url: 'index.php?action=versucursal',
        type: 'GET',
        data: {
          sucursal: $("#sucursal_id").val()
        },
        dataType: 'json',
        success: function(json) {

          $("#dpt_id").val(json["cod_depart"]);

          buscarCiudad(json["distrito_id"]);

        },
        error: function(xhr, status) {
          console.log("Ha ocurrido un error.111");
        }
      });
    }
    direccion()

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
      //           $("#precio_venta_" + (i + 1)).val(format(($("#precio_venta_hidden_" + (i + 1)).val() * cambio).toFixed(2)));




      //           $("#precio_total_" + (i + 1)).val(format(($("#precio_total_hidden_" + (i + 1)).val() * cambio).toFixed(2)));
      //           $("#iva_" + (i + 1)).html(format(($("#iva_hidden_" + (i + 1)).val() * cambio).toFixed(2)));
      //           $("#gravada_" + (i + 1)).html(format(($("#gravada_hidden_" + (i + 1)).val() * cambio).toFixed(2)));
      //         }
      //         $("#iva10").val(format((total_iva10 * cambio).toFixed(2)));
      //         $("#iva5").val(format((total_iva5 * cambio).toFixed(2)));
      //         $("#total10").val(format((total_gravada10 * cambio).toFixed(2)));
      //         $("#total5").val(format((total_gravada5 * cambio).toFixed(2)));
      //         $("#exenta").val(format((total_exenta * cambio).toFixed(2)));
      //         $("#txtTotalVentas").val(format((total_ventas * cambio).toFixed(2)));
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
      //           $("#precio_venta_" + (i + 1)).val(format(($("#precio_venta_hidden_" + (i + 1)).val() / cambio).toFixed(2)));



      //           $("#precio_total_" + (i + 1)).val(format(($("#precio_total_hidden_" + (i + 1)).val() / cambio).toFixed(2)));
      //           $("#iva_" + (i + 1)).html(format(($("#iva_hidden_" + (i + 1)).val() / cambio).toFixed(2)));
      //           $("#gravada_" + (i + 1)).html(format(($("#gravada_hidden_" + (i + 1)).val() / cambio).toFixed(2)));
      //         }
      //         $("#iva10").val(format((total_iva10 / cambio).toFixed(2)));
      //         $("#iva5").val(format((total_iva5 / cambio).toFixed(2)));
      //         $("#total10").val(format((total_gravada10 / cambio).toFixed(2)));
      //         $("#total5").val(format((total_gravada5 / cambio).toFixed(2)));
      //         $("#exenta").val(format((total_exenta / cambio).toFixed(2)));
      //         $("#txtTotalVentas").val(format((total_ventas / cambio).toFixed(2)));
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

    function getPage(newPage) {
      pagina = newPage
      console.log(pagina)
      buscar()
    }


    function pagination() {
      const limit = 20;
      const currentPage = pagina;

      paginacion = `<nav aria-label="...">
                  <ul class="pagination">
                  `;

      const startPage = Math.floor(currentPage / limit) * limit;
      const endPage = Math.min(startPage + limit, totalPages);

      if (currentPage > 0) {
        paginacion += `<li class="page-item"><a class="page-link" onclick="getPage(${currentPage - 1})">&laquo;</a></li>`;
      }

      for (let i = startPage; i < endPage; i++) {
        paginacion += `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" onclick="getPage(${i})">${i + 1}</a></li>`;
      }

      if (currentPage < totalPages - 1) {
        paginacion += `<li class="page-item"><a class="page-link" onclick="getPage(${currentPage + 1})">&raquo;</a></li>`;
      }

      paginacion += `
                  </ul>
                </nav>`;
      $("#paginacion").html(paginacion);
    }
  </script>