<?php if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != ""): ?>
  <?php
  $u = null;
  if ($_SESSION["admin_id"] != "") {
    $u = UserData::getById($_SESSION["admin_id"]);
    // $user = $u->nombre." ".$u->apellido;
  } ?>
  <?php
  $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);

  $cliente = ProductoData::getByIlistado($_GET["id_precio"]);
  // $url = "storage/plato/".$cliente->id_plato."/".$cliente->imagen;
  ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='fa fa-steam' style="color: orange;"></i>
        ACTUALIZAR LISTADO PRECIO: <b style="color: orange;"><?php echo $cliente->NOMBRE_PRECIO; ?></b>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-body">
              <div class="box box-warning">
                <div class="panel-body">
                  <form class="form-horizontal" action="index.php?action=actualizarlista" role="form" method="post"
                    enctype="multipart/form-data">

                    <div class="form-group has-feedback has-warning">
                      <label for="inputEmail1" class="col-sm-3 control-label">Descripción</label>

                      <div class="col-sm-9">
                        <textarea class="form-control" id="descripcion"
                          name="descripcion"><?php echo $cliente->NOMBRE_PRECIO ?></textarea><span
                          class="fa fa-list form-control-feedback"></span>
                      </div>
                    </div>


                    <div class="form-group has-feedback has-warning">
                      <label for="inputEmail1" class="col-sm-3 control-label">Moneda:</label>
                      <div class="col-sm-9">

                        <?php

                        $listap = ProductoData::vertipomoneda($sucursales->id_sucursal);
                        if (count($listap) > 0): ?>
                          <select name="moneda_id" id="moneda_id" required class="form-control">
                            <option value="">SELECCIONAR MONEDA</option>
                            <?php foreach ($listap as $lista): ?>
                              <option value="<?php echo $lista->id_tipomoneda; ?>" style="color: orange;"><i
                                  class="fa fa-gg"></i> <?php echo $lista->nombre; ?> </option>


                            <?php
                            endforeach; ?>


                          </select>
                        <?php endif; ?>
                        <span class="fa fa-file-text form-control-feedback"></span>
                      </div>
                    </div>



                </div>
                <div class="modal-footer">
                  <input type="hidden" name="id_sucursal" value="<?php echo $_GET["id_sucursal"]; ?>">
                  <button type="submit" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i>
                    Guardar</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
<?php else: ?>
<?php endif; ?>