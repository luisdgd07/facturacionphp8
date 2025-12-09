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

    $server   = "localhost:3306";
    $username = "root";
    $password = "asysodonto";
    $database = "rconsult_ventas";


    $mysqli = new mysqli($server, $username, $password, $database);
    $queryd = mysqli_query($mysqli, "SELECT * FROM `documentos_observacion` WHERE `cliente_id` = $_GET[cliente_id] ")
      or die('error: ' . mysqli_error($mysqli));
    $data  = mysqli_fetch_assoc($queryd);
    $queryd2 = mysqli_query($mysqli, "SELECT * FROM `documentos_presento` WHERE `cliente_id` = $_GET[cliente_id]")
      or die('error: ' . mysqli_error($mysqli));
    $data2  = mysqli_fetch_assoc($queryd2);
    $queryd3 = mysqli_query($mysqli, "SELECT * FROM `documentos_archivos` WHERE `cliente_id` = $_GET[cliente_id]")
      or die('error: ' . mysqli_error($mysqli));
    $data3  = mysqli_fetch_assoc($queryd3);
    ?>

    </section>

    <!-- Main content -->
    <div class="content-wrapper">
      <section class="content-header">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              <!-- form start -->
              <?php if ($data == NULL) { ?>
                <form role="form" class="form-horizontal" enctype="multipart/form-data" action="index.php?action=proccess_doc&created=false" method="POST">
                <?php } else { ?>
                  <form role="form" class="form-horizontal" enctype="multipart/form-data" action="index.php?action=proccess_doc&created=true" method="POST">
                  <?php } ?>
                  <input type="text" value="<?php echo $_GET['cliente_id']; ?>" name="id_cliente" hidden>
                  <div class="col-md-4">

                    <div class="box-body">

                      

                      <div class="form-group">
                        <h3 class="">Documentos Persona Física</h3>

                      </div>
						
						
						<div class="form-group" style="margin-top: 21px;">
                        <label class="">Contrato del cliente</label>
                      </div>
						
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="">Formulario de identificación del cliente</label>
                      </div>

                      <div class="form-group" style="margin-top: 21px;">
                        <label class="" readonly>Escritura de constitución de la sociedad y sus modifiaciones</label>

                      </div>
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="">Copia de cedula de identidad</label>

                      </div>
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="">Copia de cedula tributaria (RUC)</label>

                      </div>
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="">Ultimas 3 declaraciones juradas de IVA </label>

                      </div>
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="">Ultimo Balance General de Estado de Resultados </label>
                      </div>
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="">Ultimo formulario de IRE presentado (IRE simple, RE simple, General)</label>
                      </div>
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="">Ultima factura de servicio basico</label>
                      </div>
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="">Certificado de cumplimiento tributario</label>
                      </div>
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="">Declaración jurada de origen de fondos</label>
                      </div>
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="">Consulta de lista OFAC, ONU</label>
                      </div>
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="">Consulta de lista OFAC PEPs</label>
                      </div>
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="">Matriz de riesgo</label>
                      </div>
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="">Informconf</label>
                      </div>
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="" readonly>Registro de inscripción en seprelad (Si aplica)</label>
                      </div>
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="">Total de documentos a presentar</label>
                      </div>
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="">Total de documentos presentados</label>
                      </div>
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="">Realizado por</label>
                      </div>
                      <div class="form-group" style="margin-top: 21px;">
                        <label class="">Fecha</label>
                      </div>

                    </div><!-- /.box body -->


                  </div>

                  <div class="col-md-1">

                    <div class="box-body">


                         <div class="form-group">
                        <h3 class="">Presentó</h3>

                      </div>
                      <div class="form-group">
                        <select class="form-control" name="contrato_cliente">
                          <?php if ($data) { ?>
                            <option><?php echo $data2['contrato_cliente'] ?></option>
                          <?php
                          } ?>
                          <option value="si">Sí</option>
                          <option value="no">No</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <select class="form-control" name="ruc1">
                          <?php if ($data) { ?>
                            <option><?php echo $data2['form_identificacion'] ?></option>
                          <?php
                          } ?>
                          <option value="si">Sí</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="ruc2">
                          <?php if ($data) { ?>
                            <option>No aplica</option>
                          <?php
                          } ?>
                          <option value="no">No aplica</option>

                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="ruc3">
                          <?php if ($data) { ?>
                            <option><?php echo $data2['cedula_iden'] ?></option>
                          <?php
                          } ?>
                          <option value="si">Sí</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="ruc4">
                          <?php if ($data) { ?>
                            <option><?php echo $data2['cedula_tribu'] ?></option>
                          <?php
                          } ?>
                          <option value="si">Sí</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="ruc5">
                          <?php if ($data) { ?>
                            <option><?php echo $data2['declaracion_iva'] ?></option>
                          <?php
                          } ?>
                          <option value="si">Sí</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="ruc6">
                          <?php if ($data) { ?>
                            <option><?php echo $data2['balance_gen'] ?></option>
                          <?php
                          } ?>
                          <option value="si">Sí</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="ruc7">
                          <?php if ($data) { ?>
                            <option><?php echo $data2['form_ire'] ?></option>
                          <?php
                          } ?>
                          <option value="si">Sí</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="ruc8">
                          <?php if ($data) { ?>
                            <option><?php echo $data2['factura_ser'] ?></option>
                          <?php
                          } ?>
                          <option value="si">Sí</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="ruc9">
                          <?php if ($data) { ?>
                            <option><?php echo $data2['cert_cumpli'] ?></option>
                          <?php
                          } ?>
                          <option value="si">Sí</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="ruc10">
                          <?php if ($data) { ?>
                            <option><?php echo $data2['decla_jur'] ?></option>
                          <?php
                          } ?>
                          <option value="si">Sí</option>
                          <option value="no">No</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <select class="form-control" name="ruc11">
                          <?php if ($data) { ?>
                            <option><?php echo $data2['consulta_lista_peps'] ?></option>
                          <?php
                          } ?>
                          <option value="si">Sí</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="ruc12">
                          <?php if ($data) { ?>
                            <option><?php echo $data2['consulta_list_ofac'] ?></option>
                          <?php
                          } ?>
                          <option value="si">Sí</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="ruc13">
                          <?php if ($data) { ?>
                            <option><?php echo $data2['matriz_riesgo'] ?></option>
                          <?php
                          } ?>
                          <option value="si">Sí</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="ruc14">
                          <?php if ($data) { ?>
                            <option><?php echo $data2['informconf'] ?></option>
                          <?php
                          } ?>
                          <option value="si">Sí</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="ruc15">
                          <?php if ($data) { ?>
                            <option>No aplica</option>
                          <?php
                          } ?>

                          <option value="no">No aplica</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="ruc16">
                          <?php if ($data) { ?>
                            <option><?php echo $data2['total_doc_presentar'] ?></option>
                          <?php
                          } ?>
                          <option value="si">Sí</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="ruc17">
                          <?php if ($data) { ?>
                            <option><?php echo $data2['total_doc_presentado'] ?></option>
                          <?php
                          } ?>
                          <option value="si">Sí</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="ruc18">

                          <?php if ($data) { ?>
                            <option><?php echo $data2['realizado_por'] ?></option>
                          <?php
                          } ?>
                          <option value="si">Sí</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                    </div>


                  </div>
                  <div class="col-md-3">

                    <div class="box-body">



                      <div class="form-group">
                        <h3 class="">Archivos</h3>

                      </div>
						
						<div class="form-group">
                        <div class="">
                          <input type="file" class="form-control" name="contrato_cliente_" autocomplete="off">
                        </div>
                      </div>
						
                      <div class="form-group">
                        <div class="">
                          <input type="file" class="form-control" name="formularioIdentificacionCliente_" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="file" readonly class="form-control" name="escrituraConstitucionSociedad_" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="file" class="form-control" name="copiaCedulaSocios_" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="file" class="form-control" name="copiaCedulaRUC_" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="file" class="form-control" name="declaracionesIVA_" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="file" class="form-control" name="balanceGeneralEstadoResultados_" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="file" class="form-control" name="formularioIREPresentado_" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="file" class="form-control" name="ultimaFacturaServicioBasico_" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="file" class="form-control" name="certificadoCumplimientoTributario_" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="file" class="form-control" name="declaracionJuradaOrigenFondos_" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="file" class="form-control" name="consultaListaOFACONU_" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="file" class="form-control" name="consultaListaOFACPEPs_" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="file" class="form-control" name="matrizRiesgo_" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="file" class="form-control" name="informconf_" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="file" readonly class="form-control" name="registroInscripcionSeprelad_" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="file" class="form-control" name="totalDocumentosPresentar_" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="file" class="form-control" name="totalDocumentosPresentados_" autocomplete="off">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="">
                          <input type="file" class="form-control" name="realizado_" autocomplete="off">
                        </div>
                      </div>

                    </div>


                  </div>
                  <div class="col-md-2">

                    <div class="box-body">



                      <div class="form-group">
                        <h3 class="">Observación</h3>

                      </div>
                      <div class="form-group">
                        <div class="">
                          <input type="text" class="form-control" value="<?php echo $data ? $data['contrato_cliente'] : '' ?>" name="contrato_cliente" autocomplete="off">
                        </div>
                      </div>
						
						<div class="form-group">
                        <div class="">
                          <input type="text" class="form-control" value="<?php echo $data ? $data['form_identificacion'] : '' ?>" name="formularioIdentificacionCliente" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="text" readonly class="form-control" value="<?php echo $data ? $data['escri_constitucion'] : '' ?>" name="escrituraConstitucionSociedad" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="text" class="form-control" value="<?php echo $data ? $data['cedula_iden'] : '' ?>" name="copiaCedulaSocios" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="text" class="form-control" value="<?php echo $data ? $data['cedula_tribu'] : '' ?>" name="copiaCedulaRUC" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="text" class="form-control" value="<?php echo $data ? $data['declaracion_iva'] : '' ?>" name="declaracionesIVA" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="text" class="form-control" value="<?php echo $data ? $data['balance_gen'] : '' ?>" name="balanceGeneralEstadoResultados" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="text" class="form-control" value="<?php echo $data ? $data['form_ire'] : '' ?>" name="formularioIREPresentado" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="text" class="form-control" value="<?php echo $data ? $data['factura_ser'] : '' ?>" name="ultimaFacturaServicioBasico" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="text" class="form-control" value="<?php echo $data ? $data['cert_cumpli'] : '' ?>" name="certificadoCumplimientoTributario" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="text" class="form-control" value="<?php echo $data ? $data['decla_jur'] : '' ?>" name="declaracionJuradaOrigenFondos" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="text" class="form-control" value="<?php echo $data ? $data['consulta_lista_peps'] : '' ?>" name="consultaListaOFACONU" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="text" class="form-control" value="<?php echo $data ? $data['consulta_list_ofac'] : '' ?>" name="consultaListaOFACPEPs" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="text" class="form-control" value="<?php echo $data ? $data['matriz_riesgo'] : '' ?>" name="matrizRiesgo" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="text" class="form-control" value="<?php echo $data ? $data['informconf'] : '' ?>" name="informconf" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="text" readonly class="form-control" value="<?php echo  $data ? $data['reg_ins_seprelad'] : "" ?>" name="registroInscripcionSeprelad" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="text" class="form-control" value="<?php echo $data ? $data['total_doc_presentar'] : "" ?>" name="totalDocumentosPresentar" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="">
                          <input type="text" class="form-control" value="<?php echo $data ? $data['total_doc_presentado'] : "" ?>" name="totalDocumentosPresentados" autocomplete="off">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="">
                          <input type="text" class="form-control" value="<?php echo $data ? $data['realizado_por'] : "" ?>" name="realizado" autocomplete="off">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="">
                          <input type="date" class="form-control" value="<?php echo $data['fecha'] ?>" name="fecha" autocomplete="off">
                        </div>
                      </div>
                    </div>


                  </div>
                  <?php if ($data3) {
                  ?>
                    <div class="col-md-2">

                      <div class="box-body">



                        <div class="form-group">
                          <h3 class=""> Descargar</h3>

                        </div>
						  
						  
						   <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['contrato_cliente']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['form_identificacion']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['escri_constitucion']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['cedula_iden']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['cedula_tribu']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['declaracion_iva']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['balance_gen']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['form_ire']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['factura_ser']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['cert_cumpli']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['decla_jur']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['consulta_lista_peps']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['consulta_list_ofac']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['matriz_riesgo']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['informconf']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['reg_ins_seprelad']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['total_doc_presentar']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['total_doc_presentado']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <a href="<?php echo './storage/' . $data3['realizado_por']; ?>" class="btn btn-success" target="_blank">Descargar</a>
                          </div>
                        </div>



                      </div>


                    </div>
                  <?php } ?>
                  <div class="box-footer">
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" class="btn btn-primary btn-submit" name="Guardar" value="Guardar">


                        <a href="?module=clientes" class="btn btn-default btn-reset">Cancelar</a>
                      </div>
                    </div>
                  </div>

                  </form>
            </div>




          </div><!-- /.box -->
        </div><!--/.col -->
      </section><!-- /.content -->
    </div>
  <?php endif ?>
<?php endif ?>