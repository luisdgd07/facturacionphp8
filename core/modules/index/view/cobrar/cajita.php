  <?php
    $ventas = VentaData::getById($_GET["id_venta"]);
  ?>
    <?php $fech_actual=date("d-m-y"); ?>
  <?php $hora_actual=date("H:i:s"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='fa fa-institution' style="color: orange;"></i>
        REGISTRAR LA COBRANZA
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
            </div>
            <div class="box-body">
              <form class="form-horizontal" action="index.php?action=nuevocobranza" role="form" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <?php
                      $operations = OperationData::getAllProductsBySellIddd($ventas->id_venta);
                       count($operations);
                      ?> 
                    <label for="inputEmail1" class="col-lg-1 control-label">Cantidad</label>
                    <div class="col-lg-2">
                      <input type="text" name="imagen" readonly="" value="<?php if ($ventas->tipo_venta=="1"): ?><?php echo $ventas->cantidad; ?><?php else: ?><?php echo count($operations) ?><?php endif ?>" class="form-control">
                    </div>
                    <label for="inputEmail1" class="col-lg-1 control-label">Fecha</label>
                    <div class="col-lg-2">
                      <input type="text" name="imagen" readonly="" value="<?php echo $fech_actual; ?>" class="form-control">
                    </div>
                    <label for="inputEmail1" class="col-lg-2 control-label">Monto A pagar</label>
                    <div class="col-lg-2">
                      <input type="text" required="" name="cash" value="<?php echo $ventas->total-$ventas->cash; ?>" class="form-control">
                    </div>
                    <div class="col-lg-1">
                      <div class="checkbox">
                        <label><input type="checkbox" name="pagado" id="pagado">Completo</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                  <label for="inputEmail1" class="col-lg-1 control-label">Deuda</label>
                    <div class="col-lg-2">
                      <input type="text" readonly="" name="total" value="<?php echo $ventas->total; ?>" class="form-control">
                    </div>
                  <label for="inputEmail1" class="col-lg-1 control-label">Adelanto</label>
                    <div class="col-lg-2">
                      <input type="text" readonly="" name="adelanto" value="<?php echo $ventas->cash; ?>" class="form-control">
                    </div>
                  </div>
                  <hr>
                  <input type="hidden" name="id_venta" id="id_venta" value="<?php echo $ventas->id_venta; ?>">
                  <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $ventas->sucursal_id; ?>">
                  <!-- <input type="hidden" name="pagado" id="pagado" value="1"> -->
                  <button type="submit" class="btn btn-info">Registar Cobranza</button>
              </form> 
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
