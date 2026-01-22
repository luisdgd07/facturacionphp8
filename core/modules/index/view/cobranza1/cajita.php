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
        <h1> <i class="fa fa-cubes"></i>
          Realizar Cobranza
          <small> </small>
        </h1>
      </section>
      <section class="content">
        <div class="box">
          <div class="box-body">
            <div class="panel-body">
              <form>
                <input type="hidden" name="view" value="cobranza1">
                <div class="row">
                  <div class="col-md-3">



                    <select required="" name="cliente_id" class="form-control">


                      <option value="">SELECCIONAR CLIENTE</option>
                      <?php $clientes = ClienteData::verclientessucursal($sucursales->id_sucursal);
                      if (count($clientes) > 0) {
                        foreach ($clientes as $p) : ?>
                          <option value="<?php echo $p->id_cliente; ?>"><?php echo $p->nombre . " " . $p->apellido; ?></option>
                      <?php endforeach;
                      } ?>
                    </select>
                  </div>







                  <div class="col-md-3">
                    <input type="date" name="sd" id="sd" class="form-control">
                  </div>



                  <div class="col-md-3">
                    <input type="date" name="ed" id="ed" class="form-control">


                  </div>


                  <script type="text/javascript">
                    function obtenerFechaActual() {
                      n = new Date();
                      y = n.getFullYear();
                      m = n.getMonth() + 1;
                      d = n.getDate();
                      return y + "-" + (m > 9 ? m : "0" + m) + "-" + (d > 9 ? d : "0" + d)
                    }

                    //inicializar las fechas del reporte
                    $("#sd").val(obtenerFechaActual());
                    $("#ed").val(obtenerFechaActual());
                  </script>


                  <div class="col-md-3">
                    <input type="submit" class="btn btn-success btn-block" value="Procesar">
                    <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">

                  </div>
                </div>
              </form>
              <?php if (isset($_GET["sd"]) && isset($_GET["ed"])) : ?>
                <?php if ($_GET["sd"] != "" && $_GET["ed"] != "") : ?>
                  <?php
                  $operations = array();
                  if ($_GET["cliente_id"] == "") {
                    $operations = CreditoDetalleData::getAllByDateOp($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
                  } else {
                    $operations = CreditoDetalleData::getAllByDateBCOp($_GET["cliente_id"], $_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
                  }
                  ?>
                  <?php
                  $numero = 0;
                  $recibo = 0;
                  $fecha = 0;
                  $caduca = 0;
                  $turno = 0;
                  $ventarecibo = 0;
                  $ventafactura = 0;
                  $cliente = 0;

                  $apellido = 0;
                  $dni = 0;
                  $id_cliente = 0;
                  $sucursal = 0;
                  $moneda = 0;
                  if (count($operations) > 0) :
                    foreach ($operations as $oper) {
                      $cliente = $oper->cliente()->nombre;
                      $apellido = $oper->cliente()->apellido;
                      $dni = $oper->cliente()->dni;
                      $id_cliente = $oper->cliente()->id_cliente;
                      $recibo = $oper->credito()->venta_id;
                      $caduca = $oper->credito()->vencimiento;
                      $sucursal = $oper->credito()->sucursal_id;
                      $fecha = $oper->fecha;
                      $turno = 0;
                    }
                    $ventas = VentaData::vercontenidos($recibo);
                    if (count($ventas) > 0) {
                      foreach ($ventas as $venta) {
                        $ventarecibo = $venta->VerConfiFactura()->diferencia;
                        $ventafactura = $venta->factura;
                        $moneda = $venta->tipomoneda_id;
                      }
                    }
                  ?>
                    <hr>
                    <form id="cob" class="form-horizontal" enctype="multipart/form-data" method="post" action="index.php?action=cobranzacredito" role="form">

                      <input type="hidden" name="cobro_id" id="cobro_id">
                      <input type="hidden" name="factura" id="num1">
                      <input type="hidden" name="numeracion_inicial" id="numinicio">
                      <input type="hidden" name="numeracion_final" id="numfin">
                      <input type="hidden" name="serie1" id="serie">

                      <label for="inputEmail1" class="col-lg-1 control-label">Tipo doc:</label>
                      <div class="col-lg-2">
                        <?php
                        $clients = ConfigFacturaData::verfacturasucursal3($sucursal);
                        ?>
                        <select required="" name="configfactura_id" id="configfactura_id" class="form-control" oninput="configFactura()">
                          <option value="">Seleccionar</option>

                          <?php foreach ($clients as $client) : ?>
                            <option selected <?php if ($client->diferencia == -1) : ?>disabled="" <?php else : ?><?php endif ?> value="<?php echo $client->id_configfactura; ?>"><?php echo $client->comprobante1; ?></option>
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
                              configFactura()
                            </script>
                          <?php endforeach; ?>
                        </select>
                      </div>


                      <div class="form-group">
                        <div class="col-lg-2">
                          <input type="text" disabled class="form-control" name="recibon" id="recibon" value="<?php $recibos2 = new ConfigFacturaData();
                                                                                                              $recibo2 = $recibos2->verRecibo($_GET['id_sucursal']);
                                                                                                              $j8 = ($recibo2->numeracion_final - $recibo2->diferencia);
                                                                                                              if ($j8 >= 1 & $j8 < 10) {
                                                                                                                echo "000000" . $j8;
                                                                                                              } else {
                                                                                                                if ($j8 >= 10 & $j8 < 100) {
                                                                                                                  echo "00000" . $j8;
                                                                                                                } else {
                                                                                                                  if ($j8 >= 100 & $j8 < 1000) {
                                                                                                                    echo "0000" . $j8;
                                                                                                                  } else {
                                                                                                                    if ($j8 >= 1000 & $j8 < 10000) {
                                                                                                                      echo "000" . $j8;
                                                                                                                    } else {
                                                                                                                      if ($j8 >= 100000 & $j8 < 1000000) {
                                                                                                                        echo "00" . $j8;
                                                                                                                      } else {
                                                                                                                        if ($j8 >= 1000000 & $j8 < 10000000) {
                                                                                                                          echo "0" . $j8;
                                                                                                                        } else {
                                                                                                                          echo $j8;
                                                                                                                        }
                                                                                                                      }
                                                                                                                    }
                                                                                                                  }
                                                                                                                }
                                                                                                              } ?>">

                        </div>
                        <div class="col-lg-2" style="display: none">
                          <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $recibo; ?>">

                        </div>
                        <div>
                          <input type="hidden" name="presupuesto" class="form-control" id="presupuesto" value="0">
                          <input type="hidden" name="id_configfactura" id="id_configfactura">
                          <input type="hidden" name="diferencia" id="diferencia">
                        </div>

                        <label for="inputEmail1" class="col-lg-1 control-label">Fecha:</label>
                        <div class="col-lg-2">
                          <input type="date" class="form-control" name="fecha_recibo" id="fecha_recibo" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <label for="inputEmail1" class="col-lg-1 control-label">Turno:</label>
                        <div class="col-lg-2">
                          <input type="text" class="form-control" name="direccion" id="direccion" value="1">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail1" class="col-lg-1 control-label">Cliente:</label>
                        <div class="col-lg-2">
                          <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $dni; ?>">
                        </div>
                        <div class="col-lg-9">
                          <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $cliente . " " . $apellido; ?>">
                          <input type="hidden" class="form-control" name="cliente" id="cliente" value="<?php echo $id_cliente; ?>">
                          <input type="hidden" class="form-control" name="sucursal" id="sucursal" value="<?php echo $sucursal; ?>">
                          <input type="hidden" class="form-control" name="moneda" id="moneda" value="<?php echo $moneda; ?>">
                          <input type="hidden" name="recibon" id="recibon" value="<?php $recibos2 = new ConfigFacturaData();
                                                                                  $recibo2 = $recibos2->verRecibo($_GET['id_sucursal']);
                                                                                  $j8 = ($recibo2->numeracion_final - $recibo2->diferencia);
                                                                                  if ($j8 >= 1 & $j8 < 10) {
                                                                                    echo "000000" . $j8;
                                                                                  } else {
                                                                                    if ($j8 >= 10 & $j8 < 100) {
                                                                                      echo "00000" . $j8;
                                                                                    } else {
                                                                                      if ($j8 >= 100 & $j8 < 1000) {
                                                                                        echo "0000" . $j8;
                                                                                      } else {
                                                                                        if ($j8 >= 1000 & $j8 < 10000) {
                                                                                          echo "000" . $j8;
                                                                                        } else {
                                                                                          if ($j8 >= 100000 & $j8 < 1000000) {
                                                                                            echo "00" . $j8;
                                                                                          } else {
                                                                                            if ($j8 >= 1000000 & $j8 < 10000000) {
                                                                                              echo "0" . $j8;
                                                                                            } else {
                                                                                              echo $j8;
                                                                                            }
                                                                                          }
                                                                                        }
                                                                                      }
                                                                                    }
                                                                                  } ?>">
                        </div>
                      </div>
                      <hr>
                      <div class="col-md-12">
                        <table id="example1" class="table table-bordered table-hover table-responsive ">
                          <thead>
                            <th style="width: 50px !important;">Nº Crédito</th>
                            <th style="width: 50px;">Nº Factura</th>
                            <th style="width: 50px;">Cuota</th>
                            <th style="width: 50px;">Importe Crédito</th>
                            <th style="width: 50px;">Mon</th>
                            <th style="width: 50px;">Importe Cobro</th>
                            <th style="width: 20px;"></th>
                            <th style="width: 50px;">Fecha Crédito</th>
                            <th style="width: 50px;">Fecha Venc</th>
                            <th style="width: 50px;">Tipo Venta</th>
                          </thead>
                          <?php
                          $sumatotal = 0;
                          $suma = 0;
                          $i = 0;
                          foreach ($operations as $credy) :


                            // aca obtenfo el simbolo de la mondeda
                            $ventas2 = MonedaData::cboObtenerValorPorSucursal2($credy->sucursal_id, $credy->moneda_id);
                            if (count($ventas2) > 0) {

                              $simbolomon = 0;
                              foreach ($ventas2 as $simbolos) {
                                $simbolomon = $simbolos->simbolo;
                              }
                            }


                          ?>
                            <tr>
                              <input type="hidden" name="saldo_credito_cli[]" id="saldo_credito_cli<?php $i ?>" value="<?php echo $credy->saldo_credito; ?>">

                              <td><input style="width: 70px;" <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                            }  ?> type="text" name="credito[]" value="<?= $credy->credito_id; ?>" class="form-control"> </td>

                              <td><input style="width: 130px;" <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                            }  ?> style="width: 130px;" type="hidden" class="form-control" name="clientes[]" id="cliente" value="<?php echo $id_cliente; ?>"><input <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                                                                                                                                                                                                                                  }  ?> class="form-control" type="text" name="factura[]" style="width: 130px;" value="<?= $credy->nrofactura; ?>">
                                <p style="display: none;"><?= $credy->nrofactura; ?> </p>
                              </td>
                              <td><input style="width: 40px;" <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                            }  ?> class="form-control" type="text" name="couta[]" value="<?= $credy->cuota; ?>"></td>
                              <td><input style="width: 80px;" <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                                            }  ?> class="form-control" type="text" name="importecred[]" oninput="deseleccionar(<?= $i ?>,'<?= number_format($credy->saldo_credito, 2); ?>','<?= number_format($credy->importe_credito, 2); ?>',<?= $credy->id; ?>,'<?= number_format($credy->saldo_credito, 2); ?>',<?= $credy->cuota; ?>,'<?= $credy->nrofactura; ?>',<?= $credy->credito_id; ?>)" id="importecred<?php echo $i ?>" value="<?= number_format($credy->importe_credito, 2) ?>"></td>
                              <td><input <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                      }  ?> class="form-control" type="text" name="simbolo[]" value="<?= $simbolomon; ?>"></td>
                              <td><input <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                      }  ?> class="form-control" type="text" oninput="deseleccionar(<?= $i ?>,'<?= number_format($credy->saldo_credito, 2); ?>','<?= number_format($credy->importe_credito, 2); ?>',<?= $credy->id; ?>,'<?= number_format($credy->saldo_credito, 2); ?>',<?= $credy->cuota; ?>,'<?= $credy->nrofactura; ?>',<?= $credy->credito_id; ?>)" id="monto<?= $i ?>" name="monto[]" value="<?= number_format($credy->saldo_credito, 2); ?>"> </td>
                              <td><input <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                      }  ?> type="checkbox" name="check[]" onclick="agregar('<?= $credy->saldo_credito; ?>',<?= $i ?>,<?= $credy->id; ?>,'<?= number_format($credy->saldo_credito, 2); ?>',<?= $credy->cuota; ?>,<?= $credy->fecha; ?>,'<?= $credy->nrofactura; ?>',<?= $credy->credito_id; ?>)" id="check<?= $i ?>" value="<?= $credy->id; ?>"></td>
                              <td><input <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                      }  ?> type="hidden" class="form-control" name="sucursall[]" id="sucursall" value="<?php echo $sucursal; ?>"><?= $credy->fecha; ?></td>
                              <td <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                }  ?>><?= $credy->fecha_detalle; ?></td>
                              <td <?php if ($credy->saldo_credito == 0) { ?> disabled="disabled" <?php } else {
                                                                                                }  ?>>VENTAS</td>
                            </tr>

                            <!-- <tr>
                              <td> </td>

                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr> -->
                            <?php


                            ?>


                          <?php

                            $i++;



                          endforeach; ?>

                        </table>
                        <div class="col-md-6">
                          Total:
                        </div>
                        <div class="col-md-6">
                          <input type="text" disabled class="form-control" id="totalc">
                        </div>
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
                                      <?php foreach ($tipos as $tipo) : ?>

                                        <option value="<?php echo $tipo->id_tipo ?>"><?= $tipo->nombre ?></option>
                                      <?php endforeach; ?>
                                    </select>
                                    <select required="" style="margin-top: 15px;" id="tipopago" class="form-control">
                                    </select>
                                    <input type="text" name="" style="margin-top: 15px;" class="form-control" placeholder="Vaucher" id="vaucher">
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
                                  <?php
                                  $cotizacion = CotizacionData::versucursalcotizacion($_GET['id_sucursal']);
                                  // var_dump($cotizacion);
                                  $mon = MonedaData::cboObtenerValorPorSucursal3($_GET['id_sucursal']);
                                  if (count($cotizacion) > 0) { ?>
                                    <?php
                                    $valores = 0;
                                    foreach ($cotizacion as $moneda) {
                                      $mon = MonedaData::cboObtenerValorPorSucursal3($_GET['id_sucursal']);
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
                                  <div class="col-md-2">Monto:</div>
                                  <div class="col-md-2"><input type="number" value="0" class="form-control" id="monto"></div>
                                  <div class="col-md-2" style="margin-top: 15px;">Cambio:</div>
                                  <div class="col-md-2" style="margin-top: 15px;">
                                    <input type="text" onchange="tipocambio()" name="cambio2" id="cambio2" value="<?php echo $valores; ?>" class="form-control">
                                    <!-- <input type="number" name="" value="0" class="form-control" id="cambi"> -->
                                  </div>
                                  <div class="retencionCampos" id="retencionCampos">
                                    <div class="col-md-2" id="fechaRetencionT">Fecha Retencion:</div>
                                    <div class="col-md-2"><input type="date" id="fechaRetencion" name="" value="<?php echo $_GET["ed"]; ?>" class="form-control"></div>
                                    <div class="col-md-2" id="tipoRetencionT">Tipo Retencion:</div>
                                    <div class="col-md-2">
                                      <select name="" id="tipoRetencion" class="form-control">
                                        <option value="IVA">IVA</option>
                                        <option value="RENTA">RENTA</option>
                                      </select>
                                    </div>
                                    <div class="col-md-2" id="usuarioT">N° Retención:</div>
                                    <div class="col-md-2"><input type="text" id="numret" name="" value="" class="form-control"></div>
                                    <div class="col-md-2" id="usuarioT">N° Timbrado:</div>
                                    <div class="col-md-2"><input type="text" id="usuario" name="" value="" class="form-control"></div>

                                  </div>
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
                                      <th>Tipo Retención</th>
                                      <th>Fecha Retención</th>
                                      <th>N° Timbrado</th>
                                      <th>N° Retención</th>


                                      <th>Acción</th>
                                    </thead>
                                    <tbody id="tbody">

                                    </tbody>
                                  </table>
                                </div>
                                <div class="row" style="margin-bottom: 15px;">
                                  <div class="col-md-2">Concepto:</div>
                                  <div class="col-md-2"><input type="text" name="" value="" class="form-control" id="concepto"></div>

                                </div>
                                <div class="row">
                                  <div class="col-md-2">Total recibido</div>
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
                        <div class="col-md-12">
                          <input type="submit" class="btn btn-info btn-block" onclick="pagar()" value="Cobrar">
                          <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">


                        </div>
                        <br>
                        <hr>
                        <div class="form-group">
                          <label for="inputEmail1" class="col-lg-2 control-label">De Fecha:</label>
                          <div class="col-lg-2">
                            <input type="date" class="form-control" name="direccion" id="direccion" value="<?php echo $_GET["sd"]; ?>">
                          </div>
                          <label for="inputEmail1" class="col-lg-2 control-label">A Fecha:</label>
                          <div class="col-lg-2">
                            <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $_GET["ed"]; ?>">
                          </div>

                        </div>
                      <?php else :
                      // si no hay operaciones
                      ?>
                        <script>
                          $("#wellcome").hide();
                        </script>
                        <div class="jumbotron">
                          <h2>No hay registro de cuotas pendientes a cobrar</h2>
                          <p>El rango de fechas seleccionado no proporciono ningun resultado.</p>
                        </div>

                      <?php endif; ?>
                    <?php else : ?>
                      <script>
                        $("#wellcome").hide();
                      </script>
                      <div class="jumbotron">
                        <h2>Fecha Incorrectas</h2>
                        <p>Puede ser que no selecciono un rango de fechas, o el rango seleccionado es incorrecto.</p>
                      </div>
                      </div>







                    </form>
                  <?php endif; ?>

                <?php endif; ?>

            </div>
          </div>
        </div>

      </section>
      <script>
        var filas = 0;
        var pagos = [];
        var totalCobrar = 0;
        var totalACobrar = 0;
        var cambio = 1;
        var totalCobro = $("#cobror").html();
        var cantidades = [];
        $("input[name='monto[]']").each(function(index) {
          filas++;
        });
        agregar();
        var checkbox = [];
        var total = 0;
        var totalCredito = 0;
        var saldo_credito_cli = [];
        var montos = [];
        var creditos = [];
        var cuotas = [];
        var fechas = [];
        var monedas = []
        var recibos = [];
        var crediton = [];
        tipo()


        $('#totalc').val(total);
        // $.ajax({
        //   url: 'index.php?action=consultamoneda',
        //   type: 'POST',
        //   cache: false,
        //   data: {
        //     sucursal: $("#sucursal_id").val(),
        //     simbolo: moneda_principal_global, //simbolo
        //     accion: "obtenerCambioPorSimbolo"
        //   },
        //   dataType: 'json',
        //   success: function(json) {
        //     $("#cambio").val(json[0].valor);

        //     valor_dolar_global = json[0].valor;
        //     ajaxConfigMasiva("₲");

        //   },
        //   error: function(xhr, status) {
        //     console.log("Ha ocurrido un error.");
        //   }
        // });
        const number = 1200;
        const number2 = 12000;
        console.log(number.toLocaleString('es-MX')); // 1200
        console.log(new Intl.NumberFormat('es-MX').format(number)); // 1200
        console.log(number2.toLocaleString('es-MX')); // 12,000
        console.log(new Intl.NumberFormat('es-MX').format(number2)); // 12,000

        function deseleccionar(check, precio, credito, val, cuota, moneda, recibo, crediton) {
          if ($(`#check${check}`).prop('checked')) {

            let a = parseFloat(precio.replace(',', ''));

            total = total - a;
            console.log('des', total)
            let fo = credito.replace(',', '');
            totalCredito -= parseFloat(fo);
            if (total < 0 || NaN) {
              $('#totalc').val(0);

            } else {
              $('#totalc').val(total);

            }
            $(`#check${check}`).prop('checked', false);
            console.log('cred', totalCredito);
            // checkbox.filter((item) => item !== val)
            // var indice = checkbox.indexOf(val);
            // checkbox.splice(indice, 1);
            try {
              for (var i = checkbox.length; i--;) {
                if (checkbox[i] === val) {
                  checkbox.splice(i, 1);
                  saldo_credito_cli.splice(i, 1);
                  montos.splice(i, 1);
                  cuotas.splice(i, 1);
                  creditos.splice(i, 1);
                  fechas.splice(i, 1);
                  monedas.splice(i, 1);
                  recibos.splice(i, 1);
                  crediton.splice(i, 1);
                }
              }
            } catch (e) {
              console.log(e)
            }

          }
          console.log(checkbox, saldo_credito_cli);
        }

        function agregar(precio, check, val, val2, cuota, fecha, recibo, ncredito) {
          // console.log('preeee', $(`#monto${check}`).val().replace(',', ''));
          let montore = 0;
          if ($(`#check${check}`).prop('checked')) {
            montore = parseFloat(($(`#monto${check}`).val()).replace(',', ''));
            total += montore;
            montos.push(parseFloat(($(`#monto${check}`).val()).replace(',', '')));
            // montos.push(parseFloat(($(`#monto${check}`).val()).replace(',', '')));
            totalCredito += parseFloat(($(`#importecred${check}`).val()).replace(',', ''));
            checkbox.push(val);
            cuotas.push(cuota);
            saldo_credito_cli.push(val2.replace(',', ''));
            creditos.push(parseFloat(($(`#importecred${check}`).val()).replace(',', '')))
            fechas.push(fecha);
            recibos.push(recibo);
            crediton.push(ncredito);
          } else {
            let credit1 = 0;
            // checkbox.indexOf(val);
            // var indice = checkbox.indexOf(val);
            // checkbox.splice(indice, 1);
            try {
              montore = parseFloat(($(`#monto${check}`).val()).replace(',', ''));
              let credit1 = parseFloat($(`#importecred${check}`).val().replace(',', ''));
              for (var i = checkbox.length; i--;) {
                if (checkbox[i] === val) {
                  checkbox.splice(i, 1);
                  saldo_credito_cli.splice(i, 1);
                  montos.splice(i, 1);
                  cuotas.splice(i, 1);
                  creditos.splice(i, 1);
                  fechas.splice(i, 1);
                  recibos.splice(i, 1);
                  crediton.splice(i, 1);
                }
              }
            } catch (e) {
              console.log(e)
            }

            if (total < 0 || NaN) {
              $('#totalc').val(0);

            } else {
              try {
                total -= montore;
                totalCredito -= credit1;
                console.log('to cred', totalCredito)
              } catch (e) {}

            }

          }
          // });
          $('#totalc').val(total);
          totalACobrar = total;
          $("#monto").val(parseFloat(total));
          //     if ($("#tipomoneda_id").val("US$")) {
          $("#cobror").html(parseFloat(total));
          //   totalACobrar = parseFloat(total * $("#cambio2").val())
          //   // US$
          // } else {

          //   $("#cobror").html(parseFloat(total));
          //   totalACobrar = parseFloat(total)

          // }
          console.log(crediton)
          console.log('re', recibos);

          actualizarTablacobro();
        }

        function pagar() {
          if ($("#totalc").val() == 0) {
            Swal.fire({
              title: "Monto invalido",
              icon: 'error',
              confirmButtonText: 'Aceptar'
            });

          } else if (totalCredito < total) {
            Swal.fire({
              title: "Monto supera la deuda",
              icon: 'error',
              confirmButtonText: 'Aceptar'
            });
          } else if (pagos.length == 0) {
            Swal.fire({
              title: "Agregue metodo de pago",
              icon: 'error',
              confirmButtonText: 'Aceptar'
            });
          } else {
            // let check = [];
            // console.log($("[name='check[]']").attr("value"));
            // $("input[name='check[]']").each(function() {
            //   if ($('#checkboxId').is(':checked')) {
            //     console.log($(this).val());
            //     check.push($(this).val());
            //   }

            // });
            // console.log(check);
            $.ajax({
              url: 'index.php?action=cobranzacredito',
              type: 'POST',
              data: {
                check: checkbox,
                cobro_id: $("[name='cobro_id']").attr("value"),
                saldo_credito_cli: saldo_credito_cli,
                monto: montos,
                serie1: $("[name='serie1']").attr("value"),
                numeracion_final: $("[name='numeracion_final']").attr("value"),
                diferencia: $("[name='diferencia']").attr("value"),
                id_configfactura: $("#id_configfactura").val(),
                recibon: $("[name='recibon']").attr("value"),
                fecha_recibo: $("[name='fecha_recibo']").attr("value"),
                configfactura_id: $("#id_configfactura").val(),
                cliente: $("#cliente").val(),
                factura: recibos,
                couta: cuotas,
                credito: crediton,
                sucursal: $("[name='sucursal']").attr("value"),
                importecred: creditos,
                sucursall: fechas,
                // moneda: monedas,
                moneda: $("#moneda").val(),
                pagos: pagos,
                total: $("#cobror").text(),
                sucursal: '<?= $_GET['id_sucursal'] ?>',
                cliente: $("#cliente").val(),
                cobro: cobroId,
                concepto: $("#concepto").val(),
                fecha: $("#fecha_recibo").val()
              },
              dataType: 'json',
              success: function(json) {
                if (json == -1) {
                  Swal.fire({
                    title: "Error",
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                  });
                } else {
                  // var win = window.open("impresioncobro.php?cobro=" + cobroId, '_blank');

                  window.location.href = "index.php?view=detallecobros&COBRO_ID=" + cobroId;
                  // if ('<?= $_GET['id_sucursal'] ?>' == '17') {
                  //   window.location.href = "impresioncobro.php?cobro=" + cobroId;

                  // } else {
                  //   window.location.href = "impresioncobro_2.php?cobro=" + cobroId;

                  // }
                }

              },
              error: function(xhr, status) {
                console.log("Ha ocurrido un error." + JSON.stringify(xhr[1]));
              }
            });
            // $.ajax({
            //   url: 'index.php?action=cobrocaja',
            //   type: 'POST',
            //   data: {
            //     pagos: pagos,
            //     total: $("#cobror").text(),
            //     sucursal: '<?= $_GET['id_sucursal'] ?>',
            //     cliente: $("#cliente").val(),
            //     cobro: cobroId,
            //     concepto: $("#concepto").val(),
            //     fecha: $("#fecha_recibo").val()
            //   },
            //   dataType: 'json',
            //   success: function(json) {

            //     // window.location.href = "impresioncobro.php?cobro=" + cobroId;

            //   },
            //   error: function(xhr, status) {
            //     console.log("Ha ocurrido un error." + JSON.stringify(xhr));
            //   }
            // });
            // setTimeout(function() {
            //   // $("#cob").submit();

            // }, 3000);
          }


        }

        function actualizarTablacobro() {
          tabla = "";
          for (const [id, pago] of Object.entries(pagos)) {
            tabla += `<tr><td> ${pago.tipo}</td><td> ${pago.tipo_tar2}</td><td> ${pago.vaucher}</td><td> ${new Intl.NumberFormat('es-MX').format(pago.monto)}</td><td> ${new Intl.NumberFormat('es-MX').format(pago.monto2)}</td>
                        <td> ${pago.moneda}</td><td> ${pago.cambio}</td><td> ${pago.tiporet}</td><td> ${pago.fecha}</td><td> ${pago.usuario}</td><td>${pago.numret}</td><td> <button class="btn btn-danger" onclick="eliminarcobro(${id})">Eliminar</button></td></tr>`;
          }
          $("#tbody").html(tabla);


          if (totalCobrar > totalACobrar) {
            $("#pagar").show();
            $("#total").html(totalCobrar + " Vuelto: " + (totalCobrar - totalACobrar));
            $("#monto").val(0);
          } else {

            $("#total").html(totalCobrar + " Restante: " + (totalACobrar - totalCobrar));
            $("#pagar").hide();
          }
        }
        actualizarTablacobro()

        function agregarPago() {
          tabla = "";
          totalCobrar += parseFloat($('#monto').val()) * cambio;
          // pagos.push({
          //   "tipo_id": $('#tipopago_id').val(),
          //   "cambio": $("#cambio2").val(),
          //   "moneda_id": $('#tipomoneda_id2').val(),
          //   "tipo": $('select[name="tipopago_id"] option:selected').text(),

          //   "moneda": $('select[name="tipomoneda_id2"] option:selected').text(),
          //   "monto2": parseFloat($('#monto').val() * $("#cambio2").val()).toFixed(2),
          //   "monto": parseFloat($('#monto').val()),

          //   "tipo_tar": $('#tipopago').val(),
          //   "tipo_tar2": $('select[name="tipopago"] option:selected').text(),
          //   "vaucher": $("#vaucher").val(),
          //   "tiporet": $('#tipoRetencion').val(),
          //   "fecha": $('#fechaRetencion').val(),
          //   "usuario": $('#usuario').val(),
          // });
          console.log($('#tipopago_id').val());
          if ($('#tipopago_id').val() == 5) {
            pagos.push({
              "tipo_id": $('#tipopago_id').val(),
              "cambio": $("#cambio2").val(),
              "moneda_id": $('#tipomoneda_id2').val(),
              "tipo": $('select[name="tipopago_id"] option:selected').text(),

              "moneda": $('select[name="tipomoneda_id2"] option:selected').text(),
              "monto2": (parseFloat($('#monto').val() * $("#cambio2").val())).toFixed(2),
              "monto": (parseFloat($('#monto').val())).toFixed(2),

              "tipo_tar": $('#tipopago').val(),
              "tipo_tar2": $('select[name="tipopago"] option:selected').text(),
              "vaucher": $("#vaucher").val(),
              "tiporet": $('#tipoRetencion').val(),
              "fecha": $('#fechaRetencion').val(),
              "usuario": $('#usuario').val(),
              "numret": $('#numret').val(),
            });
            $('#tipoRetencion').val('')
            $('#fechaRetencion').val('')
            $('#usuario').val('')
            $('#numret').val('')
          } else {
            pagos.push({
              "tipo_id": $('#tipopago_id').val(),
              "cambio": $("#cambio2").val(),
              "moneda_id": $('#tipomoneda_id2').val(),
              "tipo": $('select[name="tipopago_id"] option:selected').text(),

              "moneda": $('select[name="tipomoneda_id2"] option:selected').text(),
              "monto2": parseFloat($('#monto').val() * $("#cambio2").val()).toFixed(2),
              "monto": parseFloat($('#monto').val()),

              "tipo_tar": $('#tipopago').val(),
              "tipo_tar2": $('select[name="tipopago"] option:selected').text(),
              "vaucher": $("#vaucher").val(),
              "tiporet": '',
              "fecha": '',
              "usuario": '',
              "numret": ''
            });
          }



          actualizarTablacobro()
          $('#monto').val("0");
        }

        function eliminarcobro(id) {
          try {
            console.log(pagos[id]['monto']);
            let re = (pagos[id]['monto']);
            var resta = parseFloat(re);
            totalCobrar = totalCobrar - resta;
            console.log(totalCobrar);
            pagos.splice(id, 1);

          } catch (e) {
            console.log(e)
          }
          actualizarTablacobro()
        }
        id_cobro()

        function id_cobro() {
          $.ajax({
            url: 'index.php?action=obtenercobroid',
            type: 'GET',
            data: {},
            dataType: 'json',
            success: function(json) {
              cobroId = json;
              $("#cobro_id").val(json);
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
            $("#retencionCampos").show();

          } else {
            tipopago = ""
            $("#tipopago").hide();
            $("#vaucher").hide();

          }
        }
        $("#total").html(totalCobrar + " Restante: " + 0);
        $("#retencionCampos").hide();

        function tipo() {
          if ($("#tipopago_id").val() == 4) {
            $("#tipopago").show();
            $("#vaucher").show();
            $("#retencionCampos").hide();
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
            $("#retencionCampos").show();

          } else {
            tipopago = ""
            $("#tipopago").hide();
            $("#vaucher").hide();
            $("#retencionCampos").hide();
          }
        }
      </script>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <?php endif ?>
<?php endif ?>