<?php
$sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1><i class='fa fa-laptop' style="color: orange;"></i>
      REGISTRO DE PRODUCTO
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <!-- <div class="box-header with-border">
               <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Nuevo</a>
            </div> -->
          <div class="box-body">
            <div class="box box-warning">
              <div class="panel-body">
                <div class="form-horizontal">

                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-lg-2 control-label">Grupo:</label>
                    <div class="col-lg-10">
                      <?php
                      $categories = GrupoData::vergrupossucursal($sucursales->id_sucursal);
                      if (count($categories) > 0): ?>
                        <select name="id_grupo" id="id_grupo" required class="form-control">
                          <option value="">SELECCIONAR GRUPO</option>
                          <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat->id_grupo; ?>" style="color: orange;"><i
                                class="fa fa-gg"></i><?php echo $cat->nombre_grupo; ?></option>
                          <?php endforeach; ?>
                        </select>
                      <?php else:
                        echo 'Deber de crear una categoria';
                      endif; ?>
                    </div>
                  </div>


                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-lg-2 control-label">Imagen:</label>
                    <div class="col-lg-10">
                      <input type="file" name="imagen" class="form-control" id="imagen">
                      <span class="fa fa-image form-control-feedback"></span>
                    </div>
                  </div>


                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-lg-2 control-label">Codigo:</label>
                    <div class="col-lg-4">
                      <input type="text" name="codigo" class="form-control" id="codigo" required=""
                        placeholder="Codigo del Producto">
                      <span class="fa fa-barcode form-control-feedback"></span>
                    </div>
                    <label class="col-lg-2 control-label">Nombre:</label>
                    <div class="col-lg-4">
                      <input type="text" name="nombre" class="form-control" id="nombre"
                        placeholder="Nombre del Producto" maxlength="800" required="">
                      <span class="fa fa-laptop form-control-feedback"></span>
                    </div>
                  </div>

                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-lg-2 control-label">Categoria:</label>
                    <div class="col-lg-10">
                      <?php
                      $categories = CategoriaData::vercategoriassucursal($sucursales->id_sucursal);
                      if (count($categories) > 0): ?>
                        <select name="categoria_id" id="categoria_id" required class="form-control">
                          <option value="">SELECCIONAR CATEGORIA</option>
                          <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat->id_categoria; ?>" style="color: orange;"><i
                                class="fa fa-gg"></i><?php echo $cat->nombre; ?></option>
                          <?php endforeach; ?>
                        </select>
                      <?php else:
                        echo 'Deber de crear una categoria';
                      endif; ?>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-lg-2 control-label">Marca:</label>
                    <div class="col-lg-10">
                      <?php
                      $Marcas = MarcaData::vermarcasucursal($sucursales->id_sucursal);
                      if (count($Marcas) > 0): ?>
                        <select name="marca_id" id="marca_id" required class="form-control">
                          <option value="">SELECCIONAR MARCA</option>
                          <?php foreach ($Marcas as $marca): ?>
                            <option value="<?php echo $marca->id_marca; ?>" style="color: orange;"><i
                                class="fa fa-gg"></i><?php echo $marca->nombre; ?></option>
                          <?php endforeach; ?>
                        </select>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-lg-2 control-label">Tipo Producto:</label>
                    <div class="col-lg-10">
                      <?php
                      $Tipoprod = ProductoData::verPRODTIPOSUC($sucursales->id_sucursal);
                      if (count($Tipoprod) > 0): ?>
                        <select name="tipo_producto" id="tipo_producto" required class="form-control">
                          <option value="">SELECCIONAR TIPO</option>
                          <?php foreach ($Tipoprod as $Tipoprods): ?>
                            <option value="<?php echo $Tipoprods->TIPO_PRODUCTO; ?>" style="color: orange;"><i
                                class="fa fa-gg"></i><?php echo $Tipoprods->TIPO_PRODUCTO; ?></option>
                          <?php endforeach; ?>
                        </select>
                      <?php endif; ?>
                    </div>



                    <label class="col-lg-2 control-label">Depósito:</label>
                    <div class="col-lg-10">
                      <?php
                      $deposito = ProductoData::verdeposito($sucursales->id_sucursal);
                      if (count($deposito) > 0): ?>
                        <select name="id_deposito" id="id_deposito" required class="form-control">
                          <option value="">SELECCIONAR DEPOSITO</option>
                          <?php foreach ($deposito as $depositos): ?>
                            <option value="<?php echo $depositos->DEPOSITO_ID; ?>" style="color: orange;"><i
                                class="fa fa-gg"></i><?php echo $depositos->NOMBRE_DEPOSITO; ?></option>
                          <?php endforeach; ?>
                        </select>
                      <?php endif; ?>
                    </div>

                    <label class="col-lg-2 control-label">Presentación:</label>
                    <div class="col-lg-4">
                      <select class="form-control" name="presentacion" id="presentacion" required="">
                        <?php $unidades = UnidadesData::getAll();
                        if (count($unidades) > 0): ?>
                          <?php foreach ($unidades as $unidad): ?>
                            <option value="<?php echo $unidad->id; ?>" style="color: orange;"><i
                                class="fa fa-gg"></i><?php echo $unidad->nombre; ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                    </div>
                    <label class="col-lg-2 control-label">Descripción:</label>
                    <div class="col-lg-4">
                      <textarea name="descripcion" id="descripcion" class="form-control"
                        placeholder="Descripcion del Producto"></textarea>
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-feedback has-warning">
                    <label class="col-lg-2 control-label">Stock inicial:</label>
                    <div class="col-lg-4">
                      <input type="text" name="q" class="form-control" id="q" placeholder="Cantidad del Producto"
                        onkeypress="return solonumeross(event)">
                      <span class="fa fa-sort-amount-desc form-control-feedback"></span>
                    </div>
                    <label class="col-lg-2 control-label">Stock Mínimo:</label>
                    <div class="col-lg-4">
                      <input type="text" name="inventario_minimo" class="form-control" id="inventario_minimo"
                        onkeypress="return solonumeross(event);" placeholder="Stock minimo" maxlength="800">
                      <span class="fa fa-sort-amount-desc form-control-feedback"></span>
                    </div>

                    <label class="col-lg-2 control-label">Stock Máximo:</label>
                    <div class="col-lg-4">
                      <input type="text" name="inventario_maximo" class="form-control" id="inventario_maximo"
                        onkeypress="return solonumeross(event);" placeholder="Stock máximo" maxlength="800">
                      <span class="fa fa-sort-amount-desc form-control-feedback"></span>
                    </div>

                  </div>
                  <div class="form-group has-feedback has-warning">

                    <label class="col-lg-2 control-label">Precio Compra:</label>
                    <div class="col-lg-4">
                      <input type="text" name="precio_compra" class="form-control" id="precio_compra"
                        placeholder="Precio de Compra" maxlength="800">
                      <span class="fa fa-dollar form-control-feedback"></span>
                    </div>
                    <label class="col-lg-2 control-label" hidden>Precio Venta:</label>
                    <div class="col-lg-4" hidden>
                      <input type="text" value="0" name="precio_venta" id="precio_venta" class="form-control"
                        placeholder="Precio de Venta" oninput="operacion()" required="">
                      <span class="fa fa-dollar form-control-feedback"></span>
                    </div>

                    <!-- <div class="col-lg-1">
                           <i class="btn btn-success" onkeypress="return operacion(event)" oninput="operacion()">?</i>
                          </div> -->
                  </div>
                  <div class="form-group has-feedback has-warning">


                    <label for="inputEmail1" class="col-lg-2 control-label">% Ganancia:</label>
                    <div class="col-lg-4">
                      <input type="text" name="ganancia" id="resultado" disabled class="form-control">

                    </div>

                    <label for="inputEmail1" class="col-lg-2 control-label">Impuesto:</label>
                    <div class="col-lg-4">
                      <select class="form-control" name="impuesto" id="impuesto" required="">

                        <option value="10">10% Gravada</option>
                        <option value="5">5% Gravada</option>
                        <option value="0">0% Exenta</option>
                        <option value="30">5% Gravada y 0% Exenta</option>
                      </select>
                    </div>

                  </div>
                  <div class="form-group has-feedback has-warning">


                    <label for="inputEmail1" class="col-lg-2 control-label">NCM:</label>
                    <div class="col-lg-4">
                      <input type="text" name="ganancia" id="ncm" class="form-control">

                    </div>

                    <label for="inputEmail1" class="col-lg-2 control-label">Partida Arancelaria:</label>
                    <div class="col-lg-4">
                      <input type="text" name="ganancia" id="partida_arancelaria" class="form-control">
                    </div>

                  </div>
                  <div class="form-group has-feedback has-warning">


                    <label for="inputEmail1" class="col-lg-2 control-label">Codigo Nivel General:</label>
                    <div class="col-lg-4">
                      <input type="text" name="codigo_nivel_general" id="codigo_nivel_general" class="form-control">

                    </div>

                    <label for="inputEmail1" class="col-lg-2 control-label">CodigoNivelEspecifico:</label>
                    <div class="col-lg-4">
                      <input type="text" name="codigo_nivel_especifico" id="codigo_nivel_especifico"
                        class="form-control">
                    </div>

                  </div>
                  <div class="form-group has-feedback has-warning">


                    <label for="inputEmail1" class="col-lg-2 control-label">Codigo Gtin Producto:</label>
                    <div class="col-lg-4">
                      <input type="text" name="codigo_gtin_producto" id="codigo_gtin_producto" class="form-control">

                    </div>

                    <label for="inputEmail1" class="col-lg-2 control-label">Codigo Nivel Paquete:</label>
                    <div class="col-lg-4">
                      <input type="text" name="codigo_nivel_paquete" id="codigo_nivel_paquete" class="form-control">
                    </div>

                  </div>
                  <!-- <div class=" form-group has-feedback has-error">
                         <label for="inputEmail1" class="col-lg-2 control-label">Codigo Barra</label>
                         <div class="col-lg-10">
                           <svg id="barcoder"></svg>
                           <span class="fa fa-barcode fa fa-instirution form-control-feedback"></span>
                         </div>

                       </div> -->
                  <div class="box-header">
                    <i class="fa fa-laptop" style="color: orange;"></i> INGRESAR INSUMOS.
                    <input type="text" class="form-control" placeholder="Buscar" onchange="buscar()" onclick="buscar()"
                      id="buscarProducto">
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
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <input type="hidden" name="id_sucursal" id="id_sucursal"
                        value="<?php echo $sucursales->id_sucursal; ?>">
                      <input type="hidden" name="sucursal_id" id="sucursal_id"
                        value="<?php echo $sucursales->id_sucursal; ?>">
                      <button onclick="accion()" class="btn btn-block btn-warning"><i class="fa fa-save"></i></button>
                    </div>
                  </div>
                  <div class="" id="insumos">

                  </div>
                </div>
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
<script>
  var carrito = []

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

    carrito[idElimina] = {
      cantidad: $(`#canEdit`).val(),
      codigo: codE,
      producto: proE,
      precio: $(`#preEdit`).val(),
      total: ($(`#canEdit`).val() * $(`#preEdit`).val()),
      id: idElimina,
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
      total += cart.total;
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
    let q = $("#q").val();
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

    if (isNaN(q)) {
      alert("Debe ingresar una cantidad válida.");
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

    if (id_grupo === "") {
      alert("Debe seleccionar un grupo.");
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
    if (q === "") {
      alert("Debe ingresar una cantidad valida");
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
    formData.append("tipo_producto", $("#tipo_producto").val());
    formData.append("codigo", $("#codigo").val());
    formData.append("impuesto", $("#impuesto").val());
    formData.append("id_sucursal", $("#id_sucursal").val());
    formData.append("sucursal_id", $("#id_sucursal").val());
    formData.append("marca_id", $("#marca_id").val());
    formData.append("q", $("#q").val());
    formData.append("precio_venta", $("#precio_venta").val());
    formData.append("id_deposito", $("#id_deposito").val());
    formData.append("inventario_minimo", $("#inventario_minimo").val());
    formData.append("inventario_maximo", $("#inventario_maximo").val());
    formData.append("precio_compra", $("#precio_compra").val());
    formData.append("presentacion", $("#presentacion").val());
    formData.append("carrito", JSON.stringify(carrito));
    formData.append("nombre", $("#nombre").val());
    formData.append("categoria_id", $("#categoria_id").val());
    formData.append("descripcion", $("#descripcion").val());
    formData.append("ncm", $("#ncm").val());
    formData.append("partida_arancelaria", $("#partida_arancelaria").val());
    formData.append("codigo_nivel_general", $("#codigo_nivel_general").val());
    formData.append("codigo_nivel_especifico", $("#codigo_nivel_especifico").val());
    formData.append("codigo_gtin_producto", $("#codigo_gtin_producto").val());
    formData.append("codigo_nivel_paquete", $("#codigo_nivel_paquete").val());
    formData.append("id_grupo", $("#id_grupo").val());
    // Enviar el objeto FormData a través de AJAX
    $.ajax({
      url: "index.php?action=nuevoproducto1",
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