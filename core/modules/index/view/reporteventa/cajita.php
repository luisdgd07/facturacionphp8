  <?php
  $u = null;
  if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
    $u = UserData::getById($_SESSION["admin_id"]);
  ?>
    <!-- Content Wrapper. Contains page content -->
    <?php if ($u->is_admin) : ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1> <i class="fa  fa-bar-chart" style="color: orange;"></i>
            REPORTE
          </h1>
        </section>
        <section class="content">
          <div class="box">
            <div class="box-header with-border">
            </div>
            <div class="box-body">
              <form>
                <input type="hidden" name="view" value="reporteventa">
                <div class="row">
                  <div class="col-md-3">

                    <select name="uso_id" class="form-control">
                      <option value="">-- REPORTE POR TODOS --</option>
                      <!-- <?php foreach ($clients as $p) : ?>
              <option value="<?php echo $p->cliente_id; ?>"><?php if ($p->cliente_id != null) {
                                                              echo $p->getCliente()->nombre . " " . $p->getCliente()->apellido;
                                                            } else {
                                                              echo "";
                                                            }  ?></option>
              <?php endforeach; ?> -->
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
                    <input type="submit" class="btn btn-warning btn-block" value="Procesar">
                  </div>

                </div>
              </form>
              <div class="row">

                <div class="col-md-12">
                  <?php if (isset($_GET["sd"]) && isset($_GET["ed"])) : ?>
                    <?php if ($_GET["sd"] != "" && $_GET["ed"] != "") : ?>
                      <?php
                      $operations = array();

                      if ($_GET["uso_id"] == "") {
                        $operations = VentaData::getAllByDateOfficial($_GET["sd"], $_GET["ed"], 2);
                      } else {
                        $operations = VentaData::getAllByDateBCOpp($_GET["uso_id"], $_GET["sd"], $_GET["ed"], 2);
                      }


                      ?>

                      <?php if (count($operations) > 0) : ?>
                        <?php $supertotal = 0; ?>
                        <table class="table table-bordered">
                          <thead>

                            <th>Subtotal</th>
                            <th>Descuento</th>
                            <th>Total</th>
                            <th>Fecha</th>
                          </thead>
                          <?php foreach ($operations as $operation) : ?>
                            <tr>
                              <td> <?php echo number_format($operation->total, 0, '.', '.'); ?></td>
                              <td> <?php echo number_format($operation->descuento, 0, '.', '.'); ?></td>
                              <td> <?php echo number_format($operation->total - $operation->descuento, 0, '.', '.'); ?></td>
                              <td><?php echo $operation->fecha; ?></td>
                            </tr>
                          <?php
                            $supertotal += ($operation->total - $operation->descuento);
                          endforeach; ?>

                        </table>
                        <h1>Total : <b><?php echo number_format($supertotal, 0, '.', '.'); ?></b></h1>

                      <?php else :
                        // si no hay operaciones
                      ?>
                        <script>
                          $("#wellcome").hide();
                        </script>
                        <div class="jumbotron">
                          <h2>No hay operaciones</h2>
                          <p>El rango de fechas seleccionado no proporciono ningun resultado de operaciones.</p>
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
                    <?php endif; ?>

                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    <?php endif ?>


    <?php if ($u->is_empleado) : ?>
      <?php
      $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
      ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1> <i class="fa  fa-bar-chart" style="color: orange;"></i>
            REPORTE DE VENTAS
          </h1>
        </section>
        <section class="content">
          <div class="box">
            <div class="box-header with-border">
            </div>
            <div class="box-body">
              <form>
                <input type="hidden" name="view" value="reporteventa">
                <div class="row">
                  <div class="col-md-3">

                    <select name="uso_id" class="form-control">
                      <option value="">-- REPORTE POR TODOS --</option>
                      <!-- <?php foreach ($clients as $p) : ?>
              <option value="<?php echo $p->cliente_id; ?>"><?php if ($p->cliente_id != null) {
                                                              echo $p->getCliente()->nombre . " " . $p->getCliente()->apellido;
                                                            } else {
                                                              echo "";
                                                            }  ?></option>
              <?php endforeach; ?> -->
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
                    <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                    <input type="submit" class="btn btn-warning btn-block" value="Procesar">
                  </div>

                </div>
              </form>
              <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

              <div class="row">

                <div class="col-md-12">
                  <?php if (isset($_GET["sd"]) && isset($_GET["ed"])) : ?>
                    <?php if ($_GET["sd"] != "" && $_GET["ed"] != "") : ?>
                      <?php
                      $operations = array();

                      if ($_GET["uso_id"] == "") {
                        $operations = VentaData::getAllByDateOfficial($_GET["sd"], $_GET["ed"], 2);
                      } else {
                        $operations = VentaData::getAllByDateBCOpp($_GET["uso_id"], $_GET["sd"], $_GET["ed"], 2);
                      }


                      ?>

                      <?php if (count($operations) > 0) : ?>
                        <?php $supertotal = 0; ?>
                        <table class="table table-bordered">
                          <thead>

                            <th>Subtotal</th>
                            <th>Descuento</th>
                            <th>Total</th>
                            <th>Fecha</th>
                          </thead>
                          <?php
                          $result_operation = "";
                          $result_operation_date = "";
                          foreach ($operations as $operation) : ?>
                            <tr>
                              <?php if ($operation->sucursal_id == $sucursales->id_sucursal) : ?>
                                <td> <?php echo number_format($operation->total, 0, '.', '.'); ?></td>
                                <td> <?php echo number_format($operation->descuento, 0, '.', '.'); ?></td>
                                <td> <?php echo number_format($operation->total - $operation->descuento, 0, '.', '.'); ?></td>
                                <td><?php echo $operation->fecha; ?></td>
                                <?php
                                if ($result_operation == "") {
                                  $result_operation_date = $result_operation_date . $operation->fecha;
                                  $result_operation = $result_operation . ($operation->total - $operation->descuento);
                                } else {
                                  $result_operation_date = $result_operation_date . ", " . $operation->fecha;
                                  $result_operation = $result_operation . ", " . ($operation->total - $operation->descuento);
                                }
                                ?>
                              <?php else : ?>
                              <?php endif ?>

                            </tr>
                          <?php
                            $supertotal += ($operation->total - $operation->descuento);
                          endforeach;

                          // $result_operation = $result_operation . "]}";
                          // $array = explode(', ', $result_operation);
                          // echo explode(', ', $result_operation);
                          ?>

                        </table>
                        <h1>Total : <b><?php echo number_format($supertotal, 0, '.', '.'); ?></b></h1>

                      <?php else :
                        // si no hay operaciones
                      ?>
                        <script>
                          $("#wellcome").hide();
                        </script>
                        <div class="jumbotron">
                          <h2>No hay operaciones</h2>
                          <p>El rango de fechas seleccionado no proporciono ningun resultado de operaciones.</p>
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
                    <?php endif; ?>

                  <?php endif; ?>
                  <canvas id="oilChart" width="600" height="400"></canvas>
                  <script>
                    var oilCanvas = document.getElementById("oilChart").getContext('2d');

                    var operations = "<?php echo $result_operation ?>";
                    var total = parseInt("<?php echo  $supertotal ?>");
                    var operations_date = "<?php echo $result_operation_date ?>";
                    var op = operations.split(", ", 50);
                    var opd = operations_date.split(", ", 50);
                    var operation = [];
                    op.forEach(function(item) {
                      operation.push((parseInt(item) / total) * 100);
                    })
                    // alert(opd)
                    // Chart.defaults.global.defaultFontFamily = "Lato";
                    // Chart.defaults.global.defaultFontSize = 18;

                    var oilData = {
                      labels: opd,
                      datasets: [{
                        data: operation,
                        backgroundColor: [
                          "#FFA384",
                          "#63FF84",
                          "#84FF63",
                          "#8FF3FF",
                          "#6384FF",
                          "#FF6384",
                          "#6AAE84",
                          "#89FF63",
                          "#84FFFF",
                          "#6A8AFF",
                          "#FFA384",
                          "#63FF84",
                          "#84FF63",
                          "#8FF3FF",
                          "#6384FF",
                          "#FF6384",
                          "#6AAE84",
                          "#89FF63",
                          "#84FFFF",
                          "#6A8AFF",
                          "#FFA384",
                          "#63FF84",
                          "#84FF63",
                          "#8FF3FF",
                          "#6384FF",
                          "#FF6384",
                          "#6AAE84",
                          "#89FF63",
                          "#84FFFF",
                          "#6A8AFF",
                          "#FFA384",
                          "#63FF84",
                          "#84FF63",
                          "#8FF3FF",
                          "#6384FF",
                          "#FF6384",
                          "#6AAE84",
                          "#89FF63",
                          "#84FFFF",
                          "#6A8AFF",
                          "#FFA384",
                          "#63FF84",
                          "#84FF63",
                          "#8FF3FF",
                          "#6384FF",
                          "#FF6384",
                          "#6AAE84",
                          "#89FF63",
                          "#84FFFF",
                          "#6A8AFF",
                          "#FFA384",
                          "#63FF84",
                          "#84FF63",
                          "#8FF3FF",
                          "#6384FF",
                          "#FF6384",
                          "#6AAE84",
                          "#89FF63",
                          "#84FFFF",
                          "#6A8AFF",
                          "#FFA384",
                          "#63FF84",
                          "#84FF63",
                          "#8FF3FF",
                          "#6384FF",
                          "#FF6384",
                          "#6AAE84",
                          "#89FF63",
                          "#84FFFF",
                          "#6A8AFF",
                          "#FFA384",
                          "#63FF84",
                          "#84FF63",
                          "#8FF3FF",
                          "#6384FF",
                          "#FF6384",
                          "#6AAE84",
                          "#89FF63",
                          "#84FFFF",
                          "#6A8AFF"
                        ]
                      }]
                    };

                    var pieChart = new Chart(oilCanvas, {
                      type: 'pie',
                      data: oilData
                    });
                  </script>
                  <script>
                    // var ctx = document.getElementById('oilChart').getContext('2d');
                    // var myChart = new Chart(ctx, {
                    //   type: 'bar',
                    //   data: {
                    //     labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                    //     datasets: [{
                    //       label: '# of Votes',
                    //       data: [12, 19, 3, 5, 2, 3],
                    //       backgroundColor: [
                    //         'rgba(255, 99, 132, 0.2)',
                    //         'rgba(54, 162, 235, 0.2)',
                    //         'rgba(255, 206, 86, 0.2)',
                    //         'rgba(75, 192, 192, 0.2)',
                    //         'rgba(153, 102, 255, 0.2)',
                    //         'rgba(255, 159, 64, 0.2)'
                    //       ],
                    //       borderColor: [
                    //         'rgba(255, 99, 132, 1)',
                    //         'rgba(54, 162, 235, 1)',
                    //         'rgba(255, 206, 86, 1)',
                    //         'rgba(75, 192, 192, 1)',
                    //         'rgba(153, 102, 255, 1)',
                    //         'rgba(255, 159, 64, 1)'
                    //       ],
                    //       borderWidth: 1
                    //     }]
                    //   },
                    //   options: {
                    //     scales: {
                    //       y: {
                    //         beginAtZero: true
                    //       }
                    //     }
                    //   }
                    // });
                  </script>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    <?php endif ?>
  <?php endif ?>