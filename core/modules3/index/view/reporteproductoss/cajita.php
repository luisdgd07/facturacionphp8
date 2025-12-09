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
        <h1> <i class="fa fa-cubes"></i>
          Reporte de productos
          <small> </small>
        </h1>
      </section>
      <section class="content">
        <div class="box">
          <div class="box-body">
            <div class="panel-body">
              <input type="hidden" name="view" value="reporteproductoss">
              <div class="row">

                <div class="col-md-3">



                  <select name="product" id="categoria" onchange=" getcategoria()" class="form-control">


                    <option value="todos" "z>Todos las categorias</option>
                    <?php $products = CategoriaData::vercategoriassucursal($_GET['id_sucursal']);
                    if (count($products) > 0) {
                      foreach ($products as $p) : ?>
                        <option value=" <?php echo $p->id_categoria; ?>"><?php echo $p->nombre ?></option>
                <?php endforeach;
                    } ?>

                  </select>
                </div>
                <div class="col-md-3">



                  <select name="product" id="products" class="form-control">

                  </select>
                </div>

                <!-- <div class="col-md-3">



                    <select required="" name="categoria" class="form-control">

                      <option value="todos">Todas la categorias</option>
                      <?php $clientes = CategoriaData::vercategoriassucursal($sucursales->id_sucursal);
                      if (count($clientes) > 0) {
                        foreach ($clientes as $p) : ?>
                          <option value="<?php echo $p->id_categoria; ?>"><?php echo $p->nombre; ?></option>
                      <?php endforeach;
                      } ?>
                    </select>
                  </div> -->





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

                <div class="col-md-3">
                  <input type="submit" class="btn btn-success btn-block" onclick="ver()" value="Procesar">
                  <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">

                </div>
              </div>

              <br>


              <input type="hidden" name="factura" id="num1">
              <input type="hidden" name="numeracion_inicial" id="numinicio">
              <input type="hidden" name="numeracion_final" id="numfin">
              <input type="hidden" name="serie1" id="serie">



              <div class="col-md-12">


                <?php if (isset($_GET['categoria'])) { ?>
                  <table id="example1" class="table table-bordered table-hover table-responsive ">
                    <thead>
                      <th style="width: 50px !important;">CODIGO</th>
                      <th style="width: 50px;">PRODUCTO</th>
                      <th style="width: 50px;">STOCK</th>
                      <th style="width: 50px;">PRESENTACION</th>

                      <th style="width: 50px;">CATEGORIA</th>

                      <th style="width: 50px;">DEPOSITO</th>
                    </thead>
                    <?php
                    $operationData = "";
                    if ($_GET['categoria'] == 'todos') {

                      $operationData = ProductoData::verproductosucursal($_GET['id_sucursal']);
                    } else if ($_GET['producto'] == 'todos') {
                      $operationData = ProductoData::verproductoscate($_GET['categoria']);
                    } else {
                      $operationData = ProductoData::getProducto2($_GET['producto']);
                    }
                    foreach ($operationData as $op) {
                      $stocks2 = StockData::vercontenidos($op->id_producto);
                    ?>

                      <tr>
                        <td><?php echo $op->codigo ?> </td>

                        <td><?php echo $op->nombre ?></td>
                        <td><?php
                            $stock = StockData::vercontenidos2($op->id_producto);
                            echo $stock->CANTIDAD_STOCK;
                            ?></td>
                        <td><?php
                            echo UnidadesData::getById($product->presentacion)->nombre;
                            ?></td>









                        <?php $concepto = ProductoData::categorian($op->categoria_id); ?>
                        <?php

                        foreach ($concepto as $cambios) {
                          if ($cambios) {


                            $categ = $cambios->nombre;
                          }
                        }

                        ?>

                        <td><?php echo $categ ?></td>










                        <?php $concepto = ProductoData::deposito($stock->DEPOSITO_ID); ?>
                        <?php

                        foreach ($concepto as $cambios) {
                          if ($cambios) {


                            $camnbio = $cambios->NOMBRE_DEPOSITO;
                          }
                        }

                        ?>


                        <td><?php echo $camnbio; ?></td>


                      </tr>
                    <?php } ?>




                  </table>
                  <br>
                  <hr>


                  <div class="row">
                    <div class="col-lg-2">


                      <!-- <h3>Total: <?php echo  number_format($total, 2, ',', ' '); ?></h3> -->



                    </div>


                  </div>




                  <div class="row">



                  </div>
                  <div class="form-group">

                  <?php } ?>

                  </div>
                <?php else :
                // si no hay operaciones
                ?>
                  <script>
                    $("#wellcome").hide();
                  </script>
                  <div class="jumbotron">
                    <h2>No hay registro de productos</h2>
                    <p>El rango de fechas seleccionado no proporciono ningun resultado.</p>
                  </div>

                <?php endif; ?>
              <?php else : ?>
                <script>
                  $("#wellcome").hide();
                </script>
                <div class="jumbotron">
                  <h2>Fecha Incorrectas</h2>
                  <p>Puede ser que no selecciono un rango de fechas, o el rango seleccionado es incorrecto.</p>
                </div>
              </div>









            </div>
          </div>
        </div>

      </section>
    </div>


  <?php endif ?>
  <script>
    function ver() {
      window.location.href = `index.php?view=reporteproductoss&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&categoria=${$('#categoria').val()}&producto=${$('#products').val()}`
    }

    function getcategoria() {
      // getAllByCategoriaId(
      console.log('22');
      $.ajax({

        url: "index.php?action=vercategorias",
        type: "GET",
        data: {
          categoria: $('#categoria').val(),
          sucursal: <?php echo $_GET['id_sucursal'] ?>
        },

        success: function(json) {
          // `<option value="todos">Todos los productos</option>`
          json = JSON.parse(json);
          try {
            var select = `<option value="todos">Todos los productos</option>`;

            for (var i = 0; i < json.length; i++) {
              console.log(json[i]);
              select += `<option value="${json[i].id_producto}">${json[i].nombre}</option> `
            }
            $("#products").html(select);
          } catch (e) {
            console.log(e)
            // Swal.fire({

          }

        },

      })
    }
    console.log('213123')
    getcategoria()
  </script>