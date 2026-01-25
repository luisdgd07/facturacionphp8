<?php
$u = null;
if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != ""):
  $u = UserData::getById($_SESSION["admin_id"]);
  ?>
  <!-- Content Wrapper. Contains page content -->

  <?php if ($u->is_admin): ?>

  <?php endif ?>

  <?php if ($u->is_empleado): ?>
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
        <?php if (isset($_GET['success']) && $_GET['success']) { ?>
          <div class="alert alert-success mt-4" role="alert">
            Documentación guardada con éxito
          </div>
          <?php
        }
        ?>
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i
                    class="fa fa-user-plus"></i> Nuevo</a>
              </div>
              <div class="box-body">
                <form method="get" class="form-inline" style="margin-bottom:10px;">
                  <input type="hidden" name="view" value="cliente" />
                  <input type="hidden" name="id_sucursal" value="<?php echo htmlspecialchars($_GET["id_sucursal"]); ?>" />
                  <div class="form-group">
                    <input type="text" name="q" class="form-control" placeholder="Buscar por nombre, apellido, DNI o email"
                      value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" />
                  </div>
                  <div class="form-group" style="margin-left:6px;">
                    <select name="per_page" class="form-control" onchange="this.form.submit()">
                      <?php $pp = isset($_GET['per_page']) ? intval($_GET['per_page']) : 10; ?>
                      <option value="10" <?php echo $pp == 10 ? 'selected' : ''; ?>>10</option>
                      <option value="20" <?php echo $pp == 20 ? 'selected' : ''; ?>>20</option>
                      <option value="50" <?php echo $pp == 50 ? 'selected' : ''; ?>>50</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary" style="margin-left:6px;">Buscar</button>
                </form>
                <div class="table-responsive">
                  <?php
                  $idSucursal = isset($_GET["id_sucursal"]) ? intval($_GET["id_sucursal"]) : 0;
                  $page = isset($_GET["page"]) ? max(1, intval($_GET["page"])) : 1;
                  $per_page = isset($_GET["per_page"]) ? max(1, intval($_GET["per_page"])) : 10;
                  $q = isset($_GET['q']) ? trim($_GET['q']) : '';
                  if ($q !== '') {
                    $total = ClienteData::contarClientesPorSucursalBuscado($idSucursal, $q);
                  } else {
                    $total = ClienteData::contarClientesPorSucursal($idSucursal);
                  }
                  $total_pages = $per_page > 0 ? (int) ceil($total / $per_page) : 1;
                  if ($page > $total_pages && $total_pages > 0) {
                    $page = $total_pages;
                  }
                  $offset = ($page - 1) * $per_page;

                  if ($q !== '') {
                    $clientes = ClienteData::verClientesSucursalPaginadoBuscado($idSucursal, $q, $per_page, $offset);
                  } else {
                    $clientes = ClienteData::verClientesSucursalPaginado($idSucursal, $per_page, $offset);
                  }
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
                              <center><a class="fancybox" href="<?php echo $url; ?>" target="_blank"
                                  data-fancybox-group="gallery" title="Imagen"><img class="fancyResponsive img-circle"
                                    src="<?php echo $url; ?>" alt="" width="30" height="30" /></a></center>
                            </td>
                            <td><?php echo $cliente->dni; ?></td>
                            <td><?php echo $cliente->tipo_doc; ?></td>
                            <td><?php echo $cliente->email; ?></td>
                            <td><?php echo $cliente->telefono; ?></td>
                            <td style="width:90px;">

                              <a href="index.php?view=actualizarcliente&id_sucursal=<?php echo $sucursales->id_sucursal; ?>&id_cliente=<?php echo $cliente->id_cliente; ?>"
                                data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cog"></i> Editar</a>
                              <a href="index.php?action=eliminarcliente&id_sucursal=<?php echo $sucursales->id_sucursal; ?>&id_cliente=<?php echo $cliente->id_cliente; ?>"
                                class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> Eliminar</a>

                              <a data-toggle="tooltip" data-placement="top" title="Control de Documentación"
                                class="btn btn-info btn-sm"
                                href="index.php?view=documentacion&id_sucursal=<?php echo $sucursales->id_sucursal; ?>&cliente_id=<?php echo $cliente->id_cliente; ?>">
                                <i style="color:#fff" class="glyphicon glyphicon-edit"></i>
                              </a>
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
                  <?php if ($total_pages > 1) { ?>
                    <nav aria-label="Clientes paginación">
                      <ul class="pagination">
                        <?php
                        $baseUrl = "index.php?view=cliente&id_sucursal=" . $idSucursal . ($q !== '' ? "&q=" . urlencode($q) : '');
                        $prev_disabled = ($page <= 1) ? " class=\"disabled\"" : "";
                        $next_disabled = ($page >= $total_pages) ? " class=\"disabled\"" : "";
                        $prev_page = max(1, $page - 1);
                        $next_page = min($total_pages, $page + 1);
                        ?>
                        <li<?php echo $prev_disabled; ?>><a
                            href="<?php echo $baseUrl . "&page=" . $prev_page . "&per_page=" . $per_page; ?>"
                            aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>
                          <?php
                          $start = max(1, $page - 2);
                          $end = min($total_pages, $page + 2);
                          if ($start > 1) {
                            echo '<li><a href="' . $baseUrl . '&page=1&per_page=' . $per_page . '">1</a></li>';
                            if ($start > 2) {
                              echo '<li class="disabled"><span>...</span></li>';
                            }
                          }
                          for ($p = $start; $p <= $end; $p++) {
                            $active = ($p == $page) ? ' class="active"' : '';
                            echo '<li' . $active . '><a href="' . $baseUrl . '&page=' . $p . '&per_page=' . $per_page . '">' . $p . '</a></li>';
                          }
                          if ($end < $total_pages) {
                            if ($end < $total_pages - 1) {
                              echo '<li class="disabled"><span>...</span></li>';
                            }
                            echo '<li><a href="' . $baseUrl . '&page=' . $total_pages . '&per_page=' . $per_page . '">' . $total_pages . '</a></li>';
                          }
                          ?>
                          <li<?php echo $next_disabled; ?>><a
                              href="<?php echo $baseUrl . "&page=" . $next_page . "&per_page=" . $per_page; ?>"
                              aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>
                      </ul>
                    </nav>
                    <p>Total: <?php echo $total; ?> clientes. Página <?php echo $page; ?> de <?php echo $total_pages; ?>.</p>
                  <?php } ?>
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
            <h4 class="modal-title"><i class="fa fa-user-circle" style="color: orange;"></i><b> Agregar Nuevo Cliente</b>
            </h4>
          </div>
          <div class="modal-body">

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
                <input type="text" class="form-control" id="nombre" name="nombre"
                  onKeyUP="this.value=this.value.toUpperCase();" maxlength="80" placeholder="Nombre del Cliente">
                <span class="fa fa-user-secret form-control-feedback"></span>
              </div>
            </div>
            <div class="form-group has-feedback has-warning">
              <label for="inputEmail1" class="col-sm-3 control-label">Apellido</label>

              <div class="col-sm-9">
                <input type="text" class="form-control" id="apellido" name="apellido"
                  onKeyUP="this.value=this.value.toUpperCase();" maxlength="200" placeholder="Apellido del Cliente">
                <span class="fa fa-file-text form-control-feedback"></span>
              </div>
            </div>
            <div class="form-group has-feedback has-warning">
              <label for="inputEmail1" class="col-sm-3 control-label">Tipo Doc.</label>
              <div class="col-sm-9">
                <select class="form-control" name="tipo_doc">
                  <option value="RUC">RUC</option>
                  <option value="CI">C.I.</option>
                  <option value="CLIENTE DEL EXTERIOR">CLIENTE DEL EXTERIOR</option>
                  <option value="PASAPORTE">PASAPORTE</option>
                  <option value="CEDULA EXTRANJERO">CEDULA DE EXTRANJERO</option>
                  <option value="SIN NOMBRE">SIN NOMBRE</option>
                  <option value="DIPLOMATICO">DIPLOMATICO</option>
                  <option value="IDENTIFICACION TRIBUTARIA">IDENTIFICACIÓN TRIBUTARIA</option>
                </select>
              </div>
            </div>

            <div class="form-group has-feedback has-warning">
              <label for="inputEmail1" class="col-sm-3 control-label">Tipo operación</label>
              <div class="col-sm-9">
                <select class="form-control" name="tipo_operacion">
                  <option value="2">B2C Business to Consumer</option>
                  <option value="1">B2B Business to Business</option>
                  <option value="3">B2G Business to Government</option>
                  <option value="4">B2F Business to Foreign</option>
                </select>
              </div>
            </div>
            <div class="form-group has-feedback has-warning">
              <label for="inputEmail1" class="col-sm-3 control-label">N° Documento</label>

              <div class="col-sm-9">
                <input type="text" class="form-control" id="dni" name="dni" maxlength="15" placeholder="Sin Nombre: X">
                <span class="fa fa-credit-card form-control-feedback"></span>
              </div>
            </div>
            <div class="form-group has-feedback has-warning">
              <label for="inputEmail1" class="col-sm-3 control-label">Departamento:</label>
              <div class="col-sm-9">
                <select name="dpt_id" id="dpt_id" onchange="buscarDistritos()" class="form-control">
                  <?php
                  $dpts = DptData::getAll();
                  foreach ($dpts as $dpt):
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
                <select onchange="buscaCiudad()" name="distrito" id="distritos" class="form-control">
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
              <label for="pais_id" class="col-sm-3 control-label">Pais:</label>
              <div class="col-sm-9">
                <select name="pais_id" id="pais_id" class="form-control">
                  <?php
                  $pais_t = PaisData::getAll();
                  foreach ($pais_t as $pais):
                    ?>
                    <option value="<?php echo $pais->id;
                    ?>"><?php echo $pais->descripcion
                      ?></option>
                  <?php endforeach;
                  ?>
                </select>
              </div>
            </div>


            <div class="form-group has-feedback has-warning">
              <label for="inputEmail1" class="col-sm-3 control-label">Dirección</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección del Cliente">
                <span class="fa fa-map-marker form-control-feedback"></span>
              </div>
            </div>
            <div class="form-group has-feedback has-warning">
              <label for="inputEmail1" class="col-sm-3 control-label">E-mail</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" id="email" name="email" maxlength="100"
                  placeholder="Correo Electronico del Cliente"> <span class="fa fa-google form-control-feedback"></span>
              </div>
            </div>
            <div class="form-group has-feedback has-warning">
              <label for="inputEmail1" class="col-sm-3 control-label">Telefono</label>

              <div class="col-sm-9">
                <input type="text" class="form-control" id="telefono" name="telefono" maxlength="15"
                  placeholder="Número de  teléfono">
                <span class="fa fa-tty form-control-feedback"></span>
              </div>
            </div>
            <div class="form-group has-feedback has-warning">
              <label for="inputEmail1" class="col-sm-3 control-label">Celular</label>

              <div class="col-sm-9">
                <input type="text" class="form-control" id="celular" name="celular" maxlength="15"
                  placeholder="Numero de Celular del Cliente">
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

                      foreach ($clients as $client):

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



            <div class="form-group has-feedback has-warning">
              <label for="inputEmail1" class="col-sm-3 control-label">Días de Credito Cliente</label>

              <div class="col-sm-9">
                <input type="text" class="form-control" id="dias_credito" name="dias_credito" maxlength="2"
                  placeholder="30">
                <span class="fa fa-credit-card form-control-feedback"></span>
              </div>
            </div>


          </div>
          <div class="modal-footer">

            <input type="hidden" name="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
            <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
            <input type="hidden" name="sucursal" id="sucursal" value="<?php echo $sucursales->nombre; ?>">
            <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i>
              Cerrar</button>
            <button type="button" class="btn btn-warning btn-flat" onclick="if(validarFormulario()) guardarCliente()"><i
                class="fa fa-save"></i> Guardar</button>

          </div>
        </div>
      </div>
      <script>
        function guardarCliente() {
          // Mostrar indicador de carga
          Swal.fire({
            title: 'Guardando...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });

          // Crear FormData para manejar archivos
          var formData = new FormData();

          // Agregar todos los campos del formulario
          formData.append('nombre', $('#nombre').val());
          formData.append('apellido', $('#apellido').val());
          formData.append('tipo_doc', $('select[name="tipo_doc"]').val());
          formData.append('dni', $('#dni').val());
          formData.append('dpt_id', $('#dpt_id').val());
          formData.append('distrito', $('#ciudades').val());
          formData.append('ciudad', $('#ciudad').val());
          formData.append('pais_id', $('#pais_id').val());
          formData.append('direccion', $('#direccion').val());
          formData.append('email', $('#email').val());
          formData.append('telefono', $('#telefono').val());
          formData.append('celular', $('#celular').val());
          formData.append('id_precio', $('#id_precio').val());
          formData.append('sucursal_id', $('#id_sucursal').val());
          formData.append('id_sucursal', $('#id_sucursal').val());
          formData.append('sucursal', $('#sucursal').val());

          // Agregar imagen si existe
          var imagenFile = $('input[name="imagen"]')[0].files[0];
          if (imagenFile) {
            formData.append('imagen', imagenFile);
          }

          // Enviar datos via AJAX
          $.ajax({
            url: 'index.php?action=nuevocliente',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
              if (response.success) {
                Swal.fire({
                  icon: 'success',
                  title: '¡Éxito!',
                  text: response.message || 'Cliente guardado correctamente',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  // Cerrar modal
                  $('#addnew').modal('hide');

                  // Limpiar formulario

                  // Recargar página o actualizar lista de clientes si es necesario
                  window.location.reload();
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: response.message || 'Error al guardar el cliente',
                  confirmButtonText: 'OK'
                });
              }
            },
            error: function (xhr, status, error) {
              console.error('Error AJAX:', error);
              Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'Ha ocurrido un error al conectar con el servidor',
                confirmButtonText: 'OK'
              });
            }
          });
        }

        // Función para validar formulario antes de enviar
        function validarFormulario() {
          var nombre = $('#nombre').val().trim();
          var apellido = $('#apellido').val().trim();
          var dni = $('#dni').val().trim();

          if (!nombre) {
            Swal.fire('Error', 'El nombre es obligatorio', 'error');
            $('#nombre').focus();
            return false;
          }

          if (!apellido) {
            Swal.fire('Error', 'El apellido es obligatorio', 'error');
            $('#apellido').focus();
            return false;
          }

          if (!dni) {
            Swal.fire('Error', 'El número de documento es obligatorio', 'error');
            $('#dni').focus();
            return false;
          }

          return true;
        }


        function buscaCiudad() {
          $.ajax({
            url: "index.php?action=buscarciudades",
            type: "GET",
            data: {
              dist: $("#distritos").val(),
            },
            cache: false,
            success: function (dataResult) {
              console.log(dataResult)
              ciudades = "";

              var result = JSON.parse(dataResult);
              for (const [id, data_1] of Object.entries(result)) {

                ciudades += `<option  value="${data_1.codigo}">${data_1.descripcion}</option>`;
              }
              $("#ciudad").html(ciudades);
            }
          });
        }
        function buscarDistritos() {
          $.ajax({
            url: "index.php?action=buscardistritos",
            type: "GET",
            data: {
              dpt: $("#dpt_id").val(),
            },
            cache: false,
            success: function (dataResult) {
              distritos = "";

              var result = JSON.parse(dataResult);
              for (const [id, data_1] of Object.entries(result)) {
                distritos += `<option  value="${data_1.codigo}">${data_1.descripcion}</option>`;
              }
              $("#distritos").html(distritos);
              buscaCiudad()
            }
          });
        }

      </script>
    </div>
  <?php endif ?>
<?php endif ?>