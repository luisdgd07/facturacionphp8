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
        <section class="content-header">
          <h1><i class='fa fa-gift' style="color: orange;"></i>
            REALIZAR COMPRA
          </h1>
        </section>
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">

                  <div class="box box-warning">

                    <div class="box-header">

                      <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Proveedor:</label>
                        <div class="col-lg-3">
                          <?php
                          $clients = ProveedorData::verproveedorssucursal($_GET["id_sucursal"]);
                          ?>
                          <select id="cliente_id" class="form-control" required>
                            <?php foreach ($clients as $client) : ?>
                              <option value="<?php echo $client->id_cliente; ?>"><?php echo $client->nombre . " " . $client->apellido; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <label for="inputEmail1" class="col-lg-1 control-label">Fecha:</label>
                        <div class="col-lg-2">
                          <input type="date" name="fecha" class="form-control" id="fecha" value="<?php echo date("Y-m-d"); ?>">
                        </div>

                      </div>
                      <div class="form-group">
                        <label for="comprobante2" class="col-lg-2 control-label">N° Comprobante:</label>
                        <div class="col-lg-2">
                          <input type="text" name="comprobante2" minlength="15" class="form-control" placeholder="Numero de factura" id="comprobante2" required onpaste="return true" maxlength="15" oninput="verComprobante()">
                        </div>
                        <label for="timbrado2" class="col-lg-2 control-label">Timbrado:</label>
                        <div class="col-lg-2">
                          <input type="text" name="timbrado2" minlength="8" class="form-control" id="timbrado2" placeholder="Timbrado" required onpaste="return true" maxlength="8">
                        </div>
                        <div id=ocultar1>
                        </div>
                        <div id=mostrar1>
                          <label for="inputEmail1" class="col-lg-2 control-label">Codigo:</label>
                          <div class="col-lg-2">
                            <input type="text" name="codigo2" class="form-control" id="codigo2">
                          </div>
                        </div>

                      </div>
                      <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Tipo de Compra:</label>
                        <div class="col-lg-2">
                          <input type="radio" name="condicioncompra" value="Contado" checked onclick="Ocultar3();"> Contado
                          <input type="radio" name="condicioncompra" value="Credito" onclick="Mostrar3()"> Credito
                        </div>
                        <div id="mostrar">
                          <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">Cuotas</label>
                            <div class="col-lg-2">
                              <input type="number" name="cuotas" class="form-control" id="cuotas">
                            </div>
                            <label for="inputEmail1" class="col-lg-2 control-label">Plazo</label>
                            <div class="col-lg-2">
                              <input type="number" id="vencimiento" name="vencimiento" class="form-control" id="vencimiento">
                            </div>

                            <div class="col-lg-2">
                              <label for="inputEmail1" class="col-lg-3 control-label">Concepto</label>

                              <input type="text" name="concepto" class="form-control" id="concepto">
                            </div>
                          </div>
                        </div>
                        <div class="row" id="cobrardiv">
                          <div class="col-md-2">
                            <?php
                            $tipos = CajaTipo::vercajatipo2();


                            ?>
                            <select required="" onselect="tipo()" onchange="tipo()" name="tipopago_id" id="tipopago_id" id1="valor" class="form-control">
                              <!-- <option value="0">Seleccionar</option> -->
                              <?php foreach ($tipos as $tipo) :
                              ?>

                                <option value="<?php echo $tipo->nombre ?>"><?= $tipo->nombre ?></option>
                              <?php
                              endforeach; ?>
                            </select>

                          </div>
                        </div>
                        <div class="col-md-2">Moneda:</div>

                        <div class="col-md-2">
                          <div>
                            <?php
                            $monedas = MonedaData::cboObtenerValorPorSucursal($_GET['id_sucursal']);
                            $cambios = MonedaData::obtenerCambioMonedaPorSimbolo($_GET['id_sucursal'], "US$");
                            $cambio1 = $cambios[0]->valor2;

                            $cambios2 = MonedaData::obtenerCambioMonedaPorSimbolo($_GET['id_sucursal'], "₲");

                            $cambio2 = $cambios2[0]->valor2;

                            $cambio = $cambio2;

                            ?>
                            <select required="" name="tipomoneda_id2" id="tipomoneda_id2" id1="valor" class="form-control" oninput="tipocambio()">
                              <?php
                              $i = 0;
                              foreach ($monedas as $moneda) : ?>
                                <?php
                                $valocito = null;
                                $i++;
                                if ($i == 1) {
                                ?>
                                  <option selected value="<?php echo $moneda->id_tipomoneda; ?>"><?php echo $moneda->nombre . "-" . $moneda->simbolo; ?></option>
                                <?php } else {

                                ?>
                                  <option value="<?php echo $moneda->id_tipomoneda; ?>"><?php echo $moneda->nombre . "-" . $moneda->simbolo; ?></option>
                              <?php
                                }

                              endforeach; ?>
                            </select>
                          </div>

                        </div>
                        <label for="inputEmail1" class="col-lg-2 control-label">Cambio</label>
                        <div class="col-lg-2">
                          <input readonly="" type="text" class="form-control" name="cambio" id="cambio">

                          <?php
                          $cotizacion = CotizacionData::versucursalcotizacion($_GET["id_sucursal"]);

                          if (count($cotizacion) > 0) {

                            $valores = 0;
                            foreach ($cotizacion as $moneda) {
                              $mon = MonedaData::cboObtenerValorPorSucursal3($_GET["id_sucursal"]);
                              foreach ($mon as $mo) :
                                $nombre = $mo->nombre;
                                $fechacotiz = $mo->fecha_cotizacion;
                                $valores = $mo->valor2;
                                $simbolo2 = $mo->simbolo;

                              endforeach;
                            }
                          }
                          ?>

                          <input type="hidden" name="cambio2" id="cambio2" value="<?php echo $valores; ?>" class="form-control">
                          <input type="hidden" name="simbolo2" id="simbolo2" value="<?php echo $simbolo2; ?>" class="form-control">



                          <input type="hidden" name="idtipomoneda" id="idtipomoneda" class="form-control">
                        </div>
                      </div>


                    </div>
                    <div class="box-header">
                      <div class="col-md-6" style="    margin-top: 5px;"> <i class="fa fa-laptop" style="color: orange;"></i> INGRESAR PRODUCTOS.
                        <input type="text" class="form-control" placeholder="Buscar" onchange="buscar()" onclick="buscar()" id="buscarProducto">
                      </div>
                      <div class="col-md-6"> <label for="inputEmail1" class="control-label">Depósito:</label>
                        <div class="">
                          <?php
                          $deposito = ProductoData::verdeposito($_GET['id_sucursal']);
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

                  <table class="table table-bordered table-hover">
                    <thead>
                      <th>Cantidad</th>
                      <th>Codigo</th>

                      <th>Producto</th>

                      <th>Deposito</th>
                      <th class="precios">Precio</th>
                      <th>Accion</th>
                    </thead>
                    <tbody id="tablaCarrito">

                    </tbody>
                  </table>
                  <br>
                  <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                      <table class="table table-bordered">
                        <tr>
                          <td>
                            <p>Gravada 10%</p>
                          </td>
                          <td>
                            <p><b> <input type="text" class="form-control" id="total10" name="grabada102" readonly=""></b></p>
                          </td>
                          <td>
                            <p>IVA 10%</p>
                          </td>
                          <td>
                            <p><b> <input type="text" class="form-control" id="iva10" value="<?php echo ($totaliva10); ?>" readonly=""></b></p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Gravada 5%</p>
                          </td>
                          <td>
                            <p><b> <input type="text" class="form-control" id="total5" name="grabada52" readonly=""></b></p>
                          </td>
                          <td>
                            <p>IVA 5%</p>
                          </td>
                          <td>
                            <p><b> <input type="text" class="form-control" id="iva5" name="iva52" readonly=""></b></p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Exenta</p>
                          </td>
                          <td>
                            <p><b> <input type="text" class="form-control" id="exenta" name="excenta2" readonly=""></b></p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Total</p>
                          </td>
                          <td>
                            <p><b> <input type="text" class="form-control" id="txtTotalVentas" name="money" readonly=""></b></p>
                          </td>
                        </tr>

                      </table>
                      <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                          <div class="checkbox">
                            <label>
                              <input name="is_oficiall" type="hidden" value="1">
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                          <div class="checkbox">
                            <label>
                              <input type="hidden" name="sucursal_id" id="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
                              <input type="hidden" value="<?php echo $q1; ?>" id="stock_trans" name="stock_trans" />
                              <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                              <button class="btn btn-lg btn-warning" onclick="accion()"><i class="fa fa-refresh"></i> Finalizar Compra</button>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

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
    var pagos = [];
    tipocambio()

    function transferencia() {
      if ($("#accion_id").val() == 3) {
        $("#transferencia").show();
      } else {
        $("#transferencia").hide();
      }
      if ($("#accion_id").val() == 1) {
        $(".precios").show();

      } else {
        $(".precios").hide();

      }
    }
    var validaComprobante = true;

    function verComprobante() {

      $.ajax({
        url: `index.php?action=validarfacturacompra&comprobante2=${$("#comprobante2").val()}&id_sucursal=<?php echo $_GET['id_sucursal'] ?>`,
        type: "get",
        data: {},
        cache: false,
        success: function(dataResult) {

          if (JSON.parse(dataResult).length > 0) {
            validaComprobante = true;
            return;
          } else {
            validaComprobante = false;
          }
        }
      });
    }

    function accion() {
      if (validaComprobante == true) {
        Swal.fire({
          title: "Comprobante duplicado ",
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
        url: "index.php?action=procesoajustestock1",
        type: "POST",
        data: {
          carrito,
          formapago2: $("#formapago2").val(),
          comprobante2: $("#comprobante2").val(),
          timbrado2: $("#timbrado2").val(),
          codigo2: $("#codigo2").val(),
          fecha2: $("#fecha2").val(),
          condicioncompra: $('input[name="condicioncompra"]:checked').val(),
          cambio: $("#cambio").val(),
          cambio2: $("#cambio2").val(),
          grabada102: parseFloat(grabada10),
          iva102: parseFloat($("#iva10").val()),
          grabada52: parseFloat(grabada5),
          iva52: parseFloat($("#iva5").val()),
          excenta2: parseFloat($("#exenta").val()),
          total: total,
          idtipomoneda: $("#tipomoneda_id2").val(),
          fecha: $("#fecha").val(),
          id_sucursal: <?php echo $_GET['id_sucursal'] ?>,
          cliente_id: $("#cliente_id").val(),
          cuotas: $("#cuotas").val(),
          tipopago_id: $("#tipopago_id").val(),
          concepto: $("#concepto").val(),
          vencimiento: $("#vencimiento").val()
        },
        cache: false,
        success: function(dataResult) {
          if (dataResult) {
            Swal.fire({
              title: "Transacción exitosa",
              icon: 'success',
              confirmButtonText: 'Aceptar'
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.reload()
              }
            });

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
        agregaTabla(id, codigo, impuesto, precioc, producto, $('#a' + id).val(), tipo, stock, precioc, $("#id_deposito").val(), $('select[name="id_deposito"] option:selected').text());
        tablab = "";
        $('#buscarProducto').val("");
        $("#tablaProductos").html(tablab);
      }
    }

    function eliminar(ide) {
      carrito.splice(ide, 1);
      actualizarTabla()
      actualizarPrecio()
    }

    function cambiarCant(id) {
      carrito[id].q = $(`#cant${id}`).val();
      actualizarPrecio()

    }

    function cambiarPre(id) {
      carrito[id].precio = $(`#prec${id}`).val();
      actualizarPrecio()
    }

    function actualizarPrecio() {
      tabla = "";
      total = 0;
      grabada10 = 0;
      grabada5 = 0;
      exenta = 0;
      iva10 = 0;
      iva5 = 0;

      for (const [id, cart] of Object.entries(carrito)) {
        if (cart.impuesto == 30 || cart.impuesto == "Iva 30 Exenta 70") {
          var prec = (parseFloat(cart.q) * parseFloat(cart.precio));
          iva += (prec * 0.3);
          exenta += (prec / 101.5 * 70);
          iva += (parseFloat(carrito.q) * parseFloat(cart.precio) / 101.5) * 1.5;
          grabada += (parseFloat(cart.q) * parseFloat(cart.precio) / 101.5) * 30;

        } else {
          var impu = parseInt(cart.impuesto);
          console.log(impu)

          if (impu == 10) {
            iva10 += (parseFloat(cart.q) * parseFloat(cart.precio)) / 11;
            grabada10 += (parseFloat(cart.q) * parseFloat(cart.precio)) / 1.1;
            console.log((parseFloat(cart.q) * parseFloat(cart.precio)) / 1.1)
          } else if (impu == 5) {
            console.log(parseFloat(cart.q) * parseFloat(cart.precio))
            iva5 += (parseFloat(cart.q) * parseFloat(cart.precio)) / 21;
            grabada5 += (parseFloat(cart.q) * parseFloat(cart.precio)) / 1.05;
          }

        }
        total += parseFloat(cart.precio * cart.q);
      }

      $("#txtTotalVentas").val(parseFloat(total).toFixed(2));
      if ($("#tipomoneda_id").val() == "US$") {
        $("#cobror").html(parseFloat(total * $("#cambio2").val()).toLocaleString("es-ES"));
        totalACobrar = parseFloat(total * $("#cambio2").val())
      } else {

        $("#cobror").html(parseFloat(total).toLocaleString("es-ES"));
        totalACobrar = parseFloat(total)

      }
      $("#total10").val(parseFloat(grabada10).toFixed(2));
      $("#total5").val(parseFloat(grabada5).toFixed(2));
      $("#iva5").val(parseFloat(iva5).toFixed(2));
      $("#iva10").val(parseFloat(iva10).toFixed(2));
      $("#exenta").val(parseFloat(exenta).toFixed(2));
      if ($('select[name="tipomoneda_id"] option:selected').text().includes("US$")) {
        $("#monto").val(parseFloat(total));
      } else {
        $("#monto").val(parseFloat(total));
      }
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
        tabla += `<tr><td hidden > ${cart.tipo}</td><td> 
        <input type="number" style="width: 250px;" oninput="cambiarCant(${id})"  id="cant${id}" value="${cart.q}"></input>
      </td><td id="${id}1"> ${cart.codigo}</td><td id="${id}3"> ${cart.producto}</td><td > ${cart.depositotext}</td><td><input type="number" style="width: 250px;" oninput="cambiarPre(${id})" class="precios" id="prec${id}" value="${cart.precio}"></input></td></td><td> <button class="btn btn-danger"  onclick="eliminar(${id})">Eliminar</button></td></tr>`;
        if (cart.impuesto == 10) {
          iva10 += parseFloat(cart.iva);
          grabada10 += parseFloat(cart.grabada);
        } else if (cart.impuesto == 5) {
          iva5 += parseFloat(cart.iva);
          exenta += parseFloat(cart.exenta);
          grabada5 += parseFloat(cart.grabada);
        }
        total += parseFloat(cart.precio * cart.q);
      }

      $("#tablaCarrito").html(tabla);
      $("#txtTotalVentas").val(parseFloat(total).toFixed(2));
      if ($("#tipomoneda_id").val() == "US$") {
        $("#cobror").html(parseFloat(total * $("#cambio2").val()).toLocaleString("es-ES"));
        totalACobrar = parseFloat(total * $("#cambio2").val())
      } else {

        $("#cobror").html(parseFloat(total).toLocaleString("es-ES"));
        totalACobrar = parseFloat(total)

      }
      $("#total10").val(parseFloat(grabada10).toFixed(2));
      $("#total5").val(parseFloat(grabada5).toFixed(2));
      $("#iva5").val(parseFloat(iva5).toFixed(2));
      $("#iva10").val(parseFloat(iva10).toFixed(2));
      $("#exenta").val(parseFloat(exenta).toFixed(2));
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
            if (data_1.tipo != 'Servicio') {
              if (data_1["producto"]['activo'] == 1) {
                tablab += `<tr>
                <td>${data_1.producto.codigo}</td>
                <td>${data_1.producto.nombre}</td>
                <td>${data_1.cantidad}</td> 
                <td>${data_1.deposito}</td>
                <td><input value="0" type="number" id="a${data_1.producto.id_producto}" class="form-control">
                <button onclick="agregar(${data_1.producto.id_producto},'${data_1.producto.codigo}','${data_1.producto.impuesto}','${data_1.precio}',' ${data_1.producto.nombre}','${data_1.tipo}',${parseInt(data_1.cantidad)},${parseInt(data_1.producto.precio_compra)})" class="btn btn-info">Agregar</button>
                </td>`;
              }
            }

          }
          $("#tablaProductos").html(tablab);
        }
      });
    }

    function Ocultar3() {
      document.getElementById('mostrar').style.display = 'none';
      document.getElementById('cobrardiv').style.display = 'block';
      document.getElementById('ocultar').style.display = 'block';
      $("#cuotas").val(0);
      $("#vencimiento").val(0);
    }
    Ocultar3();


    // function agregaTabla(id, codigo, impuesto, precio, producto, cant, tipo, stock, precioc, dep, deposito) {
    //   var iva = 0;
    //   var grabada = 0;
    //   var input = parseFloat(cant);
    //   console.log(id + " " + codigo + " " + impuesto + " " + precio + " " + producto + " " + cant + " " + tipo + " " + stock + " " + precioc)
    //   var impu = parseInt(impuesto);
    //   if (impu == 10) {
    //     iva = (input * parseFloat(precio)) / 11;
    //     grabada = (input * parseFloat(precio)) / 1.1;
    //   } else if (impu == 5) {
    //     iva = (input * parseFloat(precio)) / 21;
    //     grabada = (input * parseFloat(precio)) / 1.05;
    //   }
    //   var totalcart = input * parseFloat(precio);
    //   carrito.push({
    //     q: parseFloat(cant),
    //     codigo: codigo,
    //     producto: producto,
    //     impuesto: parseFloat(impuesto),
    //     producto_id: id,
    //     tipo: tipo,
    //     deposito: $("#id_deposito").val(),
    //     stock: parseFloat(stock).toFixed(2),
    //     depositotext: $('select[name="id_deposito"] option:selected').text(),
    //     observacion: '',
    //     precio: precioc
    //   })
    //   total += totalcart;
    //   console.log('cart', carrito)
    //   actualizarTabla();
    // }
    function agregaTabla(id, codigo, impuesto, precio, producto, cant, tipo, stock, precioc, dep, deposito) {
      var iva = 0;
      var grabada = 0;
      var input = parseFloat(cant);
      console.log(id + " " + codigo + " " + impuesto + " " + precio + " " + producto + " " + cant + " " + tipo + " " + stock + " " + precioc)

      var totalcart = input * parseFloat(precio);
      if (impuesto == 30 || impuesto == "Iva 30 Exenta 70") {
        var prec = (input * parseFloat(precio));
        iva = (prec * 0.3);
        exenta = (prec / 101.5 * 70);
        iva = (input * parseFloat(precio) / 101.5) * 1.5;
        grabada = (input * parseFloat(precio) / 101.5) * 30;

        carrito.push({
          q: parseFloat(cant),
          codigo: codigo,
          impuesto: "Iva 30 Exenta 70",
          iva: parseFloat(iva).toFixed(4),
          grabada: parseFloat(grabada).toFixed(4),
          precio: parseFloat(precio).toFixed(4),
          producto: producto,
          preciot: parseFloat(totalcart).toFixed(4),
          id: id,
          tipo: tipo,
          stock: parseFloat(stock).toFixed(2),
          precioc: parseFloat(precioE).toFixed(4),
          deposito: dep,
          depositotext: deposito,
          exenta: exenta
        })
      } else {
        var impu = parseInt(impuesto);
        if (impu == 10) {

          iva = (input * parseFloat(precio)) / 11;
          grabada = (input * parseFloat(precio)) / 1.1;
        } else if (impu == 5) {
          iva = (input * parseFloat(precio)) / 21;
          grabada = (input * parseFloat(precio)) / 1.05;
        }
        carrito.push({
          q: parseFloat(cant),
          codigo: codigo,
          impuesto: parseFloat(impuesto),
          iva: parseFloat(iva).toFixed(4),
          grabada: parseFloat(grabada).toFixed(4),
          precio: parseFloat(precio).toFixed(4),
          producto: producto,
          preciot: parseFloat(totalcart).toFixed(4),
          id: id,
          tipo: tipo,
          stock: parseFloat(stock).toFixed(2),
          precioc: parseFloat(precioE).toFixed(4),
          deposito: dep,
          depositotext: deposito
        })
      }
      total += totalcart;
      console.log('cart', carrito)
      actualizarTabla();
    }


    function tipocambio() {
      $.ajax({
        url: 'index.php?action=consultamonedaid',
        type: 'POST',
        cache: false,

        data: {
          sucursal: $("#sucursal_id").val(),
          id: $("#tipomoneda_id2").val(),
        },
        dataType: 'json',
        success: function(json) {
          $("#cambio").val(json.valor);
        },
        error: function(xhr, status) {
          console.log("Ha ocurrido un error.");
        }
      });
    }



    function Mostrar3() {
      document.getElementById('cobrardiv').style.display = 'none';
      document.getElementById('mostrar').style.display = 'block';
      $("#cuotas").val(1);
      $("#vencimiento").val(30);
    }
  </script>