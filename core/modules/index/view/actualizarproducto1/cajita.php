<?php if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != ""): ?>
  <?php
  $u = null;
  if ($_SESSION["admin_id"] != "") {
    $u = UserData::getById($_SESSION["admin_id"]);
    // $user = $u->nombre." ".$u->apellido;
  } ?>
  <?php

  $cliente = ProductoData::getById($_GET["id_producto"], "id_producto");
  // $url = "storage/plato/".$cliente->id_plato."/".$cliente->imagen;
  ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='fa fa-laptop' style="color: orange;"></i>
        ACTUALIZAR DATOS DEL PRODUCTO <?php ?>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="box">
          <div class="box-body">


            <img src="storage/producto/<?php echo $cliente->imagen ?>" alt="" class="img-responsive">
          </div>
        </div>

        <div class="col-md-8">
          <div class="box">
            <div class="box-body">
              <div class="box box-warning">
                <div class="panel-body">
                  <div class="form-horizontal">

                    <div class="form-group has-warning">
                      <label for="inputEmail1" class="col-lg-3 control-label">Grupo:</label>
                      <div class="col-lg-9">
                        <?php
                        $categories = GrupoData::vergrupossucursal($cliente->sucursal_id);
                        if (count($categories) > 0): ?>
                          <select name="id_grupo" id="id_grupo" class="form-control">
                            <option value="<?php if (!isset($cliente->id_grupo)) {
                              echo 0;
                            } else {
                              echo $cliente->id_grupo;
                            } ?>">SELECCIONAR GRUPO</option>
                            <?php foreach ($categories as $cat): ?>
                              <!-- <option value="<?php echo $cat->id_grupo; ?>"><i class="fa fa-gg"></i><?php echo $cat->nombre_grupo; ?></option> -->
                              <option value="<?php echo $cat->id_grupo; ?>" <?php if ($cliente->id_grupo == $cat->id_grupo) {
                                   echo "selected";
                                 } ?>><?php echo $cat->nombre_grupo; ?></option>
                            <?php endforeach; ?>
                          </select>
                        <?php endif; ?>

                      </div>
                    </div>

                    <div class="form-group has-warning">
                      <label for="inputEmail1" class="col-lg-3 control-label">Imagen</label>
                      <div class="col-lg-9">
                        <input type="file" class="form-control" name="imagen" id="imagen">
                      </div>
                    </div>


                    <div class="form-group has-warning">
                      <label for="inputEmail1" class="col-sm-3 control-label">Nombre</label>

                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="nombre" name="nombre" required maxlength="80"
                          value="<?php echo $cliente->nombre; ?>">
                      </div>
                    </div>
                    <div class="form-group has-warning">
                      <label for="inputEmail1" class="col-sm-3 control-label">Categoria</label>
                      <div class="col-sm-9">
                        <?php
                        $categories = CategoriaData::vercategoriassucursal($cliente->sucursal_id);
                        if (count($categories) > 0): ?>
                          <select name="categoria_id" id="categoria_id" class="form-control">
                            <option value="<?php if (!isset($cliente->id_categoria)) {
                              echo 0;
                            } else {
                              echo $cliente->id_categoria;
                            } ?>">SELECCIONAR CATEGORIA</option>
                            <?php foreach ($categories as $cat): ?>
                              <!-- <option value="<?php echo $cat->id_categoria; ?>"><i class="fa fa-gg"></i><?php echo $cat->nombre; ?></option> -->
                              <option value="<?php echo $cat->id_categoria; ?>" <?php if ($cliente->categoria_id == $cat->id_categoria) {
                                   echo "selected";
                                 } ?>><?php echo $cat->nombre; ?></option>
                            <?php endforeach; ?>
                          </select>
                        <?php endif; ?>

                      </div>
                    </div>


                    <div class="form-group has-warning">
                      <label for="inputEmail1" class="col-sm-3 control-label">Marcas</label>
                      <div class="col-sm-9">
                        <?php
                        $Marcas = MarcaData::vermarcasucursal($cliente->sucursal_id);
                        if (count($Marcas) > 0): ?>
                          <select name="marca_id" id="marca_id" class="form-control">
                            <option value="<?php echo $cliente->id_marca ?>">SELECCIONAR MARCA</option>
                            <?php foreach ($Marcas as $marc): ?>
                              <!-- <option value="<?php echo $marc->id_marca; ?>"><i class="fa fa-gg"></i><?php echo $marc->nombre; ?></option> -->
                              <option value="<?php echo $marc->id_marca; ?>" <?php if ($cliente->marca_id == $marc->id_marca) {
                                   echo "selected";
                                 } ?>><?php echo $marc->nombre; ?></option>
                            <?php endforeach; ?>
                          </select>
                        <?php endif; ?>

                      </div>
                    </div>

                    <div class="form-group has-warning">
                      <label for="inputEmail1" class="col-sm-3 control-label">Descripcion</label>
                      <div class="col-sm-4">
                        <textarea name="descripcion" id="descripcion"
                          class="form-control"><?php echo $cliente->descripcion; ?></textarea>
                      </div>
                      <label for="inputEmail1" class="col-sm-2 control-label">Presentacion</label>
                      <div class="col-sm-3">
                        <select class="form-control" name="presentacion" id="presentacion" required="">
                          <?php $unidades = UnidadesData::getAll();
                          if (count($unidades) > 0): ?>
                            <?php if (UnidadesData::getById_($cliente->presentacion)) { ?>
                              <option value="<?php echo $cliente->presentacion ?>">
                                <?php echo UnidadesData::getById_($cliente->presentacion)->nombre ?>
                              </option>
                            <?php } ?>
                            <?php foreach ($unidades as $unidad): ?>
                              <option value="<?php echo $unidad->id; ?>" style="color: orange;"><i
                                  class="fa fa-gg"></i><?php echo $unidad->nombre; ?></option>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        </select>
                      </div>
                    </div>


                    <div class="form-group has-warning" hidden>
                      <label for="inputEmail1" class="col-sm-3 control-label">Precio Compra <b>$</b></label>

                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="precio_compra" name="precio_compra" maxlength="100"
                          value="<?php echo round(($cliente->precio_compra), 4); ?>">
                      </div>
                    </div>

                    <div class="form-group has-warning">
                      <label for="inputEmail1" class="col-sm-3 control-label">Minimo Inventario</label>

                      <div class="col-sm-5">
                        <input type="text" class="form-control" id="inventario_minimo" name="inventario_minimo"
                          maxlength="10" value="<?php echo $cliente->inventario_minimo; ?>">


                      </div>


                    </div>
                    <div class="form-group has-warning">
                      <label for="inputEmail1" class="col-sm-3 control-label">Impuesto:</label>
                      <div class="col-sm-5">
                        <select class="form-control" id="impuesto" name="impuesto" required maxlength="10">

                          <option value="<?php echo $cliente->impuesto; ?>"><?php echo $cliente->impuesto; ?></option>
                          <option value="10">10% Gravada</option>
                          <option value="5">5% Gravada</option>
                          <option value="0">0% Exenta</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group has-warning">
                      <label for="inputEmail1" class="col-sm-3 control-label">Tipología</label>
                      <div class="col-sm-9">
                        <?php
                        $Marcas = MarcaData::vermarcasucursal($cliente->sucursal_id);
                        if (count($Marcas) > 0): ?>
                          <select name="marca_id" id="marca_id" class="form-control">
                            <option value="<?php echo $cliente->id_marca ?>">SELECCIONAR TIPOLOGIA</option>
                            <?php foreach ($Marcas as $marc): ?>
                              <!-- <option value="<?php echo $marc->id_marca; ?>"><i class="fa fa-gg"></i><?php echo $marc->nombre; ?></option> -->
                              <option value="<?php echo $marc->id_marca; ?>" <?php if ($cliente->marca_id == $marc->id_marca) {
                                   echo "selected";
                                 } ?>><?php echo $marc->nombre; ?></option>
                            <?php endforeach; ?>
                          </select>
                        <?php endif; ?>

                      </div>
                    </div>
                    <div class="form-group has-feedback has-warning">
                      <label for="estado" class="col-sm-3 control-label">ESTADO:</label>
                      <div class="col-sm-9">


                        <select name="estado" id="estado" class="form-control">

                          <option value="<?php if ($cliente->activo == 1) {
                            echo "1";
                          } else if ($cliente->activo == 2) {
                            echo "2";
                          } else if ($cliente->activo == 3) {
                            echo "3";
                          } else if ($cliente->activo == 4) {
                            echo "4";
                          } ?>"> <?php if ($cliente->activo == 1) {
                             echo "Disponible";
                           } else if ($cliente->activo == 2) {
                             echo "Desabilitado";
                           } else if ($cliente->activo == 3) {
                             echo "En Construcción";
                           } else if ($cliente->activo == 4) {
                             echo "Reservado";
                           } ?> </option>
                          <option value="1">Disponible</option>
                          <option value="2">Desabilitado</option>
                          <option value="3">En Construcción</option>
                          <option value="4">Reservado</option>
                        </select>

                      </div>
                    </div>
                    <!-- <div class="form-group has-feedback has-warning">
                       <label class="col-sm-3 control-label"">Depósito:</label>
                     <div class=" col-lg-8">
                         <?php
                         $deposito = ProductoData::verdeposito($_GET["id_sucursal"]);
                         if (count($deposito) > 0): ?>
                           <select name="id_deposito" id="id_deposito" required class="form-control">
                             <option value="<?php echo $cat->id_categoria; ?>" <?php if ($cliente->categoria_id == $cat->id_categoria) {
                                  echo "selected";
                                } ?>><?php echo $cat->nombre; ?></option>
                             <?php foreach ($deposito as $depositos): ?>
                               <option value="<?php echo $depositos->DEPOSITO_ID; ?>" style="color: orange;"><i class="fa fa-gg"></i><?php echo $depositos->NOMBRE_DEPOSITO; ?></option>
                             <?php endforeach; ?>
                           </select>
                         <?php endif; ?>
                     </div>
                   </div> -->
                    <div class="form-group has-feedback has-warning">
                      <label for="inputEmail1" class="col-lg-2 control-label">Tipo Producto:</label>
                      <div class="col-lg-10">
                        <?php
                        $Tipoprod = ProductoData::verPRODTIPOSUC($_GET["id_sucursal"]);
                        if (count($Tipoprod) > 0): ?>
                          <select name="tipo_producto" id="tipo_producto" required class="form-control">
                            <?php if ($cliente->ID_TIPO_PROD) { ?>
                              <option value="<?php echo $cliente->ID_TIPO_PROD ?>">
                                <?php echo ProductoData::vertipoproductoId($cliente->ID_TIPO_PROD)->TIPO_PRODUCTO ?>
                              </option>
                            <?php } ?>
                            <?php foreach ($Tipoprod as $Tipoprods): ?>
                              <option value="<?php echo $Tipoprods->ID_TIPO_PROD; ?>" style="color: orange;"><i
                                  class="fa fa-gg"></i><?php echo $Tipoprods->TIPO_PRODUCTO; ?></option>
                            <?php endforeach; ?>
                          </select>
                        <?php endif; ?>
                      </div>
                    </div>
                    <div class="form-group has-feedback has-warning">
                      <label for="estado" class="col-sm-3 control-label">VENCIMIENTO:</label>
                      <div class="col-sm-9">



                        <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento"
                          maxlength="100" value="<?php echo $cliente->fecha_vencimiento; ?>">


                      </div>
                    </div>
                    <div class="form-group has-feedback has-warning">
                      <label for="moneda" class="col-sm-3 control-label">MONEDA:</label>
                      <div class="col-sm-9">


                        <select name="moneda" id="moneda" class="form-control">





                          <option value="GUARANIES">GUARANIES</option>
                          <option value="DOLARES">DOLARES</option>
                        </select>

                      </div>
                    </div>
                    <div class="form-group has-feedback has-warning">
                      <label for="contrato_id" class="col-sm-3 control-label">Contrato:</label>
                      <div class="col-sm-9">


                        <select name="contrato_id" id="contrato_id" class="form-control">
                          <?php
                          $pais_t = ContratoData::getAll();

                          foreach ($pais_t as $dpt):
                            if ($dpt->datos) {
                              if ($cliente->contrato_id == $dpt->id) {
                                ?>

                                <option selected value="<?php echo $dpt->id;
                                ?>"><?php echo $dpt->datos
                                  ?></option>
                              <?php } else {
                                ?>
                                <option value="<?php echo $dpt->id;
                                ?>"><?php echo $dpt->datos
                                  ?></option><?php
                              }
                            }
                          endforeach;

                          ?>
                        </select>


                      </div>
                    </div>

                    <div class="form-group has-warning">
                      <label for="inputEmail1" class="col-sm-3 control-label">Entrega:</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" id="precio_venta" name="precio_venta" maxlength="100"
                          value="<?php echo round(($cliente->precio_venta), 4); ?>">
                      </div>
                    </div>


                    <div class="form-group has-feedback has-warning">
                      <label for="cliente_id" class="col-sm-3 control-label">Cliente:</label>
                      <div class="col-sm-9">


                        <select name="cliente_id" id="cliente_id" class="form-control">
                          <option selected value="null">sin cliente</option>
                          <?php
                          $pais_t = ClienteData::getAll();

                          foreach ($pais_t as $dpt):
                            if ($cliente->cliente_id == $dpt->id_cliente) {
                              ?>

                              <option selected value="<?php echo $dpt->id_cliente;
                              ?>"><?php echo $dpt->nombre . ' ' . $dpt->apellido
                                ?></option>
                            <?php } else {
                              ?>
                              <option value="<?php echo $dpt->id_cliente;
                              ?>"><?php echo $dpt->nombre . ' ' . $dpt->apellido
                                ?></option><?php
                            }
                          endforeach;
                          ?>
                        </select>



                      </div>
                      <div class="form-group has-warning">
                        <label for="inputEmail1" class="col-sm-2 control-label">Activo</label>
                        <div class="col-sm-2">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" id="estado" name="estado" <?php if ($cliente->activo) {
                                echo "checked";
                              } ?>>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group has-feedback has-warning">


                      <label for="inputEmail1" class="col-lg-2 control-label">NCM:</label>
                      <div class="col-lg-4">
                        <input type="text" name="ganancia" id="ncm" value="<?php echo $cliente->ncm; ?>"
                          class="form-control">

                      </div>

                      <label for="inputEmail1" class="col-lg-2 control-label">Partida Arancelaria:</label>
                      <div class="col-lg-4">
                        <input type="text" name="ganancia" id="partida_arancelaria"
                          value="<?php echo $cliente->partida_arancelaria; ?>" class="form-control">
                      </div>

                    </div>
                    <div class="form-group has-feedback has-warning">


                      <label for="inputEmail1" class="col-lg-2 control-label">Codigo Nivel General:</label>
                      <div class="col-lg-4">
                        <input type="text" name="codigo_nivel_general" id="codigo_nivel_general"
                          value="<?php echo $cliente->codigoNivelGeneral; ?>" class="form-control">

                      </div>

                      <label for="inputEmail1" class="col-lg-2 control-label">CodigoNivelEspecifico:</label>
                      <div class="col-lg-4">
                        <input type="text" name="codigo_nivel_especifico" id="codigo_nivel_especifico"
                          value="<?php echo $cliente->codigoNivelEspecifico; ?>" class="form-control">
                      </div>

                    </div>
                    <div class="form-group has-feedback has-warning">


                      <label for="inputEmail1" class="col-lg-2 control-label">Codigo Gtin Producto:</label>
                      <div class="col-lg-4">
                        <input type="text" name="codigo_gtin_producto" id="codigo_gtin_producto"
                          value="<?php echo $cliente->codigoGtinProducto; ?>" class="form-control">

                      </div>

                      <label for="inputEmail1" class="col-lg-2 control-label">Codigo Nivel Paquete:</label>
                      <div class="col-lg-4">
                        <input type="text" name="codigo_nivel_paquete" id="codigo_nivel_paquete"
                          value="<?php echo $cliente->codigoNivelPaquete; ?>" class="form-control">
                      </div>

                    </div>
                    <div class="modal-footer">

                      <input type="hidden" name="id_producto" value="<?php echo $_GET["id_producto"]; ?>">
                      <input type="hidden" name="id_sucursal" value="<?php echo $_GET["id_sucursal"]; ?>">


                      <input type="hidden" name="sucursal_id" id="sucursal_id"
                        value="<?php echo $_GET["id_sucursal"]; ?>">



                      <?php

                      $id_prod = 0;


                      $cant = StockData::vercontenidos($_GET["id_producto"]);
                      foreach ($cant as $can) {

                        $id_dep = $can->DEPOSITO_ID;
                      }



                      ?>


                      <input type="hidden" name="id_deposito" value="<?php echo $id_dep; ?>">
                      <div class="box-header">
                        <i class="fa fa-laptop" style="color: orange;"></i> INGRESAR INSUMOS.
                        <input type="text" class="form-control" placeholder="Buscar" onchange="buscar()"
                          onclick="buscar()" id="buscarProducto">
                      </div>
                      <table class="table table-bordered table-hover">
                        <thead>
                          <th>Codigo</th>
                          <th>Nombre</th>
                          <th>Precio</th>
                          <th>Cantidad</th>
                        </thead>
                        <tbody id="tablaProductos">
                        </tbody>
                      </table>
                      <h2 class="text-center">Insumos:</h2>
                      <table class="table table-bordered table-hover">
                        <thead>
                          <th>Cantidad</th>
                          <th>Codigo</th>
                          <th>Producto</th>
                          <th>Precio</th>
                          <th>Total</th>
                          <th>Accion</th>
                        </thead>
                        <tbody id="tablaCarrito">

                        </tbody>
                      </table>
                      <h3 class="" style="text-align: center;" id="total">Total: 0</h3>
                      <button onclick="accion()" class="btn btn-block btn-warning"><i class="fa fa-save"></i></button>
                      <!-- <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-save"></i> Guardar</button> -->
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </section>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <label for="">Cantidad</label>
            <input type="number" id="canEdit" placeholder="Cantidad">
            <label for="">Precio</label>
            <input type="number" id="preEdit" placeholder="Precio">

          </div>
          <div class="modal-footer">
            <button type="button" data-bs-dismiss="modal" class="btn btn-danger" onclick="dismiss()">Cerrar</button>
            <button type="button" class="btn btn-primary" onclick="edita()">Guardar cambios</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php if (isset($_GET['id_producto'])) { ?>
    <script type="text/javascript">
      var carrito = []

      function actualizarTabla() {
        tabla = "";
        total = 0;
        grabada10 = 0;
        grabada5 = 0;
        exenta = 0;
        iva10 = 0;
        iva5 = 0;

        for (const [id, cart] of Object.entries(carrito)) {
          tabla += `<tr><td> ${cart.cantidad}</td><td id="${id}1"> ${cart.codigo}</td><td id="${id}3"> ${cart.producto}</td><td id="${id}4"> ${cart.precio}</td><td id="${id}5"> ${cart.total}</td><td> <button class="btn btn-danger"  onclick="eliminar(${id})">Eliminar</button><button class="btn btn-warning" onclick="editar('${cart.id}',${cart.cantidad},${cart.precio},'${cart.tipo}',${cart.stock},${cart.precioc},${cart.impuesto},'${cart.producto}','${cart.codigo}',${id},'${cart.deposito}','${cart.depositotext}')">Editar</button></td></tr>`;
          total += cart.total;
        }

        $("#tablaCarrito").html(tabla);
        $("#total").html(`Total: ${parseFloat(total).toFixed(2)}`);
      }
      var idr = "<?php echo $_GET['id_producto'] ?>";
      $.ajax({
        url: 'index.php?action=insumos',
        type: 'GET',
        data: {
          id: idr,
        },
        dataType: 'json',
        success: function (json) {
          for (var i = 0; i < json.length; i++) {
            console.log("222", json[i]);
            carrito.push({
              cantidad: json[i].cantidad,
              codigo: json[i].codigo,
              producto: json[i].nombre,
              //  producto: "s",

              precio: json[i].precio,
              total: json[i].total,
              id: json[i].insumo_id,
            })
          }
          actualizarTabla()

          $("#cantidadPl").val('0')
        },
        error: function (xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });
    </script>
    <?php
  } ?>
  <script>
    function buscar() {
      tablab = "";

      $.ajax({
        url: "index.php?action=buscarinsumos",
        type: "GET",
        data: {
          buscar: $('#buscarProducto').val(),
          sucursal: $("#sucursal_id").val(),
        },
        cache: false,
        success: function (dataResult) {
          var result = JSON.parse(dataResult);
          for (const [id, data_1] of Object.entries(result)) {
            if (data_1["producto"]['activo'] == 1) {
              tablab += `<tr>
        <td> ${data_1["producto"]['codigo']}</td>
        <td> ${data_1["producto"]['nombre']}</td>
    `;
              tablab += `   <td>
             <input value="0" type="number" id="b${data_1["producto"]["id_producto"]}" class="form-control">
             </td> <td><input value="0" type="number" id="a${data_1["producto"]["id_producto"]}" class="form-control"> <button 
                onclick="agregar(${data_1["producto"]["id_producto"]},'${data_1["producto"]['codigo']}',' ${data_1["producto"]['nombre']}',${parseInt(data_1["cantidad"])})" class="btn btn-info">Agregar</button></td>
        </tr>`;
            }
          }
          $("#tablaProductos").html(tablab);
        }
      });
    }

    function agregar(id, codigo, producto, cantidad) {
      if (carrito.some(item => item.id === id)) {
        Swal.fire({
          title: "Ya posee este producto agregado",
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
      } else {
        var precio = $('#b' + id).val();
        var cantidad = $('#a' + id).val();
        carrito.push({
          cantidad: cantidad,
          codigo: codigo,
          producto: producto,
          precio: precio,
          total: (cantidad * precio),
          id: id,
        })
        tablab = "";
        $('#buscarProducto').val("");
        $("#tablaProductos").html(tablab);
        actualizarTabla()
      }
    }

    function eliminar(ide) {
      carrito.splice(ide, 1);
      actualizarTabla()
    }
    var depE = 0
    var idE = 0

    function editar(idp, cant, pre, tipo, stock, precio, impuesto, producto, codigo, id, dep, deposito) {
      idE = idp;
      codE = codigo;
      impuE = impuesto
      stockE = stock;
      tipoe = tipo;
      precioE = precio
      proE = producto
      idElimina = id;
      depE = dep;
      depositoE = deposito;
      $("#canEdit").val(cant);
      $("#preEdit").val(pre);
      $('#editModal').modal({
        show: true
      });
    }

    function edita() {
      console.log(carrito)
      let idCarrito = carrito[idElimina].id;
      carrito[idElimina] = {
        cantidad: $(`#canEdit`).val(),
        codigo: codE,
        producto: proE,
        precio: $(`#preEdit`).val(),
        total: ($(`#canEdit`).val() * $(`#preEdit`).val()),
        id: idCarrito,
      }

      actualizarTabla()
      $('#editModal').modal("hide")

    }

    function dismiss() {
      $('#editModal').modal("hide");
    }

    function actualizarTabla() {
      tabla = "";
      total = 0;
      grabada10 = 0;
      grabada5 = 0;
      exenta = 0;
      iva10 = 0;
      iva5 = 0;

      for (const [id, cart] of Object.entries(carrito)) {
        tabla += `<tr><td> ${cart.cantidad}</td><td id="${id}1"> ${cart.codigo}</td><td id="${id}3"> ${cart.producto}</td><td id="${id}4"> ${cart.precio}</td><td id="${id}5"> ${cart.total}</td><td> <button class="btn btn-danger"  onclick="eliminar(${id})">Eliminar</button><button class="btn btn-warning" onclick="editar('${cart.id}',${cart.cantidad},${cart.precio},'${cart.tipo}',${cart.stock},${cart.precioc},${cart.impuesto},'${cart.producto}','${cart.codigo}',${id},'${cart.deposito}','${cart.depositotext}')">Editar</button></td></tr>`;
        total += parseFloat(cart.total);
      }

      $("#tablaCarrito").html(tabla);
      $("#total").html(`Total: ${parseFloat(total).toFixed(2)}`);
    }



    function accion() {
      //Obtener los valores de los campos del formulario
      let tipo_producto = $("#tipo_producto").val();
      let codigo = $("#codigo").val();
      let impuesto = $("#impuesto").val();
      let id_sucursal = $("#id_sucursal").val();
      let sucursal_id = $("#sucursal_id").val();
      let marca_id = $("#marca_id").val();
      let precio_venta = $("#precio_venta").val();
      let id_deposito = $("#id_deposito").val();
      let inventario_minimo = $("#inventario_minimo").val();
      let inventario_maximo = $("#inventario_maximo").val();
      let precio_compra = $("#precio_compra").val();
      let presentacion = $("#presentacion").val();
      let nombre = $("#nombre").val();
      let categoria_id = $("#categoria_id").val();
      let descripcion = $("#descripcion").val();

      //Realizar las validaciones correspondientes
      if (tipo_producto === "") {
        alert("Debe seleccionar un tipo de producto.");
        return false;
      }

      if (codigo === "") {
        alert("Debe ingresar un código válido");
        return false;
      }

      if (isNaN(impuesto) || impuesto < 0) {
        alert("Debe ingresar un valor numérico válido para el impuesto.");
        return false;
      }

      if (id_sucursal === "") {
        alert("Debe seleccionar una sucursal.");
        return false;
      }

      if (sucursal_id === "") {
        alert("Debe seleccionar una sucursal válida.");
        return false;
      }

      if (marca_id === "") {
        alert("Debe seleccionar una marca.");
        return false;
      }


      if (id_deposito === "") {
        alert("Debe seleccionar un depósito.");
        return false;
      }

      if (inventario_minimo == "") {
        alert("Debe ingresar un valor numérico válido para el inventario mínimo.");
        return false;
      }

      if (inventario_maximo == "") {
        alert("Debe ingresar un valor numérico válido para el inventario máximo.");
        return false;
      }

      if (precio_compra === "") {
        alert("Debe ingresar un precio de compra válido.");
        return false;
      }

      if (presentacion === "") {
        alert("Debe ingresar una presentación.");
        return false;
      }



      if (nombre === "") {
        alert("Debe ingresar un nombre válido.");
        return false;
      }

      if (categoria_id === "") {
        alert("Debe seleccionar una categoría.");
        return false;
      }
      if (descripcion === "") {
        alert("Debe ingresar una descripción.");
        return false;
      }
      // Obtener el archivo seleccionado
      const fileInput = document.getElementById("imagen");
      const file = fileInput.files[0];

      // Crear un objeto FormData
      const formData = new FormData();
      formData.append("imagen", file);

      // Agregar otros datos al objeto FormData
      formData.append("impuesto", $("#impuesto").val());
      formData.append("descripcion", $("#descripcion").val());
      formData.append("id_sucursal", <?php echo $_GET['id_sucursal'] ?>);
      formData.append("sucursal_id", <?php echo $_GET['id_sucursal'] ?>);
      formData.append("marca_id", $("#marca_id").val());
      formData.append("inventario_minimo", $("#inventario_minimo").val());
      formData.append("inventario_maximo", $("#inventario_maximo").val());
      formData.append("presentacion", $("#presentacion").val());
      formData.append("carrito", JSON.stringify(carrito));
      formData.append("nombre", $("#nombre").val());
      formData.append("categoria_id", $("#categoria_id").val());
      formData.append("estado", $("#estado").val());
      formData.append("id_producto", <?php echo $_GET['id_producto'] ?>);
      formData.append("tipo", $("#tipo_producto").val());
      formData.append("estado", $("#estado").val());
      formData.append("fecha_vencimiento", $("#fecha_vencimiento").val() ? $("#fecha_vencimiento").val() : null);
      formData.append("moneda", $("#moneda").val());
      formData.append("precio_venta", $("#precio_venta").val());
      formData.append("cliente_id", $("#cliente_id").val());
      formData.append("contrato_id", $("#contrato_id").val());
      formData.append("ncm", $("#ncm").val());
      formData.append("partida_arancelaria", $("#partida_arancelaria").val());
      formData.append("partida_arancelaria", $("#partida_arancelaria").val());
      formData.append("codigo_nivel_general", $("#codigo_nivel_general").val());
      formData.append("codigo_nivel_especifico", $("#codigo_nivel_especifico").val());
      formData.append("codigo_gtin_producto", $("#codigo_gtin_producto").val());
      formData.append("codigo_nivel_paquete", $("#codigo_nivel_paquete").val());
      formData.append("id_grupo", $("#id_grupo").val());
      // Enviar el objeto FormData a través de AJAX
      $.ajax({
        url: "index.php?action=actualiza_producto",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (dataResult) {
          // Manejar la respuesta del servidor
          if (dataResult == 1) {
            alert("Producto guardado con exito");
            window.location.reload();

          } else {
            alert("error al crear producto");
          }
        }
      });


    }
  </script>
<?php else: ?>
<?php endif; ?>