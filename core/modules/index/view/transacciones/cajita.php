  <?php
  $u = null;
  if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
    $u = UserData::getById($_SESSION["admin_id"]);
  ?>
    <?php if ($u->is_empleado) : ?>

      <?php
      $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
      ?>
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1><i class='fa fa-gift' style="color: orange;"></i>
            MOVIMIENTO DE STOCK (ENTRADA/SALIDA)
          </h1>
        </section>
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">

                  <div class="box box-warning">
                    <div class="box-header">

                    </div>
                    <div class="box-header">

                      <div class="col-md-6" style="    margin-top: 5px;"> <i class="fa fa-laptop" style="color: orange;"></i> INGRESAR PRODUCTOS.
                        <input type="text" class="form-control" placeholder="Buscar" onchange="buscar()" onclick="buscar()" id="buscarProducto">
                      </div>
                      <div class="col-md-6"> <label for="inputEmail1" class="control-label">Depósito:</label>
                        <div class="">
                          <?php
                          $deposito = ProductoData::verdeposito($sucursales->id_sucursal);
                          if (count($deposito) > 0) : ?>
                            <select name="id_deposito" onchange="buscar()" id="id_deposito" required class="form-control">

                              <?php foreach ($deposito as $depositos) : ?>
                                <option value="<?php echo $depositos->DEPOSITO_ID; ?>" style="color: orange;"><i class="fa fa-gg"></i><?php echo $depositos->NOMBRE_DEPOSITO; ?></option>
                              <?php endforeach; ?>
                            </select>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>

                    <table class="table table-bordered table-hover">
                      <thead>
                        <th>Codigo</th>
                        <th>Producto</th>
                        <th>Stock</th>

                        <th>Deposito</th>
                        <th>Cantidad</th>
                      </thead>
                      <tbody id="tablaProductos">
                      </tbody>
                    </table>
                  </div>
                  <h2 class="text-center">Detalle de la operación:</h2>
                  <div class="form-group">


                    <label for="inputEmail1" class="col-lg-2 control-label">Tipo Transacción:</label>
                    <div class="col-lg-2">
                      <?php
                      $acciones = AccionData::VerAccion();
                      if (count($acciones) > 0) {
                      ?>
                        <select onclick="transferencia()" class="form-control" name="accion_id" id="accion_id">
                          <?php foreach ($acciones as $accion) : ?>
                            <option value="<?php echo $accion->id_accion ?>"><?php echo $accion->nombre; ?></option>
                          <?php endforeach ?>
                        </select>
                      <?php } ?>
                    </div>




                    <div class="" id="transferencia">


                      <label for="inputEmail1" class="col-lg-2 control-label">al Depósito:</label>
                      <div class="col-lg-2">
                        <?php
                        $deposito = ProductoData::verdeposito($sucursales->id_sucursal);
                        if (count($deposito) > 0) : ?>
                          <select name="id_deposito2" id="id_deposito2" required class="form-control">

                            <?php foreach ($deposito as $depositos) : ?>
                              <option value="<?php echo $depositos->DEPOSITO_ID; ?>" style="color: orange;"><i class="fa fa-gg"></i><?php echo $depositos->NOMBRE_DEPOSITO; ?></option>
                            <?php endforeach; ?>
                          </select>
                        <?php endif; ?>
                      </div>
                    </div>



                    <label for="inputEmail1" class="col-lg-2 control-label">Motivo:</label>
                    <div class="col-lg-2">
                      <select name="motivo" id="motivo" required class="form-control">

                        <option value="Produccion" selected>Produccion </option>
                        <option value="Control">Control de stock</option>
                        <option value="Remision">Ingreso por remision</option>


                      </select>
                    </div>

                    <label for="inputEmail1" class="col-lg-2 control-label">Fecha:</label>
                    <div class="col-lg-2">
                      <input type="date" name="sd" id="sd" class="form-control">
                    </div>

                  </div>
                  <table class="table table-bordered table-hover">
                    <thead>
                      <th>Cantidad</th>
                      <th>Codigo</th>

                      <th>Producto</th>

                      <th>Deposito</th>
                      <th>Observación</th>
                      <th>Accion</th>
                    </thead>
                    <tbody id="tablaCarrito">

                    </tbody>
                  </table>
                  <br>
                  <button style="margin-left: 45%" class="btn btn-success" onclick="accion()">Registrar transaccion </button>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    <?php endif ?>
  <?php endif ?>
  <script>
    var carrito = [];
    var precioE = 0;
    var total = 0;

    function transferencia() {
      if ($("#accion_id").val() == 3) {
        $("#transferencia").show();
      } else {
        $("#transferencia").hide();
      }
    }
    transferencia()

    function accion() {
      if ($("#motivo").val() == null) {
        Swal.fire({
          title: "Seleccione motivo ",
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
        return;
      }
      if (carrito.length == 0) {
        Swal.fire({
          title: "Agregue productos ",
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
        return;
      }
      $.ajax({
        url: "index.php?action=procesartransaccion",
        type: "POST",
        data: {
          carrito,
          id_sucursal: <?php echo $_GET['id_sucursal'] ?>,
          accion_id: $("#accion_id").val(),
          sd: $("#sd").val(),
          stock_trans: 0,
          motivo: $("#motivo").val(),
          observacion: '',
          id_deposito: $("#id_deposito").val(),
          id_depositopro: $("#id_deposito").val(),
          id_deposito2: $("#id_deposito2").val(),
          precio_comp: 0
        },
        cache: false,
        success: function(dataResult) {
          if (dataResult == 1) {
            Swal.fire({
              title: "Transacción exitosa",
              icon: 'success',
              confirmButtonText: 'Aceptar'
            });
            window.location.href = "index.php?view=transacciones&id_sucursal=<?php echo $_GET['id_sucursal'] ?> ";
            return;
          } else {
            Swal.fire({
              title: "Error al hacer transacción",
              icon: 'error',
              confirmButtonText: 'Aceptar'
            });
            return;
          }
        }
      });
    }

    function agregar(id, codigo, impuesto, precio, producto, tipo, stock, precioc) {
      if (carrito.some(item => item.id === id)) {

      } else {
        console.log($('#a' + id).val());
        agregaTabla(id, codigo, impuesto, precio, producto, $('#a' + id).val(), tipo, stock, precioc, $("#deposito").val(), $('select[name="deposito"] option:selected').text());
        tablab = "";
        $('#buscarProducto').val("");
        $("#tablaProductos").html(tablab);
      }
    }

    function eliminar(ide) {
      carrito.splice(ide, 1);
      actualizarTabla()
    }

    function cambiarob(id) {
      carrito[id].observacion = $(`#ob${id}`).val();
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
        tabla += `<tr><td hidden > ${cart.tipo}</td><td> ${cart.q}</td><td id="${id}1"> ${cart.codigo}</td><td id="${id}3"> ${cart.producto}</td><td > ${cart.depositotext}</td><td > <textarea type="text" style="width: 250px;" oninput="cambiarob(${id})" id="ob${id}" value="${cart.observacion}"></textarea></td><td> <button class="btn btn-danger"  onclick="eliminar(${id})">Eliminar</button></td></tr>`;
        if (cart.impuesto == 10) {
          iva10 += parseFloat(cart.iva);
          grabada10 += parseFloat(cart.grabada);
        } else if (cart.impuesto == 5) {
          iva5 += parseFloat(cart.iva);
          grabada5 += parseFloat(cart.grabada);
        }
        console.log('sss', total);
        total += parseFloat(cart.preciot);
      }
      // grabada10 = grabada10.toFixed(4);
      // grabada5 = grabada5.toFixed(4);
      // iva10 = iva10.toFixed(4);
      // iva5 = iva5.toFixed(4);
      $("#tablaCarrito").html(tabla);
      $("#txtTotalVentas").val(parseFloat(total).toFixed(2));
      if ($("#tipomoneda_id").val() == "US$") {
        $("#cobror").html(parseFloat(total * $("#cambio2").val()).toLocaleString("es-ES"));
        totalACobrar = parseFloat(total * $("#cambio2").val())
        // US$
      } else {

        $("#cobror").html(parseFloat(total).toLocaleString("es-ES"));
        totalACobrar = parseFloat(total)

      }
      $("#total10").val(parseFloat(grabada10).toFixed(2));
      $("#total5").val(parseFloat(grabada5).toFixed(2));
      $("#iva5").val(parseFloat(iva5).toFixed(2));
      $("#iva10").val(parseFloat(iva10).toFixed(2));
      if ($('select[name="tipomoneda_id"] option:selected').text().includes("US$")) {
        $("#monto").val(parseFloat(total));
      } else {
        $("#monto").val(parseFloat(total));
      }
    }

    function buscar() {
      tablab = "";

      $.ajax({
        url: "index.php?action=buscarproductotransa",
        type: "GET",
        data: {
          buscar: $('#buscarProducto').val(),
          sucursal: <?php echo $_GET['id_sucursal'] ?>,
          deposito: $("#id_deposito").val(),

        },
        cache: false,
        success: function(dataResult) {
          var result = JSON.parse(dataResult);
          for (const [id, data_1] of Object.entries(result)) {
            if (data_1["producto"]['activo'] == 1) {
              tablab += `<tr>
        <td> ${data_1["producto"]['codigo']}</td>
        <td> ${data_1["producto"]['nombre']}</td>
        <td>${data_1["cantidad"]}</td> 
        <td>${data_1['deposito']} </td>

    `;
              if (data_1['tipo'] != 'Servicio') {
                tablab += `    <td><input value="0" max="${parseInt(data_1["cantidad"])}" type="number" id="a${data_1["producto"]["id_producto"]}" class="form-control"> <button 
                onclick="agregar(${data_1["producto"]["id_producto"]},'${data_1["producto"]['codigo']}','${data_1["producto"]['impuesto']}','${data_1["precio"]}',' ${data_1["producto"]['nombre']}','${data_1["tipo"]}',${parseInt(data_1["cantidad"])},${parseInt(data_1["producto"]["precio_compra"])})" class="btn btn-info">Agregar</button></td>
        </tr>`;
              } else if (
                data_1['tipo'] == 'Servicio') {} else {
                tablab += `    <td></td>
        </tr>`;
              }
            }
          }
          $("#tablaProductos").html(tablab);
        }
      });
    }

    function agregaTabla(id, codigo, impuesto, precio, producto, cant, tipo, stock, precioc, dep, deposito) {
      var iva = 0;
      var grabada = 0;
      var input = parseFloat(cant);
      console.log(id + " " + codigo + " " + impuesto + " " + precio + " " + producto + " " + cant + " " + tipo + " " + stock + " " + precioc)
      var impu = parseInt(impuesto);
      if (impu == 10) {
        iva = (input * parseFloat(precio)) / 11;
        grabada = (input * parseFloat(precio)) / 1.1;
      } else if (impu == 5) {
        iva = (input * parseFloat(precio)) / 21;
        grabada = (input * parseFloat(precio)) / 1.05;
      }
      var totalcart = input * parseFloat(precio);
      carrito.push({
        q: parseFloat(cant),
        codigo: codigo,
        producto: producto,
        producto_id: id,
        tipo: tipo,
        deposito: $("#id_deposito").val(),
        stock: parseFloat(stock).toFixed(2),
        depositotext: $('select[name="id_deposito"] option:selected').text(),
        observacion: ''
      })
      total += totalcart;
      console.log('cart', carrito)
      actualizarTabla();
    }
  </script>
  <script type="text/javascript">
    function obtenerFechaActual() {
      n = new Date();
      y = n.getFullYear();
      m = n.getMonth() + 1;
      d = n.getDate();
      return y + "-" + (m > 9 ? m : "0" + m) + "-" + (d > 9 ? d : "0" + d)
    }

    //inicializar las fechas del reporte
    $("#sd").val(obtenerFechaActual());
    $("#ed").val(obtenerFechaActual());
  </script>