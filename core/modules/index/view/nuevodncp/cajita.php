<?php
$sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
?>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

<div class="content-wrapper">
  <section class="content-header">
    <h1><i class='fa fa-laptop' style="color: orange;"></i>
      REGISTRO DE DNCP
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">

    <div class="row">

      <div class="col-xs-12">
        <form method="post" action="index.php?action=creardncp" role="form">
          <div class="box">
            <div class="box-body">
              <div class="box box-warning">
                <div class="panel-body">
                  <div class="form-horizontal">





                    <div class="form-group has-feedback has-warning">

                      <label class="col-lg-2 control-label">Modalidad:</label>
                      <div class="col-lg-4">
                        <input type="text" name="modalidad" class="form-control" id="descripcion" maxlength="800">
                      </div>
                      <label class="col-lg-2 control-label">Entidad</label>
                      <div class="col-lg-4">
                        <input type="text" name="entidad" class="form-control" id="monto" maxlength="800" required>
                      </div>

                    </div>
                    <div class="form-group has-feedback has-warning">

                      <label for="cuota" class="col-lg-2 control-label">Fecha</label>
                      <div class="col-lg-4">
                        <input type="date" name="fecha" class="form-control" id="cuota" required>
                        <span class="fa fa-barcode form-control-feedback"></span>
                      </div>
                      <label class="col-lg-2 control-label">Secuencia</label>
                      <div class="col-lg-4">
                        <input type="text" name="secuencia" class="form-control" id="monto" maxlength="800" required>
                      </div>



                    </div>


                    <div class="form-group has-feedback has-warning">

                      <label for="cuota" class="col-lg-2 control-label">Cliente</label>
                      <div class="col-lg-2">

                        <select name="cliente_id" class="selectpicker show-menu-arrow" data-style="form-control" data-live-search="true" id="cliente_id" class="form-control">
                          <option value="">SELECCIONAR CLIENTE</option>

                          <?php
                          $clients = ClienteData::verclientessucursalB2G($sucursales->id_sucursal);
                          foreach ($clients as $client) :
                          ?>
                            <option value="<?php echo $client->id_cliente; ?>"><?php echo $client->dni . " - " . $client->nombre . " " . $client->apellido . " - " . $client->tipo_doc; ?></option>
                          <?php endforeach;

                          ?>
                        </select>

                      </div>


                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <input type="hidden" name="sucursal" id="sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                      <input type="hidden" name="sucursal_id" id="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
                      <button type="submit" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      </form>

    </div>

</div>
</section>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
</script>