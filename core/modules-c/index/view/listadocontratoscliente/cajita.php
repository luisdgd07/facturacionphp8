<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

<?php
$sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
?>
<div class="content-wrapper" style="height: 100vh;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><i class='fa  fa-laptop' style="color: orange;"></i>
      LISTA DE CONTRATOS
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <!-- <div class="box-header with-border">
               <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-cart-plus"></i> Nuevo Producto</a>
            </div> -->
          <div class="box-body">
            <div class="table-responsive">
              <div class="col-md-4">
                <select name="cliente_id" onchange="buscar()" class="selectpicker show-menu-arrow" data-style="form-control" data-live-search="true" id="cliente_id" class="form-control">
                  <option value="">SELECCIONAR CLIENTE</option>
                  <option value="todos">Todos</option>
                  <?php
                  $clients = ClienteData::verclientessucursal($_GET['id_sucursal']);
                  foreach ($clients as $client) :
                    // $tipocliente = ProductoData::listar_tipo_precio($client->id_precio);
                  ?>

                    <?php
                    if ($client->id_cliente == $venta->cliente_id) { ?>
                      <option selected value="<?php echo $client->id_cliente; ?>"><?php echo $client->dni . " - " . $client->nombre . " " . $client->apellido . " - " . $client->tipo_doc; ?></option>
                    <?php
                    } else {
                    ?>
                      <option value="<?php echo $client->id_cliente; ?>"><?php echo $client->dni . " - " . $client->nombre . " " . $client->apellido . " - " . $client->tipo_doc; ?></option>
                  <?php }
                  endforeach;

                  ?>
                </select>

              </div>

              <div class="col-md-4">
                <select name="" onchange="buscar2()" class="form-control" id="contratos"></select>

              </div>

              <table id="example1" class="table table-bordered table-dark">
                <button onclick=" Excel()" class="btn btn-danger">pdf</button>
                <thead>
                  <tr>
                    <th>Codigo</th>
                    <th>Producto</th>
                    <th>Total</th>
                    <th>Saldo</th>

                  </tr>
                </thead>

                <tbody id="ventas-lista">
                  <!-- Aquí se cargarán las ventas mediante Ajax -->
                </tbody>
              </table>
              <h3 style="font-weight: 800;" id="total-contratos"></h3>
              <h3 style="font-weight: 800;" id="resta"></h3>
              <h3 style="font-weight: 800;" id="saldo"></h3>

              <canvas id="grafica"></canvas>

            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>

    <script>
      const labels = ['Saldo', 'Total', 'Pagado']

      const graph = document.querySelector("#grafica");

      const data = {
        labels: labels,
        datasets: [{
          label: "Totales",
          data: [1, 1],
          backgroundColor: ['#f2116c', '#69d2e7', '#fa6900']
        }]
      };

      const config = {
        type: 'bar',
        data: data,
      };

      let chart = new Chart(graph, config);
      var totalContratos = 0;
      var saldo = 0;

      function buscar() {
        // console.log($('#contratos').val());
        totalContratos = 0;
        saldo = 0;
        const graficaCanvas = document.querySelector("#grafica canvas"); // Seleccionar el canvas de la gráfica
        if (graficaCanvas) {
          graficaCanvas.style.height = '300px'; // Cambiar la altura del canvas
        }
        $.ajax({
          url: `index.php?action=clientecontratocliente&id=${$('#cliente_id').val()}&sucursal=<?php echo $_GET['id_sucursal'] ?>`,
          method: 'GET',
          dataType: 'json',
          cache: false,
          success: function(data) {
            // Recorrer el array de ventas y agregar cada fila a la tabla
            var fila = "";
            $("#grafica").show();

            $('#ventas-lista').html(fila);
            data.forEach(function(venta) {
              totalContratos += parseFloat(venta.precio_venta);
              saldo += parseFloat(venta.saldo);
              fila += '<tr>' +
                '<td>' + venta.codigo + '</td>' +
                '<td>' + venta.nombre + '</td>' +
                '<td>' + venta.precio_venta + '</td>' +
                '<td>' + venta.saldo + '</td>' +

                '</tr>';
              $('#ventas-lista').html(fila);
            });
            chart.data.datasets[0].data = [parseFloat(saldo), parseFloat(totalContratos), parseFloat(totalContratos) - parseFloat(saldo)];
            chart.update();
            listacontratos()
            $('#total-contratos').text('Total Cuotas: ' + parseFloat(totalContratos).toFixed(2)); // Formatear el total como decimal
            $('#saldo').text('Saldo: ' + parseFloat(saldo).toFixed(2)); // Formatear el saldo como decimal
            $('#resta').text('Total pagado: ' + (parseFloat(totalContratos) - parseFloat(saldo)).toFixed(2)); // Formatear el saldo como decimal
          },
          error: function() {
            alert('Error al obtener los datos de las ventas.');
          }
        })
      }

      $("#grafica").hide();

      function buscar2() {
        var con = $('#contratos').val();
        console.log();
        $.ajax({
          url: `/index.php?action=clientecontratoproductos&id=${$('#cliente_id').val()}&contrato=${$('#contratos').val()}`,
          method: 'GET',
          dataType: 'json',
          cache: false,
          success: function(data) {

            // Recorrer el array de ventas y agregar cada fila a la tabla
            var fila = "";
            $('#ventas-lista').html(fila);
            data.forEach(function(venta) {
              total += parseFloat(venta.precio_venta);

              fila += '<tr>' +
                '<td>' + venta.codigo + '</td>' +
                '<td>' + venta.nombre + '</td>' +
                '<td>' + venta.precio_venta + '</td>' +
                '<td>' + venta.saldo + '</td>' +
                '</tr>';
              $('#ventas-lista').html(fila);
            });


          },
          error: function() {

            alert('Error al obtener los datos de las ventas.');
          }
        });
      }



      function listacontratos() {


        select = "";
        $.ajax({
          url: `index.php?action=contratoporcliente&id=${$('#cliente_id ').val()}`,
          type: 'GET',
          data: {},
          dataType: 'json',
          success: function(json) {
            console.log(json)
            for (var i = 0; i < json.length; i++) {
              if (json[i]) {
                select += `<option value="${json[i].id}">${json[i].datos}</option> `

              }


            }
            $("#contratos").html(select);
          },
          error: function(xhr, status) {
            console.log("Ha ocurrido un error.");
          }
        });

      }

      function Excel() {
        window.open(`./excels/contratos2.php?cliente=${$('#cliente_id').val()}&sucursal=<?php echo $_GET['id_sucursal'] ?>`)
      }
    </script>
  </section>
</div>