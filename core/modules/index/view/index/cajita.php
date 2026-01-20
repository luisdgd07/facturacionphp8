<?php
$u = null;
if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != ""):
  $u = UserData::getById($_SESSION["admin_id"]);
  $config = ConfigData::getAll();
  if ($u->is_admin):
    if (count($config) > 0) {
      foreach ($config as $configuracion) {
        $url = "storage/sis/admin/" . $configuracion->imagen; ?>
        <div class="content-wrapper">
          <section class="content-header">
            <h1></h1>
          </section>
          <section class="content">
            <div class="row">
              <br>
              <br>
            </div>
            <h1>
              <center>SISTEMA DE <?php echo $configuracion->texto1; ?> <small>Version 1.0</small></center>
            </h1>
          </section>
        </div>
        <?php
      }
    }
  endif;
  if ($u->is_empleado):
    // $usuarioss is redundant if $u is loaded. Using $u->id_usuario directly.
    $sucursales_list = SucursalUusarioData::verusucursalusuarios($u->id_usuario);
    if (count($sucursales_list) > 0):
      foreach ($sucursales_list as $sucur):
        $sucursal = $sucur->verSocursal();

        if (count($config) > 0) {
          foreach ($config as $configuracion) {
            $url = "storage/sis/admin/" . $configuracion->imagen; ?>
            <div class="content-wrapper">
              <section class="content-header">
                <h1></h1>
              </section>
              <section class="content">
                <div class="row">
                  <br>
                  <br>
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">COMPRAS</span>
                        <span
                          class="info-box-number"><?php echo count(VentaData::versucursaltipocompras($sucursal->id_sucursal)); ?></span>
                        <a href="./?view=compras1&id_sucursal=<?php echo $sucursal->id_sucursal; ?>" class="small-box-footer">Ver
                          mas <i class="fa fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-red"><i class="fa fa-user-circle"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">PROVEEDORES</span>
                        <span
                          class="info-box-number"><?php echo count(ProveedorData::verproveedorssucursal($sucursal->id_sucursal)); ?></span>
                        <a href="./?view=proveedor&id_sucursal=<?php echo $sucursal->id_sucursal; ?>" class="small-box-footer">Ver
                          mas <i class="fa fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                  </div>

                  <div class="clearfix visible-sm-block"></div>

                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">CLIENTES</span>
                        <span
                          class="info-box-number"><?php echo count(ClienteData::verclientessucursal($sucursal->id_sucursal)); ?></span>
                        <a href="./?view=cliente&id_sucursal=<?php echo $sucursal->id_sucursal; ?>" class="small-box-footer">Ver mas
                          <i class="fa fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-orange"><i class="fa fa-dollar"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">VENTAS</span>
                        <span
                          class="info-box-number"><?php echo count(VentaData::getVentas($sucursal->id_sucursal)); ?><small></small></span>
                        <a href="./?view=ventas&id_sucursal=<?php echo $sucursal->id_sucursal; ?>" class="small-box-footer">Ver mas
                          <i class="fa fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-blue"><i class="fa fa-laptop"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">PRODUCTOS</span>
                        <span class="info-box-number"><?php echo count(ProductoData::getAll($sucursal->id_sucursal)); ?></span>
                        <a href="./?view=producto&id_sucursal=<?php echo $sucursal->id_sucursal; ?>" class="small-box-footer">Ver
                          mas <i class="fa fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-black"><i class="fa fa-cube"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">CAJA</span>
                        <a href="./?view=caja&id_sucursal=<?php echo $sucursal->id_sucursal; ?>" class="small-box-footer">Ver mas <i
                            class="fa fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                  </div>
                </div>

                <h1>
                  <center><b>! BIENVENIDO !</b> A LA EMPRESA <b
                      style="text-transform: uppercase;"><?php echo $sucursal->nombre ?></b></center>
                </h1>

                <?php
                // Logic for Cotizacion
                // Using $sucursal directly instead of re-fetching $sucursales
                $cotizacion = CotizacionData::versucursalcotizacion($sucursal->id_sucursal);
                $fechacotiz = null; // Initialize variable
    
                if (count($cotizacion) > 0) {
                  ?>
                  <div class="box-body">
                    <div class="table-responsive">
                      <table id="example1" class="table table-bordered table-dark" style="width:100%">
                        <thead>
                          <th>Moneda</th>
                          <th>Valor Compra</th>
                          <th>Valor Venta</th>
                          <th>Fecha Cotización</th>
                        </thead>
                        <tbody>
                          <?php
                          foreach ($cotizacion as $moneda) {
                            $mon = MonedaData::cboObtenerValorPorSucursal2($sucursal->id_sucursal, $moneda->id_tipomoneda);
                            ?>
                            <?php foreach ($mon as $mo): ?>
                              <tr>
                                <td><?php
                                echo $mo->nombre;
                                $nombre = $mo->nombre;
                                $fechacotiz = $mo->fecha_cotizacion;
                                ?></td>
                              <?php endforeach; ?>
                              <td><?php echo $moneda->valor_compra; ?></td>
                              <td><?php echo $moneda->valor_venta; ?></td>
                              <td><?php echo $moneda->fecha_cotizacion; ?></td>
                            </tr>
                            <?php
                          }

                          // INICIO CONDICION DE FECHA COTIZACION
                          if ($fechacotiz) {
                            $fecha_hoy = date('d-m-Y');
                            $fecha_cotizacion = strtotime($fechacotiz);
                            $fecha_cot = date('d-m-Y', ($fecha_cotizacion));

                            if ($fecha_cot >= $fecha_hoy) {
                              echo "<p class='alert alert-yelow'>Tiene la cotización actualizada al dia:" . $fecha_cot . "</p>";
                              echo $fecha_cot;
                            } else if ($fecha_cot < $fecha_hoy) {
                              Core::alert("Atención debe de actualizar la moneda a la cotización del día...en Configuraciones/Cotizacion/Nuevo!");
                              Core::redir("index.php?view=cotizacion&id_sucursal=" . $sucursal->id_sucursal);
                            }
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <input type="hidden" name="sucursal_id" value="<?php echo $sucursal->id_sucursal; ?>">
                    <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursal->id_sucursal; ?>">
                  </div>
                  <?php
                } else {
                  echo "<p class='alert alert-danger'>No hay Cotización registrada</p>";
                }
                ?>

                <!-- Map box -->
                <div class="row">
                  <section class="col-xs-12">
                    <div class="box box-warning bg-light-blue-gradient">
                      <div class="box-header">
                        <img src="<?php echo $url; ?>" class="img-responsive" width="100%" height="100%">
                      </div>
                    </div>
                  </section>
                </div>

              </section>
            </div>
            <?php
          }
        }
      endforeach;
    endif;
  endif;
endif;