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
          Reporte de Cobranza por clientes
          <small> </small>
        </h1>
      </section>
      <section class="content">
        <div class="box">
          <div class="box-body">
            <div class="panel-body">
              <form>
                <input type="hidden" name="view" value="reporte_cobro">
                <div class="row">
                  <div class="col-md-3">



                    <select name="cliente_id" class="form-control">

                      <?php $clientes = ClienteData::verclientessucursal($sucursales->id_sucursal);
                      if (count($clientes) > 0) {
                        foreach ($clientes as $p) : ?>
                          <option value="<?php echo $p->id_cliente; ?>"><?php echo $p->nombre . " " . $p->apellido; ?></option>
                      <?php endforeach;
                      } ?>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <input type="date" name="sd" value="<?php if (isset($_GET["sd"])) {
                                                          echo $_GET["sd"];
                                                        } ?>" class="form-control">
                  </div>
                  <div class="col-md-3">
                    <input type="date" name="ed" value="<?php if (isset($_GET["ed"])) {
                                                          echo $_GET["ed"];
                                                        } ?>" class="form-control">
                  </div>
                  <div class="col-md-3">
                    <input type="submit" class="btn btn-success btn-block" value="Ver Detalle Cobranza">
                    <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">







                    <script>
                      function exportar() {
                        cliente_id = document.getElementById("cliente_id").value;
                        date1 = document.getElementById("sd").value;
                        date2 = document.getElementById("ed").value;
                        id_sucursal = document.getElementById("id_sucursal").value;
                        window.location.href = `cobranzacliente.php?&uso_id=&cliente_id=${cliente_id}&sd=${sd}&ed=${ed}&id_sucursal=${id_sucursal}`;


                      }


                      function exportar2() {
                        date1 = document.getElementById("sd").value;
                        date2 = document.getElementById("ed").value;
                        id_sucursal = document.getElementById("id_sucursal").value;
                        window.location.href = `excels/csvVenta.php?&uso_id=&sd=${sd}&ed=${ed}&id_sucursal=${id_sucursal}`;
                      }
                    </script>





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
                  $dni = 0;
                  $id_cliente = 0;
                  $sucursal = 0;
                  $moneda = 0;
                  if (count($operations) > 0) :
                    foreach ($operations as $oper) {
                      $cliente = $oper->cliente()->nombre;
                      $dni = $oper->cliente()->dni;
                      $id_cliente = $oper->cliente()->id_cliente;
                      $recibo = $oper->credito()->venta_id;
                      $caduca = $oper->credito()->vencimiento;
                      $sucursal = $oper->credito()->sucursal_id;
                      $moneda = $oper->credito()->moneda_id;


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
                    <form class="form-horizontal" enctype="multipart/form-data" method="post" action="index.php?action=cobranzacredito1" role="form">

                      <div class="form-group">
                        <label for="inputEmail1" class="col-lg-1 control-label">Cliente:</label>
                        <div class="col-lg-2">
                          <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $dni; ?>">
                        </div>
                        <div class="col-lg-9">
                          <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $cliente; ?>">
                          <input type="hidden" class="form-control" name="cliente" id="cliente" value="<?php echo $id_cliente; ?>">
                          <input type="hidden" class="form-control" name="sucursal" id="sucursal" value="<?php echo $sucursal; ?>">
                          <input type="hidden" class="form-control" name="moneda" id="moneda" value="<?php echo $moneda; ?>">

                        </div>
                      </div>
                      <hr>
                      <div class="col-md-12">
                        <table class="table table-bordered">
                          <thead>
                            <th>Nº Crédito</th>


                            <th>Nº Factura</th>
                            <th>Cuota</th>
                            <th>Importe Crédito</th>
                            <th>Mon</th>
                            <th>Importe Cobrado</th>

                            <th>Fecha Crédito</th>
                            <th>Fecha Venc</th>
                            <th>Tipo Venta</th>
                          </thead>
                          <?php foreach ($operations as $credy) :

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
                              <td><input type="text" name="credito[]" value="<?= $credy->credito_id; ?>" class="form-control"></td>

                              <td><input class="form-control" type="hidden" class="form-control" name="clientes[]" id="cliente" value="<?php echo $id_cliente; ?>"><input class="form-control" type="text" name="factura[]" value="<?= $credy->nrofactura; ?>"></td>
                              <td><input class="form-control" type="text" name="couta[]" value="<?= $credy->cuota; ?>"></td>
                              <td><input class="form-control" type="text" name="importecred[]" value="<?= $credy->importe_credito; ?>"></td>
                              <td><input class="form-control" type="text" name="simbolo[]" value="<?= $simbolomon; ?>"></td>
                              <td><input class="form-control" type="number" name="monto[]" value="<?= $credy->saldo_credito; ?>"></td>

                              <td><input type="hidden" class="form-control" name="sucursall[]" id="sucursall" value="<?php echo $sucursal; ?>"><?= $credy->fecha; ?></td>
                              <td><?= $credy->fecha_detalle; ?></td>
                              <td>VENTAS</td>
                            </tr>
                          <?php
                          endforeach; ?>

                        </table>
                        <div class="col-md-12">

                          <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                        </div>
                        <br>
                        <hr>

                      <?php else :
                      // si no hay operaciones
                      ?>
                        <script>
                          $("#wellcome").hide();
                        </script>
                        <div class="jumbotron">
                          <h2>No hay registro de creditos pendientes a cobrar</h2>
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
    </div>









  <?php endif ?>
<?php endif ?>