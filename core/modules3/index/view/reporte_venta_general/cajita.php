<?php
$u = null;
if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
  $u = UserData::getById($_SESSION["admin_id"]);
?>
  <?php if ($u->is_admin) : ?>
    <?php
    // $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
    ?>



    <div class="content-wrapper">
      <section class="content-header">
        <h1> <i class="fa fa-cubes"></i>
          Reporte de ventas por Empresa
          <small> </small>
        </h1>
      </section>
      <section class="content">
        <div class="box">
          <div class="box-body">
            <div class="panel-body">
              <form>
                <input type="hidden" name="view" value="reporte_venta_general">
                <div class="row">
                  <div class="col-md-3">



                    <select name="id_sucursal" id="id_sucursal" class="form-control">

                      <?php $clientes = SuccursalData::vercontenido();



                      if (count($clientes) > 0) {
                        foreach ($clientes as $p) : ?>
                          <option value="<?php echo $p->id_sucursal; ?>"><?php echo $p->nombre; ?></option>
                      <?php endforeach;
                      } ?>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <input type="date" name="sd" id="sd" value="<?php if (isset($_GET["sd"])) {
                                                                  echo $_GET["sd"];
                                                                } ?>" class="form-control">
                  </div>
                  <div class="col-md-3">
                    <input type="date" name="ed" id="ed" value="<?php if (isset($_GET["ed"])) {
                                                                  echo $_GET["ed"];
                                                                } ?>" class="form-control">
                  </div>
                  <div class="col-md-3">
                    <input type="submit" class="btn btn-success btn-block" value="Ver reporte">











                  </div>
                </div>
              </form>
              <button onclick="exportar2()" href="" class="mx-4 my-2 btn btn-success">Exportar en Excel</button>


              <script>
                function exportar2() {
                  date1 = document.getElementById("sd").value;
                  date2 = document.getElementById("ed").value;
                  id_sucursal = document.getElementById("id_sucursal").value;
                  console.log(`csvVenta.php?&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}`);
                  window.location.href = `excels/csvVenta.php?&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}`;
                }
              </script>
              <?php if (isset($_GET["sd"]) && isset($_GET["ed"])) : ?>
                <?php if ($_GET["sd"] != "" && $_GET["ed"] != "") : ?>
                  <?php
                  $operations = array();
                  if ($_GET["id_sucursal"] == "") {
                    $operations = VentaData::getAllByDateOfficialGs($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
                  } else {
                    $operations = VentaData::getAllByDateOfficialGs($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], 2);
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
                      $cliente = $oper->verSocursal()->nombre;
                    }


                  ?>
                    <hr>
                    <form class="form-horizontal" enctype="multipart/form-data" method="post" action="index.php?action=cobranzacredito1" role="form">

                      <div class="form-group">
                        <label for="inputEmail1" class="col-lg-1 control-label">Empresa:</label>
                        <div class="col-lg-2">
                          <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $cliente; ?>">
                        </div>
                        <div class="col-lg-9">


                        </div>
                      </div>
                      <hr>
                      <div class="col-md-12">
                        <table class="table table-bordered">
                          <thead>
                            <th width="110px">RUC</th>
                            <th width="160px">Cliente</th>
                            <th width="150px">Factura</th>
                            <th width="110px">Timbrado</th>
                            <th>Fecha</th>
                            <th>Gravada 10</th>
                            <th width="110px">IVA 10</th>

                            <th width="110px">Total</th>
                            <th>Cond. de venta</th>

                          </thead>


                          <?php
                          $total2 = 0;
                          $total = 0;
                          $totalg = 0;
                          $totali = 0;

                          $totalg5  = 0;
                          $totalii5  = 0;
                          $totalexent  = 0;

                          $cambio = 0;




                          foreach ($operations as $operation) :







                            if ($operation->simbolo2 == "US$") {
                              $cambio = $operation->cambio;
                            } else if (($operation->simbolo2 == "₲") and  ($operation->cambio == 1)) {
                              $cambio = $operation->cambio2;
                            } else if (($operation->simbolo2 == "₲") and  ($operation->cambio > 1)) {
                              $cambio = 1;
                            }

                            $total = $total + ($operation->total * $cambio);
                            $totalg = $totalg + ($operation->total10 * $cambio);
                            $totali = $totali + ($operation->iva10 * $cambio);
                            $totalg5 = $totalg5 + ($operation->total5 * $cambio);
                            $totalii5 = $totalii5 + ($operation->iva5 * $cambio);
                            $totalexent = $totalexent + ($operation->exenta * $cambio);







                          ?>
                            <tr>


                              <th><input class="form-control" type="text" name="1" value="<?= ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? "X"
                                                                                            : ($operation->getCliente()->tipo_doc == "CI" ? $operation->getCliente()->dni
                                                                                              : $operation->getCliente()->dni)); ?>"></td>


                              <th><input class="form-control" type="text" name="2" value="<?= ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? $operation->getCliente()->tipo_doc
                                                                                            : $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido); ?>"></td>
                              <td><input class="form-control" type="text" name="3" value="<?= $operation->factura; ?>"></td>
                              <td><input class="form-control" type="text" name="4" value="<?= $operation->VerConfiFactura()->timbrado1; ?>"></td>
                              <td><input class="form-control" type="text" name="5" value="<?= $operation->fecha; ?>"></td>
                              <td><input class="form-control" type="text" name="6" value="<?= number_format(($operation->total10 * $cambio), 4, ',', '.'); ?>"></td>
                              <td><input class="form-control" type="text" name="7" value="<?= number_format(($operation->iva10 * $cambio), 4, ',', '.'); ?>"></td>


                              <td><input class="form-control" type="text" name="8" value="<?= number_format(($operation->total * $cambio), 4, ',', '.'); ?>"></td>


                              <td><input class="form-control" type="text" name="9" value="<?= $operation->metodopago; ?>"></td>





                            </tr>
                          <?php
                          endforeach; ?>



                        </table>
                        <div class="col-md-12">

                          <label for="inputEmail1" class="col-lg-1 control-label">TOTAL GS:</label>
                          <input type="text" name="venntotal" id="venntotal" value="<?php echo   number_format(($total = $total + ($operation->total * $cambio)), 4, ',', '.'); ?>">
                          <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $P->id_sucursal; ?>">
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
                          <h2>No hay registro de ventas</h2>
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