<?php if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != ""): ?>
  <?php
  $u = null;
  if ($_SESSION["admin_id"] != "") {
    $u = UserData::getById($_SESSION["admin_id"]);
    // $user = $u->nombre." ".$u->apellido;
  } ?>
  <?php
  $cliente = SuccursalData::VerId($_GET["id_sucursal"]);
  // $url = "storage/plato/".$cliente->id_plato."/".$cliente->imagen;
  ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='fa fa-steam' style="color: orange;"></i>
        ACTUALIZAR EMPRESA: <b style="color: orange;"><?php echo $cliente->nombre; ?></b>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-body">
              <div class="box box-warning">
                <div class="panel-body form-horizontal">
                  <!-- <form class="form-horizontal" action="index.php?action=actualizarsucursal" role="form" method="post" enctype="multipart/form-data"> -->
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Empresa:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nombre" name="nombre" required maxlength="80"
                        value="<?php echo $cliente->nombre ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>

                    <label for="inputEmail1" class="col-sm-3 control-label">Ruc:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="ruc" name="ruc" required maxlength="80"
                        value="<?php echo $cliente->ruc ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Telefono:</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="telefono" name="telefono" maxlength="500"
                        value="<?php echo $cliente->telefono ?>" placeholder="telefono">
                      <span class="fa fa-steam form-control-feedback"></span>
                    </div>
                    <label for="inputEmail1" class="col-sm-2 control-label">Representante:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="representante" name="representante" maxlength="500"
                        value="<?php echo $cliente->representante ?>" placeholder="Representante">
                      <span class="fa fa-steam form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Dirección:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="direccion" name="direccion" required maxlength="80"
                        value="<?php echo $cliente->direccion ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                  </div>

                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Departamento:</label>
                    <div class="col-sm-9">
                      <select name="departa" id="dpt_id" onchange="buscarDistritos()" class="form-control">
                        <?php
                        $dpts = DptData::getAll();
                        $distritocli = $cliente->distrito_id;
                        $ciudadcli = $cliente->ciudad_id;
                        foreach ($dpts as $dpt):
                          if ($cliente->cod_depart == $dpt->codigo) {
                            ?>

                            <option selected value="<?php echo $dpt->codigo;
                            ?>"><?php echo $dpt->name
                              ?></option>
                          <?php } else {
                            ?>
                            <option value="<?php echo $dpt->codigo;
                            ?>"><?php echo $dpt->name
                              ?></option><?php
                          }
                        endforeach;
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Distrito:</label>
                    <div class="col-sm-9">
                      <select onchange="buscaCiudad()" onclick="buscaCiudad()" name="distrito" id="distritos"
                        class="form-control">
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
                    <label for="inputEmail1" class="col-sm-3 control-label">Numero de Casa:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="numero_casa" name="numero_casa" required maxlength="160"
                        value="<?php echo $cliente->numero_casa ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Certificado:</label>
                    <div class="col-sm-9">
                      <input type="file" class="form-control" id="certificado" required maxlength="80"
                        value="<?php echo $cliente->descripcion ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                      <button class="btn btn-primary" onclick="subirCert()" style="margin-top: 20px;">Subir
                        certificado</button>

                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Logo:</label>
                    <div class="col-sm-9">
                      <input type="file" class="form-control" id="logo" required maxlength="80"
                        value="<?php echo $cliente->clave ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                      <button class="btn btn-primary" onclick="subirLogo()" style="margin-top: 20px;">Subir Logo</button>

                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Clave del Certificado:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="clave" name="clave" required maxlength="160"
                        value="<?php echo $cliente->clave ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Fecha de la firma:</label>
                    <div class="col-sm-9">
                      <input type="date" class="form-control" id="fecha_firma" name="fecha_firma" required maxlength="160"
                        value="<?php echo $cliente->fecha_firma ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Fecha del timbrado</label>
                    <div class="col-sm-9">
                      <input type="date" class="form-control" id="fecha_tim" name="fecha_tim" required maxlength="160"
                        value="<?php echo $cliente->fecha_tim ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Razon Social:</label>
                    <div class="col-sm-9">
                      <input type="razon_social" class="form-control" id="razon_social" name="razon_social" required
                        maxlength="160" value="<?php echo $cliente->razon_social ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Nombre Fantasia:</label>
                    <div class="col-sm-9">
                      <input type="razon_social" class="form-control" id="nombre_fantasia" name="nombre_fantasia" required
                        maxlength="160" value="<?php echo $cliente->nombre_fantasia ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Establecimiento N:</label>
                    <div class="col-sm-9">
                      <input type="number" class="form-control" id="establecimiento" name="establecimiento" required
                        maxlength="160" value="<?php echo $cliente->establecimiento ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">N Timbrado:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="timbrado" name="timbrado" required maxlength="150"
                        value="<?php echo $cliente->timbrado ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Codigo de Actividad:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="codigo_act" name="codigo_act" required maxlength="80"
                        value="<?php echo $cliente->codigo_act ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Actividad:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="actividad" name="actividad" required maxlength="80"
                        value="<?php echo $cliente->actividad ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Complemento Direccion:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="com_dir" name="com_dir" required maxlength="80"
                        value="<?php echo $cliente->com_dir ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Complemento Direccion:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="com_dir2" name="com_dir2" required maxlength="80"
                        value="<?php echo $cliente->com_dir2 ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Email:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="email" name="email" required maxlength="80"
                        value="<?php echo $cliente->email ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Entorno:</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="venta_de" id="entorno">

                        <option value="test">Test</option>
                        <option value="prod">Produccion</option>

                      </select>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Es Facturador electrónico:</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="is_facturador" name="is_facturador">

                        <option value="1">SI</option>
                        <option value="0">NO</option>

                      </select>
                    </div>
                  </div>


                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Especializada en Venta de:</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="venta_de" name="venta_de">

                        <option value="1">Productos</option>
                        <option value="2">Servicios</option>
                        <option value="3">Productos y Servicios</option>

                      </select>
                    </div>
                  </div>







                </div>
                <div class="modal-footer">
                  <input type="hidden" id="id_sucursal" name="id_sucursal" value="<?php echo $_GET["id_sucursal"]; ?>">
                  <button onclick="actualizar()" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i>
                    Guardar</button>
                  <!-- </form> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
      var cert = "";
      var logo = "";

      function subirCert() {
        var formData = new FormData();
        var files = $('#certificado')[0].files[0];
        formData.append('file', files);
        formData.append('id', '<?php echo $_GET['id_sucursal'] ?>');
        $.ajax({
          // url: "http://localhost:3000/subircert",
          url: "http://18.208.224.72:3000/subircert",
          type: "POST",
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          success: function (dataResult) {
            console.log(dataResult);
            //  cert = data.file
            var formData2 = new FormData();
            formData2.append('cert', dataResult.file);
            formData2.append('id', '<?php echo $_GET['id_sucursal'] ?>');
            $.ajax({
              url: "./index.php?action=actualizarcert",
              type: "POST",
              data: formData2,
              cache: false,
              contentType: false,
              processData: false,
              success: function (dataResult) {
                if (dataResult != 0) {
                  Swal.fire({
                    title: "Certificado actualizado",
                    icon: 'info',
                    confirmButtonText: 'Aceptar'
                  });
                } else {
                  Swal.fire({
                    title: "Error",
                    icon: 'danger',
                    confirmButtonText: 'Aceptar'
                  });
                }

              }
            })
          }
        });
      }

      function subirLogo() {
        var formData = new FormData();
        var files = $('#logo')[0].files[0];
        formData.append('file', files);
        formData.append('id', '<?php echo $_GET['id_sucursal'] ?>');
        $.ajax({
          url: "./index.php?action=actualizarlogo",
          type: "POST",
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          success: function (dataResult) {
            if (dataResult != 0) {
              Swal.fire({
                title: "Logo actualizado",
                icon: 'info',
                confirmButtonText: 'Aceptar'
              });
            } else {
              Swal.fire({
                title: "Error",
                icon: 'danger',
                confirmButtonText: 'Aceptar'
              });
            }

          }
        });
      }

      function actualizar() {
        var formData = new FormData();
        formData.append('venta_de', $("#venta_de").val());
        formData.append('is_facturador', $("#is_facturador").val());
        formData.append('nombre', $("#nombre").val());
        formData.append('ruc', $("#ruc").val());
        formData.append('telefono', $("#telefono").val());
        formData.append('representante', $("#representante").val());
        formData.append('direccion', $("#direccion").val());
        formData.append('descripcion', $("#descripcion").val());
        formData.append('id_sucursal', $("#id_sucursal").val());
        formData.append('entorno', $("#entorno").val());
        formData.append('clave', $("#clave").val());
        formData.append('timbrado', $("#timbrado").val());
        formData.append('fecha_firma', $("#fecha_firma").val());
        formData.append('razon_social', $("#razon_social").val());

        formData.append('nombre_fantasia', $("#nombre_fantasia").val());
        formData.append('establecimiento', $("#establecimiento").val());
        formData.append('razon_social', $("#razon_social").val());
        formData.append('codigo_act', $("#codigo_act").val());
        formData.append('actividad', $("#actividad").val());
        formData.append('fecha_tim', $("#fecha_tim").val());
        formData.append('numero_casa', $("#numero_casa").val());
        formData.append('com_dir', $("#com_dir").val());
        formData.append('com_dir2', $("#com_dir2").val());
        formData.append('com_dir2', $("#com_dir2").val());
        formData.append('email', $("#email").val());
        formData.append('departamento_descripcion', $('select[name="departa"] option:selected').text());
        formData.append('distrito_descripcion', $('select[name="distrito"] option:selected').text());
        formData.append('ciudad_descripcion', $('select[name="ciudad"] option:selected').text());
        formData.append('id_ciudad', $('select[name="ciudad"] option:selected').val());
        formData.append('distrito_id', $('select[name="distrito"] option:selected').val());
        formData.append('cod_depart', $('select[name="departa"] option:selected').val());
        //  formData.append('ciudad_descripcion', $('select[name="ciudad"]:checked').val());
        //  $('input[name="metodopago"]:checked').val()
        $.ajax({
          url: "./index.php?action=actualizarsucursal",
          type: "POST",
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          success: function (dataResult) {
            if (dataResult == 1) {
              Swal.fire({
                title: "Sucursal actualizada",
                icon: 'info',
                confirmButtonText: 'Aceptar'
              });
            } else {
              Swal.fire({
                title: "Error al actualizar",
                icon: 'danger',
                confirmButtonText: 'Aceptar'
              });
            }
          }
        });
      }



      function ciudades(distrito) {
        console.log('222222222', distrito)

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
              if ('<?= $cliente->id_ciudad ?>' == data_1.codigo) {
                ciudades += `<option selected value="${data_1.codigo}">${data_1.descripcion}</option>`;
              } else {
                ciudades += `<option  value="${data_1.codigo}">${data_1.descripcion}</option>`;
              }
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
              if ('<?php echo $cliente->distrito_id ?>' == data_1.codigo) {
                distritos += `<option selected value="${data_1.codigo}">${data_1.descripcion}</option>`;
              } else {
                distritos += `<option  value="${data_1.codigo}">${data_1.descripcion}</option>`;
              }
            }
            $("#distritos").html(distritos);
            buscaCiudad()
          }
        });
      }
      setTimeout(() => {
        buscarDistritos()

      }, 500);
    </script>
  </div>
<?php else: ?>
<?php endif; ?>