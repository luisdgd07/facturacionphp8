<?php if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") : ?>
  <?php
  $u = null;
  if ($_SESSION["admin_id"] != "") {
    $u = UserData::getById($_SESSION["admin_id"]);
    // $user = $u->nombre." ".$u->apellido;
  } ?>
  <?php


  $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);



  $cliente = ClienteData::getById($_GET["id_cliente"]);
  $url = "storage/personal/pagina/" . $cliente->id_cliente . "/" . $cliente->imagen;
  ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1> <i class="fa fa-cubes"></i>
        ACTUALIZAR DATOS DEL CLIENTE
        <small> </small>
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <?php
          if (isset($_SESSION["actualizar_datos"])) : ?>
            <p class="alert alert-info"><i class="fa fa-check"></i> Datos del cliente actualizados correctamente</p>
          <?php
            unset($_SESSION["actualizar_datos"]);
          endif; ?>
          <div class="box-tools pull-left">

            <!-- <a href="index.php?view=actualizarcliente" data-toggle="modal" class="btn btn-success btn-sm"><i class="fa fa-refresh"></i></a> -->
          </div>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-danger btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="panel-body">
            <form class="form-horizontal" enctype="multipart/form-data" method="post" action="index.php?action=actualizarcliente" role="form">
              <!--  -->
              <!--  <div class="panel panel-warning text-center">
                          <div class="panel-heading">
                                <a class="fancybox" href="storage/cliente/<?php echo $cliente->imagen; ?> target="_blank" data-fancybox-group="gallery" title="Imagen del Cliente"><img class="fancyResponsive" src="storage/cliente/<?php echo $cliente->imagen; ?>" alt="" width="30%" height="30%" /></a>
                          </div>
                      </div> -->
              <!--  -->
              <center>
                <div>
                  <img src="storage/cliente/<?php echo $cliente->imagen; ?>" class="img-responsive img-circle" alt="" with-border="100$" width="30%" height="30%">
                </div>
              </center>
              <div class="form-group has-warning has-feedback">
                <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> Nombre</label>
                <div class="col-lg-10">
                  <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $cliente->nombre; ?>">
                  <span class="fa fa-user-secret form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-warning has-feedback">
                <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> Apellidos</label>
                <div class="col-lg-10">
                  <input type="text" class="form-control" name="apellido" id="apellido" value="<?php echo $cliente->apellido; ?>">
                  <span class="fa fa-file-text form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-warning has-feedback">
                <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> Telefono</label>
                <div class="col-lg-4">
                  <input type="text" class="form-control" name="telefono" id="telefono" value="<?php echo $cliente->telefono; ?>">
                  <span class="fa fa-tty form-control-feedback"></span>
                </div>
                <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> Celular</label>
                <div class="col-lg-4">
                  <input type="text" class="form-control" name="celular" id="celular" value="<?php echo $cliente->celular; ?>">
                  <span class="fa fa-phone form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-2 control-label">Tipo Doc.</label>
                <div class="col-sm-4">
                  <select class="form-control" name="tipo_doc">
                    <option value="<?php echo $cliente->tipo_doc; ?>"><?php echo $cliente->tipo_doc; ?></option>
                    <option value="RUC">RUC</option>
                    <option value="CI">C.I.</option>
                    <option value="CLIENTE DEL EXTERIOR">CLIENTE DEL EXTERIOR</option>
                    <option value="PASAPORTE">PASAPORTE</option>
                    <option value="CEDULA DE EXTRANJERO">CEDULA DE EXTRANJERO</option>
                    <option value="SIN NOMBRE">SIN NOMBRE</option>
                    <option value="DIPLOMATICO">DIPLOMATICO</option>
                    <option value="IDENTIFICACION TRIBUTARIA">IDENTIFICACIÓN TRIBUTARIA</option>
                  </select>
                </div>
				
				  <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-2 control-label">Tipo Operación.</label>
               <div class="col-sm-4">
                  <select class="form-control" name="tipo_operacion">
				    <option value="<?php echo $cliente->tipo_operacion; ?>"><?php echo $cliente->tipo_operacion; ?></option>
                    <option value="1">B2B Business to Business</option>
                    <option value="2">B2C Business to Consumer</option>
                    <option value="3">B2G Business to Government</option>
                    <option value="4">B2F Business to Foreign</option>
                  </select>
                </div>
              </div>
                <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> N° Documento</label>
                <div class="col-lg-4">
                  <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $cliente->dni; ?>">
                  <span class="fa fa-barcode form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-warning has-feedback">
                <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> Tipo de cliente</label>
                <div class="col-lg-10">
                  <select name="id_precio" id="id_precio" class="form-control">
                    <?php
                    $clients = ProductoData::listar_precio($_GET['id_sucursal']);

                    foreach ($clients as $client) :

                      // $tipocliente = ProductoData::listar_tipo_precio($client->id_precio);
                      if ($cliente->id_precio == $client->PRECIO_ID) {
                    ?>
                        <option selected value="<?php echo $client->PRECIO_ID; ?>"><?php echo $client->NOMBRE_PRECIO ?></option>
                      <?php } else {
                      ?>

                        <option value="<?php echo $client->PRECIO_ID; ?>"><?php echo $client->NOMBRE_PRECIO ?></option>
                    <?php }
                    endforeach;

                    ?>
                  </select>
                  <span class="fa fa-user-secret form-control-feedback"></span>
                </div>
              </div>



              <div class="form-group has-warning has-feedback">
                <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> Direccion</label>
                <div class="col-lg-10">
                  <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $cliente->direccion; ?>">
                  <span class="fa fa-map-marker form-control-feedback"></span>
                </div>
              </div>
			  
			  <div class="form-group has-feedback has-warning">
                <label for="pais_id" class="col-sm-3 control-label">Pais:</label>
                <div class="col-sm-9">
                 
				  
				    <select name="pais_id" id="pais_id" class="form-control">
                    <?php
                    $pais_t = PaisData::getAll();
                   
                    foreach ($pais_t as $dpt) :
                      if ($cliente->pais_id == $dpt->id) {
                    ?>

                        <option selected value="<?php echo $dpt->id;
                                                ?>"><?php echo $dpt->descripcion
                                                    ?></option>
                      <?php } else {
                      ?>
                        <option value="<?php echo $dpt->id;
                                        ?>"><?php echo $dpt->descripcion
                                            ?></option><?php
                                                      }
                                                    endforeach;
                                                        ?>
                  </select>
				  
				  
				  
                </div>
              </div>
              <div class="form-group has-feedback has-warning">
                <label for="inputEmail1" class="col-sm-3 control-label">Departamento:</label>
                <div class="col-sm-9">
                  <select name="departa" id="dpt_id" onchange="buscard()" class="form-control">
                    <?php
                    $dpts = DptData::getAll();
                    $distritocli = $cliente->distrito_id;
                    $ciudadcli = $cliente->ciudad;
                    foreach ($dpts as $dpt) :
                      if ($cliente->departamento_id == $dpt->codigo) {
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
                  <select onchange="buscaCiudad()" onclick="buscaCiudad()" name="distrito" id="ciudades" class="form-control">
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

               




              <div class="form-group has-warning has-feedback">
                <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> Email</label>
                <div class="col-lg-10">
                  <input type="text" class="form-control" name="email" id="email" value="<?php echo $cliente->email; ?>">
                  <span class="fa fa-google-plus form-control-feedback"></span>
                </div>
              </div>
              <div class="form-group has-warning has-feedback">
                <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> Imagen</label>
                <div class="col-lg-10">
                  <input type="file" class="form-control" name="imagen" id="imagen">
                  <span class="fa fa-image form-control-feedback"></span>
                </div>
              </div>
            <div class="form-group">
               
                
               
                      <div class="form-group has-warning has-feedback">
                <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i>Estado</label>
				
				  <div class="col-lg-10">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="is_activo" <?php if ($cliente->is_activo) {
                                                                echo "checked";
                                                              } ?>> Activo
                    </label>
                  </div>
                </div>
				</div>
              </div>
			  
			  
			  <div class="form-group has-warning has-feedback">
                <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> Días crédito cliente</label>
                <div class="col-lg-10">
                  <input type="text" class="form-control" name="dias_credito" id="dias_credito" value="<?php echo $cliente->dias_credito; ?>">
                  <span class="fa fa-google-plus form-control-feedback"></span>
                </div>
              </div>
			  
              <div class="form-group">
                <div class="col-lg-offset-2 col-lg-12">
                  <input type="hidden" name="id_cliente" value="<?php echo $_GET["id_cliente"]; ?>">
                  <input type="hidden" name="id_sucursal" value="<?php echo $_GET["id_sucursal"]; ?>">
                  <button type="submit" class="btn btn-warning "><i class="fa fa-cog fa-spin fa-1x fa-fw"></i> Actualizar Datos</button>
                  <button type="reset" class="btn btn-info "><i class="fa fa-eraser fa-spin fa-1x fa-fw"></i> Borrar</button>
                </div>
              </div>
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
                // console.log(<?= $distritocli ?>, data_1.codigo)
                if ('<?= $ciudadcli ?>' == data_1.codigo) {
                  ciudades += `<option selected value="${data_1.codigo}">${data_1.descripcion}</option>`;
                } else {
                  ciudades += `<option  value="${data_1.codigo}">${data_1.descripcion}</option>`;
                }
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
                console.log(<?= $distritocli ?>, data_1.codigo)
                // $ciudadcli
                if ('<?php echo $distritocli ?>' == data_1.codigo) {
                  ciudades += `<option selected value="${data_1.codigo}">${data_1.descripcion}</option>`;
                } else {
                  ciudades += `<option value="${data_1.codigo}">${data_1.descripcion}</option>`;
                }
              }
              $("#ciudades").html(ciudades);
            }
          });
        }
        buscard()
        buscaCiudad()
        setTimeout(() => {
          buscaCiudad()

        }, 500);
      </script>
    </section>
  </div>


<?php else : ?>
<?php endif; ?>