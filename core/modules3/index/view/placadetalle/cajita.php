  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
  <?php
    $u = null;
    $tipo = 0;
    if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
        $u = UserData::getById($_SESSION["admin_id"]);
        if ($u->is_empleado) :
            $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
    ?>
          <div class="content-wrapper">
              <section class="content-header">
                  <h1><i class='fa fa-gift' style="color: orange;"></i>
                      DETALLE DE PLACAS
                  </h1>
              </section>
              <section class="content">
                  <div class="row">
                      <div class="col-xs-12">
                          <div class="box">

                              <!-- <h2 class="text-center">Detalle de las placas:</h2>
                  <label for="inputEmail1" class="col-lg-2 control-label">N° placa Inicio:</label>
                  <div class="col-lg-2 ">
                    <input type="number" class="form-control" id="iniciop" placeholder="N Inicio:">

                  </div>
                  <label for="inputEmail1" class="col-lg-2 control-label">N° placa Fin:</label>
                  <div class="col-lg-2">
                    <input type="number" class="form-control" id="finp" placeholder="N Fin:">
                  </div> -->

                              <table class="table table-bordered table-hover">
                                  <thead>
                                      <th>Nro serie</th>

                                      <th>Nro Inicial</th>
                                      <th>Nro Final</th>
                                      <th>Cantidad</th>
                                  </thead>
                                  <tbody id="tbody">

                                  </tbody>
                              </table>
                              <h3 id="error" class="text-center "></h3>

                              <div class="form-group">
                                  <div class="col-lg-offset-2">
                                      <div class="checkbox">
                                          <label>
                                              <input type="hidden" name="sucursal_id" id="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
                                              <!-- <input type="hidden" value="<?php echo $q1; ?>" id="stock_trans" name="stock_trans" /> -->
                                              <br>

                                      </div>
                                      <br>
                                  </div>
                              </div>
                          </div>
                          <!-- </div> -->
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
                      </div>
                  </div>
              </div>
          </div>
          </div>
      <?php endif ?>
  <?php endif ?>
  <?php if (isset($_GET['id'])) { ?>
      <script type="text/javascript">
          var placas = [];

          var idr = "<?php echo $_GET['id'] ?>";
          $.ajax({
              url: 'index.php?action=obtenerplacas',
              type: 'GET',
              data: {
                  id: idr,
                  sucursal: "<?php $_GET['id_sucursal']; ?>"
              },
              dataType: 'json',
              success: function(json) {
                  console.log("222", json);
                  for (var i = 0; i < json.length; i++) {
                      placas.push({
                          ini: json[i].numero_placa_ini,
                          fin: json[i].numero_placa_fin,
                          cantidad: json[i].cantidad,
                          serie: json[i].registro_serie,
                      })
                  }

                  $("#cantidadPl").val('0')
                  actualizarTablaPlacas()
              },
              error: function(xhr, status) {
                  console.log("Ha ocurrido un error.");
              }
          });
      </script>
  <?php
    } ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
      var carrito = [];
      var total = 0;
      var grabada10 = 0;
      var grabada5 = 0;
      var exenta = 0;
      var iva10 = 0;
      var iva5 = 0;
      var idPro = 0;
      var id = "";
      var tablab = "";
      var diferencia = 0;
      var numeracion_final = 0;
      var serie1 = 0;
      var tipomoneda = 0;
      var id_configfactura = 0;
      var idtipomoneda = 0;
      const moneda_principal_global = $("#tipomoneda_id").val();
      let valor_configmasiva_global = $("#cantidaconfigmasiva").val();
      $("#paso2").hide();
      var tipoe = "";
      var tipocliente = 0;
      moneda();
      direccion();
      clienteTipo()

      function siguiente() {
          if ($("#configfactura_id").val()) {
              $("#paso2").show();

              $("#paso1").hide();
              console.log($('select[name="cliente_id"] option:selected').text())
              var isRemision = "";
              $("#cliente_select").html(`<h4> Cliente: ${$('select[name="cliente_id"] option:selected').text()} </h4> <h4> Moneda: ${$('select[name="tipomoneda_id"] option:selected').text()} </h4> <h4> tipo de venta: ${$('input[name="metodopago"]:checked').val()} </h4> <h4>  ${$('select[name="configfactura_id"] option:selected').text()} ${isRemision}</h4> `)
          }
          clienteTipo()
      }

      function agregarPlaca() {
          // var pl = $("#serie").val().split(',');
          var pl = JSON.parse($("#serie").val());
          placas.push({
              ini: pl[1],
              fin: pl[2],
              cantidad: $("#cantidadPl").val(),
              serie: pl[0]
          })
          $("#iniciop").val('');
          $("#finp").val('')
          $("#cantidadPl").val('0')
          actualizarTablaPlacas()
      }

      function eliminarplaca(id) {

          placas.splice(id, 1);
          actualizarTablaPlacas()
      }

      function actualizarTablaPlacas() {
          tabla = "";
          for (const [id, pago] of Object.entries(placas)) {
              tabla += `<tr><td> ${pago.serie}</td><td> ${pago.ini}</td><td> ${pago.fin}</td><td> ${pago.cantidad}</td> </tr>`;
          }
          $("#tbody").html(tabla);

      }

      function moneda() {
          if (moneda_principal_global == "US$") { //dolar
              $.ajax({
                  url: 'index.php?action=consultamoneda',
                  type: 'POST',
                  data: {
                      sucursal: <?= $_GET["id_sucursal"] ?>,
                      simbolo: moneda_principal_global, //simbolo
                      accion: "obtenerCambioPorSimbolo"
                  },
                  dataType: 'json',
                  success: function(json) {
                      $("#cambio").val(json[0].valor);
                      idtipomoneda = json[0].id_tipomoneda;
                      valor_dolar_global = json[0].valor;
                      ajaxConfigMasiva("₲");
                  },
                  error: function(xhr, status) {
                      console.log("Ha ocurrido un error.");
                  }
              });
          } else if (moneda_principal_global == "₲") { //guaranies
              $.ajax({
                  url: 'index.php?action=consultamoneda',
                  type: 'POST',
                  data: {
                      sucursal: <?= $_GET["id_sucursal"] ?>,
                      simbolo: moneda_principal_global, //simbolo
                      accion: "obtenerCambioPorSimbolo"
                  },
                  dataType: 'json',
                  success: function(json) {
                      valor_guaranies_global = json[0].valor;
                      idtipomoneda = json[0].id_tipomoneda;
                      $("#cambio").val(json[0].valor);
                      ajaxConfigMasiva("US$");
                  },
                  error: function(xhr, status) {
                      console.log("Ha ocurrido un error.");
                  }
              });
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
              tabla += `<tr><td hidden > ${cart.tipo}</td><td> ${cart.cantidad}</td><td> ${cart.cantidad}</td><td id="${id}1"> ${cart.codigo}</td><td id="${id}3"> ${cart.producto}</td><td id="${id}2"> ${cart.impuesto}</td><td > ${cart.iva}</td><td > ${cart.grabada}</td><td > ${cart.depositotext}</td><td> ${cart.precio}</td><td> ${cart.preciot}</td><td> <button class="btn btn-danger"  onclick="eliminar(${id})">Eliminar</button><button class="btn btn-warning" onclick="editar('${cart.id}',${cart.cantidad},${cart.precio},'${cart.tipo}',${cart.stock},${cart.precioc},${cart.impuesto},'${cart.producto}','${cart.codigo}',${id},'${cart.deposito}','${cart.depositotext}')">Editar</button></td></tr>`;
              if (cart.impuesto == 10) {
                  iva10 += parseFloat(cart.iva);
                  grabada10 += parseFloat(cart.grabada);
              } else if (cart.impuesto == 5) {
                  iva5 += parseFloat(cart.iva);
                  grabada5 += parseFloat(cart.grabada);
              }
              total += parseFloat(cart.preciot);
          }
          // grabada10 = grabada10.toFixed(2);
          // grabada5 = grabada5.toFixed(2);
          // iva10 = iva10.toFixed(2);
          // iva5 = iva5.toFixed(2);
          $("#tablaCarrito").html(tabla);
          $("#txtTotalVentas").val(parseFloat(total).toFixed(2));
          $("#total10").val(parseFloat(grabada10).toFixed(2));
          $("#total5").val(parseFloat(grabada5).toFixed(2));
          $("#iva5").val(parseFloat(iva5).toFixed(2));
          $("#iva10").val(parseFloat(iva10).toFixed(2));
      }

      function clienteTipo() {

      }

      function configFactura() {
          $.ajax({
              url: 'index.php?action=consultafactura',
              type: 'POST',
              data: {
                  confiFactura: Number(document.getElementById("configfactura_id").value)
              },
              dataType: 'json',
              success: function(json) {
                  document.getElementById('num1').value = json[0].numeroactual1;
                  document.getElementById('numinicio').value = json[0].numeracion_inicial;
                  numeracion_final = json[0].numeracion_final;
                  serie1 = json[0].serie1;
                  id_configfactura = json[0].id_configfactura;
                  diferencia = json[0].diferencia;
                  factura_no = numeracion_final - diferencia;
                  if (factura_no >= 1 && factura_no < 10) {
                      factura_no = "000000" + factura_no;
                  } else if (factura_no >= 10 && factura_no < 100) {
                      factura_no = "00000" + factura_no;
                  } else if (factura_no >= 100 && factura_no < 1000) {
                      factura_no = "0000" + factura_no;
                  } else if (factura_no >= 1000 && factura_no < 10000) {
                      factura_no = "000" + factura_no;
                  } else if (factura_no >= 10000 && factura_no < 100000) {
                      factura_no = "00" + factura_no;
                  } else if (factura_no >= 100000 && factura_no < 1000000) {
                      factura_no = "0" + factura_no;
                  }
                  $("#facturan").val(serie1 + '-' + factura_no);
              },
              error: function(xhr, status) {
                  console.log("Ha ocurrido un error.");
              }
          });

      }
      configFactura()

      function accion() {
          $("#accion").prop('disabled', true);
          setTimeout(function() {
              $.ajax({
                  url: "index.php?action=editaremision",
                  type: "POST",
                  data: {
                      id: <?php echo $_GET['id'] ?>,
                      placas: placas,
                      sucursal_id: $("#sucursal_id").val(),
                  },
                  success: function(dataResult) {

                      try {
                          if (dataResult == 1) {
                              Swal.fire({
                                  title: "Placas editadas",
                                  icon: 'Success',
                                  confirmButtonText: 'Aceptar'
                              });
                              window.location.href = "index.php?view=listadoplacas&id_sucursal=" + $("#sucursal_id").val();

                          } else {
                              Swal.fire({
                                  title: "Error al editar",
                                  icon: 'error',
                                  confirmButtonText: 'Aceptar'
                              });
                          }
                      } catch (e) {

                      }
                  }
              });

          }, 500);
          $("#accion").prop('disabled', false);
      }

      function Mostrar() {
          document.getElementById('mostrar').style.display = 'block';
          document.getElementById('ocultar').style.display = 'none';
      }
      Mostrar();
      var stockE = 0;
      tipocambio()
      var precioE = 0;
      var idE = 0;
      var impuE = 0;
      var proE = "";
      var codE = "";
      var depE = "";
      var depositoE = "";

      function eliminar(ide) {
          carrito.splice(ide, 1);
          actualizarTabla()
      }

      function dismiss() {
          $('#editModal').modal("hide");
      }

      function edita() {
          console.log("a", depE);
          agregaTabla(idE, codE,
              impuE, $(`#preEdit`).val(),
              proE, $(`#canEdit`).val(), tipoe, stockE, depositoE, depE, depositoE);
          eliminar(idElimina)
          $('#editModal').modal("hide");
      }
      var idElimina = 0;

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
          console.log("222aa", id)
          idElimina = id
          $("#canEdit").val(cant);
          $("#preEdit").val(pre);
          $('#editModal').modal({
              show: true
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


      function agregaTabla(id, codigo, impuesto, precio, producto, cant, tipo, stock, precioc, dep, deposito) {
          var iva = 0;
          var grabada = 0;
          var input = parseFloat(cant);
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
              cantidad: parseFloat(cant),
              codigo: codigo,
              impuesto: parseFloat(impuesto),
              iva: parseFloat(iva).toFixed(2),
              grabada: parseFloat(grabada).toFixed(2),
              precio: parseFloat(precio).toFixed(2),
              producto: producto,
              preciot: parseFloat(totalcart).toFixed(2),
              id: id,
              tipo: tipo,
              stock: parseFloat(stock).toFixed(2),
              precioc: parseFloat(precioE).toFixed(2),
              deposito: dep,
              depositotext: deposito
          })
          total += totalcart;
          console.log(carrito)
          actualizarTabla();
      }

      function buscar() {
          tablab = "";

          $.ajax({
              url: "index.php?action=buscarproducto",
              type: "GET",
              data: {
                  buscar: $('#buscarProducto').val(),
                  sucursal: $("#sucursal_id").val(),
                  tipocliente: tipocliente,
                  deposito: $("#deposito").val(),
                  moneda: idtipomoneda,
              },
              cache: false,
              success: function(dataResult) {
                  var result = JSON.parse(dataResult);
                  for (const [id, data_1] of Object.entries(result)) {
                      if (data_1["producto"]['activo'] == 1) {
                          tablab += `<tr>
        <td> ${data_1["producto"]['codigo']}</td>
        <td> ${data_1["producto"]['nombre']}</td>
        <td>${data_1['precio']} </td>
        <td>${data_1["cantidad"]}</td> 
    `;
                          if (true) {
                              tablab += `    <td><input value="0" max="${parseInt(data_1["cantidad"])}" type="number" id="a${data_1["producto"]["id_producto"]}" class="form-control"> <button 
                onclick="agregar(${data_1["producto"]["id_producto"]},'${data_1["producto"]['codigo']}','${data_1["producto"]['impuesto']}','${data_1["precio"]}',' ${data_1["producto"]['nombre']}','${data_1["tipo"]}',${parseInt(data_1["cantidad"])},${parseInt(data_1["producto"]["precio_compra"])})" class="btn btn-info">Agregar</button></td>
        </tr>`;
                          } else {
                              tablab += `    <td></td>
        </tr>`;
                          }
                      }
                  }
                  $("#tablaProductos").html(tablab);
              }
          });
      }

      function tipocambio() {
          moneda();
          ajaxConvertirValoresTotales($("#tipomoneda_id").val());

      }
      var ciudades = "";


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
              url: "index.php?action=buscarciudad",
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


      function direccion() {
          $.ajax({
              url: 'index.php?action=versucursal',
              type: 'GET',
              data: {
                  sucursal: $("#sucursal_id").val()
              },
              dataType: 'json',
              success: function(json) {

                  $("#dpt_id").val(json["cod_depart"]);

                  buscarCiudad(json["distrito_id"]);

              },
              error: function(xhr, status) {
                  console.log("Ha ocurrido un error.111");
              }
          });
      }
      direccion()

      function ajaxOperacionTotales(simbolo$) {

      }

      function ajaxConfigMasiva(simbolo$) {

      }

      function ajaxConvertirValoresTotales(moneda_seleccionada) {
          if (moneda_principal_global == "US$") { //dolar como moneda principal
              if (moneda_seleccionada == "₲") {
                  // ajaxOperacionTotales("₲");
                  ajaxConfigMasivaChange("₲", moneda_seleccionada)
              } else if (moneda_seleccionada == "US$") {
                  //ajaxOperacionTotales("US$");
                  ajaxConfigMasivaChange("₲", moneda_seleccionada)
              }
          } else if (moneda_principal_global == "₲") { //guaranies como moneda principal
              if (moneda_seleccionada == "US$") {
                  //ajaxOperacionTotales("US$");
                  ajaxConfigMasivaChange("US$", moneda_seleccionada)
              } else if (moneda_seleccionada == "₲") {
                  //ajaxOperacionTotales("₲");
                  ajaxConfigMasivaChange("₲", moneda_seleccionada)
              }
          }
      }


      function setearTipoCambioChange(simbolo$) {
          $.ajax({
              url: 'index.php?action=consultamoneda',
              type: 'POST',
              cache: false,

              data: {
                  sucursal: $("#sucursal_id").val(),
                  simbolo: simbolo$, //simbolo
                  accion: "obtenerCambioPorSimbolo"
              },
              dataType: 'json',
              success: function(json) {
                  const cambio_valor = json[0].valor;
                  idtipomoneda = json[0].id_tipomoneda;
                  simbolo = simbolo$;
                  $("#cambio").val(cambio_valor);
                  const valor_inical = json[0].id_tipomoneda;
                  $("#idtipomoneda").val(valor_inical);


              },
              error: function(xhr, status) {
                  console.log("Ha ocurrido un error.");
              }
          });
      }

      function ajaxConfigMasivaChange(simbolo$, moneda_seleccionada) {
          $.ajax({
              url: 'index.php?action=consultamoneda',
              type: 'POST',
              cache: false,

              data: {
                  sucursal: $("#sucursal_id").val(),
                  simbolo: simbolo$, //simbolo
                  accion: "obtenerCambioPorSimbolo"
              },
              dataType: 'json',
              success: function(json) {
                  const cambio_valor = json[0].valor;
                  if (moneda_principal_global == "US$") { //dolar como moneda principal
                      if (moneda_seleccionada == "₲") {
                          setearTipoCambioChange("₲");
                          $("#cantidaconfigmasiva").val(valor_configmasiva_global);
                      } else if (moneda_seleccionada == "US$") {
                          setearTipoCambioChange("US$");
                          $("#cantidaconfigmasiva").val(valor_configmasiva_global / cambio_valor);
                      }
                  } else if (moneda_principal_global == "₲") { //guaranies como moneda principal
                      if (moneda_seleccionada == "US$") {
                          setearTipoCambioChange("US$");
                          $("#cantidaconfigmasiva").val(valor_configmasiva_global / cambio_valor);
                      } else if (moneda_seleccionada == "₲") {
                          setearTipoCambioChange("₲");
                          $("#cantidaconfigmasiva").val(valor_configmasiva_global);
                      }
                  }
              },
              error: function(xhr, status) {
                  console.log("Ha ocurrido un error.");
              }
          });
      }
  </script>