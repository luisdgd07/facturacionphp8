<!-- Content Wrapper. Contains page content -->

<body id="cuerpoPagina">
</body>


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

    <form class="form-horizontal" role="form" method="post" hidden name="facturacion"
      action="index.php?action=agregarenvio" enctype="multipart/form-data">
      <input type="text" name="venta" id="venta" value="<?php echo $_GET['id_venta'] ?>">
      <input type="text" name="estado" id="estado" value="">
      <input type="text" name="cdc" id="cdc" value="">
      <input type="text" name="xml" id="xml" value="">
      <button type="submit">envio</button>
    </form>
    <h1><i class='fa fa-shopping-cart' style="color: orange;"></i>
      LISTADO DE PLACAS
      <!-- <marquee> Lista de Medicamentos</marquee> -->
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body">

            <?php
            $users = VentaData::versucursaltipoventasremi4($_GET['id_sucursal']);
            ?>
            <table id="example1" class="table table-bordered table-hover  ">
              <thead>
                <th>Remision</th>
                <th>Nro serie</th>
                <th>Nro Inicial</th>
                <th>Nro Final</th>
                <th>Cantidad</th>
                <th>Fecha</th>
                <th>Detalle</th>
              </thead>
              <?php
              foreach ($users as $sell) {
                $placas = PlacaDetalleData::obtener($sell->id_venta);

                ?>
                <tr>
                  <td class="width:30px;">
                    <?php if ($sell->tipo_venta == "4"): ?>     <?php echo $sell->factura; ?>
                    <?php else: ?>
                      <?php echo count($operations) ?>
                    <?php endif ?>
                  </td>
                  <td><?php if (isset($placas[0])) {
                    echo $placas[0]->registro_serie;
                  } ?></td>
                  <td><?php
                  if (isset($placas[0])) {
                    echo $placas[0]->numero_placa_ini;
                  } ?></td>
                  <td><?php
                  if (isset($placas[0])) {
                    echo $placas[0]->numero_placa_fin;
                  } ?></td>
                  <td><?php
                  if (isset($placas[0])) {
                    echo $placas[0]->cantidad;
                  } ?></td>
                  <td></td>
                  <td style="width:30px;">
                    <a href="index.php?view=placadetalle&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&id=<?php echo $sell->id_venta ?>"
                      class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"
                        style="color: orange;"></i></a>
                  </td>
                </tr>
                <?php
              } ?>
          </div>
          <!-- <div class="box-body">

            <?php $placas = PlacaData::listar3($_GET['id_sucursal']);
            if (count($placas) > 0) { ?>
              <table id="example1" class="table table-bordered table-hover  ">
                <thead>
                  <th>Remision</th>
                  <th>Nro serie</th>
                  <th>Nro Inicial</th>
                  <th>Nro Final</th>
                  <th>Cantidad</th>
                  <th>Fecha</th>
                  <th>Detalle</th>
                </thead>
                <?php foreach ($placas as $placa):
                  $venta = VentaData::getById($placa->id_venta);
                  ?>
                  <tr>
                    <td>
                      <?php echo $venta->factura ?> </td>
                    <td><?php echo $placa->serie_placa ?> </td>
                    <td><?php echo $placa->nro_ini ?> </td>

                    <td><?php echo $placa->nro_fin ?> </td>
                    <td><?php echo $placa->cantidad_total ?> </td>
                    <td><?php echo $venta->fecha ?> </td>
                    <td style="width:30px;">
                      <a href="index.php?view=placadetalle&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&id=<?php echo $placa->id_venta ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open" style="color: orange;"></i></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </table>
            <?php } ?>
          </div> -->
        </div>
      </div>
    </div>
  </section>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>