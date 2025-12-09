<?php
$u = null;
if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
  $u = UserData::getById($_SESSION["admin_id"]);
?>
  <!-- Content Wrapper. Contains page content -->

  <?php if ($u->is_admin) : ?>

  <?php endif ?>

  <?php if ($u->is_empleado) : ?>
    <?php
    $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
    ?>

    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1><i class='fa fa-users' style="color: orange;"></i>
          Lista de Clientes
          <!-- <marquee> Lista</marquee> -->
        </h1>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-user-plus"></i> Nuevo</a>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <?php
                  $clientes = ClienteData::verclientessucursal($sucursales->id_sucursal);
                  if (count($clientes) > 0) {
                    // si hay clientes
                  ?>
                    <table id="example1" class="table table-bordered table-dark" style="width:100%">
                      <thead>
                        <th>Nombre Completo</th>
                        <th>Imagen</th>
                        <th>N° Documento</th>
                        <th>Tipo doc.</th>
                        <th>E-Mail</th>
                        <th>Telefono</th>
                        <th>
                          <center>Acción</center>
                        </th>
                      </thead>
                      <tbody>
                        <?php
                        foreach ($clientes as $cliente) {
                          $url = "storage/cliente/" . $cliente->imagen;
                        ?>
                          <tr>
                            <td><?php echo $cliente->nombre . " " . $cliente->apellido; ?></td>
                            <td>
                              <center><a class="fancybox" href="<?php echo $url; ?>" target="_blank" data-fancybox-group="gallery" title="Imagen"><img class="fancyResponsive img-circle" src="<?php echo $url; ?>" alt="" width="30" height="30" /></a></center>
                            </td>
                            <td><?php echo $cliente->dni; ?></td>
                            <td><?php echo $cliente->tipo_doc; ?></td>
                            <td><?php echo $cliente->email; ?></td>
                            <td><?php echo $cliente->telefono; ?></td>
                            <td style="width:90px;">

                              <a href="index.php?view=actualizarcliente&id_sucursal=<?php echo $sucursales->id_sucursal; ?>&id_cliente=<?php echo $cliente->id_cliente; ?>" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cog"></i> Editar</a>
                              <a href="index.php?action=eliminarcliente&id_sucursal=<?php echo $sucursales->id_sucursal; ?>&id_cliente=<?php echo $cliente->id_cliente; ?>" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> Eliminar</a>


                            </td>
                          </tr>
                          </tr>
                      <?php
                        }
                      } else {
                        echo "<p class='alert alert-danger'>No hay clientes Registrados</p>";
                      }
                      ?>
                      </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <!--       <div class="formulario__grupo" id="grupo__usuario">
        <label for="usuario" class="formulario__label">Usuario</label>
        <div class="formulario__grupo-input">
          <input type="text" class="formulario__input" name="usuario" id="usuario" placeholder="john123">
          <i class="formulario__validacion-estado fas fa-times-circle"></i>
        </div>
        <p class="formulario__input-error">El usuario tiene que ser de 4 a 16 dígitos y solo puede contener numeros, letras y guion bajo.</p>
      </div> -->
    <!-- Agregar Nuevo Medicamento -->
    <div class="modal fade" id="addnew">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-user-circle" style="color: orange;"></i><b> Agregar Nuevo Cliente</b></h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" action="index.php?action=nuevocliente" role="form" method="post" enctype="multipart/form-data">
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
                  <input type="text" class="form-control" id="nombre" name="nombre" onKeyUP="this.value=this.value.toUpperCase();" maxlength="80" placeholder="Nombre del Cliente">
                  <span class="fa fa-user-secret form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Apellido</label>

                <div class="col-sm-9">
                  <input type="text" class="form-control" id="apellido" name="apellido" onKeyUP="this.value=this.value.toUpperCase();" maxlength="200" placeholder="Apellido del Cliente">
                  <span class="fa fa-file-text form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Tipo Doc.</label>
                <div class="col-sm-9">
                  <select class="form-control" name="tipo_doc">
                    <option value="RUC">RUC</option>
                    <option value="CI">C.I.</option>
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
                  <input type="text" class="form-control" id="dni" name="dni"  maxlength="15" placeholder="Sin Nombre: X">
                  <span class="fa fa-credit-card form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Departamento:</label>
                <div class="col-sm-9">
                  <select name="dpt_id" id="dpt_id" onchange="buscard()" class="form-control">
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
                <label for="inputEmail1" class="col-sm-3 control-label">Dirección</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="direccion" name="direccion"  placeholder="Dirección del Cliente">
                  <span class="fa fa-map-marker form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">E-mail</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="email" name="email" maxlength="100" placeholder="Correo Electronico del Cliente"> <span class="fa fa-google form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Telefono</label>

                <div class="col-sm-9">
                  <input type="text" class="form-control" id="telefono" name="telefono" maxlength="15" placeholder="Número de  teléfono">
                  <span class="fa fa-tty form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Celular</label>

                <div class="col-sm-9">
                  <input type="text" class="form-control" id="celular" name="celular" maxlength="15" placeholder="Numero de Celular del Cliente">
                  <span class="fa fa-phone form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Tipo cliente</label>

                <div class="col-sm-9">
                  <div class="col-lg-10">
                    <?php
                    $clients = ProductoData::listar_precio($_GET['id_sucursal']);
                    //var_dump($clients);
                    ?>
                    <select name="id_precio" id="id_precio" class="form-control">
                      <?php
                      $clients = ProductoData::listar_precio($_GET['id_sucursal']);

                      if (count($clients) > 0) {

                        foreach ($clients as $client) :

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
            <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            <button type="submit" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
            </form>
          </div>
        </div>
      </div>
      <script>
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
            url: "index.php?action=buscarendistrito",
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
      </script>
    </div>
  <?php endif ?>
<?php endif ?>